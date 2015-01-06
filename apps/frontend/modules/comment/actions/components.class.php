<?php

class commentComponents extends sfComponents 
{
  public function executeComments(sfRequest $request)
  {
  	$this->user = $this->getUser()->getGuardUser();
  	$this->formRegister = new OldRegisterForm(null, array('city_is_mandatory' => true));
  	$this->formLogin = new sfGuardFormSignin ();
  	
  	if ($request->isMethod ( 'post' )) {
  		if ($request->getParameter ( $this->formLogin->getName () )) {
  			$this->formLogin->bind ( $request->getParameter ( $this->formLogin->getName () ) );
  			if ($this->formLogin->isValid ()) {
  				$values = $this->formLogin->getValues ();
  				$this->getUser ()->signin ( $values ['user'], array_key_exists ( 'remember', $values ) ? $values ['remember'] : false );
  	
  				// Set city after login
  				if ($this->getUser()->getCountry()->getId() == $this->getUser()->getProfile()->getCountry()->getId()) {
  					$this->getUser()->setCity($this->getUser()->getProfile()->getCity());
  					$this->getUser()->setAttribute('user.set_city_after_login', true);
  				}
  	
  				$this->user = $this->getUser ()->getGuardUser();
  			}
  		}elseif ($request->getParameter ( $this->formRegister->getName () )) {
  			
  			$params = $request->getParameter($this->formRegister->getName());
  	
  			$this->formRegister->bind ( $request->getParameter ( $this->formRegister->getName () ) );
  	
  			if ($this->formRegister->isValid ()) {
  				
  				$con = Doctrine::getConnectionByTableName ( 'sfGuardUser' );
  				$params = $request->getParameter ( $this->formRegister->getName () );
  	
  				$profile = $this->formRegister->updateObject ();
  				
  				
  				if ($profile->getCountryId() > 4 && $profile->getCountryId() != 78) {
  					$profile->setCityId(NULL);
  				}
  	
  				$activation_hash = md5 ( rand ( 100000, 999999 ) );
  				$profile->setHash ( $activation_hash );
  				$user_register = $this->formRegister->getEmbeddedForm ( 'sf_guard_user' )->getObject ();
  				$user_register->setUsername ( substr ( uniqid ( md5 ( rand () ), true ), 0, 8 ) );
  				$user_register->setIsActive ( true );
  				
  				$profile->setSfGuardUser ( $user_register );
  				
  				try {
  					$con->beginTransaction ();
  					// OLD
  					//$profile->setCountryId ( getlokalPartner::getInstance () );
  	
  					if (isset($params['gender']) && $params['gender']) {
  						$profile->setGender($params['gender']);
  					}
  					$profile->save ();
  					$user_settings = new UserSetting ();
  					$user_settings->setId ( $profile->getId () );
  	
  	
  					if (!isset($params ['allow_contact'])) {
  						$user_settings->setAllowContact(false);
  						$user_settings->setAllowNewsletter(false);
  					} else {
  						$user_settings->setAllowContact(true);
  						$user_settings->setAllowNewsletter(true);
  						$user_settings->setAllowPromo(true);
  					}
  	
  					if (!isset($params ['underage'])) {
  						$user_settings->setUnderage(false);
  					} else {
  						$user_settings->setUnderage(true);
  					}
  	
  	
  					$user_settings->save ();
  	
  	
  					// Subscribe to newsletter
  					$newsletters = NewsletterTable::retrieveActivePerCountryForUser($profile->getCountryId());
  					if ($newsletters) {
  						foreach ($newsletters as $newsletter) {
  							$usernewsletter = new NewsletterUser ();
  							$usernewsletter->setNewsletterId($newsletter->getId());
  							$usernewsletter->setUserId($profile->getId());
  							$usernewsletter->setIsActive($user_settings->getAllowContact());
  							$usernewsletter->save();
  						}
  	
  						MC::subscribe_unsubscribe($user_register);
  					}
  	
  					$user_register = $profile->getSfGuardUser ();
  					//$user_register->addDefaultPermissionsAndGroups ( array ('user' ), array () );
  	
  					$this->__associatedFriends($profile);
  	
  					$con->commit ();
  				} catch ( Exception $e ) {
  					die($e->getMessage());
  					$con->rollback ();
  	
  					$this->getUser ()->setFlash ( 'error', 'We were unable to send a confirmation request to the email address that you provided. Please check the email you provided is correct.' );
  					return sfView::SUCCESS;
  	
  				}
  				$this->getUser()->signIn($user_register);
  				$this->user = $this->getUser()->getGuardUser();
  				$culture = $this->getUser ()->getCulture ();
  	
  				myTools::sendMail ( $user_register, 'Welcome to getlokal', 'activation', array ('user' => $user_register ) );
  				$i18n = sfContext::getInstance ()->getI18N ();
  				$this->getUser()->setAttribute('home.notice',
  						$i18n->__('<p class="part_one"><span class="greet">Congrats</span> you are our newest registered user.</p><p class="part_two"> Now you can tell everyone about the great places only you know!</p>',null,'user'));
  			}
  		}
  	}
  	
    $query = Doctrine::getTable('Comment')
                ->createQuery('c')
                ->innerJoin('c.UserProfile p')
                ->innerJoin('p.sfGuardUser')
                ->innerJoin('c.ActivityComment ac')
                ->leftJoin('c.Parent')
    			->orderBy('c.id DESC');
                if ($this->user){
                $query->leftJoin('ac.UserLike ul WITH ul.user_id = ?', $this->user->getId());
                }
                $query->where('c.activity_id = ?', $this->activity->getId());
                
    $classes_without_pager = array("list_comments");
    //if(in_array($this->pager_class,$classes_without_pager)){
    	$this->results = $query->execute();
    /*}else{
    	$this->pager = new sfDoctrinePager('Comment', 20);
    	$this->pager->setQuery($query);
    	$this->pager->setPage($this->getRequest()->getParameter('page', 1));
    	$this->pager->init();
    }
    */
    if(!isset($this->form)) $this->form = new CommentForm();
  }
  
