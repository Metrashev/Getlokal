<div class="promo_wrap">
<div class="promo_header_wrap"><?php $culture= $sf_user->getCulture();?>
	<?php if($sf_user->getCulture() == 'en'): ?> 
	<img src="/images/promo/addPlace/header_en.png"></img> 
	<?php else: ?> <img
	src="/images/promo/addPlace/header.png"></img> <?php endif ?>
</div>
	
		<h2><span></span><?php echo sprintf(__('Win SUPRA from %s and the <b>New iPad</b>', null ,'addPlacePage'), '<a href="/bg/sofia/blok_shop_7021393"><b>BlokShop</b></a>');?></h2>
		<h3><span></span><?php echo __('Find the place on the map, fill in the form and enter to win', null ,'addPlacePage') ?></h3>
	
<div class="promo_content_wrap">

<div class="promo_content">
<div class="promo_content_in">
	<ul>
		<li><?php echo __('Add a place by filling in all mandatory fields', null, 'addPlacePage'); ?></li>
		<li><?php echo sprintf(__('You have to be a %s of getlokal to participate', null, 'addPlacePage'), link_to(__('registered user', null, 'addPlacePage'), '@user_register')); ?></li>
		<li><?php echo __('Every added place will be verified for duplication from a member of the getlokal team and will be considered as a valid entry only if it doesn\'t already exist on the site', null, 'addPlacePage'); ?></li>
		<li><?php echo __('For every valid entry you will receive a confirmation on the email you use for your registration in getlokal', null, 'addPlacePage'); ?></li>
		<li><?php echo sprintf(__('Every confirmed place is considered as a separate entry for the set promotional period. The more new places you add, the higher your chances of winning <b>SUPRA</b> sneakers and %s', null, 'addPlacePage'), '<b>'.__('The New iPad', null, 'addPlacePage').'</b>'); ?></li>
		
		<div class="promo_content_inside">
			<ul>
				<li><?php echo sprintf(__('The game starts on 03 September and ends on 08 October', null, 'addPlacePage'))?></li>
				<li><?php echo __('The prize draw for the <b>New iPad</b> will be on 08.10.2012', null, 'addPlacePage'); ?></li>
				<li><?php echo sprintf(__('The weekly prizes will be drown on 17 and 24 September and 01 October 2012', null, 'addPlacePage'))?></li>
				<li><?php echo sprintf(__('The weekly prizes will be announced every week here and in our %s', null, 'addPlacePage'), '<a href="http://www.facebook.com/getlokal" target="_blank">'.__("fb page",null,'addPlacePage').'</a>')?></li>
				<?php //printf(__('The game is active from %s to %s', null, 'addPlacePage'), '03.09', '03.10.2012'); ?>
				<li><?php echo sprintf(__('Please %s if you have additional questions or find us on %s', null, 'addPlacePage'), '<a href="mailto:info@getlokal.com">'.__('write to us', null, 'addPlacePage').'</a>', 
				'<a href="http://www.facebook.com/getlokal" target="_blank">Facebook</a>'); ?></li>
			</ul>
		</div>
	</ul>
