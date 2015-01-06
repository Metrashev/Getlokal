<?php
use_helper('Date');

$culture = $sf_user->getCulture();
$county = sfContext::getInstance()->getRequest()->getParameter('county', false);

if ($county || (getlokalPartner::getInstanceDomain() == 78)) {
    $locationLink = link_to($company_offer->getCompany()->getCity()->getCounty()->getLocation(), '@homeCounty?county=' . $sf_user->getCounty()->getSlug(), array('class' => 'path-item-offers-details'));
} else {
    $locationLink = link_to($company_offer->getCompany()->getCity()->getDisplayCity(), '@home?city=' . $sf_user->getCity()->getSlug(), array('class' => 'path-item-offers-details'));
}
?>

<?php slot('facebook') ?>
<meta property="fb:app_id" content="<?php echo sfConfig::get('app_facebook_app_' . $sf_user->getCountry()->getSlug() . '_id'); ?>"/>
<meta property="og:title" content="<?php echo $company_offer->getDisplayTitle(); ?>" />
<meta property="og:type"   content="object" />
<meta property="og:url" content="<?php echo url_for('offer/show?id=' . $company_offer->getId(), true) ?>" />

<?php if ($company_offer->getDisplayDescription()): ?>
    <meta property="og:description" content="<?php echo truncate_text(strip_tags($company_offer->getDisplayDescription(ESC_RAW)), 500, ' ') ?>" />
<?php endif; ?>

<?php if ($company_offer->getImageId()): ?>
    <?php if ($image = Doctrine_Core::getTable('Image')->findOneById($company_offer->getImageId())): ?>
        <meta property="og:image" content="<?php echo image_path($image->getFile(), true) ?>" />
    <?php endif; ?>
<?php endif; ?>

<meta property="og:site_name" content="<?php echo $sf_request->getHost() ?>" />
<?php end_slot() ?>


<div class="slider_wrapper pp">
  <div class="slider-image">
    <div class="dim"></div>
  </div>
  <div class="slider-separator"></div>  
</div><!-- slider_wrapper -->


