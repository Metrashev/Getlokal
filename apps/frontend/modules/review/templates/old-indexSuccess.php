<?php
	use_helper('Date');
	use_helper('TimeStamps');
	use_helper('Pagination');
	use_javascript('review.js');
	use_stylesheet('jquery.rating.css');
	use_javascript('flipclock.js');
	use_stylesheet('flipclock.css');
	include_partial('review/reviewJs');
	slot('no_map', true);
	slot('no_ads', true);

    if($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG){
        $className = "summer-getlokal";
        $prize = 'Write and win: Samsung S4 or Getaway for two';
        $endDate = '2014-08-15';
    }elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO) {
        $className = "summer-getlokal ro-background";
        $prize = "Write and win: 1 x HTC Desire 610 or 2 x HTC Battery Bar";
        $endDate = '2014-08-28';
    }
?>
    <div class="<?php echo $className;?>">
        <h1><?php echo __('Getlokal is celebrating'); ?> <strong><?php echo __('the SUMMER!'); ?></strong></h1>
         <span><?php echo __($prize); ?></span>
         <h2><?php echo __('1 review  = 1 chance to win'); ?></h2>
    </div><!-- summer-getlokal -->

    <div class="green-summer-placeholder">
        <span><?php echo __('Find your favourite places,'); ?> <br> <?php echo __('write a review, win a prize!'); ?></span>
    </div><!-- green-summer-placeholder -->

    <div class="search-cyan">
        <h3><?php echo __('Search by keyword or by category:'); ?></h3>
        <ul class="category_menu">
            <?php foreach ($classifications as $classification): ?>
                <li class="category_<?php echo $classification->getSectorId() ?>">
                    <?php echo link_to($classification, '@classification?slug=' . $classification->getSlug() . '&sector=' . $classification->getPrimarySector()->getSlug() . '&city=' . $sf_user->getCity()->getSlug(), array('title' => $classification, 'target' => '_blank')) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="reviews-warning">
        <span><?php echo __('* Important: Duplicated or uncensored reviews will be deleted'); ?></span>
    </div><!-- reviews-warning -->

