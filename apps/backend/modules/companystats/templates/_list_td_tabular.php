<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo link_to($company_stats->getId(), 'company_stats_edit', $company_stats) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_action_id">
  <?php echo $company_stats->getActionName(); ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_company_id">
   <?php echo link_to($company_stats->getCompany()->getTitle(), '/en/'.$company_stats->getCompany()->getCity()->getSlug(). '/'.$company_stats->getCompany()->getSlug() ,array('target'=>'_blank')) ?>
</td>
<td class="sf_admin_date sf_admin_list_td_month">
  <?php echo false !== strtotime($company_stats->getMonth()) ? format_date($company_stats->getMonth(), "MM/yyyy",'bg') : '&nbsp;' ?>
</td>
<td class="sf_admin_text sf_admin_list_td_views">
  <?php echo $company_stats->getViews() ?>
</td>
