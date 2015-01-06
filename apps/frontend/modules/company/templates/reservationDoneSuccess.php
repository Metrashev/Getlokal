<div class="row reservation_success">
    <div class="default-container default-form-wrapper col-sm-12">
        <div class="form-message success">
            <p><?php echo __('Thank you for sending your reservation request. Getlokal will forward it to the relevant person and they will be in touch with you shortly.'); ?></p>
        </div> 
        <a href="javascript:void(0)" class="close_form_report"><?php echo __('Close') ?><i class="ico-close"></i></a>
    </div>
</div>

<script>
	$(".close_form_report").click(function(){
		$('.reservation_success').toggle();
	});

	$('html, body').animate({
      scrollTop: $(".reservation_success").offset().top - 200
    }, 1000);

</script>


