<div id="content">
  <div class="company event">
    <a href="getlokal://images" class="image">
      <img src="<?php echo image_path($event->getThumb(2)) ?>" />
    </a>
  
    <h1 class="title"><?php echo $event->getDisplayTitle() ?></h1>  
    
    <?php if($event->getFirstCompany()): ?>
    <div class="col">
      <div class="icon"><?php echo image_tag('mobile/location.png') ?></div>
      
      <div class="text">
        <?php echo $event->getFirstCompany() ?>
      </div>
      <div class="clear"></div>
    </div>
    <?php endif ?>
    
    <div class="col">
      <div class="icon"><?php echo image_tag('mobile/hours.png') ?></div>
      
      <div class="text">
        <?php echo $event->getDateTimeObject('start_at')->format('d / m /y') ?>
      </div>
      <div class="clear"></div>
    </div>
  
    <div class="details">
      <?php echo $event->getDisplayDescription(ESC_RAW) ?>
    </div>
    
    <div class="rspv">
      <a href="getlokal://status">
        <?php echo __('ATTEND') ?>
      </a>
      <div class="count">
        <?php echo __('%d participants', array('%d' => '<strong>'.$no_rspv.'</strong>')) ?>
        
      </div>
      <div class="clear"></div>
    </div>
    
  </div>
</div>