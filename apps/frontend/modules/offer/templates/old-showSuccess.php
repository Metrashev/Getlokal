<?php
//var_dump(sfContext::getInstance()->getRouting()->getCurrentInternalUri());exit();
  use_helper('Date');
  $culture= $sf_user->getCulture();
?>
<?php
    $current =  strtotime(date('Y-m-d H:i:s'));
    $timeToOfferEnd = strtotime($company_offer["active_to"]. '+3GMT');

    $hours_diff = ($timeToOfferEnd -$current)/3600 ;
?>
<?php $hasSocialScripts = true?>
<?php $hasSocialHTML = false;?>
<?php slot('facebook') ?>
  <meta property="fb:app_id" content="<?php echo sfConfig::get('app_facebook_app_'.$sf_user->getCountry()->getSlug().'_id');?>"/>
  <meta property="og:title" content="<?php echo $company_offer->getDisplayTitle();?>" />
  <meta property="og:type"   content="object" />
  <meta property="og:url" content="<?php echo url_for('offer/show?id='.$company_offer->getId(), true) ?>" />

  <?php if($company_offer->getDisplayDescription()):?>
    <meta property="og:description" content="<?php echo truncate_text(strip_tags($company_offer->getDisplayDescription(ESC_RAW)),500, ' ')?>" />
  <?php endif;?>

  <?php if ($company_offer->getImageId()):?>
      <?php if ($image = Doctrine_Core::getTable ( 'Image' )->findOneById($company_offer->getImageId())):?>
        <!--  <meta property="og:image" content="<?php //echo image_path($image->getThumb(2), true) ?>" /> -->
    <meta property="og:image" content="<?php echo image_path($image->getFile(), true) ?>" />
      <?php endif;?>
  <?php endif;?>

  <meta property="og:site_name" content="<?php echo $sf_request->getHost() ?>" />
<?php end_slot() ?>

<div class="social_share_wrap">
  <?php include_partial('global/social', array('hasSocialScripts' => true, 'hasSocialHTML' => true )); ?>
</div>

<?php if (!$company_offer->IsActive() && !$isPreview && !$company_offer->ActiveSevenDays()):?>
  <p style="display:inline-block"><?php echo __('This offer is not active.', null,'offer');?></p>
