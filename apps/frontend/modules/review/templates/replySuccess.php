<?php echo $form->renderGlobalErrors();?>
<form action="<?php echo url_for( 'review/reply?review_id='. $review->getId() ) ?>" method="post" class="replyForm">
   <div class="form_box <?php echo $form['text']->hasError()? 'error': '' ?>">
     <h3><?php echo $form['text']->renderLabel(); ?></h3>
     <?php echo $form['text']->render(); ?>
     <?php echo $form['text']->renderError() ?>
  </div>
  <div class="form_box">
    <input type="submit" value="<?php echo __('Publish');?>" class="input_submit" />
    <a href="javascript: void(0)" class="close_form_company_reply"><?php echo __('Close') ?></a>
  </div>
  <?php echo $form['_csrf_token'] ?>
</form>

<?php if($sf_request->isXmlHttpRequest()): ?>
<script type="text/javascript">
	$(".close_form_company_reply").click(function() {
		$(this).parent().parent().parent().html("");
	});
	
  $('#review-<?php echo $review->getId() ?> .replyForm').submit(function() {
    var loading = false;
        
    if(loading) return false;
    
    var element = $(this).parent().parent();
        
    loading = true;

    $.ajax({
        url: this.action,
        type: 'POST',
        data: $(this).serialize(),
        beforeSend: function() {
          $(element).html('loading...');
        },
        success: function(data, url) {
          $(element).html($(data).html());
          loading = false;
        },
        error: function(e, xhr)
        {
          console.log(e);
        }
    });
    
    return false;
  });

</script>
<?php endif ?>