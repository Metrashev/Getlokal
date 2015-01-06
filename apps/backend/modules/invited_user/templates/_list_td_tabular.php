<td class="sf_admin_text sf_admin_list_td_email">
  <?php echo $invited_user->getUserProfile()->getSfGuardUser()->getFirstName(); ?>
</td>
<td class="sf_admin_text sf_admin_list_td_facebook_uid">
  <?php echo $invited_user->getUserProfile()->getSfGuardUser()->getLastName(); ?>
</td>
<td class="sf_admin_text sf_admin_list_td_hash">
  <?php echo $invited_user->getUserProfile()->getSfGuardUser()->getEmailAddress() ?>
</td>
<td class="sf_admin_enum sf_admin_list_td_invited_from">
  <?php echo $invited_user->getUserProfile()->getGender() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_points_to_invited">
  <?php echo $invited_user->getUserProfile()->getCity()->getName() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_points_to_user">
  <?php echo $invited_user->getCountInvitedFriends(); ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_user_id">
  <?php echo $invited_user->getCountAcceptedInvites(); ?>
</td>
