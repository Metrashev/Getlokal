<div id="add_company_contact">
  <form class="add-company-mail" action="<?php echo url_for('company/addCompanySendMail') ?>" method="POST">
      <?php include_partial('contact/form', array('form' => $form)) ?>
      <a href="javascript: void(0)" class="close_mail_form"><?php echo __('Close') ?></a>
  </form>
</div>

<?php if($sf_request->isXmlHttpRequest()): ?>
  <script type="text/javascript">
    $(document).ready(function() {

        $(".close_mail_form").click(function() {
          $(this).parent().html("");
        });

        $('.add-company-mail').submit(function(){
          var element = $(this).parent();
          $.ajax({
              url: this.action,
              data: $(this).serialize(),
              type: 'POST',
              beforeSend: function() {
                 document.getElementById("loading-overlay").style.display="block";
              },
              success: function(data){
                document.getElementById("loading-overlay").style.display="none";
                $(element).html(data);

                var elementExists = document.getElementsByClassName("error_list");

                if(elementExists.length === 0) {
                  $(".add-company-mail").fadeOut();
                  $("#add_company_contact").append("<p class='send_mail_succes'><?php echo  __('Your message was sent successfully.', null, 'contact');?></p>");

                  setTimeout(function() {
                    $(".send_mail_succes").fadeOut().empty();
                  }, 8000);
                }
              }
          });

          return false;
      });

      clearContactInputs();

    });
  </script>
<?php endif ?>