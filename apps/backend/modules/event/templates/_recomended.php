<?php if($event->recommended_at): ?>
  <strong>Marked as recommended</strong> on <?php echo $event->getDateTimeObject('recommended_at')->format('M d Y H:i') ?> - 
<?php endif ?>
