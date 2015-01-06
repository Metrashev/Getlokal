<?php /*if($sf_user->hasFlash('notice')): ?>
	<div class="flash_success">
      <?php echo __($sf_user->getFlash('notice')) ?>
    </div>
<?php else :*/ ?>
<a id="email_form_close" href="#"><img src="/images/gui/close_small.png" alt="<?php echo __("close") ?>" /></a>
<div>
<h2><?php echo sprintf(__('send email to %s', null, 'company'), $company->getCompanyTitle());?></h2>
<form action="<?php echo url_for('company/sendMailTo?slug='.$company->getSlug()) ?>" method="POST">
				<div class="left" style="margin-right:25px;">
                    <div class="form_box<?php if($form['email']->hasError()):?> error<?php endif;?>">
                        <label><?php echo __('Your e-mail:',null,'contact')?><span class="pink">*</span></label>
                        <?php echo $form['email']->render();?>
                        <?php if($form['email']->hasError()):?>
                        <p class="error"><?php echo $form['email']->renderError();?></p>
                        <?php endif;?>
                    </div>
                    
                    <div class="form_box<?php if($form['name']->hasError()):?> error<?php endif;?>">
                        <label><?php echo __('Your name:',null,'contact')?><span class="pink">*</span></label>
                        <?php echo $form['name']->render();?>
                        <?php if($form['name']->hasError()):?>
                        <p class="error"><?php echo $form['name']->renderError();?></p>
                        <?php endif;?>
                    </div>
                    <div class="form_box<?php if($form['phone']->hasError()):?> error<?php endif;?>">
                        <label><?php echo __('Your phone:',null,'contact')?></label>
                        <?php echo $form['phone']->render();?>
                        <?php if($form['phone']->hasError()):?>
                        <p class="error"><?php echo $form['phone']->renderError();?></p>
                        <?php endif;?>
                    </div>
               	</div>
               	<div class="left">
                    <div class="form_box<?php if($form['message']->hasError()):?> error<?php endif;?>">
                        <label><?php echo __('Your message:',null,'contact')?></label>
                        <?php echo $form['message']->render();?>
                        <?php if($form['message']->hasError()):?>
                        <p class="error"><?php echo $form['message']->renderError();?></p>
                        <?php endif;?>
                    </div>
                    <?php if (sfConfig::get('app_recaptcha_active', false)): ?>
					<div class="form_box form_capture <?php if($form['captcha']->hasError()):?> error<?php endif;?>">
                        <?php echo $form['captcha']->renderLabel();?>
                        <?php echo $form['captcha']->render();?>
                        <?php if($form['captcha']->hasError()):?>
                        <p class="error"><?php echo $form['captcha']->renderError();?></p>
                        <?php endif;?>
                    </div>
  <?php endif;?>
                </div>
                <div class="clear"></div>
                
                    <div class="form_box">
                        <input type="submit" value="<?php echo __('Send'); ?>" class="input_submit" />
                    </div>
                </form>
                <div class="clear"></div>
</div>
<?php //endif;?>