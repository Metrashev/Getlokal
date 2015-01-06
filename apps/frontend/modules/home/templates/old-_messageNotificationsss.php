<?php use_helper('Date', 'TimeStamps');?>
<div class="header_user_msg">
          	<div class="message_icon">
				<!--<img src="/images/gui/icon_msg.png" />-->
                                <!--<img src="/images/gui/messages_icon.png" />-->
				<?php if ($message_info_count > 0): ?>
				<span class="count"><?php echo $message_info_count;?></span>
				<?php endif;?>
			</div>
			<?php // if ($message_info_count > 0): ?>
			<div class="dropdown_wrap">
			<img src="/images/gui/pointer_up.png" />
			<ul>
			<?php if(!count($message_info)): ?>
				<li><?php echo __('No messages', null, 'dashboard'); ?></li>
			<?php endif; ?>
			<?php foreach ($message_info as $notification):?>
		    <?php $message = $notification->getObj();?>
		   		<?php if($message->getId()): ?>
			     <li>
			      <?php if($message->getPage()->getType() == PageTable::COMPANY_PAGE):?>
				    <?php if ($page_admin):?>
				           <?php echo link_to(image_tag($message->getPage()->getCompany()->getThumb(1)). ' '. image_tag($message->getPage()->getCompany()->getCompanyTitle()), 'companySettings/conversations?slug='. $page_admin->getCompanyPage()->getCompany()->getSlug() .'#'.$message->getPageId()) ?>
				          <?php else:?>
				        <?php echo link_to(image_tag($message->getPage()->getCompany()->getThumb(1)). ' '. $message->getPage()->getCompany()->getCompanyTitle(), 'profile/conversations'.'#'.$message->getPageId()) ?>
				       <?php endif?>  
     
				      
				        <?php elseif($message->getPage()->getType() == PageTable::USER_PAGE):?>
				          <?php if ($page_admin):?>
				           <?php echo link_to(image_tag($message->getPage()->getUserProfile()->getThumb(1)). ' '. $message->getPage()->getUserProfile(), 'companySettings/conversations?slug='. $page_admin->getCompanyPage()->getCompany()->getSlug() .'#'.$message->getPageId()) ?>
				          <?php else:?>
				        <?php echo link_to(image_tag($message->getPage()->getUserProfile()->getThumb(1)). ' '. $message->getPage()->getUserProfile(), 'profile/conversations'.'#'.$message->getPageId()) ?>
				       <?php endif?>
				        <?php endif;?>
			       <p><?php echo (mb_strlen( $message->getBody(), 'UTF8') <= 33 )?  $message->getBody() : mb_substr($message->getBody(), 0, 30, 'UTF8').'...';?></p>
				   <p class="time"><?php echo ezDate(date('d.m.Y H:i', strtotime($notification->getCreatedAt()))); ?></p>
				   <div class="clear"></div>
			      </li>
			  <?php endif; ?>
			<?php endforeach;?>		  
			<li>
				<?php /* <a href="">SEE ALL</a> */ ?>
			</li>		 
			</ul>
			</div>
			<?php // endif;?>
</div>
          
          