<div class="moving-map-container">
  <div class="map">
    <div class="actual-map" id="google_map">
      
    </div>

    <div class="map_navigation">
      <div class="right">
      <ul>
        <?php /*?>
        <li>
          <a id="map_reload" href="javascript:void(0)">
            <img alt="<?php echo __("Reload") ?>" src="/images/gui/icon_reload.png" />
            <?php echo __('Show Places Nearby'); ?>
          </a>
        </li>
        <?php */?>
        <li class="add-place-btn-map">
        <?php echo link_to('<img src="/images/gui/add-new-place.png" alt="">', 'company/addCompany', array('title' => __('Add Place'))); //__('Add a place', null, 'company') ?>
          <a href="javascript:void(0)"></a>
          <span class="wrapper-tooltip">
            <span class="arrow-tooltip"></span>
            <span class="content-tooltip"><?php echo __('Click to add a new place', null, 'company'); ?></span>
          </span>
        </li>

        <li class="search-in-area">
        <a id="map_reload" href="javascript:void(0)"><img src="/images/gui/search-nearby.png" alt=""></a>
          <span class="wrapper-tooltip">
            <span class="arrow-tooltip"></span>
            <span class="content-tooltip"><?php echo __('Click to search in area', null, 'company'); ?></span>
          </span>
        </li>
      </ul>
        
        
      </div>
    </div>

    <div class="map_loader">
      <div class="smoke"></div>
    </div>

  </div>
  <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
		<?php if((!substr_count(get_slot('sub_module'),'vip')) && !has_slot('no_ads')): ?>
		<div class="sponsored">
			<div class="head-title">
				<?php echo __('Sponsored'); ?>
			</div>
			<!-- head-title -->

			<div class="body-content">
				<?php include_partial('global/ads', array('type' => 'box')) ?>
			</div>
			<!-- body-content -->
		</div>
		<!-- sponsored -->
		<?php endif; ?>
	<?php endif; ?>

<script type="text/javascript">
  $(window).bind('load', function() {
	  map.autoTrigger = true;
    <?php  if (getlokalPartner::getInstanceDomain() == 78): ?>
    
      var address = '<?php echo $sf_user->getCounty()->getLocation('en'); ?>';
      var geocoder = new google.maps.Geocoder();

      if($.isEmptyObject(map.markers)){
	      geocoder.geocode( { 'address': address, 'region': 'fi'}, function(results, status) {
		      var geometry = results[0].geometry;             
		      var bounds = new google.maps.LatLngBounds(geometry.bounds.getSouthWest(),geometry.bounds.getNorthEast());
		
		      map.map.fitBounds(bounds);
		      var z = map.map.getZoom();
		      map.map.setZoom(z+1);
		      map.autoTrigger = true;
	        //setTimeout($("#map_reload").trigger('click'),0);
	      });
      }
     <?php else: ?>
       
       //console.log(map.map.getBounds());

       //setTimeout( function(){console.log(map.map.getBounds())},5000);
     <?php endif; ?>
  });
</script> 