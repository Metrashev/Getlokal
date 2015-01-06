<?php slot('no_map', true) ?>
<?php slot('no_ads', true) ?>
<?php use_helper('jQuery') ?>

<?php $lng= mb_convert_case(getlokalPartner::getLanguageClass(), MB_CASE_LOWER,'UTF-8');   ?>

<?php $languages = sfConfig::get('app_languages_'.$lng)?>
<div class="settings_content company_details">
	<h2 class="dotted"><?php echo __('Place Information', null,'company')?></h2>

	<form id="cs-form" action="<?php echo url_for('companySettings/basic?slug='. $company->getSlug()) ?>" method="post">
		<?php echo $form['_csrf_token']->render() ?>
		
		<div class="form_box form_big form_label_inline  <?php echo $form[$lng]['title']->hasError()? 'error': ''?>">
			<?php echo $form[$lng]['title']->renderLabel() ?>
			<span class="pink">&nbsp;*</span>
			<?php echo $form[$lng]['title']->render(); ?>
			<?php echo $form[$lng]['title']->renderError() ?>
		</div>
      
		<div class="form_wrap two_fields">
			<div class="form_box <?php echo $form['en']['title']->hasError()? 'error': ''?>">
				<?php // echo $form['en']['title']->renderLabel() ?>
                                <label><?php echo __('Place Name in English', null, 'company'); ?></label>
				<?php echo $form['en']['title']->render(); ?>
				<?php echo $form['en']['title']->renderError() ?>
			</div>
                        <?php if(count($languages) >2):?>
                            <?php foreach ($languages as $language):?>
                                <?php if($language != 'en' && $language != $lng):?>
                                    <div class="form_box <?php echo $form[$language]['title']->hasError()? 'error': ''?>">
                                        <?php echo __('Place Name in '.sfConfig::get('app_cultures_en_'.$language), null, 'company'); ?>
                                        <?php echo $form[$language]['title']->render(); ?>
                                        <?php echo $form[$language]['title']->renderError() ?>
                                    </div>
                                <?php endif;?>
                            <?php endforeach;?>
                        <?php endif;?>
                    
			<?php ?>
			<div class="form_box form_label_inline<?php echo $form['city_id']->hasError()? 'error': ''?>">
				<?php echo $form['city_id']->renderLabel() ?>
        		<span class="pink">&nbsp;*</span>
        		<?php echo $form['city']->render(); ?>
				<?php // echo $form['city_id']->render(); ?>
				<?php echo $form['city_id']->renderError() ?>
			</div>
			<div class="clear"></div>
			<?php ?>
			<?php /*?>
			<div class="form_box form_label_inline<?php echo $form['city_id']->hasError()? 'error': ''?>">
				<?php echo $form['city_id']->renderLabel() ?>
				<span class="pink">&nbsp;*</span>
				<?php echo $form['city_id']->render(); ?>
				<?php echo $form['city_id']->renderError() ?>
			</div>
			<div class="clear"></div>
			<?php */ ?>
		</div>
      
		<div class="form_wrap location">
			<div class="form_box street_id<?php echo $form['company_location']['street_type_id']->hasError()? 'error': ''?>">
				<?php echo $form['company_location']['street_type_id']->render(); ?>
      			<?php echo $form['company_location']['street_type_id']->renderError() ?>
    		</div>
			<div class="form_box street_name form_label_inline <?php echo $form['company_location']['street']->hasError()? 'error': ''?>">
				<?php echo $form['company_location']['street_type_id']->renderLabel() ?>
				<span class="pink">&nbsp;<!--*--></span>
				<?php echo $form['company_location']['street']->render(); ?>
				<?php echo $form['company_location']['street']->renderError() ?>
			</div>
			<div class="form_box street_number form_label_inline<?php echo $form['company_location']['street_number']->hasError()? 'error': ''?>">
				<?php echo $form['company_location']['street_number']->renderLabel() ?>
				<span class="pink">&nbsp;<!--*--></span>
				<?php echo $form['company_location']['street_number']->render(); ?>
				<?php echo $form['company_location']['street_number']->renderError() ?>
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="form_wrap location">
			<?php if(isset($form['company_location']['location_type'])):?>
				<div class="form_box location_type <?php echo $form['company_location']['location_type']->hasError()? 'error': ''?>">
					<?php echo $form['company_location']['location_type']->render(); ?>
					<?php echo $form['company_location']['location_type']->renderError() ?>
				</div>
			<?php endif;?>
			
			<div class="form_box neighbourhood form_label_inline <?php echo $form['company_location']['neighbourhood']->hasError()? 'error': ''?>">
				<?php echo $form['company_location']['neighbourhood']->renderLabel() ?>
				<span class="pink">&nbsp;<!--*--></span>
				<?php echo $form['company_location']['neighbourhood']->render(); ?>
				<?php echo $form['company_location']['neighbourhood']->renderError() ?>
			</div>
			<div class="form_box building_no form_label_inline<?php echo $form['company_location']['building_no']->hasError()? 'error': ''?>"style="margin:0 20px 0 0">
				<?php echo $form['company_location']['building_no']->renderLabel() ?>
				<span class="pink">&nbsp;<!--*--></span>
				<?php echo $form['company_location']['building_no']->render(); ?>
				<?php echo $form['company_location']['building_no']->renderError() ?>
			</div> 
	        <div class="form_box address_info <?php echo $form['company_location']['address_info']->hasError() ? 'error' : '' ?>">
	            <?php echo $form['company_location']['address_info']->renderLabel() ?>
	            <?php echo $form['company_location']['address_info']->render(); ?>
	            <?php echo $form['company_location']['address_info']->renderError() ?>
	        </div>
			<div class="clear"></div>
		</div>

		<div class="company_settings_map">
			<div id="map_canvas"></div> 
		</div>
		
		<div class="additional_info_gray_bg">
			<div class="form_wrap two_fields">
				<?php if (isset($form['company_yp'])):?>
				<div class="form_box <?php echo $form['company_yp']['sr_url']->hasError()? 'error': ''?>">
					<?php echo $form['company_yp']['sr_url']->renderLabel() ?>
					<?php echo $form['company_yp']['sr_url']->render(); ?>
					<?php echo $form['company_yp']['sr_url']->renderError() ?>
				</div>
				<?php endif;?>
				<div class="form_box <?php echo $form['website_url']->hasError()? 'error': ''?>">
					<?php echo $form['website_url']->renderLabel() ?>
					<?php echo $form['website_url']->render(); ?>
					<?php echo $form['website_url']->renderError() ?>
				</div>
				<div class="form_box <?php echo $form['email']->hasError()? 'error': ''?>">
					<?php echo $form['email']->renderLabel() ?>
					<?php echo $form['email']->render(); ?>
					<?php echo $form['email']->renderError() ?>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="form_wrap three_fields phones">
				<div class="form_box <?php echo $form['phone']->hasError()? 'error': ''?>">
					<?php echo $form['phone']->renderLabel() ?>
					<?php echo $form['phone']->render(); ?>
					<a class="tip">
                        <span class="details"><?php echo __('The correct format to use is 023456789 or for mobile phones 0888888888. Add only the local area code for landlines. Only add digits – any other characters or spaces between characters are not allowed.', null, 'company') ?></span>
                    </a> 
					<?php echo $form['phone']->renderError() ?>
				                    
				</div>
                                
				<div class="form_box <?php echo $form['phone1']->hasError()? 'error': ''?>">
					<?php echo $form['phone1']->renderLabel() ?>
					<?php echo $form['phone1']->render(); ?>
					<a class="tip">
                        <span class="details"><?php echo __('The correct format to use is 023456789 or for mobile phones 0888888888. Add only the local area code for landlines. Only add digits – any other characters or spaces between characters are not allowed.', null, 'company') ?></span>
                    </a> 
					<?php echo $form['phone1']->renderError() ?>
				</div>
				<div class="form_box <?php echo $form['phone2']->hasError()? 'error': ''?>">
					<?php echo $form['phone2']->renderLabel() ?>
					<?php echo $form['phone2']->render(); ?>
					<a class="tip">
                        <span class="details"><?php echo __('The correct format to use is 023456789 or for mobile phones 0888888888. Add only the local area code for landlines. Only add digits – any other characters or spaces between characters are not allowed.', null, 'company') ?></span>
                    </a> 
					<?php echo $form['phone2']->renderError() ?>
				</div>
				<div class="clear"></div>
			</div>   
      
			<div class="form_wrap two_fields">
				<?php if(isset($form['registration_no'])):?>
					<div class="form_box <?php echo $form['registration_no']->hasError()? 'error': ''?>">
						<?php echo $form['registration_no']->renderLabel() ?>
						<?php echo $form['registration_no']->render(); ?>
						<?php echo $form['registration_no']->renderError() ?>
					</div>
				<?php endif;?>

				<div class="form_box <?php echo $form['company_location']['postcode']->hasError()? 'error': ''?>">
					<?php echo $form['company_location']['postcode']->renderLabel() ?>
					<?php echo $form['company_location']['postcode']->render(); ?>
					<?php echo $form['company_location']['postcode']->renderError() ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	      
		<div class="additional_info_gray_bg company_settings_social">
			<div class="form_box <?php echo $form['facebook_url']->hasError()? 'error': ''?>">
				<?php echo $form['facebook_url']->render(); ?>
	            <?php echo $form['facebook_url']->renderLabel() ?>  
	            <?php echo $form['facebook_url']->renderError() ?>
	         </div>
			<div class="clear"></div>
	        <div class="form_box <?php echo $form['twitter_url']->hasError()? 'error': ''?>">
				<?php echo $form['twitter_url']->render(); ?>
				<?php echo $form['twitter_url']->renderLabel() ?>
				<?php echo $form['twitter_url']->renderError() ?>
	        </div>
			<div class="clear"></div>
	        <div class="form_box <?php echo $form['googleplus_url']->hasError()? 'error': ''?>">
				<?php echo $form['googleplus_url']->render(); ?>
				<?php echo $form['googleplus_url']->renderLabel() ?>
				<?php echo $form['googleplus_url']->renderError() ?>
	        </div>
			<div class="clear"></div>
	        <div class="form_box <?php echo $form['foursquare_url']->hasError()? 'error': ''?>">       
				<?php echo $form['foursquare_url']->render(); ?>
				<?php echo $form['foursquare_url']->renderLabel() ?>
				<?php echo $form['foursquare_url']->renderError() ?>
	        </div>
			<div class="clear"></div>   
		</div>
		<div class="clear"></div>
	      
	    <div class="form_box">
			<input type="submit" value="<?php echo __('Save');?>" class="button_green" />
	    </div>
		<div class="clear"></div>
			
	    <div class="mandatory_notice">
	        <p><?php echo __('All fields marked with <span>*</span> are mandatory', null,'company')?></p>
	    </div> 
	    
		<?php echo $form->renderHiddenFields();?>
	</form>
