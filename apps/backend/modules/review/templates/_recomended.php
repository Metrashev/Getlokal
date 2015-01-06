<?php if($review->recommended_at): ?>
  <strong>Marked as top review</strong> on <?php echo $review->getDateTimeObject('recommended_at')->format('M d Y H:i') ?> - 
<?php endif ?>
