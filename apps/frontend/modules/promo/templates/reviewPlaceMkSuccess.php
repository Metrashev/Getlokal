<?php //echo __('Every review wins!', null, 'reviewPlacePage'); ?>
<?php //echo __('Getlokal.mk wants your reviews! New challenge every week!', null, 'reviewPlacePage'); ?>
<div class="promo_wrap">
	<div class="promo_header_wrap">
		<?php if($sf_user->getCulture() == 'mk'): ?>
			<a href="javascript:void(0)"><img src="/images/promo/reviewPlace_mk/header.png" /></a>
		<?php else: ?>
			<a href="javascript:void(0)"><img src="/images/promo/reviewPlace_mk/header_en.png" /></a>
		<?php endif; ?>
	</div>
	<?php /* ?>
	<?php if($sf_user->getCulture() == 'mk'): ?>
		<img src="/images/promo/reviewPlace_mk/sticker.png" />
	<?php else:?>
		<img src="/images/promo/reviewPlace_mk/sticker_en.png" />
	<?php endif;?>
	
	<h1><?php printf(__('Share your opinion about %s and <br />take a part in the draw for <br /><span class="pink">the main prize</span>!', null, 'reviewPlacePage'), link_to(__('any place', null, 'reviewPlacePage'), url_for('classification', array('slug'=>Doctrine::getTable('Classification')->find('165')->getSlug(), 'sector'=> Doctrine::getTable('Sector')->find('8')->getSlug(), 'city'=> $sf_user->getCity()->getSlug())).'#content', array('target'=>'_blank', 'class'=>'pink'))); ?></h1>
	<?php */ ?> 
	<span><?php echo sprintf(__('Hi there,<br/><br/>The big moment has come - one of you is the winner of a weekend for two at Aurora Resort & Spa - Berovo!<br/><br/>We gathered all participants from %s to %s and the winner is...... %s', null, 'reviewPlacePage'), '24.09.2012', '21.10.2012', link_to('Aleksandra Kuzmanovska', 'http://www.getlokal.mk/mk/profile/405c17bd')); ?></span>
	<br/><br/><br/>
	<span class="shadow_box"><?php printf(__('Congratulations %s!<br/><br/>Thank you all for playing! Please make sure you check out for our next games here and in %s!', null, 'reviewPlacePage'), 'Aleksandra', link_to('Facebook', 'https://www.facebook.com/getlokal.mk'))?></span>
	<div class="promo_content_wrap">
		<div class="promo_picture_wrap">
			<div class="promo_picture">
			<?php /* ?>
				<p><?php echo __('The Big Prize is a weekend for two at Aurora Resort & Spa - Berovo', null, 'reviewPlacePage')?></p>
				<?php */ ?>
				<?php if($sf_user->getCulture() == 'mk'): ?>
					<a href="javascript:void(0)"><img src="/images/promo/reviewPlace_mk/picture1.png" /></a>
				<?php else: ?>
					<a href="javascript:void(0)"><img src="/images/promo/reviewPlace_mk/picture1_en.png" /></a>
				<?php endif;?>
			</div>
			<div class="promo_picture">
				<?php /*?><p><?php printf(__('Weekly prize – a coffee at %s', null, 'reviewPlacePage'), link_to(__('Timeless cafe', null, 'reviewPlacePage'), 'http://www.getlokal.mk/mk/Skopje/timeless-caffe-tajmles-kafe_990103', array('target'=>'_blank'))); ?></p> */ ?>
				<a href="javascript:void(0)"><img src="/images/promo/reviewPlace_mk/picture1_old.png" /></a>
			</div>
		</div>
		<?php /*?>
		<div class="promo_content">
			<ul class="category_menu">
				<li class="category_8"><a target="_blank" href="<?php echo url_for('classification', array('slug'=>Doctrine::getTable('Classification')->find('165')->getSlug(), 'sector'=> Doctrine::getTable('Sector')->find('8')->getSlug(), 'city'=> $sf_user->getCity()->getSlug())).'#content' ?>"><span><?php echo __('Start here!', null, 'reviewPlacePage'); ?></span></a></li>
			</ul>
			<div class="clear"></div>
			
			<div class="promo_content_in">
				<div class="promo_content_column">
					<h2><?php echo __('Three Steps to Prizes', null, 'reviewPlacePage'); ?></h2>
					<ul>
						<li><?php echo __('In the search box find the place you want to write about', null, 'reviewPlacePage'); ?></li>
						<li><?php echo __('Register in getlokal.mk. It will only take a minute!', null, 'reviewPlacePage'); ?></li>
						<li><?php echo __('Submit your review!', null, 'reviewPlacePage'); ?></li>
					</ul>
					<?php echo __('Congratulations! You just registered in the draw for the Big Prize!', null, 'reviewPlacePage'); ?>
				</div>
			</div>
			
			<h2><?php echo __('Rules of the Game:', null, 'reviewPlacePage'); ?></h2>
			<ul class="promo_content_desc">
			    <li><?php echo __('In the fourth week of the contest, all users who wrote a review are competing for the Big Prize.', null, 'reviewPlacePage'); ?></li>
				<li><b><?php echo __('The users that will write more reviews, have a bigger chance to win the draw for the Big Prize', null, 'reviewPlacePage'); ?></b></li>
				<li><?php echo __('The reviews for the fourth week can be written in any category of places on GetLokal.mk', null, 'reviewPlacePage'); ?></li>
				<li><?php echo __('The winner will receive an e-mail with detailed information about the prize.', null, 'reviewPlacePage'); ?></li>
				<li><?php echo __('No obscene and offensive language, please.', null, 'reviewPlacePage'); ?></li>
				<li><?php printf(__('If the place you would like to write about does not have a profile with us, please %s', null, 'reviewPlacePage'), '<a href="mailto:bojana@getlokal.com?subject=Vo%20vrska%20so%20nagraden%20natprevar">'.__('tell us', null, 'reviewPlacePage').'</a>'); ?></li>
				<li><?php echo __('The contest runs from 24th of September to 21st of October 2012.', null, 'reviewPlacePage'); ?></li>	    
			</ul>
		
			<ul class="category_menu">
				<li class="category_8"><a target="_blank" href="<?php echo url_for('classification', array('slug'=>Doctrine::getTable('Classification')->find('165')->getSlug(), 'sector'=> Doctrine::getTable('Sector')->find('8')->getSlug(), 'city'=> $sf_user->getCity()->getSlug())).'#content' ?>"><span><?php echo __('Start here!', null, 'reviewPlacePage'); ?></span></a></li>
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
			<?php */ ?>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$(".content_footer").remove();
		$(".search_bar").remove();
		$(".path_wrap").remove();
		$(".banner").remove();
		$(".cta_message").remove();
		$(".cta").css("marginBottom", "0px");
		$(".cta").css("padding", "0px");
	});
</script>