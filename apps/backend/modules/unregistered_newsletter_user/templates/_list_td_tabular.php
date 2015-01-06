<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo link_to($unregistered_newsletter_user->getId(), 'unregistered_newsletter_user_edit', $unregistered_newsletter_user) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_firstname">
  <?php echo $unregistered_newsletter_user->getFirstname() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_lastname">
  <?php echo $unregistered_newsletter_user->getLastname() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_email_address">
  <?php echo $unregistered_newsletter_user->getEmailAddress() ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_country_id">
  <?php echo $unregistered_newsletter_user->getCountry()->getName() ?>
</td>
