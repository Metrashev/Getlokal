<?php slot('no_map', true) ?>
<div class="content_in">
	<h1><?php echo __('New Event',null,'events')?></h1>
	<?php include_partial('form', array('form' => $form)) ?>
</div>
<script type="text/javascript">
	$(document).ready(function() {
//		$(".search_bar").css("display", "none");
		$(".path_wrap").css("display", "none");
		$('html.special body').css("height", ($('html.special body div.page_wrap div.special').height() + 63) + "px");
                $('html.special body').css("height","100%");
                /*$('.content_footer').css("background","none");
                $('ul.footer_menu').css("background","#A9287A");*/
                
	});
</script>