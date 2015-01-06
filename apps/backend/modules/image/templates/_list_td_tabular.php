<?php use_helper('Link')?>

<?php $linka =  sfContext::getInstance ()->getConfiguration ()->generateFrontendUrl('user_page', array('username'=>$image->getUserProfile()->getsfGuardUser()->getUsername(),'sf_culture'=>'en'), false);?>
<td class="sf_admin_text sf_admin_list_td_thumb">
  <?php echo get_partial('image/thumb', array('type' => 'list', 'image' => $image)) ?>
</td>
<td class="sf_admin_enum sf_admin_list_td_status">
  <?php echo $image->getStatus() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_caption">
  <?php echo $image->getCaption() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_user_profile">
   <?php echo link_to($image->getUserProfile(),$linka)?> 
</td>
<td class="sf_admin_text sf_admin_list_td_type">
  <?php echo $image->getType() ?>
  <?php if($image->getProfile()): ?>
     <?php echo image_tag('/sfDoctrinePlugin/images/tick.png') ?>
   <?php endif ?>
</td>
<td class="sf_admin_text sf_admin_list_td_company">
  <?php $path = link_to_frontend('company', array('sf_culture'=>'en', 'slug'=>$image->getCompanyImage()->getCompany()->getSlug(),  'city'=>$image->getCompanyImage()->getCompany()->getCity()->getSlug()),false);?>
  <?php echo link_to($image->getCompanyImage()->getCompany()->getTitle(),$path);?> 

</td>
