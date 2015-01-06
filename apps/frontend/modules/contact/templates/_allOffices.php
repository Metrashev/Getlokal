<div id="map_canvas" class="map-height">
     
</div>
<div class="map_navigation view_all" style="display:none;">
    <div class="bottom right">
                        <a class="nav_button" ><img src="/images/gui/icon_enlarge.png" /><?php echo __('see all'); ?></a>
                    </div>
                </div>
<?php use_javascript('http://maps.googleapis.com/maps/api/js?key=AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08&sensor=false') ?>
<script type="text/javascript">
$(document).ready(function() {
	 var map_center = new google.maps.LatLng(43.996766, 22.867645);
	 var getlokalBG = new google.maps.LatLng(42.68099, 23.310592);
     var getlokalRO = new google.maps.LatLng(44.432444,26.107978);
     var getlokalSR = new google.maps.LatLng(44.807038,20.4579887);
     var getlokalMK = new google.maps.LatLng(42.000636,21.414362);
     var getlokalHU = new google.maps.LatLng(47.456598, 18.947098);
	 var myOptions = {
			    center: map_center,
			    zoom: 6,
			    mapTypeId: google.maps.MapTypeId.ROADMAP,
			    streetViewControl: true
			  };
			  
                            var pinIcon = new google.maps.MarkerImage(
                            '/images/gui/icons/pin.svg',
                            null, /* size is determined at runtime */
                            null, /* origin is 0,0 */
                            null, /* anchor is bottom center of the scaled image */
                            new google.maps.Size(40, 50)
                        );  
                          
                          
			  var geocoder = new google.maps.Geocoder();
			  
			  var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
			      
			  var markerBG = new google.maps.Marker({
			        map: map, 
			        position: getlokalBG,
			        draggable: false
			    });
                  
			  markerBG.setIcon(pinIcon);
              
               var markerRO = new google.maps.Marker({
			        map: map, 
			        position: getlokalRO,
			        draggable: false
			    });
			  markerRO.setIcon(pinIcon); 
              
               var markerMK = new google.maps.Marker({
			        map: map, 
			        position: getlokalMK,
			        draggable: false
			    });
			  markerMK.setIcon(pinIcon); 
              
               var markerSR = new google.maps.Marker({
			        map: map, 
			        position: getlokalSR,
			        draggable: false
			    });
                
			  markerSR.setIcon(pinIcon); 
                          
              var markerHU = new google.maps.Marker({
			        map: map, 
			        position: getlokalHU,
			        draggable: false
			    });
                
			  markerHU.setIcon(pinIcon);             
              /*Bulgaria hover*/
               $('a.office_bg').live('click', function() {
                   map.panTo(markerBG.position);
                   map.setZoom(16);
                   $('.map_navigation.view_all').show();
               });
                $('a.office_bg').live('mouseover', function() {
                   map.panTo(markerBG.position);
                   markerBG.setAnimation(google.maps.Animation.BOUNCE);
               });
              $('a.office_bg').live('mouseout', function() {
                   map.panTo(markerBG.position);
                   markerBG.setAnimation(null);
               });
               /*Macedonia hover*/
               $('a.office_mk').live('click', function() {
                   map.panTo(markerMK.position);
                   map.setZoom(16);
                   $('.map_navigation.view_all').show();
               });
               $('a.office_mk').live('mouseover', function() {
                   map.panTo(markerMK.position);
                   markerMK.setAnimation(google.maps.Animation.BOUNCE);
               });
              $('a.office_mk').live('mouseout', function() {
                   map.panTo(markerMK.position);
                   markerMK.setAnimation(null);
               });
               /*Serbia hover*/
                $('a.office_sr').live('click', function() {
                   map.panTo(markerSR.position);
                   map.setZoom(16);
                   $('.map_navigation.view_all').show();
               });
               $('a.office_sr').live('mouseover', function() {
                   map.panTo(markerSR.position);
                   markerSR.setAnimation(google.maps.Animation.BOUNCE);
               });
              $('a.office_sr').live('mouseout', function() {
                   map.panTo(markerSR.position);
                   markerSR.setAnimation(null);
                    
               });         
               /*Romania hover*/
                $('a.office_ro').live('click', function() {
                   map.panTo(markerRO.position);
                   map.setZoom(16);
                   $('.map_navigation.view_all').show();
               });
               $('a.office_ro').live('mouseover', function() {
                   map.panTo(markerRO.position);
                   markerRO.setAnimation(google.maps.Animation.BOUNCE);
               });
              $('a.office_ro').live('mouseout', function() {
                   map.panTo(markerRO.position);
                   markerRO.setAnimation(null);
               });
                 /*Hungary hover*/
               $('a.office_hu').live('click', function() {
                   map.panTo(markerHU.position);
                   map.setZoom(16);
                   $('.map_navigation.view_all').show();
               });
                $('a.office_hu').live('mouseover', function() {
                   map.panTo(markerHU.position);
                   markerHU.setAnimation(google.maps.Animation.BOUNCE);
               });
              $('a.office_hu').live('mouseout', function() {
                   map.panTo(markerHU.position);
                   markerHU.setAnimation(null);
               });
               
               
               /*End hover*/
                $('a.nav_button').live('click', function() {
                   map.panTo(map_center);
                   map.setZoom(6);
                   $('.map_navigation.view_all').hide();
               });
              

});
</script>


   