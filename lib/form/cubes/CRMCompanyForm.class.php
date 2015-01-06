<?php
class CRMCompanyForm extends CompanyForm {
public function configure() {
		parent::configure ();
                
                $this->useFields ( array ('email', 'phone', 'phone1', 'phone2','website_url', 'facebook_url', 'city_id', 'parent_external_id', 'status', 'registration_no' ) );
		
		$this->widgetSchema ['status'] = new sfWidgetFormChoice ( array ('choices' => array (CompanyTable::VISIBLE => 'approved', CompanyTable::INVISIBLE => 'invisible', CompanyTable::NEW_PENDING => 'New waiting approval', CompanyTable::REJECTED => 'rejected' ) ) );
		$this->setValidator ( 'status', new sfValidatorChoice ( array ('choices' => array (0, 1, 3, 4 ), 'required' => false ) ) );
		
		$this->widgetSchema['city_id'] = new sfWidgetFormDoctrineJQueryAutocompleter(array(
    		'model' => 'City',
    		'method' => 'getCityNameByCulture',
    		'url' => sfContext::getInstance()
    		->getRouting()
    		->generate('default', array(
    				'module' => 'user',
    				'action' => 'getCitiesAutocomplete' ) ),
    		'config' => ' {
          		  scrollHeight: 250,
         		  autoFill: false,
          		  cacheLength: 0,
        		  delay: 1,
        		  max: 10,
        		  minChars:0
        		}'
    ));
		$this->setValidator(
    		'city_id',
    		new sfValidatorDoctrineChoice(array(
    				'required' => false,
    				'model' => 'City'
    		)
    		)); 
	   
		$company_classifications = $this->getObject ()->getCompanyClassification ();
		$classifications = array ();		
		$newClassifierForm = new BaseForm ();
		$i = 1;
		$classifications_count = count ( $company_classifications);
		if (count ( $company_classifications ) > 0 ) {
			foreach ( $company_classifications as $company_classification ) {
				
				$form = new CompanyFormClassification( $company_classification, array ('default' => false ) );
				$newClassifierForm->embedForm ( $i, $form );
			    $i ++;
			}
			
		} 
		else {
		 for($j = $i; $j <= CompanyTable::MAX_CLASSIFICATION_COUNT; $j ++) {
                $company_classification = new CompanyClassification();
                $company_classification->Company = $this->getObject ();
                $form = new CompanyFormClassification ( $company_classification );
                $newClassifierForm->embedForm ( $j, $form );
            
            }	
		}
		
