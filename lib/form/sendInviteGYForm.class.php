<?php

class sendInviteGYForm extends sfForm {
    public function configure() {
        $this->i18n = sfContext::getInstance()->getI18N();

        $emails = $this->getOption('emails');

        if (!$emails && !count($emails) && sfContext::getInstance()->getUser()->hasAttribute('emailList_static')) {
            $emails = sfContext::getInstance()->getUser()->getAttribute('emailList_static', array());
        }

        //http://stackoverflow.com/questions/3861971/sfvalidatorchoice-not-working-on-multiple-selection-element
        $this->widgetSchema['email_lists'] = new sfWidgetFormChoice(array('choices' => $emails, 'multiple' => true, 'expanded' => true, 'renderer_options' => array('formatter' => array('sendInviteGYForm', 'MyChoiseFormatter'))));

        $this->widgetSchema['body'] = new sfWidgetFormTextarea();

        //$this->validatorSchema ['email_lists'] = new sfValidatorChoice(array('required' => true, 'multiple' => true, 'choices' => array_keys($emails)), array ('required' => 'The field is mandatory'));

        $this->validatorSchema['email_lists'] = new sfValidatorAnd(
            array(
                new sfValidatorChoice(array('required' => true, 'multiple' => true, 'choices' => array_keys($emails)), array('required' => 'The field is mandatory')),
                new sfValidatorCallback(array('callback' => array($this, 'checkIfUserExists'))),
            ),
            array('required' => true),
            array('required' => 'The field is mandatory')
        );

        //$this->widgetSchema['email_lists']->setOption('required', '');

        $this->validatorSchema['body'] = new sfValidatorString(array('min_length' => 1, 'trim' => true), array('required' => 'The field is mandatory')/*, array('min_length' => 'Body is too short')*/ );

        $this->widgetSchema->setLabels(array('email_lists' => $this->i18n->__('Email list', null, 'user'), 'body' => $this->i18n->__('Message', null, 'user')));

        $bodyText = $this->getOption('body');
        $this->setDefault('body', $bodyText);

        if ($this->getOption('removeCSRF') === true) {
            $this->disableCSRFProtection();
        }

        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');
        $this->widgetSchema->setNameFormat('sendInviteGY[%s]');
        $this->addCaptcha();
    }

    public function checkIfUserExists($validator, $value) {
        $this->i18n = sfContext::getInstance()->getI18N();
        $message = array();

        foreach ($value as $key => $email) {
            if ($user = Doctrine::getTable('SfGuardUser')->findOneByEmailAddress($email)) {
                $message[] = sprintf($this->i18n->__('User with same %s e-mail address is already registered!', null, 'user'), $email);
            }
        }

        if (!$message) {
            return $value;
        }
        else {
            throw new sfValidatorError($validator, implode("<br />", $message));
        }
    }

    public static function MyChoiseFormatter($widget, $inputs) {
        $result = '<ul class="checkbox_list overview">';

        foreach ($inputs as $input) {
            $result .= '<li>' . $input ['input'] . $input ['label']  . '</li>';
        }

        $result .= '</ul>';

        return $result;
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
