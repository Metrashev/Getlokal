<?php

class AddressTypeSk extends ArrayIterator
{
	// Properties defined here

    
    static public $streetTypeList = 
        array(
            'sk' => array(
                    0 =>'',
                    1 => 'Blvd',
                    5 => 'Sq.',
                    6 => 'St.',
                    ),
            'en' => array(
                    0 =>'',
                    1 => 'Blvd',
                    5 => 'Sq.',
                    6 => 'St',
             ),
            'cs' => array(
                    0 =>'',
                    1 => 'Blvd',
                    5 => 'Sq.',
                    6 => 'St.',
            ),
        );
	
    static public $locationTypeList = 
        array(
            'sk' => array(
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
            'cs' => array( 
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
            'sk' => array(
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
            ),
            'cs' => array(
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
        
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_SK))){
            $lang ='sk'	;
        }
        parent::__construct(self::$locationTypeList[$lang]);
    }

    public static function getInstance($lang=null)
    {
        $lang = sfContext::getInstance()->getUser()->getCulture();
        
        static $me = array();
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_SK))){
            $lang ='sk'	;
        }
        if (!isset($me[$lang])){
            $me[$lang] = new AddressTypeSk($lang);
        }
        return $me[$lang];
    }

    public static function getStreetNeiInstance($type, $lang =null)
    {
        $lang = sfContext::getInstance()->getUser()->getCulture();
        
        static $me = array();
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_SK))){
            $lang ='sk'	;
        }
        if ($type =='street') { 
            
            $me = self::$streetTypeList[$lang];
        }else{
            $me = self::$neighbourhoodTypeList[$lang];
        }
        
        return $me;
    }
  
}