</div> 


<div class="clear"></div>
<?php $lang = getlokalPartner::getDefaultCulture ( $company->getCountryId () );
$country  = $company->getCountryId();?>
		

<script type="text/javascript">
<?php 

			?>
<?php switch ($country):
   case getlokalPartner::GETLOKAL_RO:
   	 $deflat = "44.44432";
     $deflong ="26.096935";
    break;
    case getlokalPartner::GETLOKAL_MK:
   	 $deflat = "42.01053";
   $deflong ="21.432152";
   break;
     default:
    case getlokalPartner::GETLOKAL_BG:
    $deflat = "42.6970718";
     $deflong ="23.320999";
	break;
	endswitch;
	?>
$(document).ready(function() {
	var is_dragged = false, is_entered = false;

	if($('#company_company_location_street').val()!='') is_entered = true;
	
	  var map_center = new google.maps.LatLng(
			  <?php echo ($company->getLocation()->getLatitude() ? $company->getLocation()->getLatitude():$deflat) ?>,
			  <?php echo ($company->getLocation()->getLongitude() ? $company->getLocation()->getLongitude():$deflong) ?>
			 );

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
                 icon: new google.maps.MarkerImage('/images/gui/icons/pin.svg', null, null, null, new google.maps.Size(40,40)),
	        title: "<?php echo preg_replace("/[^a-zA-Z0-9]+/", " ", html_entity_decode($company->getCompanyTitle(), ENT_QUOTES)); ?>"
	    });
