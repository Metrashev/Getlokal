<?php
ini_set("memory_limit","1024M");
class importMontenegroCompaniesTask extends importBaseTask
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

    $this->namespace        = 'import';
    $this->name             = 'montenegro_companies';
    
    $this->setCountryId(151);
    $this->setLang("me");
    
  }

  protected function execute($arguments = array(), $options = array())
  {
  	$this->_databaseManager = new sfDatabaseManager($this->configuration);
  	$this->_connection = $this->_databaseManager->getDatabase($options['connection'])->getConnection();
  	
  	
  	$this->addSource("companies", "montenegro/companies.me_with_location_ids.csv");
  	$this->setSourceColumns("companies", array('title','classification_id','phone','city','city_ext_id',
  		'county','county_ext_id','email','website_url',18=>'street_number',
  		19=>'street',20=>'neighbourhood',21=>'post_code',22=>'latitude',23=>'longitude'));
  	
  	$this->setSourceTable("companies", "company");
  	$data = $this->fetchSourceData("companies",importBaseTask::SKIP_FIRST_ROW);
    
  	$this->_getCurrentCities();
  	$this->_getCurrentCompaniesSlug();
  	$this->_getCurrentCompanies();
  	$this->_getCurrentCounties();
//   	echo "SIZE OF companies origin is ".sizeof($this->getTableArray("companies"));
//   	echo "SIZE OF companies by_name is ".sizeof($this->getTableArray("companies","by_name"));
//   	die;
//   	var_dump($this->getTableArray("companies"));die;
  	$this->_getCurrentClassifications();
	$this->_handleCompanies();
  }
  
  protected function _handleCompanies(){
  	echo "INSERTING COMPANIES ...<br />".PHP_EOL;
//   	echo "BEFORE LAT LNG FIXING - SIZE IS :".$this->getSourceDataCount("companies").PHP_EOL;
  	//if company doesn't have lat & long , get them from city
  	$this->mapSourceData("companies",function($company){
  		$company['city_id'] = $this->_getCityId($company);
  		if(!$company['latitude'] && !$company['longitude']){
  			$company['latitude'] = $this->_table_arrays['cities']['origin'][$company['city_id']]['latitude'];
  			$company['longitude'] = $this->_table_arrays['cities']['origin'][$company['city_id']]['longitude'];
  		}
  		return $company;
  	});
  	echo "AFTER LAT LNG FIXING - SIZE IS :".$this->getSourceDataCount("companies").PHP_EOL;
//   	$offset = 200;
//   	$limit = 400;
  	

  	//filtering all matching companies
  	$this->filterSourceData("companies", function($company){
// 			global $counter;
// 			$counter++;
//   			if($counter >400){
//   				return false;
//   			}
  	  		if($this->_checkIfCompaniesMatch($company)){
//   	  			$matching++;
	  			return false;
	  		}else{
	  			return true;
	  		}
  		
  	});
  	
  	
  	
  		
  	$new_companies_slugs = array();
//   	global $matching;
  	echo "AFTER FILTERING MATCHING COMPANIES - SIZE IS :".$this->getSourceDataCount("companies").PHP_EOL;
//   	echo "MATCHING IS $matching".PHP_EOL;
  	//preparing companies before insert
  	echo "PREPARING COMPANIES BEFORE INSERT".PHP_EOL;
	$this->mapSourceData("companies", function($company) use (&$new_companies_slugs){
		echo "GENERATING SLUG - .. ";
		$slug = $this->generateCompanySlug($company['title']);
		echo "$slug".PHP_EOL;
		
 		$company['slug'] = $slug;
		$new_companies_slugs[] = $slug;
		$company['country_id'] = $this->_countryId;
		$classifications_ids = explode(",",$company['classification_id']);
		$company['classification_ids'] = $classifications_ids;
		$company['classification_id'] = intval($classifications_ids[0]);
		
		if(!isset($this->_table_arrays['classifications']['origin'][$company['classification_id']])){
			echo "SKIPPED BECAUSE OF CLASSIFICATION".PHP_EOL;
			$company['sector_id'] = 0;
		}else{
			$company['sector_id'] = $this->_table_arrays['classifications']['origin'][$company['classification_id']]['sector_id'];
		}
		$company['county_id'] = $this->_getCountyId($company);
		$date = date("Y-m-d H:i:s");
		$company['created_at'] = $date;
		$company['updated_at'] = $date;
		$company['last_click'] = $date;
		$company['status'] = 0;
		$company['is_validated'] = "validated";
// 		$company['id'] = 'soon';
		return $company;
	});
	
	$this->filterSourceData("companies", function($company){
		if(!$company['sector_id'] || !$company['classification_id']){
			return false;
		}else{
			return true;
		}
	});
	
// 	echo "AFTER PREPARING COMPANIES FOR INSERT - SIZE IS :".$this->getSourceDataCount("companies").PHP_EOL;
	$insert_columns = array("title","classification_id",'sector_id',
			'slug',"phone","city_id",'email','website_url','created_at','country_id','status','is_validated');
	
	$query = $this->bulkInsert("companies",$insert_columns);
	
	$this->executeSource("companies");

	echo "BEFORE current size is : ".sizeof($this->getTableArray("companies")).PHP_EOL;
	//load inserted companies into array_tables
	$this->_getCurrentCompanies(true);
// 	var_dump($this->getTableArray("companies","by_slug"));
	echo "AFTER current size is : ".sizeof($this->getTableArray("companies")).PHP_EOL;

	$companies_by_slug = $this->getTableArray("companies","by_slug");
	
	//adds the inserted id for the new companies which will be used later for inserting related records
	$this->mapSourceData("companies", function($company) use($companies_by_slug){
		if(isset($companies_by_slug[$company['slug']])){
			$company['id'] = $companies_by_slug[$company['slug']];
		}else{
			"ERROR: CANT FIND COMPANY BY SLUG {$company['slug']} PROBABLY INSERT WASNT SUCCESSFULL".PHP_EOL;
		}
		return $company;
	});
	
	if(!$this->getSourceData("companies")){
		echo "No companies in source after filter".PHP_EOL;
		return;
	}
	
	$classifications = array();
	$company_location = array();
	$company_translation = array();
	$page_table = array();
	
	foreach($this->getSourceData("companies") as $company){
		//preparing company_classification inserts
		foreach($company['classification_ids'] as $cid){
			$classifications[] = array(
				"company_id"=>$company['id'],
				"classification_id"=>$cid
			);
		}
		// preparing company_location inserts
		$company_location[] = array(
			"company_id"=>$company['id'],
			"street_number"=>$company['street_number'],
			"street"=>$company['street'],
			"neighbourhood"=>$company['neighbourhood'],
			"postcode"=>$company['post_code'],
			"latitude"=>$company['latitude'],
			"longitude"=>$company['longitude'],
			"is_active"=>1,
			"created_at"=>date("Y-m-d H:i:s")
		);
		// preparing company_translation inserts
		$company_translation[] = array(
			"id"=>$company['id'],
			"title"=>$company['title'],
			"lang"=>$this->_localLanguage
		);
		
		$company_translation[] = array(
			"id"=>$company['id'],
			"title"=>$this->replaceDiacritics($this->toLatin($company['title'])),
			"lang"=>"en"
		);
		
		// preparing page inserts
		$page_table[] = array(
			"foreign_id" => $company['id'],
			"is_public"=>1,
			"country_id"=>$this->_countryId,
			"type"=>2,
			"url_alias"=>"",
			"created_at"=>date("Y-m-d H:i:s")
		);
	}
	
	$classifications_bulk = $this->_bulkInsert(
			$classifications,
			"company_classification",
			array_keys(current($classifications)));
	
	$company_location_bulk = $this->_bulkInsert(
			$company_location,
			"company_location",
			array_keys(current($company_location)));
	
	$company_translation_bulk = $this->_bulkInsert(
			$company_translation,
			"company_translation",
			array_keys(current($company_translation)));
	
	$page_table_bulk = $this->_bulkInsert(
			$page_table,
			"page",
			array_keys(current($page_table)));

	
	//var_dump($classifications_bulk[0],$company_location_bulk[0],$company_translation_bulk[0],$page_table_bulk[0]);
	
	if($classifications_bulk){
		foreach($classifications_bulk as $q)
		$this->_connection->prepare($q)->execute();// works
	}
	if($company_location_bulk){
		foreach($company_location_bulk as $q)
		$this->_connection->prepare($q)->execute();// works
	}
	if($company_translation_bulk){
		foreach($company_translation_bulk as $q)
		$this->_connection->prepare($q)->execute();// works
	}		
	if($page_table_bulk){
		foreach($page_table_bulk as $q)
		$this->_connection->prepare($q)->execute();//works
	}
	
	$this->_connection->prepare(
	  			"UPDATE company c
				SET location_id = (SELECT id FROM company_location cl WHERE c.id = cl.company_id)
				WHERE c.location_id IS NULL AND DATE(c.created_at) > DATE_SUB(NOW(),INTERVAL 1 day) ")
	  ->execute();
	
  	echo "INSERTING COMPANIES: DONE ...<br />".PHP_EOL;
  }
}
