<?php

class likeActions extends sfActions 
{
  public function executeSave(sfWebRequest $request)
  {
    $referer = $request->getReferer();

    $query = Doctrine::getTable('Activity')
              ->createQuery('a')
              ->leftJoin('a.UserLike l WITH l.user_id = ?', $this->getUser()->getId())
              ->where('a.id = ?', $request->getParameter('id'));

    $this->forward404Unless($this->activity = $query->fetchOne());

    if (!isset($referer) || empty($referer)) {
        $company = Doctrine::getTable('company')->find($this->activity->getPage()->getForeignId());
        $culture = $request->getParameter('sf_culture');

        $referer = $this->generateUrl('company', array('module' => 'company', 'action' => 'show', 'sf_culture' => $culture, 'city' => $company->getCity()->getSlug(), 'slug' => $company->getSlug()));
    }

    $like_ids = (array) $this->getUser()->getAttribute('likes', array());
    
    if(in_array($this->activity->getId(), $like_ids)) 
    {
      $this->redirectUnless($request->isXmlHttpRequest(), $referer);
      
      return sfView::SUCCESS;
    }
    
    $query = Doctrine::getTable('Like')
            ->createQuery('l')
            ->where('l.user_id = ?', $this->getUser()->getId())
            ->andWhere('l.activity_id = ?', $this->activity->getId());
            
    if($query->count()) 
    {
      $this->redirectUnless($request->isXmlHttpRequest(), $referer);
      
      return sfView::SUCCESS;
    }
    
    $like = new Like();
    $like->setUserId($this->getUser()->getId());
    $like->setActivityId($this->activity->getId());
    $like->save();
    
    $like_ids[] = $this->activity->getId();
    
    $this->getUser()->setAttribute('likes', $like_ids);
    
    $this->redirectUnless($request->isXmlHttpRequest(), $referer);
  }
}