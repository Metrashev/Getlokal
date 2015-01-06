<?php
ini_set("memory_limit","2048M");
class importRussiaCompaniesTask extends importBaseTask
{
	protected function configure()
	{
		// // add your own arguments here  123456
		// $this->addArguments(array(  
		//   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
		// ));

		$this->addOptions(array(
				new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
				new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
				new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
				// add your own options here
		));
    
    	$this->addArgument('index', sfCommandArgument::REQUIRED, 'The file index');
    	$this->addArgument('part', sfCommandArgument::REQUIRED, 'Which part/half of the file to import');

		$this->namespace        = 'import';
		$this->name             = 'russia_companies';

		$this->setCountryId(184);
		$this->setLang("ru");

	}

	protected function execute($arguments = array(), $options = array())
	{
		$this->_createConnection($options);
		
		if(!($arguments['index'] > 0 && $arguments['index'] <= 13)){
			echo "Invalid index {$arguments['index']}".PHP_EOL;return;
		}
		if(!in_array($arguments['part'],array(1,2,3))){
			echo "Invalid index {$arguments['part']}".PHP_EOL;return;
		}
		
		$this->addSource("companies", "russia/getlocal-ru-2014-05-15-{$arguments['index']}_this_tab.csv");
		
 		$this->setSourceColumns("companies", array("id","title","title_en","classification_id_mod","classification_id_1",
//		$this->setSourceColumns("companies", array("id","title","title_en","classification_id_1",
				"classification_id_2","classification_id_3","classification_id_4","classification_id_5","phone","city",
				"city_ext_id","county","email","website_url","foursquare_url","twitter_url","facebook_url","company_type",
				"registration_no","location_type","street_type_id","street_number","street","neighbourhood","building_no","entrance",
				"floor","appartment","postcode","full_address","address_info","latitude","longitude"));
 		
 		if($arguments['index'] == 5){
	 		$this->removeSourceColumn("companies", "classification_id_mod");
 		}

 		$this->setSourceSeparator("companies","\t");
		
		$this->setSourceTable("companies", "company");
		
// 		$this->fetchSourceData("companies",self::SKIP_FIRST_ROW,15000);
		if($arguments['part'] == 1){
			$this->fetchSourceData("companies",self::SKIP_FIRST_ROW,33333);
		}elseif($arguments['part'] == 2){
			$this->fetchSourceData("companies",33333,66666);
		}elseif($arguments['part'] == 3){
			$this->fetchSourceData("companies",66666);
		}else{
			echo "Invalid argument `part`.";return;
		}
		

		echo "getting current table dbs as arrays ".PHP_EOL;
		$this->_getCurrentCities();
		$this->_getCurrentCompaniesSlug();
// 		$this->_getCurrentCompanies();
		$this->_getCurrentClassifications();
		$this->_handleCompanies();
		$this->_destroyConnection();
	}

