<td class="sf_admin_text sf_admin_list_td_first_name">
  <?php echo $user_profile->getFirstName() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_email_address">
  <?php echo $user_profile->getEmailAddress() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_suggested_places">
  <?php echo get_partial('addplacegame/suggested_places', array('type' => 'list', 'user_profile' => $user_profile, 'from' => $from,  'to' => $to)) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_approved_places">
  <?php echo get_partial('addplacegame/approved_places', array('type' => 'list', 'user_profile' => $user_profile, 'from' => $from,  'to' => $to)) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_rejected_places">
  <?php echo get_partial('addplacegame/rejected_places', array('type' => 'list', 'user_profile' => $user_profile, 'from' => $from,  'to' => $to)) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_pending_places">
  <?php echo get_partial('addplacegame/pending_places', array('type' => 'list', 'user_profile' => $user_profile, 'from' => $from,  'to' => $to)) ?>
</td>
