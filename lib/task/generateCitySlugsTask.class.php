<?php

// Exec: php symfony task:importCountriesTask 
class generateCitySlugsTask extends sfBaseTask {
    protected function configure() {
        $this->addArguments(array());
        $this->addOptions(array(new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'), new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'), new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine')));

        $this->namespace = 'generate';
        $this->name = 'city-slugs';
        $this->briefDescription = 'Generate city slugs for cities which haven\'t ';
        $this->detailedDescription = <<<EOF
Generate city slugs
EOF;
    }

    protected function execute($arguments = array(), $options = array())
    {
        $databaseManager = new sfDatabaseManager ( $this->configuration );
        $connection = $databaseManager->getDatabase ( $options ['connection'] ? $options ['connection'] : null )->getConnection ();
        $connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );

       $cities = Doctrine_Query::create()
            ->select('c.id, ct.name, co.id, cotr.slug')
            ->from('City c')
            ->innerJoin('c.Translation ct')
            ->innerJoin('c.County co')
            ->innerJoin('co.Country cotr')
            ->where('c.slug = "" OR c.slug IS NULL')
            ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
            ->orderBy('c.id')
            ->execute();

        foreach($cities as $city){
            $city_id = $city['id'];
            $default_lang = $city['County']['Country']['slug'];
            
            foreach($city['Translation'] as $translation){
                if(isset($city['Translation'][$default_lang] ) && $city['Translation'][$default_lang]['name'] != ''){
                    $city_slug = $this->cleanSlugString($city['Translation'][$default_lang]['name']);
                }
                elseif(isset($city['Translation']['en'] ) && $city['Translation']['en']['name'] != ''){
                    $city_slug = $this->cleanSlugString($city['Translation']['en']['name']);
                }
            }
            if($this->cleanSlugString($city_slug) == ''){
                    $city_slug = $city_id;
                }
            echo 'UPDATE city SET slug = "'.$city_slug.'" WHERE id = '.$city_id.';'. PHP_EOL;
                $con = Doctrine::getConnectionByTableName('city');
                $con->execute('UPDATE city SET slug = "'.$city_slug.'" WHERE id = '.$city_id.';');
            
        }
        $con = Doctrine::getConnectionByTableName('city');
        $con->execute('UPDATE city SET slug = LOWER(REPLACE(slug," ", "-"));');

    }


