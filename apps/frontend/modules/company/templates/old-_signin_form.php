<?php echo $form[$form->getCSRFFieldName()] ?>
	<div class="form_box<?php if( $form['username']->hasError()):?> error<?php endif;?>">
    	<?php echo $form['username']->renderLabel();?>
        <?php echo $form['username']->render();?>
        <?php if($form['username']->hasError()):?>
        	<p class="error"><?php echo $form['username']->renderError();?></p>
		<?php endif;?>
	</div>
	<div class="form_box<?php if( $form['password']->hasError()):?> error<?php endif;?>">
		<?php echo $form['password']->renderLabel();?>
		<?php echo $form['password']->render();?>
		<?php if($form['password']->hasError()):?>
			<p class="error"><?php echo $form['password']->renderError();?></p>
		<?php endif;?>
	</div>
	<div class="form_box form_label_inline">
		<?php echo $form['remember']->render();?>
		<?php echo $form['remember']->renderLabel();?>
	</div>
	<div class="form_box">
		<input type="submit" class="button_green" value="<?php echo __('Login');?>" />
		<!-- <a href="<?php //echo url_for('company/FBLogin')?>" title="Facebook Connect" class="facebook_register">Facebook Connect</a> -->
		<?php /*
                <input id="signin_facebook" name="signin[facebook]" type="submit" class="facebook_register" value="<?php echo __('Facebook Connect');?>" />
                 */ ?>
	</div>

	<div class="login_more">
		<a href="<?php echo url_for('company/registerPost')?>" class="register_pos"><?php echo __('Sign Up', null,'user')?></a>
	</div>
	<script type="text/javascript">
	$('.register_pos').click(function() {
	    //var element = this;

	    $.ajax({
	        url: this.href,
	        beforeSend: function() {
	          $('.login_form_wrap').html('loading...');
	        },
	        success: function(data, url) {
	          $('.login_form_wrap').html(data);
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
