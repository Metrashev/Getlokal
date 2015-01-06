<?php
  class PlaceAdminActivateForm extends BasesfGuardFormSignin
  {
    public function configure()
    {
       $this->setWidgets(array(
      'username' => new sfWidgetFormInputText(),
      'password' => new sfWidgetFormInputPassword(array('type' => 'password')),
      'allow_b_cmc' => new sfWidgetFormInputCheckbox(array('default' => 'checked')),
      'accept' => new sfWidgetFormInputCheckbox(array()),
      'remember' => new sfWidgetFormInputCheckbox(),
    ));
    	
    	
    
    	
     $this->widgetSchema->setLabels(array(
      'username' => 'E-mail:',
      'password' => 'Password:',  	
  	  'remember' => 'Remember me'
    ));
    
   
    
      $this->setValidators(array(
      'username' => new sfValidatorEmail(array('trim' => true), array('invalid' => 'Invalid email – your email is not in the correct format', 'required' => 'Email is required')),
      'password' => new sfValidatorString(array('trim' => true), array('required' =>  'Password is mandatory')),
      'allow_b_cmc' => new sfValidatorBoolean(),
      'accept'=> new sfValidatorBoolean( 
      array('required' => true),
      array('required' => 'You need to agree to the Terms of Use and the Policy for Use and Protection of the Information on Getlokal')
    ),
      'remember' => new sfValidatorPass(),
     
    ));
    
   
     $this->validatorSchema->setPostValidator(new placeAdminValidatorUser());
      $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');
      $this->widgetSchema->setNameFormat('signin_admin[%s]');
    }

}