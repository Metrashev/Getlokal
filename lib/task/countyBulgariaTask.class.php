<?php

class CountyBulgariaTask extends sfBaseTask
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

    $this->namespace        = 'county';
    $this->name             = 'Bulgaria';
    $this->briefDescription = 'changes the names of the counties in Bulgaria (Bulgarian and English names are changed from geocode)';
    $this->detailedDescription = <<<EOF
The [doCountyBG|INFO] task does things.
Call it with:

  [php symfony doCountyBG|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
      $databaseManager = new sfDatabaseManager ( $this->configuration );
      $connection = $databaseManager->getDatabase ( $options ['connection'] ? $options ['connection'] : null )->getConnection ();
      $connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );
      
      echo "County translation Bulgaria".PHP_EOL;
      
      $skipped = 0;
      
      $wrongs = Doctrine_Query::create()
          ->select('co.id')
          ->from('County co')
          ->where('co.id > 40 AND co.id < 71')
          ->andWhere('co.country_id = 1')
    	  ->fetchArray();
    	
  foreach ($wrongs as $w) {
    	    $city = Doctrine_Query::create()
                ->select('c.lat as lat, c.lng as long, co.id as countyId, cp.id, count(cp.id) as cnt')
                ->from('City c')
                ->innerJoin('c.Company cp')
                ->innerJoin('c.County co')
                ->where('c.county_id = ?', $w['id'])
                ->groupBy('c.id')
                ->orderBy('count(cp.id) DESC')
                ->fetchOne();
          
    	    //$latlng = $city->getLat().','.$city->getLong();
            //$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $latlng . "&sensor=false&language=en";
    	    $address = urlencode($city->getLocation('en').',Bulgaria');
    	    $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=bg";
            
            $geocode = json_decode (file_get_contents($url), true );
             
            if ($geocode['status'] != 'OK') {
                $skipped++;
                fputcsv($file, array(iconv('UTF-8', 'UTF-8',$city->getCountyId())));
                continue;                 
            }
            
            $_types = array(
                    'city' => array('locality'),
                    'county' => array(
                            'administrative_area_level_1',
                            'administrative_area_level_2',
                            'administrative_area_level_3'
                    ),
                    'country' => array('country')
            );
            
            $results = $geocode['results'][0];
            $components = $results['address_components'];
             
            $data = array(
                    'latitude' => $results['geometry']['location']['lat'],
                    'longitude' => $results['geometry']['location']['lng']
            );
             
            foreach ($components as $c) {
                foreach ($_types as $field => $types) {
                    if (array_intersect($types, $c['types'])) {
                        $data[$field] = $c['long_name'];
                    }
                    if (in_array('country', $c['types'])) {
                        $data['language'] = strtolower($c['short_name']);
                    }
                }
            }
            $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=en";
            
            $geocode = json_decode (file_get_contents($url), true );
             
            if ($geocode['status'] != 'OK') {
                $skipped++;
                echo "SKIPPED  ".$city->getCountyId().PHP_EOL;
                continue;
            }
            
            $_types = array(
                    'city_en' => array('locality'),
                    'county_en' => array(
                            'administrative_area_level_1',
                            'administrative_area_level_2',
                            'administrative_area_level_3'
                    ),
                    'country_en' => array('country')
            );
            
            $results = $geocode['results'][0];
            $components = $results['address_components'];
                         
            foreach ($components as $c) {
                foreach ($_types as $field => $types) {
                    if (array_intersect($types, $c['types'])) {
                        $data[$field] = $c['long_name'];
                    }
                    if (in_array('country', $c['types'])) {
                        $data['language'] = strtolower($c['short_name']);
                    }
                }
            }
            
            $con = Doctrine::getConnectionByTableName('county_translation');
            $con->execute("UPDATE `county_translation` SET name='".mb_strtoupper($data['county'], 'utf-8')."' WHERE id='".$city->getCountyId()."' AND lang = 'bg';");
            $con->execute("UPDATE `county_translation` SET name='".strtoupper($data['county_en'])."' WHERE id='".$city->getCountyId()."' AND lang = 'en';");
            
            echo "UPDATED  ".$city->getCountyId().PHP_EOL;
    	}
    	
    	echo "SKIPPED   ".$skipped.PHP_EOL;
  }
}
