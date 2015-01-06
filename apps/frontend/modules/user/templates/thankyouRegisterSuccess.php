<div class="success_wrapper">
    <div class="dotted"></div>
    <div class="content_in">
            
            <h1><?php echo __('Thank you for registering with getlokal!');?></h1>

             <?php if ($userStatus == 'company') : ?>
                <p><?php echo __('We just sent a confirmation request to the email address that you provided. Please check your email and click on the link to activate your getlokal account! If you don\'t see the message in your Inbox, please also check your Junk Mail folder. After your account activation you\'ll enter the game'); ?></p>
            <?php else : ?>
                <p><?php echo __('We just sent a confirmation request to the email address that you provided. Please check your email and click on the link to activate your getlokal account! If you don\'t see the message in your Inbox, please also check your Junk Mail folder.');?></p>
            <?php endif; ?>
   
   </div>
</div>    
<div class="sidebar">
</div>
<div class="clear"></div>

<script type="text/javascript">
  $(document).ready(function() {
	  $('.path_wrap').remove();
	  $('.search_bar').remove();
	  $(".banner").remove();
  }) 
</script>