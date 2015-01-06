<ul class="list-box-wrapper">
<?php foreach($pager->getResults() as $follower){ 
			$userProfile = $follower->getUserProfile();
			if($sf_user->getCulture() != 'sr'){
				$vr1 = $userProfile->getCountry()->getCountryNameByCulture();
				$vr2 = $userProfile->getCity()->getDisplayCity();
			}else{
				$vr1 = $userProfile->getCity()->getDisplayCity();
				$vr2 = $userProfile->getCountry()->getCountryNameByCulture();
			}
			$send_message = true;
	?>    
		<li class="list-box user">
		<div class="custom-row">
			<img src="<?=myTools::getImageSRC($userProfile->getThumb(), 'user')?>" class="img-circle profile-img">
			<div class="info">
				<?php echo link_to($follower->getUserProfile(), '@user_page?username='.$userProfile->getsfGuardUser()->getUsername(), 'class="name"'); ?>
				<div class="location"><i class="fa fa-map-marker"></i><?php echo $vr1.", ".$vr2?></div>
			</div>
		</div>
		<div class="custom-row">
		   <?php if(sfConfig::get('app_enable_messaging')):?>
               <?php if ($follower->getInternalNotification()):?>  
                 <?php echo link_to(__('Send Message'), 'message/view?user='.$follower->getUserProfile()->getUserPage()->getId(), array('class'=>'default-btn small')) ?>
                 <?php if ($follower->getMessagesCount()):?>
                   <?php echo link_to(__('View Messages'), 'message/view?user='.$follower->getUserProfile()->getUserPage()->getId(), array('class'=>'default-btn small')) ?>
                 <?php endif;?>
               <?php endif;?>
             <?php endif;?> 
		</div>
	</li><!-- END User -->
<?php }?>
</ul>