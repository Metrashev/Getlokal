
  <ul class="badges">
    <?php foreach($badges as $badge): ?>
      <li>
        <?php if(count($badge->getUserBadge())): ?>
          <?php echo link_to(image_tag($badge->getFile('active_image')->getUrl(), 'class=image size=75x75'), 'badge/show?id='. $badge->getId()) ?>
          
          <div class="badge_content tooltip">
            <h3><?php echo $badge->getName() ?></h3>
            <p>Won at: <span><?php echo $badge->getUserBadge()->getFirst()->getDateTimeObject('created_at')->format('d.m.Y') ?></span> </p>
            
            <span class="description"><?php echo $badge->getDescription() ?></span>
            
            <div class="tooltip_body"><?php echo $badge->getLongDescription() ?></div>
          </div>
        <?php else: ?>
          <?php echo link_to(image_tag($badge->getFile('inactive_image')->getUrl(), 'class=image size=75x75'), 'badge/show?id='. $badge->getId()) ?>
          
          <div class="badge_content tooltip">
            <h3><?php echo $badge->getName() ?></h3>
            
            <p>
              <?php echo $badge->getProgress() ?>
            </p>
            
            <span class="description"><?php echo $badge->getDescription() ?></span>
            
            <div class="tooltip_body"><?php echo $badge->getLongDescription() ?></div>
          </div>
        <?php endif ?>
        
        
        <div class="clear"></div>
      </li>
    <?php endforeach ?>
  </ul>

<div class="clear"></div>