<?php use_helper('Date')?>
<h2><?php echo $feed->getTitle();?></h2>
<?php echo image_tag($feed->getImage()->getImage());?>
<ul>
  <?php foreach($feed->getItems() as $post): ?>
  <li>
    <?php echo format_date($post->getPubDate(), 'd/MM H:mm') ?> -
    <?php echo link_to($post->getTitle(), $post->getLink()) ?>
    <?php echo html_entity_decode($post->getDescription());?>
    by <?php echo $post->getAuthorName() ?>
  </li>
  <?php endforeach; ?>
</ul>