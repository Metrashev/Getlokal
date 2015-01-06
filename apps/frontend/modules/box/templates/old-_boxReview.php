<?php if($review): ?>
<div>
<?php if ( isset($sector) ):?>

	<?php if ( ($sf_user->getCulture()=='bg' ) && (substr($sf_user->getCity()->getLocation(),0,2 )=='В' || substr($sf_user->getCity()->getLocation(),0,2 )=='Ф' ) ):?>
		<h2><?php echo __('Top Review for %sector% in %city%', array('%sector%' => $sector->getTitle(), '%city%' => $sf_user->getCity()->getLocation() ), 'exception') ?></h2>
	<?php else:?>
<!-- FOR FI TESTING COUNTY  -->
	    <?php if ($county): ?>
	        <h2><?php echo __('Top Review for %sector% in %county%', array('%sector%' => $sector->getTitle(), '%county%' => $sf_user->getCounty()->getLocation() )) ?></h2>
	    <?php  else: ?>
		    <h2><?php echo __('Top Review for %sector% in %city%', array('%sector%' => $sector->getTitle(), '%city%' => $sf_user->getCity()->getDisplayCity() )) ?></h2>
		<?php endif; ?>
<!-- <h2><?php echo __('Top Review for %sector% in %city%', array('%sector%' => $sector->getTitle(), '%city%' => $sf_user->getCity()->getDisplayCity() )) ?></h2> -->
	<?php endif;?>
<?php else :?>
<!-- FOR FI TESTING COUNTY  -->
	    <?php if ($county): ?>
	        <h2><?php echo __('Top Review for %city%', array('%city%' => $sf_user->getCounty()->getLocation())) ?></h2>
	    <?php  else: ?>
		    <h2><?php echo __('Top Review for %city%', array('%city%' => $sf_user->getCity()->getLocation())) ?></h2>
		<?php endif; ?>
  
<!-- 	<h2><?php echo __('Top Review for %city%', array('%city%' => $sf_user->getCity()->getLocation())) ?></h2> -->
<?php endif;?>
    <div class="hp_review top">
      <div class="review_content">
        <h3><?php echo link_to($review->getCompany()->getCompanyTitle(), $review->getCompany()->getUri(ESC_RAW), array('title' => $review->getCompany()->getCompanyTitle())) ?></h3>
        <div class="review_rateing">
          <div class="rateing_stars">
            <div class="rateing_stars_orange" style="width: <?php echo $review->getRatingProc() ?>%;"></div>
          </div>
          <span class=""><?php echo format_number_choice('[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $review->getCompany()->getNumberOfReviews()), $review->getCompany()->getNumberOfReviews()); ?></span>
        </div>

        <a title="<?php echo $review->getCompany()->getClassification() ?>" href="<?php echo url_for($review->getCompany()->getClassificationUri(ESC_RAW)) ?>" class="category"><?php echo $review->getCompany()->getClassification() ?></a>

        <p><?php echo truncate_text($review->getText(), 100, '...', true);?></p>
        <?php /* <a href="#"><?php echo __('Full Review...', null, 'messages') ?></a>  */ ?>
      </div>

      <div class="user_info">
        <?php echo $review->getUserProfile()->getLink(0, 'size=80x80', 'class=image', ESC_RAW) ?>

        <h3><?php echo $review->getUserProfile()->getLink(ESC_RAW) ?></h3>

        <?php //echo $review->getUserProfile()->getCity()->getLocation() ?>
      </div>


      <div class="clear"></div>
    </div>
</div>
  <?php endif ?>
