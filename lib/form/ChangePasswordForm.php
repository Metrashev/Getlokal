<?php

class ChangePasswordForm extends PluginsfGuardUserForm
{
  public function configure()
  {
  
    
   $this->setWidgets(array(     
        'old_password'    => new sfWidgetFormInputPassword(),
        'new_password'    => new sfWidgetFormInputPassword(),
        'bis_password'    => new sfWidgetFormInputPassword(),
      ));
      
     $this->widgetSchema->setLabels(array(
      'old_password' => 'Current Password',
      'new_password' => 'New Password',
      'bis_password' => 'Retype New Password'
     ));

    $this->setValidators(array(
        'old_password'      => new sfValidatorCallback(array('required'=>true,'callback'=>array($this,'verifyPassword')),array('invalid'=>'Incorrect Password','required'=>'The field is mandatory')),
        'new_password'      => new sfValidatorString(array('required'=> true,
            'min_length' => 6, 
            'max_length' => 30, 'trim' => true ),
          array('required' => 'The field is mandatory',
            'min_length' =>'Your password should be at least %min_length% characters long',
            'max_length' =>'Your password cannot contain more than %max_length% characters')),
        'bis_password'      => new sfValidatorString(array('required'=> true,
            'min_length' => 6, 
            'max_length' => 30, 'trim' => true ),
          array('required' => 'The field is mandatory',
            'min_length' =>'Your password should be at least %min_length% characters long',
            'max_length' =>'Your password cannot contain more than %max_length% characters')),
      ));

    $this->widgetSchema->setNameFormat('change_password[%s]');
	
    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
          new sfValidatorSchemaCompare('new_password', sfValidatorSchemaCompare::EQUAL, 'bis_password',
          array(),
          array('invalid' => 'The passwords do not match'))
        )));

   $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
   $this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
   	parent::configure();
   $this->useFields(array('old_password','new_password','bis_password'));
   
  }

  public function verifyPassword($validator, $password, $arguments)
  {  

    $error = $this->getObject()->checkPassword($password);
 $i18n  = sfContext::getInstance()->getI18N();
    if ($error == 0)
    {
      throw new sfValidatorErrorSchema(new sfValidatorString(array('trim' => true) ), array(
          $this->getOption('old_password') => new sfValidatorError($validator, $i18n->__('Incorrect Password',null,'form')),
        ));
    }

  }

}