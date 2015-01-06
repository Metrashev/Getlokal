<?php if ($static_page->getNode()->hasPrevSibling()): ?>
  <a href="<?php echo url_for('staticpage/up?id='.$static_page->getId()) ?>"
    title="Move Up"><?php echo image_tag('/sfDoctrinePlugin/images/desc.png') ?></a>
<?php endif ?>

<?php if ($static_page->getNode()->hasNextSibling()): ?>
  <a href="<?php echo url_for('staticpage/down?id='.$static_page->getId()) ?>"
    title="Move Down"><?php echo image_tag('/sfDoctrinePlugin/images/asc.png') ?></a>
<?php endif ?>
