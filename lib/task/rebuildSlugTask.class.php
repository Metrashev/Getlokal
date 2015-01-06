<?php
class rebuildSlugTask extends sfBaseTask {
	protected function configure() {
		$this->addArguments ( array (new sfCommandArgument ( 'limit', sfCommandArgument::REQUIRED, 'Limit' ), new sfCommandArgument ( 'offset', sfCommandArgument::REQUIRED, 'offset' ), new sfCommandArgument ( 'model', sfCommandArgument::REQUIRED, 'Model' ), new sfCommandArgument ( 'field', sfCommandArgument::REQUIRED, 'Slug source field' ), new sfCommandArgument ( 'count', sfCommandArgument::REQUIRED, 'Passing total count' ) ) );
		
		$this->addOptions ( array (new sfCommandOption ( 'application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend' ), new sfCommandOption ( 'env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev' ), new sfCommandOption ( 'connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine' ) ) );
		
		$this->namespace = 'oxt';
		$this->name = 'rebuildSlug';
		$this->briefDescription = 'Rebuild empty slug';
		$this->detailedDescription = <<<EOF
The [rebuildSlug|INFO] task rebuilds empty slugs.
Call it with: 
 
  [php symfony rebuildSlug|INFO]
EOF;
	}
	
	protected function execute($arguments = array(), $options = array()) {
		// initialize the database connection
		date_default_timezone_set ( 'Europe/Sofia' );
		$databaseManager = new sfDatabaseManager ( $this->configuration );
		$connection = $databaseManager->getDatabase ( $options ['connection'] ? $options ['connection'] : null )->getConnection ();
		$connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );
		
		$companies = Doctrine::getTable ( $arguments ['model'] )->createQuery ( 'm' )->addWhere("m.slug REGEXP '[[:digit:]]{7,10}$'")->addOrderBy ( 'm.id' )->limit ( $arguments ['limit'] )->offset ( $arguments ['offset'] )->execute ();
		$_c = $arguments['offset'];
		gc_enable ();
		foreach ( $companies as $item ) {
			//cheat doctrine to re-save our model
			$field_value = $item->get ( $arguments ['field'] );
			$item->set ( $arguments ['field'], '' );
			$item->set ( $arguments ['field'], $field_value );
			$item->save ();
			$item->free ();
			$item = null;
			unset ( $item );
			$_m = sprintf("%01.2f", (memory_get_usage() / 1024) / 1024);
			echo "\r$_c / $arguments[count] ($_m MB)";
			$_c += 1;
			if($_c % 1000 == 1) echo "\n";

		}
		
		$companies->free ();
		$companies = null;
		unset ( $companies );
		
		gc_collect_cycles ();
	}

}