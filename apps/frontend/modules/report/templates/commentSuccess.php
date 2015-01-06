<h3><?php echo __('Report Abuse')?></h3>
<form class="reportForm" action="<?php echo url_for( 'report/comment?id='. $comment->getId())?>" method="post">
  <?php include_partial('form', array('form' => $form)) ?>
</form>

<?php if($sf_request->isXmlHttpRequest()): ?>
  <script type="text/javascript">
    $(document).ready(function() {  
    	$(".close_form_report").click(function() {
			$(this).parent().parent().parent().html("");
        });            
        $("#comment-<?php echo $comment->getId() ?> .reportForm").submit(function() {
          var element = $(this).parent();
            $.ajax({
                url: this.action,
                data: $(this).serialize(),
                type: 'POST',
                beforeSend: function() {
                   $(element).html('<img src="/images/gui/blue_loader.gif"/>');
                },
                success: function(data){
                  $(element).html(data);
                  setTimeout(function() {
                   $(".report_success").fadeOut().empty();
                  }, 8000);
                }
            });

            return false;
        });
    }) 
  </script>
<?php endif ?>