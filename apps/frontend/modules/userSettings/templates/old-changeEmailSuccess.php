<?php slot('no_map', true) ?>
<div class="settings_content">
  <h2><?php echo __('Change Email') ?></h2>
  
  <form action="<?php echo url_for('userSettings/changeEmail') ?>" method="post">

    <?php echo $form[$form->getCSRFFieldName()]; ?>
    
    <div class="form_box <?php echo $form['email_address']->hasError()? 'error': '' ?>">
      <?php echo $form['email_address']->renderLabel() ?>
      
      <?php echo $form['email_address']->render();?>
      <?php echo $form['email_address']->renderError();?>
    </div>

	  <div class="form_box">
      <input type="submit" value="<?php echo __('Save')?>" class="input_submit" />
    </div>

  </form>

</div>

<script type="text/javascript">
$(document).ready(function() {
	$('.path_wrap').css('display', 'none');
//	$('.search_bar').css('display', 'none');
});
</script>
