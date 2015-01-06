<?php use_helper('Date'); ?>
<?php slot('no_map', true) ?>
<?php $culture = $sf_user->getCulture(); ?>
<?php $company_offer = $voucher->getCompanyOffer(); ?>
<?php $company = $company_offer->getCompany(); ?>

<div class="voucher_print_wrap">
    <img class="voucher_bg" src="/images/gui/bg_vocher.png" />
    <div class="voucher_print">
        <h2><?php echo $company_offer->getDisplayTitle(); ?></h2>

        <p class="voucher_code"><span><?php echo __('Voucher Code', null, 'offer') ?>: <strong><?php echo $voucher->getCode(); ?></strong></span></p>

        <div class="left_wrap">
            <p><strong><?php echo $company->getCompanyTitle(); ?></strong></p>
            <p><?php echo $company->getDisplayAddress(); ?></p>
            <p><?php echo $company->getPhoneFormated(); ?></p>

        </div>

        <div class="right_wrap">
            <p><?php echo __('Name', null, 'form') ?>: <strong><?php echo $user->getUserProfile(); ?></strong></p>
            <p><?php echo __('Issued on', null, 'offer'); ?>: <strong><?php echo format_date($company_offer->getCreatedAt(), 'f', $culture); ?></strong></p>
            <p><?php echo __('Expires on', null, 'offer'); ?>: <strong><?php echo format_date($company_offer->getValidTo(), 'f', $culture); ?></strong></p>
        </div>
    </div>
</div>
<div class="voucher_description">
    <div class="cut_line">
        <img src="/images/gui/cut_line.png"/>
    </div>  
    <?php echo $company_offer->getDisplayDescription(ESC_RAW); ?>
</div>
<div class="voucher_controls">
    <a class="button_pink button_bigger" href="javascript:window.print()" onclick="window.print();
                return false;"><?php echo __('Print', null, 'offer') ?></a>
    <!-- <a class="button_pink button_bigger" href="#"><?php echo __('Send it to my email') ?></a>  -->
</div>


<script>
            $(document).ready(function() {
                $('.path_wrap').remove();
//                $('.search_bar').remove();
            });
</script>