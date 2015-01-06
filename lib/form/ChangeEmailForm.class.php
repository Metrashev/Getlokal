<?php 
class ChangeEmailForm extends PluginsfGuardUserForm
{
  public function configure()
  { 	
  	$this->useFields(array('email_address'));  
    $this->setWidgets(array(  
      'email_address'     => new sfWidgetFormInput(),
    ));
  
    $this->setValidators(array(
       'email_address' =>  new sfValidatorAnd(array(
          new sfValidatorString(array('required'=>true,'max_length' => 100, 'trim' => true)),
          new sfValidatorEmail(array('trim' => true),array('invalid'=>'Invalid email – your email is not in the correct format'))
        ),array('required'=> true),array('required'=> 'The field is mandatory')),
    ));
 
    $this->widgetSchema->setLabel(
      'email_address', 'Enter New Email' );
 
    
    $this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
    $this->widgetSchema->setNameFormat('change_email[%s]');
  }
}