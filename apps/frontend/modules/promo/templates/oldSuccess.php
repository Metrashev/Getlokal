<?php //echo __('Every review wins!', null, 'reviewPlacePage'); ?>
<?php //echo __('getlokal.mk wants your reviews! New challenge every week!', null, 'reviewPlacePage'); ?>
<div class="promo_wrap">
	<div class="promo_header_wrap">
		<?php if($sf_user->getCulture() == 'mk'): ?>
			<a href="javascript:void(0)"><img src="/images/promo/reviewPlace_mk/header.png" /></a>
		<?php else: ?>
			<a href="javascript:void(0)"><img src="/images/promo/reviewPlace_mk/header_en.png" /></a>
		<?php endif; ?>
	</div>
	<?php if($sf_user->getCulture() == 'mk'): ?>
		<img src="/images/promo/reviewPlace_mk/sticker.png" />
	<?php else:?>
		<img src="/images/promo/reviewPlace_mk/sticker_en.png" />
	<?php endif;?>
	<h1><?php printf(__('<span>Share your opinion about</span> %s and <span class="pink">win</span>!', null, 'reviewPlacePage'), link_to('<b>'.__('Restaurants', null, 'reviewPlacePage').'</b>', url_for('classification', array('slug'=>Doctrine::getTable('Classification')->find('165')->getSlug(), 'sector'=> Doctrine::getTable('Sector')->find('8')->getSlug(), 'city'=> $sf_user->getCity()->getSlug())))); ?></h1>
	<div class="promo_content_wrap">
		<div class="promo_picture_wrap">
			<div class="promo_picture">
				<?php if($sf_user->getCulture() == 'mk'): ?>
					<a href="javascript:void(0)"><img src="/images/promo/reviewPlace_mk/picture1.png" /></a>
				<?php else: ?>
					<a href="javascript:void(0)"><img src="/images/promo/reviewPlace_mk/picture1_en.png" /></a>
				<?php endif;?>
			</div>
			<div class="promo_picture">
				<p><?php printf(__('Weekly prize – a coffee at %s', null, 'reviewPlacePage'), link_to(__('Timeless cafe', null, 'reviewPlacePage'), 'http://www.getlokal.mk/mk/Skopje/timeless-caffe-tajmles-kafe_990103')); ?></p>
				<?php if($sf_user->getCulture() == 'mk'): ?>
					<a href="javascript:void(0)"><img src="/images/promo/reviewPlace_mk/picture2.png" /></a>
				<?php else: ?>
					<a href="javascript:void(0)"><img src="/images/promo/reviewPlace_mk/picture2_en.png" /></a>
				<?php endif;?>
			</div>
		</div>
		<div class="promo_content">
			<ul class="category_menu">
				<li class="category_8"><a target="_blank" href="<?php echo url_for('classification', array('slug'=>Doctrine::getTable('Classification')->find('165')->getSlug(), 'sector'=> Doctrine::getTable('Sector')->find('8')->getSlug(), 'city'=> $sf_user->getCity()->getSlug())) ?>"><span><?php echo __('Start here!', null, 'reviewPlacePage'); ?></span></a></li>
			</ul>
			<div class="clear"></div>
			
			<div class="promo_content_in">
				<div class="promo_content_column">
					<h2><?php echo __('Three steps to prizes', null, 'reviewPlacePage'); ?></h2>
					<ul>
						<li><?php echo __('In the search box find the place you want to write about', null, 'reviewPlacePage'); ?></li>
						<li><?php echo __('Register in getlokal.mk. It will only take a minute!', null, 'reviewPlacePage'); ?></li>
						<li><?php echo __('Submit your recommendation!', null, 'reviewPlacePage'); ?></li>
					</ul>
					<?php echo __('Congratulations! You just won a voucher and registered in the draw for the big prize!', null, 'reviewPlacePage'); ?>
				</div>
			</div>
			
			<h2><?php echo __('Rules of the game:', null, 'reviewPlacePage'); ?></h2>
			<ul class="promo_content_desc">
			    <li><?php echo __('Every week we post a new challenge and a new prize.', null, 'reviewPlacePage'); ?></li>
				<li><?php echo __('A voucher will be emailed to each unique user within 24 hours after publishing the review. The period in which you voucher is valid is 7 days from its receipt.', null, 'reviewPlacePage'); ?></li>
				<li><?php echo __('Each user who submits a review will win one voucher per week.', null, 'reviewPlacePage'); ?></li>
				<li><?php echo __('In the fourth week of the contest, all users who wrote a review are competing for the big prize.', null, 'reviewPlacePage'); ?></li>
				<li><?php echo __('The winner will receive an e-mail with detailed information about the prize.', null, 'reviewPlacePage'); ?></li>
				<li><?php echo __('No obscene and offensive language, please.', null, 'reviewPlacePage'); ?></li>
				<li><?php printf(__('If the place you would like to write about does not have a profile with us, please %s', null, 'reviewPlacePage'), '<a href="mailto:bojana@getlokal.com?subject=Vo%20vrska%20so%20nagraden%20natprevar">'.__('tell us', null, 'reviewPlacePage').'</a>'); ?></li>
				<li><?php echo __('The contest runs from 24th of September through 21st of October 2012.', null, 'reviewPlacePage'); ?></li>	    
			</ul>
		
			<ul class="category_menu">
				<li class="category_8"><a target="_blank" href="<?php echo url_for('classification', array('slug'=>Doctrine::getTable('Classification')->find('165')->getSlug(), 'sector'=> Doctrine::getTable('Sector')->find('8')->getSlug(), 'city'=> $sf_user->getCity()->getSlug())) ?>"><span><?php echo __('Start here!', null, 'reviewPlacePage'); ?></span></a></li>
			</ul>
			<div class="clear"></div>
			<!-- 			
			<ul class="promo_logo">
				<li><a href="#"><img src="/images/promo/logo.png"></img></a></li>
				<li><a href="#"><img src="/images/promo/logo.png"></img></a></li>
				<li><a href="#"><img src="/images/promo/logo.png"></img></a></li>
			</ul>
			 -->
			<div class="clear"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$(".content_footer").css("display", "none");
		$(".search_bar").css("display", "none");
		$(".path_wrap").css("display", "none");
		$(".cta").css("marginBottom", "0px");
		$(".cta").css("padding", "0px");
		$(".cta_message").css("display", "none");
	});
</script>