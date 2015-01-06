<?php

/**
 * api actions.
 *
 * @package    getlokal
 * @subpackage api
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class placeadminActions extends sfActions {
	protected function checkToken($token) {
		
		$return = false;
		
		if (! $token || ! $login = Doctrine::getTable ( 'CubesLogin' )->findOneByToken ( $token )) {
			$return = array ('status' => 'ERROR', 'error' => 'Invalid user token or token expired', 'error_code' => 3 );
		}
		
		if (! $return && $login->getDateTimeObject ( 'expires_at' )->format ( 'U' ) < time ()) {
			$return = array ('status' => 'ERROR', 'error' => 'Invalid user token or token expired', 'error_code' => 3 );
		}
		if ($return) {
			
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			$this->setTemplate ( 'false' );
			
			$this->forward ( 'company', 'stop' );
		
		} else {
		    $is_getlokal_admin = (($login->getSfGuardUser () && in_array ( $login->getSfGuardUser ()->getId (), sfConfig::get ( 'app_getlokal_power_user', array () ) )) ? true : false);
			if (!$is_getlokal_admin) {
				$return = array ('status' => 'ERROR', 'error' => 'You Are Not Authorized to View This Page' );
				$this->getResponse ()->setContent ( json_encode ( $return ) );
				$this->forward ( 'company', 'stop' );
			}
			$this->token = $token;
			$this->getUser ()->setAttribute ( 'user_id', $login->getUserId (), 'sfGuardSecurityUser' );
			$this->user = $this->getUser ()->getGuardUser ();
		
		}
		
		return true;
	}
	public function executeCreate(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		sfForm::disableCSRFProtection ();
		$this->form = new CRMAdminForm ( null, array (), false );
		
		if ($request->isMethod ( 'post' )) {
			$params = $request->getParameter ( $this->form->getName () );
			$this->form->bind ( $params );
			if (! $this->form->isValid ()) {
				$this->errors = $this->form->getAllErrors ();
				$return = array ('status' => 'ERROR', 'error' => $this->errors );
				$this->getResponse ()->setContent ( json_encode ( $return ) );
				return sfView::NONE;
			}
			
			$con = Doctrine::getConnectionByTableName ( 'sfGuardUser' );
			$user = $this->form->updateObject ();
			$user->setUsername ( myTools::cleanUrl ( $params ['first_name'] ) . substr ( uniqid ( md5 ( rand () ), true ), 0, 4 ) );
			$password = substr ( md5 ( rand ( 100000, 999999 ) ), 0, 8 );
			$user->setPassword ( $password );
			$user->setIsActive ( true );
			$userProfile = $user->getUserProfile ();
			//$userProfile = new UserProfile();
			//$userProfile->setSfGuardUser ( $user );
			try {
				$con->beginTransaction ();
				$company = Doctrine::getTable ( 'Company' )->findOneById ( $params ['company_id'] );
				$user->save ();
				$userProfile->setId ( $user->getId () );
				$activation_hash = md5 ( rand ( 100000, 999999 ) );
				$userProfile->setHash ( $activation_hash );
				$userProfile->setPhoneNumber ( $params ['phone_number'] );
				$userProfile->setGender ( $params ['gender'] );
				$userProfile->setCityId ( $company->getCityId () );
				$userProfile->setCountryId ( $company->getCountryId () );
				$userProfile->setPartner ( UserProfile::CRM_PARTNER );
				$userProfile->save ();
				
				$userSetting = new UserSetting ();
				$userSetting->setId ( $user->getId () );
				$userSetting->setAllowContact ( true );
				$userSetting->setAllowNewsletter ( false );
				$userSetting->save ();
				
				//$user->addDefaultPermissionsAndGroups ( array ('user' ), array () );
				
				$page_admin = new PageAdmin ();
				$page_admin->setPageId ( $company->getCompanyPage ()->getId () );
				$page_admin->setUserId ( $user->getId () );
				$page_admin->setStatus ( 'approved' );
				$page_admin->setPosition ( $params ['position'] );
				if ($company->getCompanyPage ()->getPrimaryAdmin ()) {
					$page_admin->setIsPrimary ( false );
				}
				$page_admin->save ();
				
				$con->commit ();
			
			} catch ( Exception $e ) {
				$con->rollBack ();
				
				$return = array ('status' => 'ERROR', 'error' => $e->getMessage () );
				$this->getResponse ()->setContent ( json_encode ( $return ) );
				return sfView::NONE;
				throw $e;
			}
			$msg = array ('user' => $this->user, 'object' => 'user', 'action' => 'create', 'object_id' => $user->getId () );
			$this->dispatcher->notify ( new sfEvent ( $msg, 'user.write_log' ) );
			
			$msg = array ('user' => $this->user, 'object' => 'place_admin', 'action' => 'create', 'object_id' => $page_admin->getId () );
			$this->dispatcher->notify ( new sfEvent ( $msg, 'user.write_log' ) );
/*
			$name = Doctrine::getTable('SerbianNames')
			->createQuery ( 'sn' )
			->where('name = ?', $user->getFirstName())
			->fetchOne();
			
			if ($name){
				$first_name =  $name->getSuffix();
			} else{
				$first_name =  $user->getFirstName();
			}
*/
			$first_name = $userProfile->getSpecialFirstName();
			
			myTools::sendMail ( $user, 'Welcome to getlokal', 'place_admin_activation', array ('user' => $user, 'password' => $password, 'firstName' => $first_name ) );
			$return = array ('status' => 'SUCCESS', 'id' => $page_admin->getId (), 'user_id' => $user->getId () );
			
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		
		}
		$this->setTemplate ( 'form' );
	}
	
	public function executeUpdate(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		
		/*
		 
		$user_id = $request->getParameter ( 'user_id' );
		$company_id = $request->getParameter ( 'company_id' );
		$pageAdmin = Doctrine_Core::getTable ( 'PageAdmin' )->createQuery ( 'p' )->innerJoin ( 'p.CompanyPage cp' )->innerJoin ( 'cp.Company c' )->where ( 'p.user_id = ?' , $user_id )->andWhere ( 'c.id = ?' , $company_id );
		*/
		$this->id = $request->getParameter ( 'id' );
		$page_admin = Doctrine_Core::getTable ( 'PageAdmin' )->findOneById ( $this->id );
		if (! $page_admin) {
			$return = array ('status' => 'ERROR', 'error' => 'Object Not Found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		$profile = $page_admin->getUserProfile ();
		//$this->form = new AccountSettingsForm ( $profile, array (), false );
		$this->form = new CRMAdminForm ( $profile->getsfGuardUser (), array ('page_admin' => $page_admin ) );
		if ($request->isMethod ( 'post' )) {
			$params = $request->getParameter ( $this->form->getName () );
			$this->form->bind ( $params );
			if (! $this->form->isValid ()) {
				$this->errors = $this->form->getAllErrors ();
				$return = array ('status' => 'ERROR', 'error' => $this->errors );
				$this->getResponse ()->setContent ( json_encode ( $return ) );
				return sfView::NONE;
			}
			//TODO
			

			$con = Doctrine::getConnectionByTableName ( 'sfGuardUser' );
			$user = $this->form->updateObject ();
			$userProfile = $user->getUserProfile ();
			try {
				$con->beginTransaction ();
				$user->save ();
				$userProfile->setPhoneNumber ( $params ['phone_number'] );
				$userProfile->setGender ( $params ['gender'] );
				$userProfile->save ();
				$page_admin->setStatus ( $params ['status'] );
				if ($params ['status'] == 'rejected')
			    {
				  $page_admin->setIsPrimary(false);
			    }
				$page_admin->setPosition ( $params ['position'] );				
				$page_admin->save ();
				
				$con->commit ();
			
			} catch ( Exception $e ) {
				$con->rollBack ();
				
				$return = array ('status' => 'ERROR', 'error' => $e->getMessage () );
				$this->getResponse ()->setContent ( json_encode ( $return ) );
				return sfView::NONE;
				throw $e;
			}
			
			if ($params ['status'] == 'rejected')
			{
			  if (!$page_admin->getCompanyPage()->getPrimaryAdmin()){
		        $next_company_place_admin = Doctrine_Core::getTable ( 'PageAdmin' )->createQuery ( 'p' )->innerJoin ( 'p.CompanyPage cp' )->andWhere ( 'cp.id = ?', $page_admin->getCompanyPage()->getId() )->andWhere('p.status = ?', 'approved')->orderBy('p.created_at')->fetchOne ();
		        if ($next_company_place_admin)
		        {
			      $next_company_place_admin->setIsPrimary(true);
			      $next_company_place_admin->save();
		        }
		      }	
			}
			//TODO
			

			$msg = array ('user' => $this->user, 'object' => 'place_admin', 'action' => 'changePersonalInfo', 'object_id' => $page_admin->getId () );
			$this->dispatcher->notify ( new sfEvent ( $msg, 'user.write_log' ) );
			if($user->getIsActive()){
/*				
				$name = Doctrine::getTable('SerbianNames')
				->createQuery ( 'sn' )
				->where('name = ?', $page_admin->getUserProfile()->getFirstName())
				->fetchOne();
					
				if ($name){
					$page_admin_sr =  $name->getSuffix();
				} else{
					$page_admin_sr =  $page_admin->getUserProfile()->getFirstName();
				}
*/				
				$page_admin_sr = $userProfile->getSpecialFirstName();
				
			  myTools::sendMail ( $page_admin->getUserProfile (), 'Your Place Profile in getlokal', 'existingRupa', array ('pageAdmin' => $page_admin, 'pageAdminSr' => $page_admin_sr ) );
			}
			$return = array ('status' => 'SUCCESS', 'id' => $page_admin->getId (), 'user_id' => $profile->getId () );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		$this->setTemplate ( 'form' );
	}
	
	public function executeDeleteAdmin(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		$user_id = $request->getParameter ( 'user_id' );
		$user = Doctrine_Core::getTable ( 'sfGuardUser' )->findOneById ( $user_id );
		if (! $user) {
			$return = array ('status' => 'ERROR', 'error' => 'User Not Found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		$profile = $user->getUserProfile ();
		
		$company_id = $request->getParameter ( 'company_id' );
		$company = Doctrine_Core::getTable ( 'Company' )->findOneById ( $company_id );
		
		if (! $company) {
			$return = array ('status' => 'ERROR', 'error' => 'Company Not Found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		$page_admin = Doctrine_Core::getTable ( 'PageAdmin' )->createQuery ( 'p' )->innerJoin ( 'p.CompanyPage cp' )->innerJoin ( 'cp.Company c' )->where ( 'p.user_id = ?', $user_id )->andWhere ( 'c.id = ?', $company_id )->fetchOne ();
	if (! $page_admin) {
			$return = array ('status' => 'ERROR', 'error' => 'Page Admin Not Found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		$id = $page_admin->getId();
		
		$company = $page_admin->getCompanyPage ()->getCompany ();
		try {
			$con = Doctrine::getConnectionByTableName ( 'sfGuardUser' );
			$con->beginTransaction ();
			$page_admin->delete ();
			$con->commit ();
		} catch ( Exception $e ) {
			$con->rollBack ();
			$return = array ('status' => 'ERROR', 'error' => $e->getMessage () );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
			throw $e;
		}
/*		
		$name = Doctrine::getTable('SerbianNames')
		->createQuery ( 'sn' )
		->where('name = ?', $user->getFirstName())
		->fetchOne();

		if ($name){
			$name_sr =  $name->getSuffix();
		} else{
			$name_sr =  $user->getFirstName();
		}
*/		
		//$name_sr = $profile->getSpecialFirstName();

		//myTools::sendMail ( $user, 'Rejected Place Claim in getlokal', 'claimRequestDeniedMail', array ('company' => $company, 'profile' => $profile, 'name' => $name_sr ) );
		
		$msg = array ('user' => $this->user, 'object' => 'place_admin', 'action' => 'delete', 'object_id' => $id );
		$this->dispatcher->notify ( new sfEvent ( $msg, 'user.write_log' ) );
		if (!$company->getPrimaryAdmin()){
		  $next_company_place_admin = Doctrine_Core::getTable ( 'PageAdmin' )->createQuery ( 'p' )->innerJoin ( 'p.CompanyPage cp' )->innerJoin ( 'cp.Company c' )->andWhere ( 'c.id = ?', $company_id )->andWhere('p.status = ?', 'approved')->orderBy('p.created_at')->fetchOne ();
		  if ($next_company_place_admin)
		  {
			$next_company_place_admin->setIsPrimary(true);
			$next_company_place_admin->save();
		  }
		}
		$return = array ('status' => 'SUCCESS' );
		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}
	
	public function executeCheckAdmin(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		$user_id = $request->getParameter ( 'user_id' );
		$company_id = $request->getParameter ( 'company_id' );
		$this->id = NULL;
		$page_admin = Doctrine_Core::getTable ( 'PageAdmin' )->createQuery ( 'p' )->innerJoin ( 'p.CompanyPage cp' )->innerJoin ( 'cp.Company c' )->where ( 'p.user_id = ?', $user_id )->andWhere ( 'c.id = ?', $company_id )->fetchOne ();
		if ($page_admin) {
			$this->id = $page_admin->getId ();
		}
		$return = array ('status' => 'SUCCESS', 'id' => $this->id );
		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}
	
	public function executeSetPlaceAdmin(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		$user_id = $request->getParameter ( 'user_id' );
		$user = Doctrine_Core::getTable ( 'sfGuardUser' )->findOneById ( $user_id );
		if (! $user) {
			$return = array ('status' => 'ERROR', 'error' => 'User Not Found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		$company_id = $request->getParameter ( 'company_id' );
		$company = Doctrine_Core::getTable ( 'Company' )->findOneById ( $company_id );
		
		if (! $company) {
			$return = array ('status' => 'ERROR', 'error' => 'Company Not Found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		$page_admin = Doctrine_Core::getTable ( 'PageAdmin' )->createQuery ( 'p' )->innerJoin ( 'p.CompanyPage cp' )->innerJoin ( 'cp.Company c' )->where ( 'p.user_id = ?', $user_id )->andWhere ( 'c.id = ?', $company_id )->fetchOne ();
		 if (!$user->getIsActive () && $user->getUserProfile()->getPartner() != UserProfile::CRM_PARTNER) {
			$user->setIsActive ( true );
			$user->save ();
		} 
		if ($page_admin) {
/*			
			$name = Doctrine::getTable('SerbianNames')
			->createQuery ( 'sn' )
			->where('name = ?', $page_admin->getUserProfile()->getFirstName())
			->fetchOne();
			
			if ($name){
				$page_admin_sr =  $name->getSuffix();
			} else{
				$page_admin_sr =  $page_admin->getUserProfile()->getFirstName();
			}
*/
			$page_admin_sr = $page_admin->getUserProfile()->getSpecialFirstName();
			
			if ($page_admin->getStatus () != 'approved') {
				$page_admin->setStatus ( 'approved' );
				$page_admin->save ();
				myTools::sendMail ( $page_admin->getUserProfile (), 'Approved Place Claim in getlokal', 'claimRequestApproved', array ('pageAdmin' => $page_admin, 'pageAdminSr' => $page_admin_sr ) );
			}
			
		
		} else {
			
			$page_admin = new PageAdmin ();
			$page_admin->setUserId ( $user->getId () );
			$page_admin->setPageId ( $company->getCompanyPage ()->getId () );
			$page_admin->setStatus ( 'approved' );
			if ($company->getCompanyPage ()->getPrimaryAdmin ()) {
				$page_admin->setIsPrimary ( false );
			}
			$page_admin->save ();
			if ($user->getIsActive ()){
				
/*				$name = Doctrine::getTable('SerbianNames')
				->createQuery ( 'sn' )
				->where('name = ?', $page_admin->getUserProfile()->getFirstName())
				->fetchOne();
					
				if ($name){
					$page_admin_sr =  $name->getSuffix();
				} else{
					$page_admin_sr =  $page_admin->getUserProfile()->getFirstName();
				}
*/				
				$page_admin_sr =  $page_admin->getUserProfile()->getSpecialFirstName();
				
			myTools::sendMail ( $page_admin->getUserProfile (), 'Your Place Profile in getlokal', 'newRupaExistingUser', array ('pageAdmin' => $page_admin, 'PageAdminSr' => $page_admin_sr ) );
			}
		}
		
		$msg = array ('user' => $this->user, 'object' => 'place_admin', 'action' => 'setAdmin', 'object_id' => $page_admin->getId () );
		$this->dispatcher->notify ( new sfEvent ( $msg, 'user.write_log' ) );
		
		$return = array ('status' => 'SUCCESS', 'id' => $page_admin->getId () );
		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}	

}