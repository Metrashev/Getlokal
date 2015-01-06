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

<div class="wrap details clearfix">
    <div class="col-xs-3">
        <?php if (count($company->getCompanyImage())): ?>
            <a href="getlokal://images" id="company-image">
                <img class="img-responsive" src="<?php echo image_path($company->getThumb(0)) ?>"
                    alt="<?php echo $title; ?>">
            </a>
        <?php endif; ?>
    </div>
    <div class="col-xs-9">
        <div class="row">
            <h2 id="company-title">
                <?php echo $title; ?>
            </h2>
            <div class="clearfix">
                <div class="pull-left" id="rating">
                    <?php include_partial('rating', array('value' => $company->getRating())); ?>
                </div>
                <div class="pull-right col-xs-7 text-right" id="no-reviews">
                    <strong><?php echo $noReviews; ?></strong>
                </div>
            </div>
            <div class="gray" id="distance">
                <?php echo number_format($company->kms, 2); ?> <?php echo __('km') ?>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <?php include_partial('call', compact('company')); ?>

    <?php include_partial('companyDetail', compact('company')); ?>

    <?php include_partial('buttons', compact('company', 'is_favorite', 'is_check_in')); ?>
</div>

<?php echo include_partial('imageMap', compact('company')); ?>

<?php include_partial('reviews', compact('company', 'reviews')); ?>
