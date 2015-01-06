<?php use_helper('Link')?>
  <?php $company = $page_admin->getCompanyPage()->getCompany(); ?>
<?php $path =  sfContext::getInstance ()->getConfiguration ()->generateFrontendUrl('company', array('sf_culture'=>'bg', 'slug'=>$company->getSlug(), 'city'=>$company->getCity()->getSlug()), false);?>

<td class="sf_admin_foreignkey sf_admin_list_td_user_id">
  <?php echo link_to($page_admin->getUserProfile(), 'sfGuardUser/edit?id='.$page_admin->getUserProfile()->getId());?>
<br/>
<?php echo $page_admin->getUserProfile()->getsfGuardUser()->getEmailAddress()?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_page_id">
<?php echo link_to($company->getTitle(),$path);?> - <strong>Status</strong> :  <?php echo $company->getStatus() ?><br>

</td>
<td class="sf_admin_text sf_admin_list_td_company_id">
  <?php echo $company->getId(); ?>
  
</td>
<td class="sf_admin_enum sf_admin_list_td_status">
  <?php echo $page_admin->getStatus() ?>
  
</td>

<td class="sf_admin_text sf_admin_list_td_position">
  <?php echo $page_admin->getUserPosition(); ?>
</td>
<td class="sf_admin_boolean sf_admin_list_td_is_primary">
  <?php echo get_partial('PageAdmin/list_field_boolean', array('value' => $page_admin->getIsPrimary())) ?>
</td>
<td class="sf_admin_date sf_admin_list_td_created_at">
  <?php echo false !== strtotime($page_admin->getCreatedAt()) ? format_date($page_admin->getCreatedAt(), "f") : '&nbsp;' ?>
</td>
<td class="sf_admin_date sf_admin_list_td_updated_at">
  <?php echo false !== strtotime($page_admin->getUpdatedAt()) ? format_date($page_admin->getUpdatedAt(), "f") : '&nbsp;' ?>
</td>
