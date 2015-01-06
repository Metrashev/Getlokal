<h1><?php echo __('Login') ?></h1>
<form action="<?php echo url_for('user/placeAdminActivate?key='.$key) ?>" method="post" class="login_form">
	<?php echo $form[$form->getCSRFFieldName()] ?>
	
	
	<div class="form_box<?php if( $form['username']->hasError()):?> error<?php endif;?>">
    	<?php echo $form['username']->renderLabel();?>
        <?php echo $form['username']->render();?>
        <?php if($form['username']->hasError()):?>
        	<p class="error"><?php echo $form['username']->renderError();?></p>
		<?php endif;?>
	</div>
	<div class="form_box<?php if( $form['password']->hasError()):?> error<?php endif;?>">
		<?php echo $form['password']->renderLabel();?>
		<?php echo $form['password']->render();?>
		<?php if($form['password']->hasError()):?>
			<p class="error"><?php echo $form['password']->renderError();?></p>
		<?php endif;?>
	</div>
	<div class="form_box form_label_inline">
		<?php echo $form['remember']->render();?>
		<?php echo $form['remember']->renderLabel();?>
	</div>
	 <div class="form_box <?php echo $form['accept']->hasError()? 'error': '' ?>">
     
                       <?php echo $form['accept']->render(array('class' => 'input_check'));?>
                       <?php echo sprintf(__('I agree with the %s and the %s'),  link_to(__('Terms of Use'), '@static_page?slug=terms-of-use',array('popup'=>true) ), link_to (__('Policy for Use and Protection of the Information of Getlokal'), '@static_page?slug=privacy-policy',array('popup'=>true)));?>
                       <?php echo $form['accept']->renderError();?>
                       </div>
                        <div class="form_box <?php echo $form['allow_b_cmc']->hasError()? 'error': '' ?> form_box_small">
      <?php echo $form['allow_b_cmc']->render();?>
      <?php echo __('I would like to receive getlokal\'s Business Newsletter and Notifications.', null,'user'); ?>
      <?php echo $form['allow_b_cmc']->renderError();?>
    </div>
	<div class="form_box">  
		<input type="submit" class="button_green" value="<?php echo __('Login');?>" />
	</div>
</form>