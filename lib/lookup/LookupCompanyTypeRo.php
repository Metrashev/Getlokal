<?php

class LookupCompanyTypeRo extends ArrayIterator
{
  static public $companyTypeList = 
  array(
  'ro'=>array(
  1 =>'S.R.L',
  2 =>'S.A.'
  ),
  'en'=>array(
  1 =>'S.R.L',
  2 =>'S.A.'
  )
  );
  
 static public $companyTypeListWEmpty = 
  array(
  'ro'=>array(
  0 =>'',
  1 =>'S.R.L',
  2 =>'S.A.'),
   'en'=>array(
   0 =>'',
  1 =>'S.R.L',
  2 =>'S.A.')
  );

 public function __construct($lang=null)
  {
  if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_BG)))
        {
        $lang ='ro'	;
        }
    parent::__construct(self::$companyTypeListWEmpty[$lang]);
  }

  static function getInstance($lang=null)
  {
    static $me = array();
  if(!in_array($lang, getlokalPartner::getEmbeddedLanguages(getlokalPartner::GETLOKAL_BG)))
        {
        $lang ='ro'	;
        }
    if (!isset($me[$lang]))
    {
      $me[$lang] = new LookupCompanyTypeRo($lang);
    }
    
    return $me[$lang];
  }
}
