<?php

/**
 * Transliterate class
 *
 * This class contains utility methods for transliteration
 *
 * @author Krasimir Angelov <angelov@netage.bg>
 */
class TransliterateBg
{
  static private $toLatin = array( 
  								  'ДЖ' => 'DZH','ИЯ'=>'IA','ия'=>'ia',
                                  'Дж' => 'Dzh', 'дж' => 'dzh',
                                  'ДЗ' => 'DZ',
                                  'Дз' => 'Dz', 'дз' => 'dz',
                                  'ЬО' => 'YO',
                                  'Ьо' => 'Yo','ьо' => 'yo',
                                  'ЙО' => 'YO',
                                  'Йо' => 'Yo', 'йо' => 'yo',                         
                                  'Я' => 'Ya', 'я' => 'ya',
                                  'Ю' => 'Yu', 'ю' => 'yu',                                 
                                  'Ь' => 'Y','ь' => 'y',                                 
                                  'Ъ' => 'A', 'ъ' => 'a',
                                  'Щ' => 'Sht', 'щ' => 'sht',
                                  'Ш' => 'Sh', 'ш' => 'sh',
                                  'Ч' => 'Ch', 'ч' => 'ch',
                                  'Ц' => 'Ts', 'ц' => 'ts',
                                  'Х' => 'H', 'х' => 'h',
                                  'Ф' => 'F', 'ф' => 'f',
                                  'У' => 'U', 'у' => 'u',
                                  'Т' => 'T', 'т' => 't',
                                  'С' => 'S', 'с' => 's',
                                  'Р' => 'R', 'р' => 'r',  
                                  'П' => 'P', 'п' => 'p',
                                  'О' => 'O', 'о' => 'o',
                                  'Н' => 'N', 'н' => 'n',
                                  'М' => 'M', 'м' => 'm',
                                  'Л' => 'L', 'л' => 'l',
                                  'К' => 'K', 'к' => 'k',
                                  'Й' => 'Y', 'й' => 'y',
                                  'И' => 'I', 'и' => 'i',
                                  'З' => 'Z', 'з' => 'z',
                                  'Ж' => 'Zh', 'ж' => 'zh',
                                  'Е' => 'E', 'е' => 'e',
                                  'Д' => 'D', 'д' => 'd',
                                  'Г' => 'G', 'г' => 'g',
                                  'В' => 'V', 'в' => 'v',
                                  'Б' => 'B', 'б' => 'b',                             
                                  'А' => 'A', 'а' => 'a'
                                );


  static private $toLatinExceptions = array(                                  
                                   '№' => 'No.',
                                  'България'=>'Bulgaria', 
                                  'БЪЛГАРИЯ' =>'BULGARIA'
                                  );


   static private $toLocal = array( 
                                  'DZH' => 'ДЖ',                           
                                  'Dzh' => 'Дж', 'dzh' => 'дж',
                                  'DZ' => 'ДЗ',
                                  'Dz' => 'Дз', 'dz' => 'дз',
                                  'YO' => 'ЬО',
                                  'Yo' => 'Ьо','yo' => 'ьо',
                                  'YO' => 'ЙО',
                                  'Yo' => 'Йо', 'yo' => 'йо', 
  								  'YА' => 'Я',                                
                                  'Ya' => 'Я', 'ya' => 'я',
                                  'YU' => 'Ю',
                                  'Yu' => 'Ю', 'yu' => 'ю',                                 
                                  'Y' => 'Ь','y' => 'ь',                                 
                                  'A' => 'Ъ', 'a' => 'ъ',
                                  'SHT' => 'Щ',
                                  'Sht' => 'Щ', 'sht' => 'щ',
                                  'SH' => 'Ш',
                                  'Sh' => 'Ш', 'sh' => 'ш',
                                  'TCH' => 'Ч', 'Tch' => 'Ч',
                                  'CH' => 'Ч',
                                  'Ch' => 'Ч', 'ch' => 'ч',
                                  'TS' => 'Ц',
                                  'Ts' => 'Ц', 'ts' => 'ц',
                                  'H' => 'Х', 'h' => 'х',
                                  'F' => 'Ф', 'f' => 'ф',
                                  'U' => 'У', 'u' => 'у',
                                  'T' => 'Т', 't' => 'т',
                                  'S' => 'С', 's' => 'с',
                                  'R' => 'Р', 'r' => 'р',  
                                  'P' => 'П', 'p' => 'п',
                                  'O' => 'О', 'o' => 'о',
                                  'N' => 'Н', 'n' => 'н',
                                  'M' => 'М', 'm' => 'м',
                                  'L' => 'Л', 'l' => 'л',
                                  'K' => 'К', 'k' => 'к',
                                  'Y' => 'Й', 'y' => 'й',
                                  'I' => 'И', 'i' => 'и',
                                  'Z' => 'З', 'z' => 'з',
                                  'Zh' => 'Ж', 'zh' => 'ж',
                                  'E' => 'Е', 'e' => 'е',
                                  'D' => 'Д', 'd' => 'д',
                                  'G' => 'Г', 'g' => 'г',
                                  'V' => 'В', 'v' => 'в',
                                  'B' => 'Б', 'b' => 'б',                             
                                  'A' => 'А', 'a' => 'а'
                                );


  
static private $toLocalExceptions = array(                                  
                                   'No.' => '№',
 								   'Bulgaria'=>'България', 
                                   'BULGARIA' =>'БЪЛГАРИЯ'
                                  );

  

  /**
   * Transliterates given string to latin
   *
   * @access public
   *
   * @param string $str
   *
   * @return string
   */
  static public function toLatin($str)
  {
    $result = $str;

    $result = strtr($result, self::$toLatinExceptions);
    $result = strtr($result, self::$toLatin);

    return $result;
  }

  /**
   * Transliterates given string to cyrillic
   *
   * @access public
   *
   * @param string $str
   *
   * @return string
   */
  	static public function toLocal($str){
    	$result = $str;
   
    	$result = strtr($result, self::$toLocalExceptions);
    	$result = str_replace(array('SHT', 'SH','TS', 'TCH', 'CH', 'YA', 'UY'), array('Щ','Ш', 'Ц', 'Ч', 'Ч','Я', 'УЙ'), $result);
    	$result = strtr($result, self::$toLocal);

    	return $result;
  	}
}