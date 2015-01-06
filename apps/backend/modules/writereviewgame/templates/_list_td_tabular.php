<td class="sf_admin_text sf_admin_list_td_first_name">
  <?php echo $user_profile ?>
</td>
<td class="sf_admin_text sf_admin_list_td_email_address">
  <?php echo $user_profile->getEmailAddress() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_vouchers">
  <?php echo get_partial('writereviewgame/vouchers', array('type' => 'list', 'user_profile' => $user_profile, 'from' => $from,  'to' => $to)) ?>
</td>