</div>
<div class="clear"></div>
</div>
</div>
</div>
<div class="clear"></div>
<div class="form_container">
	<div class="pink_form_boxes"> 
		<div class="content_in">
			<form action="<?php echo url_for('promo/addPlaceGame')?>" method="post">
		    <?php echo $form[$form->getCSRFFieldName()]; ?>
		    
		     <div class="form_box form_tooltip form_label_inline form_spacing<?php echo $form['city_id']->hasError()? 'error': ''?>">
		      <?php echo $form['city_id']->renderLabel() ?><span class="pink">*</span><br />
		      <?php echo $form['city_id']->render(); ?>
			  <span class="tooltip">?</span>
		      <div class="tooltip_body"><span><?php echo __('To change the city start typing', null, 'addPlacePage');?></span></div>
		      <?php echo $form['city_id']->renderError() ?>
		    </div>
		      <div class="form_box form_label_inline form_spacing <?php echo $form['title']->hasError()? 'error': ''?>">
		      <?php echo $form['title']->renderLabel() ?><span class="pink">*</span><br />
		      <?php echo $form['title']->render(); ?>
		      <?php echo $form['title']->renderError() ?>
		    </div>
		   	
		   	 <div class="form_box form_tooltip <?php echo $form['title_en']->hasError()? 'error': ''?>">
		      <?php echo $form['title_en']->renderLabel() ?>
		      <?php //echo $form['title_en']->render(array('class'=>'typewriter_water','typewriter'=>__('Not mandatory but helpful', null, 'addPlacePage'))); ?>
		      <?php echo $form['title_en']->render(); ?>
		      <span class="tooltip">?</span>
		      <div class="tooltip_body"><span><?php echo __('Not mandatory but helpful', null, 'addPlacePage');?></span></div>
		      <?php echo $form['title_en']->renderError() ?>
		    </div>
		      <p class="extra_text" style="width:300px"><?php echo __('Is this the place? In order to participate in the prize draw please make sure the place you are tying to add is not listed bellow', null, 'addPlacePage'); ?></p>
		      <div id="data" class="form_firm"></div>
		    <div class="form_box form_tooltip form_label_inline form_spacing <?php echo $form['company_location']['address_info']->hasError()? 'error': ''?>">
		      <?php echo $form['company_location']['address_info']->renderLabel() ?><span class="pink">*</span><br />
		      <?php echo $form['company_location']['address_info']->render(); ?>
		      <span class="tooltip">?</span>
		      <div class="tooltip_body"><span><?php echo __('Drag the marker to the correct location on the map and the address will automatically show in the field. Check if it is correct. You can change it by adding or deleting information', null, 'addPlacePage');?></span></div>
		      <?php echo $form['company_location']['address_info']->renderError() ?>
		    </div>
		
		    <div class="form_box form_tooltip form_label_inline form_spacing <?php echo $form['more']->hasError()? 'error': ''?>">
		      <?php echo $form['more']->renderLabel() ?><span class="pink">*</span></br>
		      <?php echo $form['more']->render(); ?>
		      <span class="tooltip">?</span>
		      <div class="tooltip_body"><span><?php echo __('In order to verify the place it is very important for us to have one of the three. If you choose telephone, please give only numbers, no spaces.', null, 'addPlacePage');?></span></div>
		      <?php echo $form['more']->renderError() ?>
		    </div>
		    <div class="form_box form_tooltip form_label_inline form_spacing <?php echo $form['classification_id']->hasError()? 'error': ''?>">
		      <?php echo $form['classification_id']->renderLabel() ?><span class="pink">*</span><br />
		      <?php echo $form['classification_id']->render(); ?>
		      <span class="tooltip">?</span>
		      <div class="tooltip_body"><span><?php echo __('Start typing to see the list to choose from', null, 'addPlacePage');?></span></div>
		      <?php echo $form['classification_id']->renderError() ?>
		    </div>
		   	<div class="form_box">
		   		<p style="font-size:11px;"><span class="pink">* </span><?php echo __('Mandatory field', null, 'addPlacePage')?></p>
		   		<input type="submit" value="<?php echo __('Submit', null, 'addPlacePage')?>" class="input_submit" />
			<div class="right_picture_wrap">
				<img src="/images/promo/addPlace/picture2.png" />
				<a target="_blank" class="floating_logo" href="http://www.facebook.com/BLOKSHOP"><img src="/images/promo/addPlace/blokshop_logo.png" /></a>
				<div class="clear"></div>
			</div>
		   	</div>
		     <?php echo $form->renderHiddenFields();?>
		     </form>
		</div>
		<div class="right_box">
			<a href="javascript:void(0)"><?php echo __('Rules <span class="lightblue">of the Game | How to</span> <span class="yellow">win</span>', null, 'promo'); ?></a>
			<div class="clear"></div>
			<div class="canvas">
				<div id="map_canvas"></div>	
			</div>
		</div>
		<div class="clear"></div>
	</div>
 </div>

<?php $lang = mb_convert_case(getlokalPartner::getLanguageClass(), MB_CASE_LOWER);?>
<?php use_javascript('http://maps.googleapis.com/maps/api/js?key=AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08&sensor=false&language='.$lang) ?>
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
     default:
    case getlokalPartner::GETLOKAL_BG:
     $deflat = "42.6970718";
     $deflng ="23.320999";
	break;
	endswitch;
	?>
