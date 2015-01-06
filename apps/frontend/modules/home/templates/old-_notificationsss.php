<?php use_helper('Date', 'TimeStamps');?>
<div class="header_user_notif">
          	<div class="notification_icon">
				<!--<img src="/images/gui/icon_notif.png" />-->
                                <!--<img src="/images/gui/notification_icon.png" />-->
				<?php if ($feed_info_count > 0): ?>
				<span class="count"><?php echo $feed_info_count;?></span>
				<?php endif;?>
			</div>
			
			<div class="dropdown_wrap">
				<img src="/images/gui/pointer_up.png" />
				<ul>
			<?php if(!count($feed_info)): ?>
				<li><?php echo __('No notifications', null, 'dashboard'); ?></li>
			<?php endif; ?>
			<?php foreach ($feed_info as $notificationsss):?>
		    <?php $obj = $notificationsss->getObj();?>
			<?php switch ($notificationsss->getModelName()): 
			   case 'Badge': ?>
			     <li>
			       <?php echo link_to(image_tag($obj->getFile('active_image')->getUrl()),'badge/show?id=' .$obj->getId(), array('popup'=>true)); ?>
				  <p><?php echo sprintf(__('You just unlocked the %s badge', null, 'dashboard'), link_to($obj->getName(),'badge/show?id=' .$obj->getId(), array('popup'=>true))); ?></p>
				  <p class="time"><?php echo ezDate(date('d.m.Y H:i', strtotime($notificationsss->getCreatedAt()))); ?></p>
				   <div class="clear"></div>
			     </li>
	          <?php break;?>
	          <?php case 'Page':?>
	          <?php if($obj->getId()): ?>
			     <li>
			       <?php echo link_to(image_tag($obj->getUserProfile()->getThumb(), array('alt'=>$obj->getUserProfile())),'@user_page?username='.$obj->getUserProfile()->getsfGuardUser()->getUsername(), array('popup'=>true, 'title'=>$obj->getUserProfile())) ?>
			       <p><?php echo sprintf(__('%s is now following you', null, 'dashboard'),link_to($obj->getUserProfile(),'@user_page?username='.$obj->getUserProfile()->getsfGuardUser()->getUsername(), array('popup'=>true, 'title'=>$obj->getUserProfile())) ); ?></p>
				   <p class="time"><?php echo ezDate(date('d.m.Y H:i', strtotime($notificationsss->getCreatedAt()))); ?></p>
				   <div class="clear"></div>
			      </li>
			  <?php endif; ?>
	          <?php break;?>
			<?php endswitch;?>
		  <?php endforeach;?>
				<li>
				<?php /* <a href="">SEE ALL</a> */ ?>	
				</li>
			</ul>
			</div>
          </div>