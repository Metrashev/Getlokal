<?php slot('no_map');?> 
<?php include_partial('global/commonSlider'); ?>
<?php slot('no_ads', true) ?>
<div class="container set-over-slider">
	<div class="row">	
		<div class="container">
			<div class="row">
				<?php if (isset($company)):?>
					<?php $form_url = url_for('userSettings/forgotPassword?slug='.$company->getSlug());?>
					<h4 class="col-xs-12 main-form-title"><?php echo sprintf(__('Forgotten password for %s'), link_to_company($company, array('class' => 'default-link')));?></h4>
				<?php else: ?>
					<?php $form_url = url_for('userSettings/forgotPassword');?>
				<?php endif;?>
			</div>
		</div>	          
	</div>

	<form action="<?php echo $form_url; ?>" method="post" >
		<div class="row">
			<div class="default-container default-form-wrapper col-sm-12">
				<div class="form-container login container">

					<?php echo $form[$form->getCSRFFieldName()]; ?>
					<div class="row margin-bottom-small">
						<div class="col-sm-12">
							<div class="default-input-wrapper required <?=$form['username']->hasError() ? 'incorrect' : ''?>">
								<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
								<div class="error-txt"><?=($form['username']->hasError() ? $form['username']->renderError() : '')?></div>
								<?php echo $form['username']->renderLabel(null, array('for' => 'email', 'class' => 'default-label'))?>
								<?php echo $form['username']->render(array('placeholder' => $form['username']->renderPlaceholder(), 'id' => 'username', 'class' => 'default-input' ));  ?>
							</div>
						</div>
					</div>
					<?php if (sfConfig::get('app_recaptcha_active', false)){ ?>
						<div class="row margin-bottom-small">
							<div class="col-sm-12">
								<div class="default-input-wrapper required <?=$form['captcha']->hasError() ? 'incorrect' : ''?>">
									<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
									<div class="error-txt"><?=($form['captcha']->hasError() ? $form['captcha']->renderError() : '')?></div>
									<?php echo $form['captcha']->renderLabel(null, array('for' => 'captcha', 'class' => 'default-label'))?>
									<?php echo $form['captcha']->render(array('placeholder' => $form['captcha']->renderPlaceholder(), 'id' => 'captcha'));  ?>
								</div>
							</div>
						</div>
					<?php }?>
					<div class="row margin-bottom-small pull-right">
						<div class="col-sm-6">							
							<input type="submit" class="default-btn success pull-left" value="<?php echo __('Send');?>" />
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<?php if ($user && isset($company)): ?>
		                    	<?php $page_admin = $user->getPlaceAdmin($company); ?>
			                    <?php if ($page_admin): ?>
			                        <?php if ($page_admin->getUsername()): ?>
			                            <?php echo link_to(__('Send me my Username', null, 'user'), 'userSettings/sendMeMyAdminUsername?slug=' . $company->getSlug(), array('class' => 'button_pink')); ?>
			                            <?php // echo link_to(__('My Places', null, 'user'), 'userSettings/companySettings'); ?>
			                        <?php endif ?>
			                    <?php endif; ?>
		                	<?php endif; ?>
						</div>
					</div>

				</div>
			</div>
		</div>
	</form>
				
</div>