    protected function replaceDiacritics($text)
    {
	$from = array("Á", "À", "Â", "Ä", "Ă", "Ā", "Ã", "Å", "Ą", "Æ", "Ć", "Ċ", "Ĉ", "Č", "Ç", "Ď", "Đ", "Ð", "É", "È", "Ė", "Ê", "Ë", "Ě", "Ē", "Ę", "Ə", "Ġ", "Ĝ", "Ğ", "Ģ", "á", "à", "â", "ä", "ă", "ā", "ã", "å", "ą", "æ", "ć", "ċ", "ĉ", "č", "ç", "ď", "đ", "ð", "é", "è", "ė", "ê", "ë", "ě", "ē", "ę", "ə", "ġ", "ĝ", "ğ", "ģ", "Ĥ", "Ħ", "I", "Í", "Ì", "İ", "Î", "Ï", "Ī", "Į", "Ĳ", "Ĵ", "Ķ", "Ļ", "Ł", "Ń", "Ň", "Ñ", "Ņ", "Ó", "Ò", "Ô", "Ö", "Õ", "Ő", "Ø", "Ơ", "Œ", "ĥ", "ħ", "ı", "í", "ì", "i", "î", "ï", "ī", "į", "ĳ", "ĵ", "ķ", "ļ", "ł", "ń", "ň", "ñ", "ņ", "ó", "ò", "ô", "ö", "õ", "ő", "ø", "ơ", "œ", "Ŕ", "Ř", "Ś", "Ŝ", "Š", "Ş", "Ť", "Ţ", "Þ", "Ú", "Ù", "Û", "Ü", "Ŭ", "Ū", "Ů", "Ų", "Ű", "Ư", "Ŵ", "Ý", "Ŷ", "Ÿ", "Ź", "Ż", "Ž", "ŕ", "ř", "ś", "ŝ", "š", "ş", "ß", "ť", "ţ", "þ", "ú", "ù", "û", "ü", "ŭ", "ū", "ů", "ų", "ű", "ư", "ŵ", "ý", "ŷ", "ÿ", "ź", "ż", "ž");
	$to = array("A", "A", "A", "A", "A", "A", "A", "A", "A", "AE", "C", "C", "C", "C", "C", "D", "D", "D", "E", "E", "E", "E", "E", "E", "E", "E", "G", "G", "G", "G", "G", "a", "a", "a", "a", "a", "a", "a", "a", "a", "ae", "c", "c", "c", "c", "c", "d", "d", "d", "e", "e", "e", "e", "e", "e", "e", "e", "g", "g", "g", "g", "g", "H", "H", "I", "I", "I", "I", "I", "I", "I", "I", "IJ", "J", "K", "L", "L", "N", "N", "N", "N", "O", "O", "O", "O", "O", "O", "O", "O", "CE", "h", "h", "i", "i", "i", "i", "i", "i", "i", "i", "ij", "j", "k", "l", "l", "n", "n", "n", "n", "o", "o", "o", "o", "o", "o", "o", "o", "o", "R", "R", "S", "S", "S", "S", "T", "T", "T", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "W", "Y", "Y", "Y", "Z", "Z", "Z", "r", "r", "s", "s", "s", "s", "B", "t", "t", "b", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "w", "y", "y", "y", "z", "z", "z");


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
        $cleanSlug = strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('-', '-', ''), $this->replaceDiacritics($slugString)));
        return $cleanSlug;
    }
    
        protected function toLatin($str)
    {
        $theArray = array (
                        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'ā' => 'a', 'ă' => 'a', 'ç' => 'c', 'ć' => 'c', 'ĉ' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'ÿ' => 'y', 'Á' => 'A', 'Å' => 'A', 'Â' => 'A', 'Ä' => 'A', 'À' => 'A', 'Ã' => 'A', 'Ā' => 'A', 'Ă' => 'A', 'Č' => 'C', 'Ç' => 'C', 'Ć' => 'C', 'Ċ' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Õ' => 'O', 'Ö' => 'O', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Ő' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Š' => 'S', 'š' => 's', 'Đ' => 'Dj',	
                        'đ' => 'dj', 'Ž'=>'Z', 'ž'=>'z', 'e' => 'e', 'E' => 'E', 'e' => 'e', 'E' => 'E', 'e' => 'e', 'G' => 'G', 'g' => 'g', 'G' => 'G', 'g' => 'g', 'G' => 'G', 'g' => 'g', 'G' => 'G', 'g' => 'g', 'H' => 'H', 'h' => 'h', 'H' => 'H', 'h' => 'H', 'I' => 'I', 'i' => 'i', 'I' => 'I', 'i' => 'i', 'I' => 'I', 'i' => 'i', 'I' => 'I', 'i' => 'i', 'I' => 'I', 'J' => 'J', 'j' => 'j', 'K' => 'K', 'k' => 'k', 'L' => 'L', 'l' => 'l', 'N' => 'N', 'n' => 'n', 'N' => 'N', 'n' => 'n', 'N' => 'N', 'n' => 'n', 'O' => 'O', 'o' => 'o', 'O' => 'O', 'o' => 'o', 'O' => 'O', 'o' => 'o', 'R' => 'R', 'ŕ' => 'r', 'Ŗ' => 'R', 'ŗ' => 'r', 'Ř' => 'R', 'ř' => 'r', 'Ś' => 'S', 'ś' => 's', 'Ŝ' => 'S', 'ŝ' => 's', 'Ş' => 'S', 'ş' => 's', 'Š' => 'S', 'š' => 's', 'Ţ' => 'T', 'ţ' => 't', 'Ť' => 'T', 'ť' => 't', 'Ŧ' => 'T', 'ŧ' => 't', 'Ũ' => 'U', 'ũ' => 'u', 'Ū' => 'U', 'ū' => 'u', 'Ŭ' => 'U', 'ŭ' => 'u', 'Ů' => 'U', 'ů' => 'u', 'Ű' => 'U', 'ű' => 'u', 'Ų' => 'U', 'ų' => 'u', 'Ŵ' => 'W', 'ŵ' => 'w', 'Ŷ' => 'Y', 'ŷ' => 'y', 'Ÿ' => 'Y', 'Ź' => 'Z', 'ź' => 'z', 'Ż' => 'Z', 'ż' => 'z', 'Ž' => 'Z', 'ž' => 'z', 'ſ' => 'F', 'ƒ' => 'f', 'Ơ' => 'O', 'ơ' => 'o', 'Ư' => 'U', 'ư' => 'u', 'Ǎ' => 'A', 'ǎ' => 'a', 'Ǐ' => 'I', 'ǐ' => 'i', 'Ǒ' => 'O', 'ǒ' => 'o', 'Ǔ' => 'U', 'ǔ' => 'u', 'Ǖ' => 'U', 'ǖ' => 'u', 'Ǘ' => 'U', 'ǘ' => 'u', 'Ǚ' => 'U', 'ǚ' => 'u', 'Ǜ' => 'U', 'ǜ' => 'u', 'Ǻ' => 'A', 'ǻ' => 'a', 'Ǽ' => 'AE', 'ǽ' => 'ae', 'Ǿ' => 'o', 'ǿ' => 'o'
                        );
        $result = $str;
        $result = strtr($result, $theArray);

        return $result;
    }
}
