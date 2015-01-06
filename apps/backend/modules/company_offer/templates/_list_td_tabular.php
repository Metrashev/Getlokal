
<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo $company_offer->getId() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_title">
  <?php echo __('<strong>%%company_offer%%</strong><br> <small>from %%company%%</small>',

          array(
              '%%company_offer%%' => $company_offer->getTitle(),
              '%%company%%' => $company_offer->getCompany(),
           ), 'messages'
      )
  ?>    
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
