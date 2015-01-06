<?php use_helper('XssSafe') ?>

<?php if($classification->getId() == '66' || $classification->getId() == '127'):?>
<?php slot('no_ads', true) ?>
<?php endif; ?>

<?php if($classification->getPrimarySector()->getId() != $sector->getId()):?>
 <?php slot('canonical') ?>
  <?php if (/*isset($county) &&*/ $county): ?>
      <link rel="canonical" href="<?php echo url_for('@classificationCounty?slug='. $classification->getSlug(). '&sector='. $classification->getPrimarySector()->getSlug(). '&county='. $sf_user->getCounty()->getSlug(),true); ?>" />
  <?php else: ?>
      <link rel="canonical" href="<?php echo url_for('@classification?slug='. $classification->getSlug(). '&sector='. $classification->getPrimarySector()->getSlug(). '&city='. $sf_user->getCity()->getSlug(),true); ?>" />
  <?php endif; ?>
 <?php end_slot() ?>
<?php endif;?>

<?php use_helper('Pagination') ?>

<script type="text/javascript">
$(document).ready(function() {            
  map.useAjaxPagination = true;
  map.itemsPerPage = 20;
  //map.geocodeAndLoad(map.address);

  var bounds = new google.maps.LatLngBounds();

  <?php if ($pager->getNbResults() > 0):
    foreach ($pager->getResults() as $company):?>
      point = new google.maps.LatLng(<?php echo $company->getLocation()->getLatitude() !=0 ? ($company->getLocation()->getLatitude()): ($company->getCity()->getLat()) ?>,<?php echo $company->getLocation()->getLongitude()!=0 ? ( $company->getLocation()->getLongitude() ):($company->getCity()->getLng()) ?>);
      map.markers[<?php echo $company->getId(); ?>] = new google.maps.Marker({
        title: '<?php echo $company->getCompanyTitle() ?>',
        position: point,
        map: map.map,
        draggable: false,
        <?php if ($company->getActivePPPService(true)): ?>
        icon: new google.maps.MarkerImage('/images/gui/icons/small_marker_'+<?php echo $company->getSectorId() ?>+'.png', null, null, null, new google.maps.Size(40,40)),
        zIndex: google.maps.Marker.MAX_ZINDEX + 1
        <?php else :?>
        icon: new google.maps.MarkerImage('/images/gui/icons/gray_small_marker_'+<?php echo $company->getSectorId() ?>+'.png', null, null, null, new google.maps.Size(40,40)),
        <?php endif;?>
          });

      bounds.extend(point);

      google.maps.event.addListener(map.markers[<?php echo $company->getId(); ?>], 'click', function() {
        map.overlay.load(<?php echo json_encode(get_partial('search/item_overlay', array('company' => $company)));?>);
              map.overlay.setCenter(new google.maps.LatLng(<?php echo $company->getLocation()->getLatitude(); ?>, <?php echo $company->getLocation()->getLongitude(); ?>));
              map.overlay.show();
              $('.nav_arrow2').hide();
              $('#hide_sim_places').show();
          });
    <?php endforeach;?>

    map.classification_id = '<?php echo $classification->getId(); ?>';
    map.map.fitBounds(bounds);
    var listener = google.maps.event.addListener(map.map, "idle", function() { 
     if (map.map.getZoom() > 16) map.map.setZoom(16); 
     google.maps.event.removeListener(listener); 
   });
    $("#google_map").css('height', '400px');
    $(".map_activator").css('height', '400px');
    $(".nav_arrow").toggle('fast');
    google.maps.event.trigger(map.map, 'resize');

  <?php endif;?>
});
</script>
<div class="sector-classification-wrap">
    <?php include_component('box', 'boxCategoriesMenu') ?>
    <?php if (count($classifications) > 0): ?>
        <?php include_partial('home/related_classificationsWide', array('classifications' => $classifications, 'sector' => $sector, 'county' => $county)); ?>
    <?php endif; ?>
