<?php

/**
 * follow actions.
 *
 * @package    getLokal
 * @subpackage follow
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class followActions extends sfActions {
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function configShow(sfWebRequest $request) {
		
		$page_id = $request->getParameter ( 'page_id' );
		$this->forward404Unless ( $this->page = Doctrine::getTable ( 'Page' )->findOneById ( $page_id ) );
		
		$this->user_is_admin = false;
		$this->is_other_place_admin_logged = false;
		$this->user = $this->getUser ()->getGuardUser ();
		if ($this->getUser ()->getPageAdminUser ()) {
			$this->is_other_place_admin_logged = true;
		}
		
		if ($this->page instanceof UserPage) {			
			$this->page_type = 'user';
		} elseif ($this->page instanceof CompanyPage) {
		   
			if ($this->getUser ()->getPageAdminUser ()) {
				$admin = Doctrine::getTable ( 'PageAdmin' )->createQuery ( 'a' )->where ( 'a.id = ?', $this->getUser ()->getPageAdminUser ()->getId () )->andWhere ( 'a.status = ?', 'approved' )->andWhere ( 'a.page_id = ?', $this->page->getId () )->fetchOne ();
				if ($admin) {
					$this->user_is_admin = true;
					$this->is_other_place_admin_logged = false;
				}
			}
			$this->user_is_company_admin = (($this->user && $this->user->getIsPageAdmin ( $this->page->getCompany() )) ? true : false);
			$this->page_type = 'company';
		}
	}
	
	public function executeFollow(sfWebRequest $request) {
		$this->configShow ( $request );
	
		if (!$this->user_is_admin && !$this->is_other_place_admin_logged && !$this->user_is_company_admin && $this->user) {
			
			$follow = Doctrine::getTable ( 'FollowPage' )->getFollowPage ( $this->user->getId (), $this->page->getId () );
			if (! $follow) {
				$follow = new FollowPage ();
				$follow->setUserId ( $this->user->getId () );
				$follow->setPageId ( $this->page->getId () );
				$follow->save ();
				$referer = $request->getReferer ();
				$this->dispatcher->notify(new sfEvent($follow, 'social.start_follow'));
       
			}
		}
		
		
		$this->redirect ( $referer );
	}
	
	public function executeStopFollow(sfWebRequest $request) {
		$this->configShow ( $request );
		//if (! $this->user_is_admin && !$this->user_is_company_admin && ! $this->is_other_place_admin_logged && $this->user) {
			$follow = Doctrine::getTable ( 'FollowPage' )->getFollowPage ( $this->user->getId (), $this->page->getId ()  );
			if (! $follow) {
				
				//$this->getUser ()->setFlash ( 'error', 'You don\'t follow this' );
			} else {
				$follow->delete ();
				//$this->getUser ()->setFlash ( 'notice', 'success unfollow ' );
			}
		//}
		
		$this->redirect ( $request->getReferer () );
	}
	
public function executeEdit(sfWebRequest $request) {
		$this->configShow ( $request );
			
		//if (! $this->user_is_admin && !$this->user_is_company_admin && ! $this->is_other_place_admin_logged && $this->user) {
			$this->follow = Doctrine::getTable ( 'FollowPage' )->getFollowPage ( $this->user->getId (), $this->page->getId ()  );
			if (!$this->follow) {
				//$this->getUser ()->setFlash ( 'error', 'You don\'t follow this' );
			 $this->redirect('userSettings/index');
			} else {
				$this->form = new FollowPageForm($this->follow);
				if ($request->isMethod('post')){
					$params = $request->getParameter ( $this->form->getName () );
					$this->form->bind($params);
					if ($this->form->isValid()){
						$this->form->save();
						return $this->redirect('userSettings/follow');
					}
				
				}
				
			}
			
		//}		
		
		return $this->renderPartial('follow/edit', array('form' => $this->form));
		
	}

	
public function executeMultipleEdit(sfWebRequest $request) {
        $this->user_is_admin = false;
		$this->is_other_place_admin_logged = false;
		$this->user = $this->getUser ()->getGuardUser ();
		if ($this->getUser ()->getPageAdminUser ()) {
			$this->is_other_place_admin_logged = true;
		}
			
		if (!$this->user_is_admin && !$this->user_is_company_admin && ! $this->is_other_place_admin_logged && $this->user) {
			$this->followers = Doctrine::getTable ( 'FollowPage' )->findByUserId($this->getUser()->getId());
			$params = $request->getParameter ('follow_page');
		   foreach($params as $key=>$val)
		   {
		   	$follower =  Doctrine::getTable ( 'FollowPage' )->getFollowPage ( $this->user->getId (), $key );
		    if(array_key_exists('email_notification', $val))
		    {
		    	$follower->setEmailNotification(true);
		    }else {
		    	$follower->setEmailNotification(false);
		    }
		   if(array_key_exists('internal_notification', $val))
		    {
		    	$follower->setInternalNotification(true);
		    }else {
		    	$follower->setInternalNotification(false);
		    }
		   if(array_key_exists('weekly_update', $val))
		    {
		    	$follower->setWeeklyUpdate(true);
		    }else {
		    	$follower->setWeeklyUpdate(false);
		    }
		   if(array_key_exists('newsfeed', $val))
		    {
		    	$follower->setNewsfeed(true);
		    }else {
		    	$follower->setNewsfeed(false);
		    }
		    $follower->save();  	
		    
		   }
			
		}		
		
		$this->getUser ()->setFlash ( 'notice', 'success' );
		$this->redirect('userSettings/follow');
	}
}
