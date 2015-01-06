<?php

class CityrepeatSerbiaTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'cityrepeat';
    $this->name             = 'Serbia';
    $this->briefDescription = 'Fixes repeated cities in Serbia and cities in new counties';
    $this->detailedDescription = <<<EOF
The [fixRepeatCitySerbia|INFO] task does things.
Call it with:

  [php symfony fixRepeatCitySerbia|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    $connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );

    echo PHP_EOL."Repeat city Serbia".PHP_EOL;
    
    $wrongs = Doctrine_Query::create()
    	->select('c.id, c.lat, c.lng, co.id, ct.name')
    	->from('City c')
    	->innerJoin('c.Translation ct')
    	->innerJoin('c.County co')
    	->where('co.country_id = 4 AND co.id < ?', 850)
    	->andWhere('ct.lang = ?', 'en')
    	->setHydrationMode(Doctrine::HYDRATE_SCALAR)
    	->execute();
    echo count($wrongs).' cities to be done in Serbia!'.PHP_EOL;
    $done = 0;
    $skipped = 0;
      
    foreach ($wrongs as $w) {
        
        $res = null;
        $latlng = $w['c_lat'].','.$w['c_lng'];
        $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $latlng . "&sensor=false&language=en";
      
        $geocode = json_decode (file_get_contents($url), true );
      
        if ($geocode['status'] != 'OK') {
            $skipped++;
            echo "SKIPPED   ".$w['c_id']."  -> no locality".PHP_EOL;
            continue;
        }
           
        $_types = array(
                'city' => array('locality'),
                'county' => array(
                        'administrative_area_level_2',
                        'administrative_area_level_1',
                        'administrative_area_level_3'
                ),
                'country' => array('country')
        );
      
        $results = $geocode['results'];
        foreach ($results as $r) {
            if (array_intersect(array('neighborhood'), $r['types'])) {
                $res = $r['address_components'];
                break;
            }
        }
        
        if (!$res) {
            foreach ($results as $r) {
                if (array_intersect(array('locality'), $r['types'])) {
                    $res = $r['address_components'];
                    break;
                }
            }
        }
        if (!$res) {
            foreach ($results as $r) {
                if (array_intersect(array('street_address', 'postal_code'), $r['types'])) {
                    $res = $r['address_components'];
                    break;
                }
            }
        }
        
        if (!$res) {
            $skipped++;
            echo $w['c_id'].' Skipped due to missing geocode.'.PHP_EOL;
        }
        
        $components = $res;
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

        if (!isset($data_en['city'])) {
            $skipped++;
            echo "SKIPPED   ".$w['c_id']."  -> no locality".PHP_EOL;
            continue;
        }
        
        $address = urlencode($data_en['city'].',Serbia');
        $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=en";
        
        $geocode = json_decode (file_get_contents($url), true );
      
        if ($geocode['status'] != 'OK') {
            $skipped++;
            echo "SKIPPED   ".$w['c_id']."  -> no locality".PHP_EOL;
            continue;
        }
        
        $components = $geocode['results'][0]['address_components'];
        $data_en = array();
        $data_en = array(
                'latitude' => $geocode['results'][0]['geometry']['location']['lat'],
                'longitude' => $geocode['results'][0]['geometry']['location']['lng']
        );

        foreach ($components as $c) {
            foreach ($_types as $field => $types) {
                if (array_intersect($types, $c['types'])) {
                    $data_en[$field] = $c['long_name'];
                }
            }
        }

        if (!isset($data_en['city'])) {
            $skipped++;
            echo "SKIPPED   ".$w['c_id']."  -> no locality".PHP_EOL;
            continue;
        }
        
        $city = Doctrine::getTable('City')
                ->createQuery('c')
                ->innerJoin('c.Translation ct')
                ->where('c.county_id > 800')
                ->andWhere('ct.name = ?', $data_en['city'])
                ->fetchOne();
        
        if ($city && $city != NULL) {
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
            $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=sr";
        
            $geocode = json_decode (file_get_contents($url), true );

            if ($geocode['status'] != 'OK') {
                $skipped++;
                echo "SKIPPED   ".$w['c_id'].PHP_EOL;
                continue;
            }

            $components = $geocode['results'][0]['address_components'];
            $data = array();

            foreach ($components as $c) {
                foreach ($_types as $field => $types) {
                    if (array_intersect($types, $c['types'])) {
                        $data[$field] = $c['long_name'];
                    }
                }
            }

            if (!isset($data['city'])) {
                $skipped++;
                echo "SKIPPED   ".$w['c_id']."  -> no locality".PHP_EOL;
                continue;
            }

            $city = Doctrine::getTable('City')
                    ->createQuery('c')
                    ->innerJoin('c.Translation ct')
                    ->where('c.county_id > 800')
                    ->andWhere('ct.name = ?', call_user_func(array('TransliterateSr', 'toLatinSr' ), $data['city']))
                    ->fetchOne();

            if ($city && $city != NULL) {
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
                if (isset($data_en['city']) && $data_en['city'] != NULL && $data_en['city'] != ''
                        && isset($data_en['county']) && $data_en['county'] != NULL && $data_en['county'] != ''
                        && isset($data_en['latitude']) && $data_en['latitude'] != NULL && $data_en['latitude'] != ''
                        && isset($data_en['longitude']) && $data_en['longitude'] != NULL && $data_en['longitude'] != '') {
                    $county = Doctrine::getTable('County')
                        ->createQuery('co')
                        ->innerJoin('co.Translation cto')
                        ->where('cto.name LIKE ? OR cto.name LIKE ?', array($data_en['county'],$data['county']))
                        ->andWhere('co.country_id = ?', 4)
                        ->andWhere('co.id > ?', 800)
                        ->fetchOne();
                    
                    if ($county) {
                        $city = new City();
                        $city->setCounty($county);
                        $city->setLat($data_en['latitude']);
                        $city->setLng($data_en['longitude']);
                        $city->setSlug(CityTable::slugify($data_en['city']));
                        $city->save();
                        echo "NEW ";
                        $con = Doctrine::getConnectionByTableName('city_translation');
                        $con->execute('INSERT INTO `city_translation`(`id`, `name`, `lang`) VALUES ("'.$city->getId().'", "'.$data_en['city'].'", "en");');
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
                }
                else {
                    $skipped++;
                    echo "SKIPPED   ".$w['c_id'].PHP_EOL;
                    continue;
                }
            }
            sleep(3);
        }     
    }
    
    echo $skipped.' Skipped'.PHP_EOL;
    echo $done.' Updated'.PHP_EOL;
    
  }
}
