<?php

class CityrepeatMacedoniaTask extends sfBaseTask
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

    $this->namespace        = 'cityrepeat';
    $this->name             = 'Macedonia';
    $this->briefDescription = 'goes trough new cities created in MK and redirect users and companies to ones we have';
    $this->detailedDescription = <<<EOF
The [cityrepeatMacedonia|INFO] task does things.
Call it with:

  [php symfony repeatcityMacedonia|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    $connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );
    
    echo 'Fix repeat city - Bulgaria'.PHP_EOL;
    
    $wrongs = Doctrine_Query::create()
      ->select('c.id, c.lat, c.lng, ct.name')
      ->from('City c')
      ->innerJoin('c.Translation ct')
      ->innerJoin('c.County co')
      ->where('co.country_id = 3 AND co.id != ?', 71)
      //->where('co.country_id = 3 AND c.id =  58779')
      ->groupBy('c.id')
      ->setHydrationMode(Doctrine::HYDRATE_SCALAR)
      ->execute();

    $skipped = 0;
    $done = 0;
    
    foreach ($wrongs as $w) {
        $res = null;
        $latlng = urlencode($w['c_lat'].','.$w['c_lng']);
        $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $latlng . "&sensor=false&language=mk";

        $data = array();
        $geocode = json_decode (file_get_contents($url), true );

        if ($geocode['status'] != 'OK') {
            $skipped++;
            echo "SKIPPED   ".$w['c_id'].PHP_EOL;
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

        $results = $geocode['results'];
        foreach ($results as $r) {
            if (array_intersect(array('locality'), $r['types'])) {
                $res = $r['address_components'];
                break;
            }
            if (array_intersect(array('route'), $r['types'])) {
                $res = $r['address_components'];
                foreach ($res as $re) {
                    if (array_intersect(array('locality'), $r['types'])) {
                        break;
                    }
                }                
            }
        }

        $components = $res;        
        $data = array();

        if (!$res) {
            $address = urlencode($w['ct_name'].',Macedonia (FYROM)');
            $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=mk";
      
            $geocode = json_decode (file_get_contents($url), true );
      
            if ($geocode['status'] != 'OK') {
                $skipped++;
                echo "SKIPPED   ".$w['c_id'].PHP_EOL;
                continue;
            }
      
            $results = $geocode['results'][0];          
            $components = $results['address_components'];
            $data = array();          
        }
        foreach ($components as $c) {
                foreach ($_types as $field => $types) {
                    if (array_intersect($types, $c['types'])) {
                        $data[$field] = $c['long_name'];
                    }
                }
            }

        if (!isset($data['city'])) {
            $data['city'] = $data['county'];              
        }
          
        $city = Doctrine::getTable('City')
                ->createQuery('c')
                ->innerJoin('c.Translation ct')
                ->innerJoin('c.County co')
                ->where('co.country_id = ?', 3)
                ->andWhere('co.id = ?', 71)
                ->andWhere("? LIKE CONCAT('%', ct.name, '%')", $data['city'])
                ->fetchOne();
          
        $county = Doctrine::getTable('County')->findOneById(71);

        if (!$city) {
            $address = urlencode($data['city'].',Macedonia (FYROM)');
            $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=en";
      
            $geocode = json_decode (file_get_contents($url), true );
      
            if ($geocode['status'] != 'OK') {
                $skipped++;
                echo "SKIPPED   ".$w['c_id'].PHP_EOL;
                continue;
            }
      
            $results = $geocode['results'][0];          
            $components = $results['address_components'];
            $data = array();          
        
            foreach ($components as $c) {
                foreach ($_types as $field => $types) {
                    if (array_intersect($types, $c['types'])) {
                        $data[$field] = $c['long_name'];
                    }
                }
            }
            
            $data_en = array(
    	            'latitude' => $results['geometry']['location']['lat'],
    	            'longitude' => $results['geometry']['location']['lng']
    	    );
            
            $city_name = $data['city'];
            $latitude = $data_en['latitude'];
    	    $longitude = $data_en['longitude'];

            if (isset($latitude) && isset($longitude)) {
                $city = new City();
    	        $city->setCounty($county);
    	        $city->setLat($latitude);
    	        $city->setLng($longitude);
    	        $city->setSlug(CityTable::slugify($city_name));
    	        $city->save();
    	        echo "NEW ";
    	        $con = Doctrine::getConnectionByTableName('city_translation');
    	        $con->execute('INSERT INTO `city_translation`(`id`, `name`, `lang`) VALUES ("'.$city->getId().'", "'.$city_name.'", "en");');
            }
            else {
                $skipped++;
                echo "SKIPPED   NO LAT-LNG".$w['c_id'].PHP_EOL;
                continue;
            }
        }
        
        if ($city) {            
            echo 'UPDATED   '.$w['c_id'].' --> '.$city->getId().PHP_EOL;
            $con = Doctrine::getConnectionByTableName('user_profile');
            $con->execute("UPDATE `user_profile` SET city_id='".$city->getId()."' WHERE city_id='".$w['c_id']."';");
            $con = Doctrine::getConnectionByTableName('company ');
            $con->execute("UPDATE `company` SET city_id='".$city->getId()."' WHERE city_id='".$w['c_id']."';");
            $con = Doctrine::getConnectionByTableName('city');
            $con->execute("DELETE FROM `city` WHERE id=".$w['c_id'].";");

            $done++;
        }
        
        sleep(3);        
    }
    
    echo $skipped.' Skipped'.PHP_EOL;
    echo $done.' Updated'.PHP_EOL;
    
  }
}
