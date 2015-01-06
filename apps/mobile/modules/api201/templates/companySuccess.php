<div id="content">
  <div class="company">
    <div class="image">
      <?php if(count($company->getCompanyImage())): ?>
      <a href="getlokal://images">
        <img src="<?php echo image_path($company->getThumb(3)) ?>" />
      </a>
      <a href="getlokal://map" class="map">
        <img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $company->getLocation()->getLatitude() ?>,<?php echo $company->getLocation()->getLongitude() ?>&zoom=15&size=400x400&maptype=roadmap&markers=icon:<?php echo image_path('gui/icons/marker_'. $company->getSectorId(), true) ?>%7Cshadow:false%7C<?php echo $company->getLocation()->getLatitude() ?>,<?php echo $company->getLocation()->getLongitude() ?>&sensor=false" class="map_image" />
      </a>
      <?php else: ?>
        <a href="getlokal://map">
          <img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $company->getLocation()->getLatitude() ?>,<?php echo $company->getLocation()->getLongitude() ?>&zoom=15&size=600x200&maptype=roadmap&markers=icon:<?php echo image_path('gui/icons/marker_'. $company->getSectorId(), true) ?>%7Cshadow:false%7C<?php echo $company->getLocation()->getLatitude() ?>,<?php echo $company->getLocation()->getLongitude() ?>&sensor=false" class="map_image" />
        </a>
      <?php endif ?>
    </div>
  
    <h1 class="title"><?php echo $company ?></h1>
    
    <div class="classification"><?php echo $company->getClassification() ?></div>
    <div class="about">  
      <div class="rating">
        <?php echo image_tag('mobile/starsBg.png') ?>
        <div class="fill" style="width: <?php echo $company->getRating() ?>%"><?php echo image_tag('mobile/stars.png') ?></div>
      </div>
      <div class="clear"></div>
    </div>
    
    <?php if($company->getPhone()): ?>
      <div class="phone">
        <a href="getlokal://call?<?php echo $company->getPhone() ?>"><?php echo __('Call') ?> <?php echo $company->getPhone() ?></a>
      </div>
    <?php endif ?>
    
    <div class="clear"></div>
  
  
    <?php if($company->getCompanyDetail()): ?>
    <div class="col">
      <div class="icon"><?php echo image_tag('mobile/hours.png') ?></div>
      
      <div class="text">
        <?php foreach($company->getCompanyDetail()->getWorkingHours() as $hour): ?>
          <?php echo $hour['time'] ?>  <span><?php echo __($hour['day']) ?></span><br/>
        <?php endforeach ?>
      </div>
      <div class="clear"></div>
    </div>
    <?php endif ?>
      
    <?php if($company->getDisplayAddress()): ?>
    <div class="col">
      <div class="icon"><?php echo image_tag('mobile/location.png') ?></div>
      <div class="text"><?php echo __('Address') ?> <span><?php echo $company->getDisplayAddress(); ?></span></div>
      <div class="clear"></div>
    </div>
    <?php endif ?>
    
    <div class="rspv company">
      <a href="getlokal://review" id="addReview">
        <?php echo image_tag('mobile/iconReview.png') ?>
        <?php echo __('Review') ?>
      </a>
      <a href="getlokal://takephoto" id="addPhoto">
        <?php echo image_tag('mobile/iconImage.png') ?>
        <?php echo __('Add Pic') ?>
      </a>
      <a href="getlokal://favorite" onclick="toggleFavorite()">
        <?php echo image_tag('mobile/iconBookmark'.($is_favorite?'ON':'').'.png', 'id=addFavorite') ?>
        <?php echo __('Fave') ?>
      </a>
      <a href="getlokal://checkin" id="checkin">
        <?php echo image_tag('mobile/iconCheckin.png') ?>
        <?php echo __('Check-in') ?>
      </a>
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
    
    <?php if(count($reviews)): ?>
      <div class="reviews">
        <h2><?php echo __('Reviews') ?></h2>
        
        <?php foreach($reviews as $review): ?>
          <div class="review">
            <div class="date">
              <span><?php echo $review->getDateTimeObject('created_at')->format('d.m.Y') ?></span>
              <div class="rating">
                <?php echo image_tag('mobile/starsBg.png') ?>
                <div class="fill" style="width: <?php echo $review->getRatingProc() ?>%"><?php echo image_tag('mobile/stars.png') ?></div>
              </div>
              <div class="clear"></div>
            </div>
            <div class="content">
              <strong><?php echo $review->getUserProfile() ?>:</strong>
              <?php echo $review->getText(ESC_RAW) ?></div>
          </div>
        <?php endforeach ?>
      </div>
    <?php endif ?>
  </div>
</div>

<script type="text/javascript">
var toggleFavorite = function() {
  var element = document.getElementById('addFavorite');
  
  if(element.getAttribute("src").indexOf('ON') != -1)
  {
    element.src = element.src.replace('ON', '');
    return;
  }
  
  element.src = element.src.replace('.png', 'ON.png');
}
</script>