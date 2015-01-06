<?php
class LocationTask extends sfBaseTask {
	protected function configure() {
		
		$this->addOptions ( array (new sfCommandOption ( 'application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend' ), new sfCommandOption ( 'env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev' ), new sfCommandOption ( 'connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine' ) ) );
		
		$this->namespace = 'oxt';
		$this->name = 'getCitySlug';
		$this->briefDescription = 'get City Slug';
		$this->detailedDescription = <<<EOF
The [getCitySlug|INFO] task rebuilds empty slugs.
Call it with: 
 
  [php symfony getCitySlug|INFO]
EOF;
	}
	
	protected function execute($arguments = array(), $options = array()) {
		// initialize the database connection
		date_default_timezone_set ( 'Europe/Sofia' );
		$databaseManager = new sfDatabaseManager ( $this->configuration );
		$connection = $databaseManager->getDatabase ( $options ['connection'] ? $options ['connection'] : null )->getConnection ();
		$connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );
		
		$query = Doctrine::getTable ( 'City' )->createQuery ( 'm' );
		
		 $q3 = $query->createSubquery ()->select ( 'ci.slug' )
         ->from ( 'City ci')
         ->addGroupBy('ci.slug')
	     ->addHaving('count(ci.slug) > 1');
		
	     $query->andWhere ( 'm.slug IN (' . $q3->getDql () . ')' )  ;
         $query->addOrderBy ( 'm.slug' );
         	     
		$cities = $query->execute ();		
		
		if (count ( $cities ) > 0) {
			foreach ( $cities as $city ) {
				$partner_class = getlokalPartner::getLanguageClass ( $city->getCounty ()->getCountryId () );
				$slug = $city->getCityNameByCulture ('en') . ' ' . mb_convert_case ( $city->getCounty ()->getCountyNameByCulture ('en') , MB_CASE_LOWER, 'UTF-8' );
				$city->setSlug ( $slug );
				$city->save ();
				$city->free ();
			}
		}
		
		$cities = null;
		unset ( $cities );
		
		gc_collect_cycles ();
	}

}