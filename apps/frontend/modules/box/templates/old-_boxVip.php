<?php if(count($vips)): ?>
<div id="">
  <h2><?php echo __('VIPs', null, 'offer')?></h2>
  
  <div class="sidebar_block">
    <?php foreach($vips as $vip): ?>
      <div class="short">
        <?php echo link_to(image_tag($vip->getThumb(), array('size'=>'45x45', 'alt' => $vip->getCompanyTitle())), $vip->getUri(ESC_RAW), array('title' => "asd")) ?>
        <h3><?php echo link_to($vip->getCompanyTitle(), $vip->getUri(ESC_RAW), array('title' => $vip->getCompanyTitle())) ?></h3>
      </div>
    <?php endforeach ?>
  </div>
</div>
<?php endif ?>