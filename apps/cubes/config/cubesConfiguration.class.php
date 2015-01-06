<?php

class cubesConfiguration extends sfApplicationConfiguration
{
 protected $frontendRouting=null;
  public function configure()
  {  	
  
   $this->dispatcher->connect('user.write_log', array('LogUserListener',
                                                                 'listenToWriteLog'));
  }
public function generateFrontendUrl($name, $parameters = array(), $popup = true)
  {
  	if ($popup == false) 	return $this->getFrontendRouting()->generate($name, $parameters);
  	$domain = sfContext::getInstance()->getRequest()->getHost();

    if(!preg_match("~^(?:f|ht)tps?://~i", $domain)){
      return 'http://'.$domain. $this->getFrontendRouting()->generate($name, $parameters);
    }

  	return $domain. $this->getFrontendRouting()->generate($name, $parameters);
  }
 
  public function getFrontendRouting()
  {
    if (!$this->frontendRouting)
    {
      $this->frontendRouting = new sfPatternRouting(new sfEventDispatcher());
 
      $config = new sfRoutingConfigHandler();
      $routes = $config->evaluate(array(sfConfig::get('sf_apps_dir').'/frontend/config/routing.yml'));
 
      $this->frontendRouting->setRoutes($routes);
    }
 
    return $this->frontendRouting;
  }
}
