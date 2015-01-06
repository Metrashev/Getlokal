<?php
class ForgotPasswordForm extends sfForm {
	
	public function configure() {
		
		$this->setWidget ( 'email', new sfWidgetFormInput () );
		$this->setValidator ( 'email', new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => true, 'max_length' => 100, 'trim' => true  ) ), new sfValidatorEmail ( array ('trim' => true ), array ('invalid' => 'Invalid email – your email is not in the correct format' ) ) ), array ('required' => true ), array ('required' => 'The field is mandatory' ) ) );
		$this->widgetSchema->setLabel ( 'email', 'Email' );
		$this->widgetSchema->setNameFormat ( 'forgot_password[%s]' );
		$this->addCaptcha ();
		$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
	
	}
	public function addCaptcha() {
		if (sfConfig::get ( 'app_recaptcha_active', false )) {
			$i18n = sfContext::getInstance ()->getI18N ();
			$this->setWidget ( 'captcha', new sfWidgetCaptchaGD () );
			$this->widgetSchema->setLabel ( 'captcha', 'Security check. Enter the characters from the picture below' );
     		$this->setValidator ( 'captcha', new sfCaptchaGDValidator ( array ('length' => 4 ), array ('invalid' => $i18n->__ ( 'You have entered the text incorrectly. Please try again.', null, 'errors' ), 'required' => $i18n->__ ( 'The field is mandatory', null, 'errors' ) ) ) );
			$this->validatorSchema->setOption ( 'allow_extra_fields', true );
			$this->validatorSchema->setOption ( 'filter_extra_fields', false );
		}
	
	}
}