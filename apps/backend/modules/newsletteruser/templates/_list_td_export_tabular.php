<td class="sf_admin_text sf_admin_list_td_firstName">
  <?php echo $newsletter_user->getUserProfile()->getsfGuardUser()->getFirstName(); ?>
</td>
<td class="sf_admin_text sf_admin_list_td_lastName">
  <?php echo $newsletter_user->getUserProfile()->getsfGuardUser()->getLastName(); ?>
</td>
<td class="sf_admin_text sf_admin_list_td_email">
  <?php echo $newsletter_user->getUserProfile()->getsfGuardUser()->getEmailAddress(); ?>
</td>
<td class="sf_admin_text sf_admin_list_td_city">
  <?php echo $newsletter_user->getUserProfile()->getCity(); ?>
</td>