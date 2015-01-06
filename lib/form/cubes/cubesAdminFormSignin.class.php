<?php

/**
 * sfGuardFormSignin for sfGuardAuth signin action
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardFormSignin.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class cubesAdminFormSignin extends BaseForm {
	/**
	 * @see sfForm
	 */
	public function configure() {
		
		$this->widgetSchema ['username'] = new sfWidgetFormInputText ();
		$this->widgetSchema ['password'] = new sfWidgetFormInputPassword ( array ('type' => 'password' ) );
		$this->widgetSchema ['company_id'] = new sfWidgetFormInput ();
		
		$this->validatorSchema ['username'] = new sfValidatorEmail ( array ('trim' => true ), array ('invalid' => 'Invalid email – your email is not in the correct format', 'required' => 'Email is required' ) );
		$this->validatorSchema ['password'] = new sfValidatorString ( array ('trim' => true ), array ('required' => 'Password is mandatory' ) );
		
		$this->validatorSchema ['company_id'] = new sfValidatorDoctrineChoice ( array ('model' => 'Company', 'column' => 'id', 'required' => true ), array ('invalid' => 'Invalid Company', 'required' => 'Required' ) );
		$this->widgetSchema->setLabels ( array ('username' => 'E-mail:', 'password' => 'Password:', 'company_id' => 'Company' ) );
		$this->validatorSchema->setPostValidator ( new sfGuardValidatorUser (), array ('required' => 'Invalid login' ) );
		
		$this->widgetSchema->setNameFormat ( 'admin[%s]' );
		$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
	}
	
	public function getAllErrors() {
		$errors = array ();
		$errors ['admin'] ='';
		foreach ( $this as $form_field ) {
			if ($form_field->hasError ()) {
				$err_obj = $form_field->getError ();
			if ($err_obj instanceof sfValidatorError){
					
				$errors ['admin'] .= $err_obj;
				
					
			}
				elseif ($err_obj instanceof sfValidatorErrorSchema) {
					
					foreach ( $err_obj->getErrors () as $err ) {
						$errors [$form_field->getName ()] = $err->getMessage ();
					}
				} 
			}
		}
		
		// global err
		foreach ( $this->getGlobalErrors () as $validator_err ) {
			$errors [] = $validator_err->getMessage ();
		}
		return $errors;
	}
}
