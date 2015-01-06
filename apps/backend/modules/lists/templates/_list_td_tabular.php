<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo link_to($lists->getId(), 'lists_edit', $lists) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_title">
  <?php echo $lists->getTitle() ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_user_id">
<?php echo link_to( $lists->getUserProfile(),'/'. $sf_user->getCulture().'/profile/'. $lists->getUserProfile()->getSfGuardUser()->getUserName(), 'target=_blank') ?>
  <?php //echo $lists->getUserProfile() ?>
</td>
<td class="sf_admin_enum sf_admin_list_td_status">
  <?php echo $lists->getStatus() ?>
</td>
<td class="sf_admin_boolean sf_admin_list_td_is_open">
  <?php echo get_partial('lists/list_field_boolean', array('value' => $lists->getIsOpen())) ?>
</td>
<td class="sf_admin_date sf_admin_list_td_created_at">
  <?php echo false !== strtotime($lists->getCreatedAt()) ? format_date($lists->getCreatedAt(), "f") : '&nbsp;' ?>
</td>
<td class="sf_admin_date sf_admin_list_td_updated_at">
  <?php echo false !== strtotime($lists->getUpdatedAt()) ? format_date($lists->getUpdatedAt(), "f") : '&nbsp;' ?>
</td>
