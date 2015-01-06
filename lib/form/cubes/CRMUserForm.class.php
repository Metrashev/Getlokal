<?php
/**
 * RegisterForm for signup process and requires
 * sfGuardPlugin
 *
 * @author Rajat Pandit
 */
class CRMUserForm extends sfGuardUserForm {
	
public function configure() {
		$this->useFields ( array ('first_name', 'last_name', 'email_address' ) );
		
		$this->validatorSchema ['first_name'] = new sfValidatorString ( array ('max_length' => 20, 'required' => true, 'trim' => true ), array ('required' => 'First Name is required', 'max_length' => 'First Name cannot contain more than %max_length% characters.' ) );
		
		$this->validatorSchema ['last_name'] = new sfValidatorString ( array ('max_length' => 20, 'required' => true, 'trim' => true ), array ('required' => 'Last Name is required', 'max_length' => 'Last Name cannot contain more than %max_length% characters.' ) );
		
		$this->validatorSchema ['email_address'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => true, 'max_length' => 100, 'trim' => true ) ), new sfValidatorEmail ( array ('trim' => true ), array ('invalid' => 'Invalid email – your email is not in the correct format' ) ) ), array ('required' => true ), array ('required' => 'The field is mandatory' ) );
		if (!$this->getObject ()->isNew ()) {
		  unset($this['email_address']);
		}
		$user_profle = $this->getObject()->getUserProfile();
		$this->embedForm('user_profile', new UserProfileCrmForm($user_profle));
		
		$this->validatorSchema->setOption ( 'allow_extra_fields', true );
		$this->validatorSchema->setOption ( 'filter_extra_fields', false );
		if ($this->getObject ()->isNew ()) {
		  $this->validatorSchema->setPostValidator ( new sfValidatorDoctrineUnique ( array ('model' => 'sfGuardUser', 'column' => 'email_address' ), array ('invalid' => 'This email address has already been registered by another user' ) ) );
		}
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
