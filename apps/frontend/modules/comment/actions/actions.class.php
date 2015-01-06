<?php

class commentActions extends sfActions 
{
  public function executeSave(sfWebRequest $request)
  {
    $this->forward404Unless($this->activity = Doctrine::getTable('Activity')->find($request->getParameter('id')));
    $this->user = $this->getUser()->getGuardUser();
    $this->form = new CommentForm();
    $this->url = $request->getParameter('pager_url');
    

    $this->pager_url= $request->getParameter('pager_url') ;
    $this->form->bind($request->getParameter($this->form->getName()));

    
    
    if($this->form->isValid())
    {
      $comment = new Comment();
      $comment->setBody($this->form->getValue('body'));
      $comment->setUserId( $this->user->getId());
      $comment->setActivityId($this->activity->getId());
      $comment->save();
      $this->comment = $comment;
      $this->setTemplate('show');
//       $this->form = new CommentForm();
    }
   
    $this->redirectUnless($request->isXmlHttpRequest(), $request->getReferer());
  }
  
  public function executeReply(sfWebRequest $request)
  {
    $this->user = $this->getUser()->getGuardUser();
  	$this->forward404Unless($this->comment = Doctrine::getTable('Comment')->find($request->getParameter('id')));
    $comment = new Comment();
    $comment->setParentId($this->comment->getId());
    $this->pager_url= $request->getParameter('pager_url') ;
    $this->form = new CommentForm($comment);

    if ($request->isMethod('post')) {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid())
      {
        $review = $this->form->updateObject();
        $comment->setBody($this->form->getValue('body'));
        $comment->setUserId( $this->user->getId());
        $comment->setActivityId($this->comment->getActivityId());
        $comment->save();
        
        $this->redirectUnless($request->isXmlHttpRequest(), $request->getReferer());
        
        $this->getUser()->setFlash('notice', 'Comment was succesfully added!');
        $this->comment = $comment;
        $this->setTemplate('show');
      }
    }
  }
}