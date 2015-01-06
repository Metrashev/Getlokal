<?php

/**
 * Transliterate class
 *
 * This class contains utility methods for transliteration
 *
 *
 */
class TransliterateFi {
	private static $toLatin = array (
                            'á' => 'a',
                            'â' => 'a',
                            'ä' => 'a',
                            'õ' => 'o',
                            'ö' => 'o',
                            'Á' => 'A',
                            'Å' => 'A',
                            'Â' => 'A',
                            'Ä' => 'A',
                            'Õ' => 'O',
                            'Ö' => 'O',
                            'Š' => 'S',
                            'š' => 's',
                            'Đ' => 'Dj',	
                            'đ' => 'dj',
                            'Č' => 'C',
                            'č' => 'c',	
                            'Ć' => 'C',
                            'ć' => 'c',
                            'Ž'=>'Z',
                            'ž'=>'z',
                            'а' => 'a',
                            'б' => 'b',
                            'в' => 'v',
                            'г' => 'g',
                            'д' => 'd',
                            'е' => 'e',
                            'ё' => 'io',
                            'ж' => 'zh',
                            'з' => 'z',
                            'и' => 'i',
                            'й' => 'y',
                            'к' => 'k',
                            'л' => 'l',
                            'м' => 'm',
                            'н' => 'n',
                            'о' => 'o',
                            'п' => 'p',
                            'р' => 'r',
                            'с' => 's',
                            'т' => 't',
                            'у' => 'u',
                            'ф' => 'f',
                            'х' => 'h',
                            'ц' => 'ts',
                            'ч' => 'ch',
                            'ш' => 'sh',
                            'щ' => 'sht',
                            'ъ' => 'a',
                            'ы' => 'i',
                            'ь' => 'y',
                            'э' => 'e',
                            'ю' => 'yu',
                            'я' => 'ya',
                            'А' => 'A',
                            'Б' => 'B',
                            'В' => 'V',
                            'Г' => 'G',
                            'Д' => 'D',
                            'Е' => 'E',
                            'Ж' => 'Zh',
                            'З' => 'Z',
                            'И' => 'I',
                            'Й' => 'Y',
                            'К' => 'K',
                            'Л' => 'L',
                            'М' => 'M',
                            'Н' => 'N',
                            'О' => 'O',
                            'П' => 'P',
                            'Р' => 'R',
                            'С' => 'S',
                            'Т' => 'T',
                            'У' => 'U',
                            'Ф' => 'F',
                            'Х' => 'H',
                            'Ц' => 'Ts',
                            'Ч' => 'Ch',
                            'Ш' => 'Sh',
                            'Щ' => 'Sht',
                            'Ъ' => 'A',
                            'Ы' => 'I',
                            'Ь' => 'Y',
                            'Э' => 'E',
                            'Ю' => 'Yu',
                            'Я' => 'Ya'
                            );

