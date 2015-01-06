<?php use_helper('I18N') ?>
<form action="<?php echo url_for('user/signin') ?>" method="post" class="login_form default-form clearfix">
 <div class="row">
  <div class="default-container default-form-wrapper col-sm-12">	
	<div class="row">
		<div class="col-sm-12">		
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
		</div>
	</div>

	<div class="form-container login container">
		<div class="row margin-bottom-small">
			<div class="col-sm-12">
				<div class="default-input-wrapper <?php if( $form['username']->hasError()):?> incorrect<?php endif;?>">
					<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
					<div class="error-txt">
					<?php if($form['username']->hasError()):?>
			        	<?php echo $form['username']->renderError();?>
					<?php endif;?>
					</div>
					<label for="<?= $form['username']->getName()?>" class="default-label"><i class="fa fa-user"></i><?= __('E-mail')?></label>
					<?php echo $form['username']->render(array('class' => 'default-input','placeholder' => __('E-mail')));?>
				</div>
			</div>
		</div>
		
		<div class="row margin-bottom-small">
			<div class="col-sm-12">
				<div class="default-input-wrapper <?php if( $form['password']->hasError()):?> incorrect<?php endif;?>">
					<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
					<div class="error-txt">
					<?php if($form['password']->hasError()):?>
			        	<?php echo $form['password']->renderError();?>
					<?php endif;?>
					</div>
					<label for="<?= $form['password']->getName()?>" class="default-label"><i class="fa fa-lock"></i><?= __('Password', null, 'form')?></label>
					<?php echo $form['password']->render(array('class' => 'default-input','placeholder' => __('Password', null, 'form')));?>
				</div>
			</div>
		</div>
		<div class="row margin-bottom-small">
			<div class="col-sm-12">
				<div class="pull-left">
					<div class="default-checkbox">
						<?= $form['remember']->render(array('class' => 'input_check', 'id' => $form["remember"]->getName()));?>
						<div class="fake-box"></div>
					</div>
					<label for="<?= $form['remember']->getName()?>" class="default-checkbox-label">
						<?php echo $form['remember']->renderLabelName();?>
					</label>
				</div><!-- Form Checkbox -->

				<div class="pull-right">					
					<?php echo link_to(__('Forgot Password?', null,'user'),'@sf_guard_password', array('class' => 'forgot-password default-form-link'))?>
				</div>

			</div>
		</div>
		
		<div class="row margin-bottom-small">
			<div class="col-sm-12">
				<input type="submit"  class="default-btn success pull-left" value="<?php echo __('Sign in',null, 'user');?>" />
				<a href="<?php echo url_for('user/FBLogin')?>" title="Facebook Connect" class="facebook_register default-btn fb  pull-right">
					<?php echo __('Sign in via Facebook', null, 'user');?>
				</a>
			</div>
		</div>
		<div class="row margin-bottom-small text-center">
				<?php echo __("Don't have an account?", null, 'form'); ?>
				<?php echo link_to (__('Sign Up', null,'user'), '@user_register', array('class' => 'default-form-link')) ?>
		</div>
	</div>



<!-- 
	<div class="facebook_wrap facebook_wrap_big">
        <div class="facebok_content">
            <div>
                <label><?php echo __('You can use your', null, 'user') ?></label>
                <label><b><?php echo __('Facebook account to log in', null, 'user') ?></b></label>
                <label><strong><?php echo __('in getlokal.com', null, 'user') ?></strong></label>
            </div>
            <label><a href="<?php echo url_for('user/FBLogin') ?>" title="Facebook Connect" class="default-btn fb">Facebook Connect</a></label>
        </div>
    </div> -->
	
  </div>
 </div>
</form>