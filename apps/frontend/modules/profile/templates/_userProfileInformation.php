<?php 	
	use_helper('Date');

	$reviews_url = url_for('profile/reviews?username='. $pageuser->getUsername());
	$photos_url = url_for('profile/photos?username='. $pageuser->getUsername()) ;
	$lists_url = url_for('profile/lists?username='. $pageuser->getUsername());
	$events_url = url_for('profile/events?username='. $pageuser->getUsername());
	$articles_url =  url_for('profile/articles?username='. $pageuser->getUsername());
	$badges_url =  url_for('profile/badges?username='. $pageuser->getUsername()); 
	$followed_url =  url_for('profile/followed?username='. $pageuser->getUsername());
	$followers_url =  url_for('profile/followers?username='. $pageuser->getUsername());
	$profile_url =  url_for('profile/index?username='. $pageuser->getUsername());
	$places_url =  url_for('profile/places?username='. $pageuser->getUsername());	
?>
<div class="user-profile-head">
<?php /* if(sfConfig::get('app_enable_messaging') || 1){
		if($send_message_option || 1){
		  echo link_to(__('Send Message'), 'message/compose?username='.$profile->getsfGuardUser()->getUsername(), 'class="default-btn user-profile-btn"');
		}
	  } 
	  */
?>

	<div class="center-image">
		<a href="<?php echo $profile->getThumb('preview')?>" class="user-profile-image">
			<?php echo image_tag($profile->getThumb(), array('alt'=>$profile->getName())) ?>
		</a>
			<?php 
		if($is_current_user){ 
			echo link_to(__('Settings'), 'userSettings/index', 'class="default-btn user-profile-btn"');
		}
	?>
	</div>

	<?php 
	if($user && !$is_other_place_admin_logged && !$is_current_user){
			$first_name = $profile->getSpecialFirstName();
			if (!$is_followed){
				echo link_to(__('Follow').' '.$first_name.' ('. $profile->getFollowers(true).')', 'follow/follow?page_id='. $profile->getUserPage()->getId(), array('class' =>'default-btn user-profile-btn'));
			}else{
				echo link_to(__('Unfollow').' '.$first_name.' ('. $profile->getFollowers(true).')', 'follow/stopFollow?page_id='. $profile->getUserPage()->getId(), array('class' =>'default-btn user-profile-btn'));
			}
	}?>



