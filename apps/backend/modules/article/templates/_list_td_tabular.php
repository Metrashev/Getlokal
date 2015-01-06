<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo link_to($article->getId(), 'article_edit', $article) ?>
</td>
<td class="sf_admin_enum sf_admin_list_td_title">
  <?php echo link_to($article->getTitleByCulture(), '/'. $sf_user->getCulture().'/article/'.$article->getSlug(), 'target=_blank' ) ?>
</td>
<td class="sf_admin_enum sf_admin_list_td_status">
  <?php echo $article->getStatus() ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_user_id">
<?php echo link_to( $article->getUserProfile(),'/'. $sf_user->getCulture().'/profile/'. $article->getUserProfile()->getSfGuardUser()->getUserName(), 'target=_blank') ?>
  <?php //echo $article->getUserId() ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_country_id">
  <?php echo $article->getCountry()->getName() ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_location_id">
  <?php echo $article->getCity()->getName() ?>
</td>
<td class="sf_admin_date sf_admin_list_td_created_at">
  <?php echo false !== strtotime($article->getCreatedAt()) ? format_date($article->getCreatedAt(), "f") : '&nbsp;' ?>
</td>
<td class="sf_admin_date sf_admin_list_td_updated_at">
  <?php echo false !== strtotime($article->getUpdatedAt()) ? format_date($article->getUpdatedAt(), "f") : '&nbsp;' ?>
</td>
