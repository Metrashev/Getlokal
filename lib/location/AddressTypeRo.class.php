<?php

class AddressTypeRo extends ArrayIterator
{
	// Properties defined here
   

	static public $streetTypeList = 
		
	array(
			'ro' => array(
			1 => 'Bd.',
        2 => 'Cart.',
        6 => 'Str.',
        10 => 'Cal.',
        11 => 'Spl.',
        12 => 'Prel.',
        5 => 'Pţa.',
        14 => 'Drum.',       
        15 => 'Int.',
        16 => 'Fdt.',
        17 => 'Şos.',
        18 => 'Al.'
			),
			'en' => array( 
				1 => 'Bd.',
        2 => 'Cart.',
        6 => 'Str.',
        10 => 'Cal.',
        11 => 'Spl.',
        12 => 'Prel.',
        5 => 'Pţa.',
        14 => 'Drum.',       
        15 => 'Int.',
        16 => 'Fdt.',
        17 => 'Şos.',
        18 => 'Al.'
			),
	
	
      
    );
	
	
	

    public function __construct($lang=null)
    {
        if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_RO)))
        {
        $lang ='ro'	;
        }
        parent::__construct(self::$streetTypeList[$lang]);
    }

	public static function getInstance($lang){
		static $me = array();
		if (!isset($me[$lang])){
			$me[$lang] = new AddressTypeRo($lang);
		}
		return $me[$lang];
	}
  
	public static function getStreetNeiInstance($type, $lang =null){
  		static $me = array();
	 if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_RO)))
        {
        $lang ='ro'	;
        }
  		$me = self::$streetTypeList[$lang];
    
		return $me;
	}
  
}