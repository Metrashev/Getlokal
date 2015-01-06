<?php
class NewCRMCompanyForm extends CompanyForm {
	public function configure() {
		parent::configure ();
		$this->useFields ( array ('title', 'title_en', 'email', 'phone', 'website_url', 'facebook_url', 'city_id', 'sector_id', 'classification_id', 'parent_external_id', 'status', 'registration_no' ) );
		
		$this->widgetSchema ['status'] = new sfWidgetFormChoice ( array ('choices' => array (CompanyTable::VISIBLE => 'approved', CompanyTable::INVISIBLE => 'invisible', CompanyTable::NEW_PENDING => 'New waiting approval', CompanyTable::REJECTED => 'rejected' ) ) );
		$this->setValidator ( 'status', new sfValidatorChoice ( array ('choices' => array (0, 1, 3, 4 ), 'required' => false ) ) );
		
		if (! $this->getObject ()->isNew ()) {
			$lang_class = getlokalPartner::getLanguageClass ( $this->getObject ()->getCountryId () );
		
		} else {
			$lang_class = getlokalPartner::getLanguageClass ();
		}
		/*$lookupclass = 'LookupCompanyType' . $lang_class;
		
		$this->widgetSchema ['company_type'] = new sfWidgetFormChoice ( array ('choices' => call_user_func ( array ($lookupclass, 'getInstance' ) ) ) );
		*/
		if ($this->getObject ()->isNew ()) {
			$company_location = new CompanyLocation ();
			$company_location->setCompany ( $this->getObject () );
		} else {
			$company_location = $this->getObject ()->getLocation ();
		}
		
		if (isset ( $this->options ['user'] ) && $this->options ['user']) {
			
			$company_location->setUserProfile ( $this->options ['user']->getUserProfile () );
		
		}
		$company_location->setIsActive ( 1 );
		$this->embedForm ( 'location', new CompanyLocationForm ( $company_location ) );
		$this->widgetSchema ['location'] ['latitude'] = new sfWidgetFormInput ();
		$this->widgetSchema ['location'] ['longitude'] = new sfWidgetFormInput ();
		$this->widgetSchema ['location'] ['zoom'] = new sfWidgetFormInput ();
		$this->widgetSchema ['location'] ['accuracy'] = new sfWidgetFormChoice ( array ('choices' => array ('' => '', 0 => 'Complete Match', 1 => 'Street match, Number found with little difference', 2 => 'Street match, number not found', 3 => 'Neighbourhood match, street not found', 4 => 'City match, neighbourhood not found', 6 => 'Address not found' ) ) );
		$this->validatorSchema ['location'] ['latitude'] = new sfValidatorString ( array ('required' => true, 'trim' => true ), array ('required' => 'The field is mandatory' ) );
		$this->validatorSchema ['location'] ['longitude'] = new sfValidatorString ( array ('required' => true, 'trim' => true ), array ('required' => 'The field is mandatory' ) );
		$this->validatorSchema ['location'] ['accuracy'] = new sfValidatorChoice ( array ('required' => false, 'choices' => array (0, 1, 2, 3, 4, 5, 6 ) ) );
		$this->validatorSchema ['location'] ['zoom'] = new sfValidatorInteger ( array ('required' => true ) );
		
		if (! $this->getObject ()->isNew ()) {
			if ($this->getObject ()->getCountryId () == getlokalPartner::GETLOKAL_BG) {
				$partner = getlokalPartner::GETLOKAL_BG;
			} elseif ($this->getObject ()->getCountryId () == getlokalPartner::GETLOKAL_RO) {
				$partner = getlokalPartner::GETLOKAL_RO;
			} elseif ($this->getObject ()->getCountryId () == getlokalPartner::GETLOKAL_MK) {
				$partner = getlokalPartner::GETLOKAL_MK;
			}elseif ($this->getObject ()->getCountryId () == getlokalPartner::GETLOKAL_FI) {
				$partner = getlokalPartner::GETLOKAL_FI;
			}
		
		} else {
			$partner = getlokalPartner::getInstance ();
		}
		if ($partner == getlokalPartner::GETLOKAL_BG) {
			$this->widgetSchema->setLabel ( 'registration_no', 'Enter the Bulstat of your business.' );
			$this->setValidator ( 'registration_no', new sfValidatorOr ( array (new sfBulstatValidator ( array ('trim' => true ), array ('invalid' => 'Invalid Bulstat' ) ), new sfEGNValidator ( array ('trim' => true ), array ('invalid' => 'Invalid Bulstat' ) ) ), array ('required' => false ), array ('invalid' => 'Invalid Bulstat' ) ) );
		} elseif ($partner == getlokalPartner::GETLOKAL_RO) {
			$this->widgetSchema->setLabel ( 'registration_no', 'CUI (Cod Unic de Identificare)' );
			$this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 12, 'required' => false, 'trim' => true ), array ('invalid' => 'Invalid CUI', 'required' => 'The Business\' Bulstat is mandatory' ) ) );
		} elseif ($partner == getlokalPartner::GETLOKAL_MK) {
			$this->widgetSchema->setLabel ( 'registration_no', 'Registration Number' );
			$this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 12, 'required' => false, 'trim' => true ), array ('invalid' => 'Invalid Registration Number', 'required' => 'The Business\' registration number is mandatory' ) ) );
		}
                elseif ($partner == getlokalPartner::GETLOKAL_FI) {
			$this->widgetSchema->setLabel ( 'registration_no', 'Registration Number' );
			$this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 12, 'required' => false, 'trim' => true ), array ('invalid' => 'Invalid Registration Number', 'required' => 'The Business\' registration number is mandatory' ) ) );
		}
		
		$this->validatorSchema->setOption ( 'allow_extra_fields', true );
		$this->validatorSchema->setOption ( 'filter_extra_fields', false );
		$this->errorSchema = new sfValidatorErrorSchema ( $this->validatorSchema );
		/*
		if ($this->getObject ()->isNew ()) {
			$this->validatorSchema ['company_number'] = new sfValidatorInteger ( array ('required' => false ) );
			
			//$this->validatorSchema->setPostValidator ( new sfValidatorDoctrineUnique ( array ('model' => 'Company', 'column' => 'company_number' ), array ('invalid' => 'Company number exists' ) ) );
		} else {
			unset ( $this->widgetSchema ['company_number'] );
		}*/
	
	}
	public function doBind(array $taintedValues) {
		
		if (isset ( $taintedValues ['location'] ['location_type'] ) && ! isset ( $taintedValues ['location'] ['street_type_id'] ) && getlokalPartner::getInstance () != getlokalPartner::GETLOKAL_BG) {
			
			$taintedValues ['location'] ['street_type_id'] = $taintedValues ['location'] ['location_type'];
		
		}
		
		parent::doBind ( $taintedValues );
	}
	
	public function doSave($con = null) {
		$this->getObject ()->clearRelated ( 'City' );
		if ($this->getObject ()->isNew ()) {
			$this->getObject ()->setCreatedBy ( sfContext::getInstance ()->getUser ()->getId () );
		}
		$this->getObject ()->setCountryId ( sfContext::getInstance ()->getUser ()->getCountry ()->getId () );
		parent::doSave ( $con );
		
		$company_classifications = $this->getObject ()->getCompanyClassification ();
		if (count ( $company_classifications ) == 0) {
			$company_classification = new CompanyClassification ();
			$company_classification->setCompany ( $this->getObject () );
		} elseif (count ( $company_classifications ) == 1) {
			$company_classification = $company_classifications [0];
		} else {
			foreach ( $company_classifications as $cm_cl ) {
				if ($this->getObject ()->getClassificationId () == $cm_cl->getClassificationId ()) {
					$company_classification = $cm_cl;
				}
			}
		}
		
		$company_classification->setClassificationId ( $this->getObject ()->getClassificationId () );
		$company_classification->save ();
		
		$this->getObject ()->setLocationId ( $this->getObject ()->CompanyLocation->getFirst ()->getId () );
		$this->getObject ()->save ();
		
	}
	
	public function getAllErrors() {
		$err = array ();
		foreach ( $this as $form_field ) {
			if ($form_field->hasError ()) {
				$err_obj = $form_field->getError ();
				if ($$err_obj instanceof sfValidatorErrorSchema) {
					foreach ( $err_obj->getErrors () as $err ) {
						$err [$form_field->getName ()] = $err->getMessage ();
					}
				} else {
					$err [$form_field->getName ()] = $err_obj->getMessage ();
				}
			}
		}
		// global err
		foreach ( $this->getGlobalErrors () as $validator_err ) {
			$err [] = $validator_err->getMessage ();
		}
		return $err;
	}

}