<div class="content_in">
	<h2 class="last-reviews"><?php echo __('Latest written reviews'); ?></h2>
	<?php
		$reviews = $pager->getResults();
		$reviewscount = $pager->getNbResults();
		$i18n=$sf_user->getCulture();
	?>
	<div class="review_list_wrap">
		<?php 
			if ($reviewscount > 0): 
				foreach ($reviews as $review): ?>

				
					<?php
					$review_user = $review->getUserProfile();
					$culture = $sf_user->getCulture();
					?>
					<div class="review review_list_company"	id="review-<?php echo $review->getId() ?>">
						<span class="review_date"><?php echo ezDate(date('d.m.Y H:i', strtotime($review->getCreatedAt())));?></span>
						<span class="user"><?php echo $review->getUserProfile()->getLink(ESC_RAW) ?></span>
					
						<?php /*if(!isset($review_user)): */?>
						<h2><?php echo link_to($review->getCompany()->getCompanyTitle(), $review->getCompany()->getUri(ESC_RAW)) ?></h2>
						<?php echo link_to($review->getCompany()->getClassification(), $review->getCompany()->getClassificationUri(ESC_RAW), 'class=category') ?>
						<?php /* endif; */?> 
					
						<?php //if(isset($review_user)): ?> 
						<?php echo $review_user->getLink(0, 'size=100x100', 'class=review_list_img', ESC_RAW) ?>
						<?php /*else: ?> 
							<a	href="<?php echo url_for( $review->getCompany()->getUri(ESC_RAW)) ?>" class="review_list_img"> <?php echo image_tag($review->getCompany()->getThumb(0), 'size=100x100') ?></a> 
						<?php endif */?>
					
						<div class="review_content">
							<div class="review_rateing">
								<div class="rateing_stars">
									<div class="rateing_stars_pink" style="width: <?php echo $review->getRatingProc() ?>%;"></div>
								</div>
								<span><?php echo $review->getRating() ?> / 5</span>
							</div>
							<p><?php echo simple_format_text($review->getText()) ?></p>
						</div>
					
						<div class="review_interaction">
							<?php include_partial('like/like', array('object' => $review->getActivityReview())) ?>
							 <?php if($review->recommended_at):?>
							 <span class="review_list_top_review"><?php echo __('Top Review')?></span>
							 <?php endif;?>
							<?php if(!$user || ($review->getUserId() != $user->getId())): ?> 
							<a  id="<?php echo $review->getId()?>"
								href="javascript:void(0);" 
								data="<?php echo url_for('report/review?id='.$review->getId()) ?>"
								class="report"><?php echo __('report')?></a> <?php endif ?> 
								<?php if($user && $user->getIsPageAdmin($review->getCompany()) && $user->getId() != $review->getUserId()):?>
							<a  href="javascript:void(0);" 
								data="<?php echo url_for('review/reply?review_id='.$review->getId())?>"
								class="reply"><?php echo __('reply')?></a> 
								<?php endif;?> 
								<?php if(!isset($review_user) && $user && $user->getId() == $review->getUserId() && !$review->getAnswers()): ?>
								<?php echo link_to(__('delete'), 'profile/deleteReview?review_id='. $review->getId(), array('confirm'=> __('Confirm deletion'), 'class'=>'delete')); ?>
								<?php elseif (isset($review_user) && $user && $user->getId() == $review->getUserId() && !$review->getAnswers()):?>
								<?php echo link_to(__('delete'), 'company/deleteReview?review_id='. $review->getId().'&company_id='.$review->getCompanyId(), array('confirm'=> __('Confirm deletion'), 'class'=>'delete')); ?>
								<?php endif;?> 
							
							<?php if($user && $user->getId() == $review->getUserId() && !$review->getAnswers() && $review->getActivityReview()->getTotalLikes()==0 ):?> <a
								href="javascript:void(0);" 
								data="<?php echo url_for('review/edit?review_id='. $review->getId())?>"
								class="edit"><?php echo __('edit')?></a> <?php endif;?>
						</div>
					<div class="ajax"></div>
					</div>
			<?php 		//include_partial('review/review', array('review'=>$review, 'review_user' => $review->getUserProfile(), 'user'=>$user));
				endforeach;
			 	echo pager_navigation($pager, url_for('review/index'));
			endif;
		?>
	</div>
</div>


<div class="reviews-sidebar">
	<div class="sidebar" id="rightColumn" style="float: right;">
	  <?php include_component('box', 'boxVip2') ?>
	</div>
<div class="sidebar">
	
</div>

</div>
<div class="clear"></div>

<?php if ($sf_user->getCountry()->getSlug() == 'bg' || $sf_user->getCountry()->getSlug() == 'ro'): ?>
    <div class="prizes">
        <h4><?php echo __('Prizes'); ?></h4>
        <ul>
            <?php if ($sf_user->getCountry()->getSlug() == 'bg'): ?>
                <li>
                    <img src="../images/promo/summer-campaign/sc-image-01.png" alt="">
                    <span class="no-underline">
                        <?php echo __('Samsung Galaxy S4'); ?>
                    </span>
                    <p><?php echo __('5 inches super amoled display, 16 GB memory'); ?></p>
                </li>

                <li>
                    <a href="http://www.getlokal.com/bg/bansko/sv-ivan-rilski-hotel-spa-appartments">
                        <img src="../images/promo/summer-campaign/sc-image-03.png" alt="">
                        <span>
                            <?php echo __('3 х 1 nights for two'); ?>
                        </span>
                        <p><?php echo __('SPA St. Ivan Rilski, Bansko'); ?></p>
                    </a>
                </li>

                <li>
                    <a href="http://www.getlokal.com/bg/bansko/hotel-golden-rainbow">
                        <img src="../images/promo/summer-campaign/sc-image-02.png" alt="">
                        <span>
                            <?php echo __('Two nights for two'); ?>
                        </span>
                        <p><?php echo __('Rainbow Holiday Complex, Sunny Beach'); ?></p>
                    </a>
                </li>
            <?php elseif ($sf_user->getCountry()->getSlug() == 'ro'): ?>
                <li class="prize-ro no-border-radius margin-left-minus">
                    <a href="http://www.htc.com/ro/smartphones/htc-desire-610/">
                        <img src="../images/promo/summer-campaign/HTS-Desire.png" alt="">
                    </a>
                </li>

                <li class="no-border-radius">
                    <a href="http://www.htc.com/ro/accessories/htc-battery-bar/#/">
                        <img src="../images/promo/summer-campaign/HTC-Battery.png" alt="">
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        <div class="strong">
            <strong><?php echo __('Terms and conditions'); ?></strong>
        </div>
        <p class="clause">
            <?php echo __('By writing a review you agree with'); ?>
            <a href="<?php echo url_for('static_page', array('slug' => 'rules-summer-campaign')) ?>" target="_blank"><?php echo __('Terms and conditions of the current game.'); ?></a>
        </p>
    </div><!-- /.prizes -->

    <div class="top-of-the-clock">
        <h4><?php echo __('CAMPAIGN ended Aug 27th. Winners will be announced Monday, Sept 1st.'); ?></h4>
    </div>
    
