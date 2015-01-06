<?php slot('no_map', true) ?>
<div class="settings_content">
  <h2><?php echo __('Change Username');?></h2>

  <?php if(isset($form)):?>
    <form action="<?php echo url_for('userSettings/changeUsername') ?>" method="post">
      <?php echo $form[$form->getCSRFFieldName()]; ?>
      
      <div class="form_box <?php echo $form['username']->hasError()? 'error': '' ?>">
        <?php echo $form['username']->renderLabel() ?>        
        <?php echo $form['username']->render();?>
        <?php echo $form['username']->renderError();?>
      </div>

	    <div class="form_box">
        <input type="submit" value="<?php echo __('Save')?>" class="input_submit" />
      </div>

    </form>
  <?php else: ?>
    <?php echo __('Username', null,'form')?>: <?php echo $user->getUsername() ?>
  <?php endif;?>

</div>

<script type="text/javascript">
$(document).ready(function() {
	$('.path_wrap').css('display', 'none');
//	$('.search_bar').css('display', 'none');
	$('.content_footer').css('display', 'none');
});
</script>

