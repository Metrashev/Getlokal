<?php
 
class myValidatorTwitter extends sfValidatorUrl//sfValidatorBase
{
	
  protected function doClean($value)
  {
    $clean = (string) trim($value);
	
//    $reg=  '|(https)?[\:\/\/]?[twitter.com\/]?(\@[^#]+)|im';
    $reg=  '|(https)?[\:\/\/]?[twitter.com\/]?(\@[a-zA-Z0-9_]{1,15}$)|im';
    
    if (preg_match($reg, $clean, $matches)){
    	$clean= "https://twitter.com/{$matches[2]}";
    }
   	else {
   		throw new sfValidatorError($this, 'invalid', array('value' => $value));
   	}
   	
   	return $clean;
  }
}