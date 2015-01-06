<?php
  $first = $events[0];
  $eventLink = 'event/show?id=';
?>
<div class="image">
  <div class="img">
    <?php echo link_to(image_tag($first->getThumb(2)), $eventLink . $first->getId(), array(
      'target' => '_blank'
    )) ?>
  </div>
  <div class="desc">
    <h1><?php echo link_to(truncate_text($first->getTitle()), $eventLink . $first->getId(), array(
      'target' => '_blank'
    )); ?></h1>
    <p><?php echo truncate_text(strip_tags($first->getDescription(ESC_RAW)), 50) ?></p>
  </div>
</div>
<ul class="list">
  <?php for ($i = 1; $i < count($events); $i++): ?>
    <?php $event = $events[$i]; ?>
    <li>
      <div class="image">
        <?php echo link_to(image_tag($event->getThumb()), $eventLink . $event->getId(), array(
          'target' => '_blank'
        )) ?>
      </div>
      <div class="title"><?php echo link_to(truncate_text($event->getTitle()), $eventLink . $event->getId(), array(
        'target' => '_blank'
      )) ?></div>
      <div class="date"><?php echo __(sprintf('UNTIL %s', $event->getDateTimeObject('start_at')->format('d.m.Y'))) ?></div>
      <div class="location"><?php echo $event->getFirstCompany(); ?></div>
      <div class="clear"></div>
    </li>
  <?php endfor ?>
</ul>
