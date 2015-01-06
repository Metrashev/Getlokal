<div class="promo_wrap">
	<div class="promo_header_wrap"><?php $culture= $sf_user->getCulture();?>
		<?php if($sf_user->getCulture() == 'en'): ?> 
		<img src="/images/promo/reviewPlace/header_en.png"></img> 
		<?php else: ?> <img
		src="/images/promo/reviewPlace/header.png"></img> <?php endif ?>
	</div>
	<span>Здравейте, фенове! Настъпи дългоочакваният момент, в който един от вас ще спечели Новия iPad! Събрахме всички участници в игрите от 03.09 до днес, 08.10 и победителят е..... Мая Вангелова</span>
	<div class="promo_content_wrap">
		<div class="promo_picture_wrap">
			<div class="promo_picture">
				<a target="_blank" href="http://www.istyle.bg/"><img src="/images/promo/reviewPlace/picture.png"></img></a>
			</div>
			<div class="promo_picture">
				<a target="_blank" href="http://www.bloksf.com/"><img src="/images/promo/reviewPlace/picture2.png"></img></a>
			</div>
		</div>

		<div class="promo_content_video">
			<iframe style="margin-bottom: 40px;" width="560" height="315" src="http://www.youtube.com/embed/CC3IG2Tx-zY" frameborder="0" allowfullscreen ></iframe>
			<p><?php printf(__('Congratulations Maq! <br />Thank you all for playing! Please make sure you check out for our next games here and in %s', null, 'reviewPlacePage'), link_to('facebook', 'https://www.facebook.com/getlokal?fref=ts', 'target=_blank'))?></p>
			<p><?php printf(__('You can watch our previous weeks draws %s', null, 'reviewPlacePage'), link_to( __('here', null, 'reviewPlacePage'), 'http://www.youtube.com/playlist?list=PLQZWivLna3xO3j_6FvLNrc88lEfxoUiZr', 'target=_blank') )?></p>
		</div>
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
