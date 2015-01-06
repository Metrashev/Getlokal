<?php

class AddressTypeHu extends ArrayIterator
{
	// Properties defined here

    
    static public $streetTypeList = 
        array(
            'hu' => array(
                    0 =>'',
                    1 => 'körút',
                    5 => 'Sq.',
                    6 => 'utca',
                    ),
            'en' => array(
                    0 =>'',
                    1 => 'Blvd',
                    5 => 'Sq.',
                    6 => 'St',
             )
        );
	
    static public $locationTypeList = 
        array(
            'hu' => array(
                    0 =>'',
                    2 => 'Qtr',
                    3 => 'N\'hood',
                    4 => 'Area',
                    7 => 'PO Box',
                    8 => 'Zone',		
                    1 => 'körút',
                    5 => 'Sq.',
                    6 => 'utca',
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
            )
        );
		
		
		
    static public $neighbourhoodTypeList = 
        array(
            'hu' => array(
                    0 =>'',     
                    2 => 'Qtr',
                    3 => 'N\'hood',
                    4 => 'Area',
                    7 => 'PO Box',
                    8 => 'Zone',
            ),
            'en' => array( 
                    0 =>'',     
                    2 => 'Qtr',
                    3 => 'N\'hood',
                    4 => 'Area',
                    7 => 'PO Box',
                    8 => 'Zone',
            )
        );

    public function __construct($lang)
    {
        
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_HU))){
            $lang ='hu'	;
        }
        parent::__construct(self::$locationTypeList[$lang]);
    }

    public static function getInstance($lang=null)
    {
        $lang = sfContext::getInstance()->getUser()->getCulture();
        
        static $me = array();
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_HU))){
            $lang ='hu'	;
        }
        if (!isset($me[$lang])){
            $me[$lang] = new AddressTypeHu($lang);
        }
        return $me[$lang];
    }

    public static function getStreetNeiInstance($type, $lang =null)
    {
        $lang = sfContext::getInstance()->getUser()->getCulture();
        
        static $me = array();
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_HU))){
            $lang ='hu'	;
        }
        if ($type =='street') { 
            
            $me = self::$streetTypeList[$lang];
        }else{
            $me = self::$neighbourhoodTypeList[$lang];
        }
        
        return $me;
    }
  
}