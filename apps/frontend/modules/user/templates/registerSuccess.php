<?php include_partial('global/commonSlider'); ?>
<?php  slot('facebook') ?>
<?php slot('no_map', true) ?>
<meta property="fb:app_id" content="289748011093022"/>
<meta property="og:type" content="website" /> 
<meta property="og:title" content="<?php echo __('Discover getlokal!', null, 'user'); ?>" />
<meta property="og:image" content="<?php echo public_path('/images/gui/getlokal_thumbnail_200x200.jpg', true); ?>" />
<meta property="og:description" content="<?php echo __('Join me on getlokal and discover what other people like you and I think about restaurants, pubs, cafes and other interesting places in their local area.', null, 'user') ?>" />
<meta property="og:site_name" content="<?php echo $sf_request->getHost() ?>" />
<meta property="og:url" content="<?php echo url_for('user/register', true); ?>" />
<?php end_slot() ?>
<?php slot('no_ads', true) ?>
<div class="container set-over-slider">
		<div class="row">	
			<div class="container">
				<div class="row">
					<h1 class="col-xs-12 main-form-title"><?php echo __('Register'); ?></h1>
				</div>
			</div>	          
		</div>
		<form action="<?php echo url_for('user/register') ?>" method="post" class="default-form clearfix">
	    	<div class="row">
				<div class="default-container default-form-wrapper col-sm-12">	
		        	<?php if($form['underage']->hasError() || $form['accept']->hasError()):?>
					<div class="form-message error error-message-top">
						<?php echo $form['underage']->renderError();?>
						<?php echo $form['accept']->renderError();?>
					</div>
					<?php endif;?>
		        
		            <?php echo $form[$form->getCSRFFieldName()]; ?>
		            
		            <div class="row">
						<div class="col-sm-6">
							<div class="default-input-wrapper required <?php if( $form['sf_guard_user']['first_name']->hasError()):?> incorrect<?php endif;?>">
								<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
								<div class="error-txt">
								<?php if($form['sf_guard_user']['first_name']->hasError()):?>
						        	<?php echo $form['sf_guard_user']['first_name']->renderError();?>
								<?php endif;?>
								</div>
								<label for="<?= $form['sf_guard_user']['first_name']->getName()?>" class="default-label"><?= __('Name', null, 'user')?></label>
								<?php echo $form['sf_guard_user']['first_name']->render(array('class' => 'default-input','placeholder' => __('Name', null, 'user')));?>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="default-input-wrapper required <?php if( $form['sf_guard_user']['last_name']->hasError()):?> incorrect<?php endif;?>">
								<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
								<div class="error-txt">
								<?php if($form['sf_guard_user']['last_name']->hasError()):?>
						        	<?php echo $form['sf_guard_user']['last_name']->renderError();?>
								<?php endif;?>
								</div>
								<label for="<?= $form['sf_guard_user']['last_name']->getName()?>" class="default-label"><?= __('Surname', null, 'user')?></label>
								<?php echo $form['sf_guard_user']['last_name']->render(array('class' => 'default-input','placeholder' => __('Surname', null, 'user')));?>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-6">
							<div class="default-input-wrapper required <?php if( $form['sf_guard_user']['email_address']->hasError()):?> incorrect<?php endif;?>">
								<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
								<div class="error-txt">
								<?php if($form['sf_guard_user']['email_address']->hasError()):?>
						        	<?php echo $form['sf_guard_user']['email_address']->renderError();?>
								<?php endif;?>
								</div>
								<label for="<?= $form['sf_guard_user']['email_address']->getName()?>" class="default-label"><?= __('Email', null, 'user')?></label>
								<?php echo $form['sf_guard_user']['email_address']->render(array('class' => 'default-input','placeholder' => __('Email', null, 'user')));?>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="default-input-wrapper required <?php if( $form['sf_guard_user']['password']->hasError()):?> incorrect<?php endif;?>">
								<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
								<div class="error-txt">
								<?php if($form['sf_guard_user']['password']->hasError()):?>
						        	<?php echo $form['sf_guard_user']['password']->renderError();?>
								<?php endif;?>
								</div>
								<label for="<?= $form['sf_guard_user']['password']->getName()?>" class="default-label"><?= __('Password', null, 'user')?></label>
								<?php echo $form['sf_guard_user']['password']->render(array('class' => 'default-input','placeholder' => __('Password', null, 'user')));?>
							</div>
						</div>
					</div>
		
		            <?php if (isset($form['gender'])) : ?>
		                <div class="form_box<?php if ($form['gender']->hasError()): ?> error<?php endif; ?>">
		                    <label><?php echo __('Gender', null, 'user') ?><span class="pink">*</span>:</label>
		                    <?php echo $form['gender']->render(); ?>
		                    <?php if ($form['gender']->hasError()): ?>
		                        <p class="error"><?php echo $form['gender']->renderError(); ?></p>
		                    <?php endif; ?>
		                </div>
		            <?php endif; ?>
		            
		            <div class="row">
						<div class="col-sm-6">
							<div class="default-input-wrapper required<?php if($form['country_id']->hasError()):?> incorrect<?php endif;?>">
								<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
								<?php if($form['country_id']->hasError()):?>
								<div class="error-txt">
									<?php echo $form['country_id']->renderError();?>
								</div>
								<?php endif;?>
								<label for="<?= $form['country_id']->getName()?>" class="default-label"><?php echo __('Country',null,'user')?>
								</label>
								<?php echo $form['country_id']->render(array('class'=>'default-input','placeholder'=>__('Country',null,'user')));?>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="default-input-wrapper required<?php if($form['city_id']->hasError()):?> incorrect<?php endif;?>">
								<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
								<?php if($form['city_id']->hasError()):?>
								<div class="error-txt">
									<?php echo $form['city_id']->renderError();?>
								</div>
								<?php endif;?>
								<label for="<?= $form['city_id']->getName()?>" class="default-label"><?php echo __('Location',null,'user')?>
								</label>
								<?php echo $form['city_id']->render(array('class'=>'default-input','placeholder'=>__('Location',null,'user')));?>
							</div>
						</div>
					</div>
					
					<div class="custom-row">
						<div class="default-checkbox">
							<?= $form['accept']->render(array('class' => 'input_check', 'id' => 'accept'));?>
							<div class="fake-box"></div>
						</div>
						<label for="accept" class="default-checkbox-label">
							<?= sprintf(__('I agree with the %s and the %s'),  link_to(__('Terms of Use'), '@static_page?slug=terms-of-use',array('popup'=>true,'class' => 'default-form-link') ), link_to(__('Policy for Use and Protection of the Information on the Getlokal Website'),  '@static_page?slug=privacy-policy',array('popup'=>true,'class' => 'default-form-link')));?>
						</label>
					</div>
				
					<div class="custom-row">
						<div class="default-checkbox">
							<?= $form['allow_contact']->render(array('class' => 'input_check', 'id' => 'allow_contact'));?>
							<div class="fake-box"></div>
						</div>
						<label for="allow_contact" class="default-checkbox-label">
							<?= __('I agree to receive messages from getlokal and/or their partners.',null,'user');?>
						</label>
					</div>
					
					<?php if (isset($formRegister['underage'])) : ?>
					<?php echo __('If you are underage person, your parent/trustee must also declare his/her consent below');?>
				
					<div class="custom-row">
						<div class="default-checkbox">
							<?= $formRegister['underage']->render(array('class' => 'input_check'));?>
							<div class="fake-box"></div>
						</div>
						<label for="<?= $formRegister['underage']->getName()?>" class="default-checkbox-label"> 
							<?= sprintf(__('In my capacity as parent/trustee I hereby declare that I agree with the %s and the %s'),  link_to(__('Terms of Use'), '@static_page?slug=terms-of-use',array('popup'=>true) ), link_to (__('Policy for Use and Protection of the Information on the Getlokal Website'), '@static_page?slug=privacy-policy',array('popup'=>true)))?>
						</label>
						
					</div>
					<?php endif; ?>
					
					<div class="form_box">
						<input type="submit" value="<?php echo __('Register')?>" class="default-btn success" />
					</div>
				</div>
			</div>
	        </form>
	        
</div>


<style>
	.error-message-top li{
		float: none !important;
	}
</style>