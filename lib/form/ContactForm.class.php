<?php

/**
 * Contact form.
 *
 * @package    localcocal
 * @subpackage form
 * @author     Inkata
 */
class ContactForm extends BaseForm {
	
	public function configure() {
		
	
		$this->setWidgets ( array ('email' => new sfWidgetFormInputText (), 'name' => new sfWidgetFormInputText (), 'phone' => new sfWidgetFormInputText (), 'message' => new sfWidgetFormTextarea ( array (), array ('rows' => 10, 'cols' => 32 ) ) ) );
		
		$this->setValidators ( array (
            'email'   =>  new sfValidatorAnd    ( array (
                                                      new sfValidatorString ( array ('required' => true, 'max_length' => 100 ) ), 
                                                      new sfValidatorEmail  ( array ('trim' => true ), 
                                                                              array ('invalid' => 'Invalid email' ) 
                                                              ) ), 
                                                  array ('required' => true ), 
                                                  array ('required' => 'E-mail is required.' ) 
                    ), 
            'name'    =>  new sfValidatorString ( array ('required' => true, 'trim' => true ), array ('required' => 'Your name is required.' ) ), 
            'phone'   =>  new sfValidatorAnd    ( array (
                                                      new sfValidatorString ( array ('required' => false, 'min_length' => 3, 'max_length' => 15, 'trim' => true ), 
                                                                              array ('min_length' => 'Invalid Phone Number', 'max_length' => 'Invalid Phone Number' ) 
                                                              ),
                                                      new sfValidatorRegex  ( array ('pattern' => '/^[0-9+]([0-9]+)$/' , 'required'=>false),
                                                                              array ('invalid' => 'Invalid Phone Number' ) 
                                                              ) ),                          
                                                  array ('required' => false ), 
                                                  array ('required' => 'The field is mandatory', 'invalid' => 'Invalid Phone Number' ) 
                     ), 
            'message' =>  new sfValidatorString ( array ('required' => true, 'trim' => true ), array ('required' => 'This field is required. Please type your message.', 'min_length' => 10 ) ) 
            ) );
	
		$this->widgetSchema->setNameFormat ( 'contact[%s]' );
		$this->addCaptcha ();
		
		$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
		
		$this->disableLocalCSRFProtection ();
	
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
