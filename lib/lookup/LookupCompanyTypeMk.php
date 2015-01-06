<?php

class LookupCompanyTypeMk extends ArrayIterator
{
  static public $companyTypeList = 
    array(
     'mk' => array(
        1 => 'АД',
        2 => 'ГД',
        3 => 'ЕАД',
        4 => 'ЕООД',
        5 => 'ЕТ',
        6 => 'КАД',
        7 => 'КД',
        8 => 'ООД',
        9 => 'СД',
        10 => 'ДЗЗД'
        ),
     'en' => array(
        1 => 'AD',
        2 => 'GD',
        3 => 'EAD',
        4 => 'EOOD',
        5 => 'ЕТ',
        6 => 'KAD',
        7 => 'KD',
        8 => 'OOD',
        9 => 'SD',
        10 => 'DZZD'
        ),
  );
static public $companyTypeListWEmpty =   
  array(
     'mk' => array(
        0 => '',
        1 => 'АД',
        2 => 'ГД',
        3 => 'ЕАД',
        4 => 'ЕООД',
        5 => 'ЕТ',
        6 => 'КАД',
        7 => 'КД',
        8 => 'ООД',
        9 => 'СД',
        10 => 'ДЗЗД'
        ),
     'en' => array(
        0 => '',
        1 => 'AD',
        2 => 'GD',
        3 => 'EAD',
        4 => 'EOOD',
        5 => 'ЕТ',
        6 => 'KAD',
        7 => 'KD',
        8 => 'OOD',
        9 => 'SD',
        10 => 'DZZD'
        ),
  );

  public function __construct($lang=null)
  {
 
  if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_MK)))
        {
        $lang ='mk'	;
        }
    parent::__construct(self::$companyTypeListWEmpty[$lang]);
  }

  static function getInstance($lang=null)
  {
    static $me = array();
  if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_MK)))
        {
        $lang ='mk'	;
        }
    if (!isset($me[$lang]))
    {
      $me[$lang] = new LookupCompanyTypeMk($lang);
    }
    
    return $me[$lang];
  }
}