		$this->embedForm ( 'more', $newClassifierForm );
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
		$this->widgetSchema ['location']->setDefault ( 'accuracy', 0 );
		$this->validatorSchema ['location'] ['latitude'] = new sfValidatorString ( array ('required' => true, 'trim' => true ), array ('required' => 'The field is mandatory' ) );
		$this->validatorSchema ['location'] ['longitude'] = new sfValidatorString ( array ('required' => true, 'trim' => true ), array ('required' => 'The field is mandatory' ) );
		$this->validatorSchema ['location'] ['accuracy'] = new sfValidatorChoice ( array ('required' => false, 'choices' => array (0, 1, 2, 3, 4, 5, 6 ) ) );
		$this->validatorSchema ['location'] ['zoom'] = new sfValidatorInteger ( array ('required' => false ) );
		
if (! $this->getObject ()->isNew ()) {
			if ($this->getObject ()->getCountryId () == getlokalPartner::GETLOKAL_BG) {
				$partner = getlokalPartner::GETLOKAL_BG;
			} elseif ($this->getObject ()->getCountryId () == getlokalPartner::GETLOKAL_RO) {
				$partner = getlokalPartner::GETLOKAL_RO;
			} elseif ($this->getObject ()->getCountryId () == getlokalPartner::GETLOKAL_MK) {
				$partner = getlokalPartner::GETLOKAL_MK;
			}elseif ($this->getObject ()->getCountryId () == getlokalPartner::GETLOKAL_RS) {
				$partner = getlokalPartner::GETLOKAL_RS;
			}elseif ($this->getObject ()->getCountryId () == getlokalPartner::GETLOKAL_FI) {
				$partner = getlokalPartner::GETLOKAL_FI;
			}elseif ($this->getObject ()->getCountryId () == getlokalPartner::GETLOKAL_HU) {
				$partner = getlokalPartner::GETLOKAL_HU;
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
		}elseif ($partner == getlokalPartner::GETLOKAL_RS) {
			$this->widgetSchema->setLabel ( 'registration_no', 'Registration Number' );
			$this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 12, 'required' => false, 'trim' => true ), array ('invalid' => 'Invalid Registration Number', 'required' => 'The Business\' registration number is mandatory' ) ) );
		}elseif ($partner == getlokalPartner::GETLOKAL_FI) {
			$this->widgetSchema->setLabel ( 'registration_no', 'Registration Number' );
			$this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 12, 'required' => false, 'trim' => true ), array ('invalid' => 'Invalid Registration Number', 'required' => 'The Business\' registration number is mandatory' ) ) );
		}elseif ($partner == getlokalPartner::GETLOKAL_HU) {
			$this->widgetSchema->setLabel ( 'registration_no', 'Registration Number' );
			$this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 12, 'required' => false, 'trim' => true ), array ('invalid' => 'Invalid Registration Number', 'required' => 'The Business\' registration number is mandatory' ) ) );
		}
                
                $culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();
                $cultures = sfConfig::get('app_languages_'.$culture);

                $this->embedI18n($cultures);
                
                
		
		$this->validatorSchema->setOption ( 'allow_extra_fields', true );
		$this->validatorSchema->setOption ( 'filter_extra_fields', false );
	
		//$this->errorSchema = new sfValidatorErrorSchema ( $this->validatorSchema );
	/*
		if ($this->getObject ()->isNew ()) {
			$this->validatorSchema ['company_number'] = new sfValidatorInteger ( array ('required' => false ) );
			
			//$this->validatorSchema->setPostValidator ( new sfValidatorDoctrineUnique ( array ('model' => 'Company', 'column' => 'company_number' ), array ('invalid' => 'Company number exists' ) ) );
		} else {
			unset ( $this->widgetSchema ['company_number'] );
		}*/
	
	}
	
	public function getAllErrors() {
		$errors = array ();
		$errors ['company'] = '';
		foreach ( $this as $form_field ) {
			if ($form_field->hasError ()) {
				$err_obj = $form_field->getError ();
				if ($err_obj instanceof sfValidatorError) {
					
					$errors ['company'] .= $err_obj;
				
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
	
	public function bind(array $taintedValues = null, array $taintedFiles = null) {
		if (isset ( $taintedValues ['location'] ['location_type'] ) && ! isset ( $taintedValues ['location'] ['street_type_id'] ) && getlokalPartner::getInstance () != getlokalPartner::GETLOKAL_BG) {
			
			$taintedValues ['location'] ['street_type_id'] = $taintedValues ['location'] ['location_type'];
		
		}
		foreach ( $this->embeddedForms ['more']->getEmbeddedForms () as $key => $classaddForm ) {
			if (! isset ( $taintedValues ['more'] [$key] ['classification_id'] ) or is_null ( $taintedValues ['more'] [$key] ['classification_id'] ) or strlen ( $taintedValues ['more'] [$key] ['classification_id'] ) === 0) {
				
				if ($classaddForm->getObject ()) {
					
					$classaddForm->getObject ()->delete ();
				}
				
				unset ( 
				$this->embeddedForms ['more']->embeddedForms [$key], 
				$taintedValues ['more'] [$key],
				$this->validatorSchema['more'][$key] );
			}
		}
		foreach ( $taintedValues ['more'] as $key => $newClassifier ) {
			if (! isset ( $this ['more'] [$key] )) {
				if ($taintedValues ['more'] [$key] ['classification_id'] && $taintedValues ['more'] [$key] ['classification_id'] != NULL && $taintedValues ['more'] [$key] ['classification_id'] != '') {
					
					$this->addCompanyClassification ( $key );
				} else {
					
					unset ( $this->embeddedForms ['more']->embeddedForms [$key], $taintedValues ['more'] [$key] ,$this->validatorSchema['more'][$key]);
				
				}
			
			}
		}
                
                
                $culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();
      $cultures = sfConfig::get('app_languages_'.$culture);

      $this->embedI18n($cultures);
		
		parent::bind ( $taintedValues, $taintedFiles );
	}
	
	public function saveEmbeddedForms($con = null, $forms = null, $taintedValues = null, $taintedFiles = null) {
		
		if (is_null ( $con )) {
			$con = $this->getConnection ();
		}
		
		foreach ( $this->embeddedForms ['more']->getEmbeddedForms () as $classaddForm ) {
			
			if (! $classaddForm->getObject ()->getCompanyId ()) {
				$classaddForm->getObject ()->setCompanyId ( $this->getObject ()->getId () );
			
			}
		}
		
		parent::saveEmbeddedForms ( $con, $forms );
	
	}
	
	public function doSave($con = null) {
		$this->getObject ()->clearRelated ( 'City' );
		if ($this->getObject ()->isNew ()) {
			$this->getObject ()->setCreatedBy ( sfContext::getInstance ()->getUser ()->getId () );
			$new = true;
		}
		
		
		parent::doSave ( $con );
		
		$this->getObject ()->setLocationId ( $this->getObject ()->CompanyLocation->getFirst ()->getId () );
		$this->getObject ()->save ();
		$values = $this->getValues ();
		
		foreach ( $this->embeddedForms ['more']->getEmbeddedForms () as $key => $classaddForm ) {
			if ($values ['more'] [$key] ['classification_id']) {
				if ($key == 1) {
					$class  = Doctrine::getTable('Classification')->findOneById( $values ['more'] [1] ['classification_id'] );
					$sector_id = $class->getPrimarySector()->getId();
					$this->getObject ()->setSectorId ($sector_id);
					$this->getObject ()->setClassificationId ( $values ['more'] [1] ['classification_id'] );
					
					$this->getObject ()->save ();
				
				}
				// only save todos that aren't blank
				$classaddForm->updateObject ( $values ['more'] [$key] );
				$classaddForm->getObject ()->setCompanyId ( $this->getObject ()->getId () );
				$classaddForm->getObject ()->save ();
			
			} elseif (! $classaddForm->getObject ()->isNew ()) {
				// delete any existing todos that are now blank
				$classaddForm->getObject ()->delete ();
			}
		}
		
		
			$companypage = $this->getObject ()->getCompanyPage ();
			if ($this->getObject ()->getStatus () == 0) {
				$companypage->setIsPublic ( 1 );
			} else {
				$companypage->setIsPublic ( 0 );
			}
			$companypage->setCountryId ( $this->getObject ()->getCity ()->getCounty ()->getCountryId () );
			$companypage->save ();
		
	
	}
	public function addCompanyClassification($num) {
		
		$classification = new CompanyClassification ();
		$classification->setCompanyId ( $this->getObject ()->getId () );
		$class_form = new CompanyClassificationForm ( $classification, array ('default' => false ) );
		//Embedding the new classifier in the container
		$this->embeddedForms ['more']->embedForm ( $num, $class_form );
		
		$this->embedForm ( 'more', $this->embeddedForms ['more'] );
	}
}