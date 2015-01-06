<?php slot('no_ads', true) ?>
<?php slot('no_map', true) ?>
<div class="settings_content">
  <h2><?php echo __('Change Password') ?></h2>
  
  <form action="<?php echo url_for('companySettings/changePassword?slug='.$company->getSlug()) ?>" method="post">

  <?php echo $form[$form->getCSRFFieldName()]; ?>
  
  <div class="form_box <?php echo $form['old_password']->hasError()? 'error': '' ?>">
    <?php echo $form['old_password']->renderLabel() ?>
    
    <?php echo $form['old_password']->render() ?>
    <?php echo $form['old_password']->renderError() ?>
  </div>
  
  <div class="form_box <?php echo $form['new_password']->hasError()? 'error': '' ?>">
    <?php echo $form['new_password']->renderLabel() ?>

    <?php echo $form['new_password']->render() ?>
    <?php echo $form['new_password']->renderError() ?>
  </div>
  
  <div class="form_box <?php echo $form['bis_password']->hasError()? 'error': '' ?>">
    <?php echo $form['bis_password']->renderLabel() ?>
    
    <?php echo $form['bis_password']->render() ?>
    <?php echo $form['bis_password']->renderError() ?>
  </div>

  <div class="form_box">
    <input type="submit" value="<?php echo __('Save');?>" class="input_submit" />
  </div>

  </form>

</div>

<script type="text/javascript">
$(document).ready(function () { 
	$('.path_wrap').remove();
})
</script>