<?php
    decorate_with('bootstrap');

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
        <?php if (count($company->getCompanyImage())): ?>
            <a href="getlokal://images">
                <img class="img-responsive" src="<?php echo image_path($company->getThumb(3)) ?>"
                    alt="<?php echo $title; ?>">
            </a>
        <?php endif; ?>

        <div id="details" class="blk" onclick="window.location.href = 'getlokal://images';">
            <div class="col-xs-12">
                <h2 id="company-title"><?php echo $title; ?></h2>
                <div id="cs"><?php echo $company->getClassification(); ?></div>
                <div class="row">
                    <div id="rating" class="col-xs-6">
                        <?php include_partial('rating', array('value' => $company->getRating())); ?>
                    </div>
                    <div id="distance" class="col-xs-6 text-right">
                        <?php echo number_format($company->kms, 2); ?> <?php echo __('km') ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="clearfix"></div>
    <?php include_partial('call', compact('company')); ?>

    <?php include_partial('companyDetail', compact('company')); ?>

    <?php include_partial('buttons', compact('company', 'is_favorite', 'is_check_in')); ?>
</div>

<?php include_partial('imageMap', compact('company')); ?>

<?php include_partial('events', compact('events', 'company')); ?>

<?php include_partial('reviews', compact('company', 'reviews')); ?>
