<?php
require_once dirname(__FILE__).'/../lib/symfony/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->setCacheDir(dirname(__FILE__).'/../cache/');    
    $this->enablePlugins('sfDoctrinePlugin');
    $this->enablePlugins('sfDoctrineGuardPlugin');
    $this->enablePlugins('sfDoctrineNestedSetPlugin');
    $this->enablePlugins('sfWpAdminPlugin');
    $this->enablePlugins('sfJqueryReloadedPlugin');
    $this->enablePlugins('sfFormExtraPlugin');
    $this->enablePlugins('sfCaptchaGDPlugin');
    $this->enablePlugins('sfGdataPlugin');
    $this->enablePlugins('sfFeed2Plugin');
    $this->enablePlugins('sfWebBrowserPlugin');    
    $this->enablePlugins('sfMyThumbnailPlugin');
    $this->enablePlugins('sfXssSafePlugin');
  }
  
  static function nowAlt($type = null){
  	if(is_null($type) || $type == 0){
  		$return = '"'.date('Y-m-d H:i:s', time()).'"';
  	}else{
  		$return = "'".date('Y-m-d H:i:s', time())."'";
  	}
  	//$return = addslashes($return);
  	return $return;
  }
  
  static function validateIPAddress(){
  	$arBlockedIPs = array(
  			'117.42.210.18',
  	);
  	if(in_array($_SERVER['REMOTE_ADDR'], $arBlockedIPs)){
  		die('<h1>404 Error Page</h1>');
  	}
  }
  
  public function configureDoctrine(Doctrine_Manager $manager)
  {

	if(extension_loaded('memcache') ){
	  	$options = array(
	  			"servers"=> array("host"=>"localhost"),
	  			"compression"=>false
	  		);
		$DCAPC = new Doctrine_Cache_Memcache($options);
// 		var_dump($DCAPC->deleteAll());die;
	}else{
		$DCAPC = new Doctrine_Cache_Apc();	
	}
	$manager->setAttribute(Doctrine_Core::ATTR_RESULT_CACHE, $DCAPC);
  	
  }
  
}
