<div class="promo_wrap">
	<div class="promo_header_wrap"><?php $culture= $sf_user->getCulture();?>
		<img src="/images/promo/reviewMania/header_<?php echo $sf_user->getCulture(); ?>.png"></img> 
	</div>
	<span><?php echo sprintf(__('Our newest game ReviewMania starts on %s November!', null, 'reviewManiaPage'), '5'); ?></span>
	<span><?php echo sprintf(__('Post your reviews on the web site and win a getlokal glass, vouchers and %s by %s', null, 'reviewManiaPage'), 'iPod Touch', link_to('iStyle', 'https://www.facebook.com/iStyleBulgaria'))?></span>
	<div class="promo_content_wrap">
		<div class="promo_picture_wrap">
			<div class="promo_picture">
				<h2><?php echo __('Rules of the game', null, 'reviewManiaPage') ?></h2>
				<ul>
					<li><?php echo sprintf(__('ReviewMania starts on %s November and ends on %s November', null, 'reviewManiaPage'), '05', '19'); ?></li>
					<li><?php echo __('To participate you must be a registered user', null, 'reviewManiaPage'); ?></li>
					<li><?php echo __('You can post reviews, opinions and recommendations for all places in getlokal. Check out suggested sectors bellow.', null, 'reviewManiaPage'); ?></li>
					<li><?php echo sprintf(__('Every review increases your chances for the weekly prizes and for the %s', null, 'reviewManiaPage'), 'iPod Touch'); ?></li>
					<li><?php echo __('Every review should be formulated with at last one sentence', null, 'reviewManiaPage'); ?></li>
					<li><?php echo __('Reviews with repeated content and reviews with abusive or obscene language, will be deleted by our moderators', null, 'reviewManiaPage'); ?></li>
					<li><?php echo sprintf(__('The weekly prize draws will take place every Monday at %s for entries submitted by %s on the pervious Sunday.', null, 'reviewManiaPage'), '15:00', '24:00'); ?></li>
					<li><?php echo __('The iPod Touch prize draw will take place on 19 November at 15:00.', null, 'reviewManiaPage'); ?></li>
					<li><?php echo sprintf(__('Winners will be notified by email and on our %s', null, 'reviewManiaPage'), link_to(__('Facebook page', null, 'reviewManiaPage'), 'https://www.facebook.com/getlokal')); ?></li>
				</ul>
			</div>
			<a target="_blank" href="http://www.istyle.bg/"><img src="/images/promo/reviewMania/picture.png" /></a>
		</div>
		<div class="promo_content_video">
			<iframe width="600" height="370" src="http://www.youtube.com/embed/t0xbhZabcSo?rel=0" frameborder="0" allowfullscreen></iframe>
			<?php /*?>
			<img src="/images/promo/reviewMania/video_default.png" />
			*/ ?>
		</div>
		<div class="promo_content">
		
			<div class="promo_content_column">
				<h2><?php echo __('How to play?', null, 'reviewManiaPage') ?></h2>
				<ul> <?php $classification = Doctrine::getTable('Classification')->createQuery('c')->innerJoin ( 'c.Translation t' )->addWhere('c.id= 164')->fetchOne();?>
					<li><?php echo sprintf(__('Choose from the %s or in the %s', null, 'reviewManiaPage'), '<a id="sector_button" href="javascript:void(0);">'.__('sectors bellow', null, 'reviewManiaPage').'</a>', link_to(__('search bar', null, 'reviewManiaPage'), '@home?city='.$sf_user->getCity()->getSlug(), array('target'=>'_blank'))) ?></li>
					<li><?php echo __('Review it and enter the draw', null, 'reviewManiaPage') ?></li>
				</ul>
			</div>
			<div class="promo_content_column">
				<h2><?php echo __('Need help?', null, 'reviewManiaPage') ?></h2>
				<ul>
					<li><?php printf(__('Ask us in %s', null, 'reviewManiaPage'), link_to('Facebook', 'http://www.facebook.com/getlokal', array('target'=>'_blank'))) ?></li>
					<li><?php echo '<a href="mailto:info@getlokal.com">'.__('Send us an email', null, 'reviewManiaPage').'</a>' ?></li>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="clear"></div>
	
	<?php $classification = Doctrine::getTable('Classification')->createQuery('c')->innerJoin ( 'c.Translation t' )->addWhere('c.id= 170')->fetchOne();?>
	<a id="button_anchor" style="margin-left: 0px;"target="_blank" class="special_button" href="<?php echo url_for('@classification?slug='. $classification->getSlug(). '&sector='. $classification->getPrimarySector()->getSlug().'&city='. $sf_user->getCity()->getSlug()).'#content'?>"><img src="/images/promo/reviewMania/button1_<?php echo $sf_user->getCulture(); ?>.png" /></a>
	<?php $classification = Doctrine::getTable('Classification')->createQuery('c')->innerJoin ( 'c.Translation t' )->addWhere('c.id= 156')->fetchOne();?>
	<?php $sector = Doctrine::getTable('Sector')->findOneById(18);?>
	<a target="_blank" class="special_button" href="<?php echo url_for('@classification?slug='. $classification->getSlug(). '&sector='. $sector->getSlug().'&city='. $sf_user->getCity()->getSlug()).'#content'?>"><img src="/images/promo/reviewMania/button2_<?php echo $sf_user->getCulture(); ?>.png" /></a>
	<?php $classification = Doctrine::getTable('Classification')->createQuery('c')->innerJoin ( 'c.Translation t' )->addWhere('c.id= 137')->fetchOne();?>
	<a target="_blank" class="special_button" href="<?php echo url_for('@classification?slug='. $classification->getSlug(). '&sector='. $classification->getPrimarySector()->getSlug().'&city='. $sf_user->getCity()->getSlug()).'#content'?>"><img src="/images/promo/reviewMania/button3_<?php echo $sf_user->getCulture(); ?>.png" /></a>
	<a href="http://www.arlet.bg/" target="_blank"><img style="margin-top: 25px; width: 924px;" src="/images/promo/reviewMania/arlet_<?php echo $sf_user->getCulture(); ?>.png" /></a>
</div>
<div class="clear"></div>

<script type="text/javascript">
$(document).ready(function() {
	$(".search_bar").remove();
	$(".banner").remove();
	$(".path_wrap").remove();
	$('.content_footer').remove();
	$('.header').css('marginBottom', '0px');
	$('.content_wrap').addClass('content_wrap_new');

	$('#sector_button').click(function() {
		var top = $('#button_anchor').offset().top - 60;
        $('html,body').animate({scrollTop: top}, 500);
	});
});
</script>
<div class="clear"></div>
