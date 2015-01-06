<?php

class slugForAllCompaniesTask extends sfBaseTask {
	protected function configure() {
		// // add your own arguments here
		$this->addArguments ( array (new sfCommandArgument ( 'model', sfCommandArgument::REQUIRED, 'Model' ), new sfCommandArgument ( 'field', sfCommandArgument::REQUIRED, 'Slug source field' ), new sfCommandArgument ( 'limit', sfCommandArgument::REQUIRED, 'limit' ) ) );
		
		$this->addOptions ( array (new sfCommandOption ( 'application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend' ), new sfCommandOption ( 'env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev' ), new sfCommandOption ( 'connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine' ) ) );
		
		$this->namespace = 'oxt';
		$this->name = 'forAllCompanies';
		$this->briefDescription = 'Set New Slug';
		$this->detailedDescription = <<<EOF
The [oxt:forAllCompanies|INFO] task does things.
Call it with:

  [php symfony oxt:forAllCompanies|INFO]
EOF;
	}
	
	protected function execute($arguments = array(), $options = array()) {
		// initialize the database connection
		$databaseManager = new sfDatabaseManager ( $this->configuration );
		$connection = $databaseManager->getDatabase ( $options ['connection'] ? $options ['connection'] : null )->getConnection ();
		$connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );
		
		$companies = Doctrine::getTable ( $arguments ['model'] )->createQuery ( 'm' )->addWhere("m.slug REGEXP '[[:digit:]]{7,10}$'");
		$count = $companies->count();
//		echo $count; die();
		
		$offset = 0;
		gc_enable ();
		
		while ( $offset < $count ) {		
			$this->runTask ( 'oxt:rebuildSlug', array ('limit' => $arguments ['limit'], 'offset' => $offset, 'model' => $arguments ['model'], 'field' => $arguments ['field'], 'count' => $count ) );
			$offset += $arguments ['limit'] + 1;			
		}
		$companies = null;
		unset ($companies);
		gc_collect_cycles ();
	
		// add your code here
	}
}
