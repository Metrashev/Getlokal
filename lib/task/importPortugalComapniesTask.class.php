<?php

// Exec: php symfony task:importCountriesTask 
class importPortugalCompaniesTask extends sfBaseTask {
    
    protected function configure() {
        mb_internal_encoding("UTF-8");

        $this->addArguments(array(
            new sfCommandArgument('application', sfCommandArgument::OPTIONAL, 'Application', 'frontend')
          ));

        $this->addOptions(array (
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'))
        );
        $this->namespace = 'import';
        $this->name = 'portugal-companies';
        $this->briefDescription = 'Import Portugal companies, cities and counties from file';
        $this->detailedDescription = <<<EOF
Import new companies
EOF;
    }

    protected function execute($arguments = array(), $options = array())
    {
        $this->getCon();
        $this->createContext();
        
        sfContext::getInstance()->getUser()->setCulture('pt');
        
        $databaseManager = new sfDatabaseManager ( $this->configuration );
        $connection = $databaseManager->getDatabase ( $options ['connection'] ? $options ['connection'] : null )->getConnection ();
        $connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );
        
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        $arCurrentCounties = array();
        $arCurrentCities = array();
        
        $db_counties = Doctrine_Query::create()
            ->select('co.id, co.slug, cotr.name')
            ->from('County co')
            ->innerJoin('co.Translation cotr')
            ->where('co.country_id = 180')
            ->fetchArray();
        
        foreach($db_counties as $county){
            foreach($county['Translation'] as $county_trans){
                $countyName = $county_trans['name'];
                $countyName = str_ireplace('district', '', $countyName);
                $countyName = trim($countyName);
                $arCurrentCounties[$countyName]=$county_trans['id'];
            }
        }
        
        $db_cities = Doctrine_Query::create()
            ->select('c.id, c.slug, cit.name')
            ->from('City c')
            ->innerJoin('c.Translation cit')
            ->innerJoin('c.County co')
            ->where('co.country_id = 180')
            ->fetchArray();
        foreach($db_cities as $city){
            foreach($city['Translation'] as $city_trans){
                $cityName = $city_trans['name'];
                $arCurrentCities[$cityName]=$city_trans['id'];
            }
        }
        
        $handle = fopen(sfConfig::get('sf_web_dir') .'/portugal_companies.csv', 'r');
        $k=0;
        
        //var_dump($arCurrentCities);exit();
        $unique_counties = array();
        $unique_cities = array();
        
              
        while(! feof($handle)){
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $city_name = $data[5];
                $county_name = $data[6];
                $csv_id = $data[0];

                if(!array_key_exists($county_name, $arCurrentCounties)){
                    $unique_counties[] = $county_name;
                }
                $flag =false;
                if(!array_key_exists($city_name, $arCurrentCities)){
                    for($p = 0; $p<count($unique_cities); $p++){
                        if($city_name == $unique_cities[$p][0]){
                            $flag =true;
                        }
                    }
                    if($flag ===false){
                        $unique_cities[] = array($city_name, $county_name);
                    }
                }
            }
        }
        fclose($handle);
        if(sizeof($unique_counties)){
            $sql_counties ="INSERT INTO county(country_id, slug) VALUES ";  
            foreach($unique_counties as $county){
                $countySlug = $this->cleanSlugString($county);
                $countyBySlug[$countySlug] = $county;
                $sql_counties .= "(180, '$countySlug'),";            
            }

            $sql_counties = trim($sql_counties);
            $sql_counties = trim($sql_counties, ',').";";
            $con_county = Doctrine::getConnectionByTableName('county');
            $con_county->execute($sql_counties);
            
            $db_counties = Doctrine_Query::create()
                ->select('co.id, co.slug')
                ->from('County co')
                ->where('co.country_id = 180')
                ->fetchArray();
            $sql_county_tr = "INSERT INTO county_translation(id, name, lang) VALUES ";
            foreach ($db_counties as $currentCounty){
                if(key_exists($currentCounty['slug'], $countyBySlug)){
                    $id = $currentCounty['id'];
                    $name = $countyBySlug[$currentCounty['slug']];
                    $lang = 'pt';
                    $sql_county_tr .="($id, '$name', '$lang'),";
                }
            }

            $sql_county_tr = trim($sql_county_tr);
            $sql_county_tr = trim($sql_county_tr, ',').";";
            $con_county_tr = Doctrine::getConnectionByTableName('county_translation');
            $con_county_tr->execute($sql_county_tr);
            
           
            $db_counties = Doctrine_Query::create()
                ->select('co.id, co.slug, cotr.name')
                ->from('County co')
                ->innerJoin('co.Translation cotr')
                ->where('co.country_id = 180')
                ->fetchArray();
            foreach($db_counties as $county){
                foreach($county['Translation'] as $county_trans){
                    $countyName = $county_trans['name'];
                    $countyName = str_ireplace('district', '', $countyName);
                    $countyName = trim($countyName);
                    $arCurrentCounties[$countyName]=$county_trans['id'];
                }
            }

        }

