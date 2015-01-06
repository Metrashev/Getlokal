
<?php echo $formLogin[$formLogin->getCSRFFieldName()] ?>
	<div class="form_box<?php if( $formLogin['username']->hasError()):?> error<?php endif;?>">
    	<?php echo $formLogin['username']->renderLabel();?>
        <?php echo $formLogin['username']->render();?>
        <?php if($formLogin['username']->hasError()):?>
        	<p class="error"><?php echo $formLogin['username']->renderError();?></p>
		<?php endif;?>
	</div>
	<div class="form_box<?php if( $formLogin['password']->hasError()):?> error<?php endif;?>">
		<?php echo $formLogin['password']->renderLabel();?>
		<?php echo $formLogin['password']->render();?>
		<?php if($formLogin['password']->hasError()):?>
			<p class="error"><?php echo $formLogin['password']->renderError();?></p>
		<?php endif;?>
	</div>
	<div class="form_box form_label_inline">
		<?php echo $formLogin['remember']->render();?>
		<?php echo $formLogin['remember']->renderLabel();?>
	</div>
<?php
/*
	<div class="form_box">  
		<input type="submit" class="button_green" value="<?php echo __('Login');?>" />
		<a href="<?php echo url_for('user/FBLogin')?>" title="Facebook Connect" class="facebook_register">Facebook Connect</a>
	</div>

	<div id="fb_connect_login">
		 <input id="signin_facebook" name="signin[facebook]" type="submit" class="facebook_register" value="<?php echo __('Facebook Connect');?>" />
	</div>
*/ ?>

	<div class="login_more">
		<a href="<?php echo url_for('company/registerPost')?>" class="register_pos"><?php echo __('Sign Up', null,'user')?></a> 
	</div>
	<script type="text/javascript">
	$('input').each(function(index) {
		if (!($(this).hasClass('star')))
		{
			$(this).ezMark();
		}
	});
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