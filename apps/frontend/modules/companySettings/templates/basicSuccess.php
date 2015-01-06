<?php //use_helper('jQuery') ?>
<?php include_partial('global/commonSlider'); 
$params = array('company' => $company, 'adminuser' => $adminuser, 'companies' => $companies, 'is_getlokal_admin' => $is_getlokal_admin);

$lng= mb_convert_case(getlokalPartner::getLanguageClass(), MB_CASE_LOWER,'UTF-8');

$languages = sfConfig::get('app_languages_'.$lng);
?>
<div class="container set-over-slider">
		<div class="row">	
			<div class="container">
				<div class="row">
					<?php include_partial('topMenu', $params); ?>	
				</div>
			</div>	          
	
			
		<div class="col-sm-3">
           <div class="section-categories">
                <!-- div class="categories-title">
                    
	            </div><! categories-title -->
                <?php include_partial('rightMenu', $params); ?>	            
	       </div>
		</div>
		 <div class="col-sm-9">
            <div class="content-default">
			        
			        
                <form action="<?php echo url_for('companySettings/basic?slug='. $company->getSlug()) ?>" method="post" class="default-form clearfix">
                	<?php echo $form['_csrf_token']->render() ?>
			    	<div class="row">
						<div class="default-container default-form-wrapper col-sm-12 p-15">
							<div class="col-sm-12">
								<?php include_partial('tabsMenu', $params); ?>	   
							</div>
							<?php if ($sf_user->getFlash('error')) { ?>
					            <div class="form-message error pull-left">
					                <p><?php echo __($sf_user->getFlash('error')); ?></p>
					            </div>
					        <?php } ?>
					        <?php if ($sf_user->getFlash('notice')): ?> 
					            <div class="form-message success">
					                <p><?php echo __($sf_user->getFlash('notice')) ?></p>
					            </div> 
					        <?php endif; ?>
							<h2 class="form-title"><?php echo __('Place Information', null,'company')?></h2>
							<!-- Form Start -->
							
							<div class="row">
								<div class="col-sm-12">
									<div class="default-input-wrapper required <?php echo $form[$lng]['title']->hasError() ? 'incorrect': ''?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										
										<?php echo $form[$lng]['title']->renderLabel(null, array('for' => $form[$lng]['title']->getName(), 'class' => 'default-label')) ?>
										<?php echo $form[$lng]['title']->render(array('class' => 'default-input' )); ?>							
										<div class="error-txt"><?php echo $form[$lng]['title']->renderError() ?></div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-6">
									<div class="default-input-wrapper <?php echo $form['en']['title']->hasError() ? 'incorrect': ''?>">
										<label for="<?= $form['en']['title']->getName(); ?>" class="default-label"><?= __('Place Name in English', null, 'company'); ?></label>									
										<?php echo $form['en']['title']->render(array('class' => 'default-input' )); ?>							
										<div class="error-txt"><?php echo $form['en']['title']->renderError() ?></div>
									</div>
								</div>
								
								<?php 
									if(count($languages) > 2) {
                             			foreach ($languages as $language) {
                                 			if($language != 'en' && $language != $lng) {
								?>
									<div class="col-sm-6">
	                                    <div class="default-input-wrapper <?php echo $form[$language]['title']->hasError() ? 'incorrect': ''?>">
	                                        <label for="<?= $form[$language]['title']->getName()?>" class="default-label"><?php echo __('Place Name in '.sfConfig::get('app_cultures_en_'.$language), null, 'company'); ?></label>
	                                        <?php echo $form[$language]['title']->render(array('class' => 'default-input' )); ?>
	                                        <div class="error-txt"><?php echo $form[$language]['title']->renderError() ?></div>
	                                    </div>
	                                </div>
                                <?php
											}
                            			}
                        			}
                        		?>
                        		
                        		<div class="col-sm-6">
									<div class="default-input-wrapper required <?php echo $form['city_id']->hasError() ? 'incorrect': ''?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $form['city_id']->renderLabel(null, array('for' => $form['city_id']->getName(), 'class' => 'default-label')) ?>									
										<?php echo $form['city']->render(array('class' => 'default-input' )); ?>
										<?php //echo $form['city_id']->render(); ?>							
										<div class="error-txt"><?php echo $form['city_id']->renderError() ?></div>
									</div>
								</div>
								<div class="clear"></div>
								
							</div>
							
							<div class="row">
								<div class="col-sm-2">
									<div class="default-input-wrapper <?php echo $form['company_location']['street_type_id']->hasError() ? 'incorrect': ''?>">										
										<?php echo $form['company_location']['street_type_id']->render(array('class' => 'default-input' )); ?>							
										<div class="error-txt"><?php echo $form['company_location']['street_type_id']->renderError() ?></div>
									</div>
								</div>
								
								<div class="col-sm-8">
									<div class="default-input-wrapper <?php echo $form['company_location']['street']->hasError() ? 'incorrect': ''?>">
										<?php echo $form['company_location']['street_type_id']->renderLabel(null, array('for' => $form['company_location']['street_type_id']->getName(), 'class' => 'default-label')) ?>
										<?php echo $form['company_location']['street']->render(array('class' => 'default-input' )); ?>							
										<div class="error-txt"><?php echo $form['company_location']['street']->renderError() ?></div>
									</div>
								</div>
								
								<div class="col-sm-2">
									<div class="default-input-wrapper <?php echo $form['company_location']['street_number']->hasError() ? 'incorrect': ''?>">
										<?php echo $form['company_location']['street_number']->renderLabel(null, array('for' => $form['company_location']['street_number']->getName(), 'class' => 'default-label')) ?>
										<?php echo $form['company_location']['street_number']->render(array('class' => 'default-input' )); ?>							
										<div class="error-txt"><?php echo $form['company_location']['street_number']->renderError() ?></div>
									</div>
								</div>
								<div class="clear"></div>			
							</div>
							
							<div class="row">
								<div class="col-sm-2">
								<?php if(isset($form['company_location']['location_type'])) { ?>
									<div class="default-input-wrapper <?php echo $form['company_location']['location_type']->hasError() ? 'incorrect': ''?>">										
										<?php echo $form['company_location']['location_type']->render(array('class' => 'default-input' )); ?>							
										<div class="error-txt"><?php echo $form['company_location']['location_type']->renderError() ?></div>
									</div>
								<?php } ?>
								</div>
								
								<div class="col-sm-8">
									<div class="default-input-wrapper <?php echo $form['company_location']['neighbourhood']->hasError() ? 'incorrect': ''?>">
										<?php echo $form['company_location']['neighbourhood']->renderLabel(null, array('for' => $form['company_location']['neighbourhood']->getName(), 'class' => 'default-label')) ?>
										<?php echo $form['company_location']['neighbourhood']->render(array('class' => 'default-input' )); ?>							
										<div class="error-txt"><?php echo $form['company_location']['neighbourhood']->renderError() ?></div>
									</div>
								</div>
								
								<div class="col-sm-2">
									<div class="default-input-wrapper <?php echo $form['company_location']['building_no']->hasError() ? 'incorrect': ''?>">
										<?php echo $form['company_location']['building_no']->renderLabel(null, array('for' => $form['company_location']['building_no']->getName(), 'class' => 'default-label')) ?>
										<?php echo $form['company_location']['building_no']->render(array('class' => 'default-input' )); ?>							
										<div class="error-txt"><?php echo $form['company_location']['building_no']->renderError() ?></div>
									</div>
								</div>
							</div>	
							
							<div class="row">
								<div class="col-sm-12">
									<div class="default-input-wrapper <?php echo $form['company_location']['address_info']->hasError() ? 'incorrect': ''?>">
										<?php echo $form['company_location']['address_info']->renderLabel(null, array('for' => $form['company_location']['address_info']->getName(), 'class' => 'default-label')) ?>
										<?php echo $form['company_location']['address_info']->render(array('class' => 'default-input' )); ?>							
										<div class="error-txt"><?php echo $form['company_location']['address_info']->renderError() ?></div>
									</div>
								</div>
								<div class="clear"></div>			
							</div>
							
							<div class="row">
			                    <div class="col-sm-12">
			                                <section class="map-container no-padding-top">
			                                    <div id="map_canvas"></div>			                                    
			                                </section>
			                    </div>
			                </div>
			                
			                <div class="row">
			                	<?php if (isset($form['company_yp'])) { ?>
			                	<div class="col-sm-6">
									<div class="default-input-wrapper <?php echo $form['company_yp']['sr_url']->hasError() ? 'incorrect': ''?>">
										<?php echo $form['company_yp']['sr_url']->renderLabel(null, array('for' => $form['company_yp']['sr_url']->getName(), 'class' => 'default-label')) ?>
										<?php echo $form['company_yp']['sr_url']->render(array('class' => 'default-input' )); ?>							
										<div class="error-txt"><?php echo $form['company_yp']['sr_url']->renderError() ?></div>
									</div>
								</div>
								<?php } ?>
								
								<div class="col-sm-6">
									<div class="default-input-wrapper <?php echo $form['website_url']->hasError() ? 'incorrect': ''?>">
										<?php echo $form['website_url']->renderLabel(null, array('for' => $form['website_url']->getName(), 'class' => 'default-label')) ?>
										<?php echo $form['website_url']->render(array('class' => 'default-input' )); ?>							
										<div class="error-txt"><?php echo $form['website_url']->renderError() ?></div>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="default-input-wrapper <?php echo $form['email']->hasError() ? 'incorrect': ''?>">
										<?php echo $form['email']->renderLabel(null, array('for' => $form['email']->getName(), 'class' => 'default-label')) ?>
										<?php echo $form['email']->render(array('class' => 'default-input' )); ?>							
										<div class="error-txt"><?php echo $form['email']->renderError() ?></div>
									</div>
								</div>
								<div class="clear"></div>
			                </div>
			                
			                <div class="row">
			                	<div class="col-sm-4">
									<div class="default-input-wrapper <?php echo $form['phone']->hasError() ? 'incorrect': ''?>">
										<?php echo $form['phone']->renderLabel(null, array('for' => $form['phone']->getName(), 'class' => 'default-label')) ?>
										<?php echo $form['phone']->render(array('class' => 'default-input' )); ?>
										<!-- <a class="tip">
																					                        	<span class="details"><?php echo __('The correct format to use is 023456789 or for mobile phones 0888888888. Add only the local area code for landlines. Only add digits – any other characters or spaces between characters are not allowed.', null, 'company') ?></span>
																					                    	</a> -->							
										<div class="error-txt"><?php echo $form['phone']->renderError() ?></div>
									</div>
								</div>
								
								<div class="col-sm-4">
									<div class="default-input-wrapper <?php echo $form['phone1']->hasError() ? 'incorrect': ''?>">
										<?php echo $form['phone1']->renderLabel(null, array('for' => $form['phone1']->getName(), 'class' => 'default-label')) ?>
										<?php echo $form['phone1']->render(array('class' => 'default-input' )); ?>
										<!-- <a class="tip">
															                        <span class="details"><?php echo __('The correct format to use is 023456789 or for mobile phones 0888888888. Add only the local area code for landlines. Only add digits – any other characters or spaces between characters are not allowed.', null, 'company') ?></span>
															                    </a> -->
										<div class="error-txt"><?php echo $form['phone1']->renderError() ?></div>
									</div>
								</div>
								
								<div class="col-sm-4">
									<div class="default-input-wrapper <?php echo $form['phone2']->hasError() ? 'incorrect': ''?>">
										<?php echo $form['phone2']->renderLabel(null, array('for' => $form['phone2']->getName(), 'class' => 'default-label')) ?>
										<?php echo $form['phone2']->render(array('class' => 'default-input' )); ?>
										<!-- <a class="tip">
																						                        <span class="details"><?php echo __('The correct format to use is 023456789 or for mobile phones 0888888888. Add only the local area code for landlines. Only add digits – any other characters or spaces between characters are not allowed.', null, 'company') ?></span>
																						                    </a> -->							
										<div class="error-txt"><?php echo $form['phone2']->renderError() ?></div>
									</div>
								</div>
								<div class="clear"></div>
			                </div>
			                
			                <div class="row">
			                	<?php if (isset($form['registration_no'])) { ?>
			                	<div class="col-sm-6">
									<div class="default-input-wrapper <?php echo $form['registration_no']->hasError() ? 'incorrect': ''?>">
										<?php echo $form['registration_no']->renderLabel(null, array('for' => $form['registration_no']->getName(), 'class' => 'default-label')) ?>
										<?php echo $form['registration_no']->render(array('class' => 'default-input' )); ?>							
										<div class="error-txt"><?php echo $form['registration_no']->renderError() ?></div>
									</div>
								</div>
								<?php } ?>
								
								<div class="col-sm-6">
									<div class="default-input-wrapper <?php echo $form['company_location']['postcode']->hasError() ? 'incorrect': ''?>">
										<?php echo $form['company_location']['postcode']->renderLabel(null, array('for' => $form['company_location']['postcode']->getName(), 'class' => 'default-label')) ?>
										<?php echo $form['company_location']['postcode']->render(array('class' => 'default-input' )); ?>							
										<div class="error-txt"><?php echo $form['company_location']['postcode']->renderError() ?></div>
									</div>
								</div>
			                </div>
			                		                
			                <div class="row">
			                	<div class="col-sm-8">
			                		<div class="default-input-wrapper <?php echo $form['facebook_url']->hasError() ? 'incorrect': ''?>">
										<?php echo $form['facebook_url']->renderLabel(null, array('for' => $form['facebook_url']->getName(), 'class' => 'default-label')) ?>
										<?php echo $form['facebook_url']->render(array('class' => 'default-input' )); ?>							
										<div class="error-txt"><?php echo $form['facebook_url']->renderError() ?></div>
									</div>
			                	</div>
			                	<div class="clear"></div>
			                	
			                	<div class="col-sm-8">
			                		<div class="default-input-wrapper <?php echo $form['twitter_url']->hasError() ? 'incorrect': ''?>">
										<?php echo $form['twitter_url']->renderLabel(null, array('for' => $form['twitter_url']->getName(), 'class' => 'default-label')) ?>
										<?php echo $form['twitter_url']->render(array('class' => 'default-input' )); ?>							
										<div class="error-txt"><?php echo $form['twitter_url']->renderError() ?></div>
									</div>
			                	</div>
			                	<div class="clear"></div>
			                	
			                	<div class="col-sm-8">
			                		<div class="default-input-wrapper <?php echo $form['googleplus_url']->hasError() ? 'incorrect': ''?>">
										<?php echo $form['googleplus_url']->renderLabel(null, array('for' => $form['googleplus_url']->getName(), 'class' => 'default-label')) ?>
										<?php echo $form['googleplus_url']->render(array('class' => 'default-input' )); ?>							
										<div class="error-txt"><?php echo $form['googleplus_url']->renderError() ?></div>
									</div>
			                	</div>
			                	<div class="clear"></div>
			                	
			                	<div class="col-sm-8">
			                		<div class="default-input-wrapper <?php echo $form['foursquare_url']->hasError() ? 'incorrect': ''?>">
										<?php echo $form['foursquare_url']->renderLabel(null, array('for' => $form['foursquare_url']->getName(), 'class' => 'default-label')) ?>
										<?php echo $form['foursquare_url']->render(array('class' => 'default-input' )); ?>							
										<div class="error-txt"><?php echo $form['foursquare_url']->renderError() ?></div>
									</div>
			                	</div>
			                	<div class="clear"></div>
			                </div>
			                
							<div class="row">
								<div class="col-sm-12">
									<div class="default-input-wrapper">
										<input type="submit" value="<?php echo __('Save')?>" class="default-btn success" />
									</div>
								</div>
							</div>
							
							<!-- Form End -->
						</div>
					</div>
					
					<?php echo $form->renderHiddenFields();?>
				</form>
            </div>
        </div>
   	</div>	
