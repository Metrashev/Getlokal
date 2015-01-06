<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo link_to($newsletter_user->getId(), 'newsletter_user_edit', $newsletter_user) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_UserProfile">
  <?php echo $newsletter_user->getUserProfile() ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_newsletter_id">
  <?php echo $newsletter_user->getNewsletterId() ?>
</td>
<td class="sf_admin_boolean sf_admin_list_td_is_active">
  <?php echo get_partial('newsletteruser/list_field_boolean', array('status' => $status, 'value' => $newsletter_user->getIsActive())) ?>
</td>
