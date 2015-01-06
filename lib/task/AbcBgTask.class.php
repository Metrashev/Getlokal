<?php

class AbcBgTask extends sfBaseTask
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

    $this->namespace        = 'abc';
    $this->name             = 'Bug';
    $this->briefDescription = 'goes trough new cities created in BG and redirect users and companies to ones we have';
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
      
      echo 'Fix repeat city - Bulgaria'.PHP_EOL;
      
      $wrongs = Doctrine_Query::create()
    	    ->select('c.id, c.lat, c.lng, ct.name')
    	    ->from('City c')
    	    ->innerJoin('c.Translation ct')
    	    ->innerJoin('c.County co')
    	    ->where('co.country_id = 1 AND c.id > ?', 54973)
    	    ->setHydrationMode(Doctrine::HYDRATE_SCALAR)
    	    ->execute();
    	
    	$i=0;
    	$skipped = 0;

    	
    	foreach ($wrongs as $w) {
    	    $latlng = $w['c_lat'].','.$w['c_lng'];
            $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $latlng . "&sensor=false&language=bg";
    	        	
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
    	    }
    	    
    	    $components = $res;
    	    $data = array(); 
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
    	        ->fetchOne();
    	    
            if ($city) {
                if ($city->getId() == $w['c_id']) {
                    $components = $results[0]['address_components'];
                
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
                
                    $city = Doctrine::getTable('City')
                    ->createQuery('c')
                    ->innerJoin('c.Translation ct')
                    ->innerJoin('c.County co')
                    ->innerJoin('co.Translation cot')
                    ->where('ct.name = ?', $data['city'])
                    ->andWhere('cot.name = ?', $data['county'])
                    ->fetchOne();
                
                    if ($city->getId() == $w['c_id']) {
                        $skipped++;
                        echo "SKIPPED   ".$w['c_id'].PHP_EOL;
                        continue;
                    }
                }
                echo 'UPDATED   '.$w['c_id'].' -> '.$city->getId().PHP_EOL;
                $con = Doctrine::getConnectionByTableName('user_profile');
                $con->execute("UPDATE `user_profile` SET city_id='".$city->getId()."' WHERE city_id='".$w['c_id']."';");
                $con = Doctrine::getConnectionByTableName('company ');
                $con->execute("UPDATE `company` SET city_id='".$city->getId()."' WHERE city_id='".$w['c_id']."';");
                $con = Doctrine::getConnectionByTableName('city');
                $con->execute("DELETE FROM `city` WHERE id=".$w['c_id'].";");
            	$i++;                
            }
            else {
                $skipped++;
                echo "SKIPPED   ".$w['c_id'].PHP_EOL;
                continue;
            }
    	    
    	}

  }
}
