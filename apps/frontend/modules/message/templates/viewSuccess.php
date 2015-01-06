<?php use_helper('TimeStamps');?>
<?php if(get_class($page_to->getRawValue()) =='UserPage'):?>
                	<?php $obj = $page_to->getUserProfile();
					$link=  $obj->getLink(1, ESC_RAW) ?>
                <?php else:?>
					<?php $obj =$page_to->getCompany();
					$link = link_to_company($obj) ?>     
                <?php endif;?>
<!-- <h3><?php //echo sprintf(__('Conversation with %s' ),$link);?></h3> -->

<div class="messageBox">
<?php if (count($messages) >0 ):?>
	<div class="messages_scroll">
		<div class="scrollbar"><div class="track"><div class="thumb"></div></div></div>
		<div class="viewport">
			<div class="overview">
				<?php foreach ($messages as $message): ?>
				
					<div class="content <?php echo $message->getPageId() == $page->getId()?'odd':''?>"  id="<?php echo $message->getPageId()?>">
						<div class="messageContent">
							<span><?php echo ezDate(date('d.m.Y H:i', strtotime($message->getCreatedAt()))); ?></span>
			       
					        <?php if(get_class($message->getPage()->getRawValue()) == 'CompanyPage'):?>
					        <?php echo link_to(image_tag($message->getPage()->getCompany()->getThumb(1)), $message->getPage()->getCompany()->getUri(ESC_RAW)). ' '. link_to_company($message->getPage()->getCompany()); ?>        
					        <?php else:?>
					          <?php echo $message->getPage()->getUserProfile()->getLink(1, 'width=45',ESC_RAW). ' '. link_to_public_profile($message->getPage()->getUserProfile(), array('class'=>'user')); ?>
					        <?php endif;?>
				          	<?php echo simple_format_text($message->getText()) ?>
			
			        	</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<?php endif;?>
    <div class="response default-container default-form-wrapper col-sm-12">
        <div class="message_mask form-container login container"></div>
      <form action="<?php echo url_for('message/view?user='. $page_to->getId())?>" method="post" id="message">
          <?php echo $form[$form->getCSRFFieldName()] ?>
          <?php echo $form['page_id']->render(array('value' => $page_to->getId())) ?>
              <div class="row">
                <div class="col-sm-12">
                  <div class="default-input-wrapper <?php echo $form['body']->hasError() ? 'incorrect': ''?>">
                    <label for="message"><?php echo __('New message')?></label>
                    <?php echo $form['body']->render(array('class' => 'default-input' )); ?>             
                    <div class=""><?php echo $form['body']->renderError() ?></div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="default-input-wrapper">
                    <input type="submit" value="<?php echo __('Send Message')?>" class="default-btn success button_pink" />
                  </div>
                </div>
              </div>
        </form>
      </div>
    <?php /* <a href="<?php echo url_for('message/index') ?>"><?php echo __('All Conversations');?></a> */ ?>
</div>

<script type="text/javascript">
$(document).ready(function() {	
	 $('.response textarea').val('');
    $('.messages_scroll').tinyscrollbar({size: 215});

    if ($('.messageBox').find('.overview').children('div').length > 3) {
     $('.messageBox .messages_scroll').tinyscrollbar({size: 215});
    }
    else {
     $('.messageBox .messages_scroll .viewport').css('height', $('#message_content .messages_scroll .viewport .overview').outerHeight());
     $('.messageBox .messages_scroll').css('height', $('.messageBox .messages_scroll .viewport .overview').outerHeight());
     $('.messageBox').find('.scrollbar').remove();
    }

    $('#message').submit(function(event) {       
           var $form = $(this);
           $.ajax({
               type: 'POST',
               cache: false,
               url: $form.attr("action"),
               data: $form.serializeArray(),            
               success  : function(data) {
                $('.messageBox').html(data);
                if ($('.messageBox').find('.overview').children('div').length > 3) {
        $('.messageBox .messages_scroll').tinyscrollbar({size: 215});
       }
       else {
        $('.messageBox .messages_scroll .viewport').css('height', $('#message_content .messages_scroll .viewport .overview').outerHeight());
        $('.messageBox .messages_scroll').css('height', $('.messageBox .messages_scroll .viewport .overview').outerHeight());
        $('.messageBox').find('.scrollbar').remove();
        $('.response').css({'display':'none'});
       }
               },
            complete: function() {
                $('.messageBox .messages_scroll').tinyscrollbar_update('bottom');
                $('.response').css({'display':'none'});
            }
           });
           return false;
       });
   });

</script>