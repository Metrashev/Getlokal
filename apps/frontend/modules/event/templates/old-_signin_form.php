<?php use_helper('I18N') ?>
<form id="create_event" action="<?php echo url_for('user/signin') ?>" method="post" class="login_form">
	<?php echo $form[$form->getCSRFFieldName()] ?>
	<?php /* ?>
	<div id="fb_connect_login">
		<a href="<?php url_for('user/FBLogin')?>" title="<?php echo __('Facebook Connect') ?>"><img src="/images/gui/fb_light_medium_short.gif" alt="<?php echo __('Facebook Connect') ?>" /></a>
	</div>
	<?php */ ?>
	<div class="form_box<?php if( $form['username']->hasError()):?> error<?php endif;?>">
    	<?php echo $form['username']->renderLabel();?>
        <?php echo $form['username']->render();?>
        <?php if($form['username']->hasError()):?>
        	<p class="error"><?php echo $form['username']->renderError();?></p>
		<?php endif;?>
	</div>
	<div class="form_box<?php if( $form['password']->hasError()):?> error<?php endif;?>">
		<?php echo $form['password']->renderLabel();?>
		<?php echo $form['password']->render();?>
		<?php if($form['password']->hasError()):?>
			<p class="error"><?php echo $form['password']->renderError();?></p>
		<?php endif;?>
	</div>
	<div class="form_box form_label_inline">
		<?php echo $form['remember']->render();?>
		<?php echo $form['remember']->renderLabel();?>
	</div>
	<div class="form_box">  
		<input type="submit" class="button_green" value="<?php echo __('Login');?>" />
		<a href="<?php echo url_for('user/FBLogin')?>" title="Facebook Connect" class="facebook_register">Connect</a>
	</div>
</form>
<div class="login_more"><?php echo link_to (__('Sign Up', null,'user'), 'user/register') ?> | <?php echo link_to(__('Forgot Password?', null,'user'),'user/forgotPassword')?></div>
<script type="text/javascript">
$(document).ready(function() {
	$('#create_event').submit(function() {
		$.ajax({
			url: '<?php echo url_for("event/redirectAfterLogin") ?>',
			//data: {'listPageId': listPageId},
			success: function(url) {
		    },
		    error: function(e, xhr)
		    {
		        console.log(xhr);
		    }
		});
	});
})
</script>