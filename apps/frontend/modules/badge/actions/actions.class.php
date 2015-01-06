<?php

class badgeActions extends sfActions 
{
  public function executeIndex()
  {
    $this->badges = Doctrine::getTable('Badge')
                      ->createQuery('b')
                      ->where('b.is_visible = ?', true)
                      ->execute();
  }
  
  public function executeUser(sfWebRequest $request)
  {
    $this->forward404Unless($this->user = Doctrine::getTable('UserProfile')->find($request->getParameter('id')));
    
    $this->badges = Doctrine::getTable('Badge')
                      ->createQuery('b')
                      ->leftJoin('b.UserBadge ub WITH ub.user_id = ?', $this->user->getId())
                      ->leftJoin('b.BadgeRequirement br')
                      ->leftJoin('br.BadgeRequirementField brf')
                      ->leftJoin('brf.UserStat us WITH us.user_id = ?', $this->user->getId())
                      ->where('b.is_visible = ?', true)
                      ->orderBy('ub.created_at DESC')
                      ->execute();
  }
  
  public function executeShow(sfWebRequest $request)
  {
    $this->forward404Unless($this->badge = Doctrine::getTable('Badge')->find($request->getParameter('id')));
    
    $query = Doctrine::getTable('UserBadge')
              ->createQuery('bu')
              ->innerJoin('bu.UserProfile p')
              ->innerJoin('p.City')
              ->where('bu.badge_id = ?', $this->badge->getId());
              
    $this->pager = new sfDoctrinePager('UserBadge', 20);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->setQuery($query);
    $this->pager->init();
  }
}  