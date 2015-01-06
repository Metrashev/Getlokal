<?php slot('no_map', true) ?>
<?php slot('no_ads', true) ?>
<div class="settings_content">
<h2><?php echo __('Create an Offer', null,'offer');?></h2>
<?php if (isset($form)):?>

<?php include_partial('form', array('form' => $form, 'company' => $company)) ?>
<?php else:?>
 <?php if($sf_user->hasFlash('error')): ?>
    <div class="flash_success">
      <?php echo $sf_user->getFlash('error') ?>
    </div>
  <?php endif ?>
<?php endif;?>
</div>