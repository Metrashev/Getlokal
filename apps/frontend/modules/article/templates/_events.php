<?php 
foreach ($articleEvents as $articleEvent){
	include_partial('global/tag', array('id' => $articleEvent->getId(), 'text' => $articleEvent->getEvent()->getTitle()));
}
?>