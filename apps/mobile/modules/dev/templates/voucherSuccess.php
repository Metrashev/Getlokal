<?php
    decorate_with('bootstrap');
    $offer = $voucher->getCompanyOffer();
    $company = $offer->getCompany();
?>
<div class="clearfix" id="voucher">
    <div class="t"></div>
    <div class="content">
        <div class="col-xs-4">
            <?php echo image_tag('mobile/logo_tiny.png', array('class' => 'img-responsive')); ?>
        </div>
        <div class="col-xs-8 text-right code">
            <?php echo __('VOUCHER CODE') ?> :
            <strong><?php echo $voucher->getCode(); ?></strong>
        </div>
        <div class="image">
            <img src="<?php echo $offer->getImage()->getThumb('preview'); ?>"
                alt="<?php echo $offer->getDisplayTitle(); ?>" class="img-responsive">
        </div>
        <div class="title col-xs-12">
            <?php echo $offer->getDisplayTitle(); ?>
        </div>
        <div class="info col-xs-12">
            <strong><?php echo $company->getCompanyTitle(); ?></strong>
            <p>
                <?php echo $company->getCity(); ?> -
                <?php echo $company->getDisplayAddress(); ?>
                <?php if ($phone = $company->getPhoneFormated()): ?>
                    <?php echo $phone; ?>
                <?php endif ?>
            </p>
            <br>
            <p>
                <?php echo __('User'); ?>:
                <strong><?php echo $offer->getUserProfile(); ?></strong>
                <br>
                <?php echo __('Created at'); ?>:
                <strong><?php echo $voucher->getDateTimeObject('created_at')->format('d F Y'); ?></strong>
                <?php echo __('Valid until'); ?>:
                <strong><?php echo $offer->getDateTimeObject('valid_to')->format('d F Y'); ?></strong>
            </p>
        </div>
    </div>
    <div class="b"></div>
</div>
