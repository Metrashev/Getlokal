<div class="default-form-wrapper">
  <form class="reportForm" action="<?php echo url_for( 'report/list?id='. $list->getId())?>" method="post">
    <?php include_partial('form', array('form' => $form)) ?>
  </form>
</div>

<?php if($sf_request->isXmlHttpRequest()): ?>
  <script type="text/javascript">
    $(".close_form_report").click(function() {
      $(this).parent().parent().parent().parent().parent().html("");
    });

    $('.reportForm').submit(function(){
      var element = $(this).parent();
      $.ajax({
          url: this.action,
          data: $(this).serialize(),
          type: 'POST',
          beforeSend: function() {
             $(element).html(LoaderHTML);
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

  </script>
<?php endif ?>