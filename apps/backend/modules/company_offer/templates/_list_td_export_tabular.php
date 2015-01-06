<?php use_helper('Date')?>

<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo $company_offer->getId() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_title">
  <?php echo $company_offer->getTitle() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_company">
  <?php echo $company_offer->getCompany() ?>
</td>
<td class="sf_admin_date sf_admin_list_td_active_from">
  <?php echo false !== strtotime($company_offer->getActiveFrom()) ? format_date($company_offer->getActiveFrom(), "f") : '&nbsp;' ?>
</td>
<td class="sf_admin_date sf_admin_list_td_active_to">
  <?php echo false !== strtotime($company_offer->getActiveTo()) ? format_date($company_offer->getActiveTo(), "f") : '&nbsp;' ?>
</td>
<td class="sf_admin_text sf_admin_list_td_count_voucher_codes">
  <?php echo $company_offer->getCountVoucherCodes() ?>
</td>
