<?php
class SuggestEditForm extends CompanyForm {
	public function configure() {
		parent::configure ();
                
               // unset($this['company_type'], //$this['sector_id'], //$this['city_id'],
               //         $this['website_url'], $this['facebook_url'], $this['googleplus_url'],
               //         $this['foursquare_url'], $this['twitter_url'], $this['email']);
             
                $culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();

                $cultures = sfConfig::get('app_languages_'.$culture);
                $fields_array = array_merge($cultures, array ('city_id', 'phone', 'classification_id'));
                $this->useFields ($fields_array);
                
		$this->widgetSchema['city_id']->setDefault($this->getObject()->getCityId());
		$this->widgetSchema ['city_id'] = new sfWidgetFormInputHidden ();
		$this->widgetSchema ['city'] = new sfWidgetFormInputHidden ();
		$this->widgetSchema ['city']->setDefault ( $this->getObject ()->getCity ()->getName () );
                $this->widgetSchema ['classification_id'] = new sfWidgetFormInputHidden ();
		$this->widgetSchema ['sector_id'] = new sfWidgetFormInputHidden ();
		$this->widgetSchema ['classification'] = new sfWidgetFormInputText ( array ('default' => $this->getObject ()->getClassification ()->getTitle () ) );
                
		$this->validatorSchema->setOption ( 'allow_extra_fields', true );
		$this->validatorSchema->setOption ( 'filter_extra_fields', false );
		
		$this->embedForm ( 'company_location', new CompanyLocationForm ($this->getObject ()->getLocation()) );
/*		
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
*/		
	
	}

	
	


}