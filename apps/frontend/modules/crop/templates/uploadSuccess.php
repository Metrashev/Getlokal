<?php slot('no_map', true) ?>
<div class="settings_content">
  <h2><?php echo __('Add Photo', null, 'company')?></h2>

  <form action="<?php echo url_for('crop/upload?slug='. $company->getSlug()) ?>" enctype="multipart/form-data" method="post">
    <?php echo $form['_csrf_token']->render() ?>

    <div class="form_box <?php echo $form['filename']->hasError()? 'error': '' ?>">
      <?php echo $form['filename']->renderLabel() ?>
      <?php echo $form['filename']->render() ?>

      <?php echo $form['filename']->renderError() ?>
    </div>

    <div class="form_box <?php echo $form['caption']->hasError()? 'error': '' ?>">
      <?php echo $form['caption']->renderLabel() ?>
      <?php echo $form['caption']->render() ?>

      <?php echo $form['caption']->renderError() ?>
    </div>

    <div class="form_box">
      <input type="submit" value="<?php echo __('Save', null, 'messages'); ?>" class="input_submit" />
    </div>

  </form>

</div>

<script type="text/javascript">
$(document).ready(function () {
	$('.path_wrap').remove();
})
</script>