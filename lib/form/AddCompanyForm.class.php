<?php
class AddCompanyForm extends CompanyForm {
	
	public function configure() {
		parent::configure ();
         //unset($this['id'],$this ['referer'], $this['created_at'],$this['updated_at']);

        $culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();
        $userCountry = myTools::getUserCountry();

        $cultures = sfConfig::get('app_languages_'.$culture);
        $fields_array = array_merge($cultures, array ('country_id', 'city_id', 'phone', 'email', 'sector_id', 'classification_id', 'website_url', 'googleplus_url', 'facebook_url', 'twitter_url', 'foursquare_url','registration_no' ));
        $this->useFields ($fields_array);
        
        //$this->useFields ( array ($culture,'en', $current_culture,'city_id', 'phone', 'phone1', 'phone2', 'email', 'sector_id', 'classification_id', 'website_url', 'googleplus_url', 'facebook_url', 'twitter_url', 'foursquare_url','registration_no' ) );

		$this->validatorSchema ['classification_id']->setOption ( 'required', true );
		
//		$this->widgetSchema ['phone'] = new sfWidgetFormInputHidden ();
//		$this->widgetSchema ['phone1'] = new sfWidgetFormInputHidden ();
//		$this->widgetSchema ['phone2'] = new sfWidgetFormInputHidden ();
		
		$this->widgetSchema ['classification_id'] = new sfWidgetFormInputHidden ();
		$this->widgetSchema ['sector_id'] = new sfWidgetFormInputHidden ();
		$this->widgetSchema ['classification'] = new sfWidgetFormInputText ( array ('default' => $this->getObject ()->getClassification ()->getTitle () ) );

		$this->widgetSchema['country_id'] = new sfWidgetFormInputHidden();
		$this->widgetSchema['country'] = new sfWidgetFormInputText();

		$this->widgetSchema ['city_id'] = new sfWidgetFormInputHidden ();
		$this->widgetSchema ['city'] = new sfWidgetFormInputText ();

		if ($this->getObject ()->isNew ()){

			$countries = sfConfig::get('app_domain_slugs_old');
			$userData = myTools::getUserCountry();

			if(!in_array(strtolower($userData['slug']), $countries) && $userData['slug'] != ''){
				$this->widgetSchema['country']->setDefault($userCountry['name_en']);
                $this->widgetSchema['country_id']->setDefault($userCountry['id']);
                $this->widgetSchema ['city']->setDefault ('');
            }
			elseif(sfContext::getInstance()->getUser()->getCulture() == 'en'){
				$this->widgetSchema['country']->setDefault(sfContext::getInstance()->getUser()->getCountry()->getNameEn());
                $this->widgetSchema ['city']->setDefault ( sfContext::getInstance ()->getUser ()->getCity ()->getName () );
			}
			else{
				$this->widgetSchema['country']->setDefault(sfContext::getInstance()->getUser()->getCountry()->getName());
                $this->widgetSchema ['city']->setDefault ( sfContext::getInstance ()->getUser ()->getCity ()->getName () );
			}
			
		}
		else{
			$this->widgetSchema['country']->setDefault($this->getObject()->getCountry()->getName());
			$this->widgetSchema ['city']->setDefault ( $this->getObject ()->getCity ()->getName () );
		}
		
		
		
		if (!isset ( $this->options ['user'] )) {
		//	unset($this['registration_no']);
		}
		
		
		// PAGE ADMIN
		if (isset ( $this->options ['user'] )) {
			$pageAdmin = new PageAdmin ();
			$pageAdmin->setUserProfile ( $this->options ['user']->getUserProfile () );
			//$this->embedForm ( 'page_admin', new PageAdminForm ( $pageAdmin, array('no_reg_no' => true) ) );
			$this->embedForm ( 'page_admin', new AddCompanyPageAdminForm ($pageAdmin) );
			
		}
 

		$partner=getlokalPartner::getInstance();
		
		if ($partner == getlokalPartner::GETLOKAL_BG){
			$this->widgetSchema->setLabel('registration_no' ,  'Enter the Bulstat of your business.');
			$this->setValidator ( 'registration_no', 
                            new sfValidatorOr ( 
                                array (
                                    new sfBulstatValidator ( 
                                            array ( 
                                                'required' => false ,
                                                'trim' => true 
                                            ), 
                                            array (
                                                'required' => 'The field is mandatory', 
                                                'invalid' => 'Invalid Bulstat' 
                                            ) 
                                    ), 
                                    new sfEGNValidator ( 
                                            array (
                                                'required' => false ,
                                                'trim' => true 
                                            ), 
                                            array (
                                                'required' => 'The field is mandatory', 
                                                'invalid' => 'Invalid Bulstat') 
                                            ) 

                                ), 
                                array ('required' => false), 
                                array ('invalid' => 'Invalid Bulstat', 'required' => 'The field is mandatory' ) 
                            ) 
                            );
		
		}
		elseif($partner ==getlokalPartner::GETLOKAL_RO )
		{
			$this->widgetSchema->setLabel('registration_no' ,  'CUI (Cod Unic de Identificare)');
			$this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 12, 'required' => false, 'trim' => true ) , array('invalid' =>  'Invalid CUI' ,'required' =>  'The Business\' CUI is mandatory')) );
		}
		elseif($partner ==getlokalPartner::GETLOKAL_MK )
		{
			$this->widgetSchema->setLabel('registration_no' ,  'МБС (матичен број)');
			$this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 13, 'required' => false, 'trim' => true ) , array('invalid' =>  'Invalid Registration Number' ,'required' =>  'ЕДБ на компанијата е задолжителен')) );
		}elseif($partner ==getlokalPartner::GETLOKAL_RS )
		{
			$this->widgetSchema->setLabel('registration_no' ,  'Enter the registration number of your business.');
			$this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 13, 'required' => false, 'trim' => true ) , array('invalid' =>  'Invalid Registration Number' ,'required' =>  'The field is mandatory')) );
			 
		}elseif($partner ==getlokalPartner::GETLOKAL_FI )
		{
			$this->widgetSchema->setLabel('registration_no' ,  'Enter the registration number of your business.');
			$this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 13, 'required' => false, 'trim' => true ) , array('invalid' =>  'Invalid Registration Number' ,'required' =>  'The field is mandatory')) );
			 
		}
                elseif($partner ==getlokalPartner::GETLOKAL_HU )
		{
			$this->widgetSchema->setLabel('registration_no' ,  'Enter the registration number of your business.');
			$this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 13, 'required' => false, 'trim' => true ) , array('invalid' =>  'Invalid Registration Number' ,'required' =>  'The field is mandatory')) );
			 
		}
		
		
		
		$company_location = new CompanyLocation ();
		$company_location->setCompany ( $this->getObject () );
		$company_location->setIsActive ( 1 );
		
		$user = sfContext::getInstance ()->getUser ();
		if ($user->isAuthenticated ()) {
			$company_location->setUserId ( $user->getId () );
		}
		
		$this->widgetSchema->setLabels ( array ('googleplus_url' => 'https://plus.google.com/page-id', 'facebook_url' => 'http://www.facebook.com/page-name', 'twitter_url' => '@Twitter handle', 'foursquare_url' => 'Foursquare place URL' ) );
		
		$location_form = new CompanyLocationForm ( $company_location );
