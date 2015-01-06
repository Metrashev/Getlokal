<?php

class fixCityTask extends sfBaseTask
{
    protected function configure()
    {
        mb_internal_encoding("UTF-8");
        $this->addArguments(array());

        $this->addOptions(array (
                new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
                new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
                new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'))
        );

        $this->namespace = 'fix';
        $this->name = 'city';
        $this->briefDescription = 'Move users and companies from cities and countries where country_id > 250';
        $this->detailedDescription = <<<EOF
[php symfony update:geo-ip]
EOF;
    }

    protected function execute($arguments = array(), $options = array())
    {
        $databaseManager = new sfDatabaseManager ( $this->configuration );
        $connection = $databaseManager->getDatabase ( $options ['connection'] ? $options ['connection'] : null )->getConnection ();
        $connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );

        $skipped = 0;
        $done = 0;
        $skippedSerbia = 0;
        
        header("content-type:application/csv;charset=UTF-8");
        $succeded = fopen(sfConfig::get('sf_web_dir').'/done_FixCity.csv','w+');
        $failed = fopen(sfConfig::get('sf_web_dir').'/skipped_FixCity.csv','w+');
        
        $wrongs = Doctrine_Query::create()
        	->select('c.id AS city_id, ct.name AS city_name, c.lat as city_latitude, c.lng as city_longitude, co.id AS county_id, cot.name AS county_name, ctr.id AS country_id, ctr.name_en AS country_name')
        	->from('City c')
        	->innerJoin('c.Translation ct')
        	->innerJoin('c.County co')
        	->innerJoin('co.Translation cot')
        	->innerJoin('co.Country ctr')
        	->where('ctr.id > 250 AND ct.lang="en" AND cot.lang="en"')
        	//->andWhere('ctr.id < 254')
        	->orderBy('ctr.id ASC, co.id ASC, c.id ASC')
        	->setHydrationMode(Doctrine::HYDRATE_SCALAR)
    	    ->execute();
        
        $left = count($wrongs);
        
        foreach ($wrongs as $wrong) {
            $wrongCityId = $wrong['c_city_id'];
            $wrongCountryId = $wrong['ctr_country_id'];
            
            if ($wrongCountryId == 4) {
                $skippedSerbia++;
                print_r('SKIPPED Serbia: city: '.$wrongCityId);
                continue;
            }
            
            $address = urlencode($wrong['ct_city_name'].','.$wrong['cot_county_name'].','.$wrong['ctr_country_name']);        
            $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=en";
        	$geocode = json_decode(file_get_contents($url), true);
        	
        	if ($geocode['status'] != 'OK') {
        	    /*
        	    $latlng = $wrong['c_city_latitude'].','.$wrong['c_city_longitude'];
        	    $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $latlng . "&sensor=false&language=en";
        	    $geocode = json_decode (file_get_contents($url), true );
        	    
        	    if ($geocode['status'] != 'OK') {
            	    print_r($done.' cities shifted.'.PHP_EOL.$left.' left.'.PHP_EOL.$skipped.' skipped.');
            	    exit();
        	    }
        	    */
        	    $skipped++;
        	    fputcsv($failed, array(iconv('UTF-8', 'UTF-8',$wrongCityId), iconv('UTF-8', 'UTF-8',$wrongCountryId)));
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

        	$country = Doctrine::getTable('Country')
            	->createQuery('cou')
            	->where('cou.name_en LIKE ?', $data['country'])
            	->andWhere('cou.slug != ?', '')
            	->fetchOne();
        	            
        	if ($country) {
        	    if (in_array($country->getId(), getlokalPartner::getAllPartners())) {
        	    /** PARTNERS REMOVED FROM THIS TASK **/
        	    continue;
        	    /*
        	        $latlng = $data['latitude'].','.$data['longitude'];
                	$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $latlng . "&sensor=false&language=".$data['language'];
                	$geocode = json_decode (file_get_contents($url), true );
                	
                	if ($geocode['status'] != 'OK') {
                	    //print_r($done.' cities shifted.'.PHP_EOL.$left.' left.'.PHP_EOL.$skipped.' skipped.');
                	    //exit();
                	    $skipped++;
                	    fputcsv($failed, array(iconv('UTF-8', 'UTF-8',$wrongCityId), iconv('UTF-8', 'UTF-8',$wrongCountryId)));
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
                	$data_native = array(
                	        'latitude' => $results['geometry']['location']['lat'],
                	        'longitude' => $results['geometry']['location']['lng']
                	);
                	 
                	foreach ($components as $c) {
                	    foreach ($_types as $field => $types) {
                	        if (array_intersect($types, $c['types'])) {
                	            $data_native[$field] = $c['long_name'];
                	        }
                	        
                	        if (in_array('country', $c['types'])) {
                	            $data_native['language'] = strtolower($c['short_name']);
                	        }
                	    }
                	}
                	
                	if (!empty($data_native)) {
                	    $data = array_merge($data_native, array(
                	            'city_en' => $data['city'],
                	            'county_en' => (isset($data['county']) ? $data['county'] : null),
                	            'country_en' => $data['country'],
                	    ));
                	}
                */	               	
        	    }
        	    
        	    if (!isset($data['country_en'])) {
        	        if(!isset($data['county'])) {
        	            $data['county'] = $data['country'];
        	        }
        	    }
        	    else {
        	        if(!isset($data['county'])) {
        	            $data['county'] = $data['country'];
        	            $data['county_en'] = $data['country_en'];
        	        }
        	    }
 
        	    $latitude = $data['latitude'];
        	    $longitude = $data['longitude'];
        	    $county_name = (isset($data['county_en']) ? $data['county_en'] : $data['county']);
        	    
        	    if ($country->getId() == 3) {
        	        $county = Doctrine::getTable('County')->findById(71);
        	    }
        	    else {
        	        $county = Doctrine::getTable('County')
            	        ->createQuery('co')
                	    ->innerJoin('co.Translation cto')
                	    ->where('cto.name LIKE ?', $county_name)
                	    ->andWhere('co.country_id = ?', $country->getId())
                	    ->fetchOne();
        	    }
        	    
        	    if (!$county) {
        	        $county = new County();
        	        $county->setSlug(CountyTable::slugify($county_name));
        	        $county->setCountry($country);
        	        $county->save();
        	                	        
        	        $con = Doctrine::getConnectionByTableName('county_translation');
        	        $con->execute('INSERT INTO `county_translation`(`id`, `name`, `lang`) VALUES ("'.$county->getId().'", "'.$county_name.'", "en");');
        	    }
        	    
        	    $city_name = (isset($data['city_en']) ? $data['city_en'] : $data['city']);
        	    $city = Doctrine::getTable('City')
            	    ->createQuery('c')
            	    ->innerJoin('c.Translation ct')
            	    ->where('ct.name LIKE ?', $city_name)
            	    ->andWhere('c.county_id = ?', $county->getId())
            	    ->fetchOne();
        	    
        	    if (!$city) {
        	        $city = new City();
        	        $city->setCounty($county);
        	        $city->setLat($latitude);
        	        $city->setLng($longitude);
        	        $city->setSlug(CityTable::slugify($city_name));
        	        $city->save();
        	        
        	        $con = Doctrine::getConnectionByTableName('city_translation');
        	        $con->execute('INSERT INTO `city_translation`(`id`, `name`, `lang`) VALUES ("'.$city->getId().'", "'.$city_name.'", "en");');
        	    }
        	    
        	    $correctCityId = $city->getId();
        	    $correctCountryId = $country->getId();
        	    
        	    $con = Doctrine::getConnectionByTableName('user_profile');
        	    $con->execute('UPDATE `user_profile` SET city_id="'.$correctCityId.'" WHERE city_id="'.$wrongCityId.'";');
        	    $con->execute('UPDATE `user_profile` SET country_id="'.$correctCountryId.'" WHERE country_id="'.$wrongCountryId.'";');
        	    
        	    $con = Doctrine::getConnectionByTableName('company');
        	    $con->execute('UPDATE `company` SET city_id="'.$correctCityId.'" WHERE city_id="'.$wrongCityId.'";');
        	    $con->execute('UPDATE `company` SET country_id="'.$correctCountryId.'" WHERE country_id="'.$wrongCountryId.'";');

        	    $done++;
        	    $left--;
        	    fputcsv($succeded, array(iconv('UTF-8', 'UTF-8',$wrongCityId), iconv('UTF-8', 'UTF-8',$wrongCountryId),
        	        iconv('UTF-8', 'UTF-8',$correctCityId), iconv('UTF-8', 'UTF-8',$correctCountryId)));
        	    print_r('SUCCESS: city: '.$wrongCityId.'->'.$correctCityId.'    country: '.$wrongCountryId.'->'.$correctCountryId.PHP_EOL);
        	}
        	else {
        	    $skipped++;
        	    fputcsv($failed, array(iconv('UTF-8', 'UTF-8',$wrongCityId), iconv('UTF-8', 'UTF-8',$wrongCountryId)));
        	    print_r('FAILED: city: '.$wrongCityId.'->'.$correctCityId.'    country: '.$wrongCountryId.'->'.$correctCountryId.PHP_EOL);
        	}
        	sleep(5);      	
        }

        fclose($succeded);
        fclose($failed);
        print_r("Done: ".$done);
        print_r("Failed: ".$skipped);
        print_r("Skipped Serbia: ".$skippedSerbia);
    }
}