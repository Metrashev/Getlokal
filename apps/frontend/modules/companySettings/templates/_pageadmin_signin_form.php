<?php 
	echo $form->renderGlobalErrors();
	if (isset($company) && $company){
		$url_form = url_for('companySettings/login?slug='.$company->getSlug());
	} else{
		$url_form = url_for('companySettings/login');
	}
?>

<form method="post" action="<?php echo $url_form; ?>" >
	<?php echo $form['_csrf_token']->render() ?>
	
  <div class="default-container default-form-wrapper col-sm-12">	

	<?php if(!isset($without_address_title) || !$without_address_title) if($company):?>
		<span><?php echo $company->getCompanyTitle(); ?></span>
		<p><?php echo $company->getDisplayAddress(); ?></p>
	<?php endif;?>

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
					<label for="<?= $form['username']->getName()?>" class="default-label"><i class="fa fa-user"></i><?= __('Username', null, 'form')?></label>
					<?php 
						if ((isset($user) && $user) &&(isset($company) && $company)){
							$user_company = $company->getPageAdminbyUserId($user->getId());
							if ($user_company && $user_company->getUsername()){
								echo $form['username']->render(array('value'=> $user_company->getUsername(), 'class' => 'default-input','placeholder' => __('Username', null, 'form')));
							} else{
								echo $form['username']->render(array('class' => 'default-input','placeholder' => __('Username', null, 'form')));
							}
						} else{
							echo $form['username']->render(array('class' => 'default-input','placeholder' => __('Username', null, 'form')));
						} 
					?>					
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
				<?php if(isset($company) && $company):?>			
					<?php echo link_to(__('Forgot Password?', null,'user'), 'userSettings/forgotPassword?slug='.$company->getSlug(), array('class' => 'forgot-password default-form-link'))?>
				<?php else:?>
					<?php echo link_to(__('Forgot Password?', null,'user'), 'userSettings/forgotPassword', array('class' => 'forgot-password default-form-link'))?>
				<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="row margin-bottom-small text-center">
			<input type="submit"  class="default-btn success pull-left" value="<?php echo __('Login');?>" />
		</div>
	</div>
	
  </div>


</form>