<?php

class defaultActions extends sfActions 
{
  /*public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'getApp');
  }*/
  
  public function executeGetApp(sfWebRequest $request)
  {
    $agent = $request->getHttpHeader('User-Agent');
    $this->url = array(
                      0        => 'http://app.getlokal.com',
                      'google' => 'http://bit.ly/getlokaldroid',
                      'apple'  => 'http://bit.ly/getlokalios'
                      );
    
    if(strstr($agent, 'Android'))
    {
      $this->url[0] = $this->url['google'];
    }
    
    if(strstr($agent, 'iPhone') || strstr($agent, 'iPad'))
    {
      $this->url[0] = $this->url['apple'];
    }
    
    $this->getResponse()->addHttpMeta('refresh', '3;'.$this->url[0]);
  }
}