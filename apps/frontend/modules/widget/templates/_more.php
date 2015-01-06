<div class="more">
	<?php if($sf_user->getCountry()->getSlug() == 'bg'){ ?>
		<a href="<?php echo $link; ?>" target="_blank"><span><?php echo __('Write a Review', null, 'company'); ?></span></a>
	<?php } else{ ?>
		<a href="<?php echo $link; ?>" target="_blank"><span><?php echo __('more') ?></span></a>
	<?php } ?>
</div>
