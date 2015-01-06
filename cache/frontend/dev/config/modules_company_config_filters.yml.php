<?php
// auto-generated by sfFilterConfigHandler
// date: 2014/12/02 09:53:36


list($class, $parameters) = (array) sfConfig::get('sf_rendering_filter', array('sfRenderingFilter', array (
)));
$filter = new $class(sfContext::getInstance(), $parameters);
$this->register($filter);

list($class, $parameters) = (array) sfConfig::get('sf_remember_me_filter', array('sfGuardRememberMeFilter', null));
$filter = new $class(sfContext::getInstance(), $parameters);
$this->register($filter);

list($class, $parameters) = (array) sfConfig::get('sf_admin_remember_me_filter', array('AdminRememberMeFilter', null));
$filter = new $class(sfContext::getInstance(), $parameters);
$this->register($filter);

list($class, $parameters) = (array) sfConfig::get('sf_language_filter', array('glLocaleFilter', null));
$filter = new $class(sfContext::getInstance(), $parameters);
$this->register($filter);

// does this action require security?
if ($actionInstance->isSecure())
{
  
list($class, $parameters) = (array) sfConfig::get('sf_security_filter', array('sfBasicSecurityFilter', array (
)));
$filter = new $class(sfContext::getInstance(), $parameters);
$this->register($filter);
}

list($class, $parameters) = (array) sfConfig::get('sf_cache_filter', array('sfCacheFilter', array (
)));
$filter = new $class(sfContext::getInstance(), $parameters);
$this->register($filter);

list($class, $parameters) = (array) sfConfig::get('sf_execution_filter', array('sfExecutionFilter', array (
)));
$filter = new $class(sfContext::getInstance(), $parameters);
$this->register($filter);

