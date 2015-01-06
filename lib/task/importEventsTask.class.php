<?php

class importEventsTask extends sfBaseTask {
  protected function configure()
  {
    $this->addArguments(array());

    $this->addOptions(array (
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'))
     );

    $this->namespace = 'import';
    $this->name = 'events';
    $this->briefDescription = 'Import facebook events for companies';
    $this->detailedDescription = <<<EOF

  [php symfony import:events]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    //date_default_timezone_set('Europe/Bucharest');

    /*
     * IMPORTANT -> Set Pacific Time Zone (USA/Canada) - Posted from Facebook
     */
    date_default_timezone_set('America/Los_Angeles');

    $timeEurope = new DateTimeZone('Europe/Bucharest');

    $connection = new sfDatabaseManager($this->configuration);
    $connection = $connection->getDatabase($options['connection'] ? $options['connection'] : null)
      ->getConnection();

    $this->createContext();

    $query = Doctrine::getTable('Company')->createQuery('c')
      ->where('c.country_id IN (1, 2)')
      ->andWhere('c.facebook_id IS NOT NULL');

//    $token = "CAACEdEose0cBAHZAoZCLNRZCy4LmNMSbipG2jPJZAp8gRyHzrybOdcwPGJM4M1cVZChT6Ai5DZBfqeDGIflKHsfBbYLJoTBMEakD2abdJma4EeOVZAKANVUqHvCwmlh9Mo154qRtirjHZATxaMv6NC9dJsZAqZBfyCkyFNzFpfOpvYbzZBDupDZC8V6YKqmhT1JnuK9GZCyPo6O6ZBswZDZD";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); # required for https urls

    $token = $this->getAppToken();
    if (!$token)
    {
      return;
    }

    $imported = 0;

    foreach($query->execute() as $company) {
      $culture = getlokalPartner::getDefaultCulture($company->getCountryId());
      sfContext::getInstance()->getUser()->setCulture($culture);
      $url = sprintf('https://graph.facebook.com/%s/events?fields=picture.type(large),description,name,start_time,end_time,timezone&limit=5000&since=%s&access_token=%s',
        $company->getFacebookId(),
        time(),
        $token);
      curl_setopt($ch, CURLOPT_URL, $url);

      $data = json_decode(curl_exec($ch ), true );
      $category_id = $company->getClassification()->getCategory()->getId();
 	    if (!$category_id) {
 	      $category_id = 1;
 	    }

      if (isset($data['data']) && is_array($data['data']) && sizeof($data['data']))
      {
      	foreach ($data['data'] as $event_data) {
      		if(!isset($event_data['name']) || !isset($event_data['description'])){
      			continue;
      		}
      		$query = Doctrine::getTable('Event')->createQuery('e')
            ->where('e.facebook_id = ?', $event_data['id'])
            ->count();
          if ($query)
          {
            continue;
          }

          $start = DateTime::createFromFormat('Y-m-d\TH:i:sO', $event_data['start_time']);

          if($start == false){
            $start = DateTime::createFromFormat('Y-m-d', $event_data['start_time']);
          }

          if(isset($event_data['end_time'])){
            $end = DateTime::createFromFormat('Y-m-d\TH:i:sO', $event_data['end_time']);
          }
          else{
             $end = $start;
          }

          /*
           * IMPORTANT -> Set the Date to Time zone Europe/Bucharest
           */
          $start->setTimezone($timeEurope);
          $end->setTimezone($timeEurope);

          $event = new Event();
          $event->setTitle($event_data['name']);
          $event->setDescription($event_data['description']);
          $event->setStartAt($start->format("Y-m-d H:i:s"));
          $event->setStartH($start->format('H:i:s'));
          $event->setEndAt($end->format("Y-m-d H:i:s"));
          $event->setEndH($end->format('H:i:s'));
          $event->setCountryId($company->getCountryId());
          $event->setLocationId($company->getCityId());
          $event->setFacebookId($event_data['id']);

          if ($company->getCountryId() == 2)
          {
            $user_id = 33705;
          }
          else
          {
            $user_id = 66832;
          }

          $event->setCategoryId($category_id);
          $event->setUserId($user_id);
          if (isset($event_data['picture']['data'])) {
            $image_data = $event_data['picture']['data'];

            $temp_pic = sfConfig::get('sf_upload_dir') . '/' . uniqid('tmp_') . '.jpg';
            file_put_contents($temp_pic, file_get_contents($image_data['url']));

            $file = new sfValidatedFile(myTools::cleanUrl($event_data['name']) . '.jpg', filetype($temp_pic), $temp_pic, filesize($temp_pic));

            $image = new Image();
            $image->setFile($file);
            $image->setUserId($user_id);
            $image->setCaption($event_data['name']);
            $image->setType('event');
            $image->setStatus('approved');
            $image->setCountryId($company->getCountryId());
            $image->save();

            $event->setImageId($image->getId());
            @unlink($temp_pic);
          }

          $event->save();
          
          
          $q = Doctrine_Query::create()
                ->delete('EventTranslation et')
                 ->where('et.title IS NULL OR et.title=?', '')
                 ->andWhere('et.description IS NULL OR description =?', '');
          $q->execute();
          
          

          $event_place = new EventPage();
          $event_place->setEventId($event->getId());
          $event_place->setPageId($company->getCompanyPage()->getId());
          $event_place->save();

          $imported++;
        }
      }
    }

    echo $imported." imported events".PHP_EOL;

    $this->updateFacebookIds();
  }

  protected function getAppToken()
  {
    $tokenUrl = sprintf('https://graph.facebook.com/oauth/access_token?client_id=%s&client_secret=%s&grant_type=client_credentials',
      sfConfig::get('app_facebook_id'),
      sfConfig::get('app_facebook_secret'));
    try
    {
      $token = file_get_contents($tokenUrl);
      $token = explode('=', $token, 2);
      if (count($token) == 2) {
        return $token[1];
      }
    }
    catch (Exception $e)
    {
    }
    return false;
  }

  protected function updateFacebookIds()
  {
    $con = Doctrine::getConnectionByTableName('company');
    $con->execute("UPDATE company SET facebook_id = REPLACE(facebook_url, 'http://www.facebook.com/', '') WHERE facebook_url LIKE 'http://www.facebook.com/%'");
    $con->execute("UPDATE company SET facebook_id = REPLACE(facebook_url, 'https://www.facebook.com/', '') WHERE facebook_url LIKE 'https://www.facebook.com/%'");
  }

  protected function createContext()
    {
      sfContext::createInstance($this->configuration);
    }

}
