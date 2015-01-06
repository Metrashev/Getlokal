<?php use_helper('Date');?>

<td class="sf_admin_enum sf_admin_list_td_pageAadmin">
  <?php foreach ($company->getCompanyPage()->getPageAdmin() as $pageAdmin): ?>
    <?php echo $pageAdmin->getUserProfile();?><br>
  <?php endforeach;?>
</td>

<td class="sf_admin_text sf_admin_list_td_title">
  <?php echo $company->getCompanyTitleByCulture('en'); ?>
</td>

<td class="sf_admin_foreignkey sf_admin_list_td_sector">
  <?php echo $company->getSector(); ?>
</td>

<td class="sf_admin_foreignkey sf_admin_list_td_classification">
  <?php echo $company->getClassification(); ?>
</td>

<td class="sf_admin_text sf_admin_list_td_location">
  <?php echo ($company->getLocation()->getStreet().' '.$company->getLocation()->getStreetNumber()); ?>
</td>

<td class="sf_admin_text sf_admin_list_td_phone">
  <?php echo $company->getPhoneFormated();?>
  <br>
  <?php //echo $company->getPhoneFormated($company->getPhone1());?>
  <br>
  <?php //echo $company->getPhoneFormated($company->getPhone2());?>
</td>

<td class="sf_admin_foreignkey sf_admin_list_td_city" >
  <?php echo $company->getCity(); ?>
</td>

<td class="sf_admin_foreignkey sf_admin_list_td_county" >
  <?php echo $company->getCounty(); ?>
</td>

<td class="sf_admin_text sf_admin_list_td_facebook">
  <?php echo ($company->getFacebookUrl()); ?>
</td>

<td class="sf_admin_text sf_admin_list_td_website">
  <?php echo ($company->getWebsiteUrl()); ?>
</td>

<td class="sf_admin_text sf_admin_list_td_placeUrl">
  <?php $domain = sfContext::getInstance()->getRequest()->getHost(); ?>
  <?php echo $domain.'/en/'.$company->getCity()->getSlug(). '/'.$company->getSlug(); ?>
</td>

<td class="sf_admin_text sf_admin_list_td_claimUrl">
  <?php $domain = sfContext::getInstance()->getRequest()->getHost(); ?>
  <?php echo $domain.'/en/d/company/claim/slug'.'/'.$company->getSlug(); ?>
</td>

<td class="sf_admin_text sf_admin_list_td_premium">
  <?php echo ($company->getActivePPPService(true)); ?>
</td>

<td class="sf_admin_text sf_admin_list_td_claim">
  <?php echo $company->getIsClaimed(); ?>
</td>