//		$location_form->setWidget ( 'address_info', new sfWidgetFormInputText ( array ('label' => 'Additional address details' ) ) );
		$location_form->setWidget ( 'address_info', new sfWidgetFormTextarea ( array ('label' => 'Directions to place:' ), array ( 'maxlength' => 100 ) ) );
	
		$this->embedForm ( 'company_location', $location_form );
		
		$this->validatorSchema->setOption ( 'allow_extra_fields', true );
		$this->validatorSchema->setOption ( 'filter_extra_fields', false );
		
                
		$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
                $i18n = sfContext::getInstance ()->getI18N ();
   //              $this->setWidget ( 'captcha', new sfWidgetCaptchaGD () );
			// $this->widgetSchema->setLabel ( 'captcha', 'Security check. Enter the characters from the picture below' );
			// $this->setValidator ( 'captcha', new sfCaptchaGDValidator ( array ('length' => 4 ), array ('invalid' => $i18n->__ ( 'You have entered the text incorrectly. Please try again.', null, 'errors' ), 'required' => $i18n->__ ( 'The field is mandatory', null, 'errors' ) ) ) );
			$this->validatorSchema->setOption ( 'allow_extra_fields', true );
			$this->validatorSchema->setOption ( 'filter_extra_fields', false );
	}
	
	public function doSave($con = null) {
		$this->getObject ()->clearRelated ( 'City' );
		
		$this->getObject ()->clearRelated ( 'Country' );
		//// PAGE ADMIN
		if (isset ( $this->options ['no_page_admin'] ) )	unset($this->embeddedForms['page_admin']);
		
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
		
		
		// PAGE ADMIN
		if (sfContext::getInstance()->getUser()->getGuardUser() && !isset ( $this->options ['no_page_admin'] )  ) {
				
			$pageAdmin = $this->getEmbeddedForm ( 'page_admin' )->getObject();
			$pageAdmin->setCompanyPage($this->getObject()->getCompanyPage());
			$pageAdmin->setUserId(sfContext::getInstance()->getUser()->getGuardUser()->getId());
			$pageAdmin->save();
		
		}
	
	
	
	}
        
}