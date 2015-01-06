<?php include_partial('global/commonSlider'); ?>
<?php slot('no_ads', true) ?>
<div class="container set-over-slider">
	<div class="row">	
		<div class="container">
			<div class="row">
				<h1 class="col-xs-12 main-form-title"><?php echo __('LOG IN', null, 'form'); ?></h1>
			</div>
		</div>	          
	</div>
	<?php include_partial('pageadmin_signin_form', array('form'=>$form,'company'=>$company, 'user' => $user))?> 
</div>

