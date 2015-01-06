<?php
/*
 * This file is part of the isicsBreadcrumbsPlugin package.
 * Copyright (c) 2008 ISICS.fr <contact@isics.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class isicsBreadcrumbsItem
{
  protected $text;
  protected $uri;
    
  /**
   * Constructor
   *
   */    
  public function __construct($text, $uri = null)
  {
  	$i18n = sfContext::getInstance()->getI18N();
    $this->text = $i18n->__($text);
    $this->uri  = $uri;
  }
  
  /**
   * Retrieve the uri of the item
   *
   */  
  public function getUri()
  {
    return $this->uri;
  }
  
  /**
   * Retrieve the text of the item
   *
   */  
  public function getText()
  {
    return $this->text;
  }
}

class breadCrumb
{
  static    $instance = null;
  protected $items    = array();
  
  /**
   * Constructor
   *
   */
  protected function __construct()
  {
    $county = sfContext::getInstance()->getRequest()->getParameter('county', false);
    $domain = getlokalPartner::getInstanceDomain();
    $city = sfContext::getInstance()->getRequest()->getParameter('city', false);
    $routeName = sfContext::getInstance()->getRouting()->getCurrentRouteName();
    
    if ($county || (($county || $domain == 78) && !($city)) || ($routeName == 'company' && $domain == 78)) {
  		$this->setRoot(sfContext::getInstance()->getUser()->getCounty()->getLocation(), '@homeCounty?county='.sfContext::getInstance()->getUser()->getCounty()->getSlug());
  	}
  	else {
  		$this->setRoot(sfContext::getInstance()->getUser()->getCity()->getLocation(), '@home?city='.sfContext::getInstance()->getUser()->getCity()->getSlug());
  	}
  }

  /**
   * Listens to the template.filter_parameters event.
   *
   * @param  sfEvent $event       An sfEvent instance
   * @param  array   $parameters  An array of template parameters to filter
   *
   * @return array   The filtered parameters array
   */
  public static function filterTemplateParameters(sfEvent $event, $parameters)
  {
    $parameters['breadcrumbs'] = breadCrumb::getInstance();
    
    return $parameters;
  }

  /**
   * Add an item
   *
   * @param string $text
   * @param string $uri
   */
  public function addItem($text, $uri = null)
  { 
    array_push($this->items, new isicsBreadcrumbsItem($text, $uri));
  }

  /**
   * Alias of addItem()
   *
   * @see addItem
   */
  public function add($text, $uri = null)
  {
    $this->addItem($text, $uri);
  }

  /**
   * Delete all existings items
   *
   */
  public function clearItems()
  {
    $this->items = array();
  }  
  
  /**
   * Get the unique isicsBreadcrumbs instance (singleton)
   *
   * @return breadCrumb
   *
   */
  public static function getInstance()
  {
    if (is_null(self::$instance))
    {
      self::$instance = new breadCrumb();
    }
    
    return self::$instance;
  }
  
  
  /**
   * Retrieve an array of isicsBreadcrumbsItem
   *
   * @param int $offset
   *
   * @return array
   */
  public function getItems($offset = 0)
  {
    return array_slice($this->items, $offset);
  }
    
  /**
   * Redefine the root item
   *
   */
  public function setRoot($text, $uri)
  {
    $this->items[0] = new isicsBreadcrumbsItem($text, $uri);
  }
  
  public function removeRoot()
  { 
   return array_shift($this->items);
  }
}
