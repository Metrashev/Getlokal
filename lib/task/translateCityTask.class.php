<?php

class translateCityTask extends sfBaseTask
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
        $this->name = 'city';
        $this->briefDescription = 'Translate city name to Russian';
        $this->detailedDescription = <<<EOF
[php symfony translate:city] 
EOF;
    }

    protected function execute($arguments = array(), $options = array())
    {
        $databaseManager = new sfDatabaseManager ( $this->configuration );
        $connection = $databaseManager->getDatabase ( $options ['connection'] ? $options ['connection'] : null )->getConnection ();
        $connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );
        
        $cities = Doctrine::getTable ( 'City' )
                ->createQuery ( 'c' )
                ->innerJoin('c.Translation ctr')
                ->where ( 'ctr.lang = ?', 'fi'  )
                ->fetchArray ();
                       
        foreach($cities as $city){
            $name_fi = $city['Translation']['fi']['name'];
            $id = $city['Translation']['fi']['id'];
            $name_ru = $this->find_name_ru($name_fi);
            if($name_ru!= null && $name_ru !=''){
                    $con = Doctrine::getConnectionByTableName('city_translation');
                    $con->execute("INSERT INTO `city_translation`(`id`, `name`, `lang`) VALUES ($id, '$name_ru', 'ru');");

            }
            else{
                    $name_ru = $this->toRu($name_fi);
                    $con = Doctrine::getConnectionByTableName('city_translation');
                    $con->execute("INSERT INTO `city_translation`(`id`, `name`, `lang`) VALUES ($id, '$name_ru', 'ru');");
            }
        } 

        $cities_bg = Doctrine::getTable ( 'City' )
            ->createQuery ( 'c' )
            ->innerJoin('c.Translation ctr')
            ->innerJoin('c.County co')
            ->where('co.country_id = ?', 1)
            ->fetchArray ();
        
        foreach($cities_bg as $city){
            
            $keys = array_keys($city['Translation']);
            
            foreach($keys as $lang){
                $id = $city['Translation'][$lang]['id'];
                $name = $city['Translation'][$lang]['name'];
                $name=mb_convert_case($name, MB_CASE_TITLE, 'UTF-8');

                echo 'ID: '.$id.' | Name: '.$name.' | Lang: '.$lang. PHP_EOL;
                
                $con = Doctrine::getConnectionByTableName('city_translation');
                $con->execute('UPDATE city_translation SET name = "'.$name.'" WHERE id = '.$id.' and lang = "'.$lang.'";');
            }
        }
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

    protected function find_name_ru($name_fi) {
        $result = false;
        if (($handle = fopen(sfConfig::get('sf_web_dir') . '/cities.csv', "r")) !== FALSE) {     //file with translated cities (all cities)
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $name_ru = $data[1];
                $name_fi_new = $data[0];

                if($name_fi_new == $name_fi){
                    $result = $name_ru;
                    break;
                }
            }
            fclose($handle);
	}
        return $result;
    }
}
