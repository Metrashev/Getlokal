<?php if (count($reviews) >0 ):?>
<div class="hp_block">
<?php if ( isset($sector) ):?>
  	<?php if ( ($sf_user->getCulture()=='bg' ) && (substr($sf_user->getCity()->getLocation(),0,2 )=='В' || substr($sf_user->getCity()->getLocation(),0,2 )=='Ф' ) ):?>
		<h2><?php echo __('Top Reviews for %sector% in %city%', array('%sector%'=>$sector->getTitle(), '%city%' => $sf_user->getCity()->getLocation() ), 'exception') ?></h2>
	<?php else:?>
	    <?php if ($county): ?>
	        <h2><?php echo __('Top Reviews for %sector% in %city%', array('%sector%'=>$sector->getTitle(),'%city%' => $sf_user->getCounty()->getLocation())) ?></h2>
	    <?php  else: ?>
  		    <h2><?php echo __('Top Reviews for %sector% in %city%', array('%sector%'=>$sector->getTitle(),'%city%' => $sf_user->getCity()->getDisplayCity())) ?></h2>
  		<?php endif; ?>
	<?php endif;?>
<?php else :?>
        <?php if ($county): ?>
	        <h2><?php echo __('Top Reviews for %city%', array('%city%' => $sf_user->getCounty()->getLocation())) ?></h2>
	    <?php  else: ?>
  		    <h2><?php echo __('Top Reviews for %city%', array('%city%' => $sf_user->getCity()->getLocation())) ?></h2>
  		<?php endif; ?>  		
<?php endif;?>  
  <div class="hp_reviews_wrap">
    <?php foreach($reviews as $review): ?>
      <div class="hp_review">
        <h3><?php echo link_to($review->getCompany()->getCompanyTitle(), $review->getCompany()->getUri(ESC_RAW), array('title' => $review->getCompany()->getCompanyTitle())) ?></h3>
        <div class="review_rateing">
          <div class="rateing_stars">
            <div class="rateing_stars_orange" style="width: <?php echo $review->getRatingProc() ?>%;"></div>
          </div>
          <span class=""><?php echo format_number_choice('[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $review->getCompany()->getNumberOfReviews()), $review->getCompany()->getNumberOfReviews()); ?></span>
        </div>
        
        <a title="<?php echo $review->getCompany()->getClassification() ?>" href="<?php echo url_for($review->getCompany()->getClassificationUri(ESC_RAW)) ?>" class="category"><?php echo $review->getCompany()->getClassification() ?></a>

        <p><?php echo truncate_text($review->getText(), 100, '...', true);?></p>
        
        <div class="user_info">
          <?php echo $review->getUserProfile()->getLink(1, 'size=45x45', 'class=image', ESC_RAW) ?>
          
          <h3><?php echo $review->getUserProfile()->getLink(ESC_RAW) ?></h3>
          
          <?php //echo $review->getUserProfile()->getCity()->getLocation() ?>
        </div>

        
        <div class="clear"></div>
      </div>
    <?php endforeach ?>
    <div class="clear"></div>
  </div>
  
  <div class="clear"></div>
</div>
<?php endif;?>