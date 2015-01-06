<?php

/**
 * AdCompany form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class backendOrderForm extends AdServiceCompanyForm {
	public function configure() {
		$this->useFields ( array ('active_from', 'active_to') );
		
		

		if (! $this->getObject ()->isNew ()) {
			unset ( $this ['ad_service_id'] );
		} else {
			//$this->validatorSchema ['crm_id'] = new sfValidatorInteger ( array ('required' => false ), array ('required' => 'CRM ID is mandatory' ) );
			//$this->validatorSchema ['ad_service_id'] = new sfValidatorDoctrineChoice ( array ('model' => $this->getRelatedModelName ( 'AdService' ), 'required' => true ), array ('required' => 'Product is mandatory' ) );
			
			if (!($this->getObject()->getAdServiceId() == 11)) {
			    unset ( $this ['active_to'] );
			}
		
		// $this->validatorSchema['active_from']   = new sfValidatorDate(array('required' => true), array('required' =>'Active from date is mandatory'));
		}
		if ($this->getObject()->getAdServiceId() == 13) {
			$this->setWidget('status', new sfWidgetFormChoice( array ('choices' => array ('paid' => 'paid', 'cancelled' => 'cancelled'))));
			$this->setValidator('status', new sfValidatorChoice ( array ('choices' => array (1 => 'paid', 3 => 'cancelled'))));
		}
		if ($this->getObject()->getAdServiceId() == 11) {
			$this->setWidget('status', new sfWidgetFormChoice ( array ('choices' => array ('active' => 'active', 'cancelled' => 'cancelled'))));
			$this->setValidator('status', new sfValidatorChoice ( array ('choices' => array (2 => 'active', 3 => 'cancelled'))));
		}
		
		$this->widgetSchema->setNameFormat ( 'order[%s]' );
		$this->validatorSchema->setPostValidator ( new sfValidatorCallback ( array ('callback' => array ($this, 'postValidateMe' ) ) ) );
	}
	public function postValidateMe($validator, $values) {
		
		
		if ($values ['status'] == 'active') {
			if (! $values ['active_from']) {
				$error = new sfValidatorError ( $validator, 'Active From Date is mandatory' );
				throw new sfValidatorErrorSchema ( $validator, array ('active_from' => $error ) );
			
			}
		}
		if ($this->getObject()->getAdServiceId() == 13 && $values ['status'] == 'active') {
			
			$error = new sfValidatorError ( $validator, 'If the setvice is active, please select "paid" as status' );
			throw new sfValidatorErrorSchema ( $validator, array ('status' => $error ) );
		}
		if ($this->getObject()->getAdServiceId() == 11 && $values ['status'] == 'paid') {
			if (! isset ( $values ["active_to"] ) or ! isset ( $values ["active_from"] )) {
				$error = new sfValidatorError ( $validator, 'Both Active To and Active From should be selected ' );
				throw new sfValidatorErrorSchema ( $validator, array ('active_to' => $error ) );
			}
			
			if (strtotime ( $values ["active_to"] ) > strtotime ( '+4 weeks', strtotime ( $values ["active_from"] ) )) {
				$error = new sfValidatorError ( $validator, 'The Offer can be active for a maximum period of 4 weeks.' );
				throw new sfValidatorErrorSchema ( $validator, array ('active_to' => $error ) );
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
