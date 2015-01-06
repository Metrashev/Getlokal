<?php
    decorate_with('bootstrap');
    use_helper('Text');
    $company = $offer->getCompany();
    $marker = image_path('gui/icons/marker_'. $company->getSectorId(), true);
    slot('container-class', 'offer-container');

    // vouchers
    $vouchers = $offer->getMaxVouchers() - $offer->getCountVoucherCodes();
    if ($vouchers > 99 || !$vouchers) {
        $vouchers = '99+';
    }
?>

<div class="clearfix" id="offer">
    <div class="image">
        <div class="count">
            <?php echo $offer->getDisplayVouchersRemaining(); ?>
        </div>
        <img src="<?php echo $offer->getImage()->getThumb(); ?>"
            alt="<?php echo $offer->getDisplayTitle(); ?>" class="img-responsive">
        <div class="title">
            <div class="row">
                <div class="col-xs-12">
                    <?php echo truncate_text($offer->getDisplayTitle(), 60); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8 cls">
                    <?php echo $company->getClassification(); ?>
                </div>
                <div class="col-xs-4 distance text-right">
                    <?php echo number_format($offer->kms, 2); ?> <?php echo __('km') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="company">
        <a href="getlokal://location?<?php echo $company->getId(); ?>">
            <div class="bg" style="background-image: url(<?php echo $marker; ?>);">
                <?php echo $offer->getCompany()->getI18nTitle(); ?>
            </div>
        </a>
    </div>

    <div class="description">
        <?php
            // strip any html attributes (like class and style)
            echo preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $offer->getDisplayDescription(ESC_RAW));
        ?>
    </div>

    <div class="order">
        <div class="row">
            <div class="col-xs-7">
                <?php echo __("Voucher valid from") ?>
                <strong><?php echo $offer->getDateTimeObject('valid_from')->format('d / m / y') ?></strong>
                <br/>
                <?php echo __(" to ") ?>
                <strong><?php echo $offer->getDateTimeObject('valid_to')->format('d / m / Y') ?></strong>
            </div>
            <div class="col-xs-5 text-right">
                <?php
                    $vouchers = $offer->getDisplayVouchersRemaining(true);
                    if ($vouchers < 0 || $vouchers > 99) {
                        $voucher_text = "99+" . __(" available");
                    } elseif ($vouchers == 1) {
                        $voucher_text = __("1 available");
                    } elseif ($vouchers > 1) {
                        $voucher_text = $vouchers . __(" available");
                    } else {
                        $voucher_text = __("0 available");
                    }
                ?>
                <strong><?php echo $voucher_text; ?></strong>
            </div>
        </div>
        <div class="col-xs-12">
            <a href="getlokal://claim?<?php echo $offer->getId(); ?>"
                class="btn btn-lg-purple"><?php echo __("getVoucher") ?></a>
        </div>
    </div>
</div>