</div>
<div class="user-profile-information">
	<h3 class="user-profile-name"><?=$profile->getName(); ?></h3>
	<div class="profile-user-from">
	<?php 
					if($sf_user->getCulture() != 'sr'){
						 $vr1 = $profile->getCountry()->getCountryNameByCulture(); 
						 $vr2 = $profile->getCity()->getDisplayCity(); 
					}else{ 
						 $vr1 = $profile->getCity()->getDisplayCity(); 
						 $vr2 = $profile->getCountry()->getCountryNameByCulture(); 
			 		}
		 
	                 if ($profile->getCountry()->getId() && $profile->getCity()->getId()) : ?> 
	                    <?php echo __('is from', null, 'user'); ?> <?php echo '<div class="user-profile-place" href="#"><i class="fa fa-map-marker"></i>'. $vr1. ', ' . $vr2.'</div>' ?>.
	                <?php elseif ($profile->getCountry()->getId()) : ?>
	                    <?php echo __('is from', null, 'user'); ?> <?php echo '<div class="user-profile-place" href="#"><i class="fa fa-map-marker"></i>'.$profile->getCountry()->getCountryNameByCulture().'</div>' ?>.
	<?php endif ?>
	        
					<?php if ($profile->getBirthdate()):?>
						<?php echo '<span class="separator-place-birth">/</span><span class="user-birth-date-title">'.__('Date of Birth', null,'form').': </span><span class="user-birth-date">'.format_date($profile->getBirthdate(), 'dd MMM').'</span>'; ?>
					<?php endif ?>
	</div>
	<?php // TODO: description goes here <div class="user-profile-description"></div> ?>	
	<div class="user-profile-social">
		<div class="socials wrapper-social-links">
			<ul class="user-profile-social-list">
				<?php if ($profile->getFacebookUrl()): ?>
					<li>
						<a href="<?php echo $profile->getFacebookUrl() ?>" class="link-facebook" target="_blank"><i class="fa fa-facebook fa-14px"></i></a>
					</li>
				<?php endif; ?>
				
				<?php if ($profile->getTwitterUrl()): ?>
					<li>
						<a href="<?php echo $profile->getTwitterUrl() ?>" class="link-twitter" target="_blank"><i class="fa fa-twitter fa-14px"></i></a>
					</li>
				<?php endif; ?>
				
				<?php if ($profile->getBlogUrl()): ?>
					<li><a href="<?php echo $profile->getBlogUrl();?>" class="link-blog" target="_blank"><i class="fa fa-book fa-14px"></i></a></li>
				<?php endif; ?>
				
				<?php if ($profile->getWebsite()): ?>
					<li><a href="<?php echo $profile->getWebsite(); ?>" class="link-website" target="_blank"><i class="fa fa-globe fa-14px"></i></a></li>
				<?php endif;?>
			</ul>
		</div>
	</div>
	<div class="user-profile-activities">
		<h4 class="activities-title">activities</h4>
		<ul class="user-profile-list-activities">
			<li class="user-activity">
				<a href="<?=($reviewCount) ? $reviews_url : '#'; ?>">
					<div class="default-activity">
						<img src="<?=($reviewCount && $review ? $review->getCompany()->getThumb(2) : '/images/gui/default_tab.png')?>" alt="">
						<div class="user-activity-number">
							<span class="type-of-activity"><?=__('Reviews')?></span><span class="number-of-type-activity"><?=$reviewCount?></span>
						</div>
						<div class="hover-activity">
							<h5 class="number-activities-hovered"><?=$reviewCount?></h5>
							<a class="default-btn small white" href="<?=($reviewCount) ? $reviews_url : '#'; ?>"><?=__('see all')?> <i class="fa fa-long-arrow-right"></i></a>
							<h3 class="active-title-hovered"><?=__('Reviews')?></h3>
						</div>
					</div>
				</a>
			</li>
			<li class="user-activity">
				<a href="<?php echo ($imageCount) ? $photos_url : '#'?>">
					<div class="default-activity">
						<img src="<?=($imageCount && $image ? $image->getThumb(2) : '/images/gui/default_tab.png')?>" alt="">
						<div class="user-activity-number">
							<span class="type-of-activity"><?php echo __('Photos', null, 'company')?></span><span class="number-of-type-activity"><?=$imageCount?></span>
						</div>
						<div class="hover-activity">
							<h5 class="number-activities-hovered"><?=$imageCount?></h5>
							<a class="default-btn small white" href="<?php echo ($imageCount) ? $photos_url : '#'?>"><?=__('see all')?> <i class="fa fa-long-arrow-right"></i></a>
							<h3 class="active-title-hovered"><?php echo __('Photos', null, 'company')?></h3>
						</div>
					</div>
				</a>
			</li>
			<li class="user-activity">
				<a href="<?php echo ($listCount) ? $lists_url : (($is_current_user) ? url_for('list/create'): '#'); ?>">
					<div class="default-activity">
						<img src="<?=($listCount && $list ? $list->getImage()->getThumb(2) : '/images/gui/default_tab.png')?>" alt="">
						<div class="user-activity-number">
							<span class="type-of-activity"><?php echo __('Lists')?></span><span class="number-of-type-activity"><?=$listCount?></span>
						</div>
						<div class="hover-activity">
							<h5 class="number-activities-hovered"><?=$listCount?></h5>
							<a class="default-btn small white" href="<?php echo ($listCount) ? $lists_url : (($is_current_user) ? url_for('list/create'): '#'); ?>"><?=__('see all')?> <i class="fa fa-long-arrow-right"></i></a>
							<h3 class="active-title-hovered"><?php echo __('Lists')?></h3>
						</div>
					</div>
				</a>
			</li>
			
			<li class="user-activity">
				<a href="<?php echo ($eventCount) ? $events_url : (($is_current_user) ? url_for('event/create') :'#'); ?>">
					<div class="default-activity">
						<img src="<?=($eventCount && $event ? $event->getImage()->getThumb(2) : '/images/gui/default_tab.png')?>" alt="">
						<div class="user-activity-number">
							<span class="type-of-activity"><?php echo __('Events')?></span><span class="number-of-type-activity"><?=$eventCount?></span>
						</div>
						<div class="hover-activity">
							<h5 class="number-activities-hovered"><?=$eventCount?></h5>
							<a class="default-btn small white" href="<?php echo ($eventCount) ? $events_url : (($is_current_user) ? url_for('event/create') :'#'); ?>"><?=__('see all')?> <i class="fa fa-long-arrow-right"></i></a>
							<h3 class="active-title-hovered"><?php echo __('Events')?></h3>
						</div>
					</div>
				</a>
			</li>
			<?php if($articleCount || ($is_current_user && ( $user && $user->getId() && ($sf_user->isSuperAdmin()  || in_array('article_editor', $sf_user->getCredentials()->getRawValue() ) || in_array('article_writer', $sf_user->getCredentials()->getRawValue())  ) )) ):?>
			<li class="user-activity">
				<a href="<?php echo ($articleCount) ? $articles_url : (($is_current_user) ? url_for('article/create'):'#'); ?>">
					<div class="default-activity">
						<img src="<?=(is_object($article) && is_object($article->getArticleImageForIndex()) ? ZestCMSImages::getImageURL('article', 'big').$article->getArticleImageForIndex()->getFilename() : '/images/gui/default_tab.png')?>" alt="">
						<div class="user-activity-number">
							<span class="type-of-activity"><?php echo __('Articles');?></span><span class="number-of-type-activity"><?=$articleCount?></span>
						</div>
						<div class="hover-activity">
							<h5 class="number-activities-hovered"><?=$articleCount?></h5>
							<a class="default-btn small white" href="<?php echo ($articleCount) ? $articles_url : (($is_current_user) ? url_for('article/create'):'#'); ?>"><?=__('see all')?> <i class="fa fa-long-arrow-right"></i></a>
							<h3 class="active-title-hovered"><?php echo __('Articles');?></h3>
						</div>
					</div>
				</a>
			</li>
			<?php endif;?>
			
		</ul>
	</div>
</div>