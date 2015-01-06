<?php if($company->getImage()): ?>
  <?php echo image_tag($company->getImage()->getThumb(), 'width=60 style=float: left; padding: 0 10px 10px 0') ?>
<?php endif ?>