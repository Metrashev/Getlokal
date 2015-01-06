<?php //echo image_tag($review->getUserProfile()->getThumb()) ?>
<?php if ($event->getThumb(2)):?>
      <?php echo image_tag($event->getThumb(2), 'size=180x135 alt_title='.$event->getDisplayTitle()) ?>
    <?php else: ?>  
      <?php echo image_tag('gui/default_event_'.$event->getCategory()->getId().'.jpg', 'size=180x135 alt_title='.$event->getDisplayTitle()) ?>
    <?php endif;?>