<h2><?php echo __('Choose from Current Lists', null, 'list'); ?></h2>
<form action="<?php echo url_for('list/addToList') ?>" method="post" id="list_form">
	<div class="form_box<?php if( $form['list']->hasError()):?> error<?php endif;?>">
		<?php echo $form['list']->renderLabel();?>
		<?php echo $form['list']->render();?>
		<?php if($form['list']->hasError()):?>
			<p class="error"><?php echo $form['list']->renderError();?></p>
		<?php endif;?>
	</div>
	<?php ?>
	<input id="add_to_list" type="submit" value="<?php echo __( 'Add to List',null,'list') ?>" class="button_green" />
	<?php ?>
<a href="<?php echo url_for('list/addToNew?company_id='.$company_id)?>" title=""><?php echo __('Add to New List',null,'list'); ?></a>
</form>
<script type="text/javascript">
$(document).ready(function() {
$('#list_form').live('submit',function() {  

	if ($('#list_copany_list').attr('value')){
		var tab_url = "<?php echo url_for('company/lists?pageId='. $page_id)?>";
		var ppp_url = "<?php echo url_for('company/listsPPP?pageId='. $page_id)?>"
		var tab_title = "<?php echo __('Lists'); ?>"
		var page_id = <?php echo $page_id?>;
		var list_id = $('#list_copany_list').attr('value');
		//console.log($('#list_copany_list').attr('value'));
		$.ajax({
			url: this.action,
			dataType: "json",
			data: {'page_id': page_id, 'list_id': list_id},
			<?php if ($template == 'pp'):?>
			success: function(data) {
				if (data.error != undefined && data.error == false) {
					
					//if( !$('#tab2') || $('#tab2') == undefined)
				    if ($('#tab2').length == 0){
						$('#more_info .clear').before( "<a id='tab2' href='javascript:void(0);' data='"+tab_url+"'>"+tab_title+"<span> (0)</span> </a>")
					}
					$('.standard_tabs_top a').removeClass('current');
				    $('.standard_tabs_top a#tab2').addClass('current');
				    $.ajax({
						url: tab_url,
						beforeSend: function( ) {
							var num = parseInt($('#tab2 span').html().replace('(', '').replace(')', '')) + 1;
							$('#tab2 span').html('(' + num + ')');
							console.log(num);
							$('.standard_tabs_in').html('<div class="review_list_wrap">loading...</div>');
						  },
						success: function( data ) {
							$('.standard_tabs_in').html(data);
							update = false;
                                                       $('.report_success2').fadeOut().empty();
                                                           
                                                        $('.report_success1').css('display', 'inline-block');
                                                        setTimeout(function() {
                                                         $(".report_success1").fadeOut().empty();
                                                         }, 8000);
						}
					});
	
				}
			}
			<?php elseif ($template == 'ppp'):?>
			success: function(data) {
				if (data.error != undefined && data.error == false) {
					 $.ajax({
							url: ppp_url,
							beforeSend: function( ) {
								$('.place_lists').html('<div class="review_list_wrap">loading...</div>');
								$('.place_lists').show();
							  },
							success: function( data ) {
								$('.place_lists').html(data);
								update = false;
                                                                $('.report_success2').fadeOut().empty();
                                                           
                                                                $('.report_success1').css('display', 'block');
                                                                setTimeout(function() {
                                                                 $(".report_success1").fadeOut().empty();
                                                                 }, 10000);
                                                                
							}
						});
					
				}
			}
			<?php endif;?>		
		})
		$('#autocomplete_list_copany_list').val('');
		$('#list_copany_list').removeAttr('value');
	}
    return false;
});
})
</script>