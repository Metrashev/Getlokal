<?php

class getweekendActions extends sfActions 
{
  public function executeIndex()
  {
    $item = Doctrine::getTable('getWeekend')
                      ->createQuery('g')
                      ->limit(1)
                      ->where('g.country_id = ?', sfContext::getInstance()->getUser()->getCountry()->getId())
                      ->orderBy('g.aired_on DESC')
                      ->fetchOne();
                      
    $this->forward404Unless($item);
                      
    $this->redirect('getweekend/show?id='. $item->getId());
  }
  
  public function executeShow(sfWebRequest $request)
  {
    breadCrumb::getInstance()->removeRoot();  
    $this->forward404Unless($this->item = Doctrine::getTable('getWeekend')->find($request->getParameter('id')));
    
    $this->others = Doctrine::getTable('getWeekend')
                      ->createQuery('g')
                      ->where('g.id != ?', $this->item->getId())
                      //->limit(9)
                      ->andWhere('g.country_id = ?', sfContext::getInstance()->getUser()->getCountry()->getId())
                      ->orderBy('g.aired_on DESC')
                      ->execute();
                      
    $this->url = $this->generateUrl('default', array(
      'module' => 'getweekend',
      'action' => 'show',
      'id'     => $this->item->getId()
    ), true);
  }
}