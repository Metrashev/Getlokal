<?php

class googleCountiesTask extends sfBaseTask
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

        $this->namespace = 'google';
        $this->name = 'counties';
        $this->briefDescription = 'Translate County names on english (like by google)';
        $this->detailedDescription = <<<EOF
[php symfony google:counties] 
EOF;
    }

    protected function execute($arguments = array(), $options = array())
    {
        $databaseManager = new sfDatabaseManager ( $this->configuration );
        $connection = $databaseManager->getDatabase ( $options ['connection'] ? $options ['connection'] : null )->getConnection ();
        $connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );

        $counties = Doctrine_Query::create()
            ->select('c.id, ct.name, ct.lang, cot.name_en, cot.id')
            ->from('County c')
            ->innerJoin('c.Translation ct')
            ->innerJoin('c.Country cot')
            ->where('ct.lang =?','en')
            ->andWhere('cot.id=78')
            ->fetchArray();
        
        $i=0;
        foreach($counties as $county){
            
            $i++;
            $keys = array_keys($county_name = $county['Translation']);
            $lang = $keys[0];
            $county_id = $county['Translation'][$lang]['id'];
            $county_name = $county['Translation'][$lang]['name'];

            
            $country_name = $county['Country']['name_en'];
            $country_id = $county['Country']['id'];

            $url = 'http://maps.googleapis.com/maps/api/geocode/xml?address='.str_replace(array(' ','-'),array('+','+'),$county_name).','. str_replace(' ','+',$country_name).'&sensor=false&language=en';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            $geo_contents = curl_exec($ch);
            curl_close($ch);

            $geo_contents = simplexml_load_string($geo_contents);
            
            foreach($geo_contents->result[0]->address_component as $address_component){
                if($address_component->type[0] == 'administrative_area_level_1'){
                    
                    $google_name_en= $address_component->long_name;
                    $slug = $this->cleanSlugString($google_name_en);

                    $con_county_tr = Doctrine::getConnectionByTableName('county_translation');
                    $con_county_tr->execute("UPDATE county_translation SET name= '".$google_name_en."' WHERE lang='en' AND id=".$county_id.";");
                    echo "UPDATE county_translation SET name= '".$google_name_en."' WHERE lang='en' AND id=".$county_id.";".PHP_EOL;
                }
            }
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
    protected function cleanSlugString($slugString)
    {
        $cleanSlug = strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('-', '-', ''), $this->replaceDiacritics($slugString)));
        return $cleanSlug;
    }

}
