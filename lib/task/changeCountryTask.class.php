<?php

class changeCountryTask extends sfBaseTask
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

    $this->namespace        = 'change';
    $this->name             = 'Country';
    $this->briefDescription = 'changes the name_en of the countries with google ones';
    $this->detailedDescription = <<<EOF
The [changeCountry|INFO] task does things.
Call it with:

  [php symfony changeCountry|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $country = Doctrine_Query::create()
        ->select('con.id, con.name_en')
        ->from('Country con')
        ->whereNotIn('con.id', getlokalPartner::getAllPartners())
        ->andWhere('con.id < 250 AND con.id != 218 AND con.id != 220 AND con.id != 13')
        ->setHydrationMode(Doctrine::HYDRATE_SCALAR)
        ->execute();
    
    $skipped = 0;
    
    foreach ($country as $cntry) {
        $address = urlencode($cntry['con_name_en']);
        $url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=false&language=en";
        
        $geocode = json_decode (file_get_contents($url), true );
         
        if ($geocode['status'] != 'OK') {
            $geocode = json_decode (file_get_contents($url), true );
             
            if ($geocode['status'] != 'OK') {
                $skipped++;
                echo 'SKIPPED  - '.$cntry['con_id'].'   '.$cntry['con_name_en'].PHP_EOL;
                continue;
            }
        }
        
        $_types = array(
                'country' => array('country')
        );
        
        $results = $geocode['results'];
        foreach ($results as $r) {
    	        if (array_intersect(array('country'), $r['types'])) {
    	            $components = $r['address_components'];
    	            break;
    	        }
    	    }
            
        //$components = $geocode['results'][0]['address_components'];
        
        foreach ($components as $c) {
            foreach ($_types as $field => $types) {
                if (array_intersect($types, $c['types'])) {
                    $data[$field] = $c['long_name'];
                }
            }
        }
        
        if (isset($data['country']) && $data['country'] != $cntry['con_name_en']) {
            $con = Doctrine::getConnectionByTableName('country');
            $con->execute("UPDATE `country` SET `name_en`='".$data['country']."' WHERE `id`='".$cntry['con_id']."';");
            echo $cntry['con_id'].'   '.$cntry['con_name_en'].' --> '.$data['country'].PHP_EOL;
        }
        sleep(1);
    }
    
    // add your code here
  }
}
