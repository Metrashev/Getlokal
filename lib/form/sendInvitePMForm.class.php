<?php

class sendInvitePMForm extends sfForm {
    private $emailDefaultValue = 'E-mail address';

    public function configure() {
        $this->i18n = sfContext::getInstance()->getI18N();

        for ($i = 1; $i <= 5; $i++) {
            $this->widgetSchema['email_' . $i] = new sfWidgetFormInputText();

            $this->validatorSchema['email_' . $i] = new sfValidatorAnd(
                array(
                    new sfValidatorString(array('required' => false, 'max_length' => 50, 'trim' => true)),
                    new sfValidatorEmail(
                        array('trim' => true), 
                        array('invalid' => 'Invalid email – your email is not in the correct format')
                    ),
                    new sfValidatorCallback(array('callback' => array($this, 'checkIfUserExists'))),
                ),

                array('required' => false),
                array('required' => 'The field is mandatory')
            );

            $this->widgetSchema->setLabels(array('email_' . $i => $this->i18n->__('Email Address', null, 'user') . ' ' . $i));

            //$this->setDefault('email_' . $i, $this->emailDefaultValue . ' ' . $i);
        }


        $this->widgetSchema['body'] = new sfWidgetFormTextarea();

        $this->validatorSchema['body'] = new sfValidatorString(array('min_length' => 1, 'trim' => true, 'required' => true), array('required' => 'The field is mandatory')/*, array('min_length' => 'Body is too short')*/ );

        $this->widgetSchema->setLabels(array('body' => $this->i18n->__('Message', null, 'user')));

        $bodyText = $this->getOption('body');

        $this->setDefault('body', $bodyText);

        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');
        $this->widgetSchema->setNameFormat('sendInvitePM[%s]');
        $this->addCaptcha();
    }

    public function checkIfUserExists($validator, $value) {
        $this->i18n = sfContext::getInstance()->getI18N();

        if ($user = Doctrine::getTable('SfGuardUser')->findOneByEmailAddress($value)) {
            throw new sfValidatorError($validator, $this->i18n->__('User with same e-mail address is already registered!', null, 'user'));
        }
        else {
            return $value;
        }
    }
 
    public function bind(array $taintedValues = null, array $taintedFiles = null) {
        /*
        foreach ($taintedValues as $name => $value) {
            if (strpos($value, $this->emailDefaultValue) !== false) unset($taintedValues[$name]);
        }
        */

        $errors = 0;

        if ($taintedValues && count($taintedValues)) {
            foreach ($taintedValues as $name => $value) {
                if (strpos($name, 'email_') !== false && !$value) {
                    $errors++;

                    unset($taintedValues[$name]);
                }
            }
        }
        
        if ($errors == 5 || !$taintedValues || !count($taintedValues)) {
            $this->getErrorSchema()->addError(new sfValidatorError(new sfValidatorString(), "The field is mandatory"), "email_1");
        }
        else {
            return parent::bind($taintedValues, $taintedFiles);
        }
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