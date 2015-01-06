<?php use_helper('XssSafe'); ?>

<script>

$(window).bind('load', function() {
	<?php if ($sf_request->getParameter('county',false) && getlokalPartner::getInstanceDomain() == 78): ?>	  
      var address = '<?php echo $sf_user->getCounty()->getLocation('en'); ?>';
      var geocoder = new google.maps.Geocoder();
  
      geocoder.geocode( { 'address': address, 'region': 'fi'}, function(results, status) {
        var geometry = results[0].geometry;      	      
        var bounds = new google.maps.LatLngBounds(geometry.bounds.getSouthWest(),geometry.bounds.getNorthEast());

	    map.map.fitBounds(bounds);	 
        var z = map.map.getZoom();
        map.map.setZoom(z+1);
        map.sector_id = '<?php echo $sector->getId(); ?>';
        map.autoTrigger = true;
    	setTimeout($("#map_reload").trigger('click'),0);	 
      });	    
    <?php else: ?>        
      map.autoTrigger = true;
      map.sector_id = '<?php echo $sector->getId(); ?>';
	  setTimeout($("#map_reload").trigger('click'),0);
    <?php endif; ?>			    
});

</script>
<div class="sector-classification-wrap">
 <?php include_component('box', 'boxCategoriesMenu'); ?>
  <?php if (count($classifications)>0):?>
  <?php if(isset($county)): ?>
  	<?php include_partial('home/related_classificationsWide', array('classifications'=>$classifications, 'sector'=>$sector, 'county' => $county));?>
  <?php else: ?>
  	<?php include_partial('home/related_classificationsWide', array('classifications'=>$classifications, 'sector'=>$sector, 'county' => null));?>
  <?php  endif; ?>  	
  <?php endif;?>   
</div>
<div class="content_in">
    

  <?php include_component('box', 'boxSlider2', array('box' => $reviews, 'sector' => $sector)); ?>

  <!--2 columns -->
  <?php if(isset($county)): ?>
  	<?php include_partial('home/top_places', array('topLocations' => $topLocations, 'sector' => $sector, 'county' => $county));?>
  <?php else: ?>
  	<?php include_partial('home/top_places', array('topLocations' => $topLocations, 'sector' => $sector, 'county' => null));?>
  <?php  endif; ?>
  <div id="eatingOut"></div>


  <?php include_component('box', 'boxReviews', array('box' => $reviews, 'sector'=>$sector)); ?>

  <div class="sector-description">
    <?php echo $sector->getDescription(ESC_XSSSAFE); ?>
  </div>
</div>
<div class="sidebar">
  <?php include_component('box', 'boxReview', array('box' => $reviews, 'sector' => $sector)); ?>
  <div style="margin:52px 0 0 0">
      <?php if (count(CompanyOfferTable::getOnlyActiveOffersQuery(null, $sf_user->getCountry()->getId(), $sector->getId())) > 0): ?>
            <?php include_component('box', 'boxOffers', array('sector_id' => $sector->getId())) ?>
        <?php else: ?>
            <?php include_component('box', 'boxOffers') ?>
        <?php endif; ?>
  </div>
  <?php include_partial('global/ads', array('type' => 'box')); ?>  
  <?php if ($sf_user->getCountry()->getSlug()!= 'fi'):?>  
    <?php include_component('home','social_sidebar'); ?>
  <?php endif;?> 
  <?php include_component('box', 'boxVip', array('box' => $reviews)); ?>
  <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
        <div class="pullUp">
            <?php  include_partial('global/ads', array('type' => 'box2')); ?>
        </div>    
  <?php endif;?> 

  <?php //include_component('box', 'boxEvent', array('box' => $reviews)) ?>

</div>
<div class="clear"></div>
