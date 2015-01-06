<?php use_helper('Date') ?> 
<?php /*if($is_current_user):?>
<?php 
$reviews_url = url_for('profile/reviews');
$photos_url = url_for('profile/photos'); 
$lists_url = url_for('profile/lists');
$events_url = url_for('profile/events');
$articles_url =  url_for('profile/articles');
$badges_url =  url_for('profile/badges');
$followed_url =  url_for('profile/followed');
$followers_url =  url_for('profile/followers');
$profile_url =  url_for('profile/index');
?>
<?php endif*/?>
<?php $reviews_url = url_for('profile/reviews?username='. $pageuser->getUsername());
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

<div class="user_main">
	<a href="<?php echo $profile->getThumb('preview')?>" target="_blank" class="lightbox" rel="group3" title="<?php echo $profile->getName();?>">
		<?php echo image_tag($profile->getThumb(), array('alt'=>$profile->getName())) ?>
	</a>

	<?php $is_top=false;
	
	if ($profile->getIsTopUser()):?>
		<img src="<?php echo image_path('gui/top_user.png') ?>" title="This <?php echo $profile ?> is top user" />
	<?php endif; ?>

	<?php if(sfConfig::get('app_enable_messaging')):?>
		<?php if($send_message_option):?>
			<?php echo link_to('Send Message', 'message/compose?username='.$profile->getsfGuardUser()->getUsername()) ?>
		<?php endif;?>
	<?php endif;?>

	
	<?php if($user && !$is_other_place_admin_logged && !$is_current_user ):?>
	<?php $first_name = $profile->getSpecialFirstName(); ?>
		<?php if (!$is_followed):?>
			<div>
				<?php echo link_to(__('Follow').' '.$first_name.' ('. $profile->getFollowers(true).')', 'follow/follow?page_id='. $profile->getUserPage()->getId(), array('class' =>'button_green button_clickable')); ?>
			</div>
		<?php else:?>
			<div>
				<?php echo link_to(__('Unfollow').' '.$first_name.' ('. $profile->getFollowers(true).')', 'follow/stopFollow?page_id='. $profile->getUserPage()->getId(), array('class' =>'button_green button_clickable button_clicked')); ?>
			</div>
		<?php endif;?>
	<?php endif;?>
	
	
	<h1><?php echo link_to($profile->getName(), $profile_url, array('title'=>$profile->getName()));?></h1>
        <?php if($is_current_user):?> 
        <a href="<?php echo url_for('userSettings/index'); ?>" title="<?php echo __('Settings') ?>" class="settings_wheel"><?php echo image_tag('gui/settings_wheel.png') ?></a>
        <?php endif;?>
	<p>
	
		<?php if($sf_user->getCulture() != 'sr') : ?>
			<?php $vr1 = $profile->getCountry()->getCountryNameByCulture(); ?>
			<?php $vr2 = $profile->getCity()->getDisplayCity(); ?>
		<?php else: ?>
			<?php $vr1 = $profile->getCity()->getDisplayCity(); ?>
			<?php $vr2 = $profile->getCountry()->getCountryNameByCulture(); ?>
		<?php endif; ?>
	 
                <?php if ($profile->getCountry()->getId() && $profile->getCity()->getId()) : ?>
                    <?php echo __('is from', null, 'user'); ?> <?php echo '<strong>'. $vr1. ', ' . $vr2.'</strong>' ?>.
                <?php elseif ($profile->getCountry()->getId()) : ?>
                    <?php ?>
                    <?php echo __('is from', null, 'user'); ?> <?php echo '<strong>'.$profile->getCountry()->getCountryNameByCulture().'</strong>' ?>.
		<?php endif ?>
        
		<?php if ($profile->getBirthdate()):?>
			<?php echo __('Date of Birth', null,'form')?>: <?php echo '<strong>'.format_date($profile->getBirthdate(), 'dd MMM').'</strong>'; ?>
		<?php endif ?>
	</p>

	<p><?php echo $profile->getSummary()?></p>

	<ul>
		<?php if ($profile->getFacebookUrl()): ?>
			<li><a href="<?php echo $profile->getFacebookUrl() ?>" class="link_facebook" target="_blank"></a></li>
		<?php endif; ?>
		
		<?php if ($profile->getTwitterUrl()): ?>
			<li><a href="<?php echo $profile->getTwitterUrl() ?>" class="link_twitter" target="_blank"></a></li>
		<?php endif; ?>
		
		<?php if ($profile->getBlogUrl()): ?>
			<li><a href="<?php echo $profile->getBlogUrl();?>" class="link_blog" target="_blank"></a></li>
		<?php endif; ?>
		
		<?php if ($profile->getWebsite()): ?>
			<li><a href="<?php echo $profile->getWebsite(); ?>" class="link_website" target="_blank"></a></li>
		<?php endif;?>
	</ul>
	<div class="clear"></div>
	
	<?php if ($checkIns > 0):?>
		<p><?php echo sprintf(__('%s checkins'), '<strong>'.$checkIns.'</strong>');?></p>
	<?php endif;?>
      
</div>

