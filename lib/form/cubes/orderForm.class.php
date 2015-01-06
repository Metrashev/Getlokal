<?php

/**
 * AdCompany form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class orderForm extends AdServiceCompanyForm {
	public function configure() {
		$this->useFields ( array ('active_from', 'ad_service_id', 'crm_id', 'status' ) );
	
		if (! $this->getObject ()->isNew ()) {
			unset ( $this ['crm_id'], $this ['ad_service_id'] );
		} else {
			$this->validatorSchema ['crm_id'] = new sfValidatorInteger ( array ('required' => true ), array ('required' => 'CRM ID is mandatory' ) );
			$this->validatorSchema ['ad_service_id'] = new sfValidatorDoctrineChoice ( array ('model' => $this->getRelatedModelName ( 'AdService' ), 'required' => true ), array ('required' => 'Product is mandatory' ) );
			$this->validatorSchema ['status'] = new sfValidatorChoice ( array ('choices' => array (0 => 'registered', 1 => 'paid', 2 => 'active', 3 => 'cancelled', 4 => 'expired' ), 'required' => true ), array ('required' => 'Product is mandatory' ) );
		
		// $this->validatorSchema['active_from']   = new sfValidatorDate(array('required' => true), array('required' =>'Active from date is mandatory'));
		}
		
		$this->widgetSchema->setNameFormat ( 'order[%s]' );
		$this->validatorSchema->setPostValidator ( new sfValidatorCallback ( array ('callback' => array ($this, 'postValidateMe' ) ) ) );
	}
	
	public function bind(array $taintedValues = null, array $taintedFiles = null)
	{
	if ($taintedValues ['status'] == 'cancelled' or $taintedValues ['status'] =='expired') {
		
		unset ( $this['active_from'], $taintedValues['active_from'] );	
		}
		parent::bind ( $taintedValues, $taintedFiles );
	}
	public function postValidateMe($validator, $values) {
		
		if ($values ['status'] == 'active') {
			if (! $values ['active_from']) {
				$error = new sfValidatorError ( $validator, 'Active From Date is mandatory' );
				throw new sfValidatorErrorSchema ( $validator, array ('active_from' => $error ) );
			
			}
		}
		if (! $this->getObject ()->isNew ()) {
			$ad_service_id = $this->getObject ()->getAdServiceId();
		}else
		{
			$ad_service_id = $values ['ad_service_id'];
		}
	    if ($values ['status'] == 'paid' &&  $ad_service_id == 13) {
			if (! $values ['active_from']) {
				$error = new sfValidatorError ( $validator, 'Active From Date is mandatory' );
				throw new sfValidatorErrorSchema ( $validator, array ('active_from' => $error ) );
			
			}
		}
		
    return $values;
	}
	public function getAllErrors() {
		$errors = array ();
		$errors ['order'] = '';
		foreach ( $this as $form_field ) {
			if ($form_field->hasError ()) {
				$err_obj = $form_field->getError ();
				if ($err_obj instanceof sfValidatorError) {
					
					$errors ['order'] .= $err_obj;
				
				} elseif ($err_obj instanceof sfValidatorErrorSchema) {
					
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
