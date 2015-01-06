<?php slot('no_map', true) ?>
<?php slot('no_ads', true) ?>
<div class="settings_content">
  <?php if($companies):?>
  <?php foreach ($companies as $company):?>
  <?php echo $company->getCompanyTitle(); ?>
  <?php if ($company->getIsPageAdmin($adminuser)):?>
  <?php endif;?>
<?php endforeach;?>
<?php endif;?>


<br><br>
	<?php include_partial('companySettings/pageadmin_signin_form',array('form'=> new SigninPageAdminForm()));?>
<div class="clear"></div>
</div>