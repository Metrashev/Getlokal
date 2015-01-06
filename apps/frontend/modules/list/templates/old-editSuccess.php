<?php slot('no_map', true) ?>
<div class="list_edit_wrap">
<?php include_partial('form', array('form' => $form, 
									'user'=>$user, 
									'is_place_admin_logged' => $is_place_admin_logged
									)
					  ) ?>
</div>
<script type="text/javascript">
$(document).ready(function() {
//	$(".search_bar").remove();
	$(".banner").remove();
	$(".path_wrap").children('.path').html('<h1><span>' + '<?php echo __('Edit List',null,'list'); ?>' + '</span></h1>');
	$(".path_more").remove();
});
</script>
