<?php
class BasicCompanyInfoForm extends CompanyForm {
	public function configure() {
		parent::configure ();
                
                $culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();

                $cultures = sfConfig::get('app_languages_'.$culture);
                $fields_array = array_merge($cultures, array ('city_id', 'phone','phone1','phone2','registration_no', 'email','website_url', 'facebook_url','googleplus_url','foursquare_url','twitter_url'));
                $this->useFields ($fields_array);
                
              //  $this->useFields ( array ($culture, 'en', $language, 'city_id', 'phone','phone1','phone2','registration_no', 'email','website_url', 'facebook_url','googleplus_url','foursquare_url','twitter_url') );
                
                
	/*
		
		if (!$this->getObject()->isNew())
    {
    $lang_class = 	getlokalPartner::getLanguageClass($this->getObject()->getCountryId());
    
    }else {
    $lang_class= getlokalPartner::getLanguageClass();
    }
	    $lookupclass='LookupCompanyType'. $lang_class;
       
   $this->widgetSchema['company_type'] = new sfWidgetFormChoice(array(
      'choices' => call_user_func(array($lookupclass, 'getInstance'))
    ));
    
     $this->widgetSchema->setLabel ('company_type' ,'Select company type');
	*/
		
		$this->widgetSchema['city_id']->setDefault($this->getObject()->getCityId());
		$this->widgetSchema ['city_id'] = new sfWidgetFormInputHidden ();
		$this->widgetSchema ['city'] = new sfWidgetFormInputText ();
		$this->widgetSchema ['city']->setDefault ( $this->getObject ()->getCity ()->getName () );
		
		$this->validatorSchema->setOption ( 'allow_extra_fields', true );
		$this->validatorSchema->setOption ( 'filter_extra_fields', false );
		
		$this->embedForm ( 'company_location', new CompanyLocationForm ($this->getObject ()->getLocation()) );
		
		if (!$this->getObject()->isNew() && $this->getObject()->getCountryId() == getlokalPartner::GETLOKAL_RS)
		{
			$partner =getlokalPartner::GETLOKAL_RS;
		}else{
	        $partner=getlokalPartner::getInstance();
	      }
		
		if (isset($partner) && $partner==getlokalPartner::GETLOKAL_RS){
			$this->embedForm ('company_yp', new CompanyDetailSrForm($this->getObject ()->getCompanyDetailSr())  );
		}
		
		if (sfContext::getInstance()->getUser()->isGetlokalAdmin())
		{
			unset($this['registration_no']);
		}
		
	
	}

	
	


}