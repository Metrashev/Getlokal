<?php use_helper('Date', 'TimeStamps');?>						

<li class="nav-item new-mail">
	<a href="javascript:void(0)">
		<i class="fa fa-bell fa-lg notification-ico hidden-xs hidden-sm">
			<?php if ($feed_info_count > 0){ ?>
				<span class="new-mail-circle"></span>
			<?php } ?>
		</i>
	</a>
	<div class="section-notifications">
			<div class="border-arrow"></div>

			<ul>
				<?php if (!count($feed_info)){ ?>
					<li><div class="no-notifications-found"><?php echo __('No notifications', null, 'dashboard'); ?></div></li>
				<?php } ?>

				<?php foreach ($feed_info as $notifications){ 
					$obj = $notifications->getObj(); 
					switch ($notifications->getModelName()) {
					  	case 'Badge': ?>
						  	<li>
						  		<div class="notification-image alignleft">
									<?php echo link_to(image_tag($obj->getFile('active_image')->getUrl()),'badge/show?id=' .$obj->getId(), array('popup'=>true)); ?>
								</div><!--notification-image -->
						      
								<div class="notification-content alignleft">
									<p><?php echo sprintf(__('You just unlocked the %s badge', null, 'dashboard'), link_to($obj->getName(),'badge/show?id=' .$obj->getId(), array('popup'=>true))); ?></p>
									<small><?php echo ezDate(date('d.m.Y H:i', strtotime($notifications->getCreatedAt()))); ?></small>
								</div><!-- notification-content -->
						    </li>
					  	<?php break;?>

			        	<?php case 'Page':
				          	if($obj->getId()){ ?>
						    <li>
							    <div class="notification-image alignleft">
							    	<?php echo link_to(image_tag($obj->getUserProfile()->getThumb(), array('alt'=>$obj->getUserProfile())),'@user_page?username='.$obj->getUserProfile()->getsfGuardUser()->getUsername(), array('popup'=>true, 'title'=>$obj->getUserProfile())) ?>
							    </div><!-- notification-image alignleft -->

							    <div class="notification-content alignleft">
							    	<p><?php echo sprintf(__('%s is now following you', null, 'dashboard'),link_to($obj->getUserProfile(),'@user_page?username='.$obj->getUserProfile()->getsfGuardUser()->getUsername(), array('popup'=>true, 'title'=>$obj->getUserProfile())) ); ?></p>
									<small><?php echo ezDate(date('d.m.Y H:i', strtotime($notifications->getCreatedAt()))); ?></small>
							    </div><!-- notification-content -->
						      </li>
						  <?php } 
					  		break;
					  	}
					} ?>
			</ul>
	</div><!-- section-notifications -->
</li>