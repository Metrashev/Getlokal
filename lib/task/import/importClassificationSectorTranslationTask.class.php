<?php
ini_set("memory_limit","1024M");

class importClassificationSectorTranslationTask extends importBaseTask
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
		$this->name             = 'classifications_sectors';
		
// 		$this->setCountryId(151);
		$this->setLang("en");

	}

	protected function execute($arguments = array(), $options = array())
	{
		$this->_databaseManager = new sfDatabaseManager($this->configuration);
		$this->_connection = $this->_databaseManager->getDatabase($options['connection'])->getConnection();
		
		$this->_connection->prepare("UPDATE classification_translation SET title = 'Travel & Accommodation' WHERE title = 'Travel & Accomodation'")->execute();
		$this->_getCurrentClassifications();
		$this->_getCurrentSectors();
	  	
	  	require_once("GreekSlugGenerator.php");
	  	$GSG = new GreekSlugGenerator();
	  	
	  	$this->addSource("classifications_sectors", "classifications-translations-fixed.csv");
	  	$this->setSourceTable("classifications_sectors", "classifications_translations");
	  	$this->setSourceColumns("classifications_sectors", array(
	  		0=>"id",
	  		1=>"en",
	  		3=>"de",
	  		5=>"se",
	  		7=>"fr",
	  		10=>"gr",
	  		12=>"es",
	  		14=>"pt",
	  		16=>"cz",
	  		18=>"si",
	  		20=>"sk",
	  		22=>"ba"
	  	));
	  	
	  	$classifications = $this->fetchSourceData("classifications_sectors" , 2 , 275);
	  	var_dump($classifications); die;
	  	$this->newSource("classifications", $classifications);
	  	$this->setSourceTable("classifications", "classification_translation");
	  	
	  	$sectors = $this->fetchSourceData("classifications_sectors",278);
	  	$this->newSource("sectors",$sectors);
	  	$this->setSourceTable("sectors", "sector_translation");
	  	
	  	$slug_mapper = function($row) use($GSG){
	  		$row['en_slug'] = $this->getSlug($row['en']);
	  		$row['de_slug'] = $this->getSlug($row['de']);
	  		$row['se_slug'] = $this->getSlug($row['se']);
	  		$row['fr_slug'] = $this->getSlug($row['fr']);
	  		$row['gr_slug'] = $GSG->get_slug($row['gr']);
	  		$row['es_slug'] = $this->getSlug($row['es']);
	  		$row['pt_slug'] = $this->getSlug($row['pt']);
	  		$row['cz_slug'] = $this->getSlug($row['cz']);
	  		$row['si_slug'] = $this->getSlug($row['si']);
	  		$row['sk_slug'] = $this->getSlug($row['sk']);
	  		$row['ba_slug'] = $this->getSlug($row['ba']);
	  		return $row;
	  	};
	  	var_dump($slug_mapper); die;
	  	$classifications_id_mapper = function($row,$key){
	  		if(!$row['id'])
	  			if(!($row['id'] = $this->getTableArray("classifications","by_name",str_replace(";",",", $row['en']))))
		  			echo "KEY : $key".PHP_EOL;
	  		return $row;
	  	};
	  	
	  	$sectors_id_mapper = function($row,$key){
	  		if(!$row['id'] && $row['en'])
	  			if(!$row['id'] = $this->getTableArray("sectors","by_name",str_replace(";",",",$row['en'])))
	  				echo "KEY : $key".PHP_EOL;
// 	  		echo $row['id'];die;
			if(is_numeric($row['id'])){
				$sector = $this->getTableArray("sectors","origin",$row['id']);
				$row['rank'] = $sector['rank'];
			}
	  		
	  		return $row;
	  	};
	  	
	  	$langs = array("se","gr","cz","si","sk","ba","fr","de","es");
	  	echo implode(",",$langs). " needs to be cleared before importing".PHP_EOL;
	  	$sectors_language_multiplier = function($row) use($langs){
	  		$arr = array();
	  		foreach($langs as $lang){
		  		$arr[] = array(
		  			"id"=>$row['id'],
		  			"rank"=>$row['rank'],
		  			"lang"=>$lang,
		  			"title"=>$row[$lang],
		  			"slug"=>$row[$lang."_slug"],
		  			"page_title"=>$row[$lang]
		  		);
	  		}
	  		return $arr;
	  	};
	  	
	  	
	  	$classifications_language_multiplier = function($row) use($langs){
	  		$arr = array();
	  		foreach($langs as $lang){
	  			$arr[] = array(
  					"id"=>$row['id'],
  					"lang"=>$lang,
  					"title"=>$row[$lang],
  					"slug"=>$row[$lang."_slug"],
  					"short_title"=>$row[$lang]
	  			);
	  		}
	  		return $arr;
	  	};
	  	
	  	$this->mapSourceData("classifications", $slug_mapper,true);
	  	$this->mapSourceData("classifications", $classifications_id_mapper,true);
		$this->mapSourceData("sectors",$slug_mapper,true);
		$this->mapSourceData("sectors",$sectors_id_mapper,true);
		
		$this->multiplySourceData("classifications",$classifications_language_multiplier,true);
		$this->multiplySourceData("sectors",$sectors_language_multiplier,true);
		
		$qc = $this->bulkInsert("classifications");
// 		var_dump($qc);
		$qs = $this->bulkInsert("sectors");
// 		var_dump($qs);
		$this->executeSource("classifications");
		$this->executeSource("sectors");
	}
}

