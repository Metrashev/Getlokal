<?php

/**
 * PageAdmin form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PageAdminForm extends BasePageAdminForm {
	public function configure() {
		$this->useFields ( array ('position', 'username', 'password' ) );
		
		$this->widgetSchema ['position'] = new sfWidgetFormChoice ( array ('expanded' => false, 'choices' => Social::getI18NChoices ( Social::$positionChoicesWEmpty ) ) );
		$this->validatorSchema ['position'] = new sfValidatorChoice ( array ('required' => false, 'choices' => array_keys ( Social::$positionChoices ) ), array ('required' => 'The field is mandatory', 'invalid' => 'The field is mandatory' ) );
		
		$this->embedForm ( 'user_profile', new ClaimCompanyForm ( $this->getObject ()->getUserProfile()));
		$this->widgetSchema->setLabel ( 'position', 'Select Your Position' );
		
		if ($this->getObject ()->isNew () or !$this->getObject ()->getUsername ()) {
			$this->widgetSchema ['username'] = new sfWidgetFormInput ();
			
			$this->validatorSchema ['username'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => true, 'min_length' => 3, 'max_length' => 20), array ('min_length' => 'Username must contain at least %min_length% characters', 'max_length' => 'Username cannot contain more than %max_length% characters.' ) ), new sfValidatorRegex ( array ('pattern' => '/^[a-zA-Z0-9]([a-zA-Z0-9._-]+)$/' ), array ('invalid' => 'The username "%value%" contains characters that are not allowed' ) ) ), array ('required' => true ), array ('required' => 'The field is mandatory' ) );
			
			$this->widgetSchema ['password'] = new sfWidgetFormInputPassword ();
			$this->validatorSchema ['password'] = new sfValidatorString ( array ('required' => true, 'min_length' => 6, 'max_length' => 30 ), array ('required' => 'The field is mandatory', 'min_length' => 'Your password should be at least %min_length% characters long', 'max_length' => 'Your password cannot contain more than %max_length% characters' ) );
			if ($this->getObject ()->getUserProfile()->getPartner() != UserProfile::CRM_PARTNER){
			$this->widgetSchema ['accept'] = new sfWidgetFormInputCheckbox ( array () );
			$this->validatorSchema ['accept'] = new sfValidatorBoolean ( array ('required' => true ), array ('required' => 'You need to agree to the Terms of Use and the Policy for Use and Protection of the Information on Getlokal' ) );
			}
			$this->validatorSchema->setPostValidator ( new sfValidatorDoctrineUnique ( array ('model' => 'PageAdmin', 'column' => 'username' ), array ('invalid' => 'Username in use.' ) ) );
			
			if ($this->getObject ()->isNew ()) {
				
				/*$this->widgetSchema ['authorized'] = new sfWidgetFormInputCheckbox ();	
		$this->widgetSchema->setLabel('authorized','I declare that I am an authorized representative of the business.');
		$this->setValidator ( 'authorized', new sfValidatorBoolean ( array ('required' => true ), array ('required' => 'Declare that you are an authorized representative of the business.' ) ) );
		*/
				if ((! isset ( $this->options ['no_reg_no'] )) && ! $this->getObject ()->getCompanyPage ()->getPrimaryAdmin ()) {
					$this->widgetSchema ['registration_no'] = new sfWidgetFormInputText ();
					if ($this->getObject ()->getCompanyPage ()->getCompany ()->getCountryId () == getlokalPartner::GETLOKAL_BG) {
						$this->widgetSchema->setLabel ( 'registration_no', 'Enter the Bulstat of your business.' );
						$this->setValidator ( 'registration_no', new sfValidatorOr ( array (new sfBulstatValidator ( array ('trim' => true ), array ('required' => 'The field is mandatory', 'invalid' => 'Invalid Bulstat' ) ), new sfValidatorString ( array ('trim' => true, 'max_length' => 12 ), array ('required' => 'The field is mandatory', 'invalid' => 'Invalid Bulstat', 'max_length' => 'Invalid Bulstat' ) ) ), array (), array ('invalid' => 'Invalid Bulstat', 'required' => 'The field is mandatory' ) ) );
					} elseif ($this->getObject ()->getCompanyPage ()->getCompany ()->getCountryId () == getlokalPartner::GETLOKAL_RO) {
						$this->widgetSchema->setLabel ( 'registration_no', 'Enter the CUI of your business.' );
						$this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 12, 'required' => true, 'trim' => true ), array ('invalid' => 'Invalid CUI', 'required' => 'The field is mandatory' ) ) );
					
//					}elseif ($this->getObject ()->getCompanyPage ()->getCompany ()->getCountryId () == getlokalPartner::GETLOKAL_MK) {
//						$this->widgetSchema->setLabel('registration_no' ,  'Registration Number');
//     	                $this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 13, 'required' => true, 'trim' => true ) , array('invalid' =>  'Invalid Registration Number' ,'required' =>  'The Business\' registration number is mandatory')) );
					}elseif ($this->getObject ()->getCompanyPage ()->getCompany ()->getCountryId () == getlokalPartner::GETLOKAL_RS) {
						$this->widgetSchema->setLabel('registration_no' ,  'Registration Number');
     	                $this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 13, 'required' => true, 'trim' => true ) , array('invalid' =>  'Invalid Bulstat' ,'required' =>  'The field is mandatory')) );
					}
					elseif ($this->getObject ()->getCompanyPage ()->getCompany ()->getCountryId () == getlokalPartner::GETLOKAL_FI) {
						$this->widgetSchema->setLabel('registration_no' ,  'Registration Number');
                                                $this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 13, 'required' => true, 'trim' => true ) , array('invalid' =>  'Invalid Bulstat' ,'required' =>  'The field is mandatory')) );
					}
                                        elseif ($this->getObject ()->getCompanyPage ()->getCompany ()->getCountryId () == getlokalPartner::GETLOKAL_HU) {
						$this->widgetSchema->setLabel('registration_no' ,  'Registration Number');
                                                $this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 13, 'required' => true, 'trim' => true ) , array('invalid' =>  'Invalid Bulstat' ,'required' =>  'The field is mandatory')) );
					}
				}

		}
		if (!$this->getObject ()->getUserProfile ()->getIsPageAdminConfirmed()) {
				
			if($this->getObject ()->getUserProfile ()->getPartner() != UserProfile::CRM_PARTNER)	{
			$this->widgetSchema ['allow_b_cmc'] = new sfWidgetFormInputCheckbox ();
					$this->widgetSchema->setLabel ( 'allow_b_cmc', 'I want to receive business newsletter.' );
					$this->setValidator ( 'allow_b_cmc', new sfValidatorBoolean () );
				}
				}
		}else {
		unset($this['username'],$this['password'],$this['position']);
		}
		
		
		
		
		
		
		
		$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
	}
}
