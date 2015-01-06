<?php

class NotifyListener {

	static public function listenToWriteMessage(sfEvent $event)
  {
    $msg = $event->getSubject();   
    $notify = new Notification;
    $notify->notifyMessage($msg);

  }
  
static public function listenToFollow(sfEvent $event)
  {
    $follow = $event->getSubject();
    $notify = new Notification;
    $notify->notifyFollowPage($follow);
  } 
  
  static public function listenToWonBadge(sfEvent $event)
  {
    $badge = $event->getSubject();
    $notify = new Notification;
    $notify->notifyBadge($badge);
  } 
}
?>