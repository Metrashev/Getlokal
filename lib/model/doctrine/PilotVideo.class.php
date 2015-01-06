<?php

/**
 * PilotVideo
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class PilotVideo extends BasePilotVideo
{
  public function canVote() {
    $user_id = sfContext::getInstance()->getUser()->getId();
    $votes = Doctrine::getTable('PilotVote')->createQuery('v')
    ->addWhere('v.video_id = ?', $this->getId())
    ->addWhere('v.user_id = ?', $user_id)
    ->addWhere('DATE(v.created_at) = ?', date('Y-m-d'))
    ->execute();
    
    if ($votes->count()) {
      return false;
    }
    return true;
  }

  /**
   * checks if user has voted a specific video
   */
  public function hasVotedToday() {
    $user_id = sfContext::getInstance()->getUser()->getId();
    $votes = Doctrine::getTable('PilotVote')->createQuery('v')
    ->addWhere('v.user_id = ?', $user_id)
    ->addWhere('DATE(v.created_at) = ?', date('Y-m-d'))
    ->execute();
    
    if ($votes->count()) {
      return true;
    }
    return false;
  }
}
