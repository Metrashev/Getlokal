<?php use_helper('XssSafe') ?>
<?php slot('description') ?>
<?php if ($company->getCompanyDescription()):?>
  <?php echo $company->getCompanyDescription();?>
<?php else:?>
  <?php echo sprintf(__('%s, %s - detailed information', null, 'pagetitle'), $company->getCompanyTitle(), $company->getCity()->getLocation());?>
<?php endif;?>
<?php end_slot() ?>

<?php echo $company->getCompanyDetail()->getDetailDescription(ESC_XSSSAFE);?>


<script type="text/javascript">
$("document").ready(function() {

	$('.standard_tabs_top a').removeClass('current');
    $('.standard_tabs_top #tab_info').addClass('current');
    
});
</script>

