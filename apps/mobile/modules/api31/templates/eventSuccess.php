<?php
    decorate_with('bootstrap');

    $culture = $sf_user->getCulture();
    $countryId = $sf_user->getCountry()->getId();
?>

<div class="wrap clearfix" id="event">
    <a href="getlokal://images" class="image">
        <img src="<?php echo image_path($event->getThumb(2)); ?>" class="img-responsive">
    </a>
    <h4 class="col-xs-12"><?php echo $event->getDisplayTitle(); ?></h4>
    <?php if ($event->getFirstCompany()): ?>
        <div class="place clearfix">
            <div class="col-xs-9 title">
                <a href="<?php echo $companyUrl; ?>">
                    <?php echo $event->getFirstCompany(); ?>
                </a>
            </div>
            <div class="col-xs-3 text-right distance">
                <?php echo number_format($event->kms, 2) . ' ' . __('km'); ?>
            </div>
        </div>
    <?php endif ?>

    <div class="time clearfix">
        <div class="col-xs-6">
            <?php echo $event->getDateTimeObject('start_at')->format('d / m / y'); ?>
        </div>
        <?php if ($event->getStartH()): ?>
            <div class="col-xs-6 text-right">
                <?php echo substr($event->getStartH(), 0, -3); ?>
            </div>
        <?php endif ?>
    </div>

    <div class="col-xs-12">
        <div class="actions clearfix">
            <a href="getlokal://status" class="pull-left">
                <?php echo __('ATTEND'); ?>
            </a>
            <span class="pull-right">
                <?php echo __('%d participants', array('%d' => '<strong>'.$no_rspv.'</strong>')); ?>
            </span>
        </div>
    </div>
    <div class="col-xs-12">
        <p><?php echo $event->getDisplayDescription(ESC_RAW) ?></p>
    </div>
</div>
