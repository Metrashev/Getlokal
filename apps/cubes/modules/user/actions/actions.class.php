<?php

/**
 * api actions.
 *
 * @package    getlokal
 * @subpackage api
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends sfActions {
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
			if (! $is_getlokal_admin) {
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
		$this->form = new CRMUserForm ( null, array (), false );
		
		if ($request->isMethod ( 'post' )) {
			$params = $request->getParameter ( $this->form->getName () );
			$this->form->bind ( $params );
			if (! $this->form->isValid ()) {
				$this->errors = $this->form->getAllErrors ();
				$user = Doctrine::getTable('sfGuardUser')->findOneByEmailAddress($params['email_address']);
				if ($user){
				 $return = array ('status' => 'ERROR', 'id' =>$user->getId(), 'error' => $this->errors);
				}else{
				 $return = array ('status' => 'ERROR', 'error' => $this->errors );
				}
				$this->getResponse ()->setContent ( json_encode ( $return ) );
				return sfView::NONE;
			}
			
			$con = Doctrine::getConnectionByTableName ( 'sfGuardUser' );
			$user = $this->form->updateObject ();
			$user->setUsername ( myTools::cleanUrl ( $params ['first_name'] ) . substr ( uniqid ( md5 ( rand () ), true ), 0, 4 ) );
			$password = substr ( md5 ( rand ( 100000, 999999 ) ), 0, 8 );
			$user->setPassword ( $password );
			$user->setIsActive ( true );
			$userProfile = $this->form->getEmbeddedForm ( 'user_profile' )->getObject ();
			$user->setUserProfile($userProfile);
			
			try {
				$con->beginTransaction ();
				
				$user->save ();
				$userProfile->setId ( $user->getId () );
				$activation_hash = md5 ( rand ( 100000, 999999 ) );
				$userProfile->setHash ( $activation_hash );	
				$userProfile->setCountryId ( $userProfile->getCity()->getCounty()->getCountry()->getId() );
				$userProfile->setPartner ( UserProfile::CRM_PARTNER );
				$userProfile->save ();
				
				$userSetting = new UserSetting ();
				$userSetting->setId ( $user->getId () );
				$userSetting->setAllowContact ( true );
				$userSetting->setAllowNewsletter ( false );
				$userSetting->save ();
				
				$user->addDefaultPermissionsAndGroups ( array ('user' ), array () );
				
				
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
			
			
			myTools::sendMail ( $user, 'Welcome to getlokal', 'place_admin_activation', array ('user' => $user, 'password' => $password ) );
			$return = array ('status' => 'SUCCESS', 'id' => $user->getId() );
			
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		
		}
		$this->setTemplate ( 'form' );
	}
	
	public function executeUpdate(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		
		$this->id = $request->getParameter ( 'id' );
		$user = Doctrine_Core::getTable ( 'sfGuardUser' )->findOneById ( $this->id );
		if (! $user) {
			$return = array ('status' => 'ERROR', 'error' => 'Object Not Found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		$profile = $user->getUserProfile ();
	    sfForm::disableCSRFProtection ();
		$this->form = new CRMUserForm ( $user );
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
			
			try {
				$con->beginTransaction ();
				$this->form->save();
				
				$con->commit ();
			
			} catch ( Exception $e ) {
				$con->rollBack ();
				
				$return = array ('status' => 'ERROR', 'error' => $e->getMessage () );
				$this->getResponse ()->setContent ( json_encode ( $return ) );
				return sfView::NONE;
				throw $e;
			}
			
			//TODO
			

			$msg = array ('user' => $this->user, 'object' => 'user', 'action' => 'changePersonalInfo', 'object_id' => $user->getId () );
			$this->dispatcher->notify ( new sfEvent ( $msg, 'user.write_log' ) );
			
			$return = array ('status' => 'SUCCESS', 'id' => $user->getId() );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		$this->setTemplate ( 'form' );
	}
	
	public function executeCheckUser(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		sfForm::disableCSRFProtection ();
		$this->form = new CheckUserForm ();
		if ($request->isMethod ( 'post' )) {
			$params = $request->getParameter ( $this->form->getName () );
			$this->form->bind ( $params );
			if (! $this->form->isValid ()) {
				$this->errors = $this->form->getAllErrors ();
				$return = array ('status' => 'ERROR', 'error' => $this->errors );
				$this->getResponse ()->setContent ( json_encode ( $return ) );
				return sfView::NONE;
			}
			$email = $params ['email'];
			$user = Doctrine_Core::getTable ( 'sfGuardUser' )->findOneByEmailAddress ( $email );
			$return = array ('status' => 'SUCCESS', 'user_id' => ($user ? $user->getId () : "NULL"));
		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}
	$this->mail= true;
	$this->setTemplate ( 'form' );	
	}
	
        public function executeGetCitiesAutocomplete(sfWebRequest $request)
     {
        
        $this->getResponse()->setContentType('application/json');

        $q = "%" . $request->getParameter('term') . "%";
        
        $limit = $request->getParameter('limit', 20);

        // FIXME: use $limit
        $dql = Doctrine_Query::create()
                ->from('City c')
                ->innerJoin('c.Translation ctr')
                ->where('ctr.name LIKE ? ',$q )
                ->limit($limit);

        $this->rows = $dql->execute();
        $cities = $cities_names = array();

        $partner_class = getlokalPartner::getLanguageClass(getlokalPartner::getInstance());

        foreach ($this->rows as $city) {
            $cities [] = array(
                        'id' => $city ['id'],
                        'value' => $city->getCityNameByCulture() . ', ' . mb_convert_case($city->getCounty()->getCountyNameByCulture('en'), MB_CASE_TITLE, 'UTF-8')
                    );
        }
        

        return $this->renderText(json_encode($cities));  	
  }
public function in_array_r($needle, $haystack, $strict = false) {
		foreach ( $haystack as $item ) {
			if (($strict ? $item === $needle : $item == $needle) || (is_array ( $item ) && $this->in_array_r ( $needle, $item, $strict ))) {
				return true;
			}
		}
		
		return false;
	}
public function executeCheckIsAdmin(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		sfForm::disableCSRFProtection ();
		$listplaces= array();
		$this->id = $request->getParameter ( 'id' );
		$user = Doctrine_Core::getTable ( 'sfGuardUser' )->findOneById ( $this->id );
		if (! $user) {
			$return = array ('status' => 'ERROR', 'error' => 'User Not Found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		$profile = $user->getUserProfile ();
	    $allpages = $user->getIsPlaceAdmin();
		if (count($allpages) > 0 ){
			foreach($allpages as $page)
			{
				$listplaces[$page->getId()] = $page->getCompanyPage()->getCompany()->getId(); 
			}
		}
		$return = array ('status' => 'SUCCESS', 'places' => $listplaces );
		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}	
}