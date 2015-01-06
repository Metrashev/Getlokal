<?php include_partial('global/commonSlider'); ?>
<div class="container set-over-slider">
		<div class="row">	
			<div class="container">
				<div class="row">
					<h1 class="col-xs-12 main-form-title"><?php echo __('Edit Article', null, 'article'); ?></h1>
				</div>
			</div>	          
		</div>
		<?php include_partial('form', array('form' => $form, 'user_profile'=>$user_profile)) ?>
</div>