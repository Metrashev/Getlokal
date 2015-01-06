<?php 

echo javascript_include_tag(javascript_path('tiny_mce/jquery.tinymce.js'));
echo javascript_include_tag(javascript_path('tiny_mce/tiny_mce.js'));
echo javascript_include_tag(javascript_path('init_date_picker.js'));

include_partial('global/commonSlider'); ?>
<div class="container set-over-slider">
		<div class="row">	
			<div class="container">
				<div class="row">
					<h1 class="col-xs-12 main-form-title"><?php echo __('New Article', null, 'article'); ?></h1>
				</div>
			</div>	          
		</div>
		<?php include_partial('form', array('form' => $form, 'user_profile'=>$user_profile)) ?>
</div>