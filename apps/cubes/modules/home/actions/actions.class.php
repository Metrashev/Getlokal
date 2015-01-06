<?php

/**
 * api actions.
 *
 * @package    getLokal
 * @subpackage api
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeActions extends sfActions {
	public function executeIndex(sfWebRequest $request) {
		
		sfForm::disableCSRFProtection ();
		$this->form = new sfGuardFormSignin ();
		if ($request->isMethod ( 'post' )) {
			$params = $request->getParameter ( $this->form->getName () );
			$this->form->bind ( $params );
			
			if ($this->form->isValid ()) {
				
				$user_id = $this->form->getValue ( 'user' )->getId ();
				if (! $user_id) {
					$return = array ('status' => 'ERROR', 'error' => 'Unable to login user' );
				}
				$today = date('Y-m-d H:i:s');
				$login = Doctrine::getTable ( 'CubesLogin' )->createQuery ( 'cl' )->where ( 'cl.user_id =  ?', $user_id )
				->andWhere ( 'cl.expires_at > "'. $today.'"'  )
				->andWhere ( 'cl.is_active = 1' )->fetchOne ();
				
				if (! $login) {
					$login = new CubesLogin ();
					$login->setUserId ( $user_id );
					$login->save ();
				} else {
					$is_getlokal_admin = (($login->getSfGuardUser () && in_array ( $login->getSfGuardUser ()->getId (), sfConfig::get ( 'app_getlokal_power_user', array () ) )) ? true : false);
					if (! $is_getlokal_admin) {
						$return = array ('status' => 'ERROR', 'error' => 'You Are Not Authorized to View This Page' );
				        $this->getResponse ()->setContent ( json_encode ( $return ) );
				        $this->forward ( 'company', 'stop' );
					}
				}
				
				$return = array ('status' => 'SUCCESS', 'token' => $login->getToken () );
			
			} else {
				$this->errors = $this->form->getAllErrors ();
				$return = array ('status' => 'ERROR', 'error' => $this->errors );
				$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
    }
    
    $this->getResponse()->setContent(json_encode($return));
    return sfView::NONE;
  }
  $this->setTemplate ( 'form' );
  }
}