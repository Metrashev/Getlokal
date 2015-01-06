<?php foreach($pager->getResults() as $followed_page): ?>    
<?php $send_message = true;?>
         <div class="company_follower">     
          <?php if(get_class($followed_page->getPage()->getRawValue()) =='CompanyPage'):?>
             <?php echo link_to(image_tag($followed_page->getPage()->getCompany()->getThumb(1), array('alt'=>$followed_page->getPage()->getCompany()->getCompanyTitle())), $followed_page->getPage()->getCompany()->getUri(ESC_RAW), array('title'=>$followed_page->getPage()->getCompany()->getCompanyTitle())). ' '. link_to_company($followed_page->getPage()->getCompany()); ?>        
             <?php $company = $followed_page->getPage()->getCompany(); ?>
             <?php if  (!$company->getActivePPPService(true)):?>
                <?php $send_message = false;?>
             <?php endif;?>
          <?php else:?>
			<?php echo $followed_page->getPage()->getUserProfile()->getLink(1, 'width=45',ESC_RAW). ' '.link_to_public_profile($followed_page->getPage()->getUserProfile(), array('class'=>'user')); ?>    
         <?php endif;?>

           

         <?php if ($is_current_user):?>
           <?php if($user && !$is_other_place_admin_logged):?>
				<?php echo link_to(__('Unfollow'), 'follow/stopFollow?page_id='. $followed_page->getPageId(), array('class' =>'button_pink button_clickable button_clicked btn_follow')); ?>
			<?php endif;?>
             <?php if(sfConfig::get('app_enable_messaging')):?>
              <?php if ($send_message):?>
                <?php if ($followed_page->getInternalNotification()):?>
                   <?php echo link_to(__('Send Message'), 'message/view?user='.$followed_page->getPageId(), array('class'=>'button_pink button_clickable btn_msg')) ?>
                <?php endif;?>
              <?php endif;?>
            <?php endif;?>
          <?php endif;?>
		<div class="clear"></div>
	</div>        
<?php endforeach;?>
