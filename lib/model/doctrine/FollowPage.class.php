<?php

/**
 * FollowPage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class FollowPage extends BaseFollowPage
{
 public function postInsert($event)
  {
  	parent::postInsert($event);
    $activity = Doctrine::getTable('ActivityFollowPage')->getActivity($this->getId());
    $activity->setUserId($this->getUserId());
    $activity->setPageId($this->getPageId());
    $activity->save();
  }
  public function getMessagesCount()
  {
  	$messages_count = 0;
  	$coverstation = ConversationTable::getExistingConversation($this->getUserProfile()->getUserPage()->getId(),$this->getPageId());
   // $coverstation2 = ConversationTable::getExistingConversation($this->getPageId(),$this->getUserProfile()->getUserPage()->getId());
  
    
   if ($coverstation)
   {
   	 $messages_count  = Doctrine::getTable('Message')
   	 ->createQuery('m')
   	 ->where('m.conversation_id = ? ' , $coverstation->getId() )
   	 ->count();
   }
  
   
  return $messages_count;
  }

}