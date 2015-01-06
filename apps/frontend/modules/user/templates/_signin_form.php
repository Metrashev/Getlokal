<?php use_helper('I18N') ?>
<form action="<?php echo url_for('user/signin') ?>" method="post" class="login_form" data-parsley-validate>

	<div class="form-head">
		<h3><?php echo __('LOG IN', null, 'form'); ?><i class="ico-form-close"></i></h3>
	</div><!-- form-head -->

	<?php if (isset($publish_item)): ?>
		<h3><?php printf(__('If you want to add %s, please log into your getlokal profile.'), $publish_item); ?></h3>
	<?php endif; ?>
	<?php if (isset($title_message)): ?>
		<h3><?php echo $title_message; ?></h3>
	<?php endif; ?>
	<?php if (isset($localReferer)): ?>
		<input type="hidden" name="local_referer" value="<?php echo $localReferer; ?>">
	<?php endif ?>
	<?php echo $form[$form->getCSRFFieldName()] ?>
	<?php /* ?>
	<div id="fb_connect_login">
		<a href="<?php url_for('user/FBLogin')?>" title="<?php echo __('Facebook Connect') ?>"><img src="/images/gui/fb_light_medium_short.gif" alt="<?php echo __('Facebook Connect') ?>" /></a>
	</div>
	<?php */ ?>

	<div class="form-body">
		<div class="form-row">
			<div class="form-controls form_box<?php if( $form['username']->hasError()):?> error<?php endif;?>">
				<i class="fa fa-user"></i>
		    	<?php //echo $form['username']->renderLabel();?>
		    	<div class="input-label-holder">
		    		<label id="usernamelabel">
		    			<span class="original-value"><?php echo __('E-mail'); ?></span>
		    		</label>
			        <?php echo $form['username']->render(array('class' => 'field floatlabel username', 'id' => 'account', 'placeholder' => __('E-mail'), 'data-parsley-required-message' => __('The field is required', null, 'form'), 'data-parsley-required'=>'true', 'data-parsley-errors-container'=>'#usernamelabel'));?>
			        <?php if($form['username']->hasError()):?>
			        	<p class="error"><?php echo $form['username']->renderError();?></p>
					<?php endif;?>
				</div>
			</div>
		</div>

		<div class="form-row">
			<div class="form-controls form_box<?php if( $form['password']->hasError()):?> error<?php endif;?>">
				<i class="fa fa-lock"></i>
				<?php //echo $form['password']->renderLabel();?>
				<div class="input-label-holder">
		    		<label id="passwordlabel">
		    			<span class="original-value"><?php echo __('Password', null, 'form'); ?></span>
		    		</label>
					<?php echo $form['password']->render(array('class' => 'field floatlabel password', 'id' => 'password', 'placeholder' => __('Password', null, 'form'), 'data-parsley-required-message' => __('The field is required', null, 'form'), 'data-parsley-required'=>'true', 'data-parsley-errors-container'=>'#passwordlabel'));?>
					<?php if($form['password']->hasError()):?>
						<p class="error"><?php echo $form['password']->renderError();?></p>
					<?php endif;?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="checkbox form_box form_label_inline">
					<?php echo $form['remember']->render(array('class' => 'field', 'id' => 'checkbox'));?>
					<?php echo $form['remember']->renderLabel(null, array('for' => 'checkbox'));?>
			</div>

			<div class="form-row">
				<label for="#">
					<?php echo link_to(__('Forgot Password?', null,'user'),'@sf_guard_password', array('class' => 'forgot-password'))?>
				</label>
				<div class="form-controls"></div><!-- form-controls -->
			</div><!-- form-row -->
		</div><!-- form-group -->
	</div><!-- form-body -->

	<div class="form-foot">
		<div class="form-actions">
			<input type="submit" class="form-btn" value="<?php echo __('Sign in',null, 'user');?>" />
			<a href="<?php echo url_for('user/FBLogin')?>" title="Facebook Connect" class="facebook_register form-btn-facebook"><?php echo __('Sign in via Facebook', null, 'user');?></a>
			<p>
				<?php echo __("Don't have an account?", null, 'form'); ?>
				<?php echo link_to (__('Sign Up', null,'user'), '@user_register') ?>
			</p>
		</div><!-- form-actions -->
	</div><!-- form-foot -->
</form>