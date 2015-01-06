<form action="<?php echo url_for('user/resendActivationEmail')?>" method="POST" >
	<?php echo $form[$form->getCSRFFieldName()] ?>
	<?php echo $form->renderGlobalErrors() ?>
	<div class="form_box">
		<?php echo $form['email']->renderLabel();?>
		<?php echo $form['email'];?>
		<?php echo $form['email']->renderError();?>
	</div>
	<?php if (sfConfig::get('app_recaptcha_active', false)): ?>
		<div class="form_box captcha_out">
			<?php echo $form['captcha']->renderLabel(); ?>
			<?php echo $form['captcha']->render(); ?>
			<?php echo $form['captcha']->renderError() ?>
		</div>
	<?php endif;?>
	
	<div class="form_box">                 
		<input type="submit" class="button_green" value="<?php echo __('Send');?>" />
	</div>
</from>
<div class="login_more"><?php echo link_to(__('Forgot Password?', null,'user'),'@sf_guard_password')?></div>
