<?php use_helper('Pagination', 'jQuery') ?>
<div class="content_in_full">
	<h2><?php echo __('Following')?></h2>
	<p><?php echo format_number_choice('[0]No users or places being followed.|[1]1 followed.|(1,+Inf]%count% followed', array('%count%' => $pager->getNbResults()), $pager->getNbResults(),'messages'); ?></p>
   
	<?php if($pager->getNbResults() > 0): ?>
     <div class="company_followers user_followers">
       
              		 <?php include_partial('followed', array ('pager' => $pager,  'user' => $user,  'is_current_user'=>$is_current_user, 'pageuser' => $pageuser, 'is_other_place_admin_logged' => $is_other_place_admin_logged ));?>
        
        <div id="message_content"><div style="display:none"></div></div>
      
     </div>
   <?php endif;?> 
</div>
<div class="clear"></div>

<script type="text/javascript">
$(document).ready(function() {
	$('.company_follower a.button_pink').click(function() {
		if(!$(this).hasClass('btn_follow')) {
			if (!$(this).hasClass('button_clicked')) {
				$('#message_content div').slideUp('fast').html('');
			}
			else {
				var elem = $(this);
				var parent = $(this).parent();
				parent.parent().find('a.button_pink').not($(this)).not($('.btn_follow')).removeClass('button_clicked');
				$.ajax({
					url: this.href,
					beforeSend: function() {
						parent.append($('#message_content'));
						$('#message_content div').hide();
					},
					success: function(data, url) {
						$('#message_content div').html(data);
						$('#message_content div').slideDown('fast');
						if (elem.hasClass('btn_msg'))
							$('#message_content div div.messages_scroll').hide();
				    },
				    complete: function() {
						$('#message_content .messages_scroll').tinyscrollbar_update('bottom');
                                                 $('.company_follower .messageBox .response ').css({'position' : 'relative', 'border':'none', 'background':'none', 'right':'0', 'padding':'25px 0'});
				    }
				});
			}
			return false;
		}
	});
});
</script>

