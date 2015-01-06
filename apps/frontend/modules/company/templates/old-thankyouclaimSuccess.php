<?php slot('no_map', true) ?>
<div class="success_wrapper">
    <div class="dotted"></div>
    <div class="content_in">
            <h1><?php echo __('Thank you for your claim request!');?></h1>

            <p><?php echo __('Your claim request was submitted and will be approved by an administrator. Once you have been approved, you will be able to manage the information about this company.');?></p>
    </div>
</div>    
<div class="sidebar">
</div>
<div class="clear"></div>

<script type="text/javascript">
  $(document).ready(function() {
	  $('.path_wrap').remove();
	  $(".banner").remove();
          $(".flash_success").remove();
  }) 
</script>