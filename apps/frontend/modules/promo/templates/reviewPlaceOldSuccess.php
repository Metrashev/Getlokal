
<?php use_javascript('/sfFormExtraPlugin/js/jquery.autocompleter.js') ?>
<?php use_stylesheet('/sfFormExtraPlugin/css/jquery.autocompleter.css') ?>
<div class="promo_wrap">
	<div class="promo_header_wrap"><?php $culture= $sf_user->getCulture();?>
		<?php if($sf_user->getCulture() == 'en'): ?> 
		<img src="/images/promo/reviewPlace/header_en.png"></img> 
		<?php else: ?> <img
		src="/images/promo/reviewPlace/header.png"></img> <?php endif ?>
	</div>
		<p><?php echo __('Thank you for your huge interest in Add a Place. We have been overwhelmed with your suggestions so far and so have decided to change things slightly. All your places approved by 18.09.2012 are <a id="terms_win" href="javascript:void(0);">valid entries</a> for the <b>New iPad</b> Prize Draw on 08.10.2012 and for the Prize Draw for <b>SUPRA</b> on 19.09.2012.', null, 'reviewPlacePage'); ?></p>
			<h2><span></span><?php echo sprintf(__('Win SUPRA by %s, iPod by %s and the <b>New iPad</b>', null ,'reviewPlacePage'), '<a target="_blank" href="/bg/sofia/blok_shop_7021393"><b>BlokShop</b></a>', '<a target="_blank" href="http://www.istyle.bg/"><b>iStyle</b></a>');?></h2>
	<div class="promo_content_wrap">
		<div class="promo_picture_wrap">
			<div class="promo_picture">
				<a target="_blank" href="http://www.istyle.bg/"><img src="/images/promo/reviewPlace/picture.png"></img></a>
			</div>
			<div class="promo_picture">
				<a target="_blank" href="http://www.bloksf.com/"><img src="/images/promo/reviewPlace/picture2.png"></img></a>
			</div>
		</div>
		<div class="promo_content">
			<div class="promo_content_column">
				<h2><span></span><?php echo __('How to play?', null, 'reviewPlacePage') ?></h2>
				<ul> <?php $classification = Doctrine::getTable('Classification')->createQuery('c')->innerJoin ( 'c.Translation t' )->addWhere('c.id= 164')->fetchOne();?>
					<li><?php printf(__('Find your favourite %s', null, 'reviewPlacePage'), link_to(__('place in getlokal', null, 'reviewPlacePage'), url_for('@classification?slug='. $classification->getSlug(). '&sector='. $classification->getPrimarySector()->getSlug().'&city='. $sf_user->getCity()->getSlug()).'#content', array('target'=>'_blank'))) ?></li>
					<li><?php echo __('Review it', null, 'reviewPlacePage') ?></li>
					<li><?php echo __('Publish and enter the draw', null, 'reviewPlacePage') ?></li>
				</ul>
			</div>
			<div class="promo_content_column">
				<h2><span></span><?php echo __('Need help?', null, 'reviewPlacePage') ?></h2>
				<ul>
					<li><a id="terms" href="javascript:void(0)"><?php echo __('Rules of the Game', null, 'reviewPlacePage'); ?></a></li>
					<li><?php printf(__('Ask us in %s', null, 'reviewPlacePage'), link_to('Facebook', 'http://www.facebook.com/getlokal', array('target'=>'_blank'))) ?></li>
					<li><?php echo '<a href="mailto:info@getlokal.com">'.__('Write to us', null, 'reviewPlacePage').'</a>' ?></li>
				</ul>
			</div>
			<div class="clear"></div>
			
			<div class="promo_content_in">
				<ul>
					<li><?php echo __('Enter the <b>"Review a place"</b> game for a change to win an <b>iPod Touch 8GB</b> by <a href="http://www.facebook.com/iStyleBulgaria" target="_blank">iStyle</a>, <b>SUPRA</b> sneakers by <a href="/bg/sofia/blok_shop_7021393" target="_blank">BLOK Shop</a> and the <b>New iPad</b> by <a href="http://www.facebook.com/iStyleBulgaria" target="_blank">iStyle</a>!', null, 'reviewPlacePage'); ?></li>
					<li><?php echo __('<b>"Review a place"</b> starts at midday on 18.09.2012 and finishes at midday on 08.10.2012', null, 'reviewPlacePage'); ?></li>
					<li><?php printf(__('To enter write a review for a place chosen by you in %s', null, 'reviewPlacePage'), link_to('getlokal', url_for('@homepage').'#search_by_category', array('target'=>'_blank'))); ?>
					<li><?php echo __('There is no limit to the number of times you can participate in the game. Every review increases your chance of winning the Weekly Prize and the New iPad!', null, 'reviewPlacePage'); ?></li>
					<li><?php echo __('The Weekly Prize Draws will take place every Monday at 15:00 pm for the previous week and the final draw for the <b>New iPad</b> will take place at 15:00 on 08.10.2012', null, 'reviewPlacePage'); ?></li>
					<li><?php echo __('You have to be a registered getlokal user to participate', null, 'reviewPlacePage'); ?></li>
					<li><?php echo __('Reviews must contain at least one sentence and to project personal opinion', null, 'reviewPlacePage'); ?></li>
				</ul>
			</div>
			<div class="promo_content_inside">
				<ul>
					<li><?php echo __('Only places suggested by 17:00 on 16.09.2012 are valid entries for the Prize Draw on 19.09.2012', null, 'reviewPlacePage'); ?></li>
					<li><?php echo __('All places approved during <b>"Add a Place"</b> between 03 and 18.09.2012 are automatically entered in the <b>New iPad</b> Prize Draw on 08.10.2012 and the <b>SUPRA</b> Prize Draw on 19.09.2012.', null, 'reviewPlacePage'); ?></li>
					<li><?php echo sprintf(__('Winners will be notified by email and on our %s page', null, 'reviewPlacePage'),'<a href="http://www.facebook.com/getlokal" target="_blank">Facebook</a>'); ?></li>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
		<a class="button_green" target="_blank" href="<?php echo url_for('@classification?slug='. $classification->getSlug(). '&sector='. $classification->getPrimarySector()->getSlug().'&city='. $sf_user->getCity()->getSlug()).'#content';?>" class="button_pink"><?php echo __('Start here', null, 'reviewPlacePage')?></a>
	</div>
	<div class="right_box">
		
		<?php if(!$sf_user->isAuthenticated()): ?>
			<a href="<?php echo url_for('@sf_guard_signin').'?reviewplace=1';?>" class="button_green"><span></span><?php echo __('Login', null, 'reviewPlacePage')?></a>
		<?php endif; ?>
	</div>
	<div class="clear"></div>
	<?php $classification = Doctrine::getTable('Classification')->createQuery('c')->innerJoin ( 'c.Translation t' )->addWhere('c.id= 170')->fetchOne();?>
	<a href="<?php echo url_for('@classification?slug='. $classification->getSlug(). '&sector='. $classification->getPrimarySector()->getSlug().'&city='. $sf_user->getCity()->getSlug()).'#content'?>"><img style="float: left; width:auto; margin-right: 20px;" src="/images/promo/reviewPlace/iPad3.png" /></a>
	<?php $classification = Doctrine::getTable('Classification')->createQuery('c')->innerJoin ( 'c.Translation t' )->addWhere('c.id= 137')->fetchOne();?>
	<a href="<?php echo url_for('@classification?slug='. $classification->getSlug(). '&sector='. $classification->getPrimarySector()->getSlug().'&city='. $sf_user->getCity()->getSlug()).'#content'?>"><img style="float: left; width:auto; margin-right: 4px;"src="/images/promo/reviewPlace/supra_ketzki.png" /></a>
	<?php $classification = Doctrine::getTable('Classification')->createQuery('c')->innerJoin ( 'c.Translation t' )->addWhere('c.id= 174')->fetchOne();?>
	<a href="<?php echo url_for('@classification?slug='. $classification->getSlug(). '&sector='. $classification->getPrimarySector()->getSlug().'&city='. $sf_user->getCity()->getSlug()).'#content'?>"><img style="float: left; width:auto;"src="/images/promo/reviewPlace/iPod.png" /></a>
