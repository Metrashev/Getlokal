<?php

class reportActions extends sfActions 
{
  public function preExecute()
  {
    $report = new Report();


    if($this->getUser()->isAuthenticated())
    {
      $user = $this->getUser()->getGuardUser();
      
      $report->fromArray(array(
        'user_id' => $user->getId(),
        'email'   => $user->getEmailAddress(),
        'name'    => $user->getFirstName(). ' '. $user->getLastName(),
      ));
    }
    
    $this->form = new ReportForm($report);
    
    if($this->getRequest()->getParameter('modal'))
    {
      $this->setLayout('modal');
    }
  }
  
  public function isValid()
  {
    if($this->getRequest()->isMethod('post'))
    {
      $this->form->bind($this->getRequest()->getParameter($this->form->getName()));
      
      return $this->form->isValid();
    }
  }
  
  public function executeImage(sfWebRequest $request)
  {
    $this->forward404Unless($this->image = Doctrine::getTable('Image')->find($request->getParameter('id')));
    
    $this->getUser()->setReferer($request->getReferer());
    
    if($this->isValid())
    {
      $report = $this->form->updateObject();
      $report->setObjectId($this->image->getId());
      $report->setType('image');
      $report->save();

      $image = Doctrine::getTable('Image')->createQuery('i')
           ->where('i.id = ?', $report->getObjectId())
           ->fetchOne();

      $user = Doctrine::getTable('SfGuardUser')->createQuery('sfg')
           ->where('sfg.id = ?', $image->getUserId())
           ->fetchOne();

      $company = Doctrine::getTable('Company')->createQuery('c')
           ->innerJoin('c.CompanyImage ci')
           ->where('ci.image_id = ?', $image->getId())
           ->fetchOne();

//      $this->redirectUnless($this->getRequest()->getParameter('modal'), $this->getUser()->getReferer());
      $this->setTemplate('abuse');

      myTools::sendMail ( null, 'Report Image', 'reportAbuseMail', array('reportAbuse' => $report,
        'companyInfo' => $company, 'reportObject' => $image->getCaption(), 'author' => $user));
    }
  }
  
  
  public function executeReview(sfWebRequest $request)
  {
    $this->forward404Unless($this->review = Doctrine::getTable('Review')->find($request->getParameter('id')));
    
    $this->getUser()->setReferer($request->getReferer());
    
    if($this->isValid())
    {
      $report = $this->form->updateObject();
      $report->setObjectId($this->review->getId());
      $report->setType('review');
      $report->save();

      $review = Doctrine::getTable('Review')->createQuery('r')
           ->where('r.id = ?', $report->getObjectId())
           ->fetchOne();

      $user = Doctrine::getTable('SfGuardUser')->createQuery('sfg')
           ->where('sfg.id = ?', $review->getUserId())
           ->fetchOne();

      $company = Doctrine::getTable('Company')->createQuery('c')
           ->where('c.id = ?', $review->getCompanyId())
           ->fetchOne();
      
      $this->redirectUnless($request->isXmlHttpRequest(), $this->getUser()->getReferer($request->getReferer()));    
      $this->setTemplate('abuse');

      myTools::sendMail ( null, 'Report Review', 'reportAbuseMail', array('reportAbuse' => $report,
        'companyInfo' => $company, 'reportObject' => $review->getText(), 'author' => $user));
    }

  }
  
  
  public function executeComment(sfWebRequest $request)
  {
    $this->forward404Unless($this->comment = Doctrine::getTable('Comment')->find($request->getParameter('id')));
    
    $this->getUser()->setReferer($request->getReferer());
    
    if($this->isValid())
    {
      $report = $this->form->updateObject();
      $report->setObjectId($this->comment->getId());
      $report->setType('comment');
      $report->save();

      $comment = Doctrine::getTable('Comment')->createQuery('c')
           ->where('c.id = ?', $report->getObjectId())
           ->fetchOne();

      $user = Doctrine::getTable('SfGuardUser')->createQuery('sfg')
           ->where('sfg.id = ?', $comment->getUserId())
           ->fetchOne();

      $activity = Doctrine::getTable('Activity')->createQuery('a')
           ->where('a.id = ?', $comment->getActivityId())
           ->fetchOne();

 //     $this->redirectUnless($request->isXmlHttpRequest(), $this->getUser()->getReferer());
      $this->setTemplate('abuse');

      myTools::sendMail ( null, 'Report Comment', 'reportAbuseMail', array('reportAbuse' => $report,
        'activityInfo' => $activity, 'reportObject' => $comment->getBody(), 'author' => $user));
    }
  }
  
