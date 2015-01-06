<?php use_helper('Date', 'TimeStamps');?>
<li class="nav-item new-mail-message hidden-xs hidden-sm">
	<a href="javascript:void(0)">
		<i class="fa fa-comments fa-lg ico-messages">
			<?php if ($message_info_count > 0){ ?>
				<span class="new-mail-message-circle"></span>
			<?php } ?>
		</i>
	</a>
	<div class="section-messages">
		<div class="messages-body">
			<div class="border-arrow"></div>

			<ul>
				<?php if(!count($message_info)){ ?>
					<li><div class="no-messages-notification"><?php echo __('No messages', null, 'dashboard'); ?></div></li>
				<?php } ?>

				<?php foreach ($message_info as $notification){ 
					  $message = $notification->getObj();
					  if($message->getId()){ ?>
						<li>
							<div class="message-image alignleft">
								<?php if($message->getPage()->getType() == PageTable::COMPANY_PAGE){ 
										if ($page_admin){ 
									    	echo link_to(image_tag($message->getPage()->getCompany()->getThumb(1)). ' '. image_tag($message->getPage()->getCompany()->getCompanyTitle()), 'companySettings/conversations?slug='. $page_admin->getCompanyPage()->getCompany()->getSlug() .'#'.$message->getPageId());
									    } else{
									        echo link_to(image_tag($message->getPage()->getCompany()->getThumb(1)). ' '. $message->getPage()->getCompany()->getCompanyTitle(), 'profile/conversations'.'#'.$message->getPageId());
									   	} 

								 	  } elseif($message->getPage()->getType() == PageTable::USER_PAGE){
									    if ($page_admin){
									        echo link_to(image_tag($message->getPage()->getUserProfile()->getThumb(1)). ' '. $message->getPage()->getUserProfile(), 'companySettings/conversations?slug='. $page_admin->getCompanyPage()->getCompany()->getSlug() .'#'.$message->getPageId());
									    } else{
									         echo link_to(image_tag($message->getPage()->getUserProfile()->getThumb(1)). ' '. $message->getPage()->getUserProfile(), 'profile/conversations'.'#'.$message->getPageId());
									    }
							     	} ?>
							</div>
						</li>
					  <?php } ?>
				<?php } ?>
			</ul>
		</div><!-- messages-body -->
	</div><!-- section-messages -->
</li>