        if(sizeof($unique_cities)){
            $sql_cities = "INSERT INTO city(slug, county_id, is_default) VALUES ";
            foreach($unique_cities as $city){
                $countyId = $arCurrentCounties[$city[1]];
                $c_slug = $this->cleanSlugString($city[0]);
                $cityBySlug["$c_slug"] = "$city[0]";

                $sql_cities .= "('$c_slug', $countyId, 1),";  
            }

            $sql_cities = trim($sql_cities);
            $sql_cities = trim($sql_cities, ',').";";
            $con_city = Doctrine::getConnectionByTableName('city');
            $con_city->execute($sql_cities);
            
            $db_cities = Doctrine_Query::create()
                ->select('c.id, c.slug')
                ->from('City c')
                ->innerJoin('c.County co')
                ->where('co.country_id = 180')
                ->fetchArray();
            
            $sql_city_tr = "INSERT INTO city_translation(id, name, lang) VALUES ";
            foreach ($db_cities as $currentCity){
                if(key_exists($currentCity['slug'], $cityBySlug)){
                    $id = $currentCity['id'];
                    $slug = $currentCity['slug'];
                    $name = $cityBySlug[$slug];
                    $lang = 'pt';
                    $sql_city_tr .="($id, '$name', '$lang'),";
                }
            }
           

            $sql_city_tr = trim($sql_city_tr);
            $sql_city_tr = trim($sql_city_tr, ',').";";
            
            $city_tr_con = Doctrine::getConnectionByTableName('city_translation');
            $city_tr_con->execute($sql_city_tr);

            $db_cities = Doctrine_Query::create()
                ->select('c.id, c.slug, cit.name')
                ->from('City c')
                ->innerJoin('c.Translation cit')
                ->innerJoin('c.County co')
                ->where('co.country_id = 180')
                ->fetchArray();
            
            foreach($db_cities as $city){
                foreach($city['Translation'] as $city_trans){
                    $cityName = $city_trans['name'];
                    $arCurrentCities[$cityName]=$city_trans['id'];
                }
            }
        }
        
        $db_companies = Doctrine_Query::create()
                    ->select('c.id, c.slug, ct.title')
                    ->from('Company c')
                    ->innerJoin('c.Translation ct')
                    ->where('c.country_id = ?', 180)
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                   // ->limit(1)
                    ->execute();
        
        $external_ids_sql = $db_companies = Doctrine_Query::create()
                    ->select('c.external_id')
                    ->from('Company c')
                    ->where('c.country_id = ?', 180)
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                   // ->limit(1)
                    ->execute();
        
        $external_ids=array();
        
        foreach($external_ids_sql as $id){
            $external_ids[] = $id['external_id'];
        }
         
