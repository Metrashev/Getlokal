<?php 	
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
<ul class="nav nav-tabs default-form-tabs global-tab-profile-settings" id="myTab">
<?php /* if($is_current_user && sfConfig::get('app_enable_messaging')){?>
	<li<?=$selectedTab == 'conversationsTab' ? ' class="active" ' : ''?>><?=link_to("<span>$messageCount</span>".__('Messages'), 'profile/conversations'); ?></li>	
<?php } */ ?>

<?php if($followerCount){?>
	<li <?=$selectedTab == 'followersTab' ? ' class="active" ' : ''?>><?=link_to("<span>$followerCount</span>".__('Followers'), $followers_url); ?></li>	
<?php }?>

<?php if($followedCount){?>
	<li<?=$selectedTab == 'followedTab' ? ' class="active" ' : ''?>><?=link_to("<span>$followedCount</span>".__('Following'), $followed_url); ?></li>	
<?php }?>

<?php if($badgeCount){?>
	<li<?=$selectedTab == 'badgesTab' ? ' class="active" ' : ''?>><?=link_to("<span>$badgeCount</span>".__('Badges'), $badges_url); ?></li>	
<?php }?>

<?php if($voucherCount){?>
	<li<?=$selectedTab == 'vouchersTab' ? ' class="active" ' : ''?>><?=link_to("<span>$voucherCount</span>".__('Vouchers', null, 'offer'), 'profile/vouchers'); ?></li>	
<?php }?>

<?php if($placesCount){?>
	<li<?=$selectedTab == 'placesTab' ? ' class="active" ' : ''?>><?=link_to("<span>$placesCount</span>".__('Added Places', null, 'company'), $places_url); ?></li>	
<?php }?>

	<li class="inactive"><a href="javascript:void(0)"><span><?=$checkIns?></span><?=__('checkins')?></a></li>
</ul>