</div>
<div class="clear"></div>

<script type="text/javascript">
$(document).ready(function() {
	$(".search_bar").remove();
	$(".banner").remove();
	$(".path_wrap").remove();
	$('.content_footer').remove();
	$('input, textarea').mouseenter(function() {
		var tooltip = $(this).parent().children('.tooltip');
		if (tooltip.length > 0)
			$(this).parent().children('.tooltip_body').toggle();
	});
	$('input, textarea').mouseleave(function() {
		var tooltip = $(this).parent().children('.tooltip');
		if (tooltip.length > 0)
			$(this).parent().children('.tooltip_body').toggle();
	});

	$('#terms').fancybox({
		'hideOnContentClick': true,
		'content': '<div class="promo_content_in" style="display:block">' + $('.promo_content_in').html() + '</div>'
	});
	
	$('#terms_win').fancybox({
		'hideOnContentClick': true,
		'content': '<div class="promo_content_in" style="display:block">' + $('.promo_content_inside').html() + '</div>'
	});
	
	$('a#header_close').live('click', function() {
		$('.extra_text').css('display', 'none');
	   	$('#map_canvas').css('height', '352px');
	   	$('.canvas').css('height', '352px');
	   	google.maps.event.trigger(map.map, 'resize');
	});

	$('.header').css('marginBottom', '0px');
	$('.content_wrap').addClass('content_wrap_new');
});
</script>
<div class="clear"></div>