<?php if(count($events)): ?>
<div id="">
<?php if ($county): ?>
  <h2><?php echo sprintf(__('Events in %s', null,'events'),$sf_user->getCounty()->getLocation()); ?></h2>
<?php else: ?>
  <h2><?php echo sprintf(__('Events in %s', null,'events'),$sf_user->getCity()); ?></h2>
<?php endif; ?>  
  <div class="sidebar_block">
    <?php foreach($events as $event): ?>
      <div class="short">
        <?php echo link_to(image_tag($event->getThumb(1), array('alt' => $event->getDisplayTitle())), 'event/show?slug='. $event->getId(), array('title' => $event->getDisplayTitle())) ?>
    
        
        <h3><?php echo link_to($event->getDisplayTitle(), 'event/show?id='. $event->getId(), array('title' => $event->getDisplayTitle())) ?></h3>
        <a title="<?php echo $event->getCategory() ?>" href="<?php echo url_for('event/index?id='. $event->getCategoryId()) ?>" class="category"><?php echo $event->getCategory() ?></a>
      </div>
    <?php endforeach ?>
  </div>
</div>
<?php endif ?>
