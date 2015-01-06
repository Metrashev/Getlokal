<?php //include_javascripts('jquery.rating.js');?>
<?php include_partial('company/rating');?>
    <div class="add_review" id="add_review_container">
      <h3><?php echo __('Write a Review'); ?></h3>
      <form action="<?php echo url_for('list/review?place_id='.$placeId.'&list_id='.$listId )?>" method="post">
        <div class="form_box<?php if( $form['rating']->hasError()):?> error<?php endif;?>">
          <label><?php echo __('Rate'); ?></label>
          <?php  echo $form['rating']->render(array('class'=>'star')); ?>
          <?php echo $form['rating']->renderError()?>
          <div class="clear"></div>
        </div>
        <div class="form_box<?php if( $form['text']->hasError()):?> error<?php endif;?>">
          <label><?php echo __('Review'); ?></label>
          <?php echo $form['text'] ?>
          <?php echo $form['text']->renderError()?>
        </div>
        <div class="form_box">
          		<?php if ($user):?>
					<input onClick="_gaq.push(['_trackEvent', 'Review', 'Publish', 'list']);" type="submit" value="<?php echo __('Publish')?>" class="input_submit" />
				<?php elseif (!$user):?>
			        <a href="<?php echo url_for('list/loginPost')?>" onClick="_gaq.push(['_trackEvent', 'Review', 'Publish', 'list']);" class="button_green"><?php echo __('Publish')?></a>
					<div class="login_form_wrap" style="display:none">
			        </div>
				<?php endif;?>
        </div>
        <?php echo $form['_csrf_token'] ?>
      </form>

      <?php echo __('Please write clearly, without using offensive or obscene language.', null, 'messages');?>
    </div>
    
    
    <script type="text/javascript">
  $(document).ready(function() {
	  $('.radio_list li span div#review_rating_1 a').attr('title', "<?php echo __('Poor'); ?>");
	  $('.radio_list li span div#review_rating_2 a').attr('title', "<?php echo __('Average'); ?>");
	  $('.radio_list li span div#review_rating_3 a').attr('title', "<?php echo __('Good'); ?>");
	  $('.radio_list li span div#review_rating_4 a').attr('title', "<?php echo __('Very good'); ?>");
	  $('.radio_list li span div#review_rating_5 a').attr('title', "<?php echo __('Excellent'); ?>");
	  if ($('div.star-rating a').css('background-image') != "none")
	  {
		  $('div.star-rating a').css('text-indent', '-9999px');
	  }

	       
  $('#login').click(function() {
	  $('.login_form_wrap').toggle();
  });
  
  //$('.register_pos, .login_form_wrap, .button_green').click(function() {
  $('.button_green').click(function() {
	    var element = this;

	    $.ajax({
	        url: this.href,
	        beforeSend: function() {
	        	$(element).next('div.login_form_wrap').toggle();  
	        	$(element).next('div.login_form_wrap').html('loading...');
	        },
	        success: function(data, url) {
	          $(element).next('div.login_form_wrap').html(data);
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
  $('.register_pos').click(function() {
	    var element = this;

	    $.ajax({
	        url: this.href,
	        beforeSend: function() {
	        	//$(element).parent().parent().toggle();  
	        	$(element).parent().parent().html('loading...');
	        },
	        success: function(data, url) {
	          $(element).parent().parent().html(data);
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
  });
</script>