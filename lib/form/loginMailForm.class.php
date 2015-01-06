<?php

class loginMailForm extends sfForm {
    public function configure() {
        $this->i18n = sfContext::getInstance()->getI18N();

        // Widgets
        $this->setWidget('email_password', new sfWidgetFormInputPassword());

        // Validators
        /*$this->setValidator('email_password', new sfValidatorString(
                array(
                    'required' => true,
                    'min_length' => 6,
                    'max_length' => 30,
                    'trim' => true
                )
        ));*/

        $this->setValidator('email_password', new sfValidatorString(array('trim' => true), array('required' =>  'Password is mandatory')));

        $this->widgetSchema->setLabel(
            'email_password', $this->i18n->__('E-mail password',null,'user')
        );


        // Add custom widget(s) if form isn`t short
        if ($this->getOption('isShort') === false) {
            $this->setWidget('email_address', new sfWidgetFormInputText());

            $this->setValidator('email_address', new sfValidatorAnd(
                array(
                    new sfValidatorString(array('required' => true, 'max_length' => 50, 'trim' => true)),
                    new sfValidatorEmail(
                        array('trim' => true), 
                        array('invalid'=>'Invalid email – your email is not in the correct format')
                    )
                ),

                array('required' => true),
                array('required'=> 'The field is mandatory')
            ));

            $this->widgetSchema->setLabel(
                'email_address', $this->i18n->__('Email Address', null,'user')
            );

            $this->useFields(
                array(
                    'email_address',
                    'email_password'
                )
            );
        }
        else {
            $this->useFields(array('email_password'));
        }

        if ($this->getOption('removeCSRF') === true) {
            $this->disableCSRFProtection();
        }

        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');
        $this->widgetSchema->setNameFormat('loginMail[%s]');
    }
}