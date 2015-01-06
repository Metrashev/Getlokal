<?php use_helper('jQuery')?>
<?php slot('no_feed', true) ?>

<div class="content_in">
			
		
				<h1><?php echo __('Add Company', null, 'company')?></h1>

		 <form action="<?php echo url_for('company/addNewCompany');?>" method="post">
   	  <?php echo $form['_csrf_token']->render() ?>
   	 
   	  <div class="form_box <?php echo $form['title']->hasError()? 'error': ''?>">
      <?php echo $form['title']->renderLabel() ?>
        
      <?php echo $form['title']->render(); ?>
      <?php echo $form['title']->renderError() ?>
    </div>
   	
   	 <div class="form_box <?php echo $form['title_en']->hasError()? 'error': ''?>">
      <?php echo $form['title_en']->renderLabel() ?>
        
      <?php echo $form['title_en']->render(); ?>
      <?php echo $form['title_en']->renderError() ?>
    </div>
    
   	 <div class="form_box <?php echo $form['city_id']->hasError()? 'error': ''?>">
      <?php echo $form['city_id']->renderLabel() ?>
        
      <?php echo $form['city_id']->render(); ?>
      <?php echo $form['city_id']->renderError() ?>
    </div>
     <div class="form_box form_tooltip <?php echo $form['phone']->hasError()? 'error': ''?>">
      <?php echo $form['phone']->renderLabel() ?>
        
      <?php echo $form['phone']->render(); ?>
	  <span class="tooltip">?</span>
      <div class="tooltip_body longer_desc"><span><?php echo __('The correct format to use is 023456789 or for mobile phones 0888888888. Add only the local area code for landlines. Only add digits – any other characters or spaces between characters are not allowed.', null, 'company');?></span></div>
      <?php echo $form['phone']->renderError() ?>
    </div> 
    
    <?php if(isset($form['registration_no'])):?>
    <div class="form_box <?php echo $form['registration_no']->hasError()? 'error': ''?>">
      <?php echo $form['registration_no']->renderLabel() ?>
        
      <?php echo $form['registration_no']->render(); ?>
      <?php echo $form['registration_no']->renderError() ?>
    </div>
    <?php endif;?>
   	<div class="form_box <?php echo $form['sector_id']->hasError()? 'error': ''?>">
      <?php echo $form['sector_id']->renderLabel() ?>
       
       <?php echo $form['sector_id']->render(array(
		'onchange'=>jq_remote_function(array(
  		  'update'=>'classification_id', //dom id
  		  'url'=>'company/selectClassification', //the action to be called
  		  'method'=>'get',
  		  'with'=>"'sector_id=' + this.options[this.selectedIndex].value",
          'complete'=>"$('#classification_id').show();",
		))
  	     ), array('value' => $sector_id)) ?>
      <?php echo $form['sector_id']->renderError() ?>
    </div>
    <div <?php echo (!isset($classification_id))? 'style="display:none"' :''; ?> id ="classification_id" class="form_box <?php echo $form['classification_id']->hasError()? 'error': ''?>">
      <?php echo $form['classification_id']->renderLabel() ?>   
      <?php echo $form['classification_id']->render(array('value' => $classification_id)); ?>
      <?php echo $form['classification_id']->renderError() ?>
    </div>
    
     <div class="form_box <?php echo $form['company_location']['street_type_id']->hasError()? 'error': ''?>">
      <?php echo $form['company_location']['street_type_id']->renderLabel() ?>
        
      <?php echo $form['company_location']['street_type_id']->render(); ?>
      <?php echo $form['company_location']['street_type_id']->renderError() ?>
    </div>
    
     <div class="form_box <?php echo $form['company_location']['street']->hasError()? 'error': ''?>">
              
      <?php echo $form['company_location']['street']->render(); ?>
      <?php echo $form['company_location']['street']->renderError() ?>
    </div>
     <div class="form_box <?php echo $form['company_location']['street_number']->hasError()? 'error': ''?>">
              <?php echo $form['company_location']['street_number']->renderLabel() ?>      
      <?php echo $form['company_location']['street_number']->render(); ?>
      <?php echo $form['company_location']['street_number']->renderError() ?>
    </div>
     <?php if (isset($form['company_location']['location_type'])):?>
     <div class="form_box <?php echo $form['company_location']['location_type']->hasError()? 'error': ''?>">
      <?php echo $form['company_location']['location_type']->renderLabel() ?>
        
      <?php echo $form['company_location']['location_type']->render(); ?>
      <?php echo $form['company_location']['location_type']->renderError() ?>
    </div>
  <?php endif;?>
     <div class="form_box <?php echo $form['company_location']['neighbourhood']->hasError()? 'error': ''?>">
      <?php echo $form['company_location']['neighbourhood']->renderLabel() ?>
        
      <?php echo $form['company_location']['neighbourhood']->render(); ?>
      <?php echo $form['company_location']['neighbourhood']->renderError() ?>
    </div>
    <div class="form_box <?php echo $form['company_location']['building_no']->hasError()? 'error': ''?>">
      <?php echo $form['company_location']['building_no']->renderLabel() ?>
        
      <?php echo $form['company_location']['building_no']->render(); ?>
      <?php echo $form['company_location']['building_no']->renderError() ?>
    </div>
    <div class="form_box <?php echo $form['company_location']['entrance']->hasError()? 'error': ''?>">
      <?php echo $form['company_location']['entrance']->renderLabel() ?>
        
      <?php echo $form['company_location']['entrance']->render(); ?>
      <?php echo $form['company_location']['entrance']->renderError() ?>
    </div>
    <div class="form_box <?php echo $form['company_location']['floor']->hasError()? 'error': ''?>">
      <?php echo $form['company_location']['floor']->renderLabel() ?>
        
      <?php echo $form['company_location']['floor']->render(); ?>
      <?php echo $form['company_location']['floor']->renderError() ?>
    </div>
    <div class="form_box <?php echo $form['company_location']['appartment']->hasError()? 'error': ''?>">
      <?php echo $form['company_location']['appartment']->renderLabel() ?>
        
      <?php echo $form['company_location']['appartment']->render(); ?>
      <?php echo $form['company_location']['appartment']->renderError() ?>
    </div>
    <div class="form_box <?php echo $form['company_location']['postcode']->hasError()? 'error': ''?>">
      <?php echo $form['company_location']['postcode']->renderLabel() ?>
        
      <?php echo $form['company_location']['postcode']->render(); ?>
      <?php echo $form['company_location']['postcode']->renderError() ?>
    </div>  
    <?php if (isset($form['page_admin'])): ?>  
    <?php if (isset($form['page_admin']['user_profile']['sf_guard_user']) && isset($form['page_admin']['user_profile']['sf_guard_user']['first_name'])):?>
    <div class="form_box <?php echo $form['page_admin']['user_profile']['sf_guard_user']['first_name']->hasError()? 'error': '' ?>">
      <?php echo $form['page_admin']['user_profile']['sf_guard_user']['first_name']->renderLabel() ?><span class="pink">*</span>
      <?php echo $form['page_admin']['user_profile']['sf_guard_user']['first_name']->render();?>
      <?php echo $form['page_admin']['user_profile']['sf_guard_user']['first_name']->renderError();?>
    </div>
    <?php endif;?>
     <?php if (isset($form['page_admin']['user_profile']['sf_guard_user']) && isset($form['page_admin']['user_profile']['sf_guard_user']['last_name'])):?>
      <div class="form_box <?php echo $form['page_admin']['user_profile']['sf_guard_user']['last_name']->hasError()? 'error': '' ?>">
      <?php echo $form['page_admin']['user_profile']['sf_guard_user']['last_name']->renderLabel() ?><span class="pink">*</span>
      <?php echo $form['page_admin']['user_profile']['sf_guard_user']['last_name']->render();?>
      <?php echo $form['page_admin']['user_profile']['sf_guard_user']['last_name']->renderError();?>
    </div>
    <?php endif;?>
 
     <?php if (isset($form['page_admin']['user_profile']['gender'])):?>
    <div class="form_box <?php echo $form['page_admin']['user_profile']['gender']->hasError()? 'error': '' ?>">
      <?php echo $form['page_admin']['user_profile']['gender']->renderLabel() ?><span class="pink">*</span>
       <?php echo $form['page_admin']['user_profile']['gender']->render();?>
      <?php echo $form['page_admin']['user_profile']['gender']->renderError();?>
    </div>
     <?php endif;?>
      <?php if (isset($form['page_admin']['user_profile']['phone_number'])):?>
    <div class="form_box <?php echo $form['page_admin']['user_profile']['phone_number']->hasError()? 'error': '' ?>">
      <?php echo $form['page_admin']['user_profile']['phone_number']->renderLabel() ?><span class="pink">*</span>
      
      <?php echo $form['page_admin']['user_profile']['phone_number']->render();?>
      <?php echo $form['page_admin']['user_profile']['phone_number']->renderError();?>
    </div>
    <?php endif;?>
    
    <div class="form_box <?php echo $form['page_admin']['position']->hasError()? 'error': '' ?>">
      <?php echo $form['page_admin']['position']->renderLabel() ?>      
      <?php echo $form['page_admin']['position']->render();?>
      <?php echo $form['page_admin']['position']->renderError();?>
    </div>
    <?php if (isset($form['page_admin']['username'])):?>
    <div class="form_box form_tooltip <?php echo $form['page_admin']['username']->hasError()? 'error': '' ?>">
      <?php echo $form['page_admin']['username']->renderLabel() ?>      
      <?php echo $form['page_admin']['username']->render();?>
      <span class="tooltip">?</span>
      <div class="tooltip_body"><span><?php echo __('Your username should contain only alphanumeric characters, dash, dot or underscore');?></span></div>
      <?php echo $form['page_admin']['username']->renderError();?>
    </div>
      <?php endif;?>
       <?php if (isset($form['page_admin']['password'])):?>
    <div class="form_box <?php echo $form['page_admin']['password']->hasError()? 'error': '' ?>">
      <?php echo $form['page_admin']['password']->renderLabel() ?>      
      <?php echo $form['page_admin']['password']->render();?>
      <?php echo $form['page_admin']['password']->renderError();?>
    </div>
    <?php endif;?>
     <?php if (isset($form['page_admin']['authorized'])):?>
    <div class="form_box <?php echo $form['page_admin']['authorized']->hasError()? 'error': '' ?>">
      <?php echo $form['page_admin']['authorized']->render(array('class' => 'input_check'));?>
      <?php echo $form['page_admin']['authorized']->renderLabel() ?>
      <?php if($form['page_admin']['authorized']->hasError()):?>
        <p class="error"><?php echo $form['page_admin']['authorized']->renderError();?></p>
        <?php endif;?>

    </div>
    <?php endif;?>
     <?php if (isset($form['page_admin']['allow_b_cmc'])):?>
     <div class="form_box <?php echo $form['page_admin']['allow_b_cmc']->hasError()? 'error': '' ?> form_box_small">
      <?php echo $form['page_admin']['allow_b_cmc']->render();?>
      <?php echo __('I would like to receive getlokal\'s Business Newsletter and Notifications.'); ?>
      <?php echo $form['page_admin']['allow_b_cmc']->renderError();?>
    </div>
    <?php endif;?>
     <?php if (isset($form['page_admin']['accept'])):?>
     <div class="form_box <?php echo $form['page_admin']['accept']->hasError()? 'error': '' ?> form_box_small">
		<?php echo $form['page_admin']['accept']->render();?>
	    <?php echo sprintf(__('I have the necessary representative powers and agree with the %s and the %s'),  link_to(__('Terms of Use'), '@static_page?slug=terms-of-use',array('popup'=>true) ), link_to (__('Policy for Use and Protection of the Information of Getlokal'), '@static_page?slug=privacy-policy',array('popup'=>true)));?>
        <?php echo $form['page_admin']['accept']->renderError();?>
    </div>
    <?php endif;?>
    
		  <?php endif;?>
			 <div class="form_box">
      <input type="submit" value="<?php echo __('Send')?>" class="input_submit" />
    </div>
    <?php echo $form->renderHiddenFields();?>
  </form>
			
				
