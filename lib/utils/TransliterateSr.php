<?php

/**
 * Transliterate class
 *
 * This class contains utility methods for transliteration
 *
 *
 */
class TransliterateSr {
    private static $toLatin = array (
                              'Š' => 'S',
                              'š' => 's',
                              'Đ' => 'Dj',	
                              'đ' => 'dj',
                              'Č' => 'C',
                              'č' => 'c',	
                              'Ć' => 'C',
                              'ć' => 'c',
	                      'Ž'=>'Z',
	                      'ž'=>'z'	
     );

    private static $toLatinSr = array (
                                'А' => 'A',     'а' => 'a',
                                'Б' => 'B',     'б' => 'b',
                                'В' => 'V',     'в' => 'v',
                                'Г' => 'G',     'г' => 'g',
                                'Д' => 'D',     'д' => 'd',
                                'Ђ' => 'Đ',     'ђ' => 'đ',
                                'Е' => 'E',     'е' => 'e',
                                'Ж' => 'Ž',     'ж' => 'ž',
                                'З' => 'Z',     'з' => 'z',
                                'И' => 'I',     'и' => 'i',
                                'Ј' => 'J',     'ј' => 'j',
                                'К' => 'K',     'к' => 'k',
                                'Л' => 'L',     'л' => 'l',
                                'Љ' => 'Lj',    'љ' => 'lj',
                                'М' => 'M',     'м' => 'm',
                                'Н' => 'N',     'н' => 'n',
                                'Њ' => 'Nj',    'њ' => 'nj',
                                'О' => 'O',     'о' => 'o',
                                'П' => 'P',     'п' => 'p',
                                'Р' => 'R',     'р' => 'r',
                                'С' => 'S',     'с' => 's',
                                'Т' => 'T',     'т' => 't',
                                'Ћ' => 'Ć',     'ћ' => 'ć',
                                'У' => 'U',     'у' => 'u',
                                'Ф' => 'F',     'ф' => 'f',
                                'Х' => 'H',     'х' => 'h',
                                'Ц' => 'C',     'ц' => 'c',
                                'Ч' => 'Č',     'ч' => 'č',
                                'Џ' => 'Dž',    'џ' => 'dž',
                                'Ш' => 'Š',     'ш' => 'š'
    );

                                
  static public function toLatin($str)
  {
    $result = $str;
   
    $result = strtr($result, self::$toLatin);

    return $result;
  }

  static public function toLatinSr($str)
  {
    $string = $str;
   
    $result = strtr($string, self::$toLatinSr);

    return $result;
  }


 
}