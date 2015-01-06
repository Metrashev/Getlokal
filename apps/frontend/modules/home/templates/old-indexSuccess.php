
<div class="sidebar" id="rightColumn" style="float: right;">

  <?php include_component('box', 'column', array('key' => 'home', 'column' => 2)); ?>
  <?php if ($sf_user->getCountry()->getSlug()!= 'fi'):?>
        <?php include_partial('global/ads', array('type' => 'box')) ?>
    <?php include_component('home','social_sidebar'); ?>
  <?php endif;?>
   
  <?php include_component('box', 'boxVip') ?>
  <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
       <?php  include_partial('global/ads', array('type' => 'box2')); ?>   
  <?php endif;?>   
  <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
       <?php  include_partial('global/ads', array('type' => 'adoce')); ?>   
  <?php endif;?>
</div>

<div class="content_in" id="middleColumn">
  <?php include_component('box', 'boxSlider2') ?>
  <?php include_component('box', 'column', array('key' => 'home', 'column' => 1))?>
</div>
<div class="clear"></div>


<script type="text/javascript">
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
        map.autoTrigger = true;
      	setTimeout($("#map_reload").trigger('click'),0);	 
      });	    
     <?php else: ?>        
       map.autoTrigger = true;
 	   setTimeout($("#map_reload").trigger('click'),0);
     <?php endif; ?>
  });
</script> 
