<h3 class="report_list"><?php echo __('Report Abuse')?></h3>
<?php /* <form class="reportForm" action="<?php echo url_for( 'report/comment?id='. $list->getId())?>" method="post"> */ ?>

<form class="reportForm report_list" action="<?php echo url_for( 'report/event?id='. $event->getId())?>" method="post">
  <?php include_partial('form', array('form' => $form)) ?>
</form>

<?php if($sf_request->isXmlHttpRequest()): ?>
  <script type="text/javascript">
    $(document).ready(function() {

    	$(".close_form_report").click(function() {
    	      $(this).parent().parent().parent().html("");
    	        if ($('.profile_event_scroll').length > 0) {
    	            if ($('.profile_event_scroll .scrollbar').length > 0) {
    	                $('.profile_event_scroll').tinyscrollbar_update('relative');
    	            }
    	        }
    	      });           
        /* $("#review-<?php //echo $list->getId() ?> .reportForm").submit(function() {*/
          $('.reportForm').live("submit", function(){
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
    }); 
  </script>
<?php endif ?>