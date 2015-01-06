<?php

/**
 * BGGrammar class
 *
 * This class contains singelton for BGGrammar usage
 *
 */
class StemmerBg
{
  private $resource;
  private function __construct()
  {
    $this->resource = bggrammar_init();
  }

  /**
   * returns array of all root words for this word
   *
   * @param string $word
   * @return array
   */
  public static function stem($word)
  {  
    return bggrammar_get_root_word_list(self::getInstance()->resource, $word);
  }

  /**
   * Singletron - returns one instance of dictionaries
   *
   * @return BGGrammar
   */
  static function getInstance()
  {
    static $instance = null;
    if (is_null($instance))
    {
      $instance = new self();
    }
   
    return $instance;
  }
}

/*
  Fake BGGrammar function definitions for windows users
*/
if (!extension_loaded('bggrammar'))
{
  function bggrammar_init() { return 'Fake Resource';}
  function bggrammar_get_root_word_list($res, $word) { return array($word); }
}
