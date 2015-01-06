<?php  foreach ($pager->getResults() as $conversation): ?>
  <div class="company_follower"  id="<?php echo $conversation->getToPage()->getId()?>">
  <?php echo link_to('<img src="/images/gui/close.png" alt="X" />', 'message/delete?id='.$conversation->getId(), 'class=messageDelete confirm='.__('Do you really want to delete this converstaion?')) ?>
  <span><?php echo ezDate(date('d.m.Y H:i', strtotime($conversation->getUpdatedAt()))); ?></span>
    <div class="clear"></div>
  <?php if(get_class($conversation->getToPage()->getRawValue()) =='CompanyPage'):?>
    <?php $company = $conversation->getToPage()->getCompany();?>
    <?php echo link_to(image_tag($company->getThumb(1), array('alt'=>$company->getCompanyTitle())),$company->getUri(ESC_RAW)) ?>
    <?php echo link_to_company($company)?>
  <?php else:?>
    <?php $user_profile =$conversation->getToPage()->getUserProfile();?>
    <?php echo $user_profile->getLink(1, 'width=45',ESC_RAW) ;?>
    <?php echo link_to_public_profile($user_profile, array('class'=>'user'));?>
  <?php endif;?>
  <?php echo link_to(__('View Messages'), 'message/view?user='.$conversation->getToPage()->getId(), 'class="button_pink button_clickable"') ?>
  <?php if(!$conversation->getMessage()->getIsRead()):?>
    <p><strong><?php echo (mb_strlen($conversation->getMessage()->getBody(), 'UTF8') <= 53 )? $conversation->getMessage()->getText() : mb_substr($conversation->getMessage()->getBody(), 0, 50, 'UTF8').'...';?></strong></p>
  <?php else:?>
    <p><?php echo (mb_strlen($conversation->getMessage()->getBody(), 'UTF8') <= 53 )? $conversation->getMessage()->getBody() : mb_substr($conversation->getMessage()->getBody(), 0, 50, 'UTF8').'...';?></p>
  <?php endif;?>
  <div class="clear"></div>
  </div>
<?php endforeach;?>