    private static $toRu = array (
                            'a' => 'а',
                            'ä' => 'я',
                            'b' => 'б',
                            'c' => 'ц',
                            'd' => 'д',
                            'e' => 'е',
                            'f' => 'ф',
                            'g' => 'г',
                            'h' => 'х', 
                            'i' => 'и',
                            'j' => 'й',
                            'k' => 'к',
                            'l' => 'л',
                            'm' => 'м',
                            'n' => 'н',
                            'o' => 'о',
                            'ö' => 'ë',
                            'p' => 'п',
                            'q' => 'к',
                            'r' => 'р',
                            's' => 'с',
                            't' => 'т',
                            'u' => 'у',
                            'v' => 'в',
                            'w' => 'у',
                            'x' => 'кс',
                            'y' => 'ю',
                            'z' => 'з',
                            'å' => 'о',
                            'A' => 'А',
                            'Ä' => 'Я',
                            'Å' => 'О',
                            'B' => 'Б',
                            'C' => 'Ц',
                            'D' => 'Д',
                            'E' => 'Э',
                            'F' => 'Ф',
                            'G' => 'Г',
                            'H' => 'Х',
                            'I' => 'И',
                            'J' => 'Й',
                            'K' => 'К',
                            'L' => 'Л',
                            'M' => 'М',
                            'N' => 'Н',
                            'O' => 'О',
                            'Ö' => 'Ë',
                            'P' => 'П',
                            'Q' => 'К',
                            'R' => 'Р',
                            'S' => 'С',
                            'T' => 'Т',
                            'U' => 'У',
                            'V' => 'В',
                            'W' => 'У',
                            'X' => 'Кс',
                            'Y' => 'Ю',
                            'Z' => 'З',
                            'Ck' => 'К',
                            'ck' => 'к',
                            'Yu' => 'Ю',
                            'yu' => 'ю',
                            'Ju' => 'Ю',
                            'ju' => 'ю',
                            'jy' => 'ю',
                            'Jy' => 'Ю',
                            'ja' => 'я',
                            'Ja' => 'Я',
                            'jä' => 'я',
                            'Jä' => 'Я',
                            'Ya' => 'Я',
                            'ya' => 'я',
                            'Ch' => 'Ч',
                            'ch' => 'ч',
                            'Tsh' => 'Ч',
                            'tsh' => 'ч',
                            'Ts' => 'Ц',
                            'ts' => 'ц',
                            'Sh' => 'Ш',
                            'sh' => 'ш',
                            'Shh' => 'Щ',
                            'shh' => 'щ',
                            'Shs' => 'Щ',
                            'shs' => 'щ',
                            'Jo' => 'Ё',
                            'jo' => 'ё',
                            'oi' => 'ой',
                            'Oi' => 'Ой',
                            'ai' =>'ай',
                            'Ai' =>'Ай',
                            'Ui' =>'Уй',
                            'ui' =>'уй',
                            'ii' =>'ий',
                            'Ii' =>'Ий',
                            'Ei' =>'ей',
                            'ei' =>'ей',
                            'ää' =>'яа',
                            'Ää' =>'Яа',
                            'Ee' =>'Еэ',
                            'ee' =>'еэ',
                            'io' =>'иë',
                            'Io' => 'Иë',
                            'io' =>'иë',
                            'Io' => 'Иë',
                            'Zh' => 'Ж',
                            'zh' => 'ж'
                            );
    private static $fromRu = array (
                            'а' => 'a',
                            'б' => 'b',
                            'в' => 'v',
                            'г' => 'g',
                            'д' => 'd',
                            'е' => 'e',
                            'ё' => 'io',
                            'ж' => 'zh',
                            'з' => 'z',
                            'и' => 'i',
                            'й' => 'y',
                            'к' => 'k',
                            'л' => 'l',
                            'м' => 'm',
                            'н' => 'n',
                            'о' => 'o',
                            'п' => 'p',
                            'р' => 'r',
                            'с' => 's',
                            'т' => 't',
                            'у' => 'u',
                            'ф' => 'f',
                            'х' => 'h',
                            'ц' => 'ts',
                            'ч' => 'ch',
                            'ш' => 'sh',
                            'щ' => 'sht',
                            'ъ' => 'a',
                            'ы' => 'i',
                            'ь' => 'y',
                            'э' => 'e',
                            'ю' => 'yu',
                            'я' => 'ya',
                            'А' => 'A',
                            'Б' => 'B',
                            'В' => 'V',
                            'Г' => 'G',
                            'Д' => 'D',
                            'Е' => 'E',
                            'Ж' => 'Zh',
                            'З' => 'Z',
                            'И' => 'I',
                            'Й' => 'Y',
                            'К' => 'K',
                            'Л' => 'L',
                            'М' => 'M',
                            'Н' => 'N',
                            'О' => 'O',
                            'П' => 'P',
                            'Р' => 'R',
                            'С' => 'S',
                            'Т' => 'T',
                            'У' => 'U',
                            'Ф' => 'F',
                            'Х' => 'H',
                            'Ц' => 'Ts',
                            'Ч' => 'Ch',
                            'Ш' => 'Sh',
                            'Щ' => 'Sht',
                            'Ъ' => 'A',
                            'Ы' => 'I',
                            'Ь' => 'Y',
                            'Э' => 'E',
                            'Ю' => 'Yu',
                            'Я' => 'Ya'
                            );

                                
  static public function toLatin($str)
  {
    $result = $str;
   
    $result = strtr($result, self::$toLatin);

    return $result;
  }

  static public function toLocal($str) {
    return $str;
  } 
  
  static public function toRu($str){
        $result = $str;
    	$result = strtr($result, self::$toRu);

    	return $result;
    }

 

 
}