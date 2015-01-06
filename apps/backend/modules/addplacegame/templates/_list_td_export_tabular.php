
<td class="sf_admin_text sf_admin_list_td_first_name">
  <?php echo $user_profile; ?>
</td>
<td class="sf_admin_text sf_admin_list_td_email_address">
  <?php echo $user_profile->getEmailAddress() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_approved_places">
 <?php
  $companies= $user_profile->getSugestedCompanies('approved', $from, $to);

  $count = count($companies);
  echo $count;
   $companies->free();
?>
<?php $user_profile->free();?>

</td>
