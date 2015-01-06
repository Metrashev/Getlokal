<?php foreach($pager->getResults() as $follower): ?>           
         <div class="company_follower"  id="company_follower<?php echo $follower->getUserProfile()->getUserPage()->getId() ?>">
           <?php echo $follower->getUserProfile()->getLink(1, 'size=45x45', '', ESC_RAW). ' '.link_to($follower->getUserProfile(), '@user_page?username='.$follower->getUserProfile()->getsfGuardUser()->getUsername(), 'class="user"'); ?>
           <?php if ($is_current_user):?>
	           
              <?php if($user && !$is_other_place_admin_logged):?>
	               <?php $is_followed = Doctrine::getTable ( 'FollowPage' )->getFollowPage ( $user->getId (), $follower->getUserProfile()->getUserPage()->getId() )?>
	                 <?php if (!$is_followed):?>
	                   <?php echo link_to(__('Follow'), 'follow/follow?page_id='. $follower->getUserProfile()->getUserPage()->getId(), array('class' =>'button_pink button_clickable btn_follow')); ?>
	                 <?php else:?>
	                   <?php echo link_to(__('Unfollow'), 'follow/stopFollow?page_id='. $follower->getUserProfile()->getUserPage()->getId(), array('class' =>'button_pink button_clickable button_clicked btn_follow')); ?>
	                 <?php endif;?>
	             <?php endif;?>      
	           <?php endif;?>
           
             <?php if(sfConfig::get('app_enable_messaging')):?>
               <?php if ($follower->getInternalNotification()):?>  
                 <?php echo link_to(__('Send Message'), 'message/view?user='.$follower->getUserProfile()->getUserPage()->getId(), array('class'=>'button_pink button_clickable btn_msg')) ?>
                 <?php if ($follower->getMessagesCount()):?>
                   <?php echo link_to(__('View Messages'), 'message/view?user='.$follower->getUserProfile()->getUserPage()->getId(), array('class'=>'button_pink button_clickable')) ?>
                 <?php endif;?>
               <?php endif;?>
             <?php endif;?> 

           <div class="clear"></div>
         </div>        
<?php endforeach;?>
