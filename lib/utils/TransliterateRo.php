<?php

/**
 * Transliterate class
 *
 * This class contains utility methods for transliteration
 *
 *
 */
class TransliterateRo {
	private static $toLatin = array (
                                  'ă' => 'a',
                                  'Ă' => 'A',
                                  'â' => 'a',	
                                  'Â' => 'A',
                                  'î' => 'i',
                                  'Î' => 'I',	
                                  'ş' => 's',
                                  'Ş' => 'S',
                                  'ţ' => 't',
                                  'Ţ' => 'T',
	                              'ã'=>'a',
	                              'ž'=>'z',								 
	                              'Ã'=>'A',
	                              'Ž'=>'Z',
	                              'é' => 'e'
                                );


  static public function toLatin($str)
  {

    $result = $str;

    $result = strtr($result, self::$toLatin);

    return iconv('UTF-8', 'US-ASCII//TRANSLIT', urldecode($result));
  }

  static public function toLocal($str) {
    return $str;
  } 

 
}