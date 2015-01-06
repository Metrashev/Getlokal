<?php

class translateCountyTask extends sfBaseTask
{
    protected function configure()
    {
        mb_internal_encoding("UTF-8");
        $this->addArguments(array());

        $this->addOptions(array (
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'))
        );

        $this->namespace = 'translate';
        $this->name = 'county';
        $this->briefDescription = 'Translate County names and generate slug';
        $this->detailedDescription = <<<EOF
[php symfony translate:county] 
EOF;
    }

    protected function execute($arguments = array(), $options = array())
    {
        $databaseManager = new sfDatabaseManager ( $this->configuration );
        $connection = $databaseManager->getDatabase ( $options ['connection'] ? $options ['connection'] : null )->getConnection ();
        $connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );

        $counties = Doctrine::getTable ( 'County' )
                ->createQuery ( 'co' )
                ->innerJoin('co.Translation ctr')
                ->fetchArray ();
        
        
        foreach($counties as $county){
            
            $keys = array_keys($county_name = $county['Translation']);
            $lang = $keys[0];
            $county_id = $county['Translation'][$lang]['id'];
            $county_name = $county['Translation'][$lang]['name'];
            
            
            
            $name_en = $this->replaceDiacritics($county_name);
            $name_en = str_replace('"', '', $name_en);
            $slug = $this->cleanSlugString($name_en);
            
            $con = Doctrine::getConnectionByTableName('county_translation');
            $con->execute('INSERT INTO `county_translation`(`id`, `name`, `lang`) VALUES ("'.$county_id.'", "'.$name_en.'", "en");');
            
            if($lang == 'fi'){
                $name_ru = $this->find_name_ru($county_name);
                $name_ru = str_replace('"','',$name_ru);
                if($name_ru!= null && $name_ru !=''){
                        $con = Doctrine::getConnectionByTableName('county_translation');
                        $con->execute('INSERT INTO `county_translation`(`id`, `name`, `lang`) VALUES ("'.$county_id.'", "'.$name_ru.'", "ru");');

                }
                else{
                        $name_ru = $this->toRu($county_name);
                        $name_ru = str_replace('"','',$name_ru);
                        $con = Doctrine::getConnectionByTableName('county_translation');
                        $con->execute('INSERT INTO `county_translation`(`id`, `name`, `lang`) VALUES ("'.$county_id.'", "'.$name_ru.'", "ru");');
                }
            }
            
            $con = Doctrine::getConnectionByTableName('county');
            $con->execute("UPDATE `county` SET slug= '$slug' WHERE id=$county_id;");
        }
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

    protected function find_name_ru($name_fi) {
        $result = false;
	$unique = fopen(sfConfig::get('sf_web_dir') . "/counties.csv", "r");
        while(! feof($unique)){
            $array = fgetcsv($unique);
            $name_fi_new = $array[0];
            $name_ru = $array[1];
            if($name_fi_new == $name_fi){
                    $result = $name_ru;
                    break;
            }
	}
	fclose($unique);
        return $result;
    }
    
    protected function toRu($str)
    {
	$theArray = array (
                            'a' => 'а',
                            'ä' => 'я',
                            'b' => 'б',
                            'c' => 'ц',
                            'd' => 'д',
                            'e' => 'е',
                            'f' => 'ф',
                            'g' => 'г',
                            'h' => 'х', 
                            'i' => 'и',
                            'j' => 'й',
                            'k' => 'к',
                            'l' => 'л',
                            'm' => 'м',
                            'n' => 'н',
                            'o' => 'о',
                            'ö' => 'ë',
                            'p' => 'п',
                            'q' => 'к',
                            'r' => 'р',
                            's' => 'с',
                            't' => 'т',
                            'u' => 'у',
                            'v' => 'в',
                            'w' => 'у',
                            'x' => 'кс',
                            'y' => 'ю',
                            'z' => 'з',
                            'å' => 'о',
                            'A' => 'А',
                            'Ä' => 'Я',
                            'Å' => 'О',
                            'B' => 'Б',
                            'C' => 'Ц',
                            'D' => 'Д',
                            'E' => 'Э',
                            'F' => 'Ф',
                            'G' => 'Г',
                            'H' => 'Х',
                            'I' => 'И',
                            'J' => 'Й',
                            'K' => 'К',
                            'L' => 'Л',
                            'M' => 'М',
                            'N' => 'Н',
                            'O' => 'О',
                            'Ö' => 'Ë',
                            'P' => 'П',
                            'Q' => 'К',
                            'R' => 'Р',
                            'S' => 'С',
                            'T' => 'Т',
                            'U' => 'У',
                            'V' => 'В',
                            'W' => 'У',
                            'X' => 'Кс',
                            'Y' => 'Ю',
                            'Z' => 'З',
                            'Ck' => 'К',
                            'ck' => 'к',
                            'Yu' => 'Ю',
                            'yu' => 'ю',
                            'Ju' => 'Ю',
                            'ju' => 'ю',
                            'jy' => 'ю',
                            'Jy' => 'Ю',
                            'ja' => 'я',
                            'Ja' => 'Я',
                            'jä' => 'я',
                            'Jä' => 'Я',
                            'Ya' => 'Я',
                            'ya' => 'я',
                            'Ch' => 'Ч',
                            'ch' => 'ч',
                            'Tsh' => 'Ч',
                            'tsh' => 'ч',
                            'Ts' => 'Ц',
                            'ts' => 'ц',
                            'Sh' => 'Ш',
                            'sh' => 'ш',
                            'Shh' => 'Щ',
                            'shh' => 'щ',
                            'Shs' => 'Щ',
                            'shs' => 'щ',
                            'Jo' => 'Ё',
                            'jo' => 'ё',
                            'oi' => 'ой',
                            'Oi' => 'Ой',
                            'ai' =>'ай',
                            'Ai' =>'Ай',
                            'Ui' =>'Уй',
                            'ui' =>'уй',
                            'ii' =>'ий',
                            'Ii' =>'Ий',
                            'Ei' =>'ей',
                            'ei' =>'ей',
                            'ää' =>'яа',
                            'Ää' =>'Яа',
                            'Ee' =>'Еэ',
                            'ee' =>'еэ',
                            'io' =>'иë',
                            'Io' => 'Иë',
                            'io' =>'иë',
                            'Io' => 'Иë',
                            'Zh' => 'Ж',
                            'zh' => 'ж'
			);
	$result = $str;
        $result = strtr($result, $theArray);

        return $result;
    }
    protected function cleanSlugString($slugString)
    {
        $cleanSlug = strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('-', '-', ''), $slugString));
        return $cleanSlug;
    }
}