// marker
	  google.maps.event.addListener(marker, 'dragend', dropMarker);

	  function dropMarker()
	  {
		is_dragged = true;
	    //console.log(marker.getPosition());
	    var caa = '';
	    var listarray = {
	    		'булевард' : 1,
		        'улица' : 6,
		        'площад' : 5,
		        'шосе': 17,
		        'жк' : 2,
		        'кв.' : 3,
		        'bulevard' : 1,
		        'ulitsa' : 6,
		        'ploshtad' : 5,
		        'zhk': 2,
		        'kv.': 3
	    };

	    geocoder.geocode( { 'latLng': marker.getPosition()}, function(results, status) {
	      if (status == google.maps.GeocoderStatus.OK) {
	        //console.log(is_entered);
	        if(!is_entered){
	           $(results[0].address_components).each(function(i,s) {
		          if(s.types[0] == 'street_number') {
		            $('#company_company_location_street_number').val(s.long_name);
		          }else if(s.types[0] == 'route') {
		        	  var str = s.long_name;
		              firstword =  str.split(" ",1);
		              caa = firstword[0];
		              rest = str.replace(caa, '');
	
		              if (listarray[caa] != undefined){
		                if (listarray[caa] != 2 && listarray[caa] != 5){
				            $('#company_company_location_street_type_id').val(listarray[caa]);
				            $('#company_company_location_street').val(rest);
				            $('#company_company_location_sublocation').val(s.long_name);
		              	} else {
			            	$('#company_company_location_location_type').val(listarray[caa]);
			                $('#company_company_location_neighbourhood').val(rest);
			                $('#company_company_location_sublocation').val(s.long_name);
		              	}
		              } else {
		            	  $('#company_company_location_street').val(s.long_name);
		              }
	
		          } else if(s.types[0] == 'sublocality') {
		            $('#company_company_location_neighbourhood').val(s.long_name);
		          } else if(s.types[0] == 'postal_code') {
		              $('#company_company_location_postcode').val(s.long_name);
		          }
	           })
	        }
	        $('#company_company_location_latitude').val(marker.getPosition().lat());
	        $('#company_company_location_longitude').val(marker.getPosition().lng());

	        } else {
	        alert("Geocode was not successful for the following reason: " + status);
	      }
	    });

	  }





	  $('#company_city').autocomplete({
	      source: "<?php echo url_for('company/autocompleteCity') ?>",
	      minLength: 2,
	      position: {of: $('#company_city').parent()},
	      select: function( event, ui ) {
	        $('#company_city_id').val(ui.item.id);
	        geocoder.geocode( { 'address': ui.item.value }, function(results, status) {
	          if (status != google.maps.GeocoderStatus.OK) return;
	          
	          map.setCenter(results[0].geometry.location);
	          marker.setPosition(results[0].geometry.location);

	          $('#company_company_location_latitude').val(marker.getPosition().lat());
	          $('#company_company_location_longitude').val(marker.getPosition().lng());
	        });
	      }
	  });