$(document).ready(function() {
  $('.extra_text').css('display', 'none');
  $('.form_firm').css('display', 'none');
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
        draggable: true
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
                  $('#company_company_location_sublocation').val(rest);
                } else
                {
              	  $('#company_company_location_location_type').val(listarray[caa]); 
                  $('#company_company_location_neighbourhood').val(rest);
                  $('#company_company_location_sublocation').val(rest);      
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
        var address = results[0].formatted_address; 
      
        var str = address.split(", ");
        str.pop(-1);
        str.pop(-1);
 
         $('#company_company_location_address_info').val(str);
        
        } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });

  }

  
 
  $('#autocomplete_company_city_id').result(function (event, data, formatted) {
      city = data[0];
      console.log($('#company_city_id').val());
      
      
      
      geocoder.geocode( { 'address':  $('#company_company_location_address_info').val()+ ", "+ city}, function(results, status) {
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


  $('#company_company_location_address_info').change(function() {
	    console.log($('#company_company_location_address_info').val());
	  
	  
	    
	    geocoder.geocode( { 'address': $('#company_company_location_address_info').val()+ ", "+ $('#autocomplete_company_city_id').val()}, function(results, status) {
	      if (status == google.maps.GeocoderStatus.OK) {
	          console.log($(results));
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
	        
	          $(results[0].address_components).each(function(i,s) {
	        	
	            if(s.types[0] == 'street_number')
	              $('#company_company_location_street_number').val(s.long_name);
	            else if(s.types[0] == 'route')
	            {
	                var str = s.long_name; 
	                firstword =  str.split(" ",1);
	              
	                caa = firstword[0];
	                rest = str.replace(caa, '');

		                
	                if (listarray[caa] != undefined){
	                    if (listarray[caa] != 2 && listarray[caa] != 3){
	                $('#company_company_location_street_type_id').val(listarray[caa]); 
	                $('#company_company_location_street').val(rest);
	                $('#company_company_location_sublocation').val(rest);
	                } else
	                {
	              	  $('#company_company_location_location_type').val(listarray[caa]); 
	                    $('#company_company_location_neighbourhood').val(rest);
	                    $('#company_company_location_sublocation').val(rest); 
	                }
	                }

	                else
	                {
	              	  $('#company_company_location_street').val(s.long_name);
	                }
	                  
	            }
	            else if(s.types[0] == 'sublocality')
	              $('#company_company_location_neighbourhood').val(s.long_name);
	            else if(s.types[0] == 'postal_code')
	                $('#company_company_location_postcode').val(s.long_name);
	            else if(s.types[0] == 'locality')
	                $('#company_city').val(s.long_name);

	           
	            })
	            map.setCenter(results[0].geometry.location);
	            marker.setPosition(results[0].geometry.location);
		        $('#company_company_location_latitude').val(marker.getPosition().lat());
		        $('#company_company_location_longitude').val(marker.getPosition().lng());    
	         
	      	         
		        } else {
	        alert("Geocode was not successful for the following reason: " + status);
	      }
	    });
	   
	  
	  });

var container = jQuery("#data");

//note that you'll need a routing for the offers index to point to module: offers, action: index..
var url = "<?php echo url_for("search/searchByNameAndCity"); ?>";
function loadPage(page,title,city_id)
{
	title = title.replace(" ","_");
	
// is it that simple? Yes it is with jQuery. Prototype would be just a few lines more code.. without library this would be 20 lines ;)
container.load(url+"?name="+title+"&city_id="+city_id+"&page="+page, function() {
	if (container.children('p').length == 0)
	{
		container.css('display', 'none');
	   	$('.extra_text').css('display', 'none');
	   	$('#map_canvas').css('height', '352px');
	   	$('.canvas').css('height', '352px');
	   	google.maps.event.trigger(map.map, 'resize');
	}
	else
	{
		container.css('display', 'block');
	   	$('.extra_text').css('display', 'block');
	   	$('#map_canvas').css('height', '454px');
	   	$('.canvas').css('height', '454px');
	   	google.maps.event.trigger(map.map, 'resize');
	}
});

}

  $('#company_title').change(function() {
	 var title = $('#company_title').val();
     var city_id = $('#company_city_id').val();
     loadPage(1,title,city_id);
});
 

	$(".search_bar").remove();
	$(".banner").remove();
	$(".path_wrap").remove();
	$('.content_footer').remove();
	$('input, textarea').mouseenter(function() {
		var tooltip = $(this).parent().children('.tooltip');
		if (tooltip.length > 0)
			$(this).parent().children('.tooltip_body').toggle();
	});
	$('input, textarea').mouseleave(function() {
		var tooltip = $(this).parent().children('.tooltip');
		if (tooltip.length > 0)
			$(this).parent().children('.tooltip_body').toggle();
	});

	$('.right_box > a').fancybox({
		'hideOnContentClick': true,
		'content': '<ul class="promo_content_in">' + $('.promo_content_in').children('ul').html() + '</ul>'
	});

	$('a#header_close').live('click', function() {
		$('.extra_text').css('display', 'none');
	   	$('#map_canvas').css('height', '352px');
	   	$('.canvas').css('height', '352px');
	   	google.maps.event.trigger(map.map, 'resize');
	});

	$('.header').css('marginBottom', '0px');
});



</script>
				
			
			</div>
			
			
			
			<div class="clear"></div>
