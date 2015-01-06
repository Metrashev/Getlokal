<div class="promo_wrap">
	<div class="promo_header_wrap"><?php $culture= $sf_user->getCulture();?>
		<img src="/images/promo/ambassador/header_<?php echo $sf_user->getCulture()?>.png"></img> 
	</div>	
	<h1><?php echo __('Become getlokal Ambassador in your Town', null, 'ambassador'); ?></h1>
	<p><?php echo __('getlokal is more and more popular and we want to make it more useful, complete and interesting to everyone. We are looking for the most active people in your town to help us achieve this, and we want to reward you for helping us!', null, 'ambassador'); ?></p>
	<div class="promo_left_wrap">
		<h2><?php echo __('If YOU:', null, 'ambassador'); ?></h2>
		<ul>
			<li><?php echo __('Love your city and know all the cool places', null, 'ambassador'); ?></li>
			<li><?php echo __('Want others to appreciate your beautiful town', null, 'ambassador'); ?></li>
			<li><?php echo __('Are the one everyone turns to for recommendations for  the best restaurant, shop, hairdresser and the most popular club', null, 'ambassador'); ?></li>
			<li><?php echo __('Love being online and staying informed about all important topics', null, 'ambassador'); ?></li>
			<li><?php echo __('Enjoy yourself while working', null, 'ambassador'); ?></li>
		</ul>
		<div class="box_shadow">
			<h2><?php echo __('Then you are like us!', null, 'ambassador'); ?></h2>
			<p><?php echo sprintf(__('If you would like to be part of the success of getlokal.com and to work for your town, %s!', null, 'ambassador'), '<strong>'.__('take part in our getlokal Ambassador challenge', null, 'ambassador').'</strong>'); ?></p>
		</div>
	</div>
	<div class="promo_right_wrap">
		<h2><?php echo __('It’s simple!', null, 'ambassador'); ?></h2>
		<div class="promo_preview promo_preview_reg">
			<h3><?php echo __('Create a profile on getlokal', null, 'ambassador'); ?></h3>
			<?php echo link_to('getlokal.com/'.$sf_user->getCulture().'/register', '@user_register', array('target'=>'blank')); ?>
		</div>
		<div class="promo_preview promo_preview_search">
			<h3><?php echo __('Upload content', null, 'ambassador'); ?></h3>
			<p class="pink"><?php echo __('pictures, new places, reviews, lists – the more, the better!', null, 'ambassador'); ?></p>
		</div>
		<div class="promo_preview promo_preview_help">
			<h3><?php echo __('Send us an email', null, 'ambassador'); ?></h3>
			<p class="pink"><?php echo __('with your user name and the reason why you would like to become an Ambassador', null, 'ambassador'); ?></p>
			<?php echo link_to('емайл', 'contact/getlokal', array('target'=>'_blank', 'class'=> 'send_button', 'title' => __('Contact Us')));?>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() { 
	$('.path_wrap').remove();
	$('.search_bar').remove();
	$('.content_footer').remove();
	$('.header').css('marginBottom', '0');
});
</script>