</div>
	 
		<!-- Sidebar Area -->
			<div class="sidebar">
		<div id="map_canvas"></div>	
			

<script type="text/javascript">
<?php $country  = $sf_user->getCountry()->getId();?>
<?php switch ($country):
   case getlokalPartner::GETLOKAL_RO:
   	 $deflat = "44.44432";
     $deflng ="26.096935";   	 
    break;
    case getlokalPartner::GETLOKAL_MK:
   	 $deflat = "42.01053";
        $deflng ="21.432152";
    break;
   case getlokalPartner::GETLOKAL_FI:
   	 $deflat = "60.984017";
         $deflng ="25.65093";
    break;
     default:
    case getlokalPartner::GETLOKAL_BG:
     $deflat = "42.6970718";
     $deflng ="23.320999";
	break;
	endswitch;
	?>
$(document).ready(function() {
	$(".search_bar").css("display", "none");
	$(".path_wrap").css("display", "none");
	$(".banner").css("display", "none");
//	$(".follow_feed").css("display", "none");
	<?php if (($sf_user->getCulture()== 'bg') || ($sf_user->getCulture()== 'mk')): ?>
            $(".tooltip_body.longer_desc").css({'top':'-155px'});
        <?php endif;?>
  var map_center = new google.maps.LatLng(
		  <?php echo (isset($lat)? $lat: ($sf_user->getCity()->getLat() ? $sf_user->getCity()->getLat(): $deflat)); ?>, 
		  <?php echo (isset($long)? $long: ($sf_user->getCity()->getLng()? $sf_user->getCity()->getLng(): $deflng)); ?>
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
        title: '<?php echo $company->getCompanyTitle() ?>'
    });
    
  google.maps.event.addListener(marker, 'dragend', dropMarker);
  
  function dropMarker()
  {
    console.log(marker.getPosition());
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
        console.log($(results));
        $(results[0].address_components).each(function(i,s) {

        	
            if(s.types[0] == 'street_number')
              $('#company_company_location_street_number').val(s.long_name);
            else if(s.types[0] == 'route'  || s.types[0] == 'sublocality')
            {
               
                var str = s.long_name; 
                firstword =  str.split(" ",1);
              
                caa = firstword[0];
                rest = str.replace(caa, '');
                
                if (listarray[caa] != undefined){
                    if (listarray[caa] != 2 && listarray[caa] != 3){
                  $('#company_company_location_street_type_id').val(listarray[caa]); 
                  $('#company_company_location_street').val(rest);
                  $('#company_company_location_sublocation').val(s.long_name);
                } else
                {
              	  $('#company_company_location_location_type').val(listarray[caa]); 
                  $('#company_company_location_neighbourhood').val(rest);
                  $('#company_company_location_sublocation').val(s.long_name);
                    
                }
                }

                else
                {
              	  $('#company_company_location_street').val(s.long_name);
                }
                  
            }
            
            else if(s.types[0] == 'postal_code')
                $('#company_company_location_postcode').val(s.long_name);
            else if(s.types[0] == 'locality'){
                $('#autocomplete_company_city_id').val(s.long_name);
                $('#company_city').val(s.long_name);
             
              }
          })
        $('#company_company_location_latitude').val(marker.getPosition().lat());
        $('#company_company_location_longitude').val(marker.getPosition().lng());
       
        } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });

  }

  $('#autocomplete_company_city_id').result(function (event, data, formatted) {
      city = data[0];
      console.log($('#company_city_id').val());
      
      
      
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
});
  
  $('#company_company_location_street').change(function() {
    console.log($('#company_company_location_street').val());
  
  
    
    geocoder.geocode( { 'address': $('#company_company_location_street').val() + ", " + $('#autocomplete_company_city_id').val()}, function(results, status) {
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
})
</script>
				
			
			</div>
			
			
			
			<div class="clear"></div>