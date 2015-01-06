<?php if(!empty($with_form)):?>
<form method="post" class="default-form clearfix">
<?php endif; ?>
<?php echo $form[$form->getCSRFFieldName()] ?>
<div class="row">
	<div class="col-sm-12">
		<h2 class="form-title">
			<?php echo __('Login'); ?>
			<button type="button" class="close" onclick="$('#buttons_login_form').hide()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		</h2>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="default-input-wrapper required<?php if( $form['username']->hasError()):?> incorrect<?php endif;?>">
			<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
			<?php if($form['username']->hasError()):?>
	        	<div class="error-txt"><?php echo $form['username']->renderError();?></div>
			<?php endif;?>
			<label for="<?= $form['username']->getName()?>" class="default-label"><?php echo $form['username']->renderLabelName();?></label>
			<?php echo $form['username']->render(array('class'=>'default-input','placeholder'=>$form['username']->renderLabelName()));?>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="default-input-wrapper required<?php if( $form['password']->hasError()):?> incorrect<?php endif;?>">
			<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
			<?php if($form['password']->hasError()):?>
	        	<div class="error-txt"><?php echo $form['password']->renderError();?></div>
			<?php endif;?>
			
			<label for="<?= $form['password']->getName()?>" class="default-label"><?php echo $form['password']->renderLabelName();?></label>
			<?php echo $form['password']->render(array('class'=>'default-input','placeholder'=>$form['password']->renderLabelName()));?>
		</div>
	</div>
</div>
	<div class="custom-row pull-left">
		<div class="default-checkbox">
			<?= $form['remember']->render(array('class' => 'input_check', 'id' => $form["remember"]->getName()));?>
			<div class="fake-box"></div>
		</div>
		<label for="<?= $form['remember']->getName()?>" class="default-checkbox-label">
			<?php echo $form['remember']->renderLabelName();?>
		</label>
	</div><!-- Form Checkbox -->
<!-- 
	<div class="form_box form_label_inline">
		<?php echo $form['remember']->render();?>
		<?php echo $form['remember']->renderLabel();?>
	</div> -->

	<div class="row">
		<div class="col-sm-12">
				<input type="submit" class="default-btn success pull-left" value="<?php echo __('Login');?>" />
				<!-- <a href="<?php //echo url_for('company/FBLogin')?>" title="Facebook Connect" class="facebook_register">Facebook Connect</a> -->
				<?php /*
		                <input id="signin_facebook" name="signin[facebook]" type="submit" class="facebook_register" value="<?php echo __('Facebook Connect');?>" />
		                 */ ?>
		        <a href="<?php echo url_for('company/registerPost')?>" class="register_pos1 default-btn pull-right"><?php echo __('Sign Up', null,'user')?></a>
		</div>
	</div>


<?php if(!empty($with_form)):?>
</form>
	<?php endif; ?>
	<script type="text/javascript">
	$('.register_pos1').click(function() {
	    //var element = this;

	    $.ajax({
	        url: this.href,
	        beforeSend: function() {
	          $('#buttons_login_form').html(LoaderHTML);
	        },
	        success: function(data, url) {
	          $('#buttons_login_form').html('<form id="reviewForm" method="post" class="default-form clearfix">'+data+'</form>');
	          loading = false;
	          //console.log(id);
	        },
	        error: function(e, xhr)
	        {
	          console.log(e);
	        }
	    });
	    return false;
	  });
	</script>
