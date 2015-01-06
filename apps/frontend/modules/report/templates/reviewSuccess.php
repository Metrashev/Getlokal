<div class="default-form-wrapper report-review-form global-padding-form">

  <form class="reportForm default-form" action="<?php echo url_for( 'report/review?id='. $review->getId())?>" method="post">
    <?php include_partial('form', array('form' => $form)) ?>
  </form>
</div>

<script type="text/javascript">          
    $(".close_form_report").click(function() {
      $('.report-review-form').parent().html("");
    });

      $(".reportForm").submit(function() {
        var element = $(this).parent();
          $.ajax({
              url: this.action,
              data: $(this).serialize(),
              type: 'POST',
              beforeSend: function() {
                $(element).html(LoaderHTML);
                $('html, body').animate({
                    scrollTop: $(element).offset().top - 250
                }, 1000);
              },
              success: function(data){
                $(element).html(data);
                $('html, body').animate({
                  scrollTop: $(".report-review-form .report_success").offset().top - 245
                }, 1000);
                /*setTimeout(function() {
                 $(".report_success").fadeOut().empty();
                }, 7000);*/
              }
          });

          return false;
      });
</script>