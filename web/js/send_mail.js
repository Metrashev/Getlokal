$('#contact_form').on('click','#email_form_close',function(){
	$('.email_form_wrap').removeClass('email_form_wrap_opened');
	$("#contact_form").html("");
})
$('a#send_mail_company').click(function(event) {
	if ($('.email_form_wrap').hasClass('email_form_wrap_opened'))
	  $('.email_form_wrap').removeClass('email_form_wrap_opened');
	else {
	  $('.email_form_wrap').addClass('email_form_wrap_opened');
	
	    $.ajax({
	    url: this.href,
	            dataType: 'json',
	    beforeSend: function( ) {
	                $(".report_success").html("");
	                $(".report_success").css('display', 'hidden');
	                $(".embedding .box").css('display', 'none');
	      $('#contact_form').html(LoaderHTML);
	      },
	    success: function( data ) {
	      $("#contact_form").html(data.html);
	    }
	  });
	}
	return false;
});

$('#contact_form').on('submit','form', function(event) {
    event.preventDefault();
    $("#contact_form form").append(LoaderHTML)
      $.ajax({
          type: "POST",
          url: $(this).attr('action'),
            data: $(this).serialize() + '&getFlashOnly=true',
            dataType: 'json',
          success: function(data) {
            //$('#contact_form').html(data);

              if (data.success == true) {
                  $('a#email_form_close').click();
                  $(".report_success").html(data.html);
                  $(".report_success").css('display', 'inline-block');
                  setInterval(function(){
                    $(".report_success").fadeOut(400);
                  },3000)
                  
              }
              else {
                  $('#contact_form').html(data.html);
                  $(".report_success").html("");
                  $(".report_success").css('display', 'hidden');
              }
          }
        });
      return false;
  });