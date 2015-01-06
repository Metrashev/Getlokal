<?php slot('no_map');?>
<?php slot('no_ads');?>
<div class="content_in claim_form_wrap">
  <form action="<?php echo url_for('company/claim?slug='.$company->getSlug())?>" method="post">
    <?php echo $form[$form->getCSRFFieldName()]; ?>
    <?php if (isset($form['user_profile']['sf_guard_user']) && isset($form['user_profile']['sf_guard_user']['first_name'])):?>
    <div class="form_box <?php echo $form['user_profile']['sf_guard_user']['first_name']->hasError()? 'error': '' ?>">
      <?php echo $form['user_profile']['sf_guard_user']['first_name']->renderLabel() ?><span class="pink">*</span>
      <?php echo $form['user_profile']['sf_guard_user']['first_name']->render();?>
      <?php echo $form['user_profile']['sf_guard_user']['first_name']->renderError();?>
    </div>
    <?php endif;?>
     <?php if (isset($form['user_profile']['sf_guard_user']) && isset($form['user_profile']['sf_guard_user']['last_name'])):?>
      <div class="form_box <?php echo $form['user_profile']['sf_guard_user']['last_name']->hasError()? 'error': '' ?>">
      <?php echo $form['user_profile']['sf_guard_user']['last_name']->renderLabel() ?><span class="pink">*</span>
      <?php echo $form['user_profile']['sf_guard_user']['last_name']->render();?>
      <?php echo $form['user_profile']['sf_guard_user']['last_name']->renderError();?>
    </div>
    <?php endif;?>
  <?php if (isset($form['user_profile']['birthdate'])):?>
    <div class="form_box <?php echo $form['user_profile']['birthdate']->hasError()? 'error': '' ?>">
      <?php echo $form['user_profile']['birthdate']->renderLabel() ?><span class="pink">*</span>
      <?php echo $form['user_profile']['birthdate']->render();?>
      <?php echo $form['user_profile']['birthdate']->renderError();?>
    </div>
    <?php endif;?>
     <?php if (isset($form['user_profile']['gender'])):?>
    <div class="form_box form_label_inline<?php echo $form['user_profile']['gender']->hasError()? 'error': '' ?>">
      <?php echo $form['user_profile']['gender']->renderLabel() ?><span class="pink">*</span>
       <?php echo $form['user_profile']['gender']->render();?>
      <?php echo $form['user_profile']['gender']->renderError();?>
    </div>
     <?php endif;?>
      <?php if (isset($form['user_profile']['phone_number'])):?>
    <div class="form_box form_tooltip form_label_inline leftFloat <?php echo $form['user_profile']['phone_number']->hasError()? 'error': '' ?>">
      <?php echo $form['user_profile']['phone_number']->renderLabel() ?><span class="pink" style="display:block">&nbsp;*</span>
       
      <?php echo $form['user_profile']['phone_number']->render();?>
      <a class="tool-tip"><span class="details"><?php echo __('The correct format to use is 023456789 or for mobile phones 0888888888. Add only the local area code for landlines. Only add digits – any other characters or spaces between characters are not allowed.', null, 'company');?></span></a>

      <?php echo $form['user_profile']['phone_number']->renderError();?>
    </div>
    <?php endif;?>
    <?php if (isset($form['position'])):?>
    <div class="form_box form_label_inline leftFloat <?php echo $form['position']->hasError()? 'error': '' ?>">
      <?php echo $form['position']->renderLabel() ?><span class="pink" style="display:block">&nbsp;*</span>
      <?php echo $form['position']->render();?>
      <?php echo $form['position']->renderError();?>
    </div>
    <?php endif;?>
    <?php if (isset($form['registration_no']) && $sf_user->getAttribute('country_id') != getlokalPartner::GETLOKAL_MK):?>
    <div class="form_box <?php echo $form['registration_no']->hasError()? 'error': '' ?>">
      <?php /*echo $form['registration_no']->renderLabel()*/ ?>
      <label>
	      <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG):?>
	      	<?php echo __('Enter your EIK/Bulstat'); ?>
	      <?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO):?>
	      	<?php echo __('Enter the CUI of your business'); ?>
	      <?php //elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_MK):?>
	      	<?php //echo __('Enter your EIK/Bulstat'); ?>
	      <?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RS):?>
	      	<?php echo __('Enter your EIK/Bulstat'); ?>
        <?php else: ?>
          <?php echo __('Enter your EIK/Bulstat'); ?>
	      <?php endif;?>
          <span class="pink">*</span>
	 </label>
      <?php echo $form['registration_no']->render();?>
      <?php echo $form['registration_no']->renderError();?>
    </div>
    <?php endif;?>
    <?php if (isset($form['username'])):?>
    <div class="form_box form_tooltip form_label_inline leftFloat <?php echo $form['username']->hasError()? 'error': '' ?>">
      <?php echo $form['username']->renderLabel() ?><span class="pink" style="display:block">&nbsp;*</span>
      <?php echo $form['username']->render();?>
        <a class="tool-tip"><span class="details"><?php echo __('Your username should contain only alphanumeric characters, dash, dot or underscore');?></span></a>
      <?php echo $form['username']->renderError();?>
    </div>
      <?php endif;?>
       <?php if (isset($form['password'])):?>
    <div class="form_box form_label_inline leftFloat <?php echo $form['password']->hasError()? 'error': '' ?>">
      <?php echo $form['password']->renderLabel() ?><span class="pink" style="display:block">&nbsp;*</span>
      <?php echo $form['password']->render();?>
      <?php echo $form['password']->renderError();?>
    </div>
    <?php endif;?>
     <?php if (isset($form['authorized'])):?>
    <div class="form_box form_label_inline leftFloat <?php echo $form['authorized']->hasError()? 'error': '' ?>">
      <?php echo $form['authorized']->render(array('class' => 'input_check'));?>
      <?php echo $form['authorized']->renderLabel() ?><span class="pink" style="display:block">&nbsp;*</span>
      <?php if($form['authorized']->hasError()):?>
        <p class="error"><?php echo $form['authorized']->renderError();?></p>
        <?php endif;?>

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
     <div class="form_box <?php echo $form['accept']->hasError()? 'error': '' ?> form_box_small form_label_inline leftFloat">
            <span class="pink" style="display:inline-block;">&nbsp;*</span><?php echo $form['accept']->render();?>
	    <?php echo sprintf(__('I have the necessary representative powers and I agree to the %s and the %s'),  link_to(__('Terms of Use'), '@static_page?slug=terms-of-use',array('popup'=>true) ), link_to (__('Policy for Use and Protection of the Information on the Getlokal Website', null, 'user'), '@static_page?slug=privacy-policy',array('popup'=>true)));?>
        <?php echo $form['accept']->renderError();?>
    </div>
    <?php endif;?>
    <div class="form_box">

    </div>

    <div class="form_box">
      <input type="submit" value="<?php echo __('Send')?>" class="input_submit" />
    </div>
    <div class="mandatory_notice">
      <p><?php echo __('All fields marked with <span>*</span> are mandatory', null,'company')?></p>
    </div> 
  </form>
</div>
<div class="clear"></div>