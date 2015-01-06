<?php
class SublocationTask extends sfBaseTask {
	protected function configure() {
		$this->addArguments ( array (new sfCommandArgument ( 'limit', sfCommandArgument::REQUIRED, 'Limit' ), new sfCommandArgument ( 'offset', sfCommandArgument::REQUIRED, 'offset' ) ) );
		
		$this->addOptions ( array (new sfCommandOption ( 'application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend' ), new sfCommandOption ( 'env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev' ), new sfCommandOption ( 'connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine' ) ) );
		
		$this->namespace = 'oxt';
		$this->name = 'getSublocation';
		$this->briefDescription = 'get company Sublocation';
		$this->detailedDescription = <<<EOF
The [getSublocation|INFO] task rebuilds empty slugs.
Call it with: 
 
  [php symfony getSublocation|INFO]
EOF;
	}
	
	protected function execute($arguments = array(), $options = array()) {
		// initialize the database connection
		date_default_timezone_set ( 'Europe/Sofia' );
		$databaseManager = new sfDatabaseManager ( $this->configuration );
		$connection = $databaseManager->getDatabase ( $options ['connection'] ? $options ['connection'] : null )->getConnection ();
		$connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );
		
		$query = Doctrine::getTable ( 'CompanyLocation' )->createQuery ( 'm' )
		->innerJoin('m.Company c')
		->innerJoin('c.City ci')
		->where ('c.status = 0')
		->addWhere('ci.is_default != 0')
		->addWhere('m.sublocation is NULL')
		->addOrderBy ( 'm.id' );
		
		
	    $companies = $query ->limit ( $arguments ['limit'] )->offset ( $arguments ['offset'] )->execute ();
		gc_enable ();
		foreach ( $companies as $item ) {
			
			$lang = getlokalPartner::getDefaultCulture ( $item->getCompany()->getCountryId () );
			
			$key = "AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08";
			
			$address = urlencode ( $item->getCompany()->getDisplayAddressMap ( $lang ) );
			
			$url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=".$lang;
			
			$string = file_get_contents ( $url ); // get json content
			$json_a = json_decode ( $string, true );
			$ch = curl_init ();
			
			curl_setopt ( $ch, CURLOPT_URL, $url );
			curl_setopt ( $ch, CURLOPT_HEADER, 0 ); //Change this to a 1 to return headers
			

			curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
			
			$results = curl_exec ( $ch );			
			curl_close ( $ch );
			$sublocation = null;
			$words = array ();
			if (isset ( $results [0]) && isset($json_a ['results'] [0] ['address_components']) ) {
			//print_r($json_a ['results'] [0] ['address_components']); exit();
		foreach ($json_a ['results'] [0] ['address_components'] as $key =>$val)
		{
			
			if (self::in_array_r('street', $val) or self::in_array_r('route', $val)){
				$sublocation=   $val['long_name'];
			}
		}
		
				if ($sublocation) {
					
					$item->set ( 'sublocation', $sublocation );
					$item->save ();
					$item->free ();
					$item = null;
					unset ( $item );
				
				}
			}
		
		//echo $item->getId () . ' ' . $sublocation . '\n';
		

		}
		
		$companies->free ();
		$companies = null;
		unset ( $companies );
		
		gc_collect_cycles ();
	}
   protected function in_array_r($needle, $haystack, $strict = true) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && self::in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}
}