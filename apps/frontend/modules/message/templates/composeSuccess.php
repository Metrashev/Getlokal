

 <form id="message" action="<?php echo url_for('message/compose') ?>" method="post">
   <?php echo $form[$form->getCSRFFieldName()] ?>
   <?php echo $form['page_id']->render(array('value'=>$page_to->getId())) ?>
   <?php echo $form['body'] ?>
  <div class="form_box">
      <input type="submit" value="<?php echo __('Send');?>" class="input_submit" />
    </div>
     </form>
     
<script type="text/javascript">
$(document).ready(function() {
     $('#message').submit(function(event) {       
        var $form = $(this);
        $.ajax({
            type: 'POST',
            cache: false,
            url: $form.attr("action"),
            data: $form.serializeArray(),            
            success  : function(data) {
               
           		$('#message_content div').html('<p class="flash_success">' + '<?php echo __('Message sent successfully');?>' + '</p>');
           		
                }
        });
        return false;
    });
});
</script>

