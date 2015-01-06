<?php

/**
 * company actions.
 *
 * @package    getLokal
 * @subpackage photo
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userSettingsActions extends sfActions {
	
	public function preExecute() {
		$this->user = $this->getUser()->getGuardUser ();
		if (!$this->user)
		{
		 $this->redirect ( 'user/signin' );	
		}
		$this->profile = $this->user->getUserProfile ();
		$this->getResponse ()->setSlot ( 'sub_module', 'userSettings');
		$this->getResponse ()->setSlot ( 'sub_module_parameters', array('user'=>$this->user));
	}
	
    public function executeIndex(sfWebRequest $request) {
        $this->form = new AccountSettingsForm($this->profile, array('city_is_mandatory' => true));

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter($this->form->getName()));

            if ($this->form->isValid()) {
                $object = $this->form->save();
                
                // $msg = array('user' => $this->user, 'object' => 'user', 'action' => 'changePersonalInfo');
                // $this->dispatcher->notify(new sfEvent($msg, 'user.write_log'));

                $this->getUser()->setFlash('notice', 'Your account changes were successfully saved.');
                $this->redirect('userSettings/index');
            }
        }

        $request->setParameter('no_location', true);
        $this->getResponse()->setTitle('Account Settings');
    }

	public function executeSecurity(sfWebRequest $request) {
		
		$this->form = new ChangePasswordForm ( $this->user );
	   if(in_array($this->user->getId(), sfConfig::get('app_getlokal_power_user',array())))
				{
					$this->redirect('user/secure');
				}
		if ($request->isMethod ( 'post' )) {
			$this->form->bind ( $request->getParameter ( $this->form->getName () ) );
			
			if ($this->form->isValid ()) {
				$this->user->setPassword ( $this->form->getValue ( 'new_password' ) );
				$this->user->save ();
				$this->getUser ()->setFlash ( 'notice', 'Your password was changed successfully.' );
				 $msg = array('user'=>$this->user, 'object'=>'user', 'action'=>'changePassword');      
			     $this->dispatcher->notify(new sfEvent($msg, 'user.write_log'));
          
				$this->redirect ( 'userSettings/security' );
			}
		}
		$request->setParameter ( 'no_location', true );
		$this->getResponse ()->setTitle ( 'Change Password' );
	}
	
public function executeDeactivateMe(sfWebRequest $request) {
            MC::unsubscribe($this->user->getUserProfile()->getSfGuardUser()->getEmailAddress(), $this->user->getUserProfile()->getCountry()->getSlug(), sfConfig::get('app_mail_chimp_list_name_' . $this->user->getUserProfile()->getCountry()->getSlug()) );
		
	    $activation_hash = md5 ( rand ( 100000, 999999 ) );
		$this->user->getUserProfile()->setHash ( $activation_hash );
	    $this->user->getUserProfile()->save ();
		$this->user->setIsActive ( false );
		$this->user->save ();		
		$this->getUser ()->setFlash ('Your getlokal account was deactivated successfully.');
		$this->getUser ()->signOut ();
		
		myTools::sendMail ( $this->user, 'Your getlokal account was deactivated', 'deactivation', array ('user' => $this->user ) );
		$this->redirect ( '@homepage' );
	}
	
	public function executeDeactivateAccount(sfWebRequest $request) {
		if ($request->isMethod ( 'POST' )) {
                        MC::unsubscribe($this->user->getUserProfile()->getSfGuardUser()->getEmailAddress(), $this->user->getUserProfile()->getCountry()->getSlug(),   sfConfig::get('app_mail_chimp_list_name_' . $this->user->getUserProfile()->getCountry()->getSlug()));

			$msg = array ('user' => $this->user, 'object' => 'user', 'action' => 'deleteAccount' );
			$this->dispatcher->notify ( new sfEvent ( $msg, 'user.write_log' ) );
			$user_reviews = $this->user->getAllReviews ();
			$user_pictures = $this->user->getAllPictures ();
			$profile = $this->user->getUserProfile();
			$user_setting = $profile->getUserSetting();
			$page_admins= $profile->getPageAdmin();
			$con = Doctrine::getConnectionByTableName ( 'sfGuardUser' );
			try {
					$con->beginTransaction ();
			if ($user_reviews) {
				foreach ( $user_reviews as $review ) {
					//if ($review->getReview ()) {
					//	$review->getReview ()->delete ();
					//}
					$review->delete ();
				}
			}
			
			if ($user_pictures) {
				foreach ( $user_pictures as $picture ) {
					$picture->delete();
				}
			}
			
			if(count($page_admins) > 0)
			{
				foreach($page_admins as $page_admin)
				{
					$page_admin->delete();
				}
			}
			$profile->getUserPage()->delete();
			$user_setting->delete();
			$profile->delete();			
			$this->user->delete();
			
			$con->commit ();
				} catch ( Exception $e ) {
					$con->rollback ();
					$this->getUser ()->setFlash ( 'error', 'An error ocurred while processing your request. Please try again later.' . $e->getMessage());
					return sfView::SUCCESS;
				
				}
			$this->user = null;
            $this->getUser()->clearCredentials();
            $this->getUser()->setAuthenticated(false);
//			$this->getUser ()->setFlash ( 'Your getlokal account was deleted successfully.' );
			
			$this->redirect ( 'user/deactivated' );
		}
	}
	
	public function executeChangeUsername(sfWebRequest $request) {
		$new_username = $this->profile->getUserPage ()->getUrlAlias ();
		
		if (! $new_username) {
			$this->form = new ChangeUsernameForm ( $this->user );
		
			
			if ($request->isMethod ( 'post' )) {
				$this->form->bind ( $request->getParameter ( $this->form->getName () ) );
				
				if ($this->form->isValid ()) {
					$new_username = $this->form->getValue ( 'username' );
					$this->user->setUsername ( $new_username );
					$this->user->save ();
					$this->profile->getUserPage ()->setUrlAlias ( $new_username );
					$this->profile->getUserPage ()->setForeignId ( $this->profile->getId () );
					$this->profile->getUserPage ()->setCountryId ( $this->profile->getCountryId () );
					$this->profile->getUserPage ()->save ();
					$this->getUser ()->setFlash ( 'notice', 'Your username was changed successfully.');
					 
					$msg = array('user'=>$this->user, 'object'=>'user', 'action'=>'changeUsername');      
			        $this->dispatcher->notify(new sfEvent($msg, 'user.write_log'));
					
			        $this->redirect ( 'userSettings/changeUsername' );
				}
			}
		}
		 $request->setParameter ( 'no_location', true );
		$this->getResponse ()->setTitle ( 'Change Username' );
	}
	
	public function executeChangeEmail(sfWebRequest $request) {
	    if(in_array($this->user->getId(), sfConfig::get('app_getlokal_power_user',array())))
		{
		  $this->redirect('user/secure');
		}
		$this->form = new ChangeEmailForm ( $this->user );
		
		if ($request->isMethod ( 'post' )) {
			$this->form->bind ( $request->getParameter ( $this->form->getName () ) );
			
			if ($this->form->isValid ()) {
				$con = Doctrine::getConnectionByTableName ( 'sfGuardUser' );
				$email = mb_strtolower ( $this->form->getValue ( 'email_address' ) );
				$hash = md5 ( rand ( 100000, 999999 ) );
				$profile = $this->user->getUserProfile ();			   
				$this->user->setEmailAddress ( $email );
				$this->user->setIsActive ( false );
				try {
					$con->beginTransaction ();
					$this->user->save ();
					$profile->setHash ( $hash );
					$profile->save ();
					myTools::sendMail ( $this->user, 'Change Email Confirmation', 'changeEmail', array ('user' => $this->user ) );
					
					$con->commit ();
				} catch ( Exception $e ) {
					$con->rollback ();
					$this->getUser ()->setFlash ( 'error', 'We were unable to change your email.' );
					return sfView::SUCCESS;
				
				}
				$this->getUser ()->setFlash ( 'notice', 'Your email was changed successfully.');
				
				$msg = array('user'=>$this->user, 'object'=>'user', 'action'=>'changeEmail');      
			    $this->dispatcher->notify(new sfEvent($msg, 'user.write_log'));
				
			    $this->redirect ( 'userSettings/changeEmail' );
			}
		}
		 $request->setParameter ( 'no_location', true );
		$this->getResponse ()->setTitle ( 'Security Settings' );
	}
	
	public function executeUpload(sfWebRequest $request) {
		$this->form = new ImageForm ();
		
		if ($request->isMethod ( 'post' )) {
			$this->form->bind ( $request->getParameter ( $this->form->getName () ), $request->getFiles ( $this->form->getName () ) );
			
			if ($this->form->isValid ()) {
				$image = new Image ();
				$image->setFile ( $this->form->getValue ( 'file' ) );
				$image->setCaption ( $this->form->getValue ( 'caption' ) );
				$image->setUserId ( $this->getUser ()->getId () );
        $image->setType('profile');
        $image->setStatus('approved');
				$image->save ();
				
				$this->getUser ()->setFlash ( 'notice', 'Picture was saved successfully.' );
				
				$this->redirect ( 'userSettings/images' );
			} else{
	            if(myTools::isExceedingMaxPhpSize()){
	              $this->getUser ()->setFlash ( 'error', 'File size limit is 4MB.Please reduce file size before submitting again.' );
	            }
          	}
		}
	}
	
	public function executeSetProfile(sfWebRequest $request) {
		$query = Doctrine::getTable ( 'Image' )->createQuery ( 'i' )->where ( 'i.user_id = ?', $this->getUser ()->getId () )->andWhere ( 'i.id = ?', $request->getParameter ( 'id' ) );
		
		$this->forward404Unless ( $image = $query->fetchOne () );
		
		$this->profile->setImageId ( $image->getId () );
		$this->profile->save ();
		$this->getUser ()->setFlash ('notice', 'The profile picture was changed successfully.');
				
		$this->redirect ( $request->getReferer () );
	}
	
	public function executeDeleteImage(sfWebRequest $request) {
		$query = Doctrine::getTable ( 'Image' )->createQuery ( 'i' )->where ( 'i.user_id = ?', $this->getUser ()->getId () )->andWhere ( 'i.id = ?', $request->getParameter ( 'id' ) );
		
		$this->forward404Unless ( $image = $query->fetchOne () );
		
		$image->delete ();
		
		$this->getUser ()->setFlash ( 'notice', 'The photo was deleted successfully.' );
		
		$this->redirect ( $request->getReferer () );
	}
	
	public function executeImages(sfWebRequest $request) {
		$query = Doctrine::getTable ( 'Image' )->createQuery ( 'i' )->where ( 'i.user_id = ?', $this->getUser ()->getId () );
		
		$this->pager = new sfDoctrinePager ( 'Image', 9 );
		$this->pager->setPage ( $request->getParameter ( 'page', 1 ) );
		$this->pager->setQuery ( $query );
		$this->pager->init ();
	}
	
	public function executeFindMyCompany(sfWebRequest $request) {
                breadCrumb::getInstance()->removeRoot();
		$this->form = new SearchCompanyForm ();
		$this->search = null;
		if ($request->getParameter ( 'search' )) {
			$this->search = $request->getParameter ( 'search' );
			$this->pager = $this->getPagerCompanies ( $this->getCriteriaCompanies ( $this->search ), $request->getParameter ( 'page', 1 ) );
			return sfView::SUCCESS;
		} elseif ($request->isMethod ( 'post' )) {
			
			$this->form->bind ( $request->getParameter ( $this->form->getName () ) );
			
			if ($this->form->isValid ()) {
				
				$this->search = $this->form->getValue ( 'mycompany' );
				
				$this->pager = $this->getPagerCompanies ( $this->getCriteriaCompanies ( $this->search ), $request->getParameter ( 'page', 1 ) );
			
			}
		}
	
	}
	protected function getPagerCompanies($criteria, $page) {
		$pager = new sfDoctrinePager ( 'Company', 5 );
		
		$pager->setQuery ( $criteria );
		
		$pager->setPage ( $page );
		$pager->init ();
		
		return $pager;
	}
	
	public function getCriteriaCompanies($search_term) {
		sfContext::getInstance()->getConfiguration()->loadHelpers('Frontend');
		$company = "%" . format_company_title ( $search_term ) . "%";
		
		$dql = Doctrine_Query::create ()->from ( 'Company c' )
                        ->innerJoin('c.Translation ctr')
                        ->where ( 'ctr.title LIKE ?  OR c.registration_no = ? ', array ($company, $search_term ) )
                        ->addWhere('c.status = 0');
		return $dql;
	
	}
	
    public function executeCommunication(sfWebRequest $request) {
        breadCrumb::getInstance()->removeRoot();
        $this->status = MC::getEmailStatus($this->user->getUserProfile());

        $this->form = new CommunicationForm($this->user->getUserProfile()->getUserSetting());
        $newsletters = NewsletterTable::retrieveActivePerCountry($this->user->getUserProfile()->getCountryId());
        if ($newsletters) {
            $this->usernewsletters = array();
            foreach ($newsletters as $newsletter) {
                $checkthis1 = 1;
                $checkthis = NewsletterUserTable::getPerUserAndNewsletter($this->user->getId(), $newsletter->getId());

                if ($checkthis) {
                    $checkthis1 = $checkthis->getIsActive();
                }

                $this->usernewsletters [$newsletter->getId()] = $checkthis1;
            }
        }

        if ($request->isMethod('post')) {
            $params = $request->getParameter($this->form->getName());

            if (!array_key_exists('allow_contact', $params)) {
                unset($params['allow_newsletter']);
                unset($params['allow_b_cmc']);
                unset($params['allow_promo']);
            }

            $this->form->bind($params);

            if ($this->form->isValid()) {
                $this->form->save();

                if ($newsletters) {
                    if (!array_key_exists('allow_contact', $params)) {
                        foreach ($newsletters as $newsletter) {
                            $checkthis = NewsletterUserTable::getPerUserAndNewsletter($this->user->getId(), $newsletter->getId());
                            if ($checkthis instanceof NewsletterUser) {
                                $checkthis->setIsActive(false);
                                $checkthis->save();
                            } else {
                                if (($newsletter->getUserGroup() == 'Бизнес бюлетини' || $newsletter->getUserGroup() == 'Business newsletters' || $newsletter->getUserGroup() == 'Newsletter business') && !$this->user->getIsPageAdmin()) continue;

                                $usernewsletter = new NewsletterUser ();
                                $usernewsletter->setNewsletterId($newsletter->getId());
                                $usernewsletter->setUserId($this->user->getId());
                                $usernewsletter->setIsActive(false);
                                $usernewsletter->save();
                            }
                        }
                    } else {
                        foreach ($newsletters as $newsletter) {
                            if ($newsletter->getUserGroup() != 'Бизнес бюлетини' && $newsletter->getUserGroup() != 'Business newsletters' && $newsletter->getUserGroup() != 'Newsletter business') {
                                // New
                                if (($newsletter->getUserGroup() == 'Развлекателни бюлетини' || $newsletter->getUserGroup() == 'Community newsletters' || $newsletter->getUserGroup() == 'Newsletter de comunitate') && (!isset($params['allow_newsletter']) || !$params['allow_newsletter'])) {
                                    unset($params['newsletter_' . $newsletter->getId()]);
                                }

                                if (($newsletter->getUserGroup() == 'Известия за игри и промоции' || $newsletter->getUserGroup() == 'Games and promotions' || $newsletter->getUserGroup() == 'Jocuri si promotii') && (!isset($params['allow_promo']) || !$params['allow_promo'])) {
                                    unset($params['newsletter_' . $newsletter->getId()]);
                                }

                                if (array_key_exists('newsletter_' . $newsletter->getId(), $params)) {
                                    $checkthis = NewsletterUserTable::getPerUserAndNewsletter($this->user->getId(), $newsletter->getId());

                                    if ($checkthis) {
                                        $checkthis->setIsActive(true);
                                        $checkthis->save();
                                    } else {
                                        if (($newsletter->getUserGroup() == 'Бизнес бюлетини' || $newsletter->getUserGroup() == 'Business newsletters' || $newsletter->getUserGroup() == 'Newsletter business') && !$this->user->getIsPageAdmin()) continue;

                                        $usernewsletter = new NewsletterUser ();
                                        $usernewsletter->setNewsletterId($newsletter->getId());
                                        $usernewsletter->setUserId($this->user->getId());
                                        $usernewsletter->setIsActive(true);
                                        $usernewsletter->save();
                                    }
                                } else {
                                    $checkthis = NewsletterUserTable::getPerUserAndNewsletter($this->user->getId(), $newsletter->getId());

                                    if ($checkthis) {
                                        $checkthis->setIsActive(false);
                                        $checkthis->save();
                                    } else {
                                        if (($newsletter->getUserGroup() == 'Бизнес бюлетини' || $newsletter->getUserGroup() == 'Business newsletters' || $newsletter->getUserGroup() == 'Newsletter business') && !$this->user->getIsPageAdmin()) continue;

                                        $usernewsletter = new NewsletterUser ();
                                        $usernewsletter->setNewsletterId($newsletter->getId());
                                        $usernewsletter->setUserId($this->user->getId());
                                        $usernewsletter->setIsActive(false);
                                        $usernewsletter->save();
                                    }
                                }
                            } else {
                                if ($this->user->getIsPageAdmin()) {
                                    // New
                                    if (($newsletter->getUserGroup() == 'Развлекателни бюлетини' || $newsletter->getUserGroup() == 'Community newsletters' || $newsletter->getUserGroup() == 'Newsletter de comunitate') && (!isset($params['allow_newsletter']) || !$params['allow_newsletter'])) {
                                        unset($params['newsletter_' . $newsletter->getId()]);
                                    }

                                    if (($newsletter->getUserGroup() == 'Известия за игри и промоции' || $newsletter->getUserGroup() == 'Games and promotions' || $newsletter->getUserGroup() == 'Jocuri si promotii') && (!isset($params['allow_promo']) || !$params['allow_promo'])) {
                                        unset($params['newsletter_' . $newsletter->getId()]);
                                    }

                                    if (($newsletter->getUserGroup() == 'Бизнес бюлетини' || $newsletter->getUserGroup() == 'Business newsletters' || $newsletter->getUserGroup() == 'Newsletter business') && (!isset($params['allow_b_cmc']) || !$params['allow_b_cmc'])) {
                                        unset($params['newsletter_' . $newsletter->getId()]);
                                    }

                                    if (array_key_exists('newsletter_' . $newsletter->getId(), $params)) {
                                        $checkthis = NewsletterUserTable::getPerUserAndNewsletter($this->user->getId(), $newsletter->getId());

                                        if ($checkthis) {
                                            $checkthis->setIsActive(true);
                                            $checkthis->save();
                                        } else {
                                            $usernewsletter = new NewsletterUser ();
                                            $usernewsletter->setNewsletterId($newsletter->getId());
                                            $usernewsletter->setUserId($this->user->getId());
                                            $usernewsletter->setIsActive(true);
                                            $usernewsletter->save();
                                        }
                                    } else {
                                        $checkthis = NewsletterUserTable::getPerUserAndNewsletter($this->user->getId(), $newsletter->getId());

                                        if ($checkthis) {
                                            $checkthis->setIsActive(false);
                                            $checkthis->save();
                                        } else {
                                            $usernewsletter = new NewsletterUser ();
                                            $usernewsletter->setNewsletterId($newsletter->getId());
                                            $usernewsletter->setUserId($this->user->getId());
                                            $usernewsletter->setIsActive(false);
                                            $usernewsletter->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                // Subscribe or unsubscribe the user
                MC::subscribe_unsubscribe();

                $this->getUser()->setFlash('notice', 'Your account changes were successfully saved.');
                $msg = array('user' => $this->user, 'object' => 'user', 'action' => 'changeCommunication');
                $this->dispatcher->notify(new sfEvent($msg, 'user.write_log'));
                $this->redirect('userSettings/communication');
            }
        }
        $request->setParameter('no_location', true);
        $this->getResponse()->setTitle('Communication Settings');
    }
	
public function executeCompanySettings(sfWebRequest $request) {
    breadCrumb::getInstance()->removeRoot();
    if ($pageuser= $this->getUser()->getPageAdminUser())
	{
		$this->getUser()->signOutPageAdmin();
		
		//$this->redirect('userSettings/basic?slug='.$pageuser->getCompanyPage()->getCompany()->getSlug());
	}
	$this->user = $this->getUser()->getGuardUser();
    if (!$this->user->getIsPageAdmin ()){
      $city = (($this->user->getUserProfile ()->getCity())? $this->user->getUserProfile ()->getCity()->getSlug():$this->getUser()->getCity()->getSlug());
      $this->redirect('@home?city='.$city);
    }
		if ($this->getActionName () == 'noAccess')
			return;
		
		$request = $this->getRequest ();
		
		$query = Doctrine::getTable ( 'Company' )
		->createQuery ( 'c' )
		->innerJoin ( 'c.CompanyPage p' );
		if (!$this->getUser ()->isGetlokalAdmin())
		{
		$query->innerJoin ( 'p.PageAdmin a' )
		->where ( 'a.user_id = ?', $this->getUser ()->getId () )
		->andWhere ( 'a.status = ?', 'approved' );
		
		$q = clone $query;
		
		$q->andWhere ( 'c.slug = ?', $request->getParameter ( 'slug' ) );
		
		if (! $this->company = $q->fetchOne ()) {
			$this->company = $query->fetchOne ();
		}
		
		$this->forwardUnless ( $this->company, 'companySettings', 'noAccess' );
		
		$this->companies = $query->execute ();
		
		$q = Doctrine::getTable ( 'PageAdmin' )->createQuery ( 'p' )
		->where ( 'p.page_id = ?', $this->company->getCompanyPage ()->getId () )->andWhere ( 'p.user_id = ?', $this->getUser ()->getId () );
		$this->pageAdmin = $q->fetchOne ();
	}else {
		$query->andWhere ( 'c.slug = ?', $request->getParameter ( 'slug' ) );
		$this->companies=array();
		$this->company = $query->fetchOne ();
		
		$this->forwardUnless ( $this->company, 'companySettings', 'noAccess' );
		
	}
		
		
	}
	
public function executeRegisterPageAdmin(sfWebRequest $request) {
 
    $page_admin_id = $request->getParameter ( 'id' );
	
    $query = Doctrine::getTable ( 'PageAdmin' )
		->createQuery ( 'a' )
		->innerJoin ( 'a.CompanyPage p' )->innerJoin ( 'p.Company c' )
		->where('a.id = ? ', $page_admin_id)
		->andWhere ( 'a.user_id = ?', $this->getUser ()->getId () )
		->andWhere ( 'a.status = ?', 'approved' );
		
		$q = clone $query;
		
		$q->andWhere ( 'c.slug = ?', $request->getParameter ( 'slug' ) );
		
		if (! $this->pageadmin = $q->fetchOne ()) {
			
			$this->pageadmin = $query->fetchOne ();
		}
		
	    $this->forwardUnless ($this->pageadmin, 'companySettings', 'noAccess' );
		
		$this->company = $this->pageadmin->getCompanyPage()->getCompany();
        $this->forwardUnless ($this->company, 'companySettings', 'noAccess' );
		$this->companies = array($this->company);
   
	    $this->form = new PageAdminForm ( $this->pageadmin);
		
		if ($request->isMethod ( 'post' )) {
			$params =$request->getParameter ( $this->form->getName () );
			$params['username'] = mb_convert_case($params['username'], MB_CASE_LOWER);
			if(!$this->user->getUserProfile()->getIsPageAdminConfirmed()){
			if (isset($params['allow_b_cmc']))
            {
             $allow_b_cmc= true;
            }else 
            {
          
              $allow_b_cmc= false;
            }
			}
			$this->form->bind ($params);
			
			if ($this->form->isValid ()) {
				//TODO
				$values = $this->form->getValues();
				
				$pageuser=$this->form->save();	
				if(isset($allow_b_cmc)){					
				$this->user->getUserProfile()->getUserSetting()->setAllowBCmc($allow_b_cmc);			
				$this->user->getUserProfile()->getUserSetting()->save();
				$newsletters = NewsletterTable::retrieveActivePerCountry($this->user->getUserProfile()->getCountryId(),'business');
               if ($newsletters){
               foreach ($newsletters as $newsletter)
               {
              $newsletter_user= NewsletterUserTable::getPerUserAndNewsletter($this->user->getId(), $newsletter->getId());
              if (!$newsletter_user)
              {
                $newsletter_user = new NewsletterUser();
                $newsletter_user->setNewsletterId($newsletter->getId());
                $newsletter_user->setUserId($this->user->getId());
              }
               $newsletter_user->setIsActive($allow_b_cmc);              
               $newsletter_user->save();
            }
            }
		}
				 $msg = array('user'=>$this->user, 'object'=>'company', 'action'=>'setPlaceUsername');      
		         $this->dispatcher->notify(new sfEvent($msg, 'user.write_log'));
          
				$this->getUser()->signInPageAdmin($pageuser, false);
				//$this->getUser ()->setFlash ( 'notice', 'Information was changed successfully.' );

                                // Set city after login
                                if ($this->getUser()->getCountry()->getId() == $this->getUser()->getProfile()->getCountry()->getId()) {                                    
                                    $this->getUser()->setCity($this->getUser()->getProfile()->getCity());
                                    $this->getUser()->setAttribute('user.set_city_after_login', true);
                                }

				$this->redirect('companySettings/basic?slug='.$pageuser->getCompanyPage()->getCompany()->getSlug());
				
			}
		}
		$request->setParameter ( 'no_location', true );
		$this->getResponse ()->setTitle ( 'Secure Place Admin' );
		$this->setTemplate ( 'companySettings' );
	}
	
	public function executeForgotPassword(sfWebRequest $request) {
            breadCrumb::getInstance()->removeRoot();
	    if(in_array($this->user->getId(), sfConfig::get('app_getlokal_power_user',array())))
		{
		  $this->redirect('user/secure');
		}
		$all_companies=array();
		$query = Doctrine::getTable('Company')
			->createQuery('cy')
			->innerjoin('cy.CompanyPage cp')
			->innerJoin('cp.PageAdmin pa')
			->where('pa.user_id = ? ', $this->user->getId())
			->andWhere('pa.status = ? ', 'approved');
	     
		if ($request->getParameter ( 'slug' ))
		{
			
			$query->andWhere('cy.slug = ? ', $request->getParameter ( 'slug' ));
		    $this->company = $query->fetchOne();
		    if (!$this->company ){ 		    	
		    $this->getUser ()->setFlash ( 'error', 'The username and/or password are invalid or you don\'t have enough credentials' );
		    $this->redirect ( 'companySettings/noAccess' );
		    }
		    $this->form = new ForgotPasswordAdminForm (null, array('company' => $this->company));
		}
		else {
		$companies = $query->execute();
		if (count($companies) == 0 ){
		$this->getUser ()->setFlash ( 'error', 'No companies to administer' );
		$this->redirect('companySettings/login');	
		}else {
			foreach ($companies as $firm){
				$all_companies[$firm->getId()] =$firm->getId(); 
				
			}
		}	
		$this->form = new ForgotPasswordAdminForm ();	
		}
		if ($request->isMethod ( 'post' )) {
			$this->form->bind ( $request->getParameter ( 'forgot_password' ), $request->getFiles ( 'forgot_password' ) );
			
			if ($this->form->isValid ()) {
				
				$password = substr ( md5 ( rand ( 100000, 999999 ) ), 0, 8 );
				$params = $request->getParameter ( 'forgot_password', array () );
				$username = mb_strtolower ( $params ['username'] );
				
				$user = Doctrine::getTable ( 'PageAdmin' )->findOneByUsername ( $username );
				if (!$user) {
					$this->getUser ()->setFlash ( 'error', 'There is no profile with this username' );
					return sfView::SUCCESS;
				} 
				
				if (isset($this->company))
				{

					$this->forwardUnless (($this->user->getId() == $user->getUserId()), 'companySettings', 'noAccess' );
				}elseif($all_companies)
				{
					 $this->forwardUnless ((array_key_exists($user->getCompanyPage()->getCompany()->getId(), $all_companies)), 'companySettings', 'noAccess' );
					
				}
				$con = Doctrine::getConnectionByTableName ( 'PageAdmin' );
				

				
					
					try {
						$con->beginTransaction ();
						$user->setPassword ( $password );
						$user->save ();						
						$con->commit ();
					} catch ( Exception $e ) {
						$con->rollback ();
						$this->getUser ()->setFlash ( 'error', 'We were unable to send you a new password.' );
						return sfView::SUCCESS;
					
					}
					
					$name = Doctrine::getTable('SerbianNames')
					->createQuery ( 'sn' )
					->where('name = ?', $user->getUserProfile()->getFirstName())
					->fetchOne();
					
					if ($name){
						$name =  $name->getSuffix();
					} else{
						$name =  $user->getUserProfile()->getFirstName();
					}					
					
					myTools::sendMail ( $user->getUserProfile(), 'Forgotten Place Admin Password', 'sendAdminPassword', array ('password' => $password, 'pageadmin'=>$user, 'pageadminName' => $name ) );
					$this->getUser ()->setFlash ( 'notice', 'The new password was sent successfully to the email you provided.' );
					
					if($this->company){
					$this->redirect ( 'companySettings/login?slug='.$this->company->getSlug() );
					}else {
					$this->redirect ( 'companySettings/login' );
					}
				
				
			}
		}
	 $request->setParameter ( 'no_location', true );
	 $this->getResponse ()->setTitle ('Forgotten Password');	
	}
	
public function executeSendMeMyAdminUsername(sfWebRequest $request) {
		$all_companies=array();
		$query = Doctrine::getTable('Company')
			->createQuery('cy')
			->innerjoin('cy.CompanyPage cp')
			->innerJoin('cp.PageAdmin pa')
			->where('pa.user_id = ? ', $this->user->getId())
			->andWhere('pa.status = ? ', 'approved')
		    ->andWhere('cy.slug = ? ', $request->getParameter ( 'slug' ));
		    $this->company = $query->fetchOne();
		    if (!$this->company ){ 		    	
		    $this->getUser ()->setFlash ( 'error', 'You don\'t have enough credentials' );
		    $this->redirect ( 'companySettings/noAccess' );
		    }
		    $pageadmin = $this->company->getPageAdminbyUserId($this->user->getId());
		    if (!$pageadmin)
            { 		    	
		    $this->getUser ()->setFlash ( 'error', 'You don\'t have enough credentials' );
		    $this->redirect ( 'companySettings/noAccess' );
		    }
		    
		    $name = Doctrine::getTable('SerbianNames')
		    ->createQuery ( 'sn' )
		    ->where('name = ?', $pageadmin->getUserProfile()->getFirstName())
		    ->fetchOne();
		    
		    if ($name){
		    	$name =  $name->getSuffix();
		    } else{
		    	$name =  $pageadmin->getUserProfile()->getFirstName();
		    }
		    
		   myTools::sendMail ( $this->user->getUserProfile(), 'Forgotten Username', 'sendAdminUsername', array ('pageadmin' => $pageadmin, 'pageadminName' => $name ) );
		   $this->getUser ()->setFlash ( 'notice', 'The username was sent successfully to your email.' );
	       $this->redirect ( 'userSettings/forgotPassword?slug='.$this->company->getSlug() );
	}
	
 public function executeFollow(sfWebRequest $request) {

      
       $q = Doctrine::getTable ( 'FollowPage' )
       ->createQuery('fp')
       ->where('fp.user_id = ?', $this->user->getId());
      $this->pager = new sfDoctrinePager ( 'FollowPage', 8 );
      $this->pager->setPage ( $request->getParameter ( 'page', 1 ) );
      $this->pager->setQuery ( $q );
      $this->pager->init ();
    }
}