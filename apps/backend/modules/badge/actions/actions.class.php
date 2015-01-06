<?php

require_once dirname(__FILE__).'/../lib/badgeGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/badgeGeneratorHelper.class.php';

/**
 * badge actions.
 *
 * @package    getLokal
 * @subpackage badge
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class badgeActions extends autoBadgeActions
{
  public function executeRequirements(sfWebRequest $request)
  {
    $this->forward404Unless($this->badge = Doctrine::getTable('Badge')->find($request->getParameter('id')));
    
    $this->requirements = $this->badge->getBadgeRequirement();
    
    $this->choices = array();
    $groups = Doctrine::getTable('UserStatKey')
                ->createQuery('s')
                ->groupBy('s.type')
                ->fetchArray();
    foreach($groups as $group)
    {
      $this->choices[$group['type']] = Doctrine::getTable('UserStatKey')
        ->createQuery('u')
        ->where('u.type = ?', $group['type'])
        ->execute();
    }
    
    $this->form = new BaseForm();
    $this->form->getWidgetSchema()->setNameFormat('requirements[%s]');
    
    foreach($this->requirements as $i=>$item)
    {
      $this->form->embedForm($i, new BadgeRequirementForm($item));
    }
    
    $this->form->embedForm('new', new BadgeRequirementForm());
    
    if($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter($this->form->getName()));
      
      if($this->form->isValid())
      {
        $values = $this->form->getValues();
        
        Doctrine::getTable('BadgeRequirement')->createQuery('r')->where('r.badge_id = ?', $this->badge->getId())->delete()->execute();
        
        foreach($values as $val)
        {
          if(!$val['key']) continue;
          
          $br = new BadgeRequirement();
          $br->fromArray($val);
          $br->setBadgeId($this->badge->getId());
          $br->save();
          
          foreach($val['key'] as $key)
          {
            $brf = new BadgeRequirementField();
            $brf->setKey($key);
            $brf->setRequirementId($br->getId());
            $brf->save();
          }
        }
        
        $requirements = Doctrine::getTable('BadgeRequirement')->createQuery('r')->where('r.badge_id = ?', $this->badge->getId())->groupBy('group_no')->count();
        $this->badge->setRequirements($requirements);
        $this->badge->save();
        
        $this->redirect('badge/requirements?id='. $this->badge->getId());
      }
    }
  }
  public function executeNew(sfWebRequest $request)
  {
      
  }
}