<?php else: ?>
  <?php $company = $company_offer->getCompany();?>

  <div class="offer_wrap offer_layout">

    <div class="interaction">
    <?php if ($company_offer->getAvailableVouchers()): ?>
      <?php if ($user && $company_offer->getIsAvailableToOrder($user)): ?>
        <?php if ($company_offer->getMaxPerUser() == 1 or ($company_offer->getMaxPerUser() - $company_offer->getVouchersPerOffer($user, true) == 1)): ?>
        <?php else: ?>
        <?php endif;?>
      <?php elseif (!$user):?>
      <?php else: ?>
            <div class="left_wrap">
              <span><?php echo __('You have already ordered the maximum number of vouchers', null, 'offer')?>!</span>
            </div>
      <?php endif;?>
    <?php else: ?>
            <div class="left_wrap">
              <span><?php echo __('No more vouchers available for this offer', null, 'offer')?>!</span>
            </div>
          <?php endif;?>
        <div class="clear"></div>
    </div>
    <?php breadCrumb::getInstance()->add(link_to(__('Offers', null, 'offer'), 'offer/index', 'class=offers_path'));?>

    <div class="offer_desc offer_layout <?php echo ($company_offer->getBenefitChoice()) ? '' : 'no_benefits'; ?>">
        <div class="offer_image">
            <?php $class_img = '' ?>
            <?php if (($hours_diff>0 && $hours_diff<24) && $company_offer->getAvailableVouchers()>0 ):?>
               <?php $class_img = 'expiring_soon' ?>
               <div id="expirationStrip" class="expiration_strip">
                   <?php echo __('Expiring soon',null,'form')?>
               </div>
            <?php endif;?>
            <?php if ($hours_diff<0 or $company_offer->getAvailableVouchers()==FALSE):?>
               <?php $class_img = 'expired' ?>
               <div id="expiriredStrip" class="expiration_strip expired">
                   <?php echo __('Not available',null,'form')?>
               </div>
            <?php endif;?>
            <?php if ($company_offer->getImageId()): ?>
              <?php if ($image = Doctrine_Core::getTable('Image')->findOneById($company_offer->getImageId())): ?>

                <!--   <?php //echo image_tag($image->getThumb(3), array('size' => '290x257', 'alt_title'=>$company_offer->getDisplayTitle(), 'class'=>$class_img )) ?> -->
                <?php echo image_tag($image->getFile(), array('size' => '290x257', 'alt_title'=>$company_offer->getDisplayTitle(), 'class'=>$class_img )) ?>
              <?php endif; ?>
            <?php else: ?>
              <?php echo image_tag('gui/default_place_560x420.jpg', array('size' => '290x257', 'alt_title' => $company_offer->getDisplayTitle(),'class'=>$class_img )) ?>
      <?php endif; ?>
        </div>
    <?php if ($company_offer->getBenefitChoice()): ?>
        <div class="offer_main_benefits">
            <?php switch ($company_offer->getBenefitChoice()):
                case 1:
                    ?>
                    <h4><?php echo $company_offer->getNewPrice(). ' '; ?><?php echo $company_offer->getCompany()->getCountry()->getCurrency(); ?>
                        <span><?php echo $company_offer->getOldPrice(). ' '; ?><?php echo $company_offer->getCompany()->getCountry()->getCurrency(); ?></span>
                    </h4>
                    <h5>
                        <?php $priceDiff = ($company_offer->getNewPrice()/$company_offer->getOldPrice())*100; ?>
                         <?php $ptcDiscount = 100 - $priceDiff; ?>
                        <?php if($ptcDiscount>90):?>
                            <?php echo __('Discount:' . ' ', null, 'form'); ?><?php echo round($ptcDiscount, 1); ?><?php echo ('%'); ?>
                            <?php echo __('You save:' . ' ', null, 'form'); ?><?php echo $company_offer->getOldPrice()-$company_offer->getNewPrice(). ' '; ?><?php echo $company_offer->getCompany()->getCountry()->getCurrency(); ?>
                        <?php else:?>
                            <?php echo __('Discount:' . ' ', null, 'form'); ?><?php echo round($ptcDiscount); ?><?php echo ('%'); ?>
                            <?php echo __('You save:' . ' ', null, 'form'); ?><?php echo $company_offer->getOldPrice()-$company_offer->getNewPrice(). ' '; ?><?php echo $company_offer->getCompany()->getCountry()->getCurrency(); ?>
                        <?php endif;?>

                    </h5>
                    <?php break; ?>
                <?php case 2: ?>
                    <h4><?php echo $company_offer->getDiscountPct(); ?><?php echo __('% discount', null, 'form'); ?></h4>
                    <?php break; ?>
                <?php case 3: ?>
                    <h5><?php echo $company_offer->getBenefitText(); ?></h5>
                    <?php break; ?>
            <?php endswitch; ?>
        </div>
    <?php endif; ?>
      <div class="offer_content">
          <h1 class="offer_title">
              <?php echo $company_offer->getDisplayTitle(); ?>
          </h1>
          <p class="company_classification"><?php echo $company_offer->getCompany()->getClassification(); ?></p>
          <div class="company_provider">
                    <?php echo __('from', null, 'company') ?> <?php echo link_to_company($company_offer->getCompany()); ?>,
                    <?php echo $company_offer->getCompany()->getCity()->getLocation(); ?>,
                    <?php echo $company_offer->getCountry()->getCountryNameByCulture(); ?>
          </div>
          <div class="clear"></div>
          <div id ="bottomWrap"class="bottom_wrap">
             <div class="voucher_dates">
                <p id="voucherValidLabels"><?php echo __('Voucher Valid From', null, 'form') ?></p>
                <p>
                    <strong>
                        <?php echo format_date($company_offer->getValidFrom(), 'dd MMM yy', $culture); ?>
                    </strong>
                    <?php echo __('-', null, 'offer') ?> <strong>
                    <?php echo format_date($company_offer->getValidTo(), 'dd MMM yy', $culture); ?></strong>
                </p>
              </div>
               <?php if ($hours_diff>0):?>
                    <div id="countDownTimer" class="count_down_timer">
                     <p id="countDownLabel"><?php echo __('Time left to get it:', null, 'form') ?></p>
                     <div id="offerCountdown"></div>
                   </div>
              <?php endif;?>
              <div class="order_module">
                  <?php if ($company_offer->getAvailableVouchers() && $company_offer->IsActive() ): ?>
                    <?php if ($user && $company_offer->getIsAvailableToOrder($user)): ?>
                      <?php if ($company_offer->getMaxPerUser() == 1 or ($company_offer->getMaxPerUser() - $company_offer->getVouchersPerOffer($user, true) == 1)): ?>
                         <?php echo link_to(__('getVoucher', null, 'offer'), 'offer/orderVoucher?id=' . $company_offer->getId(), array('class'=>'button_pink', 'id'=>'getVoucher')); ?>
                      <div id="remainingVouchers" class="remaining_vouchers">
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
                       </div>
                     <?php else: ?>
                        <form  action="<?php echo url_for('offer/orderVoucher') ?>" method="post" id="voucher_form">
                          <div id ="voucherCount" class="voucher_count">
                            <?php echo __('Number of Vouchers', null, 'offer') ?>
                              <select name="vouchers" id="vouchers"><?php $i = 1; ?>
                                <?php while ($i <= $offersLeft): ?>
                                      <option value=<?php echo $i ?>><?php echo $i ?></option>
                                 <?php $i++;endwhile;?>
                              </select>
                          </div>
                          <input id="getVoucherBtnForm" type="submit" value="<?php echo __('getVoucher', null, 'offer') ?>" class="button_pink" />
                          <div class="clear"></div>
                        </form>
                        <div id="remainingVouchers" class="remaining_vouchers order_via_form">
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
                          </div>
                     <?php endif;?>
                     <?php elseif (!$user): ?>
                         <a href="javascript:void(0)" id="login"  class="button_pink button_clickable"><?php echo __('getVoucher', null, 'offer') ?></a>
                         <div class="clear"></div>
                         <div class="remaining_vouchers login_required">
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
                        </div>

                        <div class="clear"></div>
                    <?php endif;?>
                  <?php endif;?>
              </div>
          </div>
    </div>
  </div>
  <div class="clear"></div>
    <?php if (!$user): ?>
        <div class="login_form_wrap" style="display: none;">
         <a href="javascript:void(0)" id="header_close"></a>
              <?php include_partial('user/signin_form', array('form' => $form)); ?>
        </div>
    <?php endif;?>
  <div class="offer_description">
    <?php echo $company_offer->getDisplayDescription(ESC_RAW);?>
  </div>
    <?php if ($user && $user->getIsPageAdmin($company)): ?>
        <p>
          <?php echo __('Offer Active From',null,'form')?>:
          <strong><?php echo format_date($company_offer->getActiveFrom(), 'dd MMM yyyy',$culture); ?></strong>
          <?php echo __('to', null, 'offer')?> <strong>
          <?php echo format_date($company_offer->getActiveTo(), 'dd MMM yyyy',$culture);?></strong>
        </p>
      <?php endif;?>
      <div class="offer_hint offer_layout">
        <p><?php echo __('Download the voucher for this offer now and pay when you use it in the place.', null, 'form')?></p>
      </div>
  </div>

