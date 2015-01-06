<?php
class NewCompanyForm extends CompanyForm {
	public function configure() {
     parent::configure();
		$this->useFields ( array ('title', 'title_en', 'city_id', 'phone', 'registration_no', 'sector_id', 'classification_id' ) );
			
	
		$this->widgetSchema ['city_id']->setDefault ( sfContext::getInstance ()->getUser ()->getCity ()->getId () );
		$this->widgetSchema ['city'] = new sfWidgetFormInputHidden ();
		$company_location = new CompanyLocation ();
		
		$company_location->setCompany ( $this->getObject () );
	    if (isset ( $this->options ['user'] )) {
			
			$company_location->setUserProfile ( $this->options ['user']->getUserProfile () );
		    $company_location->setIsActive(1);
		}
		$this->embedForm ( 'company_location', new CompanyLocationForm ( $company_location ) );
		
	
		if (!isset ( $this->options ['user'] )) {
			unset($this['registration_no']);
		}
		
		
		if (isset ( $this->options ['user'] )) {
			
			$pageAdmin = new PageAdmin ();
			$pageAdmin->setUserProfile ( $this->options ['user']->getUserProfile () );
		    $this->embedForm ( 'page_admin', new PageAdminForm ( $pageAdmin, array('no_reg_no' => true) ) );
		
		}
		 $this->validatorSchema->setOption ( 'allow_extra_fields', true );
		 $this->validatorSchema->setOption ( 'filter_extra_fields', false );
		 $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
		 $this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
	
	}

	
public function doSave($con = null)
	{
    $this->getObject()->clearRelated('City');
    $this->getObject ()->setCountryId ( sfContext::getInstance()->getUser()->getCountry()->getId());
    if (sfContext::getInstance()->getUser()->getGuardUser()) {
      $this->getObject ()->setCreatedBy(sfContext::getInstance()->getUser()->getGuardUser()->getId());
     $new = true;
    }
    parent::doSave( $con);
    
    $company_classification = new CompanyClassification();
    $company_classification->setCompanyId($this->getObject()->getId());
    $company_classification->setClassificationId($this->getObject ()->getClassificationId());
    $company_classification->save();
    
	$this->getObject ()->setLocationId ( $this->getObject()->CompanyLocation->getFirst()->getId());
	$this->getObject()->save();
    
     if (sfContext::getInstance()->getUser()->getGuardUser()) {
			
      $pageAdmin = $this->getEmbeddedForm ( 'page_admin' )->getObject();
      $pageAdmin->setCompanyPage($this->getObject()->getCompanyPage());
      $pageAdmin->setUserId(sfContext::getInstance()->getUser()->getGuardUser()->getId());
      $pageAdmin->save();
     	
     	
	
	}
	}	
	

}