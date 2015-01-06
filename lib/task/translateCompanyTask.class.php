<?php

class translateCompanyTask extends sfBaseTask
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
        $this->name = 'company';
        $this->briefDescription = 'Transliterate company names to Russian';
        $this->detailedDescription = <<<EOF
[php symfony translate:company] 
EOF;
    }

    protected function execute($arguments = array(), $options = array())
    {
        $databaseManager = new sfDatabaseManager ( $this->configuration );
        $connection = $databaseManager->getDatabase ( $options ['connection'] ? $options ['connection'] : null )->getConnection ();
        $connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );



        $cities = Doctrine::getTable ( 'Company' )
                ->createQuery ( 'c' )
                ->innerJoin('c.Translation ctr')
                ->where ( 'ctr.lang = ?', 'fi'  )
                ->fetchArray ();
                
        foreach($cities as $city){
            $id = $city['Translation']['fi']['id'];
            $title_fi = $city['Translation']['fi']['title'];
            $description = $city['Translation']['fi']['description'];
            $content = $city['Translation']['fi']['content'];

            $title_ru = $this->toRu($title_fi);

            $title_ru = str_replace('"','', $title_ru);
            $description = str_replace('"','', $description);
            $content = str_replace('"','', $content);
            $con = Doctrine::getConnectionByTableName('company_translation');
            $con->execute('INSERT INTO `company_translation`(`id`, `title`, `description`, `content`, `lang`) VALUES ('.$id.', "'.$title_ru.'", "'.$description.'", "'.$content.'", "ru");');
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
                            'ai' => 'ай',
                            'Ai' => 'Ай',
                            'Ui' => 'Уй',
                            'ui' => 'уй',
                            'ii' => 'ий',
                            'Ii' => 'Ий',
                            'Ei' => 'ей',
                            'ei' => 'ей',
                            'ää' => 'яа',
                            'Ää' => 'Яа',
                            'Ee' => 'Еэ',
                            'ee' => 'еэ',
                            'io' => 'иë',
                            'Io' => 'Иë',
                            'io' => 'иë',
                            'Io' => 'Иë',
                            'Zh' => 'Ж',
                            'zh' => 'ж'
			);
	$result = $str;
        $result = strtr($result, $theArray);
        $result=  str_replace('"', '', $result);
        return $result;
    }
}
