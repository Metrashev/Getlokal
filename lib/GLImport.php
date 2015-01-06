<?php

class GLImport {
	static public function initDatabaseConnection($configuration, $connectionName) {
		// initialize the database connection
		$databaseManager = new sfDatabaseManager ( $configuration );
		$connection = $databaseManager->getDatabase ( $connectionName ? $connectionName : null )->getConnection ();
		
		return $connection;
	}
	
	static public function analyze($connection) {
		$connection->beginTransaction ();
		GLImport::message ( 'analyze' );
		$connection->exec ( 'ANALYZE' );
		$connection->commit ();
		GLImport::message ( 'analyze completed' );
	}
	
	static public function setDatabase($connection) {
		GLImport::message ( 'SET work_mem TO \'10MB\'' );
		$connection->query ( 'SET work_mem TO \'10MB\'' );
		
		GLImport::message ( 'SET temp_buffers TO \'6MB\'' );
		$connection->query ( 'SET temp_buffers TO \'6MB\'' );
	}
	
	static public function setEnTitles($connection) {
		$result = true;
		$all_companies = Doctrine::getTable ( 'Company' )->createQuery('c')->addWhere ( 'c.title_en is null OR c.title_en = ""' )->execute ();
		if(count($all_companies)>0){
			foreach ( $all_companies as $company ) {
				switch ($company->getCountryId ()) {
					case getlokalPartner::GETLOKAL_BG :
						$title_en = TransliterateBg::toLatin ( $company->getTitle () );
						break;
					case getlokalPartner::GETLOKAL_RO :
						$title_en = TransliterateRo::toLatin ( $company->getTitle () );
						break;
					case getlokalPartner::GETLOKAL_MK :
						$title_en = TransliterateMk::toLatin ( $company->getTitle () );
						break;
							
				}
					
				$company->setTitleEn ( $title_en );
				$company->save ();

			}
		}
	}
static public function message($msg) {
		echo '[' . date ( 'H:i:s' ) . '] ' . $msg . "\n";
	}
}