</div>

<?php $lang = getlokalPartner::getDefaultCulture ( $company->getCountryId () );
$country  = $company->getCountryId();?>
		

<script type="text/javascript">

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

	var is_dragged = false, is_entered = false;

	//if($('#company_company_location_street').val()!='') is_entered = true;
	
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
		var str_num = false;
      	var str_route = false;
      	var str_str = false;
      	var str_hood = false;
		is_dragged = true;
	    
	    var caa = '';
	    var listarray = {
	    		'булевард' : 1,
		        'улица' : 6,
		        'площад' : 5,
		        'шосе': 17,
		        'жк' : 2,
		        'кв.' : 3,
		        'бул.' : 1,
		        'ул.': 6,
		        'ж.к.' : 2,
		        'bulevard' : 1,
		        'ulitsa' : 6,
		        'ploshtad' : 5,
		        'zhk': 2,
		        'kv.': 3
	    };

	    geocoder.geocode( { 'latLng': marker.getPosition()}, function(results, status) {		    
	      if (status == google.maps.GeocoderStatus.OK) {
	        if(!is_entered){
	        
	         $(results).each(function(j,r) {
	           $(r.address_components).each(function(i,s) {
		           
		          if(s.types[0] == 'street_number' && !str_num) {
			          str_num = true;
		            $('#company_company_location_street_number').val(s.long_name);
		          }else if(s.types[0] == 'route' && !str_route) {
		        	  str_route = true;
		        	  var str = s.long_name;
		              firstword =  str.split(" ",1);
		              caa = firstword[0];
		              rest = str.replace(caa, '');

		              if (listarray[caa] != undefined){
		                if (listarray[caa] != 2 && listarray[caa] != 5 && listarray[caa] != 7 && listarray[caa] != 9 && !str_str) {
		                	str_str = true;
				            $('#company_company_location_street_type_id').val(listarray[caa]);
				            $('#company_company_location_street').val(rest);
				            $('#company_company_location_sublocation').val(s.long_name);
		              	} else if (!str_hood) {
		              		str_hood = true;
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
		          } else if(s.types[0] == 'neighborhood' && !str_hood) {
		        	  str_hood = true;
		        	  var str = s.long_name;
		              firstword =  str.split(" ",1);
		              caa = firstword[0];
		              rest = str.replace(caa, '');
		              if (listarray[caa] != undefined){
		            	  $('#company_company_location_location_type').val(listarray[caa]);
			              $('#company_company_location_neighbourhood').val(rest);
			              $('#company_company_location_sublocation').val(s.long_name);
		              }
		              else {
			              $('#company_company_location_neighbourhood').val(s.long_name);
		              }
		          }
	           });
	          });
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
	        cityVal = ui.item.value;
	        $('#company_city').attr('value',cityVal.split(',')[0]);
	        
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

	    if ($('#company_company_location_street').val() != '')
		{
			var adrress = $('#company_company_location_street').val() + " " + $('#company_company_location_street_number').val() + ", "+ $('#company_city').attr('value');
		}
	    else
	    {
	    	var adrress = $('#company_company_location_street').val() + ", "+ $('#company_city').attr('value');
	    }
	    geocoder.geocode( { 'address': adrress}, function(results, status) {
	      if (status == google.maps.GeocoderStatus.OK) {
	        //console.log(results[0].geometry.location);

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
		    //console.log($('#company_company_location_neighbourhood').val());

		    geocoder.geocode( { 'address': $('#company_company_location_neighbourhood').val() +", " +$('#company_company_location_street').val() + ", "+ city}, function(results, status) {
		      if (status == google.maps.GeocoderStatus.OK) {
		        //console.log(results[0].geometry.location);

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


</script>