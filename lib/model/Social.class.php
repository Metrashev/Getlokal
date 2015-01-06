<?php

class Social
{
  // sex choices

  const SEX_UNSPECIFIED = '';
  const POSITION_UNSPECIFIED = '';
  const SEX_MALE        = 'm';
  const SEX_FEMALE      = 'f';
  
  const OWNER = 1;
  const DIRECTOR = 2;
  const MANAGER = 3;  
  const EMPLOYEE = 4;  
  const OTHER = 5; 
  
                                      
   static public $sexChoices = array(
                                    self::SEX_MALE        => 'Male',
                                    self::SEX_FEMALE      => 'Female');
   static public $sexChoicesWEmpty = array(self::SEX_UNSPECIFIED => 'Choose... ',
                                    self::SEX_MALE        => 'Male',
                                    self::SEX_FEMALE      => 'Female');
   static public $positionChoices = array(self::OWNER => 'Owner',
     								  self::DIRECTOR => 'Director',
     								  self::MANAGER => 'Manager',
     								  self::EMPLOYEE => 'Employee',
     								  self::OTHER => 'Other');                                 
  static public $positionChoicesWEmpty = array( self::POSITION_UNSPECIFIED => 'Choose... ',
     								  self::OWNER => 'Owner',
     								  self::DIRECTOR => 'Director',
     								  self::MANAGER => 'Manager',
     								  self::EMPLOYEE => 'Employee',
     								  self::OTHER => 'Other');                                            

  /**
   * Get the I18n array of choices from the one
   * given in parameter, if i18n enabled.
   * @param array $choices An array instance of choices
   */
  static public function getI18NChoices(array $choices)
  { 
    if (sfConfig::get('sf_i18n'))
    {
      // make confirm a choice (i18n solution is very ugly, is there a better way? TODO)
      $i18n = sfContext::getInstance()->getI18N();
      foreach ($choices as $k => $choice)
      {
        $i18nChoices[$k] = $i18n->__($choice, null, 'form');
      }
      return $i18nChoices;
    }
    else
    {
      return $choices;
    }
  }
  /*
   * Return $choices 
   */
  static public function getChoices(array $choices)
  {
      return $choices;
  }
}
