<?php
ini_set("memory_limit","2048M");
class importHungaryCompaniesTask extends importBaseTask
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
		$this->name             = 'hu_companies';

		$this->setCountryId(104);
		$this->setLang("hu");

	}

	protected function execute($arguments = array(), $options = array())
	{
		$this->_databaseManager = new sfDatabaseManager($this->configuration);
		$this->_connection = $this->_databaseManager->getDatabase($options['connection'])->getConnection();
		 
		$this->addSource("companies", "hungary/companies_hu_5th_1.1.csv");
		$this->setSourceColumns("companies", array(
				0=>"title",
				1=>"title_en",
				#0=>"classification_id_mod",
				2=>"classification_id_1",
				#0=>"classification_id_2",
				#0=>"classification_id_3",
				#0=>"classification_id_4",
				#0=>"classification_id_5",
				3=>"phone",
				4=>"city",
				#0=>"city_ext_id",
				9=>"county",
				18=>"email",
				19=>"website_url",
				20=>"foursquare_url",
				21=>"twitter_url",
				22=>"facebook_url",
				23=>"company_type",
				24=>"registration_no",
				10=>"location_type",
				11=>"street_type_id",
				8=>"street_number",
				7=>"street",
				12=>"neighbourhood",
				13=>"building_no",
				14=>"entrance",
				15=>"floor",
				16=>"appartment",
				5=>"postcode",
				6=>"full_address",
				17=>"address_info",
				25=>"latitude",
				26=>"longitude"));
		$this->setSourceSeparator("companies","\t");
		 
		$this->setSourceTable("companies", "company");
		$data = $this->fetchSourceData("companies",importBaseTask::SKIP_FIRST_ROW);

		$this->_getCurrentCities();
		$this->_getCurrentCompaniesSlug();
		$this->_getCurrentCompanies();
// 		$this->_getCurrentCounties();
		$this->_getCurrentClassifications();
		$this->_handleCompanies();
	}

	protected function _handleCompanies(){
		//If company doesn't have lat & long , get them from city
		$this->mapSourceData("companies",$this->getLatLngFromCityMapper());
			
		//Filtering all matching companies + all without city
		$this->filterSourceData("companies", $this->getMatchingAndNoCityFilter());
		 
		echo "AFTER FILTERING MATCHING COMPANIES - SIZE IS :".$this->getSourceDataCount("companies").PHP_EOL;
		//   	echo "MATCHING IS $matching".PHP_EOL;
		//preparing companies before insert
		echo "PREPARING COMPANIES BEFORE INSERT".PHP_EOL;
		$this->mapSourceData("companies", function($company) use (&$new_companies_slugs){
			//echo "GENERATING SLUG - .. ";
			$slug = $this->generateCompanySlug($company['title']);
			//echo "'$slug', ";

			$company['slug'] = $slug;
			$new_companies_slugs[] = $slug;
			$company['country_id'] = $this->_countryId;
			// 		$classifications_ids = explode(",",$company['classification_id']);
			$classifications_ids = array();
			$classifications_ids[] = $company['classification_id_1'];
			if(isset($company['classification_id_2'])){
				$classifications_ids[] = $company['classification_id_2'];
			}
			if(isset($company['classification_id_3'])){
				$classifications_ids[] = $company['classification_id_3'];
			}
			if(isset($company['classification_id_4'])){
				$classifications_ids[] = $company['classification_id_4'];
			}
			if(isset($company['classification_id_5'])){
				$classifications_ids[] = $company['classification_id_5'];
			}

			$company['classification_ids'] = $classifications_ids;
			$company['classification_id'] = intval($classifications_ids[0]);

			$phones = explode(",",$company['phone']);
			$company['phone'] = $phones[0];
			if(isset($phones[1]))$company['phone1'] = $phones[1];
			if(isset($phones[2]))$company['phone2'] = $phones[2];

			$company['sector_id'] = (int)$this->getTableArray("classifications","origin",$company['classification_id']);
			
			// 		$company['county_id'] = $this->_getCountyId($company);
			$date = date("Y-m-d H:i:s");
			$company['created_at'] = $date;
			$company['updated_at'] = $date;
			$company['last_click'] = $date;
			$company['status'] = 0;
			$company['is_validated'] = "validated";
			// 		$company['id'] = 'soon';
			return $company;
		});
		//Remove all companies without classification also filling $this->_no_classification_companies
		$this->filterSourceData("companies",$this->getNoClassificationFilter());

		//Executes all the filters and mappers above in a way that all the companies are iterated only once
		//note that all the filters and mappers without (.. , true) as last parameter
		//are not executed until this method is called
		echo "processing filters...";
		$time = microtime(true);
		$this->executeAllFiltersAndMappers("companies");
		echo "done (".(microtime(true)-$time)."s)".PHP_EOL;
		$this->_table_arrays = NULL;

		// 	echo "AFTER PREPARING COMPANIES FOR INSERT - SIZE IS :".$this->getSourceDataCount("companies").PHP_EOL;
		$insert_columns = array("title","classification_id",'sector_id','slug',"phone","city_id",'email',
				'website_url','created_at','country_id','status','is_validated','facebook_url','foursquare_url',
				'twitter_url',"company_type","registration_no");

		$query = $this->bulkInsert("companies",$insert_columns);

		$this->executeSource("companies");

		echo "BEFORE current size is : ".sizeof($this->getTableArray("companies")).PHP_EOL;
		//load inserted companies into array_tables
		$this->_getCurrentCompanies(true);
		// 	var_dump($this->getTableArray("companies","by_slug"));
		echo "AFTER current size is : ".sizeof($this->getTableArray("companies")).PHP_EOL;

		//Adds the inserted id for the new companies which will be used later for inserting related records
		$this->mapSourceData("companies", $this->getInsertedIdsFilter(),true);
		
		$this->_table_arrays = NULL;

		if(!$this->getSourceData("companies")){
			echo "No companies in source after filter".PHP_EOL;
		}else{
			$classifications = array();
			$company_location = array();
			$company_translation = array();
			$page_table = array();
	
			foreach($this->getSourceData("companies") as $company){
				//Preparing `company_classification` insert array
					foreach($company['classification_ids'] as $cid){
						if($cid){
							$classifications[] = array(
								"company_id"=>$company['id'],
								"classification_id"=>$cid
							);
						}
					}
				// preparing company_location inserts
				$company_location[] = array(
						"company_id"=>$company['id'],
						"street_number"=>$company['street_number'],
						"street"=>$company['street'],
						"neighbourhood"=>$company['neighbourhood'],
						"postcode"=>$company['postcode'],
						"location_type"=>$company['location_type'],
						"street_type_id"=>$company["street_type_id"],
						"building_no"=>$company['building_no'],
						"entrance"=>$company['entrance'],
						"floor"=>$company['floor'],
						"appartment"=>$company['appartment'],
						"full_address"=>$company['full_address'],
						"address_info"=>$company['address_info'],
						"latitude"=>$company['latitude'],
						"longitude"=>$company['longitude'],
						"is_active"=>1,
						"created_at"=>date("Y-m-d H:i:s"),
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
		echo "Number of filtered because of cities (".sizeof($this->_missmatching_companies).")".PHP_EOL;
		echo "Number of filtered because of already exists (".sizeof($this->_matching_companies).")".PHP_EOL;
		echo "Number of filtered because of classifications (".sizeof($this->_no_classifications_companies).")".PHP_EOL;
		echo "NO CLASSIFICATION COMPANIES".PHP_EOL;
		foreach($this->_no_classifications_companies as $mmcompany){
			$tmp_arr = array();
// 			$tmp_arr['id'] = '"'.$mmcompany['id'].'"';
			$tmp_arr['title'] = '"'.$mmcompany['title'].'"';
			$tmp_arr['city'] = '"'.$mmcompany['city'].'"';
			echo implode(",",$tmp_arr).PHP_EOL;
		}
		
		echo "MISSMATCHING COMPANIES".PHP_EOL;
		foreach($this->_missmatching_companies as $mmcompany){
			$tmp_arr = array();
// 			$tmp_arr['id'] = '"'.$mmcompany['id'].'"';
			$tmp_arr['title'] = '"'.$mmcompany['title'].'"';
			$tmp_arr['city'] = '"'.$mmcompany['city'].'"';
			echo implode(",",$tmp_arr).PHP_EOL;
		}
	}
}
