<div class="settings_user_company_form">
    <div class="login_form_mask username_password"></div>
	<?php echo $form->renderGlobalErrors();?>
	<form method="post" action="<?php echo url_for('userSettings/registerPageAdmin?slug='.$form->getObject()->getCompanyPage()->getCompany()->getSlug().'&id='.$form->getObject()->getId() )?>" >
		<?php echo $form['_csrf_token']->render() ?>
		<div class="form_box form_tooltip <?php if( $form['username']->hasError()):?> error<?php endif;?>">
			<label><?php echo __('Username',null,'form')?><span class="pink">*</span></label>
			<?php echo $form['username']->render();?>
			<a class="tip admin_username">
            	<span class="details"><?php echo __('Your username should contain only alphanumeric characters, dash, dot or underscore');?></span>
            </a>
      		<?php if($form['username']->hasError()):?>
				<p class="error"><?php echo $form['username']->renderError();?></p>
			<?php endif;?>
		</div>
		<div class="form_box<?php if( $form['password']->hasError()):?> error<?php endif;?>">
			<label><?php echo __('Password',null,'form')?><span class="pink">*</span></label>
			<?php echo $form['password']->render();?>
			<?php if($form['password']->hasError()):?>
				<p class="error"><?php echo $form['password']->renderError();?></p>
			<?php endif;?>
		</div>
		<?php if (!$form->getObject()->getUserProfile()->getGender()):?>
	
		<div class="form_box <?php echo $form['user_profile']['gender']->hasError()? 'error': '' ?>">
      <label><?php echo __('Gender',null,'form')?><span class="pink">*</span>:</label>
       <?php echo $form['user_profile']['gender']->render(array('class'=>'select_two'));?>
      <?php echo $form['user_profile']['gender']->renderError();?>
      </div>

		<?php endif;?>
		<?php if (!$form->getObject()->getUserProfile()->getPhoneNumber()):?>
		
		<div class="form_box <?php echo $form['user_profile']['phone_number']->hasError()? 'error': '' ?>">
      <label><?php echo __('Phone',null,'form')?><span class="pink">*</span></label>
      <?php echo $form['user_profile']['phone_number']->render();?>
      <?php echo $form['user_profile']['phone_number']->renderError();?>
    
    </div>
		<?php endif;?>
		<?php if (!$form->getObject()->getPosition()):?>
		<div class="form_box <?php echo $form['position']->hasError()? 'error': '' ?>">
      <?php echo $form['position']->renderLabel() ?>      
      <?php echo $form['position']->render(array('class'=>'select_three'));?>
      <?php echo $form['position']->renderError();?>
    </div>
    <?php endif;?>
     <?php if (isset($form['allow_b_cmc'])):?>
     <div class="form_box <?php echo $form['allow_b_cmc']->hasError()? 'error': '' ?> form_box_small">
      <?php echo $form['allow_b_cmc']->render();?>
      <?php echo __('I would like to receive getlokal\'s Business Newsletter and Notifications.', null,'user'); ?>
      <?php echo $form['allow_b_cmc']->renderError();?>
    </div>
    <?php endif;?>
     <?php if (isset($form['accept'])):?>
		<div class="form_box <?php echo $form['accept']->hasError()? 'error': '' ?>">
			<?php echo $form['accept']->render();?>
			<?php echo sprintf(__('I agree with the %s and the %s'),  link_to(__('Terms of Use'), '@static_page?slug=terms-of-use',array('popup'=>true) ), link_to (__('Policy for Use and Protection of the Information of Getlokal'), '@static_page?slug=privacy-policy',array('popup'=>true)));?>
			<?php echo $form['accept']->renderError();?>
		</div>
		<?php endif;?>
		<div class="form_box">
			<input type="submit" class="button_green" value="<?php echo __('Save');?>" />
		</div>
	</form>
	<a href="javascript:void(0)" id="header_close"></a>
</div>