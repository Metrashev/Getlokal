<?php 

	$eventData = array();
	$placeData = array();

	if(!empty($review)){
		$placeData = array(
			'review' => $review->getText(),
			'user' => $review->getUserProfile()->__toString(),
			'userImg' => $review->getUserProfile()->getThumb(0),
			'userUrl' => url_for($review->getUserProfile()->getUri(ESC_RAW)),
			'companyTitle' => $review->getCompany()->getCompanyTitle(),
			'companyUrl' => url_for($review->getCompany()->getUri(ESC_RAW)),
			'numberOfReviews' => $review->getCompany()->getNumberOfReviews(),
			'classification' => $review->getCompany()->getClassification()->getTitle(),
			'classificationUrl' => url_for($review->getCompany()->getClassificationUri(ESC_RAW)),
			'reviewRating' => $review->getRatingProc()
		);
	}

	if(!empty($event)){
		$event_company = $event->EventPage[0]->CompanyPage->Company;
		$event_company->City = $event->City;
		$eventData = array(
			'title' => $event->getDisplayTitle(),
	 		'description' => $event->getDisplayDescription(ESC_RAW),
	 		'image' => $event->getThumb(0),
	 		'link' => url_for('event/show?id='.$event->getId()),
			'place' => $event_company->getCompanyTitle(),
			'city' => $event_company->City,
			'start' => date('d / m / Y', strtotime($event->getStartAt())),
			'end' => $event->getEndAt() ? date('d / m / Y', strtotime($event->getEndAt())) : '',
			'start_h' => $event->getStartH() ? ' ' . date('G:i', strtotime($event->getStartH())) : '',
//  			'place' => $event->getFirstEventPage()->getCompanyPage()->getCompany()->getCompanyTitle(),
// 	 		'placeUrl' => url_for($event->getFirstEventPage()->getCompanyPage()->getCompany()->getUri(ESC_RAW)),
	 		'placeUrl' => url_for($event_company->getUri(ESC_RAW)),
	 		'category' => $event->getCategory()->getTitle(),
	 		'categoryLink' => url_for('event/index?id='. $event->getCategoryId()),
		);
	}

	include_partial('home/homeIndex', array('placeData' => $placeData, 'eventData' => $eventData));
	include_partial('global/search_form');  
?>


<div class="categories_wrapper home-z-index-fix">
	<div class="container">
	
		<div class="row">
			<div class="col-sm-3 hidden-sm">
				<?php
					$component = get_component('box','boxCategories');
					slot('side_categories');
					echo $component;
					end_slot();
					echo $component;
				?>
			</div>

			<div class="col-lg-9 col-md-9 col-sm-12">
				<?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
					<?php if((!substr_count(get_slot('sub_module'),'vip')) && !has_slot('no_ads')): ?>
					<div class="sponsored">
						<div class="head-title">
							<?php echo __('Sponsored'); ?>
						</div>
						<!-- head-title -->
	
						<div class="body-content">
							<?php include_partial('global/ads', array('type' => 'leader')) ?>
						</div>
						<!-- body-content -->
					</div>
					<!-- sponsored -->
					<?php endif; ?>
				<?php endif; ?>
				<div class="top-places">
					<div class="categories-title">
						<?php
							if(getlokalPartner::getInstanceDomain() == 78){
								echo __('Top Places in %county%', array('%county%' => '<span>'.$sf_user->getCounty().'</span>'));
							}else{
								echo __('Top Places in %city%', array('%city%' => '<span>'.$sf_user->getCity()->getDisplayCity().'</span>'));
							} 
						?>
					</div>
					<?php include_component('box', 'column', array('key' => 'home', 'column' => 1))?>						
					<div class="inner-sidebar-container">
						<?php include_partial('global/map')?>
					</div>
				</div><!-- top-places -->
			</div>
		</div>
	</div>
