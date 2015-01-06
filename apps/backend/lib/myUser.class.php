<?php

class myUser extends sfGuardSecurityUser
{
  protected $profile, $country;
  
  public function getId()
  {
    return $this->getAttribute('user_id', null, 'sfGuardSecurityUser');
  }
  
  public function getCountry()
  {
    if($this->country) return $this->country;
    
    return $this->country = Doctrine::getTable('Country')->find($this->getAttribute('country_id'));
  }
  
  public function getProfile()
  {
    if ($this->profile) return $this->profile;
  
    if (!$this->isAuthenticated() || !($this->profile = Doctrine::getTable('UserProfile')->find($this->getId())))
    {
      $this->profile = new UserProfile();
      $this->profile->setId(0);
    }
    
    return $this->profile;
      
  }
  
  public function getFlashKey()
  {
    $request = sfContext::getInstance()->getRequest();
    return 'referer_'.$request->getParameter('module').'_'.$request->getParameter('action');
  }
  
  public function setReferer($referer)
  {
    if(!$referer) $referer = '@homepage';
    
    $key = $this->getFlashKey();
    
    if (!$this->hasAttribute($key))
    {
      $this->setAttribute($key, $referer);
    }
  }
  
  public function getReferer($default)
  {
    $request = sfContext::getInstance()->getRequest();
    if(!$default) $default = $request->getReferer();
    if(!$default) $default = '@homepage';
    
    $key = $this->getFlashKey();
    
    $referer = $this->getAttribute($key, $default);
    $this->getAttributeHolder()->remove($key);

    return $referer;
  }

  public function getAdminCompanies()
  {
    return array();
  }
}