/*	  
	  $('#autocomplete_company_city_id').result(function (event, data, formatted) {
	      city = data[0];
	      //console.log($('#company_city_id').val());

	      geocoder.geocode( { 'address':  city}, function(results, status) {
	        if (status == google.maps.GeocoderStatus.OK) {
	          console.log(results[0].geometry.location);

	          map.setCenter(results[0].geometry.location);

	          marker.setPosition(results[0].geometry.location);
	          $('#company_company_location_latitude').val(marker.getPosition().lat());
	          $('#company_company_location_longitude').val(marker.getPosition().lng());

		        } else {
	          alert("Geocode was not successful for the following reason: " + status);
	        }
	      });
	});
*/
// address
	  $('#company_company_location_street, #company_company_location_street_number').change(function() {
		is_entered = true;
		if(is_dragged) return;
	    //console.log($('#company_company_location_street').val());

	    geocoder.geocode( { 'address': $('#company_company_location_street').val() + ", "+ $('#company_city').val()}, function(results, status) {
	      if (status == google.maps.GeocoderStatus.OK) {
	        console.log(results[0].geometry.location);

	        map.setCenter(results[0].geometry.location);

	        marker.setPosition(results[0].geometry.location);
	        $('#company_company_location_latitude').val(marker.getPosition().lat());
	        $('#company_company_location_longitude').val(marker.getPosition().lng());
	      } else {
	        alert("Geocode was not successful for the following reason: " + status);
	      }
	    });
	  });

	  $('#company_company_location_neighbourhood').change(function() {
		  	is_entered = true;
		    console.log($('#company_company_location_neighbourhood').val());

		    geocoder.geocode( { 'address': $('#company_company_location_neighbourhood').val() +", " +$('#company_company_location_street').val() + ", "+ city}, function(results, status) {
		      if (status == google.maps.GeocoderStatus.OK) {
		        console.log(results[0].geometry.location);

		        map.setCenter(results[0].geometry.location);

		        marker.setPosition(results[0].geometry.location);
		        $('#company_company_location_latitude').val(marker.getPosition().lat());
		        $('#company_company_location_longitude').val(marker.getPosition().lng());
		      } else {
		        alert("Geocode was not successful for the following reason: " + status);
		      }
		    });
		  });

		$(".banner").css("display", "none");
		$('.path_wrap').remove();
	});

</script>