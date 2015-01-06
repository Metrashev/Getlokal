<?php slot('no_map', true) ?>
<?php slot('no_ads', true) ?>
<div class="settings_content">
  <h2>Tab Name</h2>
  
  <form action="<?php echo url_for('companySettings/location?id='. $company->getId()) ?>">
    
    <div class="form_box <?php echo $form['building_no']->hasError()? 'error': '' ?>">
      <?php echo $form['building_no']->renderLabel() ?>
      <?php echo $form['building_no']->render(array('style' => 'width: 300px')) ?>
      
      <?php echo $form['building_no']->renderError() ?>
    </div>
    
    <div class="form_box <?php echo $form['street']->hasError()? 'error': '' ?>">
      <?php echo $form['street']->renderLabel() ?>
      <?php echo $form['street']->render(array('style' => 'width: 300px')) ?>
      
      <?php echo $form['street']->renderError() ?>
    </div>
    
    <div id="map_canvas" style="width: 400px; height: 300px;"></div>
    
    <div class="form_box <?php echo $form['entrance']->hasError()? 'error': '' ?>">
      <?php echo $form['entrance']->renderLabel() ?>
      <?php echo $form['entrance']->render() ?>
      
      <?php echo $form['entrance']->renderError() ?>
    </div>
    
    <div class="form_box <?php echo $form['floor']->hasError()? 'error': '' ?>">
      <?php echo $form['floor']->renderLabel() ?>
      <?php echo $form['floor']->render() ?>
      
      <?php echo $form['floor']->renderError() ?>
    </div>
    
    <div class="form_box <?php echo $form['appartment']->hasError()? 'error': '' ?>">
      <?php echo $form['appartment']->renderLabel() ?>
      <?php echo $form['appartment']->render() ?>
      
      <?php echo $form['appartment']->renderError() ?>
    </div>

    <div class="form_box">
      <input type="submit" value="Save" class="input_submit" />
    </div>

  </form>

</div>


<div class="clear"></div>

<?php use_javascript('http://maps.googleapis.com/maps/api/js?key=AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08&sensor=false') ?>
<script type="text/javascript">
$(document).ready(function() {
  var map_center = new google.maps.LatLng(<?php echo $company->getLocation()->getLatitude() ?>, <?php echo $company->getLocation()->getLongitude() ?>);
  
  var myOptions = {
    center: map_center,
    zoom: 14,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    streetViewControl: true
  };
  
  var geocoder = new google.maps.Geocoder();
  
  var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
      
  var marker = new google.maps.Marker({
        map: map, 
        position: map_center,
        draggable: true,
        title: '<?php echo $company->getCompanyTitle() ?>'
    });
    
  google.maps.event.addListener(marker, 'dragend', dropMarker);
  
  function dropMarker()
  {
    console.log(marker.getPosition());
    
    geocoder.geocode( { 'latLng': marker.getPosition()}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        console.log($(results));
        $(results[0].address_components).each(function(i,s) {
          if(s.types[0] == 'street_number')
            $('#company_location_building_no').val(s.long_name);
          else if(s.types[0] == 'route')
            $('#company_location_street').val(s.long_name);
          else if(s.types[0] == 'sublocality')
            $('#company_location_neighbourhood').val(s.long_name);
        })
        
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });

  }
    
  $('#company_location_street').change(function() {
    console.log($('#company_location_street').val());
    
    geocoder.geocode( { 'address': $('#company_location_street').val() + ", "+ $('#company_location_city_id').val()}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        console.log(results[0].geometry.location);
        
        map.setCenter(results[0].geometry.location);
          
        marker.setPosition(results[0].geometry.location);
        
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  })
})
</script>