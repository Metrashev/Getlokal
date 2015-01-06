<?php
/**
 * RegisterForm for signup process and requires
 * sfGuardPlugin
 *
 * @author Rajat Pandit
 */
class NewCRMUserForm extends sfGuardUserForm {
	
	public function configure() {
		$this->useFields ( array ('first_name', 'last_name', 'email_address' ) );
		
		$this->validatorSchema ['first_name'] = new sfValidatorString ( array ('max_length' => 20, 'required' => true, 'trim' => true ), array ('required' => 'The field is mandatory', 'max_length' => 'The field cannot contain more than %max_length% characters.' ) );
		
		$this->validatorSchema ['last_name'] = new sfValidatorString ( array ('max_length' => 20, 'required' => true, 'trim' => true ), array ('required' => 'The field is mandatory', 'max_length' => 'The field cannot contain more than %max_length% characters.' ) );
		
		$this->validatorSchema ['email_address'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => true, 'max_length' => 100, 'trim' => true ) ), new sfValidatorEmail ( array ('trim' => true ), array ('invalid' => 'Invalid email – your email is not in the correct format' ) ) ), array ('required' => true ), array ('required' => 'The field is mandatory' ) );
		
	    /*
        $this->widgetSchema['allow_b_cmc']     =  new sfWidgetFormInputCheckbox(array('default' => 'checked'));
        $this->validatorSchema['allow_b_cmc']     = new sfValidatorBoolean();
        */
		$this->widgetSchema ['company_id'] = new sfWidgetFormInput ();
		$this->validatorSchema ['company_id'] = new sfValidatorDoctrineChoice ( array ('model' => 'Company', 'required' => true ), array ('invalid' => 'Invalid Company' ) );
		
		$this->widgetSchema ['phone_number'] = new sfWidgetFormInputText ();
		
		$this->validatorSchema ['phone_number'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => false, 'min_length' => 7, 'max_length' => 20, 'trim' => true ), array ('min_length' => 'Invalid Phone Number', 'max_length' => 'Invalid Phone Number' ) ), new sfValidatorRegex ( array ('pattern' => '/^[0-9+]([0-9.-]+)$/' ), array ('invalid' => 'Invalid Phone Number' ) ) ), array ('required' => false ), array ('required' => 'The field is mandatory' , 'invalid' => 'Invalid Phone Number') );
		
		$this->widgetSchema ['position'] = new sfWidgetFormChoice ( array ('expanded' => false, 'choices' => Social::getI18NChoices ( Social::$positionChoicesWEmpty ) ) );
		$this->validatorSchema ['position'] = new sfValidatorChoice ( array ('required' => false, 'choices' => array_keys ( Social::$positionChoicesWEmpty ) ), array ('required' => 'The field is mandatory', 'invalid' => 'The field is mandatory' ) );
		
		$this->widgetSchema ['gender'] = new sfWidgetFormChoice ( array ('expanded' => false, 'label' => 'Gender', 'choices' => Social::getI18NChoices ( Social::$sexChoicesWEmpty ) ) );
		
		$this->validatorSchema ['gender'] = new sfValidatorChoice ( array ('required' => false, 'choices' => array_keys ( Social::$sexChoices ) ), array ('required' => 'The field is mandatory' ) );
		
		$this->validatorSchema->setOption ( 'allow_extra_fields', true );
		$this->validatorSchema->setOption ( 'filter_extra_fields', false );
		
		$this->validatorSchema->setPostValidator ( new sfValidatorDoctrineUnique ( array ('model' => 'sfGuardUser', 'column' => 'email_address' ), array ('invalid' => 'This email address has already been registered by another user' ) ) );
	
	}
	public function getAllErrors() {
		$err = array ();
		foreach ( $this as $form_field ) {
			if ($form_field->hasError ()) {
				$err_obj = $form_field->getError ();
				if ($err_obj instanceof sfValidatorErrorSchema) {
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
	
	public function save($con = null) {
		
		try {
			$con = Doctrine::getConnectionByTableName ( 'sfGuardUser' );
			$con->beginTransaction ();
			$this->getObject ()->setUsername(myTools::cleanUrl($this->values ['first_name']).substr ( uniqid ( md5 ( rand () ), true ), 0, 4 ));
			$password = substr ( md5 ( rand ( 100000, 999999 ) ), 0, 8 );
			$this->getObject ()->setPassword ( $password );
			$this->getObject ()->setIsActive ( false );
			parent::save ();
			$company = Doctrine::getTable ( 'Company' )->findOneById ( $this->values ['company_id'] );
			
			$userProfile = new UserProfile ();
			$userProfile->setId ( $this->getObject ()->getId () );
			$userProfile->setPhoneNumber ( $this->values ['phone_number'] );
			$userProfile->setGender ( $this->values ['gender'] );
			$userProfile->setCityId ( $company->getCityId () );
			$userProfile->setCountryId ( $company->getCountryId () );
			$userProfile->setPartner ( UserProfile::CRM_PARTNER );
			$userProfile->save ();
			
			$userSetting = new UserSetting ();
			$userSetting->setId ( $this->getObject ()->getId () );
			/* $allowBcontact = ((isset($this->values['allow_b_cmc']) && $this->values['allow_b_cmc'] == 1) ? true : false);
		     $userSetting->setAllowBCmc($allowBcontact);	*/
			$userSetting->setAllowContact ( true );
			$userSetting->setAllowNewsletter ( false );
			$userSetting->save ();
			
			$this->getObject ()->addDefaultPermissionsAndGroups ( array ('user' ), array () );
			
			$page_admin = new PageAdmin ();
			$page_admin->setPageId ( $company->getCompanyPage ()->getId () );
			$page_admin->setUserId ( $this->getObject ()->getId () );
			$page_admin->setStatus ( 'approved' );
			$page_admin->setPosition ( $this->values ['position'] );
			if ($company->getPrimaryAdmin ()) {
				$page_admin->setIsPrimary ( false );
			}
			$page_admin->save ();
			$user = sfContext::getInstance ()->getUser()->getGuardUser();
			$msg = array('user'=>$user, 'object'=>'place_admin', 'action'=>'registerCrm','object_id' => $page_admin->getId());      
			
            sfProjectConfiguration::getActive()->getEventDispatcher()->notify(new sfEvent($msg, 'user.write_log'));
          
			/*
	      $allBNews = Doctrine::getTable('Newsletter')->retrieveActivePerCountry($company->getCountryId());
	     if($allBNews){	     	
	        	foreach ($allBNews as $allBNew)
	        	{
	        		
	        		$user_news = new NewsletterUser();
	        		$user_news->setNewsletterId($allBNew->getId());
	        		$user_news->setUserId($this->getObject()->getId());
	        	    if ($allowcontact && $allowBcontact)
	        	    {
	        	    	$user_news->setIsActive(true);
	        	    }elseif($allowcontact)
	        	    {
	        	    	//if ($allBNew->getUserGroup() == 'business')
	        	    //	{
	        	    		$user_news->setIsActive(false);
	        	    //	}else {
	        	    	//	$user_news->setIsActive(true);
	        	    //	}
	        	    	
	        	    	
	        	    }else 
	        	    {
	        	    		$user_news->setIsActive(false);
	        	    }
	        	 $user_news->save();
	        	}
	        }*/
			$con->commit ();
			
		} catch ( Exception $e ) {
			$con->rollBack ();
			
			throw $e;
		}
	    
	    return $this->getObject();
	    
	}

}