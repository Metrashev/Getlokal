<div class="settings_user_company_form">
<?php echo $form->renderGlobalErrors();?>

	<form method="post" action="<?php echo url_for('userSettings/registerPageAdmin?slug='.$form->getObject()->getCompanyPage()->getCompany()->getSlug().'&id='.$form->getObject()->getId() )?>" >
	<?php echo $form['_csrf_token']->render() ?>

	<h2 class="form-title"><?php echo __('Create Username and Password'); ?></h2>

	 <div class="row">
	 	<div class="default-container default-form-wrapper col-sm-12">

			<div class="form-container login container">
				<div class="row margin-bottom-small">
					<div class="col-sm-12">
						<div class="default-input-wrapper required <?php if( $form['username']->hasError()):?> incorrect<?php endif;?>">
							<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
							<div class="error-txt">
							<?php if($form['username']->hasError()):?>
					        	<?php echo $form['username']->renderError();?>
							<?php endif;?>
							</div>
							<label for="<?= $form['username']->getName()?>" class="default-label"><i class="fa fa-user"></i><?= __('Username', null, 'form')?></label>
							<?php echo $form['username']->render(array('class' => 'default-input','placeholder' => __('Username', null, 'form'))); ?>					
						</div>
					</div>
				</div>

				<div class="row margin-bottom-small">
					<div class="col-sm-12">
						<div class="default-input-wrapper required <?php if( $form['password']->hasError()):?> incorrect<?php endif;?>">
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

				<?php if (!$form->getObject()->getUserProfile()->getGender()):?>
					<div class="row margin-bottom-small">
						<div class="col-sm-12">
							<div class="default-input-wrapper <?php if( $form['user_profile']['gender']->hasError()):?> incorrect<?php endif;?>">
								<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
								<div class="error-txt">
								<?php if($form['user_profile']['gender']->hasError()):?>
						        	<?php echo $form['user_profile']['gender']->renderError();?>
								<?php endif;?>
								</div>
								<label for="<?= $form['user_profile']['gender']->getName()?>" class="default-label"><i class="fa fa-lock"></i><?= __('Gender', null, 'form')?></label>
								<?php echo $form['user_profile']['gender']->render(array('class' => 'default-input','placeholder' => __('Gender', null, 'form')));?>
							</div>
						</div>
					</div>
				<?php endif;?>

				<?php if (!$form->getObject()->getUserProfile()->getPhoneNumber()):?>
					<div class="row margin-bottom-small">
						<div class="col-sm-12">
							<div class="default-input-wrapper <?php if( $form['user_profile']['phone_number']->hasError()):?> incorrect<?php endif;?>">
								<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
								<div class="error-txt">
								<?php if($form['user_profile']['phone_number']->hasError()):?>
						        	<?php echo $form['user_profile']['phone_number']->renderError();?>
								<?php endif;?>
								</div>
								<label for="<?= $form['user_profile']['phone_number']->getName()?>" class="default-label"><i class="fa fa-lock"></i><?= __('Phone', null, 'form')?></label>
								<?php echo $form['user_profile']['phone_number']->render(array('class' => 'default-input','placeholder' => __('Phone', null, 'form')));?>
							</div>
						</div>
					</div>
				<?php endif;?>

				<?php if (!$form->getObject()->getPosition()):?>
					<div class="row margin-bottom-small">
						<div class="col-sm-12">
							<div class="default-input-wrapper <?php if( $form['position']->hasError()):?> incorrect<?php endif;?>">
								<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
								<div class="error-txt">
								<?php if($form['position']->hasError()):?>
						        	<?php echo $form['position']->renderError();?>
								<?php endif;?>
								</div>
								<label for="<?= $form['position']->getName()?>" class="default-label"><i class="fa fa-lock"></i><?= __('Position', null, 'company')?></label>
								<?php echo $form['position']->render(array('class' => 'default-input','placeholder' => __('Position', null, 'company')));?>
							</div>
						</div>
					</div>
				<?php endif;?>

				<?php if (isset($form['allow_b_cmc'])):?>
					<div class="custom-row">
						<div class="default-checkbox">
							<?= $form['allow_b_cmc']->render(array('class' => 'input_check', 'id' => 'allow_b_cmc'));?>
							<div class="fake-box"></div>
						</div>
						<label for="allow_b_cmc" class="default-checkbox-label">
							<?php echo __('I would like to receive getlokal\'s Business Newsletter and Notifications.', null,'user'); ?>
						</label>
					</div>
				<?php endif;?>

				<?php if (isset($form['accept'])):?>
					<div class="custom-row">
						<div class="default-checkbox">
							<?= $form['accept']->render(array('class' => 'input_check', 'id' => 'accept'));?>
							<div class="fake-box"></div>
						</div>
						<label for="accept" class="default-checkbox-label">
							<?= sprintf(__('I agree with the %s and the %s'),  link_to(__('Terms of Use'), '@static_page?slug=terms-of-use',array('popup'=>true,'class' => 'default-form-link') ), link_to(__('Policy for Use and Protection of the Information on the Getlokal Website'),  '@static_page?slug=privacy-policy',array('popup'=>true,'class' => 'default-form-link')));?>
						</label>
					</div>
				<?php endif;?>

				<div class="row margin-bottom-small text-center">
					<input type="submit"  class="default-btn success pull-left" value="<?php echo __('Save');?>" />
				</div>
			</div>
		
		</div>
	</div>
	</form>

</div>