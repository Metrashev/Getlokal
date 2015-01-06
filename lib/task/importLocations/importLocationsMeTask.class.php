<?php

class importLocationsMeTask extends sfBaseTask
{
	protected $_countryId = 151;
	
	protected $_localLaguage = "me";
	/*
	 * COLUMN INDEX SETTINGS
	 * set up on witch column is the information you need, if the information is not present set the field on -1 
	 * 
	 * */
	protected $_iCityName = 0;
	protected $_iCityLat = 4;
	protected $_iCityLang = 5;
	protected $_iCityExternalId = 1;
	protected $_iCityCountyExternalId = 3;
	protected $_iCityCountyName = -1;
	
	protected $_iCountyName = 0;
	protected $_iCountyLat = -1;
	protected $_iCountyLang = -1;
	protected $_iCountyExternalId = 1;
	
	protected $_skipFirstCity = true;
	protected $_skipFirstCounty = true;
	
	protected function configure(){
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
		$this->name             = 'LocationMe';		
		
		$this->settings['source']['cities'] = sfConfig::get('sf_web_dir') . "/sources/montenegro/montenegro_locations_with_ids_cities.csv";
		$this->settings['source']['counties'] = sfConfig::get('sf_web_dir') . "/sources/montenegro/montenegro_locations_with_ids_counties.csv";
		
	}
	
	protected function execute($arguments = array(), $options = array()){
		mb_internal_encoding("UTF-8");
		// initialize the database connection
		$this->_databaseManager = new sfDatabaseManager ( $this->configuration );
        $this->_connection = $this->_databaseManager->getDatabase ( $options ['connection'] ? $options ['connection'] : null )->getConnection ();
		if(is_array($this->settings['source']) && sizeof($this->settings['source']) > 1){
			$this->_counties = $this->_csvToArray($this->settings['source']['counties']);
			$this->_handleCounties(); 
						
			$this->_cities = $this->_csvToArray($this->settings['source']['cities']);
			$this->_handleCities();					
		}
	}  
	
	protected function _handleCounties(){
		echo "INSERTING COUNTIES ...".PHP_EOL;
		$skipFirstCounty = $this->_skipFirstCounty;
		$table = 'county';
		$columns = array('country_id', 'slug', 'external_id');
		$this->_getCurrentCounties();
		$insertData = array();
		$arNames = array();
		$data = array();
		foreach($this->_counties as $county){
			$countyData = array();
			if($skipFirstCounty){
				$skipFirstCounty = false;
				continue;
			}
			$newName = $county[$this->_iCountyName];
			if(in_array($newName, $arNames)){
				continue;
			}
			$newSlug = $this->getSlug($newName);
			$newExternalId = $this->_iCountyExternalId > -1 ? $county[$this->_iCountyExternalId] : '';
			
			$arNames[] = $newName;
			
			$countyData['country_id'] = $this->_countryId;
			$countyData['slug'] = $newSlug;
			$countyData['external_id'] = $newExternalId;
			
			$key = $this->_iCountyExternalId > -1 ? $newExternalId : $newSlug;
			//var_dump($this->_currentCounties, $newName, $newSlug, $newExternalId);
			if( !isset($this->_currentCounties['ByName'][$newName]) && !isset($this->_currentCounties['BySlug'][$newSlug]) && (!isset($this->_currentCounties['ByExtId'][$newExternalId]) || $newExternalId == '') ){
				$insertData[$key] = $countyData;
			}
			$countyData['name'] = $newName;
			$allDataSlug[$newSlug] = $countyData;
			$allDataExId[$newExternalId] = $countyData;
		}		
		if(sizeof($insertData)){
			$bulk = $this->_bulkInsert($insertData, $table, $columns);
			$countyConnection = Doctrine::getConnectionByTableName($table);
			$countyConnection->execute($bulk);					
		}
		echo "INSERTING COUNTIES: DONE (".sizeof($insertData)." inserted counties)".PHP_EOL;
		$this->_handleCountiesTranslation($insertData, $allDataSlug, $allDataExId);
	}
	
