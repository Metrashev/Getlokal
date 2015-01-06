<?php
    decorate_with('bootstrap');
    slot('container-class'); print 'wide company-new'; end_slot();

    $culture = $sf_user->getCulture();
    $countryId = $sf_user->getCountry()->getId();

    $title = $company->getCompanyTitleByCulture();
    $noReviews = format_number_choice(
        '[0]No reviews|[1]<span>1</span> review|(1,+Inf]<span>%count%</span> reviews',
        array('%count%' => $company->getNumberOfReviews()),
        $company->getNumberOfReviews(),
        'messages'
    );
?>

<div class="wrap details clearfix ppp">
    <div id="company-image">
        <a href="getlokal://images">
            <?php if (count($company->getCompanyImage())): ?>
                <img class="img-responsive" src="<?php echo image_path($company->getThumb(3)) ?>"
                    alt="<?php echo $title; ?>">
            <?php endif; ?>

            <div id="details" class="blk" onclick="window.location.href = 'getlokal://images';">
                <div class="col-xs-12">
                    <h2 id="company-title"><?php echo $title; ?></h2>
                    <div class="row">
                        <div id="rating" class="col-xs-8">
                            <?php echo $company->getClassification(); ?>
                            <?php include_partial('rating', array('value' => $company->getRating())); ?>
                        </div>
                        <div id="distance" class="col-xs-4 text-right">
                            <?php echo number_format($company->kms, 2); ?> <?php echo __('km') ?>
                        </div>
                    </div>
                </div>
            </div>
        </a>

    </div>
    <div class="clearfix"></div>
    <?php include_partial('call', compact('company')); ?>

    <?php include_partial('companyDetail', compact('company')); ?>

    <?php include_partial('buttonsNew', compact('company', 'is_favorite', 'is_check_in')); ?>
</div>

<?php include_partial('imageMap', compact('company')); ?>

<?php include_partial('description', compact('company')); ?>

<?php include_partial('eventsNew', compact('events', 'company')); ?>

<?php include_partial('offers', compact('offers')); ?>

<?php include_partial('reviews', compact('company', 'reviews')); ?>
