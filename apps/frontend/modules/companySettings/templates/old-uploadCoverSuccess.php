<?php slot('no_map', true) ?>
<?php slot('no_ads', true) ?>
<div class="settings_content">
	<h2><?php echo __('Cover Photo', null, 'company')?></h2>
	<p>
		<?php echo __('The cover photo template is <strong>975x300 px</strong>. For best results, we recommend that you upload pictures of that size.', null, 'company');?><br />
		<strong><?php echo __('Upload your photo here, crop it if necessary and then save it.',null,'company');?></strong>
	</p>

	<form action="<?php echo url_for('companySettings/uploadCover?slug='. $company->getSlug()) ?>" enctype="multipart/form-data" method="post">
	    <?php echo $form['_csrf_token']->render() ?>
	
	    <div class="form_box <?php echo $form['file']->hasError()? 'error': '' ?>">
	      <?php echo $form['file']->renderLabel() ?>
	      <?php echo $form['file']->render() ?>
	
	      <?php echo $form['file']->renderError() ?>
	    </div>
	
	    <div class="form_box <?php echo $form['caption']->hasError()? 'error': '' ?>">
	      <?php echo $form['caption']->renderLabel() ?>
	      <?php echo $form['caption']->render() ?>
	
	      <?php echo $form['caption']->renderError() ?>
	    </div>
	
	    <div class="form_box">
	      <input type="submit"  value="<?php echo __('Save', null, 'messages'); ?>" class="input_submit" />
	    </div>

	</form>
</div>

<script type="text/javascript">
$(document).ready(function () {
	$('.path_wrap').remove();
$('.input_submit').click(function() {
   var that = this;
 $.fancybox(
    {
        'autoDimensions'    : true,
        'width'                 : 350,
        'height'                : 'auto',
        'transitionIn'      : 'none',
        'transitionOut'     : 'none',
        'href'          : '\apps\frontend\modules\crop\templates\placePhotoSuccess.php'
    }
);
});
});

</script>