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
   
  public function getAdminCompanies()
  {
    return array();
  }
}