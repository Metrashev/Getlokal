<?php

class geocodeCityPortugalTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'geocode';
    $this->name             = 'CityPortugal';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [geocodeCityPortugal|INFO] task does things.
Call it with:

  [php symfony geocodeCityPortugal|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    $connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );

    echo PHP_EOL."Geocode cities Portugal".PHP_EOL;

    $cities = Doctrine::getTable('City')
            ->createQuery('c')
            ->innerJoin('c.Translation ct')
            ->innerJoin('c.County co')
            //->where('c.lat IS NULL OR c.lat = ?', '')
            ->andWhere('co.country_id = ?', 180)
            //->andWhere('ct.lang = ?', 'pt')
            ->execute();
    
    if ($cities) {
        echo $cities->count().' cities without lat and lng found'.PHP_EOL;
    }
    else {
        echo 'No cities without lat and lng found'.PHP_EOL;
    }
    
    $skipped = 0;
    $done = 0;
            
    foreach ($cities as $city) {
        $address = urlencode($city->getLocation('pt').', Portugal');
        $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=pt";
      
        $geocode = json_decode (file_get_contents($url), true );
      
        if ($geocode['status'] != 'OK') {
            sleep(2);
            $geocode = json_decode (file_get_contents($url), true );
      
            if ($geocode['status'] != 'OK') {
                $skipped++;
                echo "SKIPPED   ".$city->getId()."  -> no geocode".PHP_EOL;
                continue;
            }
        }
        
        $result = $geocode['results'][0];
        $data = array(
    	            'latitude' => $result['geometry']['location']['lat'],
    	            'longitude' => $result['geometry']['location']['lng']
    	    );
        
        $city->setLat($data['latitude']);
        $city->setLng($data['longitude']);
        $city->save();

        $done++;
        sleep(1);
    }
    
    echo 'Done '.$done.PHP_EOL;
    echo 'Skipped '.$skipped.PHP_EOL;
    echo 'FINISHED '.PHP_EOL;
            
  }
}
