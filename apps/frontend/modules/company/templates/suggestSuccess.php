<?php slot('no_map', true) ?>
<?php slot('no_ads', true) ?>
<?php use_helper('jQuery') ?>
<?php use_stylesheet('add.place.css'); ?>

<?php $lng= mb_convert_case(getlokalPartner::getLanguageClass(), MB_CASE_LOWER,'UTF-8');   ?>

<?php $languages = sfConfig::get('app_languages_'.$lng)?>

<div class="review-changes-form">
	    <div class="form-wrap">
	        <div class="companyHeader">
	        	<h1 class="border"><?php echo __('Suggest an Edit', null,'company')?></h2>
	        </div>
	
	        <form id="addCompanyForm" class="right" action="<?php echo url_for('@company_suggest?city='.$sf_request->getParameter('city').'&slug='.$sf_request->getParameter('slug')) ?>" method="post">

	            <?php if ($localLang): ?>
	                <div class="capitalize no-padding-top <?php echo $form[$userCulture]['title']->hasError()? 'error': ''?>">
	                    <?php echo $form[$userCulture]['title']->renderLabel(); ?>            
			                <div class="form_box <?php echo $form[$userCulture]['title']->hasError() ? 'error' : '' ?>">
			                    <?php echo $form[$userCulture]['title']->render(array('value' => $companyTitle)); ?>
			                    <?php echo $form[$userCulture]['title']->renderError() ?>
			                </div>
                    <?php else: ?>
                        <div class="capitalize no-padding-top <?php echo $form[$userCulture]['title']->hasError()? 'error': ''?>">
                                    <?php echo $form['en']['title']->renderLabel(); ?>            
                                    <div class="form_box <?php echo $form['en']['title']->hasError() ? 'error' : '' ?>">
                                        <?php echo $form['en']['title']->render(array('value' => $companyTitle)); ?>
                                        <?php echo $form['en']['title']->renderError() ?>
                                    </div>    
	                </div>
                    <?php endif; ?>

	            <section id="classifications" class="capitalize">
	                <div class="add_field <?php echo $form['classification_id']->hasError() ? 'error' : '' ?>">
	                    <?php echo $form['classification']->renderLabel() ?>
	                    <div class="form_box tooltip-input left-float">
	                        <?php echo $form['classification']->render(array('value' => $companyClassification)) ?>
	                        <a id="classification" class="tool-tip" data-tip="<?php echo __('Start typing the place type e.g. ‘restaurant’ or ‘hairdressers’ and select the most appropriate category for the place you’re adding', null, 'company') ?>"></a>
	                    </div> 
	                    
	                    <?php echo $form['sector_id']->render() ?>
	                    <?php echo $form['classification_id']->render() ?>
	                    <?php echo $form['classification_id']->renderError() ?>
	
	                    <div class="clear"></div>
	
	                    <section class="added_items" id="list_of_classifications" <?php echo!isset($classification_list_id) ? ('style="display:none"') : '' ?>>
	                        <?php if (isset($classification_list_id)) : ?>
	                            <?php foreach ($classification_list_id as $key => $cll): ?>
	                                <div class="added_item">
	                                    <p><?php echo $classification_list_title[$key]; ?></p>
	                                    <a>×</a>
	                                    <input type="hidden" name="company[classification_list_title][]" id="classification_list_title_<?php echo $cll; ?>" value="<?php echo $classification_list_title[$key]; ?>">
	                                    <input type="hidden" name="company[classification_list_id][]" id="classification_list_id_<?php echo $cll; ?>" value="<?php echo $cll; ?>">
	                                    <input type="hidden" name="company[sector_list_id][]" id="sector_list_id_<?php echo $sector_list_id[$key]; ?>" value="<?php echo $sector_list_id[$key]; ?>">
	                                </div>
	                            <?php endforeach; ?>
	                        <?php endif; ?>
	                    </section>
	                </div> 
	            </section>  
	
	            <section id="full-width" class="no-border no-padding-top">    
	                <div class="three-inputs no-border">
	                    <div class="form_box small <?php echo $form['company_location']['street_type_id']->hasError() ? 'error' : '' ?>">
	                        <?php echo $form['company_location']['street_type_id']->render(); ?>
	                        <?php echo $form['company_location']['street_type_id']->renderError(); ?>
	                    </div>
	
	                    <div class="form_box tooltip-input middle  <?php echo $form['company_location']['street']->hasError() ? 'error' : '' ?>">
							<?php echo $form['company_location']['street']->render() ?>
	                        <a class="tool-tip" data-tip="<?php echo __('If you type in the address – street name and number - the position of the market showing where the place is will change. If the positioning doesn’t seem correct you can move the marker. This will not change the address you’ve already written.', null, 'company'); ?>"></a>
	
	                        <?php echo $form['company_location']['street']->renderError(); ?>
	                    </div>
	
	                    <div class="form_box small no-margin <?php echo $form['company_location']['street_number']->hasError() ? 'error' : '' ?>">
	                        <?php echo $form['company_location']['street_number']->render(array('placeholder' => __('Number', null, 'form'))); ?>
	                        <?php echo $form['company_location']['street_number']->renderError() ?>
	                    </div>
	                </div>
	
	                <div class="location-hint">
		                <p class="fade"><?php echo __('<span class="regular">Start typing the </span><span class="highlight">place address</span> <span class="regular"> and a marker will be placed on the map.</span>', null, 'company'); ?></p>
		            </div>
	            </section>    
								
	
	            <section class="map-container no-padding-top">
                	<div id="map_canvas"></div>
            	</section>
	
				<div class="form_wrap three_fields phones" style="display: inline-block;">
	                <div class="form_box <?php echo $form['phone']->hasError()? 'error': ''?>">
	                    <?php echo $form['phone']->renderLabel() ?>
                            <?php 
                            if ($company->getPhone()) {
                                echo $form['phone']->render(array('value' => $companyPhone)); 
                            }
                            else {
                                echo $form['phone']->render();
                            }
                            ?>
	                    <?php echo $form['phone']->renderError() ?>
	                 <!--   
	                    <a class="tip">
	                        <span class="details"><?php echo __('The correct format to use is 023456789 or for mobile phones 0888888888. Add only the local area code for landlines. Only add digits – any other characters or spaces between characters are not allowed.', null, 'company') ?></span>
	                    </a> 
	                 -->
	                </div>
	            </div> 
	
				<div class="checkbox-container">

					<h3><?php echo __('Report a Problem',null,'form');?></h3>

					<div class="align-left">
						<div class="form-row">
							<div class="form-controls">
								<input type="checkbox" id="closed" name="closed" value="true">
							</div>
							<label for="closed"><?php echo __('Is closed or out of business',null,'form');?></label>
						</div>

						<div class="form-row">
							<div class="form-controls">
								<input type="checkbox" id="dublicate" name="duplicate" value="true">
							</div>
							<label for="dublicate"><?php echo __('Is a duplicate',null,'form');?></label>
						</div>
					</div>

					<div class="align-right">
						<div class="form-row">
							<div class="form-controls">
								<input type="checkbox" id="moved" name="moved" value="true">
							</div>

							<label for="moved"><?php echo __('Has moved',null,'form');?></label>

						</div>

						<div class="form-row">
							<div class="form-controls">
								<input type="checkbox" id="phone_number" name="phone_number" value="true">
							</div>
							<label for="phone_number"><?php echo __('Wrong phone number',null,'form');?></label>
						</div>
					</div>
				</div><!-- checkbox-container -->
	
	            <section class="mandatory_notice no-border submit">	                
	                <input type="submit" value="<?php echo __('Send') ?>" class="button_green" id="btn-no-scroll" />
	            </section>
	            <?php echo $form->renderHiddenFields();?>
	        </form>
	        <div class="clear"></div>
	    </div>
	</div>
