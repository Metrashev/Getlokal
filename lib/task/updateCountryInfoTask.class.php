<?php

// Exec: php symfony task:importCountriesTask 
class updateCountryInfoTask extends sfBaseTask {
    
    protected function configure() {
        mb_internal_encoding("UTF-8");
        
        $this->addArguments(array());

        $this->addOptions(array (
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'))
        );
        $this->namespace = 'update';
        $this->name = 'country-info';
        $this->briefDescription = 'Update country database';
        $this->detailedDescription = <<<EOF
Update country db
EOF;
    }

    protected function execute($arguments = array(), $options = array())
    {
        
        $databaseManager = new sfDatabaseManager ( $this->configuration );
        $connection = $databaseManager->getDatabase ( $options ['connection'] ? $options ['connection'] : null )->getConnection ();
        $connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );
        
        $connection->query('SET FOREIGN_KEY_CHECKS=0');

        $row_county = Doctrine_Query::create()
            ->select('MAX(id)')
            ->from('County')
            ->fetchOne();

        $last_county_id = $row_county['MAX'];
        
        $row_city = Doctrine_Query::create()
            ->select('MAX(id)')
            ->from('City')
            ->fetchOne();

        $last_city_id = $row_city['MAX'];
        
        $i=0;
        $city_name = $country_name = $county_name = '';

        echo PHP_EOL;

        $handle = fopen(sfConfig::get('sf_web_dir') .'/google_capitals.csv', 'r');
        $k=0;
        while(! feof($handle)){
            $city_name = $country_name = $county_name = '';
            $k++;
          //  if($k==10){
            //    exit();
          //  }

            $data = fgetcsv($handle);
            $city_name = $data[1];
            $country_name = $data[0];
            
            $search_sql = Doctrine_Query::create()
                        ->select('c.*')
                        ->from('Country c')
                        ->where('c.name_en = ?', $country_name)
                        ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                        ->limit(1)
                        ->execute();

            if(count($search_sql)>0){
                $country_id =  $search_sql[0]['id'];
                $country_lang = $search_sql[0]['slug'];
            }
            else{
                $search_sql = Doctrine_Query::create()
                    ->select('c.*')
                    ->from('Country c')
                    ->where('c.name_en = ?', $data[2])
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->limit(1)
                    ->execute();
                if(count($search_sql)>0){
                    $country_id =  $search_sql[0]['id'];
                    $country_lang = $search_sql[0]['slug'];
                }
                else{
                    $search_sql = Doctrine_Query::create()
                        ->select('c.*')
                        ->from('Country c')
                        ->where('c.name_en LIKE "%?%"', $country_name)
                        ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                        ->limit(1)
                        ->execute();
                }
                if(count($search_sql)>0){
                    $country_id =  $search_sql[0]['id'];
                    $country_lang = $search_sql[0]['slug'];
                }
                else{
                    $search_sql = Doctrine_Query::create()
                        ->select('c.*')
                        ->from('Country c')
                        ->where('c.name_en LIKE "%?%"', $data[2])
                        ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                        ->limit(1)
                        ->execute();
                }
                if(count($search_sql)>0){
                    $country_id =  $search_sql[0]['id'];
                    $country_lang = $search_sql[0]['slug'];
                }
            }
            $con_county = Doctrine::getConnectionByTableName('country');
            $con_county->execute('UPDATE country SET name_en="'.$country_name.'" WHERE id='.$country_id.';');
            echo 'Updated country: id->'.$country_id.' name_en -> '.$country_name.PHP_EOL;

            $search_city = Doctrine_Query::create()
                    ->select('c.id')
                    ->from('City c')
                    ->innerJoin('c.Translation ct')
                    ->where('ct.name = ?', $city_name)
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->limit(1)
                    ->execute();

            if(count($search_city)>0){
                $city_id =  $search_city[0]['id'];
            }
            else{
                $city_id =  '';
            }
            
            if(!isset($city_id) || $city_id =='' || $city_id===false){
                $last_city_id++;
                $url = 'http://maps.googleapis.com/maps/api/geocode/xml?address='.str_replace(' ','+',$city_name).','.str_replace(' ','+',$country_name).'&sensor=false&language=en';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		$geo_contents = curl_exec($ch);
		curl_close($ch);
		
		$geo_contents = simplexml_load_string($geo_contents);


                $city_lat = (double)$geo_contents->result[0]->geometry->location->lat;
                $city_lng = (double)$geo_contents->result[0]->geometry->location->lng;
                $county_name = (string)$geo_contents->result[0]->address_component[1]->long_name;
                
                
                
                $url_local = 'http://maps.googleapis.com/maps/api/geocode/xml?address='.str_replace(' ','+',$city_name).','.str_replace(' ','+',$country_name).'&sensor=false&language='.$country_lang;
		
		$ch_local = curl_init();
		curl_setopt($ch_local, CURLOPT_URL, $url_local);
		curl_setopt($ch_local, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch_local, CURLOPT_CONNECTTIMEOUT, 0);
		$geo_contents_local = curl_exec($ch_local);
		curl_close($ch_local);
		
		$geo_contents_local = simplexml_load_string($geo_contents_local);


                $county_name_local = (string)$geo_contents_local->result[0]->address_component[1]->long_name;
                $city_name_local = (string)$geo_contents_local->result[0]->address_component[0]->long_name;
                
                
                
                $search_county = Doctrine_Query::create()
                    ->select('co.id')
                    ->from('County co')
                    ->innerJoin('co.Translation cot')
                    ->where('cot.name = ?', $county_name)
                    ->orWhere('cot.name = ?', $county_name_local)
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->limit(1)
                    ->execute();

                if(count($search_county)>0){
                    $county_id =  $search_sql[0]['id'];
                }
                else{
                    $last_county_id++;

                    if(isset($county_name) && $county_name != '' && $county_name !=null){
                        if($county_name_local =='' || $county_name_local===null){
                            $county_name_local=$county_name;
                        }
                        if($county_name =='Argentina'){
                            $county_name_local=$county_name;
                        }
                        if($county_name ==''){
                            $county_name=$country_name;
                            $county_name_local=$county_name;
                        }
                        $con_county = Doctrine::getConnectionByTableName('county');
                        $con_county->execute('INSERT INTO county(id, country_id, slug) VALUES ('.$last_county_id.', '.$country_id.', "'.$this->cleanSlugString($county_name).'");');
                        $con_county_tr = Doctrine::getConnectionByTableName('county_translation');
                        $con_county_tr->execute('INSERT INTO county_translation(id, name, lang) VALUES ('.$last_county_id.', "'.$county_name_local.'", "'.$country_lang.'"), ('.$last_county_id.', "'.$county_name.'", "en");');
                        
                        echo 'Imported County: id->'.$last_county_id.' | name->'.$county_name.PHP_EOL;
                        $county_id = $last_county_id;
                    }
                    
                }
                if($city_name_local =='' || $city_name_local ===null){
                    $city_name_local = $city_name;
                }
                if($city_name == 'Buenos Aires'){
                    $city_name_local =$city_name;
                }
                $con_city = Doctrine::getConnectionByTableName('city');
                $con_city->execute('INSERT INTO city(id, slug, county_id, is_default, lat, lng, old_id) VALUES ('.$last_city_id.', "'.$this->cleanSlugString($city_name).'", '.$county_id.', 1, "'.$city_lat.'", "'.$city_lng.'", 0 );');

                $con_city_tr = Doctrine::getConnectionByTableName('city_translation');
                $con_city_tr->execute('INSERT INTO city_translation(id, name, lang) VALUES ('.$last_city_id.', "'.$city_name_local.'", "'.$country_lang.'"), ('.$last_city_id.', "'.$city_name.'", "en");');

                echo 'Imported City: id->'.$last_city_id.' | City name->'.$city_name.' | lat->'.$city_lat.' | lng->'.$city_lng.PHP_EOL;

            }

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

}
