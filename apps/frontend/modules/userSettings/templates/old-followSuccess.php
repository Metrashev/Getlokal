<?php use_helper('Pagination','jQuery') ?>
<div class="settings_content">
  <h2><?php echo __('Follow Settings', null,'user')?></h2>
   <p><?php echo format_number_choice('[0] You follow 0 places/users|[1]You follow 1 place/user|(1,+Inf]You follow %count% places/users', array('%count%' => $pager->getNbResults()), $pager->getNbResults(),'messages'); ?></p>
   <?php if($pager->getNbResults() > 0): ?>
     <form action="<?php echo url_for('follow/multipleEdit'); ?>" method="post">
     
     <div>
       <?php foreach($pager->getResults() as $follow): ?>
         <div>         
           <?php if ($follow->getPage()->getType()== PageTable::USER_PAGE):?>
             <?php echo link_to_public_profile($follow->getPage()->getUserProfile());?><br/>
           <?php elseif ($follow->getPage()->getType()== PageTable::COMPANY_PAGE):?>
             <?php echo link_to_company($follow->getPage()->getCompany());?>            
           <?php endif;?>
           <?php echo link_to('Stop Follow', 'follow/stopFollow?page_id='. $follow->getPageId(), array('class' =>'button_green')); ?><br/>
          
          <input id="follow_page_<?php echo $follow->getPageId()?>_email_notification" type="checkbox" <?php echo ($follow->getEmailNotification()) ?  'checked="checked"' :'';?> name="follow_page[<?php echo $follow->getPageId()?>][email_notification]">
          <label for="follow_page_<?php echo $follow->getPageId()?>_email_notification">Email notification</label>
          <input id="follow_page_<?php echo $follow->getPageId()?>_internal_notification" type="checkbox" <?php echo ($follow->getInternalNotification()) ?  'checked="checked"' :'';?> name="follow_page[<?php echo $follow->getPageId()?>][internal_notification]">
          <label for="follow_page_<?php echo $follow->getPageId()?>_internal_notification">Messages</label>
          <input id="follow_page_<?php echo $follow->getPageId()?>_newsfeed" type="checkbox" <?php echo ($follow->getNewsfeed()) ?  'checked="checked"' :'';?> name="follow_page[<?php echo $follow->getPageId()?>][newsfeed]">
          <label for="follow_page_<?php echo $follow->getPageId()?>_newsfeed">Show in newsfeed</label>
          <input id="follow_page_<?php echo $follow->getPageId()?>_weekly_update" type="checkbox"<?php echo ($follow->getWeeklyUpdate()) ?  'checked="checked"' :'';?> name="follow_page[<?php echo $follow->getPageId()?>][weekly_update]">
          <label for="follow_page_<?php echo $follow->getPageId()?>_weekly_update">Receive weekly update email</label> 
          
     
</div>
       <?php endforeach;?>    
        <div class="form_box">
      <input type="submit" value="<?php echo __('Save');?>" class="input_submit" />
    </div>
</form> 
       <?php  echo pager_navigation($pager, 'userSettings/follow'); ?>
     </div>
   <?php endif;?> 
</div>
<div class="clear"></div>



