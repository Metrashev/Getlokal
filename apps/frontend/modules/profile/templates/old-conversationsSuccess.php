<?php //include_partial($partial,  array('pageUser' => $pageUser, 'pager' => $pager, 'is_current_user' => $is_current_user));?>
<?php use_helper('Date','TimeStamps');?>

<div class="review_list_wrap">
	<?php if ($pager->getNbResults() == 0): ?>
		<p><?php echo __('No messages', null, 'offer') ?></p>
	<?php else:?>
		 <?php include_partial('conversations', array ('pager' => $pager,  'user' => $user ));?>
	<?php endif;?>
	<div id="message_content"><div></div></div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$('.company_follower a.button_pink').click(function() {
		if (!$(this).hasClass('button_clicked')) {
			$('#message_content div').slideUp('fast').html('');
		}
		else {
			var elem = $(this);
			var parent = $(this).parent();
			parent.parent().find('a.button_pink').not($(this)).removeClass('button_clicked');
			$.ajax({
				url: this.href,
				beforeSend: function() {
					parent.append($('#message_content'));
					$('#message_content div').hide();
				},
				success: function(data, url) {
					$('#message_content div').html(data);
					$('#message_content div').slideDown('fast');
					if ($('#message_content .messages_scroll .overview > div').length > 3) {
						$('#message_content .messages_scroll').tinyscrollbar({size: 215});
					}
					else {
						$('#message_content .messages_scroll .viewport').css('height', $('#message_content .messages_scroll .viewport .overview').outerHeight());
						$('#message_content .messages_scroll').css('height', $('#message_content .messages_scroll .viewport .overview').outerHeight());
					}
			    },
			    complete: function() {
					$('#message_content .messages_scroll').tinyscrollbar_update('bottom');
                                         $('.company_follower .messageBox .response ').css({'position' : 'relative', 'border':'none', 'background':'none', 'right':'0', 'padding':'25px 0'});
			    }
			});
		}
		return false;
	});

	if(window.location.hash) {
	    var hash = window.location.hash.substring(1);
		$('#' + hash + ' a.button_pink').trigger('click');
	}
});
</script>

