<div class="promo_wrap">
	<h2><span></span><?php echo __('Congratulations! Thank you for adding a place!') ?></h2>
</div>	

	<p><?php echo __('The place you suggested was added to getlokal. It will be checked by a member of the getlokal team to ensure we have the right details. Meanwhile continue playing! Every new place you add increase your chances to win brand new SUPRA sneakers and the New iPad!');?>
	</p>
	<?php echo link_to(__('Back to getlokal', null, 'addPlacePage'), '@homepage', array('class'=>'button_pink button_promo_back')) ?>
	<?php echo link_to(__('Play again', null, 'addPlacePage'), '@promo_add_place', array('class'=>'button_green button_promo_play')) ?>
	<img class="button_promo_back" src="/images/promo/ipad_300x300.png" />
	<img class="button_promo_play" src="/images/promo/blokshop_logo_big.png" />
<script type="text/javascript">
  $(document).ready(function() {
	  $('.search_bar').css('display', 'none');
	  $('.banner').css('display', 'none');
	  <?php if($sf_user->getCulture() == 'en'): ?> 
		$(".path_wrap").replaceWith('<div class="promo_header_wrap"><img src="/images/promo/header_new_en.png"></div>');
	  <?php else: ?>
		$(".path_wrap").replaceWith('<div class="promo_header_wrap"><img src="/images/promo/header_new.png"></div>');
	  <?php endif;?>
	
  });
</script>