<?php
class orderActions extends sfActions {
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
		$company_id = $request->getParameter ( 'company_id' );
		$this->company = Doctrine_Core::getTable ( 'Company' )->findOneById ( $company_id );
		if (! $this->company) {
			$return = array ('status' => 'ERROR', 'error' => 'Object Not Found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		
		sfForm::disableCSRFProtection ();
		$this->object = new AdServiceCompany ();
		$this->object->setCompanyId ( $this->company->getId () );
		$this->form = new OrderForm ( $this->object );
		
		if ($request->isMethod ( 'post' )) {
			$params = $request->getParameter ( $this->form->getName () );
			$this->form->bind ( $params );
			if (! $this->form->isValid ()) {
				$this->errors = $this->form->getAllErrors ();
				$return = array ('status' => 'ERROR', 'error' => $this->errors );
				$this->getResponse ()->setContent ( json_encode ( $return ) );
				return sfView::NONE;
			
			} else {
				
				$this->form->save ();
				$return = array ('status' => 'SUCCESS', 'id' => $this->object->getId () );
				$this->getResponse ()->setContent ( json_encode ( $return ) );
				return sfView::NONE;
			}
		}
		$this->setTemplate ( 'form' );
	}
	public function executeUpdate(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		
		$this->id = $request->getParameter ( 'id', null );
		
		$this->object = Doctrine_Core::getTable ( 'AdServiceCompany' )->findOneById ( $this->id );
		
		if (! $this->object) {
			$return = array ('status' => 'ERROR', 'error' => 'Order not found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		
		sfForm::disableCSRFProtection ();
		
		$this->form = new OrderForm ( $this->object );
		
		if ($request->isMethod ( 'post' )) {
			$params = $request->getParameter ( $this->form->getName () );
			$this->form->bind ( $params );
			if (! $this->form->isValid ()) {
				$this->errors = $this->form->getAllErrors ();
				$return = array ('status' => 'ERROR', 'error' => $this->errors );
				$this->getResponse ()->setContent ( json_encode ( $return ) );
				return sfView::NONE;
			} else {
				
				$this->form->save ();
				$msg = array ('user' => $this->user, 'object' => 'order', 'action' => 'update', 'object_id' => $this->object->getId () );
				$this->dispatcher->notify ( new sfEvent ( $msg, 'user.write_log' ) );
				
				$return = array ('status' => 'SUCCESS', 'id' => $this->object->getId () );
				$this->getResponse ()->setContent ( json_encode ( $return ) );
				return sfView::NONE;
			}
		}
		$this->setTemplate ( 'form' );
	}
	
	public function executeGetCompanyOrders(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		$company_id = $request->getParameter ( 'company_id' );
		$this->company = Doctrine_Core::getTable ( 'Company' )->findOneById ( $company_id );
		if (! $this->company) {
			$return = array ('status' => 'ERROR', 'error' => 'Company Not Found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		$listorders = array ();
		$this->orders = Doctrine_Core::getTable ( 'AdServiceCompany' )->findByCompanyId ( $this->company->getId () );
		
		if (count ( $this->orders ) > 0) {
			foreach ( $this->orders as $order ) {
				$listorders [$order->getAdServiceId ()] = $order->getId ();
			}
		}
		$return = array ('status' => 'SUCCESS', 'services' => $listorders );
		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}
	public function executeDelete(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		
		$this->id = $request->getParameter ( 'id', null );
		
		$this->object = Doctrine_Core::getTable ( 'AdServiceCompany' )->findOneById ( $this->id );
		
		if (! $this->object) {
			$return = array ('status' => 'ERROR', 'error' => 'Order not found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		if ($this->object->getStatus() == "registered"){
		$this->object->delete();
		$return = array ('status' => 'SUCCESS');
		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
		}else {
			$return = array ('status' => 'ERROR', 'error' => 'Unable to delete! The service status is ' . $this->object->getStatus());
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		
	}
}