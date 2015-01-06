<?php

/**
 * PageAdmin form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class AddCompanyPageAdminClaimForm extends UserProfileForm {
	public function configure() {
		$years = range ( (date ( 'Y' ) - 16), 1930 );
		$years_list = array_combine ( $years, $years );
		parent::configure ();
		unset ( $this ['summary'],$this ['country_id'],$this ['city_id'],$this ['birthdate'],$this ['blog_url']
		,$this ['facebook_url'],$this ['twitter_url'],$this ['website'], $this ['google_url']);
       
		
		if (!$this->getObject ()->getSfGuardUser ()->getFirstName() or 	!$this->getObject ()->getSfGuardUser ()->getLastName())
		{
			
		$guard_form = new sfGuardUserForm ( $this->getObject ()->getSfGuardUser () );
		 unset ( $guard_form ['id'], $guard_form ['password'],$guard_form ['email_address']);
		 if ($this->getObject ()->getSfGuardUser ()->getFirstName())
		{
		  unset($guard_form['first_name']);
		}else{
			$guard_form->validatorSchema['first_name'] = new sfValidatorString(
					array('max_length' => 20, 'required' => false, 'trim' => true),
					array(
							'required' => 'The field is mandatory',
							'max_length' => 'The field cannot contain more than %max_length% characters.'
					));
		}
		if ($this->getObject ()->getSfGuardUser ()->getLastName())
		{
		  unset($guard_form['last_name']);
		}else{
			$guard_form->validatorSchema['last_name'] = new sfValidatorString(
					array('max_length' => 20, 'required' => false, 'trim' => true),
					array(
							'required' => 'The field is mandatory',
							'max_length' => 'The field cannot contain more than %max_length% characters.'
					));
		}
		$this->embedForm ( 'sf_guard_user', $guard_form );
		}
	  
		
		
		
		if ($this->getObject ()->getGender())
		{		
		   unset($this['gender']);
		}else 
		{
		  $this->validatorSchema ['gender'] = new sfValidatorChoice ( array ('required' => false, 'choices' => array_keys ( Social::$sexChoices ) ), array ('required' => 'The field is mandatory' ) );
		}
		if ($this->getObject ()->getPhoneNumber())
		{  
		  unset($this['phone_number']);
		}else 
		{
		$this->validatorSchema ['phone_number'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => false, 'min_length' => 7, 'max_length' => 20, 'trim' => true  ), array ('min_length' => 'Invalid Phone Number', 'max_length' => 'Invalid Phone Number' ) ), new sfValidatorRegex ( array ('pattern' => '/^[0-9+]([0-9.-]+)$/' ), array ('invalid' => 'Invalid Phone Number' ) ) ), 
		
		array ('required' => false ), array ('required' => 'The field is mandatory' , 'invalid' => 'Invalid Phone Number') );
		
		}
		
		$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
	
	}
}