        $handle = fopen(sfConfig::get('sf_web_dir') .'/portugal_companies.csv', 'r');
        $i=0;
        while(! feof($handle)){
            
//            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){
                $i++;
                $city_id = '';
                $county_id ='';

                $arrCompanyTranslation = array();
                $data = fgetcsv($handle);

                $csv_id = $data[0];
                $title = $data[1];
                $title_en = $data[2];
                $classification_id = $data[3];
                $phone = $data[4];
                $city_name = $data[5];
                $county_name = $data[6];
                $email = $data[7];
                $website_url = $data[8];
                $foursquare_url = $data[9];
                $twitter_url = $data[10];
                $facebook_url = $data[11];
                $facebook_id = $data[12];
                $company_type = $data[13];
                $registration_no = $data[14];
                $location_type = $data[15];
                $street_type_id = $data[16];
                $street_number = $data[17];
                $street = $data[18];
                $neighbourhood = $data[19];
                $building_no = $data[20];
                $entrance = $data[21];
                $floor = $data[22];
                $appartment = $data[23];
                $postcode = $data[24];
                $full_address = $data[25];
                $address_info = $data[26];
                $latitude = $data[27];
                $longitude = $data[28];
                
                $cultures=array('pt', 'en');
                
                if(array_key_exists($city_name, $arCurrentCities)){
                    $city_id = $arCurrentCities[$city_name];
                }

                $sector_query = Doctrine_Query::create()
                    ->select('cl.sector_id')
                    ->from('Classification cl')
                    ->where('cl.id = ?', $classification_id)
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->limit(1)
                    ->execute();

                if(count($sector_query) > 0){
                    $sector_id = $sector_query[0]['sector_id'];
                }
                
                if(!in_array($csv_id, $external_ids)){
                    $company = new Company();
                    foreach($cultures as $culture){
                        sfContext::getInstance()->getUser()->setCulture($culture);
                        if($culture == 'en'){
                            $company->setTitle($this->toLatin($title));
                        }
                        else{
                            $company->setTitle($title);
                        }
                    }
                    
                    $external_ids[]=$csv_id;

                    $company->setExternalId($csv_id);
                    $company->setPhone($phone);
                    $company->setEmail($email);
                    $company->setClassificationId($classification_id);
                    $company->setSectorId($sector_id);
                    $company->setCityId($city_id);
                    $company->setCountryId('180');
                    $company->setStatus('0');
                    $company->setCompanyType($company_type);
                    $company->setWebsiteUrl($website_url);
                    $company->setFacebookUrl($facebook_url);
                    $company->setFoursquareUrl($foursquare_url);
                    $company->setTwitterUrl($twitter_url);
                    $company->setRegistrationNo($registration_no);
                    $company->setFacebookId($facebook_id);
                    $company->save();

                    $company_location = new CompanyLocation();
                    $company_location->setCompanyId($company->getId());
                    $company_location->setLocationType($location_type);
                    $company_location->setStreetTypeId($street_type_id);
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

                    echo 'New Comlpany: id->'.$company->getId().'  |  Name->'.$company->getTitle().PHP_EOL;
                }
                else{
                    echo 'Found Company: external_id->'.$csv_id.PHP_EOL;
                }

//            }
        }

        fclose($handle);

        $connection->query('SET FOREIGN_KEY_CHECKS=1');
        
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
                            'Ž '=> 'Z',
                            'ž' => 'z',
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
                            'I' => 'I',
                            'i' => 'i',
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

	//	echo $result; exit();
        return $result;
    }
    
    protected function getCompanySlug($title)
    {
        $check_slug = array();
	$slug = $this->cleanSlugString($title);
        
        
        $this->company = Doctrine_Query::create()
                ->from('Company c')
                ->where("slug REGEXP '^{$slug}(-[0-9]*)?$'")
                ->execute();

	$slugCount = count( $this->company);

	return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }
    
    protected function array_value_recursive($key, array $arr)
    {
        $val = array();
        array_walk_recursive($arr, function($v, $k) use($key, &$val){
            if($k == $key) array_push($val, $v);
        });
        return count($val) > 1 ? $val : array_pop($val);
    }
    protected function getCon()
    {
        static $con = null;
        if (!is_null($con)){
            return $con;
        }

        date_default_timezone_get('Europe/Bucharest');
        $dm = new sfDatabaseManager($this->configuration);

        $con = $dm->getDatabase('doctrine')->getConnection();
        $con->setAttribute(Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true);
        return $con;
    }

    protected function createContext()
    {
      // var_dump($this->configuration); die;
      sfContext::createInstance($this->configuration);
    }

}