  public function __associatedFriends($invitedUser) {
  	if ($code = $this->getUser()->getAttribute('code', false)) {
  		//$invitedUserTable = Doctrine::getTable('InvitedUser')->findOneByHash($code);
  
  		$email = $invitedUser->getSfGuardUser()->getEmailAddress();
  		$facebookUID = $invitedUser->getFacebookUid();
  		$invitedUserTable = Doctrine::getTable('InvitedUser')
  		->createQuery('iu')
  		->where('iu.hash = ?', $code)
  		->andWhere('iu.email = ? or iu.facebook_uid = ?', array($email, $facebookUID))
  		->fetchOne();
  
  		if ($invitedUserTable && $userWhoSentInvite = Doctrine::getTable('UserProfile')->findOneById($invitedUserTable->getUserId())) {
  			$points = $userWhoSentInvite->getPoints() + $invitedUserTable->getPointsToUser();
  			$userWhoSentInvite->setPoints($points);
  			$userWhoSentInvite->save();
  		}
  
  		$pointsToInvited = 0;
  		if ($invitedUserTable) {
  			$pointsToInvited = $invitedUserTable->getPointsToInvited();
  		}
  
  		$points = $invitedUser->getPoints() + $invitedUserTable;
  		$invitedUser->setPoints($points);
  		$invitedUser->save();
  
  		$friendList = new friendList();
  		$friendList->setUserId1($userWhoSentInvite->getId());
  		$friendList->setUserId2($invitedUser->getId());
  
  		$friendList->save();
  
  		// Delete current record
  		// Deprecated after new specification
  		//$invitedUserTable->delete();
  
  		$this->getUser()->setAttribute('code', null);
  	}
  	else {
  		// Set relation by e-mail of fb
  		$email = $invitedUser->getSfGuardUser()->getEmailAddress();
  		$facebookUID = $invitedUser->getFacebookUid();
  		$query = Doctrine::getTable('InvitedUser')
  		->createQuery('iu')
  		->where('iu.email = ?', $email)
  		->orWhere('iu.facebook_uid = ?', $facebookUID);
  
  		if ($friends = $query->execute()) {
  			foreach ($friends as $friend) {
  				$friendList = new friendList();
  				$friendList->setUserId1($invitedUser->getId());
  				$friendList->setUserId2($friend->getUserId());
  				$friendList->save();
  
  				// Deprecated after new specification
  				//$friend->delete();
  			}
  		}
  	}
  }
}