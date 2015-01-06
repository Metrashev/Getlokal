<?php
class ChangeUsernameForm extends PluginsfGuardUserForm
{
  public function configure()
  {    
   $this->useFields(array('username'));
   $this->widgetSchema['username']  = new sfWidgetFormInput();
   $this->widgetSchema->setLabels ( array 
		(
		'username' => 'Username'
		 ) );
    $this->validatorSchema['username']  = new sfValidatorAnd(array(
        new sfValidatorString(array('required'=>true,
                                    'min_length' => 3, 
                                    'max_length' => 20),
        array('min_length'=>'Username must contain at least %min_length% characters',
        'max_length' =>'Username cannot contain more than %max_length% characters.')),
        new sfValidatorRegex(array('pattern' => '/^[a-zA-Z0-9]([a-zA-Z0-9._-]+)$/'), 
                             array('invalid' => 'The username "%value%" contains characters that are not allowed')),
        new sfValidatorBlacklist(array('case_sensitive'=> false, 
                                       'forbidden_values' => sfConfig::get('app_people_forbidden_names', array())
        ), array('forbidden' => 'Username "%value%" cannot be used')),
      ),array('required'=> true),array('required'=>'The field is mandatory'));
     
      
     $this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
    $this->widgetSchema->setNameFormat('change_email[%s]');
    
  }
}