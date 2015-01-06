<?php include_partial('review/reviewJs');?>
<div class="standard_tabs_bar"></div>
<?php include_component('comment', 'comments', array('activity' => $event->getActivityEvent(),'user'=>$user, 'url'=>url_for('event/comments?event_id='. $event->getId() ))) ?>