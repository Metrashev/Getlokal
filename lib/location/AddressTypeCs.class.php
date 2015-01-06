<?php

class AddressTypeCs extends ArrayIterator
{
	// Properties defined here

    
    static public $streetTypeList = 
        array(
            'cs' => array(
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
            'sk' => array(
                    0 =>'',
                    1 => 'Blvd',
                    5 => 'Sq.',
                    6 => 'St.',
            ),
        );
	
    static public $locationTypeList = 
        array(
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
        );
		
		
		
    static public $neighbourhoodTypeList = 
        array(
            'cs' => array(
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
            'sk' => array(
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
        
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_CZ))){
            $lang ='cs'	;
        }
        parent::__construct(self::$locationTypeList[$lang]);
    }

    public static function getInstance($lang=null)
    {
        $lang = sfContext::getInstance()->getUser()->getCulture();
        
        static $me = array();
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_CZ))){
            $lang ='cs'	;
        }
        if (!isset($me[$lang])){
            $me[$lang] = new AddressTypeCs($lang);
        }
        return $me[$lang];
    }

    public static function getStreetNeiInstance($type, $lang =null)
    {
        $lang = sfContext::getInstance()->getUser()->getCulture();
        
        static $me = array();
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_CZ))){
            $lang ='cs'	;
        }
        if ($type =='street') { 
            
            $me = self::$streetTypeList[$lang];
        }else{
            $me = self::$neighbourhoodTypeList[$lang];
        }
        
        return $me;
    }
  
}