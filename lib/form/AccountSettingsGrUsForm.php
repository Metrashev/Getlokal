<?php
class AccountSettingsGrUsForm extends sfGuardUserForm
{
public function configure()
  {
   
    parent::configure();

    unset(
      $this['email_address'],    
      $this['password']
    ); 
  
  }
}