<?php

class AddressTypeSr extends ArrayIterator
{
	// Properties defined here
   

	static public $streetTypeList = 
		array(
			'sr' => array(
				0 =>'',
				1 => 'bul', 
				5 => 'trg',
				6 => 'ul',
			
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
			'sr' => array(
				0 =>'',        
				2 => 'stambeni prostor',
				3 => 'kraj',
				4 => 'oblast',
				7 => 'poštanski fah',
				8 => 'zona',	
				1 => 'bul', 
				5 => 'trg',
				6 => 'ul',
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
			'sr' => array(
				0 =>'',        
				2 => 'stambeni prostor',
				3 => 'kraj',
				4 => 'oblast',
				7 => 'poštanski fah',
				8 => 'zona',
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
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_RS))){
            $lang ='sr';
        }
        parent::__construct(self::$locationTypeList[$lang]);
    }

    public static function getInstance($lang=null)
    {
        $lang = sfContext::getInstance()->getUser()->getCulture();
        
        static $me = array();
	if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_RS))){
            $lang ='sr';
        }
        if (!isset($me[$lang])){
            $me[$lang] = new AddressTypeSr($lang);
        }
        return $me[$lang];
    }
  
    public static function getStreetNeiInstance($type, $lang =null)
    {
        $lang = sfContext::getInstance()->getUser()->getCulture();
        
        static $me = array();
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_RS))){
            $lang ='sr'	;
        }
        if ($type =='street') { 
                $me = self::$streetTypeList[$lang];
        }else{
                $me = self::$neighbourhoodTypeList[$lang];
        }

        return $me;
    }
  
}