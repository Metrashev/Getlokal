<?php

class AddressTypeFi extends ArrayIterator
{
	// Properties defined here

    
    static public $streetTypeList = 
        array(
            'fi' => array(
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
            'ru' => array(
                    0 =>'',
                    1 => 'бул.',
                    5 => 'кв.',
                    6 => 'ул.',
            ),
        );
	
    static public $locationTypeList = 
        array(
            'fi' => array(
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
            'ru' => array( 
                    0 =>'',        
                    2 => 'кв.',
                    3 => 'окр.',
                    4 => 'м.',
                    7 => 'п.и.',
                    8 => 'зона',	
                    1 => 'бул.', 
                    5 => 'пл.',
                    6 => 'ул.',
            ),
        );
		
		
		
    static public $neighbourhoodTypeList = 
        array(
            'fi' => array(
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
            'ru' => array(
                    0 =>'',        
                    2 => 'кв.',
                    3 => 'окр.',
                    4 => 'м.',         
                    7 => 'п.и.',
                    8 => 'зона',
            ),
        );

    public function __construct($lang)
    {
        
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_FI))){
            $lang ='fi'	;
        }
        parent::__construct(self::$locationTypeList[$lang]);
    }

    public static function getInstance($lang=null)
    {
        $lang = sfContext::getInstance()->getUser()->getCulture();
        
        static $me = array();
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_FI))){
            $lang ='fi'	;
        }
        if (!isset($me[$lang])){
            $me[$lang] = new AddressTypeFi($lang);
        }
        return $me[$lang];
    }

    public static function getStreetNeiInstance($type, $lang =null)
    {
        $lang = sfContext::getInstance()->getUser()->getCulture();
        
        static $me = array();
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_FI))){
            $lang ='fi'	;
        }
        if ($type =='street') { 
            
            $me = self::$streetTypeList[$lang];
        }else{
            $me = self::$neighbourhoodTypeList[$lang];
        }
        
        return $me;
    }
  
}