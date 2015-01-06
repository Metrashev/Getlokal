<?php include_partial('global/commonSlider'); ?>
<?php slot('no_ads', true) ?>
<div class="container set-over-slider">
	<div class="row">	
		<div class="container">
			<div class="row">
				<h1 class="col-xs-12 main-form-title"><?php echo __('Forgotten Password'); ?></h1>
			</div>
		</div>	          
	</div>
	<form action="<?php echo url_for('@sf_guard_password') ?>" method="post" >
		<div class="row">
			<div class="default-container default-form-wrapper col-sm-12">
				<div class="form-container login container">

					<?php echo $form[$form->getCSRFFieldName()]; ?>
					<div class="row margin-bottom-small">
						<div class="col-sm-12">
							<div class="default-input-wrapper required <?=$form['email']->hasError() ? 'incorrect' : ''?>">
								<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
								<div class="error-txt"><?=($form['email']->hasError() ? $form['email']->renderError() : '')?></div>
								<?php echo $form['email']->renderLabel(null, array('for' => 'email', 'class' => 'default-label'))?>
								<?php echo $form['email']->render(array('placeholder' => $form['email']->renderPlaceholder(), 'id' => 'email', 'class' => 'default-input' ));  ?>
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
					<div class="row margin-bottom-small">
						<div class="col-sm-6">							
							<input type="submit" class="default-btn success pull-left" value="<?php echo __('Send');?>" />
						</div>
					</div>
					
					<?php if($show_reslend_activation || 1){?>
					<div class="row margin-bottom-small">
						<div class="col-sm-4">
							<div class="default-input-wrapper">
								
							</div>
						</div>
					</div>
					<?php }?>

				</div>
			</div>
		</div>
	</form>
				
</div>