</div>
<div class="breadcrumb external">
      <?php foreach(breadCrumb::getInstance()->getItems() as $i=>$item): ?>
        <?php if($item->getUri()): ?>
          <?php echo link_to($item->getText(), $item->getUri()) ?>
        <?php else: ?>
          <?php echo $item->getText() ?>
        <?php endif ?>
        <?php if($i+1 < sizeof(breadCrumb::getInstance()->getItems())) echo '/' ?>
      <?php endforeach ?>
    <?php echo '/' ?>
    <?php if($sf_user->getCulture() != 'en' && $sf_user->getCulture() != $sf_user->getCountry()->getSlug() && method_exists($transliterate,$to)):?>
        <?php if ($county): ?>
    		<a><?php echo isset($street_params) ? $classification->getTitle() .' - '. $county->getLocation().', ' . mb_convert_case ( call_user_func ( array ($transliterate, $to ), $street_params ), MB_CASE_LOWER, 'UTF-8' ): $classification->getTitle() .' - '. $county->getLocation();?></a>
    	<?php else: ?>
        	<a><?php echo isset($street_params) ? $classification->getTitle() .' - '. $city->getLocation().', ' . mb_convert_case ( call_user_func ( array ($transliterate, $to ), $street_params ), MB_CASE_LOWER, 'UTF-8' ): $classification->getTitle() .' - '. $city->getLocation();?></a>
        <?php endif; ?>
    <?php else:?>
        <?php if ($county): ?>
    		<a><?php echo isset($street_params) ? $classification->getTitle() .' - '. $county->getLocation().', ' .$street_params: $classification->getTitle() .' - '. $county->getLocation();?></a>
    	<?php else: ?>
        	<a><?php echo isset($street_params) ? $classification->getTitle() .' - '. $city->getLocation().', ' .$street_params: $classification->getTitle() .' - '. $city->getLocation();?></a>
        <?php endif; ?>
    <?php endif;?>
</div>
    
