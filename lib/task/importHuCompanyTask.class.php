<?php

class importHuCompaniesTask extends sfBaseTask
{
    protected $arCurrentCities=array();
    
    protected function configure()
    {
        $this->addArguments(array());

        $this->addOptions(array (
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'))
        );

        $this->namespace = 'import';
        $this->name = 'hu-companies';
        $this->briefDescription = 'Import hungarian companies';
        $this->detailedDescription = <<<EOF
[php symfony import:hu-companies] 
EOF;
    }

    protected function execute($arguments = array(), $options = array())
    {
        mb_internal_encoding("UTF-8");
        $databaseManager = new sfDatabaseManager ( $this->configuration );
        $connection = $databaseManager->getDatabase ( $options ['connection'] ? $options ['connection'] : null )->getConnection ();
        $connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );

        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        $this->createContext();

        unlink(sfConfig::get('sf_web_dir').'/skipped_companies.csv');
        $arCurrentCompanies = array();
        $cultures = array('hu', 'en');
         
        $db_cities = Doctrine_Query::create()
            ->select('city.id, city.slug')
            ->from('City city')
            ->innerJoin('city.County co')
            ->where('co.country_id = 104')
            ->fetchArray();
        
        foreach($db_cities as $city){
            $citySlug = $city['slug'];
            $this->arCurrentCities[$citySlug]=$city['id'];
        }
        
        $db_companies = Doctrine_Query::create()
            ->select('c.external_id')
            ->from('Company c')
            ->where('c.country_id = 104')
            ->fetchArray();
        
        foreach($db_companies as $company){
            $ext_id= $company['external_id'];
            $arCurrentCompanies[$company['id']]=$ext_id;
        }
        
        $sector_query = Doctrine_Query::create()
	        ->select('cl.sector_id, cl.id')
	        ->from('Classification cl')
	        ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
	        ->execute();
        foreach($sector_query as $sector){
        	$arSectors[$sector['id']] = $sector['sector_id'];
        }

        $file = fopen(sfConfig::get('sf_web_dir') . "/companies_hu_3th.csv", "r");
	$k = $j = $i = 0;
        
        
	gc_enable();
        while (($array = fgetcsv($file, 1000, ";")) !== FALSE) {
            

            $city_id = '';

            $company_title = $array[0];
            $company_title_en = $array[1];
            $classification_id = $array[2];
            $phone = $array[3];
            $city_name = $array[4];
            $postcode = $array[5];
            $full_address = trim($array[6],' .');
            $street = $array[7];
            $street_number = trim($array[8], ' .');
            $county_name = $array[9];
            $location_type = $array[10];
            $street_type = $array[11];
            $neighbourhood = $array[12];
            $building_no = $array[13];
            $entrance = $array[14];
            $floor = $array[15];
            $appartment = $array[16];
            $address_info = $array[17];
            $email = $array[18];
            $website_url = $array[19];
            $foursquare_url = $array[20];
            $twitter_url = $array[21];
            $facebook_url = $array[22];
            $company_type = $array[23];
            
            //external_id is the registration_no in the file
            $external_id = $array[24];

            $latitude = $array[25];
            $longitude = $array[26];
            

            $sector_id = $arSectors[$classification_id];

            $city_slug_for_check = $this->cleanSlugString($this->toLatin($city_name));

            if(array_key_exists($city_slug_for_check, $this->arCurrentCities)){
                if(!in_array($external_id, $arCurrentCompanies)){

                    $city_id = $this->arCurrentCities[$city_slug_for_check];
                    
                    $company = new Company();
                    
                    foreach($cultures as $culture){
                        sfContext::getInstance()->getUser()->setCulture($culture);

                        switch ($culture){
                            case 'en':
                                $company->setTitle($company_title_en);
                                break;
                            case 'hu':
                                $company->setTitle($company_title);
                                break;
                        }
                    }
                    
                    $company->setExternalId($external_id);
                    $company->setPhone($phone);
                    $company->setEmail($email);
                    $company->setClassificationId($classification_id);
                    $company->setSectorId($sector_id);
                    $company->setCityId($city_id);
                    $company->setCountryId('104');
                    $company->setStatus('0');
                    $company->setCompanyType($company_type);
                    $company->setWebsiteUrl($website_url);
                    $company->setFacebookUrl($facebook_url);
                    $company->setFoursquareUrl($foursquare_url);
                    $company->setTwitterUrl($twitter_url);
                    $company->save();

                    $company_location = new CompanyLocation();
                    $company_location->setCompanyId($company->getId());
                    $company_location->setLocationType($location_type);
                    $company_location->setStreetTypeId($street_type);
                    $company_location->setStreetNumber($street_number);
                    $company_location->setStreet($street);
                    $company_location->setNeighbourhood($neighbourhood);
                    $company_location->setBuildingNo($building_no);
                    $company_location->setEntrance($entrance);
                    $company_location->setFloor($floor);
                    $company_location->setAppartment($appartment);
                    $company_location->setPostcode($postcode);
                    $company_location->setFullAddress($full_address);
                    $company_location->setAddressInfo($address_info);
                    $company_location->set('latitude', $latitude);
                    $company_location->set('longitude', $longitude);
                    $company_location->save();

                    $company->setLocationId($company_location->getId());
                    $company->save();
                    
                    $arCurrentCompanies[$external_id] = $company->getId();
                    
                    $company->free();
                    //unset($company);

                    $company_location->free();
                    //unset($company_location);
                    $company = null;
                    $company_location=null;
                    gc_collect_cycles();
                    
                }
                else{
                    echo 'Company exists:  external_id->'.$external_id.PHP_EOL;
                }
            }
            else{
                $city_id = $this->importMissingCities($city_name);
                if($city_id != '' && $city_id !==false ){
                    $company = new Company();

                    foreach($cultures as $culture){
                        sfContext::getInstance()->getUser()->setCulture($culture);

                        switch ($culture){
                            case 'en':
                                $company->setTitle($company_title_en);
                                break;
                            case 'hu':
                                $company->setTitle($company_title);
                                break;
                        }
                    }

                    $company->setExternalId($external_id);
                    $company->setPhone($phone);
                    $company->setEmail($email);
                    $company->setClassificationId($classification_id);
                    $company->setSectorId($sector_id);
                    $company->setCityId($city_id);
                    $company->setCountryId('104');
                    $company->setStatus('0');
                    $company->setCompanyType($company_type);
                    $company->setWebsiteUrl($website_url);
                    $company->setFacebookUrl($facebook_url);
                    $company->setFoursquareUrl($foursquare_url);
                    $company->setTwitterUrl($twitter_url);
                    $company->save();

                    $company_location = new CompanyLocation();
                    $company_location->setCompanyId($company->getId());
                    $company_location->setLocationType($location_type);
                    $company_location->setStreetTypeId($street_type);
                    $company_location->setStreetNumber($street_number);
                    $company_location->setStreet($street);
                    $company_location->setNeighbourhood($neighbourhood);
                    $company_location->setBuildingNo($building_no);
                    $company_location->setEntrance($entrance);
                    $company_location->setFloor($floor);
                    $company_location->setAppartment($appartment);
                    $company_location->setPostcode($postcode);
                    $company_location->setFullAddress($full_address);
                    $company_location->setAddressInfo($address_info);
                    $company_location->set('latitude', $latitude);
                    $company_location->set('longitude', $longitude);
                    $company_location->save();

                    $company->setLocationId($company_location->getId());
                    $company->save();

                    $arCurrentCompanies[$external_id] = $company->getId();
                    
                    $company->free();
                    //unset($company);
                    $company_location->free();
                    //unset($company_location);
                    $company = null;
                    $company_location=null;
                    gc_collect_cycles();
                    
                }
                else{
                    $this->saveScippedCompanies($array);
                    echo 'Company not imported: Company external_id->'.$external_id.'  |  City not found: City Name->'.$city_name.PHP_EOL;
                    echo 'Company details written in the file "skipped_companies.csv"'.PHP_EOL;
                    echo PHP_EOL;
                }
            }
        }
        
    }

