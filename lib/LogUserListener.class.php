<?php

class LogUserListener {
	static public function listenToWriteLog(sfEvent $event) {
		$msg = $event->getSubject ();
		if ($msg ['user'] instanceof PageAdmin) {			
			$email = $msg ['user']->getUserProfile ()->getsfGuardUser ()->getEmailAddress ();
		} elseif ($msg ['user'] instanceof sfGuardUser) {			
			$email = $msg ['user']->getEmailAddress ();
		} elseif ($msg ['user'] instanceof UserProfile) {			
			$email = $msg ['user']->getsfGuardUser()->getEmailAddress ();
		} else {
			$email = $msg ['user'];
		}
		if (!isset($msg ['object_id']))
		{
			$msg ['object_id'] = $msg ['user']->getId();
		}
		$log = new ActivityLogUser ();
		$log->setObject ( $msg ['object'] );
		$log->setAction ( $msg ['action'] );
		$log->setIpAddress ( $_SERVER ['REMOTE_ADDR'] );		
		$log->setEmailAddress ( $email );
		$log->setObjectId($msg ['object_id']); 
		$log->setCreatedAt ( date ( 'Y-m-d H:i:s' ) );
		$log->save ();
	}
}
?>