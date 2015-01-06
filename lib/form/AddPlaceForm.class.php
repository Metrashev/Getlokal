<?php
class AddPlaceForm extends CompanyForm {
	
	public function configure() {
		parent::configure ();
		
		$this->useFields ( array ('title', 'title_en', 'classification_id', 'city_id' ) );
		
		$this->widgetSchema ['city'] = new sfWidgetFormInputHidden ();
		$this->widgetSchema ['city_id']->setDefault ( sfContext::getInstance ()->getUser ()->getCity ()->getId () );
		$this->widgetSchema->setLabel ( 'city_id', 'Location' );
		$this->widgetSchema ['classification_id'] = new sfWidgetFormDoctrineJQueryAutocompleter ( array ('model' => 'Classification', 'url' => sfContext::getInstance ()->getController ()->genUrl ( array ('module' => 'company', 'action' => 'getClassifiersAutocomplete', 'route' => 'default' ) ), 'config' => ' {
          scrollHeight: 250,
          autoFill: false,
          cacheLength: 1,
          delay: 0,
          max: 10,
          minChars:1
       }' ) );
		$this->widgetSchema ['more'] = new sfWidgetFormInput ();
	//	$this->validatorSchema ['more'] = new sfValidatorString ( array ('min_length' => 255, 'max_length' => 255, 'required' => true, 'trim' => true ), array ('required' => 'The field is mandatory', 'max_length' => 'The field cannot contain more than %max_length% characters.' ) );
		
		$this->validatorSchema ['more'] = new sfValidatorOr(
		array(
        new sfValidatorRegex ( array ('required' => false, 'pattern' => '/^(https?:\/\/+[\w\-]+\.[\w\-]+)/i' ), array ('invalid' =>'Invalid format. E.g. http://www.facebook.com/getlokal' ) ) ,
         new sfValidatorRegex ( array ('pattern' => '/^[0-9+()]([ 0-9.()-]+)$/' ), array ('invalid' => 'Invalid Phone Number' )  ) ),
       array ('required' => true ) , array ('required' => 'The field is mandatory' ));
		$this->widgetSchema->setLabel('more','Telephone/Website/FB page');
		
		$this->validatorSchema ['classification_id'] = new sfValidatorDoctrineChoice ( array ('model' => $this->getRelatedModelName ( 'Classification' ) ), array ('required' => 'The field is mandatory', 'invalid' => 'Invalid City' ) );
		
		$this->validatorSchema ['city_id'] = new sfValidatorDoctrineChoice ( array ('model' => $this->getRelatedModelName ( 'City' ) ), array ('required' => 'The field is mandatory', 'invalid' => 'Invalid City' ) );
		
		$company_location = new CompanyLocation ();
		$company_location->setCompany ( $this->getObject () );
		$company_location->setIsActive ( 1 );
		
		$user = sfContext::getInstance ()->getUser ()->getGuardUser ();
		if ($user) {
			$company_location->setUserId ( $user->getId () );
		}
		
		$this->embedForm ( 'company_location', new CompanyLocationBasicForm ( $company_location ) );
		
		$this->validatorSchema->setOption ( 'allow_extra_fields', true );
		$this->validatorSchema->setOption ( 'filter_extra_fields', false );
		
		$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
	}
	
	public function doSave($con = null) {
		$more = $this->getValue ('more' );
		if (preg_match ( '/^[0-9+]([0-9.-]+)$/', $more )) {
			$this->getObject ()->setPhone ( $more );
		} elseif (preg_match ( '/^(https?:\/\/+[\w\-]+\.[\w\-]+)/i', $more )) {

			
			if (stripos ( $more, 'http://facebook.com' )===0  or stripos ( $more, 'http://www.facebook.com' ) ===0  ) {
				$this->getObject ()->setFacebookUrl ( $more );
			} else {
				$this->getObject ()->setWebsiteUrl ( $more );
			}
		
		}
		$this->getObject ()->clearRelated ( 'City' );
		$this->getObject ()->setCountryId ( sfContext::getInstance ()->getUser ()->getCountry ()->getId () );
		if (sfContext::getInstance ()->getUser ()->getGuardUser ()) {
			$this->getObject ()->setCreatedBy ( sfContext::getInstance ()->getUser ()->getGuardUser ()->getId () );
		}
		parent::doSave ( $con );
		
		$company_classification = new CompanyClassification ();
		$company_classification->setCompanyId ( $this->getObject ()->getId () );
		$company_classification->setClassificationId ( $this->getObject ()->getClassificationId () );
		$company_classification->save ();
		$this->getObject ()->setSectorId ( $this->getObject ()->getClassification ()->getPrimarySector ()->getId () );
		$this->getObject ()->setLocationId ( $this->getObject ()->CompanyLocation->getFirst ()->getId () );
		$this->getObject ()->setStatus ( CompanyTable::VISIBLE );
		$this->getObject ()->save ();
		
	}

}