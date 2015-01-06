<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo link_to($company->getId(), 'company_edit', $company) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_title_en">
  <?php echo link_to($company->getCompanyTitleByCulture('en'), '/en/'.$company->getCity()->getSlug(). '/'.$company->getSlug() ,array('target'=>'_blank')) ?>
<br><br>
<?php echo $company->getAddressInfo();?>
</td>
<td class="sf_admin_text sf_admin_list_td_phone">
  <?php echo $company->getPhoneFormated() ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_city_id">
  <?php echo $company->getCity()->getLocation() ?>
</td>

<td class="sf_admin_foreignkey sf_admin_list_td_classification_id">
  <?php echo $company->getClassification() ?> /  <?php echo $company->getSector() ?>
</td>
<td class="sf_admin_enum sf_admin_list_td_status">
  <?php echo $company->getStatus() ?>
</td>
<td class="sf_admin_enum sf_admin_list_page_admin">
  <?php foreach ($company->getCompanyPage()->getPageAdmin() as $pageAdmin): ?>
    <?php echo link_to($pageAdmin->getUserProfile(), url_for('PageAdmin/index?id='.$pageAdmin->getId()) );?> <?php echo $pageAdmin->getStatus()?><br>
  <?php endforeach;?>
</td>
<td class="sf_admin_date sf_admin_list_td_created_at">
  <?php echo false !== strtotime($company->getCreatedAt()) ? format_date($company->getCreatedAt(), "f") : '&nbsp;' ?>
</td>
<td class="sf_admin_date sf_admin_list_td_created_by">
 <?php if ($company->getCreatedByUser() && $company->getCreatedByUser()!=''):
   echo link_to($company->getCreatedByUser(),'user_profile/listShow?id='.$company->getCreatedByUser()->getId() , array('popup'=>true));
 endif; ?>
</td>