<?php

/**
 * Transliterate class
 *
 * This class contains utility methods for transliteration
 *
 *
 */
class TransliterateMk {
	
  static private $toLatin = array( 
  								  'а' => 'a','А	'=>'A','б'=>'b',
                                  'Б' => 'B', 'в' => 'v',
                                  'В' => 'V',
                                  'г' => 'g', 'Г' => 'G',
                                  'д' => 'd',
                                  'Д' => 'D','ѓ' => 'gj',
                                  'Ѓ' => 'Gj',
                                  'е' => 'e', 'Е' => 'E',                         
                                  'ж' => 'zh', 'Ж' => 'Zh',
                                  'з' => 'z', 'З' => 'Z',                                 
                                  'ѕ' => 'dz','Ѕ' => 'Dz',                                 
                                  'и' => 'i', 'И' => 'I',
                                  'ј' => 'j', 'Ј' => 'J',
                                  'к' => 'k', 'К' => 'K',
                                  'л' => 'l', 'Л' => 'L',
                                  'љ' => 'lj', 'Љ' => 'Lj',
                                  'м' => 'm', 'М' => 'M',
                                  'н' => 'n', 'Н' => 'N',
                                  'њ' => 'nj', 'Њ' => 'Nj',
                                  'о' => 'o', 'О' => 'O',
                                  'п' => 'p', 'П' => 'P',
                                  'р' => 'R', 'р' => 'r',  
                                  'П' => 'P', 'п' => 'p',
                                  'О' => 'O', 'о' => 'o',
                                  'с' => 's', 'С' => 'S',
                                  'т' => 't', 'Т' => 'T',
                                  'ќ' => 'kj', 'Ќ' => 'Kj',
                                  'у' => 'u', 'У' => 'U',
                                  'ф' => 'f', 'Ф' => 'F',
                                  'х' => 'h', 'Х' => 'H',
                                  'ц' => 'c', 'Ц' => 'C',
                                  'ч' => 'ch', 'Ч' => 'Ch',
                                  'џ' => 'dz', 'Џ' => 'Dz',
                                  'ш' => 'sh', 'Ш' => 'Sh'
                                );
static private $toLatinExceptions = array(                                  
                                   '№' => 'No.',
                                  'Македонија'=>'Macedonia', 
                                  'МАКЕДОНИЈА' =>'MACEDONIA'
                                  );
static private $toLocalExceptions = array(                                  
                                   'No.' => '№',
 								   'Macedonia'=>'Македонија', 
                                   'MACEDONIA' =>'МАКЕДОНИЈА'
                                  );
                                    
  static public function toLatin($str)
  {
    $result = $str;

    $result = strtr($result, self::$toLatinExceptions);
    $result = strtr($result, self::$toLatin);

    return $result;
  }

 
static public function toLocal($str){
    	$result = $str;
   
    	$result = strtr($result, self::$toLocalExceptions);    	
    	$result = strtr($result, self::$toLocal);

    	return $result;
  	}
 
}