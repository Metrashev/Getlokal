<?php

/**
 * Activity
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Activity extends BaseActivity
{
  public function setUp()
  {
    parent::setUp();
    
    $this->hasOne('Like as UserLike', array(
             'local' => 'id',
             'foreign' => 'activity_id'));
  }
  
  public function getTotalLikes()
  {
    return (int) $this->getVotesCount() + $this->getAnonymousVotesCount();
  }
}