<div class="profile_tab_wrap">
	<ul>
		<li>
			<a href="<?php echo ($reviewCount) ? $reviews_url : '#'; ?>">
			<?php if($review):?>
				<?php echo image_tag($review->getCompany()->getThumb(2)) ?>
			<?php else:?>
				<img src="/images/gui/default_tab.png" />
			<?php endif;?>
				<span>
					<span><?php echo __('Reviews')?> </span>
					<?php echo $reviewCount?>
				</span>
			</a>
		</li>
		<li>
			<a href="<?php echo ($imageCount) ? $photos_url : '#'?>">
			<?php if($image):?>
				<?php echo image_tag($image->getThumb(2)) ?>
			<?php else:?>
				<img src="/images/gui/default_tab.png" />
			<?php endif;?>	
				<span>
					<span><?php echo __('Photos', null, 'company')?> </span>
					<?php echo $imageCount?>
				</span>
			</a>
		</li>
		<li>
			<a href="<?php echo ($listCount) ? $lists_url : (($is_current_user) ? url_for('list/create'): '#'); ?>">
			<?php if($list):?>
				<?php echo image_tag($list->getImage()->getThumb(2)) ?>
			<?php else:?>
				<img src="/images/gui/default_tab.png" />
				<?php if (!$listCount && $is_current_user):?>
					<span class="button_pink"><?php echo __('Create List', null, 'list')?></span>
				<?php endif; ?>
			<?php endif;?>	
				<span>
					<span><?php echo __('Lists')?> </span>
					<?php echo $listCount?>
				</span>
			</a>
		</li>
		<li>
		
			<a href="<?php echo ($eventCount) ? $events_url : (($is_current_user) ? url_for('event/create') :'#'); ?>">
			<?php if($event):?>
				<?php echo image_tag($event->getImage()->getThumb(2)) ?>
			<?php else:?>
				<img src="/images/gui/default_tab.png" />
				<?php if (!$eventCount && $is_current_user):?>
					<span class="button_pink"><?php echo __('New Event', null, 'events')?></span>
				<?php endif; ?>
			<?php endif;?>	
				
			
				<span>
					<span><?php echo __('Events')?> </span>
					<?php echo $eventCount?>
				</span>
			</a>
		</li>
		<?php if($articleCount or ($is_current_user && ( $user && $user->getId() && ($sf_user->isSuperAdmin()  || in_array('article_editor', $sf_user->getCredentials()->getRawValue() ) || in_array('article_writer', $sf_user->getCredentials()->getRawValue())  ) )) ):?>
		<li>
		
			<a href="<?php echo ($articleCount) ? $articles_url : (($is_current_user) ? url_for('article/create'):'#'); ?>">
			<?php if($article):?>
				<?php echo image_tag(ZestCMSImages::getImageURL('article', 'big').$article->getArticleImageForIndex()->getFilename()) ?>
			<?php else:?>
				<img src="/images/gui/default_tab.png" />
				<?php if (!$articleCount && $is_current_user):?>
				<?php if  ( $user && $user->getId() && ($sf_user->isSuperAdmin()  || in_array('article_editor', $sf_user->getCredentials()->getRawValue() ) || in_array('article_writer', $sf_user->getCredentials()->getRawValue())  ) ):?>
					<span class="button_pink"><?php echo __('Create an Article', null, 'article')?></span>
				<?php endif; ?>
				<?php endif; ?>
			<?php endif;?>
				<span>
					<span><?php echo __('Articles');?> </span>
					<?php echo $articleCount?>
				</span>
			</a>
		</li>
		<?php endif;?>
	</ul>
	<div class="clear"></div>
</div>


<div class="user_tabs_wrap">
	<div class="special_tabs_wrap">
	
		<div class="special_tabs_top">

			<?php if($is_current_user):?>
		    <?php if(sfConfig::get('app_enable_messaging')):?>
				
				<?php //if ($messageCount > 0): ?>
					<div id="conversations">
						<?php echo link_to(__('Messages'), 'profile/conversations'); ?>
						<span>(<?php echo $messageCount; ?>)</span>
					</div>
				<?php //endif; ?>
			<?php endif;?>
			<?php endif;?>
			<?php if ($followerCount > 0): ?>
					<div id="followers">
						<?php echo link_to(__('Followers', null, 'user'), $followers_url ); ?>
						<span>(<?php echo $followerCount; ?>)</span>
					</div>
				<?php endif; ?>
				<?php if ($followedCount > 0): ?>
					<div id="followed">
						<?php echo link_to(__('Following'), $followed_url); ?>
						<span>(<?php echo $followedCount; ?>)</span>
					</div>
				<?php endif; ?>
		    <?php if ($badgeCount > 0): ?>
					<div id="badges">
						<?php echo link_to(__('Badges'), $badges_url ); ?>
						<span>(<?php echo $badgeCount; ?>)</span>
					</div>
				<?php endif; ?>
				<?php if($is_current_user):?>
                  <?php if ($voucherCount > 0): ?>
					<div id="vouchers">
						<?php echo link_to(__('Vouchers', null, 'offer'), 'profile/vouchers'); ?>
						<span>(<?php echo $voucherCount; ?>)</span>
					</div>
			  <?php endif;?>
			<?php endif;?>

			<?php if ($placesCount > 0): ?>
					<div id="added_places">
						<?php echo link_to(__('Added Places', null, 'company'), $places_url); ?>
						<span>(<?php echo $placesCount; ?>)</span>
					</div>
			  <?php endif;?>

		    <div class="clear"></div>
		</div>
		
		<div id="tab-container-1" class="standard_tabs_in special_tabs_in">
			<?php echo $sf_data->getRaw('sf_content') ?>		
		</div>
	</div>
</div>

<div class="clear"></div>


<script type="text/javascript">
$(document).ready(function() {
	$('.special_tabs_top a').removeClass('current');
    $('.special_tabs_top #<?php echo $sf_params->get('action');?> a').addClass('current');
    
	$("a.lightbox").fancybox({
		'cyclic'			: false,
		'titlePosition'		: 'outside',
		'overlayColor'		: '#000',
		'overlayOpacity'	: 0.6
	});
	
           setTimeout(function() {
        $(".profile_tab_wrap ul li").trigger('click');
    },10);
      $(".profile_tab_wrap ul li").click(function() {
        $('html, body').animate({
         scrollTop: $(".page_wrap").offset().top
     }, 10);
        });
	
});
</script>
