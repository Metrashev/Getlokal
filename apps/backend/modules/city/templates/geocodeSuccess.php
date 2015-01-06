<?php 
set_time_limit(0);
ob_implicit_flush(true);
foreach ( $records as $city ) {
	$adr = $city->getCounty()->getCountry()->getName().",".$city->getCounty()->getName().",".$city->getName();
	//print_r($adr."<br />");
	print_r($city->getId().',');
?>
<script type="text/javascript">
	var geocoder= new google.maps.Geocoder();
	geocoder.geocode( { 'address': '<?php print_r($adr); ?>'}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				    console.log(results[0].geometry.location.lat()+':'+results[0].geometry.location.lng());

					var lat = results[0].geometry.location.lat();
					var lng = results[0].geometry.location.lng();
					var cityId = '<?php echo $city->getId(); ?>';
				    $.ajax({
				        url: '<?php echo url_for("city/savegeo") ?>',
				        type: 'POST',
				        data: {'lat':lat,'lng':lng, 'cityId':cityId},
				        success: function(data, url) {
					        
				        },
				        error: function(e, xhr)
				        {
				          console.log(e);
				        }
				        
				    });

				    
			}
			else {
				alert("Geocode was not successful for the following reason: " + status);
			}
		});
</script> 

<?php	sleep(1);
	//2, 4, 5, 7, 10, 11, 12, 14, 16, 17,
	
}




  