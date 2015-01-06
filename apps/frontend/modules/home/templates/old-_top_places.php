 <div class="hp_2columns">
    <!--Articles-->
    <?php if ( ($sf_user->getCulture()=='bg' ) && (substr($sf_user->getCity()->getLocation(),0,2 )=='В' || substr($sf_user->getCity()->getLocation(),0,2 )=='Ф' ) ):?>
			<h2><?php echo __('Recommended for %sector% in  %city%', array('%sector%' => $sector->getTitle() ,'%city%' => $sf_user->getCity()->getLocation()), 'exception') ?></h2>
	<?php else:?>
	  <?php if ($county): ?>
        <h2><?php echo __('Recommended for %sector% in  %city%', array('%sector%' => $sector->getTitle() ,'%city%' => $sf_user->getCounty()->getLocation())) ?></h2>
      <?php else: ?>
        <h2><?php echo __('Recommended for %sector% in  %city%', array('%sector%' => $sector->getTitle() ,'%city%' => $sf_user->getCity()->getDisplayCity())) ?></h2>
	  <?php endif; ?>    	
    <?php endif;?>
    <div class="hp_2columns_center">    
      <?php foreach($topLocations as $i => $location): ?>
        <div class="short">
          <?php echo link_to(image_tag($location->getThumb(1), 'size=45x45 alt=' . $location->getCompanyTitle()), $location->getUri(ESC_RAW), array('title' => $location->getCompanyTitle())) ?>
          <h3><?php echo link_to($location->getCompanyTitle(), $location->getUri(ESC_RAW), array('title' => $location->getCompanyTitle())) ?></h3>
          <div class="review_rateing">
            <div class="rateing_stars">
              <div class="rateing_stars_orange" style="width: <?php echo $location->getRating() ?>%;"></div>
            </div>
            <span class=""><?php echo format_number_choice('[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $location->getNumberOfReviews()), $location->getNumberOfReviews()); ?></span>
          </div>
        </div>
        <?php if($i == 3): ?>
          </div>
          <div class="hp_2columns_right">
        <?php endif ?>
      <?php endforeach ?>
    </div>
    
    <div class="clear"></div>
  </div>