</div><!-- categories_wrapper -->
<?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
	<?php if((!substr_count(get_slot('sub_module'),'vip')) && !has_slot('no_ads')): ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="default-container">
					<h3 class="heading"><?php echo __('Sponsored'); ?></h3>
					<!-- END heading -->
					<div class="content">
						<?php include_partial('global/ads', array('type' => 'branding')) ?>
					</div>
					<!-- END content -->
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
<?php endif; ?>

<div class="events_wrapper">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<?php include_component('event', 'sliderEvents', array('city' => $sf_user->getCity()->getDisplayCity()))?>						
			</div>
		</div>
	</div>
</div><!-- events_wrapper -->

<?php include_component('box', 'boxOffers'); ?>

<div class="section-get-mobile">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="gl-icon pull-left"></div>
				<p class="txt"><?php echo __('Install'); ?> <?php echo __('Getlokal app'); ?></p>			
				<a href="https://itunes.apple.com/ro/app/getlokal/id563521118?mt=8" class="store-btn appstore alignright"></a>
				<a href="https://play.google.com/store/apps/details?id=com.getLokal" class="store-btn googleplay alignright"></a>
			</div>
		</div>
	</div>
</div><!-- section-get-mobile -->

<div class="testimonials_wrapper">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-8 col-lg-8">
				<?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
					<?php if((!substr_count(get_slot('sub_module'),'vip')) && !has_slot('no_ads')): ?>
					<div class="sponsored">
						<div class="head-title">
							<?php echo __('Sponsored'); ?>
						</div>
						<!-- head-title -->
	
						<div class="body-content">
							<?php include_partial('global/ads', array('type' => 'leader')) ?>
						</div>
						<!-- body-content -->
					</div>
					<!-- sponsored -->
					<?php endif; ?>
				<?php endif; ?>

					<div id="fb-root"></div>
					<div class="section-socials">
						<div class="head-title">
							<?php echo __('SOCIAL', null, 'company'); ?>
						</div>
						<!-- head-title -->
	
						<div class="body-content">
							<div class="facebook-socials alignleft">
								<div class="facebook-arrow alignleft">
									<img src="/../css/images/temp/fb-arrow.png" alt="">
								</div>
								<div class="fb-info alignleft">
									<div class="txt">
										<?php echo __("LIKE AND SHARE US ON <span>FACEBOOK</span>", null, 'form'); ?>
									</div>
									<div class="fb-widget">
										<?php include_component('home','social_sidebar'); ?>
									</div>
								</div>
							</div>
							<img src="/../css/images/temp/finger-up.png" class="alignright"
								alt="">
						</div>
						<!-- body-content -->
					</div>
					<!-- socias -->
	
				</div>
				<!-- col-sm-8 -->

			<div class="col-sm-6 col-md-4 col-lg-4">
					<?php 
						if ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->getUserProfile()->getFollowedPages(true)){
                        	if(!has_slot('no_feed')){
                          		include_component('home', 'feed', array('page' => (isset($page)? $page : 1), 'user'=> $sf_user->getGuardUser()));
                          	}
						} else{
							if($sf_user->getCulture() == 'bg'){
								echo link_to(image_tag('gui/activity_bg.jpg'), 'contact/getlokal');
							} else{
								echo link_to(image_tag('gui/activity_en.jpg'), 'contact/getlokal');
							}
						}
					?>
					
			</div><!-- col-sm-4 -->
		</div>
	</div>
</div><!-- testimonials_wrapper -->

<script type='text/javascript'>
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
var gads = document.createElement('script');
gads.async = true;
gads.type = 'text/javascript';
var useSSL = 'https:' == document.location.protocol;
gads.src = (useSSL ? 'https:' : 'http:') +
'//www.googletagservices.com/tag/js/gpt.js';
var node = document.getElementsByTagName('script')[0];
node.parentNode.insertBefore(gads, node);
})();
</script>

<script type='text/javascript'>
googletag.cmd.push(function() {
googletag.defineSlot('/7328715/970-90-HP', [975, 90], 
'div-gpt-ad-1415702762316-0').addService(googletag.pubads());
googletag.pubads().enableSingleRequest();
googletag.enableServices();
});
</script>