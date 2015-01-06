<?php

class AddressTypeBg extends ArrayIterator
{
	// Properties defined here
   

	static public $streetTypeList = 
		array(
			'bg' => array(
				0 =>'',
				1 => 'бул.',
				5 => 'пл.',
				6 => 'ул.',
			
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
			'bg' => array(
				0 =>'',        
				2 => 'жк.',
				3 => 'кв.',
				4 => 'м.',
				7 => 'п.к.',
				8 => 'к-с',	
				1 => 'бул.', 
				5 => 'пл.',
				6 => 'ул.',
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
			'bg' => array(
				0 =>'',        
				2 => 'жк.',
				3 => 'кв.',
				4 => 'м.',         
				7 => 'п.к.',
				8 => 'к-с',
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
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_BG))){
            $lang ='bg';
        }
        parent::__construct(self::$locationTypeList[$lang]);
    }

    public static function getInstance($lang=null)
    {
        $lang = sfContext::getInstance()->getUser()->getCulture();

        static $me = array();
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_BG))){
            $lang ='bg';
        }
        if (!isset($me[$lang])){
            $me[$lang] = new AddressTypeBg($lang);
        }
        return $me[$lang];
    }

    public static function getStreetNeiInstance($type, $lang =null)
    {
        $lang = sfContext::getInstance()->getUser()->getCulture();

        static $me = array();
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_BG))){
            $lang ='bg'	;
        }
        if ($type =='street') { 
            $me = self::$streetTypeList[$lang];
        }else{
            $me = self::$neighbourhoodTypeList[$lang];
        }

        return $me;
    }
  
}