<?php

class AccountSettingsForm extends UserProfileForm
{
  public function configure()
  {
  	$i18n = sfContext::getInstance()->getI18N();  
    parent::configure();
	
    $guard_form = new sfGuardUserForm($this->getObject()->getSfGuardUser());
    $guard_form->useFields(array(
      'first_name',
      'last_name'
    ));

    $this->widgetSchema ['gender'] = new sfWidgetFormChoice(array('expanded' => false, 'label' => 'Gender', 'choices' => Social::getI18NChoices(Social::$sexChoicesWEmpty)));
    $this->validatorSchema ['gender'] = new sfValidatorChoice(array('required' => false, 'choices' => array_keys(Social::$sexChoices)), array('required' => 'The field is mandatory'));
    
    if ($this->getObject()->getIsPageAdmin()){
        $this->validatorSchema['gender']->setOption('required', true);
        
        $this->validatorSchema ['phone_number'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => true, 'min_length' => 7, 'max_length' => 20, 'trim' => true  ), array ('min_length' => 'Invalid Phone Number', 'max_length' => 'Invalid Phone Number' ) ), new sfValidatorRegex ( array ('pattern' => '/^[0-9+]([0-9.-]+)$/' ), array ('invalid' => 'Invalid Phone Number' ) ) ), 
            array ('required' => true ), array ('required' => 'The field is mandatory' , 'invalid' => 'Invalid Phone Number') );			
    }

    if (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_RS) {
        $this->validatorSchema['gender']->setOption('required', true);
    }

    $this->embedForm('sf_guard_user', $guard_form);
  }
  
  public function getAllErrors() {
		$err = array ();
		foreach ( $this as $form_field ) {
			if ($form_field->hasError ()) {
				$err_obj = $form_field->getError ();
				if ($err_obj instanceof sfValidatorErrorSchema) {
					foreach ( $err_obj->getErrors () as $err ) {
						$err [$form_field->getName ()] = $err->getMessage ();
					}
				} else {
					$err [$form_field->getName ()] = $err_obj->getMessage ();
				}
			}
		}
		// global err
		foreach ( $this->getGlobalErrors () as $validator_err ) {
			$err [] = $validator_err->getMessage ();
		}
		return $err;
	}
}