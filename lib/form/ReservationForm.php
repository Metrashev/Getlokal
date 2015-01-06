<?php

class ReservationForm extends sfForm {

 	private static $reservationType;

	public static function setReservationType($set) { 
		self::$reservationType = $set; 
	}

	public function configure() {
		$this->setWidgets(
			array('email' => new sfWidgetFormInputText(),
			   	  'name' => new sfWidgetFormInputText(),
			   	  'phone' => new sfWidgetFormInputText(), 
			   	  'about' => new sfWidgetFormTextarea ( array (), array ('rows' => 5, 'cols' => 30 ) ),
			   	  'time' => new sfWidgetFormChoice(array('choices' => array(''))),
			   	  'people' => new sfWidgetFormInputText(),
			   	  'nights' => new sfWidgetFormInputText(),
			   	  'start_date' => new sfWidgetFormInput(),
			   	  'end_date' => new sfWidgetFormInput()
			));

		$this->setValidators(
			array('email' => new sfValidatorEmail(array('trim' => true), array('required' => 'The field is mandatory', 'invalid' => 'Invalid email – your email is not in the correct format')),
				  'name' => new sfValidatorString(array('required' => false, 'trim' => true, 'max_length' => 100)),
				  'phone' => new sfValidatorAnd(array(
				  	new sfValidatorString(array('required' => true, 'trim' => true, 'min_length' => 3, 'max_length' => 15),
				  						  array('required' => 'The field is mandatory', 'min_length' => 'Invalid Phone Number', 'max_length' => 'Invalid Phone Number')),
				    new sfValidatorRegex(array('required' => true, 'pattern' => '/^[0-9+]([0-9]+)$/'), 
				    					 array('required' => 'The field is mandatory', 'invalid' => 'Invalid Phone Number'))),
				     					 array('required' => true), array('required' => 'The field is mandatory')),
				  'about' => new sfValidatorString(array('required' => false, 'trim' => true)),
				  'people' => new sfValidatorInteger(array('required' => true, 'trim' => true), array('required'=>'The field is mandatory')),
				  'nights' => new sfValidatorInteger(array('required' => true, 'trim' => true), array('required'=>'The field is mandatory')),
				  'time' => new sfValidatorString(array('required' => true), array('required'=>'The field is mandatory')),
				  'start_date' => new sfValidatorString(array('required' => true), array('required'=>'The field is mandatory')),
				  'end_date' => new sfValidatorString(array('required' => true), array('required'=>'The field is mandatory'))
		));

		if(self::$reservationType == 'hotel') {
			unset($this['time']);
            	  $this->widgetSchema->setLabels(array('start_date' => 'Start Date'));
			
		} 
		elseif (self::$reservationType == 'restaurant') {
			unset($this['end_date'],
				  $this['nights']);
                  $this->widgetSchema->setLabels(array('start_date' => 'Booking Date'));
		}
 
		$this->widgetSchema->setLabels(
			array('about' => 'Additional Information',
				  'people' => 'Number of Guests',
			   	  'nights' => 'Number of Nights',
			   	  'time' => 'Time',
			   	  'end_date' => 'End Date'
		));

		$this->widgetSchema->setNameFormat ('reservation[%s]');
		$this->addCaptcha();
		$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ('form');	
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
