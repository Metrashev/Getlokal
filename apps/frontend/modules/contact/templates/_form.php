<div class="row">
	<div class="default-container default-form-wrapper col-sm-12 p-20">
		<div class="row">
			<div class="col-sm-6">
        <?php if ($sf_user->getFlash('newerror')) { ?>
        	<div class="form-message error">
        		<p><?php echo __($sf_user->getFlash('error'), null, 'contact'); ?></p>
        	</div>
        <?php } ?>
        <?php if ($sf_user->getFlash('notice')): ?> 
        	<div class="form-message success">
            	<p><?php echo __($sf_user->getFlash('notice'), null, 'contact') ?></p>
            </div> 
        <?php endif; ?>
        
		<form class="offices_contact" action="<?php echo url_for('contact/getlokal') ?>" method="POST">
    		<div class="row">
        		<div class="col-sm-12 col-md-12 col-lg-12">
		        	<div class="default-input-wrapper required <?= $form['email']->hasError() ? 'incorrect' : ''; ?>">
		        		<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
		        		<?php if ($form['email']->hasError()) { ?>
		        			<div class="error-txt"><?= $form['email']->renderError(); ?></div>
		        		<?php } ?>
		        		<label for="name" class="default-label"><?= __('Your e-mail:', null, 'contact') ?></label>
		            	<?= $form['email']->render(array('placeholder' => __('Your e-mail:', null, 'contact'), 'class' => 'default-input')); ?>		            
		        	</div>
		    	</div>
			</div>
    
    		<div class="row">
        		<div class="col-sm-12 col-md-12 col-lg-12">
		    		<div class="default-input-wrapper required <?= $form['name']->hasError() ? 'incorrect' : ''; ?>">
	        			<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
	        			<?php if ($form['name']->hasError()) { ?>
	        				<div class="error-txt"><?= $form['name']->renderError(); ?></div>
	        			<?php } ?>
	        			<label for="name" class="default-label"><?= __('Your name:', null, 'contact') ?></label>
	            		<?= $form['name']->render(array('placeholder' => __('Your name:', null, 'contact'), 'class' => 'default-input')); ?>		            
	        		</div>
	    		</div>
			</div>
	
			<div class="row">
        		<div class="col-sm-12 col-md-12 col-lg-12">
		    		<div class="default-input-wrapper required <?= $form['phone']->hasError() ? 'incorrect' : ''; ?>">
	        			<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
	        			<?php if ($form['phone']->hasError()) { ?>
	        				<div class="error-txt"><?= $form['phone']->renderError(); ?></div>
	        			<?php } ?>
	        			<label for="name" class="default-label"><?= __('Your phone:', null, 'contact') ?></label>
	            		<?= $form['phone']->render(array('placeholder' => __('Your phone:', null, 'contact'), 'class' => 'default-input')); ?>		            
	        		</div>
	    		</div>
			</div>

			<div class="row">
        		<div class="col-sm-12 col-md-12 col-lg-12">
		    		<div class="default-input-wrapper required <?= $form['message']->hasError() ? 'incorrect' : ''; ?>">
	        			<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
	        			<?php if ($form['message']->hasError()) { ?>
	        			<div class="error-txt"><?= $form['message']->renderError(); ?></div>
	        			<?php } ?>
	        			<label for="name" class="default-label"><?= __('Your message:', null, 'contact') ?></label>
	            		<?= $form['message']->render(array('placeholder' => __('Your message:', null, 'contact'), 'class' => 'default-input')); ?>		            
	        		</div>
	    		</div>
			</div>


			<?php if (sfConfig::get('app_recaptcha_active', false)) { ?>
			<div class="row">
        		<div class="col-sm-12 col-md-12 col-lg-12">
		    		<div class="default-input-wrapper required <?= $form['captcha']->hasError() ? 'incorrect' : ''; ?>">
	        			<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
	        			<?php if ($form['captcha']->hasError()) { ?>
	        				<div class="error-txt"><?= $form['captcha']->renderError(); ?></div>
	        			<?php } ?>
	        			<label for="name" class="default-label"><?= __('Security check. Enter the characters from the picture below', null, 'form') ?></label>
	            		<?= $form['captcha']->render(array('class' => 'default-input')); ?>		            
	        		</div>
	    		</div>	    
			</div>
			<?php } ?>

			<input class="default-btn success pull-left " type="submit" value="<?= __('Send') ?>">
		</form>
		</div>
		<div class="col-sm-6">
				<div class="contact_map_wrap">
				<?php if (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_BG): ?>
				    <?php include_partial('contact/bulgaria'); ?>
				<?php elseif (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_RO): ?>
				    <?php include_partial('contact/romania'); ?>
				<?php elseif (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_MK): ?>
				    <?php include_partial('contact/macedonia'); ?>
				<?php elseif (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_RS): ?>
				    <?php include_partial('contact/serbia'); ?>
				<?php elseif (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_HU): ?>
				    <?php include_partial('contact/hungary'); ?>
				<?php elseif (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_FI): ?>
				    <?php include_partial('contact/finland'); ?>
				<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
    $('.close_mail_form').click(function(){
    $("html, body").animate({ scrollTop: 0 }, 600);
    return false;
 });
</script>

