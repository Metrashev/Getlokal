
<div class="default-form-wrapper embedded">
	<div class="embeded-form-container">
	<form action="<?php echo url_for('list/addToList') ?>" method="post" id="list_form" class="default-form">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="form-title">
					<?php echo __('Choose from Current Lists', null, 'list'); ?>
					<button type="button" class="close" onclick="$('#add_list_wrap').html('')"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="default-input-wrapper required<?php if($form['list']->hasError()):?> incorrect<?php endif;?>">
					<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
					<?php if($form['list']->hasError()):?>
					<div class="error-txt">
						<?php echo $form['list']->renderError();?>
					</div>
					<?php endif;?>
					<label for="<?= $form['list']->getName()?>" class="default-label"><?php echo $form['list']->renderLabelName()?>
					</label>
					<?php echo $form['list']->render(array('class'=>'default-input','placeholder'=>$form['list']->renderLabelName()));?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<input id="add_to_list" type="submit" value="<?php echo __( 'Add to List',null,'list') ?>" class="default-btn success pull-left" />
				<a href="<?php echo url_for('list/create')?>" title="" class="default-btn pull-right"><?php echo __('Add to New List',null,'list'); ?></a>
			</div>
		</div>
	</form>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
$('#list_form').on('submit',function() {  

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
			<?php if ($template =="none"):?>
			success: function(data){
				if(data.error != undefined && data.error == false){
					$("#list_form").prepend("<div class=\"form-message success\"><?php echo __('This place was successfully added to the list!', null, 'company') ?></div>")
				}
			}
			<?php endif;?>
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