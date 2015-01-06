<?php

class importNewCitiesTask extends sfBaseTask {
    
    protected function configure() {
        mb_internal_encoding("UTF-8");
        
        $this->addArguments(array());

        $this->addOptions(array (
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'))
        );
        $this->namespace = 'import';
        $this->name = 'NewCities';
        $this->briefDescription = 'Import new citis for add company campaign';
        $this->detailedDescription = <<<EOF
Import new cities in Slovenia, Italy and Sweden
EOF;
    }

    protected function execute($arguments = array(), $options = array())
    {
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    $connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );

    $connection->query('SET FOREIGN_KEY_CHECKS=0');

        $row_county = Doctrine_Query::create()
            ->select('MAX(id)')
            ->from('County')
            ->fetchOne();
        
        $row_city = Doctrine_Query::create()
            ->select('MAX(id)')
            ->from('City')
            ->fetchOne();

	$cities = fopen(sfConfig::get('sf_web_dir') . "/add_company_cities.csv", "r");
		$k = $j =0;
        while(! feof($cities)){
            //$found_flag = false;
            $county_id = '';
            
            $array = fgetcsv($cities);
            $city_name = $array[0];
            $city_name_en = $array[1];
            $county_name_en = $array[2];
            $lat = $array[3];
            $lng = $array[4];
            $country_id = $array[5];

            switch ($country_id) {
                case '113':
                    $lang = 'it';
                    break;
                case '203':
                    $lang = 'si';
                    break;
                case '215':
                    $lang = 'se';
                    break;
            }

            $found_flag_county = false;

            $county = Doctrine_Query::create()
                ->select('cot.*')
                ->from('CountyTranslation cot')
                ->where('cot.name = ?', $county_name_en)
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->limit(1)
                ->execute();

            if(count($county) == 0){
                $j++;

                $county = new County();
                $county->setName($county_name_en);
                $county->setCountryId($country_id);
                $county->setSlug(CountyTable::slugify($county_name_en));
                $county->setName($county_name_en);
                $county->setLang('en');
                $county->save();

                $county_id = $county->getId();
            }
            elseif(isset($county['']['id']) && $county['']['id'] !=''){
                $county_id = $county['']['id'];
            }
            elseif(isset($county['en']['id']) && $county['en']['id'] !=''){
                $county_id = $county['en']['id'];
            }

            $db_cities = Doctrine_Query::create()
                ->select('ct.*')
                ->from('CityTranslation ct')
                ->where('ct.name = ?', $city_name_en)
                ->orWhere('ct.name = ?', $city_name)
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->limit(1)
                ->execute();
            
            if(count($db_cities)==0){
                $k++;
            
                $city = new City();
                $city->setCountyId($county_id);
                $city->setLat($lat);
                $city->setLng($lng);
                $city->setSlug(CityTable::slugify($city_name));
                $city->save();

                $con = Doctrine::getConnectionByTableName('city_translation');
                $con->execute('INSERT INTO `city_translation`(`id`, `name`, `lang`) VALUES ("'.$city->getId().'", "'.$city_name.'", "'.$lang.'");');
                $con->execute('INSERT INTO `city_translation`(`id`, `name`, `lang`) VALUES ("'.$city->getId().'", "'.$city_name_en.'", "en");');
                
                echo 'Imported cities: '.$city->getId().' '.$city->getName().PHP_EOL;
            }

	}
        fclose($cities);
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

}