	protected function _handleCompanies(){
		//If company doesn't have lat & long , get them from city
		$this->mapSourceData("companies",$this->getLatLngFromCityMapper());
		
		//Filtering all matching companies + all without city
		$this->filterSourceData("companies", $this->getMatchingAndNoCityFilter());
			
		//Preparing company keys before insert
		//Any manipulations of the records between getting them from csv and inserting them into table
		//should be done here
		echo "PREPARING COMPANIES BEFORE INSERT".PHP_EOL;
		$this->mapSourceData("companies", function($company){
			$company['slug'] = $this->generateCompanySlug($company['title']);
			$company['country_id'] = $this->_countryId;
			
// 			$classifications_ids = explode(",",$company['classification_id']);
			$classifications_ids = array();
			$classifications_ids[] = $company['classification_id_1'];
			$classifications_ids[] = $company['classification_id_2'];
			$classifications_ids[] = $company['classification_id_3'];
			$classifications_ids[] = $company['classification_id_4'];
			if(isset($company['classification_id_5']))
				$classifications_ids[] = $company['classification_id_5'];

			$company['classification_ids'] = $classifications_ids;
			$company['classification_id'] = intval($classifications_ids[0]);

			$phones = explode(",",$company['phone']);
			$company['phone'] = $phones[0];
			if(isset($phones[1]))$company['phone1'] = $phones[1];
			if(isset($phones[2]))$company['phone2'] = $phones[2];

			if($company['classification_id']){
				$company['sector_id'] = (int)$this->getTableArray("classifications","origin",$company['classification_id']);
			}else{
				$company['sector_id'] = false;	
			}

			$date = date("Y-m-d H:i:s");
			$company['created_at'] = $date;
			$company['updated_at'] = $date;
			$company['last_click'] = $date;
			$company['status'] = 0;
			$company['is_validated'] = "validated";

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
		
		$this->_createConnection($options);
		
		//This will filter all the keys of a company down to the listed here,
		//so that bulkInsert could iterate through them
		$insert_columns = array("title","classification_id",'sector_id',
				'slug',"phone","city_id",'email','website_url','created_at','country_id','status','is_validated','facebook_url','foursquare_url','twitter_url',
				"company_type","registration_no");

		//Generates ['query'] in source
		echo "processing bulk...";
		$time = microtime(true);
		$this->bulkInsert("companies",$insert_columns);
		echo "done (".(microtime(true)-$time)."s)".PHP_EOL;
		
		//Executes the generated ['query'] in source
		echo "executing insert companies query...";
		$time = microtime(true);
		$this->executeSource("companies");
		echo "done (".(microtime(true)-$time)."s)".PHP_EOL;
	
// 		echo "BEFORE current size is : ".sizeof($this->getTableArray("companies")).PHP_EOL;
		//Load inserted companies into array_tables
		$this->_getCurrentCompanies(true);
// 		echo "AFTER current size is : ".sizeof($this->getTableArray("companies")).PHP_EOL;

		

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
				//Preparing `company_location` insert array
				$company_location[] = array(
						"company_id"=>$company['id'],
						"location_type"=>$company['location_type'],
						"street_type_id"=>$company["street_type_id"],
						"street_number"=>$company['street_number'],
						"street"=>$company['street'],
						"neighbourhood"=>$company['neighbourhood'],
						"postcode"=>$company['postcode'],
						"building_no"=>$company['building_no'],
						"entrance"=>$company['entrance'],
						"floor"=>$company['floor'],
						"appartment"=>$company['appartment'],
						"full_address"=>$company['full_address'],
						"address_info"=>$company['address_info'],
						"latitude"=>$company['latitude'],
						"longitude"=>$company['longitude'],
						"is_active"=>1,
						"created_at"=>date("Y-m-d H:i:s")
				);
				//Preparing `company_translation` insert array
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
	
				//Preparing `page` insert array
				$page_table[] = array(
						"foreign_id" => $company['id'],
						"is_public"=>1,
						"country_id"=>$this->_countryId,
						"type"=>2,
						"url_alias"=>"",
						"created_at"=>date("Y-m-d H:i:s")
				);
			}
			
			//Generate & Execute related tables bulk queries
	
			$bulk = $this->_bulkInsert(
					$classifications,
					"company_classification",
					array_keys(current($classifications)));
			$this->executeBulk($bulk);
	
			$bulk = $this->_bulkInsert(
					$company_location,
					"company_location",
					array_keys(current($company_location)));
			$this->executeBulk($bulk);
	
			$bulk = $this->_bulkInsert(
					$company_translation,
					"company_translation",
					array_keys(current($company_translation)));
			$this->executeBulk($bulk);
	
			$bulk = $this->_bulkInsert(
					$page_table,
					"page",
					array_keys(current($page_table)));
			$this->executeBulk($bulk);
	
			//Updates location_id in `company` table
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
	  		$tmp_arr['id'] = '"'.$mmcompany['id'].'"';
	  		$tmp_arr['title'] = '"'.$mmcompany['title'].'"';
	  		$tmp_arr['city'] = '"'.$mmcompany['city'].'"';
	  		echo implode(",",$tmp_arr).PHP_EOL;
	  	}
			
// 		  	var_dump($this->getSourceData("companies"),$this->getSourceDataCount("companies"));
		die;
	}
}
