<?php
class AddOrEditCompanyForm extends CompanyForm {
	
	public function configure() {
		parent::configure ();
		
		$this->useFields ( array ('title', 'title_en', 'city_id', 'phone', 'email', 'sector_id', 'classification_id', 'website_url', 'facebook_url', 'twitter_url', 'foursquare_url' ) );
		
		$this->validatorSchema ['classification_id']->setOption ( 'required', true );
		
		$this->widgetSchema ['classification_id'] = new sfWidgetFormInputHidden ();
		$this->widgetSchema ['sector_id'] = new sfWidgetFormInputHidden ();
		$this->widgetSchema ['classification'] = new sfWidgetFormInputText ( array ('default' => $this->getObject ()->getClassification ()->getTitle () ) );
		
		$this->widgetSchema ['city_id'] = new sfWidgetFormInputHidden ();
		$this->widgetSchema ['city'] = new sfWidgetFormInputText ( array ('default' => $this->getObject ()->getCity ()->getName () ) );
		
		$company_location = new CompanyLocation ();
		$company_location->setCompany ( $this->getObject () );
		$company_location->setIsActive ( 1 );
		
		$user = sfContext::getInstance ()->getUser ();
		if ($user->isAuthenticated ()) {
			$company_location->setUserId ( $user->getId () );
		}
		
		$this->widgetSchema->setLabels ( array ('facebook_url' => '/page-name', 'twitter_url' => '@Twitter handle', 'foursquare_url' => 'Foursquare place URL' ) );
		
		$location_form = new CompanyLocationForm ( $company_location );
		$location_form->setWidget ( 'address_info', new sfWidgetFormInputText ( array ('label' => 'Additional address details' ) ) );
		
		$this->embedForm ( 'company_location', $location_form );
		
		$this->validatorSchema->setOption ( 'allow_extra_fields', true );
		$this->validatorSchema->setOption ( 'filter_extra_fields', false );
		
		$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
	}
	
	public function doSave($con = null) {
		$this->getObject ()->clearRelated ( 'City' );
		$this->getObject ()->setCountryId ( sfContext::getInstance ()->getUser ()->getCountry ()->getId () );
		if (sfContext::getInstance ()->getUser ()->getGuardUser ()) {
			$this->getObject ()->setCreatedBy ( sfContext::getInstance ()->getUser ()->getGuardUser ()->getId () );
		}
		$this->getObject ()->clearRelated ( 'Classification' );
		parent::doSave ( $con );
		
		$company_classification = new CompanyClassification ();
		$company_classification->setCompanyId ( $this->getObject ()->getId () );
		$company_classification->setClassificationId ( $this->getObject ()->getClassificationId () );
		$company_classification->save ();
		
		$this->getObject ()->setLocationId ( $this->getObject ()->CompanyLocation->getFirst ()->getId () );
		$this->getObject ()->save ();
		
		
	}

}