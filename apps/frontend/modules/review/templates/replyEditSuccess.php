<?php echo $form->renderGlobalErrors();?>
<form action="<?php echo url_for( 'review/edit?review_answer_id='. $review->getId() ) ?>" method="post">
   <div class="form_box <?php echo $form['text']->hasError()? 'error': '' ?>">
     <?php echo $form['text']->renderLabel(); ?>
     <?php echo $form['text']->render(); ?>
     <?php echo $form['text']->renderError() ?>
  </div>
  <div class="form_box">
    <input type="submit" value="<?php echo __('Publish');?>" class="input_submit" />
    <a href="<?php echo url_for("review/cloce?review_id=".$form->getObject()->getId())?>" class="close_form_company_reply"><?php echo __('Close') ?></a>
  </div>
  <?php echo $form['_csrf_token'] ?>
</form>

<?php if($sf_request->isXmlHttpRequest()): ?>
<script type="text/javascript">
	$(".close_form_company_reply").click(function() {
		var loading = false;
        
	    if(loading) return false;
	    
	    var element = $(this).parent().parent().parent();
	        
	    loading = true;

	    $.ajax({
	        url: this.href,
	        type: 'POST',
	        //data: element.serialize(),
	        beforeSend: function() {
	          $(element).html(LoaderHTML);
	        },
	        success: function(data, url) {
	          $(element).html(data);
	          loading = false;
	        },
	        error: function(e, xhr)
	        {
	          console.log(e);
	        }
	    });
	    
	    return false;
	});
	
  $('.review_company_content_wrap form').submit(function() {
    var loading = false;
        
    if(loading) return false;
    
    var element = $(this).parent().parent().find('div.review-content-body');
        
    loading = true;

    $.ajax({
        url: this.action,
        type: 'POST',
        data: $(this).serialize(),
        beforeSend: function() {
          $(element).html(LoaderHTML);
        },
        success: function(data, url) {
          $(element).html(data);
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