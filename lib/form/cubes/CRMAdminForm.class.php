<?php
/**
 * RegisterForm for signup process and requires
 * sfGuardPlugin
 *
 * @author Rajat Pandit
 */
class CRMAdminForm extends sfGuardUserForm {
	
	public function configure() {
		$this->useFields ( array ('first_name', 'last_name', 'email_address' ) );
		
		$this->validatorSchema ['first_name'] = new sfValidatorString ( array ('max_length' => 20, 'required' => true, 'trim' => true ), array ('required' => 'The field is mandatory', 'max_length' => 'The field cannot contain more than %max_length% characters.' ) );
		
		$this->validatorSchema ['last_name'] = new sfValidatorString ( array ('max_length' => 20, 'required' => true, 'trim' => true ), array ('required' => 'The field is mandatory', 'max_length' => 'The field cannot contain more than %max_length% characters.' ) );
		
		$this->validatorSchema ['email_address'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => true, 'max_length' => 100, 'trim' => true ) ), new sfValidatorEmail ( array ('trim' => true ), array ('invalid' => 'Invalid email – your email is not in the correct format' ) ) ), array ('required' => true ), array ('required' => 'The field is mandatory' ) );
		
		/*
        $this->widgetSchema['allow_b_cmc']     =  new sfWidgetFormInputCheckbox(array('default' => 'checked'));
        $this->validatorSchema['allow_b_cmc']     = new sfValidatorBoolean();
        */
		//	$this->embedForm('user_profile', new UserProfileForm());
		//	$this->getEmbeddedForm('user_profile')->useFields ( array ('phone_number', 'gender'));
		if ($this->getObject ()->isNew ()) {
			$this->widgetSchema ['company_id'] = new sfWidgetFormInput ();
			$this->validatorSchema ['company_id'] = new sfValidatorDoctrineChoice ( array ('model' => 'Company', 'column' => 'id', 'required' => true ), array ('invalid' => 'Invalid Company', 'required' => 'Required' ) );
		} else {
			$place_admin = $this->options ['page_admin'];
			unset ( $this ['email_address'] );
			$this->widgetSchema ['status'] = new sfWidgetFormChoice ( array ('expanded' => false, 'choices' => array ('' => 'Choose... ', 'pending' => 'pending', 'approved' => 'approved', 'rejected' => 'rejected' ) ) );
			$this->setDefault ( 'status', $place_admin->getStatus () );
			$this->validatorSchema ['status'] = new sfValidatorChoice ( array ('required' => true, 'choices' => array ('pending', 'approved', 'rejected' ) ), array ('required' => 'The field is mandatory', 'invalid' => 'The field is mandatory' ) );
		   $this->setDefault ( 'position', $place_admin->getPosition()  );
		    $this->setDefault ( 'phone_number', $place_admin->getUserProfile()->getPhoneNumber()  );
		    $this->setDefault ( 'gender', $place_admin->getUserProfile()->getGender()  );
		}
		$this->widgetSchema ['phone_number'] = new sfWidgetFormInputText ();
		
		$this->validatorSchema ['phone_number'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => false, 'min_length' => 7, 'max_length' => 20, 'trim' => true ), array ('min_length' => 'Invalid Phone Number', 'max_length' => 'Invalid Phone Number' ) ), new sfValidatorRegex ( array ('pattern' => '/^[0-9+]([0-9.-]+)$/', 'required' => false ), array ('invalid' => 'Invalid Phone Number' ) ) ), array ('required' => false ), array ('required' => 'The field is mandatory', 'invalid' => 'Invalid Phone Number' ) );
		$this->widgetSchema ['position'] = new sfWidgetFormChoice ( array ('expanded' => false, 'choices' => Social::getI18NChoices ( Social::$positionChoicesWEmpty ) ) );
		
		$this->validatorSchema ['position'] = new sfValidatorChoice ( array ('required' => false, 'choices' => array_keys ( Social::$positionChoicesWEmpty ) ), array ('required' => 'The field is mandatory', 'invalid' => 'The field is mandatory' ) );
		
		$this->widgetSchema ['gender'] = new sfWidgetFormChoice ( array ('expanded' => false, 'label' => 'Gender', 'choices' => Social::getI18NChoices ( Social::$sexChoicesWEmpty ) ) );
		
		$this->validatorSchema ['gender'] = new sfValidatorChoice ( array ('required' => false, 'choices' => array_keys ( Social::$sexChoices ) ), array ('required' => 'The field is mandatory' ) );
		
		$this->validatorSchema->setOption ( 'allow_extra_fields', true );
		$this->validatorSchema->setOption ( 'filter_extra_fields', false );
		
		$this->validatorSchema->setPostValidator ( new sfValidatorDoctrineUnique ( array ('model' => 'sfGuardUser', 'column' => 'email_address' ), array ('invalid' => 'This email address has already been registered by another user' ) ) );
	
	}
	public function getAllErrors() {
		$errors = array ();
		$errors ['user'] = '';
		foreach ( $this as $form_field ) {
			if ($form_field->hasError ()) {
				$err_obj = $form_field->getError ();
				if ($err_obj instanceof sfValidatorError) {
					
					$errors ['user'] .= $err_obj;
				
				} elseif ($err_obj instanceof sfValidatorErrorSchema) {
					
					foreach ( $err_obj->getErrors () as $err ) {
						$errors [$form_field->getName ()] = $err->getMessage ();
					}
				}
			}
		}
		
		// global err
		foreach ( $this->getGlobalErrors () as $validator_err ) {
			$errors [] = $validator_err->getMessage ();
		}
		return $errors;
	}
	
	

}