</div>

<p hidden id="class-url"><?php echo url_for('company/autocompleteClassification') ?></p>

<?php $lang = getlokalPartner::getDefaultCulture ( $company->getCountryId () );
$country  = $company->getCountryId();?>
		

<script type="text/javascript">
/*Classification autocomplete*/
    $('#company_classification').autocomplete({
        source: $('#class-url').text(),
        minLength: 2,
        position: {
            of: $('#company_classification').parent()
        },
        select: function( event, ui ) {
            $('#company_classification_id').val(''+ui.item.id);
            $('#company_sector_id').val(''+ui.item.sector_id);
        },
        open: function (event, ui) {
            var menu = $(this).data("uiAutocomplete").menu
            , i = 0
            , $items = $('li', menu.element)
            , item
            , text
            , startsWith = new RegExp("^" + this.value, "i");
            for (; i < $items.length && !item; i++) {
                text = $items.eq(i).text();
                if (startsWith.test(text)) {
                    item = $items.eq(i);
                }
            }
            
            if (item) {
                menu.focus(null, item);
            }
        }
    }).autocomplete( "widget" ).addClass( "classification-autocomplete" );

<?php 
switch ($country):
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

	if($('#company_company_location_street').val()!='<?php echo $company->getLocation()->getStreet(); ?>') is_entered = true;
	
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

