	protected function _handleCountiesTranslation($insertData, $allDataSlug, $allDataExId){
		echo "INSERTING COUNTIES TRANSLATIONS ...".PHP_EOL;
		$this->_getCurrentCounties();
		$insertData = array();
		$table = 'county_translation';
		$columns = array('id', 'name', 'lang');
		foreach ($this->_currentCounties['Data'] as $county){
			if(sizeof($county['Translation']) == 0){
				if($this->_iCountyExternalId > -1 && isset($allDataExId[$county['external_id']])){
					$name = $allDataExId[$county['external_id']]['name'];
				}else{
					$name = $allDataSlug[$county['slug']]['name'];
				}
				
				$item['id'] = $county['id'];
				$item['name'] = $name;
				$item['lang'] = $this->_localLaguage;
				$insertData[] = $item;
				
				$itemEn['id'] = $county['id'];
				$itemEn['name'] = $this->toLatin($name);
				$itemEn['lang'] = 'en';
				$insertData[] = $itemEn;
			}
		}
		if(sizeof($insertData)){
			$bulk = $this->_bulkInsert($insertData, $table, $columns);
			$countyConnection = Doctrine::getConnectionByTableName($table);
			$countyConnection->execute($bulk);
		}
		echo "INSERTING COUNTIES TRANSLATIONS: DONE (".sizeof($insertData)." inserted counties names)".PHP_EOL;
	}
	