    protected function cleanSlugString($slugString)
    {
        $cleanSlug = strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $this->replaceDiacritics($slugString)));
        return $cleanSlug;
    }

    
    protected function toLatin($str)
    {
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
                            'ǿ' => 'o'
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
    
    protected function createContext()
    {
      // var_dump($this->configuration); die;
      sfContext::createInstance($this->configuration);
    }
    protected function importMissingCities($city_name){
        
        
        $url = 'http://maps.googleapis.com/maps/api/geocode/xml?address='.str_replace(' ', '+',$city_name).'+Hungary&sensor=false&language=en';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        $geo_contents = curl_exec($ch);
        curl_close($ch);

        $geo_contents = simplexml_load_string($geo_contents);
        
        //print_r($geo_contents);exit();

        for($i=0; $i<count($geo_contents->result->address_component); $i++){
            if($geo_contents->result->address_component[$i]->type[0] == 'administrative_area_level_1'){
                //$city_name_en = (string)$content->address_component[0]->long_name;
                $county = (string)$geo_contents->result->address_component[$i]->long_name;
                $county_name =  trim(str_ireplace('county', '', $county));
                break;
            }
        }

        $searchedCounty = Doctrine::getTable('County')->findOneBy('slug',$this->cleanSlugString($county_name));
        if(!sizeof($searchedCounty)){
            $searchedCounty = Doctrine::getTable('County')->findOneBy('slug',$this->cleanSlugString($county));
        }
        if(sizeof($searchedCounty) && $searchedCounty !==false){

            $county_id = $searchedCounty->getId();
            if($county_id && $county_id !=''){
                $city_lat = (double)$geo_contents->result->geometry->location->lat;
                $city_lng = (double)$geo_contents->result->geometry->location->lng;
                $cultures = array('hu','en');
                
                $city = new City();
                foreach($cultures as $culture){
                    sfContext::getInstance()->getUser()->setCulture($culture);

                    switch ($culture){
                        case 'en':
                            $city->setName($city_name);
                            break;
                        case 'hu':
                            $city->setName($city_name);
                            break;
                    }
                }
                $city->setCountyId($county_id);
                $city->setSlug($this->cleanSlugString($this->toLatin($city_name)));
                $city->setLat($city_lat);
                $city->setLng($city_lng);
                $city->save();

                $this->arCurrentCities[$city->getSlug()]=$city->getId();
                
                $city_id = $city->getId();
                
                $city->free();
                unset($city);
                $city=null;
                
                return $city_id;
                
            }
        }
        else{
            $cultures = array('hu','en');
            
            $new_county = new County();
            foreach($cultures as $culture){
                sfContext::getInstance()->getUser()->setCulture($culture);

                switch ($culture){
                    case 'en':
                        $new_county->setName($county_name);
                        break;
                    case 'hu':
                        $new_county->setName($county_name);
                        break;
                }
            }
            $new_county->setCountryId('104');
            $new_county->setSlug($this->cleanSlugString($this->toLatin($county_name)));
            $new_county->save();
            
            $city_lat = (double)$geo_contents->result->geometry->location->lat;
            $city_lng = (double)$geo_contents->result->geometry->location->lng;

            $city = new City();
            foreach($cultures as $culture){
                sfContext::getInstance()->getUser()->setCulture($culture);

                switch ($culture){
                    case 'en':
                        $city->setName($city_name);
                        break;
                    case 'hu':
                        $city->setName($city_name);
                        break;
                }
            }
            $city->setCountyId($new_county->getId());
            $city->setSlug($this->cleanSlugString($this->toLatin($city_name)));
            $city->setLat($city_lat);
            $city->setLng($city_lng);
            $city->save();

            $this->arCurrentCities[$city->getSlug()]=$city->getId();
            
            $city_id = $city->getId();
            
            $city->free();
            unset($city);
            $city=null;

            $new_county->free();
            unset($new_county);
            $new_county=null;
            
            return $city_id;
        }
    }
    protected function saveScippedCompanies($info_array)
    {
        $fh = fopen(sfConfig::get('sf_web_dir') .'/skipped_companies.csv', 'a');
        fputcsv($fh, $info_array, ';', '"');
        fclose($fh);
    }
}
