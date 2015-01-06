<div class="success_wrapper add_place_success">

        <div class="content_in">
                <h1><?php echo __('<span>Thank you for suggesting</span> <span>a new place!</span>');?></h1>

                <p><?php echo __('The place you suggested was added to getlokal. It will be checked by a member of the getlokal team to ensure we have the right details and you will receive a confirmation email once it has been verified.');?>
                </p>
        </div>
</div>
<!--
<div class="sidebar write_review_form">
    <?php/*"Write a review" form GOES HERE*/ ?>
    <?php /* 
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
					<input type="submit" value="<?php echo __('Publish')?>" class="input_submit" />
				<?php elseif (!$user):?>
			        <a href="<?php echo url_for('list/loginPost')?>" class="button_green"><?php echo __('Publish')?></a>
					<div class="login_form_wrap" style="display:none">
			        </div>
				<?php endif;?>
        </div>
        <?php echo $form['_csrf_token'] ?>
      </form>

      <?php echo __('Please write clearly, without using offensive or obscene language.', null, 'messages');?>
    </div>
    */ ?>
</div>
-->
<div class="clear"></div>
<div class="dotted success_separator"></div>
<div class="add_other_link">
    <?php echo link_to(__('Add other place'), 'company/addCompany', array('title' => __('Add other place')));?>
</div>
<div class="dotted success_separator"></div>
<div class="clear"></div>

<script type="text/javascript">
  $(document).ready(function() {
	  $('.search_bar').css('display', 'none');
	  $('.banner').css('display', 'none');
          $('.flash_success').css('display', 'none');
  }) 
</script>