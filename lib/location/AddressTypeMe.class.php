<?php
class AddressTypeMe extends ArrayIterator
{
	// Properties defined here
   

	static public $streetTypeList = 
		array(
			'me' => array(
				0 =>'',
				1 => 'Bulevar',
				5 => 'Trg.',
				6 => 'Ulica.',
			
				),
			'en' => array(
				0 =>'',
				1 => 'Blvd',
				5 => 'Sq.',
				6 => 'St',
			),
		);
	
	static public $locationTypeList = 
		array(
			'me' => array(
				0 =>'',        
				2 => 'Kvart.',
				3 => 'Kraj.',
				4 => 'Oblast',
				7 => 'Poštanski broj',
				8 => 'Zone',	
				1 => 'Bul.', 
				5 => 'Trg.',
				6 => 'Ul.',
			),
			'en' => array( 
				0 =>'',
				2 => 'Qtr',
				3 => 'N\'hood',
				4 => 'Area',
				7 => 'PO Box',
				8 => 'Zone',		
				1 => 'Blvd',
				5 => 'Sq.',
				6 => 'St',
			),
		);
		
		
		
        static public $neighbourhoodTypeList = 
		array(
			'me' => array(
				0 =>'',        
				2 => 'Kvart.',
				3 => 'Kraj.',
				4 => 'Oblast',         
				7 => 'Poštanski broj',
				8 => 'Zone',
			),
			'en' => array( 
				0 =>'',     
				2 => 'Qtr',
				3 => 'N\'hood',
				4 => 'Area',
				7 => 'PO Box',
				8 => 'Zone',
			),
		);

    public function __construct($lang)
    {
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_ME))){
            $lang ='me';
        }
        parent::__construct(self::$locationTypeList[$lang]);
    }

    public static function getInstance($lang=null)
    {
        $lang = sfContext::getInstance()->getUser()->getCulture();

        static $me = array();
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_ME))){
            $lang ='me';
        }
        if (!isset($me[$lang])){
            $me[$lang] = new AddressTypeMe($lang);
        }
        return $me[$lang];
    }

    public static function getStreetNeiInstance($type, $lang =null)
    {
        $lang = sfContext::getInstance()->getUser()->getCulture();

        static $me = array();
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_ME))){
            $lang ='me'	;
        }
        if ($type =='street') { 
            $me = self::$streetTypeList[$lang];
        }else{
            $me = self::$neighbourhoodTypeList[$lang];
        }

        return $me;
    }
  
}