<?php endif;?>
<?php $timeToConvert = (1000 * strtotime($company_offer["active_to"] . '+3GMT')); ?>
<script type="text/javascript">
$(document).ready(function() {
    singleOfferLayout();
            <?php if ($sf_user->getCulture() == 'en'): ?>
                 <?php if (!$user): ?>
                    singleOfferLayoutNotLogged_EN();
                 <?php else:?>
                     singleOfferLayoutLogged_EN();
                <?php endif; ?>
                <?php if ($company_offer->getMaxPerUser() == 1):?>
                    maxVoucher1()
                <?php endif; ?>
            <?php elseif ($sf_user->getCulture() == 'bg'): ?>
                <?php if ($company_offer->getMaxPerUser() > 1):?>
                 <?php if ($user): ?>
                  singleOfferLayoutLoggedForm_BG();
                 <?php endif; ?>
                <?php endif; ?>
                   singleOfferLayoutNotLogged_BG();
            <?php elseif ($sf_user->getCulture() == 'mk'): ?>
                     <?php if ($company_offer->getMaxPerUser() > 1):?>
                     <?php if ($user): ?>
                        singleOfferLayoutLoggedForm_MK();
                     <?php endif; ?>
                 <?php endif; ?>
                 <?php if ($user): ?>
                     <?php if ($company_offer->getMaxPerUser() == 1):?>
                      $('#getVoucher').addClass('logged_in_mk moz');
                     <?php endif; ?>
                 <?php else: ?>
                 <?php endif; ?>
                        singleOfferLayoutNotLogged_MK();
            <?php elseif ($sf_user->getCulture() == 'sr'): ?>
                <?php if ($company_offer->getMaxPerUser() > 1):?>
                     <?php if ($user): ?>
                       singleOfferLayoutLoggedForm_SR();
                     <?php endif; ?>
                 <?php endif; ?>
                   singleOfferLayoutNotLogged_SR();
            <?php elseif ($sf_user->getCulture() == 'ro'): ?>
                 <?php if ($company_offer->getMaxPerUser() > 1):?>
                     <?php if ($user): ?>
                       singleOfferLayoutLoggedForm_RO();
                     <?php endif; ?>
                 <?php endif; ?>
                     singleOfferLayoutNotLogged_RO();
            <?php endif; ?>
 <?php if ($hours_diff>0):?>
  var dealEndDate = new Date(<?php echo $timeToConvert ?>);
        $('#offerCountdown').countdown({until: dealEndDate, compact: true,
            <?php if ($sf_user->getCulture() == 'en'): ?>
                            compactLabels: ['', '', '', ' Days', '', '', ''],
                            compactLabels1: ['', '', '', ' Day', '', '', ''],
            <?php elseif ($sf_user->getCulture() == 'bg'): ?>
                            compactLabels: ['', '', '', ' Дни', '', '', ''],
                            compactLabels1: ['', '', '', ' Ден', '', '', ''],
            <?php elseif ($sf_user->getCulture() == 'mk'): ?>
                            compactLabels: ['', '', '', ' Денови', '', '', ''],
                            compactLabels1: ['', '', '', ' Ден', '', '', ''],
            <?php elseif ($sf_user->getCulture() == 'sr'): ?>
                            compactLabels: ['', '', '', ' Dana', '', '', ''],
                            compactLabels1: ['', '', '', ' Dan', '', '', ''],
            <?php elseif ($sf_user->getCulture() == 'ro'): ?>
                            compactLabels: ['', '', '', ' Zile', '', '', ''],
                            compactLabels1: ['', '', '', ' Zi', '', '', ''],
            <?php endif; ?>

            whichLabels: function(amount) {
                var units = amount % 10;
                var tens = Math.floor(amount % 100 / 10);
                return (amount == 1 ? 1 :
                    (units >=2 && units <= 4 && tens != 1 ? 2 : 0));
            }
        });
<?php endif;?>

                        <?php if ($company_offer->getMaxPerUser() == 1 or ($company_offer->getMaxPerUser() - $company_offer->getVouchersPerOffer($user, true) == 1)): ?>
                             $('.button_pink').live("click", function() {
                                  var company_offer_id = <?php echo $company_offer->getId()?>;
                                  var vouchers = <?php $vouchers = 1?>
                        <?php else: ?>
                             $('#voucher_form').live("submit", function() {
                                  var company_offer_id = <?php echo $company_offer->getId()?>;
                                  var vouchers= $('#vouchers').attr('value');
                        <?php endif;?>
			//console.log($('#list_copany_list').attr('value'));
			$.ajax({
                           <?php if ($company_offer->getMaxPerUser() == 1 or ($company_offer->getMaxPerUser() - $company_offer->getVouchersPerOffer($user, true) == 1)): ?>
                                  url: this.href,
                           <?php else: ?>
                                url: this.action,
                           <?php endif;?>

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
						if(typeof data.voulchers_id == 'string'){
							$("#dialog-confirm").dialog({
				                resizable: false,
				                height: 250,
				                width:340,
				                buttons: {
				                    "<?php echo __('Print', null, 'offer') ?>": function() {
				                       window.location.href = "<?php echo url_for('offer/voucher?id=');?>"+data.voulchers_id;
				                    },
				                    <?php echo __('View', null, 'offer') ?>: function() {
				                    	window.location.href = "<?php echo url_for('profile/vouchers');?>";
				                    }
				                }
				            });
						}
						else {
							$("#dialog-confirm").dialog({
				                resizable: false,
				                height: 250,
				                width:340,
				                buttons: {
				                    <?php echo __('View', null, 'offer') ?>: function() {
				                    	window.location.href = "<?php echo url_for('profile/vouchers');?>";
				                    }
				                }
				            });

						}
					}
				}
			});

	    return false;
	});
                         	
    var bounds = new google.maps.LatLngBounds( );

    point = new google.maps.LatLng(<?php echo $company_offer->getCompany()->getLocation()->getLatitude() !=0 ? ($company_offer->getCompany()->getLocation()->getLatitude()): ($company_offer->getCompany()->getCity()->getLat()) ?>,<?php echo $company_offer->getCompany()->getLocation()->getLongitude()!=0 ? ( $company_offer->getCompany()->getLocation()->getLongitude() ):($company_offer->getCompany()->getCity()->getLng()) ?>);

	  map.markers[<?php echo $company_offer->getCompany()->getId(); ?>] = new google.maps.Marker({
		        title: '<?php echo $company_offer->getCompany()->getCompanyTitle() ?>',
		        position: point,
		        map: map.map,
		        draggable: false,
		        <?php if ($company_offer->getCompany()->getActivePPPService(true)):?>
		          icon: new google.maps.MarkerImage('/images/gui/icons/small_marker_'+<?php echo $company_offer->getCompany()->getSectorId() ?>+'.png', null, null, null, new google.maps.Size(40,40)),
		        zIndex: google.maps.Marker.MAX_ZINDEX + 1
		        <?php else :?>
		        icon: new google.maps.MarkerImage('/images/gui/icons/gray_small_marker_'+<?php echo $company_offer->getCompany()->getSectorId() ?>+'.png', null, null, null, new google.maps.Size(40,40)),
		        <?php endif;?>
		          });

			
		  bounds.extend(point);
		  google.maps.event.addListener(map.markers[<?php echo $company_offer->getCompany()->getId(); ?>], 'click', function() {
		        map.overlay.load(<?php echo json_encode(get_partial('search/item_overlay', array('company' => $company_offer->getCompany())));?>);
		              map.overlay.setCenter(new google.maps.LatLng(<?php echo $company_offer->getCompany()->getLocation()->getLatitude(); ?>, <?php echo $company_offer->getCompany()->getLocation()->getLongitude(); ?>));
		              map.overlay.show();
		              $('.nav_arrow2').hide();
		              $('#hide_sim_places').show();
		          });
		  map.map.setZoom(14);
		  map.map.setCenter(point);
  });
</script>

    <div id="dialog-confirm" title="<?php echo __('Congrats', null, 'offer') ?>" style="display:none;">
        <p><?php echo __("We just issued your voucher! It's saved in your Profile.", null, 'offer') ?></p>
    </div>
