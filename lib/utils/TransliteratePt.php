<?php

/**
 * Transliterate class
 *
 * This class contains utility methods for transliteration
 *
 *
 */
class TransliteratePt {
	private static $toLatin = array (
								'ã' => 'a',
								'á' => 'a',
								'à' => 'a',
								'â' => 'a',
								'ç' => 'c',
								'é' => 'e',
								'ê' => 'e',
								'í' => 'i',
								'õ' => 'o',
								'ó' => 'o',
								'ô' => 'o',
								'ú' => 'u',
								'ü' => 'u',
								'Ã' => 'A',
								'Á' => 'A',
								'À' => 'A',
								'Â' => 'A',
								'Ç' => 'C',
								'É' => 'E',
								'Ê' => 'E',
								'Í' => 'I',
								'Õ' => 'O',
								'Ó' => 'O',
								'Ô' => 'O',
								'Ú' => 'U',
								'Ü' => 'U',			
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