	protected function _getCurrentCounties(){
		$db_counties = Doctrine_Query::create()
		->select('co.id, 
				co.slug, 
				cotr.name, 
				co.external_id')
		->from('County co')
		->leftJoin('co.Translation cotr')
		->where('co.country_id = '.$this->_countryId)
		->fetchArray();
		$this->_currentCounties['ByName'] = array();
		$this->_currentCounties['BySlug'] = array();
		$this->_currentCounties['ByExtId'] = array();
		
		foreach($db_counties as $county){
			$this->_currentCounties['Data'][$county['id']] = $county;			
			foreach($county['Translation'] as $countyTrans){
				$countyName = $countyTrans['name'];
				$countyName = str_ireplace('district', '', $countyName);
				$countyName = trim($countyName);
				$this->_currentCounties['ByName'][$countyName] = $county['id'];				
			}
			$this->_currentCounties['BySlug'][$county['slug']] = $county['id'];
			$this->_currentCounties['ByExtId'][$county['external_id']] = $county['id'];
			//$arCurrentCountiesById[$county['id']] = $county;
		}		
	}
	
	protected function _handleCities(){
		echo "INSERTING CITIES ...".PHP_EOL;
		$this->_getCurrentCities();
		$this->_getCurrentCounties();
		
		$skipFirstCity = $this->_skipFirstCity;
		$table = 'city';
		$columns = array('slug', 'county_id', 'lat', 'lng', 'external_id');
		$insertData = array();
		$arSlugs = array();
		$data = array();
		foreach($this->_cities as $city){
			$cityData = array();
			if($skipFirstCity){
				$skipFirstCity = false;
				continue;
			}
			$newName = $city[$this->_iCityName];	
			$newSlug = $this->getSlug($newName);
			if(in_array($newSlug, $arSlugs) || isset($this->_currentCities['BySlug'][$newSlug])){	
				$slugUnique = false;	
				$i = 0;		
				while(!$slugUnique){
					$i++;
					$tmpSlug = $newSlug.$i;
					if(!in_array($tmpSlug, $arSlugs) && !isset($this->_currentCities['BySlug'][$tmpSlug])){
						$slugUnique = true;
					}
				}
				$newSlug = $tmpSlug;
			}
			$arSlugs[] = $newSlug;
			$newLang = $city[$this->_iCityLang];
			$newLat = $city[$this->_iCityLat];
			
			
			$newExternalId = $this->_iCityExternalId > -1 ? $city[$this->_iCityExternalId] : '';
			$countyExternalId = $this->_iCityCountyExternalId > -1 ? $city[$this->_iCityCountyExternalId] : '';
			if($countyExternalId != ''){
				$newCountyId = $this->_currentCounties['ByExtId'][$countyExternalId];
			}else{
				$countyName = $city[$this->_iCityCountyName];
				$newCountyId = $this->_currentCounties['ByName'][$countyName];
			}  
			if(isset($this->_currentCities['ByName'][$newName])){
				$cityId = $this->_currentCities['ByName'][$newName];
				$currntCityCountyId = $this->_currentCities['Data'][$cityId]['county_id'];				
			}else{
				$currntCityCountyId = 'none';
			}
			
			$cityData['slug'] = $newSlug;
			$cityData['county_id'] = $newCountyId;
			$cityData['lat'] = $newLat;
			$cityData['lng'] = $newLang;
			$cityData['external_id'] = $newExternalId;
			
			$slugs[] = $newSlug;
			$key = $this->_iCityExternalId > -1 ? $newExternalId : $newSlug;
			if( ( !isset($this->_currentCities['ByName'][$newName]) || ($currntCityCountyId != 'none' && $currntCityCountyId != $newCountyId) ) && (!isset($this->_currentCities['ByExtId'][$newExternalId]) || $newExternalId == '') ){
				$insertData[$key] = $cityData;
			}	
			$cityData['name'] = $newName;
			$allDataSlug[$newSlug] = $cityData;
			$allDataExId[$newExternalId] = $cityData;
		}
		if(sizeof($insertData)){
			$bulk = $this->_bulkInsert($insertData, $table, $columns);
			
			$cityConnection = Doctrine::getConnectionByTableName($table);
			if(is_array($bulk)){
				foreach ($bulk as $query){
					$cityConnection->execute($query);
				}	
			}else{
				$cityConnection->execute($bulk);
			}
		}
		echo "INSERTING CITIES: DONE (".sizeof($insertData)." inserted cities)".PHP_EOL;
		$this->_handleCitiesTranslation($insertData, $allDataSlug, $allDataExId);
	}
	
	protected function _handleCitiesTranslation($insertData, $allDataSlug, $allDataExId){
		echo "INSERTING CITIES TRANSLATIONS ...".PHP_EOL;
		$this->_getCurrentCities();
		$insertData = array();
		$table = 'city_translation';
		$columns = array('id', 'name', 'lang');
		foreach ($this->_currentCities['Data'] as $city){
			if(is_null($city['name']) || $city['name'] == ''){
				if($this->_iCityExternalId > -1 && isset($allDataExId[$city['external_id']])){
					$name = $allDataExId[$city['external_id']]['name'];
				}else{
					$name = $allDataSlug[$city['slug']]['name'];
				}
				
				$item['id'] = $city['id'];
				$item['name'] = $name;
				$item['lang'] = $this->_localLaguage;
				$insertData[] = $item;
				
				$itemEn['id'] = $city['id'];
				$itemEn['name'] = $this->toLatin($name);
				$itemEn['lang'] = 'en';
				$insertData[] = $itemEn;
			}
		}
		//var_dump($insertData);
		if(sizeof($insertData)){
			$bulk = $this->_bulkInsert($insertData, $table, $columns);
			$cityConnection = Doctrine::getConnectionByTableName($table);
			if(is_array($bulk)){
				foreach ($bulk as $query){
					$cityConnection->execute($query);
				}	
			}else{
				$cityConnection->execute($bulk);
			}
		}
		echo "INSERTING CITIES TRANSLATIONS: DONE (".sizeof($insertData)." inserted cities names)".PHP_EOL;
	}
	
	protected function _getCurrentCities(){
		$sql = "SELECT 
					c.id,
					c.slug,
					c.external_id,
					c.county_id, 
					ct.name
				FROM `city` c 
				JOIN county cn
				ON cn.id=c.county_id
				LEFT JOIN city_translation ct
				ON ct.id=c.id
				WHERE cn.country_id=".$this->_countryId;
		$currentCities = $this->_connection->prepare($sql);
		$currentCities->execute();
		$this->_currentCities['ByName'] = array();
		$this->_currentCities['BySlug'] = array();
		$this->_currentCities['ByExtId'] = array();
		
		while ($city = $currentCities->fetch()) {
			$this->_currentCities['Data'][$city['id']] = $city;
			
			$this->_currentCities['ByName'][$city['name']] = $city['id'];
			$this->_currentCities['BySlug'][$city['slug']] = $city['id'];
			$this->_currentCities['ByExtId'][$city['external_id']] = $city['id'];		
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////
	protected function _csvToArray($source){
		$result = array();
		if (($handle = fopen($source, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$result[] = $data;
			}
			fclose($handle);
		}
		return $result;
	}
	
	protected function _bulkInsert($data, $table = null, $columns = null, $limit = null){
		$recordset = array();
		$values = array();
		$queries = array();
		$queryFirst = "";
		if(is_null($limit)){
			$limit = 1000;
		}
		if(!is_null($table) && !is_null($columns)){
			sort($columns);
			$keys = "`".implode('`,`', $columns)."`";
			$queryFirst = "INSERT INTO `$table` ($keys) VALUES ";
		}
		$count = 1;
		foreach ($data as $item){
			ksort($item);
			$recordset[] = "( '".implode("', '", $item)."' )";
			if($count % $limit == 0){
				$values[] = $recordset;
				$recordset = array();
			}
			$count++;
		}
		if(sizeof($recordset)){
			$values[] = $recordset;
		}
		foreach ($values as $v){
			$queries[] = $queryFirst."".implode(", ", $v);
		}
		return $queries;
	}
	////////////////////////////////
	private function _escapeSpecialChars($pTerm)
	{
		$from = array ( '\\', '(',')','|','-','!','@','~','"','&', '/', '^', '$', '=' );
		$to   = array ( '\\\\\\', '\\\(','\\\)','\\\|','\\\-','\\\!','\\\@','\\\~','\\\"', '\\\&', '\\\/', '\\\^', '\\\$', '\\\=' );
	
		return str_replace ( $from, $to, $pTerm );
	}
	
	protected function getSlug($string){
		return CityTable::slugify($string);
		//return $this->cleanSlugString($this->toLatin($string));
	}
	
	protected function cleanSlugString($slugString)	{
		$cleanSlug = strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $this->replaceDiacritics($slugString)));
		return $cleanSlug;
	}
	
	
	protected function toLatin($str){		
		$theArray = array (
				'à' => 'a',
				'á' => 'a',
				'â' => 'a',
				'ã' => 'a',
				'ä' => 'a',
				'å' => 'a',
				'ā' => 'a',
				'ă' => 'a',
				'ç' => 'c',
				'ć' => 'c',
				'ĉ' => 'c',
				'è' => 'e',
				'é' => 'e',
				'ê' => 'e',
				'ë' => 'e',
				'ì' => 'i',
				'í' => 'i',
				'î' => 'i',
				'ï' => 'i',
				'ò' => 'o',
				'ó' => 'o',
				'ô' => 'o',
				'õ' => 'o',
				'ö' => 'o',
				'ő' => 'o',
				'ù' => 'u',
				'ú' => 'u',
				'û' => 'u',
				'ü' => 'u',
				'ý' => 'y',
				'ÿ' => 'y',
				'Á' => 'A',
				'Å' => 'A',
				'Â' => 'A',
				'Ä' => 'A',
				'À' => 'A',
				'Ã' => 'A',
				'Ā' => 'A',
				'Ă' => 'A',
				'Č' => 'C',
				'Ç' => 'C',
				'Ć' => 'C',
				'Ċ' => 'C',
				'È' => 'E',
				'É' => 'E',
				'Ê' => 'E',
				'Ë' => 'E',
				'Ì' => 'I',
				'Í' => 'I',
				'Î' => 'I',
				'Ï' => 'I',
				'Õ' => 'O',
				'Ö' => 'O',
				'Ò' => 'O',
				'Ó' => 'O',
				'Ô' => 'O',
				'Ő' => 'O',
				'Ø' => 'O',
				'Ù' => 'U',
				'Ú' => 'U',
				'Û' => 'U',
				'Ü' => 'U',
				'Ý' => 'Y',
				'Š' => 'S',
				'š' => 's',
				'Đ' => 'Dj',
				'đ' => 'dj',
				'Ž'=>'Z',
				'ž'=>'z',
				'e' => 'e',
				'E' => 'E',
				'e' => 'e',
				'E' => 'E',
				'e' => 'e',
				'G' => 'G',
				'g' => 'g',
				'G' => 'G',
				'g' => 'g',
				'G' => 'G',
				'g' => 'g',
				'G' => 'G',
				'g' => 'g',
				'H' => 'H',
				'h' => 'h',
				'H' => 'H',
				'h' => 'H',
				'I' => 'I',
				'i' => 'i',
				'I' => 'I',
				'i' => 'i',
				'I' => 'I',
				'i' => 'i',
				'I' => 'I',
				'i' => 'i',
				'I' => 'I',
				'J' => 'J',
				'j' => 'j',
				'K' => 'K',
				'k' => 'k',
				'L' => 'L',
				'l' => 'l',
				'N' => 'N',
				'n' => 'n',
				'N' => 'N',
				'n' => 'n',
				'N' => 'N',
				'n' => 'n',
				'O' => 'O',
				'o' => 'o',
				'O' => 'O',
				'o' => 'o',
				'O' => 'O',
				'o' => 'o',
				'R' => 'R',
				'ŕ' => 'r',
				'Ŗ' => 'R',
				'ŗ' => 'r',
				'Ř' => 'R',
				'ř' => 'r',
				'Ś' => 'S',
				'ś' => 's',
				'Ŝ' => 'S',
				'ŝ' => 's',
				'Ş' => 'S',
				'ş' => 's',
				'Š' => 'S',
				'š' => 's',
				'Ţ' => 'T',
				'ţ' => 't',
				'Ť' => 'T',
				'ť' => 't',
				'Ŧ' => 'T',
				'ŧ' => 't',
				'Ũ' => 'U',
				'ũ' => 'u',
				'Ū' => 'U',
				'ū' => 'u',
				'Ŭ' => 'U',
				'ŭ' => 'u',
				'Ů' => 'U',
				'ů' => 'u',
				'Ű' => 'U',
				'ű' => 'u',
				'Ų' => 'U',
				'ų' => 'u',
				'Ŵ' => 'W',
				'ŵ' => 'w',
				'Ŷ' => 'Y',
				'ŷ' => 'y',
				'Ÿ' => 'Y',
				'Ź' => 'Z',
				'ź' => 'z',
				'Ż' => 'Z',
				'ż' => 'z',
				'Ž' => 'Z',
				'ž' => 'z',
				'ſ' => 'F',
				'ƒ' => 'f',
				'Ơ' => 'O',
				'ơ' => 'o',
				'Ư' => 'U',
				'ư' => 'u',
				'Ǎ' => 'A',
				'ǎ' => 'a',
				'Ǐ' => 'I',
				'ǐ' => 'i',
				'Ǒ' => 'O',
				'ǒ' => 'o',
				'Ǔ' => 'U',
				'ǔ' => 'u',
				'Ǖ' => 'U',
				'ǖ' => 'u',
				'Ǘ' => 'U',
				'ǘ' => 'u',
				'Ǚ' => 'U',
				'ǚ' => 'u',
				'Ǜ' => 'U',
				'ǜ' => 'u',
				'Ǻ' => 'A',
				'ǻ' => 'a',
				'Ǽ' => 'AE',
				'ǽ' => 'ae',
				'Ǿ' => 'o',
				'ǿ' => 'o',				
		);
		$result = $str;
		$result = strtr($result, $theArray);
		
		return $result;
	}
	
	protected function replaceDiacritics($text)
	{
		$from = array("Á", "À", "Â", "Ä", "Ă", "Ā", "Ã", "Å", "Ą", "Æ", "Ć", "Ċ", "Ĉ", "Č", "Ç", "Ď", "Đ", "Ð", "É", "È", "Ė", "Ê", "Ë", "Ě", "Ē", "Ę", "Ə", "Ġ", "Ĝ", "Ğ", "Ģ", "á", "à", "â", "ä", "ă", "ā", "ã", "å", "ą", "æ", "ć", "ċ", "ĉ", "č", "ç", "ď", "đ", "ð", "é", "é", "è", "ė", "ê", "ë", "ě", "ē", "ę", "ə", "ġ", "ĝ", "ğ", "ģ", "Ĥ", "Ħ", "I", "Í", "Ì", "İ", "Î", "Ï", "Ī", "Į", "Ĳ", "Ĵ", "Ķ", "Ļ", "Ł", "Ń", "Ň", "Ñ", "Ņ", "Ó", "Ò", "Ô", "Ö", "Õ", "Ő", "Ø", "Ơ", "Œ", "ĥ", "ħ", "ı", "í", "ì", "i", "î", "ï", "ī", "į", "ĳ", "ĵ", "ķ", "ļ", "ł", "ń", "ň", "ñ", "ņ", "ó", "ò", "ô", "ö", "õ", "ő", "ø", "ơ", "œ", "Ŕ", "Ř", "Ś", "Ŝ", "Š", "Ş", "Ť", "Ţ", "Þ", "Ú", "Ù", "Û", "Ü", "Ŭ", "Ū", "Ů", "Ų", "Ű", "Ư", "Ŵ", "Ý", "Ŷ", "Ÿ", "Ź", "Ż", "Ž", "ŕ", "ř", "ś", "ŝ", "š", "ş", "ß", "ť", "ţ", "þ", "ú", "ù", "û", "ü", "ŭ", "ū", "ů", "ų", "ű", "ư", "ŵ", "ý", "ŷ", "ÿ", "ź", "ż", "ž");
		$to = array("A", "A", "A", "A", "A", "A", "A", "A", "A", "AE", "C", "C", "C", "C", "C", "D", "D", "D", "E", "E", "E", "E", "E", "E", "E", "E", "G", "G", "G", "G", "G", "a", "a", "a", "a", "a", "a", "a", "a", "a", "ae", "c", "c", "c", "c", "c", "d", "d", "d", "e", "e", "e", "e", "e", "e", "e", "e", "e", "g", "g", "g", "g", "g", "H", "H", "I", "I", "I", "I", "I", "I", "I", "I", "IJ", "J", "K", "L", "L", "N", "N", "N", "N", "O", "O", "O", "O", "O", "O", "O", "O", "CE", "h", "h", "i", "i", "i", "i", "i", "i", "i", "i", "ij", "j", "k", "l", "l", "n", "n", "n", "n", "o", "o", "o", "o", "o", "o", "o", "o", "o", "R", "R", "S", "S", "S", "S", "T", "T", "T", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "W", "Y", "Y", "Y", "Z", "Z", "Z", "r", "r", "s", "s", "s", "s", "B", "t", "t", "b", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "w", "y", "y", "y", "z", "z", "z");
	
	
		$cyr  = array('ИЯ','Ия','ия','а','б','в','г','д','е','ж','з','и','й','к','л','м','н','о','п','р','с','т','у',
				'ф','х','ц','ч','ш','щ','ъ','ь', 'ю','я','А','Б','В','Г','Д','Е','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У',
				'Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ь', 'Ю','Я' );
	
		$lat = array( 'IA', 'Ia', 'ia', 'a','b','v','g','d','e','zh','z','i','y','k','l','m','n','o','p','r','s','t','u',
				'f' ,'h' ,'ts' ,'ch','sh' ,'sht' ,'a' ,'y' ,'yu' ,'ya','A','B','V','G','D','E','Zh',
				'Z','I','Y','K','L','M','N','O','P','R','S','T','U',
				'F' ,'H' ,'Ts' ,'Ch','Sh' ,'Sht' ,'A' ,'Y' ,'Yu','Ya' );
	
		$text = str_replace($from, $to, $text);
		$text = str_replace($cyr, $lat, $text);
	
		return $text;
	}
}