<div class="content_in" style="padding:0;">
    <?php $transliterate = 'Transliterate'. $sf_user->getCountry()->getSlug();?>
    <?php $to = 'to'.$sf_user->getCulture()?>
  <div class="classification-description">
    <?php echo $classification->getDescription(ESC_XSSSAFE) ?>
  </div>

  <?php if ($pager->getNbResults() > 0):?>
  <div class="listing_tabs_wrap" style="padding: 0">
    <div class="listing_number">
        <?php if ($county): ?>
    		<a title="<?php echo __('Places')?> (<?php echo $pager->getNbResults() ?>)" href="<?php echo url_for('@classificationCounty?slug='. $classification->getSlug(). '&sector='. $classification->getPrimarySector()->getSlug(). '&county='. $sf_user->getCounty()->getSlug(),true); ?>" class="current"><?php echo __('Places')?> (<span id="places_count"><?php echo $pager->getNbResults() ?></span>)</a>
    	<?php else : ?>
        	<a title="<?php echo __('Places')?> (<?php echo $pager->getNbResults() ?>)" href="<?php echo url_for('@classification?slug='. $classification->getSlug(). '&sector='. $classification->getPrimarySector()->getSlug(). '&city='. $sf_user->getCity()->getSlug(),true); ?>" class="current"><?php echo __('Places')?> (<span id="places_count"><?php echo $pager->getNbResults() ?></span>)</a>
        <?php endif; ?>
    </div>

    <div class="listing_wrapper">
      <div class="listing_place_wrap">
        <?php foreach($pager->getResults() as $company): ?>
          <div class="listing_place <?php echo $company->getActivePPPService(true)? 'vip' :'' ?>">
              <?php if ($company->getActivePPPService(true)):?>
                <?php echo link_to(image_tag($company->getThumb(2), 'alt='. $company->getCompanyTitle()), $company->getUri(ESC_RAW), 'class=listing_place_img title=' . $company->getCompanyTitle()) ?>
                <div class="vip_badge"></div>
                <div class="official_page"><?php echo __('Official page', null, 'company'); ?></div>
              <?php else:?>
                <?php echo link_to(image_tag($company->getThumb(2), 'alt='. $company->getCompanyTitle()), $company->getUri(ESC_RAW), 'class=listing_place_img title=' . $company->getCompanyTitle()) ?>
              <?php endif;?>
            <div class="listing_place_in">
                 <?php if (!$company->getActivePPPService(true)):?>
              <div class="listing_place_rateing">
                <div class="rateing_stars">
                  <div class="rateing_stars_orange" style="width: <?php echo $company->getRating() ?>%;"></div>
                </div>
                <span class=""><?php echo format_number_choice('[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $company->getNumberOfReviews()), $company->getNumberOfReviews()); ?></span>
              </div>
                <h3>
                  <a href="<?php echo url_for($company->getUri(ESC_RAW)) ?>" title="<?php echo $company->getCompanyTitle() ?>">
                    <?php echo $company->getCompanyTitle() ?>
                  </a>
                </h3>
                <?php else:?>
                <h3>
                  <a href="<?php echo url_for($company->getUri(ESC_RAW)) ?>" title="<?php echo $company->getCompanyTitle() ?>">
                    <?php echo $company->getCompanyTitle() ?>
                  </a>
                </h3>
                <div class="listing_place_rateing vip">
                    <div class="rateing_stars">
                        <div class="rateing_stars_orange" style="width: <?php echo $company->getRating() ?>%;"></div>
                    </div>
                    <span class=""><?php echo format_number_choice('[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $company->getNumberOfReviews()), $company->getNumberOfReviews()); ?></span>
                </div> 
                <?php endif;?>
              <?php if ($county): ?>
                  <p><strong><?php echo link_to(sprintf(__('%s in %s'), $sector, $company->getCity()->getCounty()->getLocation()), '@sectorCounty?slug='. $sector->getSlug(). '&county='. $sf_user->getCounty()->getSlug(), array('class'=>'category', 'title' => sprintf(__('%s in %s'), $sector, $company->getCity()->getCounty()->getLocation())));?></strong></p>
              <?php else: ?>    
                  <p><strong><?php echo link_to(sprintf(__('%s in %s'), $sector, $company->getCity()->getDisplayCity()), '@sector?slug='. $sector->getSlug(). '&city='. $sf_user->getCity()->getSlug(), array('class'=>'category', 'title' => sprintf(__('%s in %s'), $sector, $company->getCity()->getLocation())));?></strong></p>
              <?php endif; ?>    
              <p>
                <?php echo $company->getDisplayAddress() ?><br />
                <?php echo $company->getPhoneFormated() ?>
              </p>
	            <?php if ($company->getAllOffers()):?>
	            <div title="<?php echo format_number_choice( '[1]1 offer for %company%|(1,+Inf]%count% offers for %company%',
	                                  array('%count%' => $company->getAllOffers(true,false,true), '%company%'=>$company->getCompanyTitle() ),
	                                  $company->getAllOffers(true,false,true),'offer' )   ; ?>" class="available_company_offers">
	                <div class="company_offers_count">
	                    <?php echo $company->getAllOffers(true, false, true) ;?>
	                </div>
	            </div>
	        	<?php endif;?>
            </div>
            <div class="clear"></div>
            <?php // Last review ?>
            <?php $review = $company->getTopReview(); ?>
            <?php if($review && $review->getUserProfile()): ?>
              <div class="listing_place_review">
                 <strong><?php echo $review->getUserProfile()->getLink(ESC_RAW) ?></strong>
                  <?php if ($sf_user->getCulture() == 'bg'): ?>
                        <?php echo image_tag('gui/quotation_icon_bg.png', array('class' => 'quotation_icon')) ?>
                  <?php else : ?>
                        <?php echo image_tag('gui/quotation_icon.png', array('class' => 'quotation_icon')) ?>
                  <?php endif; ?>
                 <q>
                     
                    <?php if(strlen(strip_tags($review->getText())) > 400): ?>
                     <?php 
                        
                        $truncate_text = substr(strip_tags($review->getText()), 0, 400 - strlen('...'));
                        
                        
                        echo preg_replace('/\s+?(\S+)?$/', '', $truncate_text).'...';
                        
                     ?>
                          <a href="<?php echo url_for($company->getUri(ESC_RAW)) ?>" class="link_to_company">
                              <?php echo __('see more'); ?>
                          </a>
                    <?php else:?>
                          <?php echo $review->getText(ESC_XSSSAFE);?>
                    <?php endif; ?>
                 </q>
              <div class="clear"></div>
              </div>
            <?php endif ?>
          </div>
         <?php  if ($company->getActivePPPService (true)):
           CompanyStatsTable::saveStatsLog(sfConfig::get('app_log_actions_company_show_category'), $company->getId());
         endif;
      ?>
        <?php endforeach ?>

      </div>

      <?php if ($county): ?>
          <?php echo pager_navigation($pager, '@classificationCounty?slug='. $classification->getSlug(). '&sector='. $sector->getSlug(). '&county='. $sf_user->getCounty()->getSlug()) ?>
      <?php else: ?>
          <?php echo pager_navigation($pager, '@classification?slug='. $classification->getSlug(). '&sector='. $sector->getSlug(). '&city='. $sf_user->getCity()->getSlug()) ?>
      <?php endif; ?>

      <div class="ajaxPager" style="display: none">
                        <div class="pagerLeft">
                        </div>

                        <div class="pagerCenter">
                        </div>

                        <div class="pagerRight">
                        </div>
                    </div>

    </div>


  </div>
  <?php else:?>
    <?php if ($county): ?>
		<h3><?php echo __('No Results found for %keyword% in %place%', array('%keyword%' => $classification->getTitle(), '%place%' => $county->getLocation())) ?></h3>
	<?php  else: ?>
    	<h3><?php echo __('No Results found for %keyword% in %place%', array('%keyword%' => $classification->getTitle(), '%place%' => $city->getLocation())) ?></h3>
    <?php endif; ?>
<?php $country = __($sf_user->getCountry()->getName());?>
      <p><?php echo __('If you want to search again for another location, please use the \'Where\' field to enter the right location. It is also possible to expand your search to cover the whole of %s', array('%s' => $country)) ?></p>

      <p><?php echo sprintf(__('Couldn\'t find the place you were looking for? %s and we\'ll add it.'), link_to(__('Send it to us'), 'company/addCompany')); ?></p>
      
<?php endif;?>
</div>
<div class="sidebar">
    <div style="margin-top: 42px"> 
          <?php if (count(CompanyOfferTable::getOnlyActiveOffersQuery(null, $sf_user->getCountry()->getId(), $sector->getId())) > 0): ?>
            <?php include_component('box', 'boxOffers', array('sector_id' => $sector->getId())) ?>
        <?php else: ?>
            <?php include_component('box', 'boxOffers') ?>
        <?php endif; ?>
    </div>
   <?php include_partial('global/ads', array('type' => 'box')) ?>
   <?php if ($sf_user->getCountry()->getSlug()!= 'fi'):?>  
    <?php include_component('home','social_sidebar'); ?>
  <?php endif;?> 

  <?php // include_component('box', 'boxVip', array('box' => $box)) ?>
  <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
        <?php  include_partial('global/ads', array('type' => 'box2')); ?>   
  <?php endif;?>
   <div class="sidebarBtn-cont">  
          <?php echo link_to('<span>+</span>'.__('Add a place', null, 'company'), 'company/addCompany', array('title' => __('Add Place'), 'class'=>'sidebarBtn button_green')); ?>
   </div>     
</div>
<div class="clear"></div>