<div class="wrapper-offers-details-slider"> <!-- start wrapper-offers-details-slider -->

    <div class="container"><!-- start container->wrapper-header -->
        <div class="row">
            <div class="col-sm-12 left-column">
                <div class="path-holder path-holder-offers-details ">
                    <?php echo $locationLink; ?>
                    <span>/</span>
                    <?php echo link_to(__('Offers', null, 'offer'), 'offer/index', array('class' => 'path-item-offers-details active')); ?>
                </div><!-- /.path-holder -->

                <div class="top-info-holder">
                    <h1 class="top-info-heading-offers-details"><?php echo __('Offers', null, 'offer') ?></h1>
                </div><!-- /.path-holder -->
            </div>
        </div>
    </div> <!-- end container->wrapper-header -->

    <div class="container">
        <div class="row">
            <div class="wrapper-offers-details-page"> <!-- start wrapper-offers-details-page -->
                <div class="col-sm-8 content-offers-details">
                    <div class="section-offer-head">
                        <div class="offer-details-image">
                            <?php echo image_tag($company_offer->getThumb(2), array('size' => '260x200', 'alt_title' => $company_offer->getDisplayTitle())); ?>
                        </div>
                        <div class="wrapper-offers-details-head">
                            <div class="share-offers-details">
                                <h4><?php echo __('SHARE', null, 'company'); ?></h4>
                                <div class="socials-container-offers-details">    
                                    <?php include_partial('global/social', array('hasSocialScripts' => true, 'hasSocialHTML' => true)); ?>
                                </div> <!-- socials-container-offers-details -->
                            </div> <!-- share-offers-details -->
                        </div> <!-- swrapper-offers-details-head -->

                        <div class="offers-details-desc">
                            <h1>
                                <?php if ($company_offer->getBenefitChoice()) { ?>
                                    <?php
                                    switch ($company_offer->getBenefitChoice()) {
                                        case 1:
                                            ?>
                                            <?php echo __('Price', null, 'form'); ?>: <?php echo $company_offer->getNewPrice() . ' ' . $company_offer->getCompany()->getCountry()->getCurrency(); ?>
                                            </br>
                                            <?php echo __('Old price', null, 'form'); ?>: <?php echo $company_offer->getOldPrice() . ' ' . $company_offer->getCompany()->getCountry()->getCurrency(); ?>
                                            </br>
                                            <?php echo __('Discount:' . ' ', null, 'form'); ?>
                                            <?php echo Doctrine::getTable('CompanyOffer')->getDiscount($company_offer); ?>%
                                            </br>
                                            <?php echo __('You save:' . ' ', null, 'form'); ?>
                                            <?php echo $company_offer->getOldPrice() - $company_offer->getNewPrice() . ' ' . $company_offer->getCompany()->getCountry()->getCurrency(); ?>
                                            </br>
                                            <?php break; ?>
                                        <?php
                                        case 2:
                                            echo __('Discount:' . ' ', null, 'form') . $company_offer->getDiscountPct() . '%';
                                            break;
                                        case 3:
                                            echo $company_offer->getBenefitText();
                                            break;
                                    }
                                }
                                ?>
                            </h1>
                            <h2><?php echo $company_offer->getDisplayTitle(); ?></h2>    
                        </div><!-- profile-content-body -->
                    </div>

                    <div class="section-body-offers-details">
                        <?php echo $company_offer->getDisplayDescription(ESC_RAW); ?>
                    </div>
                </div>

                <!-- ================================================== START SIDEBAR ============================================================-->
                <div class="col-sm-4 sidebar-offers-details">

                    <div class="widget offer-info">
                        <div class="place-info-head">
                            <h3><?php echo __('Information', null, 'company'); ?></h3>
                        </div><!-- place-info-head -->

                        <div class="place-info-body">
                            <?php
                            $location = $company_offer->getCompany()->getLocation();
                            $latLng = $location->getLatitude() . ',' . $location->getLongitude();
                            $marker = image_path('gui/icons/marker_' . $company_offer->getCompany()->getSectorId(), true);
                            $params = array(
                                // 'center' => $latLng, // google know how to center if you give him markers
                                'zoom' => '15',
                                'size' => '358x100',
                                'maptype' => 'roadmap',
                                'markers' => "icon:{$marker}%7Cshadow:false%7C{$latLng}",
                                'sensor' => 'false',
                                    //'key' => 'AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08'
                            );
                            $ps = array();
                            foreach ($params as $k => $v) {
                                $ps[] = "{$k}={$v}";
                            }
                            $params = implode('&', $ps);
                            ?>
                            <a href="#" data-toggle="modal" data-target="#modalMap"><img src="http://maps.googleapis.com/maps/api/staticmap?<?php echo $params; ?>"></a>


                            <ul class="offer-info-tags">
                                <li class="get-address-p get-address-offers-info"><i class="fa fa-map-marker"></i>
                                    <?php echo link_to($company_offer->getCompany()->getTitle(), $company_offer->getCompany()->getUri(ESC_RAW)); ?>, 
                                    <!-- <a href="#"> -->
                                        <span><?php echo $company_offer->getCompany()->getDisplayAddress(); ?></span>
                                    <!-- </a> -->
                                </li>
                                <li class="get-address-p get-address-offers-info"><i class="fa fa-tags"></i>
                                    <?php echo link_to($company_offer->getCompany()->getClassification()->getTitle(), $company_offer->getCompany()->getClassificationUri(ESC_RAW), array('title' => $company_offer->getCompany()->getClassification()->getTitle())); ?>
                                </li>
                            </ul>

                            <div class="offer-info-separator">
                                <p class="offer-info-line-on"><span><?php echo __('Voucher Valid From', null, 'form') ?></span></p>
                            </div>
                            <div class="vaucher-valid-from">
                                <?php echo format_date($company_offer->getValidFrom(), 'dd MMM yyyy', $culture); ?>
                            </div>
                            <div class="offer-info-separator">
                                <p class="offer-info-line-on"><span><?php echo __('Voucher Valid To', null, 'form') ?></span></p>
                            </div>
                            <div class="vaucher-valid-from">
                                <?php echo format_date($company_offer->getValidTo(), 'dd MMM yyyy', $culture); ?>
                            </div>
                            <div class="offer-info-separator">
                                <p class="offer-info-line-on"><span><?php echo __('Time left to get it:', null, 'form') ?></span></p>
                            </div>
                            <div class="offer-time-left">
                                <?php
                                $remaining = Doctrine::getTable('CompanyOffer')->getRemainingTime($company_offer);
                                echo format_number_choice('[0]%time%|[1]1 day %time%|(1,+Inf]%days% days %time%', array('%days%' => $remaining->format('%d'), '%time%' => $remaining->format('%H:%I:%S')), $remaining->format('%d'), 'offer');
                                ?>
                            </div>

                            <?php if ($company_offer->getMaxPerUser() > 1 or ( $company_offer->getMaxPerUser() - $company_offer->getVouchersPerOffer($user, true) > 1)) { ?>
                                <div class="offer-info-separator">
                                    <p class="offer-info-line-on"><span><?php echo __('Number of Vouchers', null, 'offer') ?></span></p>
                                </div>

                                <?php if ($company_offer->getAvailableVouchers() && $company_offer->IsActive()) { ?>
                                    
                                <?php } ?>

                            <?php } ?>

                            <div class="wrapper-get-vaucher-btn">

                              <?php
                              if ($company_offer->getAvailableVouchers() && $company_offer->IsActive()) {
                                  if ($user && $company_offer->getIsAvailableToOrder($user)) {
                                      if ($company_offer->getMaxPerUser() == 1 or ( $company_offer->getMaxPerUser() - $company_offer->getVouchersPerOffer($user, true) == 1)) {
                                          echo link_to(__('getVoucher', null, 'offer'), 'offer/orderVoucher?id=' . $company_offer->getId(), array('class' => 'default-btn action get-vaucher', 'id' => 'getVoucher'));
                                      } else {
                                          ?>
                                          <form  action="<?php echo url_for('offer/orderVoucher') ?>" method="post" id="voucher_form">
                                              <div class="wrapper-vaucher-number">
                                                  <select name="vouchers" id="vouchers" class="offer-info-vaucher-number"><?php $i = 1; ?>
                                                      <?php while ($i <= $offersLeft): ?>
                                                          <option value=<?php echo $i ?>><?php echo $i ?></option>
                                                          <?php
                                                          $i++;
                                                      endwhile;
                                                      ?>
                                                  </select>
                                              </div>
                                              <input id="getVoucherBtnForm" class="default-btn action get-voucher" type="submit" value="<?php echo __('getVoucher', null, 'offer') ?>" />
                                          </form>
                                      <?php } ?>
                                      <?php
                                  } elseif (!$user) {
                                      $formLogin = new sfGuardFormSignin ();
                                      ?>
                                        <a href="javascript:void(0)" id="getvoucher_login"  class="default-btn action"><?php echo __('getVoucher', null, 'offer') ?></a>
                                        <div id="login_form_getvoucher" class="login_form_wrap" style="display:none">
                                            <a href="javascript:void(0)" id="header_close"></a>
                                            <?php include_component('user', 'signinRegister',array('type' => 'voucher', 'trigger_id' => 'getvoucher_login', 'button_close' => true));?>
                                        </div>
                                      <?php
                                  } ?>
                                  
                                      <span>
                                        <?php
                                        if ($company_offer->getMaxVouchers()) {
                                            $vouchersRemaining = $company_offer->getMaxVouchers() - $company_offer->getCountVoucherCodes();
                                            if ($vouchersRemaining > 99) {
                                                $vouchersRemaining = 99;
                                                echo ($vouchersRemaining . '+');
                                            } else {
                                                echo $vouchersRemaining;
                                            }
                                        } else {
                                            $vouchersRemaining = 99;
                                            echo ($vouchersRemaining . '+');
                                        }
                                        ?>
                                    </span>
                                <?php } ?>
                            </div>
                        </div><!-- place-info-body -->
                    </div>

                    <?php /* <div class="default-container">
                        <h3 class="heading"><?php echo __('Sponsored', null, 'mailsubject'); ?></h3> <!-- END heading -->
                        <div class="content">
                            <a href="#"><img src="css/images/sponsored.png" alt="" width="0" height="0" style="display: none !important; visibility: hidden !important; opacity: 0 !important; background-position: 0px 0px;"></a>
                        </div> <!-- END content -->
                    </div>
                    */ ?>

                </div> <!-- end sidebar-offers-details -->
                <!-- ================================================== END SIDEBAR ============================================================-->
            </div> <!-- end wrapper-offers-details-page -->
        </div> <!-- end row -->
    </div> <!-- end container --> 
    <div><!-- end wrapper-offers-details-slider -->


        <div class="modal fade standart" id="modalMap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><a class="close-btn" href="#"></a></span></button>
                        <h4 class="modal-title" id="myModalLabel"><?php echo __('Location details', null, 'company'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <div style="width:990px;height:566px;" class="map" id="google_map"></div>
                        <div class="widget-map">
                            <div class="place-info-head">
                                <h3><?php echo __('Information', null, 'company'); ?></h3>
                            </div><!-- place-info-head -->

                            <div class="place-info-body">
                                <ul>
                                    <li class="get-address-p"><i class="fa fa-map-marker"></i><?php echo $company_offer->getCompany()->getDisplayAddress(); ?></li>
                                     <?php if ($company_offer->getCompany()->getPhone()) { ?>
                                        <li class="get-phone-p"><i class="fa fa-phone"></i><strong><?php echo $company_offer->getCompany()->getPhoneFormated() ?></strong></li>
                                    <?php } ?>

                                    <?php if ($company_offer->getCompany()->getWebsiteUrl()) { ?>
                                        <li><a href="#"><?php echo getCompanyWebSite($company_offer->getCompany()) ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div><!-- place-info-body -->

                            <div class="place-info-foot">
                                <div class="socials">
                                    <ul>
                                        <?php if ($company_offer->getCompany()->getFacebookUrl()): ?>
                                            <li><?php echo getCompanyFacebook($company_offer->getCompany()); ?></li>
                                        <?php endif; ?>
                                        <?php if ($company_offer->getCompany()->getTwitterUrl()): ?>
                                            <li><?php echo getCompanyTwitter($company_offer->getCompany()); ?></li>
                                        <?php endif; ?>
                                        <?php if ($company_offer->getCompany()->getFoursquareUrl()): ?>
                                            <li><?php echo getCompanyFoursquare($company_offer->getCompany()); ?></li>
                                        <?php endif; ?>
                                        <?php if ($company_offer->getCompany()->getGoogleplusUrl()): ?>
                                            <li><?php echo getCompanyGooglePlus($company_offer->getCompany()); ?></li>
                                        <?php endif; ?>
                                        <?php if ($company_offer->getCompany()->getCountryId() == 4 && $$company_offer->getCompany()->getCompanyDetailSr()->getSrUrl()): ?>
                                            <li><?php echo getCompanyYellowPagesRS($company_offer->getCompany()); ?></li>
                                        <?php endif; ?>
                                    </ul>
                                </div><!-- socials -->
                            </div><!-- place-info-foot -->
                        </div>
                    </div>
                </div>
            </div>
        </div>  <!-- modal -->

<script type="text/javascript">

  <?php if ($company_offer->getMaxPerUser() == 1 or ( $company_offer->getMaxPerUser() - $company_offer->getVouchersPerOffer($user, true) == 1)): ?>
    $('.get-vaucher').click(function() {
        var company_offer_id = <?php echo $company_offer->getId() ?>;
        var vouchers = <?php $vouchers = 1 ?>
  <?php else: ?>
        $('#voucher_form').submit(function() {
            var company_offer_id = <?php echo $company_offer->getId() ?>;
            var vouchers = $('#vouchers').attr('value');
  <?php endif; ?>
        //console.log($('#list_copany_list').attr('value'));
        $.ajax({
  <?php if ($company_offer->getMaxPerUser() == 1 or ( $company_offer->getMaxPerUser() - $company_offer->getVouchersPerOffer($user, true) == 1)): ?>
            url: this.href,
  <?php else: ?>
            url: this.action,
  <?php endif; ?>

        dataType: "json",
                data: {'vouchers': vouchers, 'id': company_offer_id },
                success: function(data) {
                $.ajax({
                    url: "<?php echo url_for(sfContext::getInstance()->getRouting()->getCurrentInternalUri()) ?>",
                    dataType: "html",
                    data: {'jsp': "1"},
                    success: function(srv) {
                        $('.offer_wrap').html(srv);
                    }
                });

                if (data.error != undefined && data.error == false) {
                    console.log(typeof data.voulchers_id);
                    if (typeof data.voulchers_id == 'string') {
                        $("#dialog-confirm").dialog({
                            resizable: false,
                            height: 250,
                            width: 340,
                            buttons: {
                                "<?php echo __('Print', null, 'offer') ?>": function() {
                                    window.location.href = "<?php echo url_for('offer/voucher?id='); ?>" + data.voulchers_id;
                                },
                                    <?php echo __('View', null, 'offer') ?>: function() {
                                    window.location.href = "<?php echo url_for('profile/vouchers'); ?>";
                                }
                            }
                        });
                    }
                    else {
                        $("#dialog-confirm").dialog({
                            resizable: false,
                            height: 250,
                            width: 340,
                            buttons: {
                              <?php echo __('View', null, 'offer') ?>: function() {
                                    window.location.href = "<?php echo url_for('profile/vouchers'); ?>";
                                }
                            }
                        });
                    }
                }
            }
    });
    return false;
});


$("#getvoucher_login").click(function() {
    $('#login_form_getvoucher').toggle();
});

</script>

<div id="dialog-confirm" title="<?php echo __('Congrats', null, 'offer') ?>" style="display:none;">
    <p><?php echo __("We just issued your voucher! It's saved in your Profile.", null, 'offer') ?></p>
</div>




<script type="text/javascript">
    var first_flag = 1;
    $('#modalMap').on('shown.bs.modal', function (e) {
        if(first_flag){
            map.init();
            map.loadMarkers('<?php echo json_encode(array(array(
                'lat' => $company_offer->getCompany()->Location->getLatitude(),
                'lng' => $company_offer->getCompany()->Location->getLongitude(),
                'id' => $company_offer->getCompany()->getId(),
                'title' => $company_offer->getCompany()->getCompanyTitle(),
                'icon' => $company_offer->getCompany()->getSmallIcon()
            )))?>');
            first_flag = 0;
        }
    })
</script>