<?php

require_once dirname(__FILE__).'/../lib/PageAdminGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/PageAdminGeneratorHelper.class.php';

/**
 * PageAdmin actions.
 *
 * @package    getLokal
 * @subpackage PageAdmin
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PageAdminActions extends autoPageAdminActions
{
public function executeSetAdminStatus(sfWebRequest $request)
  {
   
    $this->page_admin = $this->getRoute()->getObject();
    
    
    $name = Doctrine::getTable('SerbianNames')
    ->createQuery ( 'sn' )
    ->where('name = ?', $this->page_admin->getUserProfile()->getFirstName())
    ->fetchOne();
    
    if ($name){
    	$page_admin_sr =  $name->getSuffix();
    } else{
    	$page_admin_sr =  $this->page_admin->getUserProfile()->getFirstName();
    }
    
    
    if ($request->getParameter('status'))
    {
    	 $status = $request->getParameter('status');    	
    	 $this->page_admin->setStatus($status);
    	 $this->page_admin->save();
    	 $this->getUser()->setFlash('notice', 'PageAdmin Approved Successfully');

      if ($status == 'approved')
      {
       myTools::sendMail ( $this->page_admin->getUserProfile() , 'Approved Place Claim in getlokal', 'claimRequestApproved' , array ('pageAdmin' => $this->page_admin, 'pageAdminSr' => $page_admin_sr ) );
       $this->getUser()->setFlash('notice', 'PageAdmin Approved Successfully');
      }elseif ($status == 'rejected') {
      $newsletters = NewsletterTable::retrieveActivePerCountry ( $this->page_admin->getUserProfile ()->getCountryId (), 'business' );
				if ($newsletters) {
					foreach ( $newsletters as $newsletter ) {
						$newsletter_user = NewsletterUserTable::getPerUserAndNewsletter ( $this->page_admin->getUserProfile ()->getId (), $newsletter->getId () );
						if ($newsletter_user) {
							$newsletter_user->delete ();
						}
					
					}
				}
        
       myTools::sendMail ( $this->page_admin->getUserProfile() , 'Rejected Place Claim in getlokal', 'claimRequestDeniedMail' , array ('pageAdmin' => $this->page_admin, 'pageAdminSr' => $page_admin_sr  ) ); 
       $this->getUser()->setFlash('notice', 'PageAdmin Rejected Successfully');	
      }
      
      
    }else{
			
			if ($this->page_admin->getStatus () != 'approved') {
				$status = 'approved';
				$this->page_admin->setStatus ( $status );
				$this->page_admin->save ();
				myTools::sendMail ( $this->page_admin->getUserProfile() , 'Approved Place Claim in getlokal', 'claimRequestApproved' , array ('pageAdmin' => $this->page_admin, 'pageAdminSr' => $page_admin_sr ) ); 
               $this->getUser ()->setFlash ( 'notice', 'PageAdmin Approved Successfully' );
			} else {
				$status = 'rejected';
				$this->page_admin->setStatus ( $status );
				$this->page_admin->save ();
				$newsletters = NewsletterTable::retrieveActivePerCountry ( $this->page_admin->getUserProfile ()->getCountryId (), 'business' );
				if ($newsletters) {
					foreach ( $newsletters as $newsletter ) {
						$newsletter_user = NewsletterUserTable::getPerUserAndNewsletter ( $this->page_admin->getUserProfile ()->getId (), $newsletter->getId () );
						if ($newsletter_user) {
							$newsletter_user->delete ();
						}
					
					}
				}
			   myTools::sendMail ( $this->page_admin->getUserProfile() , 'Rejected Place Claim in getlokal', 'claimRequestDeniedMail' , array ('pageAdmin' => $this->page_admin, 'pageAdminSr' => $page_admin_sr ) ); 
              
				$this->getUser ()->setFlash ( 'notice', 'PageAdmin Rejected Successfully' );
			}
    
   

    }
    $msg = array('user'=>$this->getUser()->getGuardUser(), 'object'=>'place_admin', 'action'=>$status, 'object_id'=>$this->page_admin->getId());      
    $this->dispatcher->notify(new sfEvent($msg, 'user.write_log'));
          
    $this->redirect('@page_admin');
  }
}
