<?php

/**
 * Contact form.
 *
 * @package    localcocal
 * @subpackage form
 * @author     Inkata
 */
class ReportAbuseForm extends BaseForm
{
    // Properties defined here
    
    // Constructor
	public function __construct($arDefaults = array(), $arOptions = array(), $arCSRFSecret = null){
		return parent::__construct($arDefaults, $arOptions, $arCSRFSecret);
	}
    
    // Methods defined here
    public function configure(){
        $i18n = sfContext::getInstance()->getI18N();
  		$sCulture = sfContext::getInstance()->getUser()->getCulture();
        
		$this->setWidgets(
			array(
					'email' => new sfWidgetFormInputText()
					, 'name' => new sfWidgetFormInputText()
					, 'message' => new sfWidgetFormTextarea(
						array()
						, array(
							'rows' => 10
							, 'cols' => 32
						)
					)
					, 'abuseTypeID' => new sfWidgetFormChoice(
						array(
							'expanded' => false
							, 'choices' => AbuseType::GetAbuseTypeChoicesList()
						)
					)
			)
		);
        
        if ($this->options['user']){
            $this->setDefault('email', $this->options['user']->getProfile()->getEmail());
            $this->setDefault('name', $this->options['user']->getUsername());
        }
        if ($this->options['company']){   
            if ($this->options['object'] == 'picture'){
                $this->setDefault('message', $i18n->__('Inappropriate photo of ', null, 'company'));//.$this->options['company']->getDisplayTitle($sCulture));
            }
            if ($this->options['object'] == 'review'){ 
                $this->setDefault('message', $i18n->__('Inappropriate review submitted for ', null, 'company'));//.$this->options['company']->getDisplayTitle($sCulture));
            }
        }
		$this->setValidators(
			array(
				'email' => new sfValidatorAnd(
					array(
						new sfValidatorString(
							array(
								'required' => true
								, 'max_length' => 100
							)
						)
						, new sfValidatorEmail(
							array(
								'trim' => true
							)
							, array(
								'invalid' => $i18n->__('Invalid email - your email is not in the correct format', null, 'errors')
							)
						)
					)
					, array(
						'required' => true
					)
					, array(
						'required' => $i18n->__('The field is mandatory', null, 'errors')
					)
				)
				, 'name' => new sfValidatorString(
					array(
						'required' => true
						, 'trim' => true
					)
					, array(
						'required' => $i18n->__('Your name is required.', null, 'contactus')
					)
				)
				, 'message' => new sfValidatorString(
					array(
						'required' => true
						, 'trim' => true
						, 'min_length' => 10
						, 'max_length' => 300
					)
					, array(
						'required' => $i18n->__('This field is required. Please type your message.', null, 'contactus')
					)
				)
				, 'abuseTypeID' => new sfValidatorChoice(
					array(
						'required' => true
						, 'choices' => AbuseType::GetPosibleAbuseTypeChoiseList()
					)
					, array(
						'required' => $i18n->__('Abuse type is required.', null, 'errors')
						, 'invalid' => $i18n->__('Abuse type is required.', null, 'errors')
					)
				)
			)
		);
		
        
    
        $this->widgetSchema->setNameFormat('report_me[%s]');
        $this->addCaptcha();
        $this->validatorSchema->setOption('allow_extra_fields', true);    
        $this->validatorSchema->setOption('filter_extra_fields', false); 

        $this->disableLocalCSRFProtection();
    
    }
    
    public function addCaptcha(){
        if (sfConfig::get('app_recaptcha_active', false)){
            $i18n = sfContext::getInstance()->getI18N();  
            $this->setWidget('captcha', new sfWidgetCaptchaGD());
            $this->setValidator('captcha',  new sfCaptchaGDValidator(array('length' => 4), array('invalid' => $i18n->__('You have entered the text incorrectly. Please try again.', null, 'errors'),'required' => $i18n->__('This field is required'))));
            $this->validatorSchema->setOption('allow_extra_fields', true);
            $this->validatorSchema->setOption('filter_extra_fields', false);
        }	
    }
}
