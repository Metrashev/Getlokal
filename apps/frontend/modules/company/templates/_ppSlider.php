<div class="slider_wrapper pp global-slider-margin">
  <div class="slider-image">
    <div class="dim"></div>
  </div>
  <div class="slider-separator"></div>  
</div><!-- slider_wrapper -->

<?php 
  $city = $company->getCity();
  $country = $company->getCountry();

  $sector = $company->getSector();
  $classification = $company->getClassification();

  $county = sfContext::getInstance()->getRequest()->getParameter('county', false);

  if ($county || (getlokalPartner::getInstanceDomain() == 78)){
    $locationLink = link_to($company->getCity()->getCounty()->getLocation(), '@homeCounty?county='. $sf_user->getCounty()->getSlug(), array('class' => 'path-item-ppp'));
    $hrefSector = url_for('@sectorCounty?slug='. $company->getSector()->getSlug(). '&county='. $company->getCounty()->getSlug());
    $hrefClassification= url_for('@classificationCounty?slug='. $company->getClassification()->getSlug(). '&sector='. $company->getSector()->getSlug(). '&county='. $company->getCounty()->getSlug(),true);
  }else{
    $locationLink = link_to($company->getCity()->getDisplayCity(), '@home?city='. $sf_user->getCity()->getSlug(), array('class' => 'path-item-ppp'));
    
    $hrefSector = url_for('@sector?slug='. $company->getSector()->getSlug(). '&city='. $company->getCity()->getSlug());
    $hrefClassification= url_for('@classification?slug='. $company->getClassification()->getSlug(). '&sector='. $company->getSector()->getSlug(). '&city='. $sf_user->getCity()->getSlug(),true);
  }

  $percetnRating = round($company->getAverageRating() * 20);
?>

<div class="view-page">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 left-column">
      <div class="col-sm-12 path-holder-margin">
        <?php include_partial('global/breadCrumb'); ?>      
      </div>
        <div class="top-info-holder">
          <h1 class="top-info-heading"><?=$company->getCompanyTitle()?>
            <?php if ($company->getIsClaimed()){ ?>
                <span class="page-icon verified"> <!-- !!!!!! change class premium / verified to change icon -->
                <span class="wrapper-tooltip-ppp"><span class="tooltip-arrow-ppp"></span><span class="tooltip-body-ppp">
                  <?php echo __('This page has been claimed by the Place Owner.', null, 'company'); ?>
                </span></span>
              </span>
            <?php } ?>
          </h1>
          <div class="reviews-holder">
            <div class="stars-holder bigger">         
              <ul>
                <li class="gray-star"><i class="fa fa-star"></i></li>
                <li class="gray-star"><i class="fa fa-star"></i></li>
                <li class="gray-star"><i class="fa fa-star"></i></li>
                <li class="gray-star"><i class="fa fa-star"></i></li>
                <li class="gray-star"><i class="fa fa-star"></i></li>
                <li class="review-rating"><?=$company->getAverageRating() ?> -</li>
                <li><p class="reviews-number">
                <?php echo format_number_choice('[0]No reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $company->getNumberOfReviews()), $company->getNumberOfReviews(), 'user'); ?>
                </p></li>
              </ul>
              <div class="top-list" style="width: 114px;">
                <div class="hiding-holder" style="width: <?=$percetnRating?>%;">
                  <ul class="spans-holder">
                    <li class="red-star"><i class="fa fa-star"></i></li>
                    <li class="red-star"><i class="fa fa-star"></i></li>
                    <li class="red-star"><i class="fa fa-star"></i></li>
                    <li class="red-star"><i class="fa fa-star"></i></li>
                    <li class="red-star"><i class="fa fa-star"></i></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.path-holder -->
        <ul class="review-places">
          <?php if ((getlokalPartner::getInstanceDomain() == 78) || $sf_request->getParameter('county', false)): ?>
                      <li><?php echo link_to('<i class="fa fa-tags"></i>'.sprintf(__('%s in %s'), $company->getClassification(), $company->getCity()->getCounty()->getLocation()), '@classificationCounty?slug='. $company->getClassification ()->getSlug (). '&sector='. $company->getSector ()->getSlug (). '&county='. $company->getCity()->getCounty()->getSlug(), array('title' => sprintf(__('%s in %s'), $company->getClassification(), $company->getCity()->getCounty()->getLocation()))) ?></li>
                      <?php if ($company->getAdditionalClassifications()): ?>
                          <?php foreach ($company->getAdditionalClassifications() as $classification): ?>                
                              <li><?php echo link_to('<i class="fa fa-tags"></i>'.sprintf(__('%s in %s'), $classification, $company->getCity()->getCounty()->getLocation()), sprintf('@classificationCounty?slug=%s&county=%s&sector=%s', $classification->getSlug(), $company->getCity()->getCounty()->getSlug(), $classification->getPrimarySector()->getSlug()), array('title' => sprintf(__('%s in %s'), $classification, $company->getCity()->getCounty()->getLocation()))) ?></li>
                          <?php endforeach; ?>
                      <?php endif; ?>
                  <?php else: ?>
                      <li><?php echo link_to('<i class="fa fa-tags"></i>'.sprintf(__('%s in %s'), $company->getClassification(), $company->getCity()->getDisplayCity()), $company->getClassificationUri(ESC_RAW), array('title' => sprintf(__('%s in %s'), $company->getClassification(), $company->getCity()->getDisplayCity()))) ?></li>
                        <?php if ($company->getAdditionalClassifications()): ?>
                            <?php foreach ($company->getAdditionalClassifications() as $classification): ?>
                                <li><?php echo link_to('<i class="fa fa-tags"></i>'.sprintf(__('%s in %s'), $classification, $company->getCity()->getDisplayCity()), $classification->getUrla($company->getCity()->getSlug(), ESC_RAW), array('title' => sprintf(__('%s in %s'), $classification, $company->getCity()->getDisplayCity()))) ?></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                  <?php endif; ?>
        </ul>
      </div><!-- /.col-sm-8 -->
<?php if(!is_null($company->getCreatedByUser()->getId())){ ?>
      <div class="col-sm-4 right-column">
        <div class="profile-information">
          <div class="profile-image">
            <a href="#"><?php echo image_tag($company->getCreatedByUser()->getThumb(), 'size=50x50') ?></a>
          </div><!-- profile-image -->
          <div class="profile-content">
            <p style="text-align: right;"><?php echo __('This place was added by', null, 'company') . " "; ?></p>
            <h3><a href="<?php echo url_for('profile/index?username=' . $company->getCreatedByUser()->getSfGuardUser()->getUsername()); ?>">
                  <?php echo $company->getCreatedByUser()->getSfGuardUser()->getFirstName() . ' ' . $company->getCreatedByUser()->getSfGuardUser()->getLastName(); ?>
                </a>
            </h3>
          </div>
        </div><!-- profile-information -->
      </div><!-- /.col-sm-4 -->
<?php } ?>      
    </div>
  </div>
</div><!-- /.view-page -->