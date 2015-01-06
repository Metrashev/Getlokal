<?php

class CountyChangeSerbiaTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'county';
    $this->name             = 'ChangeSerbia';
    $this->briefDescription = 'Changes the counties and regions. Mistaken when imported.';
    $this->detailedDescription = <<<EOF
The [countyChangeSerbia|INFO] task does things.
Call it with:

  [php symfony countyChangeSerbia|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    $connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );
    
          echo PHP_EOL."County and region change Serbia".PHP_EOL;
    
    $names = Doctrine_Query::create()
              ->select('co.id as id, cot.name as name, co.region as co_name')
              ->from('County co')
              ->innerJoin('co.Translation cot')
              ->where('co.id < 251')
              ->andWhere('co.country_id = 4')
              ->andWhere('cot.lang = ?', 'sr')
              ->groupBy('co.region')
              ->setHydrationMode(Doctrine::HYDRATE_SCALAR)
              ->fetchArray();

    echo count($names).' Counties should be changed'.PHP_EOL;
    
    $newNames = array();
    
    array_push($newNames, array(
                'old_name' => 'KOSOVO I METOHIJA',
                'new_name_sr' => 'Kosovo i Metohija',
                'new_name_en' => 'Kosovo and Metohija'
                ));
$newN = array('Kosovo i Metohija');
    $skipped = 0;
    $i = 1;
    $x=0;
 $newJP = array();   
    foreach ($names as $name) {
        if ($name['co_name'] == 'JABLANIČKO-PČINJSKI') {
            $names2 = Doctrine_Query::create()
              ->select('co.id as id, cot.name as name, co.region as co_name')
              ->from('County co')
              ->innerJoin('co.Translation cot')
              ->where('co.region LIKE ?', 'JABLANIČKO-PČINJSKI')
              ->andWhere('co.country_id = 4')
              ->andWhere('cot.lang = ?', 'sr')
              ->setHydrationMode(Doctrine::HYDRATE_SCALAR)
              ->fetchArray();
            foreach ($names2 as $name2) {

                $address = urlencode($name2['name'].',Serbia');
                $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=sr";
                $data = array();
                $data_en = array();

                $geocode = json_decode (file_get_contents($url), true );

                if ($geocode['status'] != 'OK') {
                    $skipped++;

                    $j = 0;

                    do {
                        sleep(5);
                        $geocode = json_decode (file_get_contents($url), true );
                        $j++;
                    }while($geocode['status'] == 'OVER_QUERY_LIMIT' && $j < 5);

                    if ($geocode['status'] != 'OK') {
                        $skipped++;
                        continue;                 
                    }                 
                }

                $_types = array(
                        'city' => array('locality'),
                        'county' => array(
                                'administrative_area_level_2'
                        ),
                        'country' => array('country')
                );

                $results = $geocode['results'][0];
                $components = $results['address_components'];            

                foreach ($components as $c) {
                    foreach ($_types as $field => $types) {
                        if (array_intersect($types, $c['types'])) {
                            $data[$field] = $c['long_name'];
                        }
                    }
                }

                $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=en";

                $geocode = json_decode (file_get_contents($url), true );

                if ($geocode['status'] != 'OK') {
                    $skipped++;

                    $j = 0;

                    do {
                        sleep(5);
                        $geocode = json_decode (file_get_contents($url), true );
                        $j++;
                    }while($geocode['status'] == 'OVER_QUERY_LIMIT' && $j < 5);

                    if ($geocode['status'] != 'OK') {
                        $skipped++;
                        continue;                 
                    }                 
                }

                $_types = array(
                        'city' => array('locality'),
                        'county' => array(
                                'administrative_area_level_2'
                        ),
                        'country' => array('country')
                );

                $results = $geocode['results'][0];
                $components = $results['address_components'];

                foreach ($components as $c) {
                    foreach ($_types as $field => $types) {
                        if (array_intersect($types, $c['types'])) {
                            $data_en[$field] = $c['long_name'];
                        }
                        if (in_array('country', $c['types'])) {
                            $data['language'] = strtolower($c['short_name']);
                        }
                    }
                }
                
                $needle = null;

                if (isset($data['county'])) {
                    $needle = call_user_func(array('TransliterateSr', 'toLatinSr' ), $data['county']);
                    $newJP[$name2['id']] = call_user_func(array('TransliterateSr', 'toLatinSr' ), $data['county']);
                    if (!in_array($needle, $newN)) {
                        array_push($newNames, array(
                            'old_name' => $name2['co_name'],
                            'new_name_sr' => call_user_func(array('TransliterateSr', 'toLatinSr' ), $data['county']),
                            'new_name_en' => $data_en['county']
                            ));
                        array_push($newN, call_user_func(array('TransliterateSr', 'toLatinSr' ),$data['county']));
                        $x++;
                        $i++;
                    }
                }
                else {
                    if (!isset($data['country'])) {
                        echo 'SKIPPED: '.$name2['id'].'   '.$name2['name'].'   '.$name2['co_name'].PHP_EOL;
                        continue;
                    }
                    $needle = call_user_func(array('TransliterateSr', 'toLatinSr' ), $data['country']);
                    $newJP[$name2['id']] = call_user_func(array('TransliterateSr', 'toLatinSr' ),$data['country']);
                    if (!in_array($needle, $newN)) {
                        array_push($newNames, array(
                            'old_name' => $name2['co_name'],
                            'new_name_sr' => call_user_func(array('TransliterateSr', 'toLatinSr' ),$data['country']),
                            'new_name_en' => $data_en['country']
                            ));
                            array_push($newN, call_user_func(array('TransliterateSr', 'toLatinSr' ),$data['country']));
                        $x++;
                        $i++;
                    }
                }

                //sleep(1);
                
            }
            
            echo $x.' done in IF'.PHP_EOL;  
            continue;
        }
        
        $address = urlencode($name['name'].',Serbia');
        $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=sr";
        $data = array();
        $data_en = array();

        $geocode = json_decode (file_get_contents($url), true );

        if ($geocode['status'] != 'OK') {
            $skipped++;

            $j = 0;
            
            do {
                sleep(5);
                $geocode = json_decode (file_get_contents($url), true );
                $j++;
            }while($geocode['status'] == 'OVER_QUERY_LIMIT' && $j < 5);

            if ($geocode['status'] != 'OK') {
                $skipped++;
                continue;                 
            }                 
        }

        $_types = array(
                'city' => array('locality'),
                'county' => array(
                        'administrative_area_level_2'
                ),
                'country' => array('country')
        );

        $results = $geocode['results'][0];
        $components = $results['address_components'];            

        foreach ($components as $c) {
            foreach ($_types as $field => $types) {
                if (array_intersect($types, $c['types'])) {
                    $data[$field] = $c['long_name'];
                }
            }
        }

        $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=en";

        $geocode = json_decode (file_get_contents($url), true );

        if ($geocode['status'] != 'OK') {
            $skipped++;

            $j = 0;
            
            do {
                sleep(5);
                $geocode = json_decode (file_get_contents($url), true );
                $j++;
            }while($geocode['status'] == 'OVER_QUERY_LIMIT' && $j < 5);

            if ($geocode['status'] != 'OK') {
                $skipped++;
                continue;                 
            }                 
        }

        $_types = array(
                'city' => array('locality'),
                'county' => array(
                        'administrative_area_level_2'
                ),
                'country' => array('country')
        );

        $results = $geocode['results'][0];
        $components = $results['address_components'];

        foreach ($components as $c) {
            foreach ($_types as $field => $types) {
                if (array_intersect($types, $c['types'])) {
                    $data_en[$field] = $c['long_name'];
                }
                if (in_array('country', $c['types'])) {
                    $data['language'] = strtolower($c['short_name']);
                }
            }
        }

        if (isset($data['county'])) {
            array_push($newNames, array(
                'old_name' => $name['co_name'],
                'new_name_sr' => call_user_func(array('TransliterateSr', 'toLatinSr' ), $data['county']),
                'new_name_en' => $data_en['county']
                ));
array_push($newN, call_user_func(array('TransliterateSr', 'toLatinSr' ),$data['country']));
            $i++;
        }
        else {
            if (!isset($data['country'])) {
                echo 'SKIPPED: '.$name['id'].'   '.$name['name'].'   '.$name['co_name'].PHP_EOL;
                continue;
            }
            array_push($newNames, array(
                'old_name' => $name['co_name'],
                'new_name_sr' => call_user_func(array('TransliterateSr', 'toLatinSr' ),$data['country']),
                'new_name_en' => $data_en['country']
                ));
array_push($newN, call_user_func(array('TransliterateSr', 'toLatinSr' ),$data['country']));
            $i++;
        }

        //sleep(1);
    }
    
    echo $i.' Counties geocoded'.PHP_EOL;
    if ($i < count($names)) {
      echo 'Not all counties coded! EXIT'.PHP_EOL;
      exit();
    }
  
    $country = Doctrine::getTable('Country')->findOneById(4);
    
    echo 'Staring transition'.PHP_EOL;
    $i = 0;

    foreach ($newNames as $newName) {
        $oldCounties = Doctrine::getTable('County')->findBy('region', $newName['old_name']);
        
        if ($oldCounties) {
                $newCounty = new County();
                $newCounty->setCountry($country);
                $newCounty->setSlug(CityTable::slugify($newName['new_name_en']));
                $newCounty->save();

                $con = Doctrine::getConnectionByTableName('county_translation');
                $con->execute('INSERT INTO `county_translation`(`id`, `name`, `lang`) VALUES ("'.$newCounty->getId().'", "'.$newName['new_name_en'].'", "en");');
                $con->execute('INSERT INTO `county_translation`(`id`, `name`, `lang`) VALUES ("'.$newCounty->getId().'", "'.$newName['new_name_sr'].'", "sr");');


                foreach ($oldCounties as $oldCounty) {
                    if ($newName['old_name'] == 'JABLANIČKO-PČINJSKI') {
                       // var_dump(($newName['new_name_sr'] == $newJP[$oldCounty->getId()]).' *** '.$newJP[$oldCounty->getId()].'  *  '.$newName['new_name_sr']);
                        if ($newName['new_name_sr'] == $newJP[$oldCounty->getId()]) {
                            $con = Doctrine::getConnectionByTableName('city');
                            $con->execute("UPDATE `city` SET county_id='".$newCounty->getId()."' WHERE county_id='".$oldCounty->getId()."';");
                        }
                    }
                    else {
                        $con = Doctrine::getConnectionByTableName('city');
                        $con->execute("UPDATE `city` SET county_id='".$newCounty->getId()."' WHERE county_id='".$oldCounty->getId()."';");
                    }
                    $oldCityCount = Doctrine_Query::create()
                          ->select('c.id as id')
                          ->from('City c')
                          ->where('c.county_id = ?', $oldCounty->getId())
                          ->count();

                    if ($oldCityCount == 0) {
                        $con = Doctrine::getConnectionByTableName('county');
                        $con->execute("DELETE FROM `county` WHERE id=".$oldCounty->getId().";");
                    }
                }
            
            $i++;
        }
    }
    
    echo $i.' regions done'.PHP_EOL;
  }
  
}
