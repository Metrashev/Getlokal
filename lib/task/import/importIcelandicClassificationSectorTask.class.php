<?php
ini_set("memory_limit","1024M");

class importIcelandicClassificationSectorTranslationTask extends importBaseTask
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

		$this->namespace        = 'import_translation';
		$this->name             = 'iceland_classifications_sectors';
		
// 		$this->setCountryId(151);
		$this->setLang("en");

	}

	protected function execute($arguments = array(), $options = array())
	{
		$this->_databaseManager = new sfDatabaseManager($this->configuration);
		$this->_connection = $this->_databaseManager->getDatabase($options['connection'])->getConnection();
		
		$this->_getCurrentClassifications();
		$this->_getCurrentSectors();
	  	
	  	$this->addSource("classifications", "iceland/classification_IS.csv");
	  	$this->setSourceTable("classifications", "classification_translation");
	  	$this->setSourceColumns("classifications", array(
	  		0=>"id",
	  		2=>"is",
	  	));
	  	
	  	$classifications = $this->fetchSourceData("classifications",self::SKIP_FIRST_ROW);
	  	
	  	$this->addSource("sectors", "iceland/sector_IS.csv");
	  	$this->setSourceTable("sectors", "sector_translation");
	  	$this->setSourceColumns("sectors", array(
	  		0=>"id",
	  		2=>"is"
	  	));
	  	$this->setSourceTable("sectors", "sector_translation");
	  	
	  	$sectors = $this->fetchSourceData("sectors",self::SKIP_FIRST_ROW);
	  	
	  	$sectors_mapper = function($row){
	  		$data = explode(',',$row['is']);
	  		$sector = $this->getTableArray("sectors","origin",$data[0]);
	  		$arr = array(
		  			"id"=>$data[0],
		  			"rank"=>$sector['rank'],
		  			"lang"=>"is",
		  			"title"=>$data[1],
		  			"slug"=>$this->getSlug($data[1]),
		  			"page_title"=>$data[1]
		  		);
	  		return $arr;
	  	};
	  	
	  	
	  	$classifications_mapper = function($row){
	  		$a = explode(',',$row['id']);
	  		$id = $a[0];
	  		$b = explode(',',$row['is']);
	  		$title = $b[1];
	  		$arr = array(
	  			"id"=>$id,
	  			"lang"=>"is",
	  			"title"=>$title,
	  			"slug"=>$this->getSlug($title),
	  			"short_title"=>$title,
	  			"page_title"=>$title
	  		);
	  		return $arr;
	  	};
	  	
	  	$this->mapSourceData("classifications", $classifications_mapper,true);
		$this->mapSourceData("sectors",$sectors_mapper,true);
		
		$qc = $this->bulkInsert("classifications");
		
		$qs = $this->bulkInsert("sectors");		
		$this->executeSource("classifications");
		$this->executeSource("sectors");
	}
}

