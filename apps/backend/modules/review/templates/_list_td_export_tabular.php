<td class="sf_admin_text sf_admin_list_td_firstName">
  <?php echo link_to( $review->getUserProfile(),'http://www.getlokal.com/'. $sf_user->getCulture().'/profile/'. $review->getUserProfile()->getSfGuardUser()->getUserName());?>
</td>
<td class="sf_admin_text sf_admin_list_td_lastName">
  <?php echo $review->getUserProfile()->getsfGuardUser()->getLastName(); ?>
</td>
<td class="sf_admin_text sf_admin_list_td_email">
  <?php echo $review->getUserProfile()->getsfGuardUser()->getEmailAddress(); ?>
</td>
<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo $review->getId(); ?>
</td>
<td class="sf_admin_text sf_admin_list_td_date">
  <?php echo $review->getCreatedAt() ; ?>
</td>