  public function executeList(sfWebRequest $request)
  {
    $this->forward404Unless($this->list = Doctrine::getTable('Lists')->find($request->getParameter('id')));
  
    $this->getUser()->setReferer($request->getReferer());
  
    if($this->isValid())
    {
      $report = $this->form->updateObject();
      $report->setObjectId($this->list->getId());
      $report->setType('list');
      $report->save();

      $lists = Doctrine::getTable('Lists')->createQuery('l')
            ->innerJoin('l.Translation lt')
            ->where('l.id = ?', $report->getObjectId())
            ->fetchOne();

      $user = Doctrine::getTable('SfGuardUser')->createQuery('sfg')
           ->where('sfg.id = ?', $lists->getUserId())
           ->fetchOne();

 //     $this->redirectUnless($request->isXmlHttpRequest(), $this->getUser()->getReferer());
      $this->setTemplate('abuse');

      myTools::sendMail ( null, 'Report List', 'reportAbuseMail', array('reportAbuse' => $report,
        'listInfo' => $lists, 'reportObject' => $lists->getTitle(), 'author' => $user));
    }
  }
  
  public function executeArticle(sfWebRequest $request)
  {
  	$this->forward404Unless($this->article = Doctrine::getTable('Article')->find($request->getParameter('id')));
  
  	$this->getUser()->setReferer($request->getReferer());
  
  	if($this->isValid())
  	{
  		$report = $this->form->updateObject();
  		$report->setObjectId($this->article->getId());
  		$report->setType('article');
  		$report->save();
  
  		$articles = Doctrine::getTable('Article')->createQuery('a')
  		->innerJoin('a.Translation at')
  		->where('a.id = ?', $report->getObjectId())
  		->fetchOne();
  
  		$user = Doctrine::getTable('SfGuardUser')->createQuery('sfg')
  		->where('sfg.id = ?', $articles->getUserId())
  		->fetchOne();
  
  		//     $this->redirectUnless($request->isXmlHttpRequest(), $this->getUser()->getReferer());
  		$this->setTemplate('abuse');
  
  		myTools::sendMail ( null, 'Report Article', 'reportAbuseMail', array('reportAbuse' => $report,
  		'articleInfo' => $articles, 'reportObject' => $articles->getTitle(), 'author' => $user));
  	}
  }
  
  public function executeEvent(sfWebRequest $request)
  {
  	$this->forward404Unless($this->event = Doctrine::getTable('Event')->find($request->getParameter('id')));
  
  	$this->getUser()->setReferer($request->getReferer());
  
  	if($this->isValid())
  	{
  		$report = $this->form->updateObject();
  		$report->setObjectId($this->event->getId());
  		$report->setType('event');
  		$report->save();
  
  		$events = Doctrine::getTable('Event')->createQuery('e')
  		->innerJoin('e.Translation et')
  		->where('e.id = ?', $report->getObjectId())
  		->fetchOne();
  
  		$user = Doctrine::getTable('SfGuardUser')->createQuery('sfg')
  		->where('sfg.id = ?', $events->getUserId())
  		->fetchOne();
  
  		//     $this->redirectUnless($request->isXmlHttpRequest(), $this->getUser()->getReferer());
  		$this->setTemplate('abuse');
  
  		myTools::sendMail ( null, 'Report Event', 'reportAbuseMail', array('reportAbuse' => $report,
  		'eventInfo' => $events, 'reportObject' => $events->getTitle(), 'author' => $user));
  	}
  }
  
}  