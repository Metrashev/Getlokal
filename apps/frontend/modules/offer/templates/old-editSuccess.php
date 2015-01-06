<?php slot('no_map', true) ?>
<?php slot('no_ads', true) ?>
<div class="settings_content">
    <h2><?php echo __('Edit Offer', null, 'offer') ?></h2>
    <?php if ($company_offer): ?>
        <?php include_partial('form', array(
            'form' => $form, 
            'company' => $company,
            'company_offer' => $company_offer,
            'active'=> isset($active) && $active == 1 ? 1 : null
        )); ?>
    <?php endif; ?>
</div>
