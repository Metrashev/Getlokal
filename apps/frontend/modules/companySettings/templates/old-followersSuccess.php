<?php slot('no_ads', true) ?>
<?php use_helper('Pagination', 'jQuery') ?>
<div class="settings_content">
	<p class="settings_right_msg"><?php echo format_number_choice('[0]No followers|[1]1 follower|(1,+Inf]%count% followers', array('%count%' => $pager->getNbResults()), $pager->getNbResults(),'messages'); ?></p>
	<h2><?php echo __('Followers')?></h2>
   
	<?php if($pager->getNbResults() > 0): ?>
     <div class="company_followers">
       <?php foreach($pager->getResults() as $follower): ?>
           
         <div class="company_follower"  id="company_follower<?php echo $follower->getUserProfile()->getUserPage()->getId() ?>">
           <?php echo $follower->getUserProfile()->getLink(1, 'size=45x45', '', ESC_RAW). ' '.link_to($follower->getUserProfile(), '@user_page?username='.$follower->getUserProfile()->getsfGuardUser()->getUsername()); ?>
           
           <?php if(sfConfig::get('app_enable_messaging')):?>
             <?php if ($follower->getInternalNotification()):?>
             
             
               <?php echo link_to(__('Send Message'), 'message/view?user='.$follower->getUserProfile()->getUserPage()->getId(), array('class'=>'button_pink btn_msg')) ?>
               <?php if ($follower->getMessagesCount()):?>
                 <?php echo link_to(__('View Messages').' <img src="/images/gui/menu_user_arrow.png" />', 'message/view?user='.$follower->getUserProfile()->getUserPage()->getId(), array('class'=>'right')) ?>
               <?php endif;?>
             <?php endif;?>
           <?php endif;?>
          
           <div class="clear"></div>
         </div>
        
       <?php endforeach;?>
       
        
        <div id="message_content"><div style="display:none"></div></div>
       <?php  echo pager_navigation($pager, 'companySettings/followers'); ?>
     </div>
   <?php endif;?> 
</div>
<div class="clear"></div>

<script type="text/javascript">
$(document).ready(function() {
 $('.company_follower a.button_pink').click(function() {
  if ($('#message_content > div').css('display') == 'block') 
  {   $('.btn_msg').css({'background' : '#a9287a', 'color':'#fff'});  
      $('#message_content > div').slideUp('fast');
      
      console.log(1);
       
  }
  else {   
   var elem = $(this);
   $(this).css({'background' : '#fff', 'color':'#414040', 'border':'1px #a9287a solid', 'border-bottom': 'none', 'border-bottom-right-radius:': 'none', 'border-bottom-left-radius:': 'none'});
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
     if (elem.hasClass('btn_msg'))
      $('#message_content div div.messages_scroll').hide();
       
            var btnWidth = $('.btn_msg').outerWidth();
            $('.message_mask').css('width', btnWidth );
            $('.btn_msg').click(function() {    
            
    });
    $('input.button_pink').click(function() {      
          $('.btn_msg').css({'background' : '#a9287a', 'color':'#fff'}); 
    });
    
       },
       complete: function() {
     $('#message_content .messages_scroll').tinyscrollbar_update('bottom');
       }
   });
  }
  return false;
 });

  $('.company_follower a.right').click(function() {
                
		var elem = $(this);
		var parent = $(this).parent();
		if ($('#message_content > div').css('display') === 'block') $('#message_content > div').slideUp('fast');
		else {
			$.ajax({
				url: this.href,
				beforeSend: function() {
					parent.append($('#message_content'));
					$('#message_content  div').hide();
                                        
				},
				success: function(data, url) {
					$('#message_content div').html(data);
					$('#message_content div').slideDown('fast');
                                        $('.response').css({'display':'none'});
					if ($('#message_content .messages_scroll .overview > div').length > 3) {
						$('#message_content .messages_scroll').tinyscrollbar({size: 215});
					}
					else {
						$('#message_content .messages_scroll .viewport').css({height:'auto'});
						$('#message_content .messages_scroll .overview').css({position:'static'});
						$('#message_content .messages_scroll .scrollbar').remove();
					}
					if (elem.hasClass('btn_msg'))
						$('#message_content div div.messages_scroll').hide();
			    },
			    complete: function() {
					$('#message_content .messages_scroll').tinyscrollbar_update('bottom');
                                       
                                        
			    }
			});
		}
		return false;
	});
 
        
});
</script>
<script>
            $(document).click(function (event) {
                if (($(event.target).closest('.settings_user_company_form').get(0) == null) && ($(event.target).closest('.response').get(0) == null) )
                { $("#message_content > div").hide('fast') 
                 $('.btn_msg').css({'background' : '#a9287a', 'color':'#fff'});
                }
            });
           
           
</script>

