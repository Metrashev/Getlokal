<?php

class fixRepeatCityRomaniaTask extends sfBaseTask
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

    $this->namespace        = 'fix';
    $this->name             = 'RepeatCityRomania';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [RepeatCityRomania|INFO] task does things.
Call it with:

  [php symfony RepeatCityRomania|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
      $databaseManager = new sfDatabaseManager ( $this->configuration );
      $connection = $databaseManager->getDatabase ( $options ['connection'] ? $options ['connection'] : null )->getConnection ();
      $connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );

      echo 'Fix repeat city - ROMANIA'.PHP_EOL;
      
    	$skipped = 0;
    	$done = 0;

    	$wrongs = Doctrine_Query::create()
    	->select('c.id, c.lat, c.lng, co.id, ct.name')
    	->from('City c')
    	->innerJoin('c.Translation ct')
    	->innerJoin('c.County co')
    	->where('co.country_id = 2 AND co.id > ?', 295)
    	->andWhere('ct.lang = ?', 'en')
    	->setHydrationMode(Doctrine::HYDRATE_SCALAR)
    	->execute();
    	
      	foreach ($wrongs as $w) {
    	    $latlng = $w['c_lat'].','.$w['c_lng'];
    	    $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $latlng . "&sensor=false&language=en";
    	    $res = null;
    	    $geocode = json_decode (file_get_contents($url), true );
    	     
    	    if ($geocode['status'] != 'OK') {
    	        $skipped++;
    	        echo "SKIPPED   ".$w['c_id']."  -> no geocode".PHP_EOL;    	         
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
    	            $res = $r;
    	            break;
    	        }
    	    }
    	    
    	    $address = null;
    	    $adminAreaL1 = null;
    	    $adminAreaL2 = null;
    	    
    	    if (!isset($res)) {
    	        foreach ($results as $r) {
    	            // geocode for city, county, country, lat, lng 
    	            $_types = array(
    	                    'city' => array('locality'),
    	                    'county' => array(
    	                            'administrative_area_level_1',
    	                            'administrative_area_level_2',
    	                            'administrative_area_level_3'
    	                    ),
    	                    'country' => array('country')
    	            );
    	            
    	            $components = $r['address_components'];
    	            $data_en = array();
    	            
    	            foreach ($components as $c) {
    	                foreach ($_types as $field => $types) {
    	                    if (array_intersect($types, $c['types'])) {
    	                        $data_en[$field] = $c['long_name'];
    	                    }
    	                	    
    	                    if (in_array('country', $c['types'])) {
    	                        $data_en['language'] = strtolower($c['short_name']);
    	                    }
    	                }
    	            }
    	            
    	            if (isset($data_en['city']) && isset($data_en['country'])) {
    	                $address = urlencode($data_en['city'].','.$data_en['country']);
    	                break;
    	            }
    	        }
    	        
    	        
    	        if (!isset($res) && !isset($address)) {
    	            foreach ($results as $r) {
    	                // geocode for city, county, country, lat, lng 
    	                $_types2 = array(
    	                        'aa3' => array('administrative_area_level_3'),
    	                        'aa2' => array('administrative_area_level_2'),
    	                        'aa1' => array('administrative_area_level_1'),
    	                        'country' => array('country')
    	                );
    	                 
    	                $components = $r['address_components'];
    	                $data_en = array();
    	                 
    	                foreach ($components as $c) {
    	                    foreach ($_types2 as $field => $types) {
    	                        if (array_intersect($types, $c['types'])) {
    	                            $data_en[$field] = $c['long_name'];
    	                        }
    	                    }
    	                }
    	                 
    	                if (isset($data_en['aa3'])) {
    	                    $address = urlencode($data_en['aa3'].','.$data_en['country']);
    	                    break;
    	                }
    	                if (isset($data_en['aa2'])) {
    	                    $adminAreaL2 = urlencode($data_en['aa2'].','.$data_en['country']);
    	                    //break;
    	                }
    	                if (isset($data_en['aa1'])) {
    	                    $adminAreaL1 = urlencode($data_en['aa1'].','.$data_en['country']);
    	                }
    	            }
    	        }
    	        
    	        if ($address) {    	            
    	            $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=en";    	            
    	            $geocode = json_decode (file_get_contents($url), true );
    	            
    	            if ($geocode['status'] != 'OK') {
    	                $skipped++;
    	                echo "SKIPPED   ".$w['c_id']."  -> no geocode".PHP_EOL;
    	                continue;
    	            }
    	            
    	            $res = $geocode['results'][0];
    	        }
    	        elseif (isset($adminAreaL2)) {
    	            $address = $adminAreaL2;
    	            $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=en";    	            
    	            $geocode = json_decode (file_get_contents($url), true );
    	            
    	            if ($geocode['status'] != 'OK') {
    	                $skipped++;
    	                echo "SKIPPED   ".$w['c_id']."  -> no geocode".PHP_EOL;
    	                continue;
    	            }
    	            
    	            $res = $geocode['results'][0];
    	        }
    	        elseif (isset($adminAreaL1)) {
    	            $address = $adminAreaL1;
    	            $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=en";    	             
    	            $geocode = json_decode (file_get_contents($url), true );
    	             
    	            if ($geocode['status'] != 'OK') {
    	                $skipped++;
    	                echo "SKIPPED   ".$w['c_id']."  -> no geocode".PHP_EOL;
    	                continue;
    	            }
    	             
    	            $res = $geocode['results'][0];
    	        }
    	        else {
    	            $skipped++;
    	            echo "SKIPPED   ".$w['c_id']."  -> no locality".PHP_EOL;
    	            continue;
    	        }
    	    }
  	     
    	    $components = $res['address_components'];
    	    $data_en = array();
    	    $data_en = array(
    	            'latitude' => $res['geometry']['location']['lat'],
    	            'longitude' => $res['geometry']['location']['lng']
    	    );
    	    
    	    foreach ($components as $c) {
    	        foreach ($_types as $field => $types) {
    	            if (array_intersect($types, $c['types'])) {
    	                $data_en[$field] = $c['long_name'];
    	            }
    	            
    	            if (in_array('country', $c['types'])) {
    	                $data_en['language'] = strtolower($c['short_name']);
    	            }
    	        }
    	    }

    	    if (!isset($data_en['city'])) {
    	        $skipped++;
    	        echo "SKIPPED   ".$w['c_id']."  -> no locality".PHP_EOL;
    	        continue;
    	    }
    	    
    	    if(!isset($data_en['county'])) {
    	        $data_en['county'] = $data_en['country'];
    	    }
    	    
    	    $latitude = $data_en['latitude'];
    	    $longitude = $data_en['longitude'];
    	    $latlng = $latitude.','.$longitude;
    	    $county_name = $data_en['county'];
    	     
    	    $county = Doctrine::getTable('County')
        	    ->createQuery('co')
        	    ->innerJoin('co.Translation cto')
        	    ->where('cto.name LIKE ?', $county_name)
        	    ->andWhere('co.country_id = ?', 2)
        	    ->fetchOne();
    	     
    	    $city = Doctrine::getTable('City')
        	    ->createQuery('c')
        	    ->innerJoin('c.Translation ct')
        	    ->innerJoin('c.County co')
        	    ->innerJoin('co.Translation cot')
        	    ->where('ct.name = ?', $data_en['city'])
        	    ->andWhere('cot.name = ?', $data_en['county'])
        	    ->andWhere('co.id < ?', 296)
        	    ->fetchOne();
    	
    	    if (!$city) {
    	        $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $latlng . "&sensor=false&language=ro";
    	         
    	        $geocode = json_decode (file_get_contents($url), true );
    	         
    	        if ($geocode['status'] != 'OK') {
    	            $skipped++;
    	            echo "SKIPPED   ".$w['c_id']."  -> no geocode".PHP_EOL;    	             
    	            continue;
    	        }
    	         
    	        $results = $geocode['results'];
    	        foreach ($results as $r) {
    	            if (array_intersect(array('locality'), $r['types'])) {
    	                $res = $r;
    	                break;
    	            }
    	        }
    	        	
    	        $components = $res['address_components'];
    	        $data = array();
    	        $data = array(
    	                'latitude' => $res['geometry']['location']['lat'],
    	                'longitude' => $res['geometry']['location']['lng']
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
    	        
    	        if(!isset($data['county']))
    	        {
    	            $data['county'] = $data['country'];
    	        }
    	         
    	        $city = Doctrine::getTable('City')
    	        ->createQuery('c')
    	        ->innerJoin('c.Translation ct')
    	        ->innerJoin('c.County co')
    	        ->innerJoin('co.Translation cot')
    	        ->where('ct.name = ?', $data['city'])
    	        ->andWhere('cot.name = ?', $data['county'])
    	        ->andWhere('co.id < ?', 296)
    	        ->fetchOne();
    	    }
    	    
    	    if (!$city && (isset($data_en['city']) || isset($data['city']))) {
    	        $city_name = (isset($data_en['city']) ? $data_en['city'] : $data['city']);
    	        
    	        $city = Doctrine::getTable('City')
    	        ->createQuery('c')
    	        ->innerJoin('c.Translation ct')
    	        ->innerJoin('c.County co')
    	        ->innerJoin('co.Translation cot')
    	        ->where('ct.name = ?', $data['city'])
    	        //->andWhere('cot.name = ?', $data['county'])
    	        ->andWhere('co.id < ?', 296)
    	        ->fetchOne();
    	    }
    	    
    	    if (!$city && (isset($data_en['city']) || isset($data['city']))) {
    	        $city_name = (isset($data_en['city']) ? $data_en['city'] : $data['city']);
    	        
    	        $city = new City();
    	        $city->setCounty($county);
    	        $city->setLat($latitude);
    	        $city->setLng($longitude);
    	        $city->setSlug(CityTable::slugify($city_name));
    	        $city->save();
    	        
    	        $con = Doctrine::getConnectionByTableName('city_translation');
    	        $con->execute('INSERT INTO `city_translation`(`id`, `name`, `lang`) VALUES ("'.$city->getId().'", "'.$city_name.'", "en");');
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
    	    else {
    	        $skipped++;
    	        echo "SKIPPED   ".$w['c_id'].PHP_EOL;
    	        continue;
    	    }
    	    sleep(3);
    	    
    	}

    	echo $skipped.' Skipped'.PHP_EOL;
    	echo $done.' Updated'.PHP_EOL;
  }
}