<?php endif; ?>

<?php if ($sf_user->getCountry()->getSlug() == 'bg' || $sf_user->getCountry()->getSlug() == 'ro'): ?>
    <div class="prizes">
        <h4><?php echo __('Jury'); ?></h4>
        <ul>
            <?php if ($sf_user->getCountry()->getSlug() == 'bg'): ?>
            <li>
                <a href="http://www.getlokal.com/bg/page/our-team">
                    <?php echo image_tag('promo/summer-campaign/sc-image-04.png') ?>
                    <span>
                        <?php echo __('Getlokal team'); ?>
                    </span>
                    <p></p>
                </a>
            </li>

            <li>
                <a href="http://www.getlokal.com/bg/bansko/sv-ivan-rilski-hotel-spa-appartments">
                    <?php echo image_tag('promo/summer-campaign/sc-image-05.png') ?>
                    <span>
                        <?php echo __('Stefan Milanov'); ?>
                    </span>
                    <p><?php echo __('FPI Hotels & Resorts'); ?></p>
                </a>
            </li>

            <li>
                <a href="http://www.getlokal.com/bg/slanchev-bryag/hotel-golden-rainbow">
                    <?php echo image_tag('promo/summer-campaign/sc-image-06.png') ?>
                    <span>
                        <?php echo __('Ivanka Antonova'); ?>
                    </span>
                    <p><?php echo __('Rainbow Holiday Complex'); ?></p>
                </a>
            </li>

            <?php elseif ($sf_user->getCountry()->getSlug() == 'ro'): ?>
            <li class="margin-left-ro">
                <a href="http://www.getlokal.com/bg/page/our-team">
                    <?php echo image_tag('promo/summer-campaign/sc-image-04.png') ?>
                    <span>
                        <?php echo __('Getlokal team'); ?>
                    </span>
                    <p></p>
                </a>
            </li>
            <li>
                <a href="http://www.htc.com/ro">
                    <?php echo image_tag('promo/summer-campaign/htc.png') ?>
                    <span>
                        <?php echo __('HTC'); ?>
                    </span>
                    <p></p>
                </a>
            </li>

            <?php endif; ?>
        </ul>
        </div><!-- /.prizes -->

        <p class="clause">
            <?php echo __('Prizes will receive the best written reviews, based on the discretion of our jury, therefore we expect to read about your emotions and honest reviews about the places you have visited. Every member of the jury will choose one winner who will win the prize. The Getlokal team will choose 3 reviews, that will be the finalists for the prize Samsung Galaxy S4. The review which receives the most votes from our fans on <a href="https://www.facebook.com/getlokal">Facebook</a>, will win the prize.'); ?> 
        </p>
<?php endif; ?>
