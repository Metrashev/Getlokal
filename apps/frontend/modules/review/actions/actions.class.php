<?php

/**
 * reviews actions.
 *
 * @package    getLokal
 * @subpackage reviews
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reviewActions extends sfActions
{
  public function executeEdit(sfWebRequest $request)
  {
  	
  	if ($request->getParameter('review_id')){
  		$reviewId = $request->getParameter('review_id');
  	}
  	elseif ($request->getParameter('review_answer_id')){
  		$reviewId = $request->getParameter('review_answer_id');
  	}
  	$this->user = $this->getUser()->getGuardUser ();
  	$this->forward404Unless($this->review = Doctrine::getTable('Review')->find($reviewId));
    $this->forwardUnless($this->review->getUserId() == $this->user->getId(), 'user','secure');
    $this->review->getCompany()->setUser( $this->getUser());
    
  	if ($request->getParameter('review_id')){
  		 $this->form = new ReviewForm($this->review);
  	}
  	elseif ($request->getParameter('review_answer_id')){
  		$this->form = new AnswerForm($this->review);
  		$this->setTemplate('replyEdit');
  	}
    
    if ($request->isMethod('post')) {
      $this->form->bind($request->getParameter($this->form->getName()));
        if ($this->form->isValid())
        {
          $object = $this->form->updateObject();
          $object->save();
            
          $this->redirectUnless($request->isXmlHttpRequest(), '@company?city='.$this->review->getCompany()->getCity()->getSlug().'&slug='.$this->review->getCompany()->getSlug());
          
          return 'Done';
        }
    }
  }

  public function executeCloce(sfWebRequest $request)
  {
  	$this->forward404Unless($this->review = Doctrine::getTable('Review')->find($request->getParameter('review_id')));
 	$this->user = $this->getUser ()->getGuardUser();     
	$this->company = $this->review->getCompany();
	$this->company->setUser( $this->getUser());
	 $this->user_is_admin=false;
     $this->is_other_place_admin_logged = false;
      
      if ($this->getUser()->getPageAdminUser())
      {
        $this->is_other_place_admin_logged = true;
      	$admin = Doctrine::getTable('PageAdmin')
      	 ->createQuery('a')
        ->where ( 'a.id = ?', $this->getUser()->getPageAdminUser()->getId () )
        ->andWhere ( 'a.status = ?', 'approved' )
        ->andWhere ( 'a.page_id = ?', $this->company->getCompanyPage()->getId() )->fetchOne();
        if ($admin)
        {
        	$this->user_is_admin =true;
        	$this->is_other_place_admin_logged = false;
        }
      }
      $this->user_is_company_admin = (( $this->user &&  $this->user->getIsPageAdmin($this->company))? true : false );
	
	//$this->forwardUnless($this->user_is_admin,	'companySettings','login');
  	//    return 'Done';
  }

  public function executeReply(sfWebRequest $request)
  {
    $this->forward404Unless($this->review = Doctrine::getTable('Review')->find($request->getParameter('review_id')));
    $this->user = $this->getUser ()->getGuardUser();     
	$this->company = $this->review->getCompany();
	$this->company->setUser( $this->getUser());
	 $this->user_is_admin=false;
     $this->is_other_place_admin_logged = false;
      
      if ($this->getUser()->getPageAdminUser())
      {
        $this->is_other_place_admin_logged = true;
      	$admin = Doctrine::getTable('PageAdmin')
      	 ->createQuery('a')
        ->where ( 'a.id = ?', $this->getUser()->getPageAdminUser()->getId () )
        ->andWhere ( 'a.status = ?', 'approved' )
        ->andWhere ( 'a.page_id = ?', $this->company->getCompanyPage()->getId() )->fetchOne();
        if ($admin)
        {
        	$this->user_is_admin =true;
        	$this->is_other_place_admin_logged = false;
        }
      }
      $this->user_is_company_admin = (( $this->user &&  $this->user->getIsPageAdmin($this->company))? true : false );
	
	$this->forwardUnless($this->user_is_admin,	'companySettings','login');
	
	
	$answer = new Review();
    $answer->setParentId($this->review->getId());
    $answer->setUserId($this->user->getId ());
    $answer->setCompanyId($this->review->getCompanyId() );
    $answer->setRecommend(0);
    $answer->setRating(0);
  
    $this->form = new AnswerForm($answer);

    if ($request->isMethod('post')) {
    
    
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid())
      {
      		
       $answer->setText($this->form->getValue('text'));
       $answer->save();
        
        //$this->redirectUnless($request->isXmlHttpRequest(), '@company?city='.$answer->getCompany()->getCity()->getSlug().'&slug='.$answer->getCompany()->getSlug());
        
        $this->setTemplate('show');
      }$this->setTemplate('show');
    }
  }
  
  public function executeShow(sfWebRequest $request)
  {
    $this->user = $this->getUser ()->getGuardUser();
  	$this->forward404Unless($this->review = Doctrine::getTable('Review')->findOneBySlug($request->getParameter('slug')));
  }
  
  public function executeIndex(sfWebRequest $request)
  { 
  	$country_id = $this->getUser()->getCountry()->getId();
    //$partner_id = $this->getUser()->getCountry();
    $this->user = $this->getUser ()->getGuardUser();
    $country_id= getlokalPartner::getInstance(); 
    $query = Doctrine::getTable ( 'Review' )
              ->createQuery ( 'r' )
              ->innerJoin('r.Company c')
              ->innerJoin('r.ActivityReview a')
              ->innerJoin('r.UserProfile p')
              ->innerJoin('c.City ci')
              ->innerJoin('c.Classification ca')
              ->innerJoin('ca.Translation')
              ->innerJoin('c.Sector s')
              ->innerJoin('s.Translation')
              ->innerJoin('p.sfGuardUser sf')
              ->leftJoin('a.UserLike l WITH l.user_id = ?', $this->getUser()->getId())
              //->leftJoin('r.Review')
              ->where ( 'r.is_published = ?', Review::FRONTEND_REVIEWS_IS_PUBLISHED )
              ->addWhere( 'r.parent_id IS NULL')
              ->addWhere('c.country_id = ?', $country_id)
              ->addWhere('c.status = ?', 0)
              ->orderBy ( 'r.created_at DESC' );

    $this->classifications = Doctrine::getTable('Classification')
                              ->createQuery('c')
                              ->innerJoin('c.Translation ct')
                              ->where('c.id IN (11, 24, 56, 157, 160, 165, 170, 177, 185, 206 )')
                              ->execute();

    
    $this->pager = new sfDoctrinePager ( 'Review', Review::FRONTEND_REVIEWS_PER_PAGE );
    $this->pager->setQuery($query);    
    $this->pager->setPage ( $request->getParameter('page', 1) );
    $this->pager->init ();


    breadCrumb::getInstance()->removeRoot();
  
  }

	public function executeDeleteReview(sfWebRequest $request)
    {
      $this->user = $this->getUser ()->getGuardUser ();
	  
      $query = Doctrine::getTable('Review')
      ->createQuery('r')
      ->where('r.id = ?',$request->getParameter('review_id'))
      ->andWhere('r.user_id = ?', $this->user->getId());
      $this->forwardUnless($this->review = $query->fetchOne(),'user', 'secure');
      $this->review->getCompany()->setUser( $this->getUser());
      $this->review->delete();

       if ($request->getParameter('company_id')){
      	$company = Doctrine::getTable('Company')->find($request->getParameter('company_id'));
      	$this->getUser()->setFlash('notice','Review was deleted successfully.');
      	$this->redirect ($request->getReferer());
      }else {
      	$this->redirect('profile/reviews?username='. $this->user->getUsername());
      }
      
    }
  
}
