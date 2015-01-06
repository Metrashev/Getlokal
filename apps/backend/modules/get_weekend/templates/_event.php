<div id="<?php echo $event->getId() ?>">
  <input type="hidden" name="get_weekend[events_list][]" value="<?php echo $event->getId() ?>" />
  <?php echo image_tag($event->getThumb(), 'size=50x50 style=margin-right:10px;float:left') ?>
  <h3><?php echo $event ?></h3>
  <?php echo $event->getCategory() ?>
  <a  class="remove" onclick="$(this).parent().remove(); return false;">remove</a>
  
  <div class="clear"></div>
</div>