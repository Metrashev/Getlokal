<?php
class ForgotPasswordAdminForm extends sfForm {
	
	public function configure() {
		
		$this->widgetSchema ['username']= new sfWidgetFormInput();
		 
		 $this->validatorSchema ['username']  = new sfValidatorAnd(array(
        new sfValidatorString(array('required'=>true,
                                    'min_length' => 3, 
                                    'max_length' => 20),
        array('min_length'=> 'Username must contain at least %min_length% characters.',
        'max_length' =>'Username cannot contain more than %max_length% characters.')),
        new sfValidatorRegex(array('pattern' => '/^[a-zA-Z0-9]([a-zA-Z0-9._-]+)$/'), 
                             array('invalid' => 'The username "%value%" is invalid.'))       
      ),array('required'=> true),array('required'=>'The field is mandatory'));
        $this->widgetSchema->setLabel ( 'username', 'Username' );
		$this->widgetSchema->setNameFormat ( 'forgot_password[%s]' );
		$this->addCaptcha ();
		$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
	
	}
	public function addCaptcha() {
		if (sfConfig::get ( 'app_recaptcha_active', false )) {			
			$this->setWidget ( 'captcha', new sfWidgetCaptchaGD () );
			$this->widgetSchema->setLabel ( 'captcha', 'Security check. Enter the characters from the picture below' );
     		$this->setValidator ( 'captcha', new sfCaptchaGDValidator ( array ('length' => 4 ), array ('invalid' => 'You have entered the text incorrectly. Please try again.', 'required' =>'The field is mandatory' ) ) );
			$this->validatorSchema->setOption ( 'allow_extra_fields', true );
			$this->validatorSchema->setOption ( 'filter_extra_fields', false );
		}
	
	}
}