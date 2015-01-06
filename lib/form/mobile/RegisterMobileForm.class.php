<?php

/**
 * RegisterForm for signup process and requires
 * sfGuardPlugin
 *
 * @author Rajat Pandit
 */
class RegisterMobileForm extends BasesfGuardRegisterForm {
	public function configure() {
		
		$facebook_user_data = $this->getOption ( 'facebook_user_data', null );
		
		$this->widgetSchema ['allow_contact'] = new sfWidgetFormInputCheckbox ( array ('default' => 'checked' ) );
		$this->validatorSchema ['allow_contact'] = new sfValidatorBoolean ();
		
		$this->widgetSchema ['accept'] = new sfWidgetFormInputCheckbox ( array () );
		$this->validatorSchema ['accept'] = new sfValidatorBoolean ( array ('required' => true ), array ('required' => 'You need to agree to the Terms of Use and the Policy for Use and Protection of the Information on Getlokal' ) );
		
		$this->validatorSchema ['first_name'] = new sfValidatorString ( array ('max_length' => 20, 'required' => true, 'trim' => true ), array ('required' => 'The field is mandatory', 'max_length' => 'The field cannot contain more than %max_length% characters.' ) );
		
		$this->validatorSchema ['last_name'] = new sfValidatorString ( array ('max_length' => 20, 'required' => true, 'trim' => true ), array ('required' => 'The field is mandatory', 'max_length' => 'The field cannot contain more than %max_length% characters.' ) );
		
		$this->validatorSchema ['email_address'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => true, 'max_length' => 100, 'trim' => true ) ), new sfValidatorEmail ( array ('trim' => true ), array ('invalid' => 'Invalid email – your email is not in the correct format' ) ) ), array ('required' => true ), array ('required' => 'Email is required' ) );
		
		$this->validatorSchema ['password'] = new sfValidatorString ( array ('required' => true, 'min_length' => 6, 'max_length' => 30, 'trim' => true ), array ('required' => 'The field is mandatory', 'min_length' => 'Your password should be at least %min_length% characters long', 'max_length' => 'Your password cannot contain more than %max_length% characters' ) );
		
		
		
		
		$this->widgetSchema ['location'] = new sfWidgetFormDoctrineJQueryAutocompleter ( array ('model' => 'City', 'method' => 'getLocation', 'url' => sfContext::getInstance ()->getController ()->genUrl ( array ('module' => 'api2', 'action' => 'getCitiesAutocomplete', 'route' => 'default' ) ), 'config' => ' {
            scrollHeight: 250,
            autoFill: false,
            cacheLength: 1,
            delay: 1,
            max: 10,
            minChars:0
        }' ) );
	    $this->validatorSchema['location'] = new sfValidatorPass();
		$this->validatorSchema ['location']->setOption ( 'required', false );
		
	
		
		$facebook_user_data = $this->getOption('fb', null);
	    if ($facebook_user_data) {	    	   

            unset($this['password']);
	    
	    
	    }
		
		

		$this->validatorSchema->setPostValidator ( new sfValidatorAnd ( array (new sfValidatorDoctrineUnique ( array ('model' => 'sfGuardUser', 'column' => 'email_address' ), array ('invalid' => 'This email address has already been registered by another user' ) ), new sfValidatorDoctrineUnique ( array ('model' => 'sfGuardUser', 'column' => 'username' ), array ('invalid' => 'This username has already been registered by another user'))
        )));
       
    }

 
}