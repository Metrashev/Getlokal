<?php slot('no_map', true) ?>
<div class="content_in_full">
<?php include_partial('form', array('form' => $form)) ?>
</div>

<script type="text/javascript">
$(document).ready(function() {
//	$(".search_bar").remove();
	$(".banner").remove();
	$(".path_wrap").children('.path').html('<h1><span>' + '<?php echo __('New List'); ?>' + '  </span></h1>');
	$(".path_more").remove();
});
</script>