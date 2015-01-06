
<?php /* ?>
<?php echo __('Start typing the place name', null, 'company'); ?>
<?php echo __('You need to complete this field', null, 'company'); ?>
<?php echo __('Place Name in English', null, 'company'); ?>
<?php echo __('Any notes for getlokal editors that might speed up the approval process?', null, 'company'); ?>
<?php echo __('Are you (representing) the place owner?', null, 'company'); ?>
<?php */ ?>

<div class="addCompany">	
	<div class="left">
		<div class="image">
			<?php echo image_tag('promo/addPlace/relevance.gif') ?>
		</div>
		
		<div class="points">
			<div class="step1">
				<?php echo image_tag('promo/addPlace/clover.png') ?>
				<span class="smiley"></span>	
			</div>
			<div class="step2">
				<?php echo image_tag('promo/addPlace/clover.png') ?>
				<span class="smiley"></span>
			</div>
			<div class="step3">
				<?php echo image_tag('promo/addPlace/clover.png') ?>
				<span class="smiley"></span>
			</div>
		</div>
	</div>
	
	<form action="<?php echo url_for('company/addOrEditCompany');?>" method="post" class="right">  	
		<div class="companyHeader">
			<h1><?php echo __('Add a place', null, 'company'); ?></h1>
			<p><?php echo __('Add a new place and make getlokal better for you and other people in your area.', null, 'company')?></p>
		</div>
		
		<div class="part one">
			<p><?php echo __('Let\'s see if we have the place you want to add! If we don\'t then you can add it and then write a review, add a photo or share it with your friends!', null, 'company'); ?></p>
		
			<?php echo $form['_csrf_token']->render() ?>
		 
			<div class="input_box tip <?php echo $form['title']->hasError()? 'error': ''?>">
				<?php echo $form['title']->renderLabel() ?>
					
				<?php echo $form['title']->render(array('style' => 'width: 385px')); ?>
				<?php echo $form['title']->renderError() ?>
				
				<a class="tip">
					<span class="details">More info</span>
				</a>
			</div>
			
			<div class="input_box tip <?php echo $form['city_id']->hasError()? 'error': ''?>">
				<?php echo $form['city']->renderLabel() ?>
					
        <?php echo $form['city']->render(array('style' => 'width: 160px')); ?>
				<?php echo $form['city_id']->render(); ?>
				<?php echo $form['city_id']->renderError() ?>
				
				<a class="tip">
					<span class="details">More info</span>
				</a>
			</div>
			<div class="clear"></div>
      
			<label class="input_box <?php echo $form['company_location']['street_type_id']->hasError()? 'error': ''?>">          
				<?php echo $form['company_location']['street_type_id']->render(); ?>
				<?php echo $form['company_location']['street_type_id']->renderError() ?>
			</label>
			
			<div class="input_box <?php echo $form['company_location']['street']->hasError()? 'error': ''?>">
				<?php echo $form['company_location']['street']->renderLabel() ?>      
					
				<?php echo $form['company_location']['street']->render(array('style' => 'width: 400px')); ?>
				<?php echo $form['company_location']['street']->renderError() ?>
				
				<a class="tip">
					<span class="details">More info</span>
				</a>
			</div>
			
			<div class="input_box tip <?php echo $form['company_location']['street_number']->hasError()? 'error': ''?>">
				<?php echo $form['company_location']['street_number']->renderLabel() ?>      
				<?php echo $form['company_location']['street_number']->render(array('style' => 'width: 50px')); ?>
				<?php echo $form['company_location']['street_number']->renderError() ?>
				
				<a class="tip">
					<span class="details">More info</span>
				</a>
			</div>
			<div class="clear"></div>
			
			<div id="map_canvas"></div>  
			
			<div class="input_box tip <?php echo $form['classification_id']->hasError()? 'error': ''?>">
        <?php echo $form['classification']->renderLabel() ?>
        <?php echo $form['classification']->render(array('style' => 'width:300px')) ?>
        
				<?php echo $form['sector_id']->render() ?>
        
        <?php echo $form['classification_id']->render() ?>
        
				<?php echo $form['classification_id']->renderError() ?>
				
				<a class="tip">
					<span class="details">More info</span>
				</a>
			</div>
			
			<div class="clear"></div>
		</div>
		
		<div class="separator"></div>
		
		<div class="part two">
			<p><?php echo __('Congrats on adding the place! Do you know any more details about it?', null, 'company'); ?></p>
			
			<?php /* <div class="input_box extra tip <?php echo $form['company_location']['full_address']->hasError()? 'error': ''?>">
				<?php echo $form['company_location']['full_address']->renderLabel() ?>
	 
				<?php echo $form['company_location']['full_address']->render(); ?>
				<?php echo $form['company_location']['full_address']->renderError() ?>
        
        <a class="tip">
          <span class="details">More info</span>
        </a>
			</div>*/ ?>
			<div class="input_box tip <?php echo $form['title_en']->hasError()? 'error': ''?>">
				<?php echo $form['title_en']->renderLabel() ?>
					
				<?php echo $form['title_en']->render(); ?>
				<?php echo $form['title_en']->renderError() ?>
        
        <a class="tip">
          <span class="details">More info</span>
        </a>
			</div>
			
			 <div class="input_box tip more <?php echo $form['phone']->hasError()? 'error': ''?>">
				<?php echo $form['phone']->renderLabel() ?>
	 
				<?php echo $form['phone']->render(); ?>
				<?php echo $form['phone']->renderError() ?>
				
				<span class="fill_details">Correct format: +359 999 999 999</span>
        <a class="tip">
          <span class="details">More info</span>
        </a>
			</div>
			
			<div class="input_box tip <?php echo $form['email']->hasError()? 'error': ''?>">
				<label for="company_email"><?php echo __('Place Email Address', null, 'company'); ?></label>
				<?php echo $form['email']->render(); ?>
				<?php echo $form['email']->renderError() ?>
        
        <a class="tip">
          <span class="details">More info</span>
        </a>
			</div>
			
			<div class="input_box tip more <?php echo $form['company_location']['address_info']->hasError()? 'error': ''?>">
				<label for="company_company_location_address_info"><?php echo __('Additional Address Details', null, 'company'); ?></label>
				<?php echo $form['company_location']['address_info']->render(); ?>
				<?php echo $form['company_location']['address_info']->renderError() ?>
				
				<span class="fill_details"><?php echo __('Building, floor, apt, zip', null, 'company'); ?></span>
        <a class="tip">
          <span class="details">More info</span>
        </a>
			</div>
			
			<div class="clear"></div>
	 </div>
	 
	 <div class="separator"></div>
	 
	 <div class="part three">
			<p><?php echo __('Let\'s link the place with its other online profiles!', null, 'company'); ?></p>		
			<div class="row">
				<div class="input_box tip <?php echo $form['website_url']->hasError()? 'error': ''?>">
					<label for="company_website_url"><?php echo __('Enter the exact place website URL!', null, 'company'); ?></label>
						
					<?php echo $form['website_url']->render(array('style' => 'width: 280px')) ?>
					<?php echo $form['website_url']->renderError() ?>
					
					<span class="icon"><?php echo image_tag('promo/addPlace/icoWeb.gif') ?></span>
				</div>
			</div>
			<a href="http://www.gooogle.com/" target="_blank" class="row"><?php echo sprintf(__('Search for Place Name on %s', null, 'company'), __('Google+', null, 'company')); ?></a>
			<div class="clear"></div>
				
			<div class="row">
				<div class="input_box tip <?php echo $form['facebook_url']->hasError()? 'error': ''?>">
					<?php echo $form['facebook_url']->renderLabel() ?>
						
					<?php echo $form['facebook_url']->render(array('style' => 'width: 100px')); ?>
					<?php echo $form['facebook_url']->renderError() ?>
					
					<span class="icon"><?php echo image_tag('promo/addPlace/icoFacebook.gif') ?></span>
				</div>
				<span class="text">http://facebook.com</span>
			</div>
			<a href="www.facebook.com/search.php" class="row" target="_blank"><?php echo sprintf(__('Search for Place Name on %s', null, 'company'), __('Facebook', null, 'company')); ?></a>
			<div class="clear"></div>
			
			<div class="row">
				<div class="input_box tip <?php echo $form['twitter_url']->hasError()? 'error': ''?>">
					<?php echo $form['twitter_url']->renderLabel() ?>
						
					<?php echo $form['twitter_url']->render(array('style' => 'width: 100px')); ?>
					<?php echo $form['twitter_url']->renderError() ?>
					
					<span class="icon"><?php echo image_tag('promo/addPlace/icoTwitter.gif') ?></span>
				</div>
			</div>
			<a href="#" class="row" target="_blank"><?php echo sprintf(__('Search for Place Name on %s', null, 'company'), __('Twitter', null, 'company')); ?></a>
			<div class="clear"></div>
			
			<div class="row">
				<div class="input_box tip <?php echo $form['foursquare_url']->hasError()? 'error': ''?>">
					<?php echo $form['foursquare_url']->renderLabel() ?>
						
					<?php echo $form['foursquare_url']->render(array('style' => 'width: 280px')) ?>
					<?php echo $form['foursquare_url']->renderError() ?>
					
					<span class="icon"><?php echo image_tag('promo/addPlace/icoFoursquare.gif') ?></span>
				</div>
			</div>
			<a href="#" class="row"><?php echo sprintf(__('Search for Place Name on %s', null, 'company'), __('Foursquare', null, 'company')); ?></a>
			<div class="clear"></div>
	 </div>
			
	 <div class="form_box">
			<input type="submit" value="<?php echo __('Send')?>" class="input_submit" />
		
	</div>
	
	
	</form>
	
	<div class="clear"></div>
