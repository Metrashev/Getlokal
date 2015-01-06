<?php if($sf_user->hasFlash('notice')): ?>
<div class="report_success">
	<?php echo __($sf_user->getFlash('notice')) ?>
</div>
<?php else :?>
<a id="email_form_close" class="email-form-close-btn" href="javascript:void(0);">
	<img src="/images/gui/close_small.png" /> 
</a>
<div>
	<h2 class="send-email-company-header">
		<?php echo sprintf(__('<span class="send-mail-to-company-span">Send email to</span> %s', null, 'company'), $company->getCompanyTitle());?>
	</h2>
	<form action="<?php echo url_for('company/sendMailTo?slug='.$company->getSlug()) ?>"
		method="POST" class="default-form">
		<div class="row">
			<div class="col-sm-12">
				<div class="default-input-wrapper required<?php if($form['email']->hasError()):?> incorrect<?php endif;?>">
					<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
					<?php if($form['email']->hasError()):?>
					<div class="error-txt">
						<?php echo $form['email']->renderError();?>
					</div>
					<?php endif;?>
					<label for="<?= $form['email']->getName()?>" class="default-label"><?php echo __('Your e-mail:',null,'contact')?>
					</label>
					<?php echo $form['email']->render(array('class'=>'default-input','placeholder'=>__('Your e-mail:',null,'contact')));?>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="default-input-wrapper required<?php if($form['name']->hasError()):?> incorrect<?php endif;?>">
					<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
					<?php if($form['name']->hasError()):?>
					<div class="error-txt">
						<?php echo $form['name']->renderError();?>
					</div>
					<?php endif;?>
					<label for="<?= $form['name']->getName()?>" class="default-label"><?php echo __('Your name:',null,'contact')?>
					</label>
					<?php echo $form['name']->render(array('class'=>'default-input','placeholder'=>__('Your name:',null,'contact')));?>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="default-input-wrapper<?php if($form['phone']->hasError()):?> incorrect<?php endif;?>">
					<?php if($form['phone']->hasError()):?>
					<div class="error-txt">
						<?php echo $form['phone']->renderError();?>
					</div>
					<?php endif;?>
					<label for="<?= $form['phone']->getName()?>" class="default-label"><?php echo __('Your phone:',null,'contact')?>
					</label>
					<?php echo $form['phone']->render(array('class'=>'default-input','placeholder'=>__('Your phone:',null,'contact')));?>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="default-input-wrapper required<?php if($form['message']->hasError()):?> incorrect<?php endif;?>">
					<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
					<?php if($form['message']->hasError()):?>
					<div class="error-txt">
						<?php echo $form['message']->renderError();?>
					</div>
					<?php endif;?>
					<label for="<?= $form['message']->getName()?>" class="default-label"><?php echo __('Your message:',null,'contact')?>
					</label>
					<?php echo $form['message']->render(array('class'=>'default-input','placeholder'=>__('Your message:',null,'contact')));?>
				</div>
			</div>
		</div>
		<?php if (sfConfig::get('app_recaptcha_active', false)): ?>
		<div class="row">
			<div class="col-sm-12">
				<div class="default-input-wrapper<?php if($form['captcha']->hasError()):?> incorrect<?php endif;?>">
					<?php if($form['captcha']->hasError()):?>
					<div class="error-txt">
						<?php echo $form['captcha']->renderError();?>
					</div>
					<?php endif;?>
					<label for="<?= $form['captcha']->getName()?>" class="default-label"><?php echo __('Your message:',null,'contact')?>
					</label>
					<?php echo $form['captcha']->render();?>
				</div>
			</div>
		</div>
		<?php endif;?>
		<div class="clear"></div>

		<div class="form_box">
			<input type="submit" value="<?php echo __('Send'); ?>"
				class="input_submit default-btn success pull-right" />
		</div>
	</form>
	<div class="clear"></div>
</div>
<?php endif;?>
