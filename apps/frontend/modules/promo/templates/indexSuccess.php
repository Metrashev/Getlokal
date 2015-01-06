<div class="promo_wrap">
<div class="promo_header_wrap"><?php $culture= $sf_user->getCulture();?>
	<?php if($sf_user->getCulture() == 'en'): ?> 
	<img src="/images/promo/header_en.png"></img> 
	<?php else: ?> <img
	src="/images/promo/header.png"></img> <?php endif ?>
<p><?php echo __('Win the special FreshNewLook package from HILIFESALON. <br>Every Monday one of you will win a BGN 50 voucher fоr a famous fashion brand!', null, 'promo') ?></p>
</div>
<div class="promo_content_wrap">
<div class="promo_picture_wrap">
<div class="promo_picture">
<?php if($sf_user->getCulture() == 'en'): ?> 
	<?php echo link_to('<img src="/images/promo/picture1_en.png" />', 'company',array('city'=>'sofia','slug'=>'hilifesalon_7025952')) ?>
<?php else: ?>
	<?php echo link_to('<img src="/images/promo/picture1.png" />', 'company',array('city'=>'sofia','slug'=>'hilifesalon_7025952')) ?>
<?php endif ?>
</div>
<br />
<div class="promo_picture">
	<?php if($sf_user->getCulture() == 'en'): ?> 
	<a href="javascript:void(0)"><img src="/images/promo/picture2_en.png"></img></a>
	<?php else: ?>
	<a href="javascript:void(0)"><img src="/images/promo/picture2.png"></img></a>
	<?php endif ?>
</div>
</div>
<div class="promo_content"><?php /* ?>
<ul class="category_menu">
<li><a target="_blank" href="<?php echo url_for('@sector?slug='. Doctrine::getTable('Sector')->find('8')->getSlug(). '&city='. $sf_user->getCity()->getSlug())."#eatingOut" ?>"><span><?php echo __('Eating Out', null, 'promo') ?></span></a></li>
</ul>
<div class="clear"></div>
<?php */ ?>
<h2><?php echo __('How to Participate', null, 'promo') ?></h2>
<div class="promo_content_in">
<p><?php echo __('From 03 to 30 July registered in getlokal.com and upload a profile picture. If you already have a registration just upload new photo to participate.', null, 'promo') ?></p>
<div class="promo_content_column promo_content_column_left">
<h2><?php echo __('Fresh New Look for Her:', null, 'promo') ?></h2>
<ul>
	<li><?php echo __('Facial and neck SPA therapy', null, 'promo') ?></li>
	<li><?php echo __('Hairstyle', null, 'promo') ?></li>
	<li><?php echo __('Manicure and Pedicure', null, 'promo') ?></li>
	<li><?php echo __('Make up', null, 'promo') ?></li>
</ul>
</div>
<div class="promo_content_column">
<h2><?php echo __('Fresh New Look for Him:', null, 'promo') ?></h2>
<ul>
	<li><?php echo __('SPA procedure for hair', null, 'promo') ?></li>
	<li><?php echo __('Hairstyle', null, 'promo') ?></li>
	<li><?php echo __('Manicure and Pedicure', null, 'promo') ?></li>
	<li><?php echo __('Massage', null, 'promo') ?></li>
</ul>
</div>
<div class="clear"></div>
</div>

<h2><?php echo __('Rules of the Game', null, 'promo') ?></h2>
<ul class="promo_content_desc">
	<li><?php echo __('On 30 July a man and a woman will win FreshNewLook from ', null, 'promo').link_to('HILIFESALON', 'company',array('city'=>'sofia','slug'=>'hilifesalon_7025952')) ?></li>
	<li><?php echo link_to(__('Register', null, 'promo'), '@user_register').__(' or ', null, 'promo').link_to(__('login', null, 'promo'), '@sf_guard_signin') ?></li>
	<li><?php echo __('Click on folding menu next to your name and choose <b>‘settings’</b>.', null, 'promo') ?></li>
	<li><?php echo __('Choose <b>‘photos’</b> and <b>‘upload photo’</b>.', null, 'promo') ?></li>
	<li><?php echo __('After upload, click on the green button <b>‘upload as profile picture’</b>.', null, 'promo') ?></li>
	<li><?php echo __('Congratulations, you’re now in the game!', null, 'promo') ?></li>
	<li><?php echo __('All winners will be randomly chosen.', null, 'promo') ?></li>
	<li><?php echo __('If you already have registration and a profile pic just upload a new one to participate.', null, 'promo') ?></li>
	<li><?php echo __('The photo could be of anything, except for images with obscene or pornographic content.', null, 'promo') ?></li>
	<li><?php echo sprintf(__('If you have questions ask us on %s or send us an email to %s', null, 'promo'), '<a target="_blank" href="http://www.facebook.com/getlokal">Facebook</a>', '<a href="mailto:info@getlokal.com">info@getlokal.com</a>') ?>
</ul>

<?php /* ?>
<ul class="category_menu category_menu_bottom">
<li><a href="<?php echo url_for('@sector?slug='. Doctrine::getTable('Sector')->find('8')->getSlug(). '&city='. $sf_user->getCity()->getSlug())."#eatingOut" ?>"><span><?php echo __('Eating Out', null, 'promo') ?></span></a></li>
</ul>
<?php */ ?>
<div class="clear"></div>

<ul class="promo_logo">
	<li><?php echo link_to(__('Register', null, 'promo'), '@user_register', array('class'=>'button_blue')) ?></li>
	<!-- <li><a href="#"><img src="/images/promo/logo.png"></img></a></li>
				<li><a href="#"><img src="/images/promo/logo.png"></img></a></li>
				<li><a href="#"><img src="/images/promo/logo.png"></img></a></li>
				 -->
</ul>
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
		$(".header").css("marginBottom", "0px");
		$(".header").css("boxShadow", "none");

		$(".category_menu li a").mouseover(function() {
			$(this).parent().parent().css('border', '5px solid #FF004E');
		});

		$(".category_menu li a").mouseleave(function() {
			$(this).parent().parent().css('border', '5px solid #FFD200');
		});
	});
</script>
