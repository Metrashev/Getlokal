<div id="<?php echo $company->getId() ?>">
  <input type="hidden" name="get_weekend[companies_list][]" value="<?php echo $company->getId() ?>" />
  <?php echo image_tag($company->getThumb(), 'size=50x50 style=margin-right:10px;float:left') ?>
  <h3><?php echo $company ?></h3>
  <?php echo $company->getSector() ?>
  <a href="#" class="remove" onclick="$(this).parent().remove(); return false;">remove</a>
  
  <div class="clear"></div>
</div>