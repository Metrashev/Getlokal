<?php use_helper('Link') ?>
<?php $linka =  sfContext::getInstance ()->getConfiguration ()->generateFrontendUrl('user_page', array('username'=>$user_profile->getsfGuardUser()->getUsername(),'sf_culture'=>'en'),false);
?>
<td class="sf_admin_text sf_admin_list_td_thumb">
<?php echo link_to(get_partial('user_profile/thumb', array('type' => 'list', 'user_profile' => $user_profile)),$linka);?>

</td>
<td class="sf_admin_text sf_admin_list_td_is_active">
  <?php echo get_partial('user_profile/is_active', array('type' => 'list', 'user_profile' => $user_profile)) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_first_name">
 <?php echo link_to($user_profile->getFirstName(),$linka)?>
</td>
<td class="sf_admin_text sf_admin_list_td_last_name">
  <?php echo $user_profile->getLastName() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_email_address">
  <?php echo $user_profile->getEmailAddress() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_gender">
  <?php echo $user_profile->getGender() ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_city_id">
  <?php echo $user_profile->getCity()->getName() ?>
</td>
<td class="sf_admin_date sf_admin_list_td_created_at">
  <?php echo false !== strtotime($user_profile->getCreatedAt()) ? format_date($user_profile->getCreatedAt(), "f") : '&nbsp;' ?>
</td>
<td class="sf_admin_text sf_admin_list_td_allow_contact">
  <?php echo $user_profile->getAllowContact() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_allow_newsletter">
  <?php echo $user_profile->getAllowNewsletter() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_allow_b_cmc">
  <?php echo $user_profile->getAllowBCmc() ?>
</td>