</div>
		
			
<?php $company=$form->getObject();?>				

<script type="text/javascript">
$(document).ready(function() {
	$('.input_box input, .input_box textarea').each(function(i,s) {
		s = $(s);
		if(s.val()) {
			s.parent().find('label').hide();
		}
		s.focus(function() {
			$(this).parent().find('label').hide();
		}).blur(function() {
			if(!$(this).val()) $(this).parent().find('label').show();
		})
	});
	
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
  $('#company_classification').blur(function() {
    if(!$(this).val()) $('#company_classification_id').val(0);
  });
  $('#company_classification').autocomplete({
      source: "<?php echo url_for('company/autocompleteClassification') ?>",
      minLength: 2,
      position: {of: $('#company_classification').parent()},
      select: function( event, ui ) {
        $('#company_classification_id').val(''+ui.item.id);
        $('#company_sector_id').val(''+ui.item.sector_id);
      }
  });
  /*$('#company_title').autocomplete({
      source: "<?php echo url_for('company/autocomplete') ?>",
      minLength: 2,
      position: {of: $('#company_title').parent()},
      select: function( event, ui ) {
        $('#company_id').val(ui.item.id);
        
        map_center = new google.maps.LatLng(ui.item.lat, ui.item.lng);
        
        map.setCenter(map_center);
        marker.setPosition(map_center);

        $('#company_city').val(ui.item.city).parent().find('label').hide();
        $('#company_city_id').val(ui.item.city_id);
        $('#company_classification').val(ui.item.classification).parent().find('label').hide();
        $('#company_company_location_street').val(ui.item.street).parent().find('label').hide();
        $('#company_company_location_street_number').val(ui.item.street_no).parent().find('label').hide();
        $('#company_company_location_latitude').val(ui.item.lat);
        $('#company_company_location_longitude').val(ui.item.lng);
        $('#company_sector_id').val(ui.item.sector);
        $('#company_classification_id').val(ui.item.ciclassification_id);
      }
  }); */
  
  lat = $('#company_company_location_latitude').val()? $('#company_company_location_latitude').val(): '<?php echo $sf_user->getCity()->getLat() ?>';
  lng = $('#company_company_location_longitude').val()? $('#company_company_location_longitude').val(): '<?php echo $sf_user->getCity()->getLng() ?>';
  
  <?php if($sf_user->getCountry()->getSlug() == 'ro'): ?>
      var listarray = {
        'Bulevardul' : 0,
        'Cartier' : 1,
        'Strada' : 2,
        'Calea' : 3,
        'Prelungirea' : 4,
        'Piata': 5,
        'Drumul' : 6,
        'Intrarea' : 7,
        'Șoseaua' : 10,
        'Aleea' : 11
      }
    <?php else: ?>
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
    }
    <?php endif ?>
  
  var is_dragged = false, is_entered = false;
	
	var map_center = new google.maps.LatLng(lat, lng);
	
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
		
	google.maps.event.addListener(marker, 'dragend',  function() {
    is_dragged = true;
		var caa = '';
	 
		geocoder.geocode( { 'latLng': marker.getPosition(), 'language': 'bg'}, function(results, status) {
			if (status != google.maps.GeocoderStatus.OK || is_entered) return;
      
			$(results[0].address_components).each(function(i,s) {
				
        if(s.types[0] == 'street_number') 
          $('#company_company_location_street_number').val(s.long_name).parent().find('label').hide();
        else if(s.types[0] == 'route') 
        {
					var str = s.long_name; 
					firstword =  str.split(" ",1);
          
          
				
					caa = firstword[0];
					rest = str.replace(caa, '');
					
					if (listarray[caa] != undefined)
          {
						$('#company_company_location_street_type_id')[0].selectedIndex = listarray[caa]; 
						$('#company_company_location_street').val(rest).parent().find('label').hide();
					}
					else
					{
						$('#company_company_location_street').val(s.long_name).parent().find('label').hide();
					}
						
				}
				else if(s.types[0] == 'postal_code')
					$('#company_company_location_postcode').val(s.long_name);
				else if(s.types[0] == 'locality')
        {
					$('#autocomplete_company_city_id').val(s.long_name);
					$('#company_city').val(s.long_name).parent().find('label').hide();
			 
				}
			})
      
		  $('#company_company_location_latitude').val(marker.getPosition().lat());
		  $('#company_company_location_longitude').val(marker.getPosition().lng());
		});

	});


	/* $('#autocomplete_company_city_id').result(function (event, data, formatted) {
			city = data[0];
			
			geocoder.geocode( { 'address': city}, function(results, status) {
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
  }); */
	
	$('#company_company_location_street, #company_company_location_street_type').change(function() {
    if(is_dragged) return;
    
    var list = [];
    $(listarray).each(function(i,s) {
      list[s] = i;
    });
    console.log(list,listarray); 
    var selected = list[$('#company_company_location_street_type_id')[0].selectedIndex];
    
    console.log(selected + ' '+ $(this).val() + ", " + $('#company_city').val());
		geocoder.geocode( { 'address': selected + ' '+ $(this).val() + ", " + $('#company_city').val(), bounds: map.getBounds()}, function(results, status) {
      is_entered = true;
      
			if (status != google.maps.GeocoderStatus.OK) return;
      
			map.setCenter(results[0].geometry.location);
				
			marker.setPosition(results[0].geometry.location);
			$('#company_company_location_latitude').val(marker.getPosition().lat());
			$('#company_company_location_longitude').val(marker.getPosition().lng());		
		});
	});

})
</script>