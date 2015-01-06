<h2><?php echo __('Choose an existing list', null, 'messages'); ?></h2>
<form id="listForm" action="<?php echo url_for('list/addToList') ?>" method="post" id="list_form">
	<div class="form_box<?php if( $form['list']->hasError()):?> error<?php endif;?>">
		<?php echo $form['list']->renderLabel();?>
		<?php echo $form['list']->render();?>
		<?php if($form['list']->hasError()):?>
			<p class="error"><?php echo $form['list']->renderError();?></p>
		<?php endif;?>
	</div>
	<?php ?>
	<input id="add_to_list" type="submit" value="<?php echo __( 'Add',null,'messages') ?>" class="button_green" />
	<?php ?>
</form>
<div class="clear"></div>
    <script type="text/javascript">
        $(document).ready(function(){
            $("form#listForm").submit(function(){
              $('input').attr('readonly', true);
              $('input[type=submit]').attr("disabled", "disabled");
              $('a').unbind("click").click(function(e) {
                  e.preventDefault();
              });
            });
        });
    </script>
<script type="text/javascript">
$(document).ready(function() {
$('#list_form').submit(function() {  

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

					if( !$('#tab2') || $('#tab2') == undefined){
						$('#more_info .clear').before( "<a id='tab2' href='javascript:void(0);' data='"+tab_url+"'>"+tab_title+"<span>1</span> </a>")
					}
					$('.standard_tabs_top a').removeClass('current');
				    $('.standard_tabs_top a#tab2').addClass('current');
				    $.ajax({
						url: tab_url,
						beforeSend: function( ) {
							$('.standard_tabs_in').html('<div class="review_list_wrap">loading...</div>');
						  },
						success: function( data ) {
							$('.standard_tabs_in').html(data);
							update = false;
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
							  },
							success: function( data ) {
								$('.place_lists').html(data);
								update = false;
							}
						});
					
				}
			}
			<?php endif;?>		
		})
	}
    return false;
});
})
</script>