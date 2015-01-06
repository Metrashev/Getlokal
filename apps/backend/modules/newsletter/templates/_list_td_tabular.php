<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo link_to($newsletter->getId(), 'newsletter_edit', $newsletter) ?>
</td>
<td class="sf_admin_boolean sf_admin_list_td_is_active">
  <?php echo get_partial('newsletter/list_field_boolean', array('value' => $newsletter->getIsActive())) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_name">
  <?php echo $newsletter->getName() ?> - <?php echo mb_convert_case($newsletter->getCountry()->getSlug(), MB_CASE_UPPER); ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_country_id">
  <?php echo $newsletter->getCountry() ?>
</td>
<td class="sf_admin_enum sf_admin_list_td_user_group">
  <?php echo $newsletter->getUserGroup() ?>
</td>
<td class="sf_admin_date sf_admin_list_td_created_at">
  <?php echo false !== strtotime($newsletter->getCreatedAt()) ? format_date($newsletter->getCreatedAt(), "f") : '&nbsp;' ?>
</td>
<td class="sf_admin_date sf_admin_list_td_updated_at">
  <?php echo false !== strtotime($newsletter->getUpdatedAt()) ? format_date($newsletter->getUpdatedAt(), "f") : '&nbsp;' ?>
</td>
