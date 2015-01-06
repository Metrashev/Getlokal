<div class="content_in_full">
  <ul class="badges">
    <?php foreach($badges as $badge): ?>
      <li>
        <?php echo link_to(image_tag($badge->getFile('active_image')->getUrl(), 'class=image size=75x75'), 'badge/show?id='. $badge->getId()) ?>

        <div class="badge_content">
          <h3><?php echo $badge->getName() ?></h3>
          <p><?php echo sprintf( __('Badge unlocked by <span> %s%s </span> of users'),$badge->getPercent(),'%' ) ?></p>

          <span class="description"><?php echo $badge->getDescription() ?></span>

          <div class="tooltip_body"><?php echo $badge->getLongDescription() ?></div>
        </div>
        <div class="clear"></div>
      </li>
    <?php endforeach ?>
  </ul>
<div class="clear"></div>
</div>