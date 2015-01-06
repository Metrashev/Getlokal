<?php use_helper('Pagination');?>
<?php /*use_helper('MoreText','jQuery','ObjectUrl'); ?>
<?php //print_r($addListIds);exit();?>
<script>
$("a.place_list_link_add").click(function(event) {
	var currentId = $(this).attr('id');
	
	$.ajax({
        url: '<?php echo url_for("@add_company_to_list_js") ?>',
        type: "POST",
        data: {'guid':currentId},
        success: function(str)
        {
        	$("div.list_of_company").prepend(str);
        }
	})  
	
  	//$("div.my_test").show(); 
});


$("a.place_list_link_dell").click(function(event) {
	  event.preventDefault();
	  var currentId = $(this).attr('id');
	  $("div.list_of_company").find('div#'+currentId).remove();
	  //$("ul.list_of_company").prepend('<div>'+currentId+'</div>');
	});

$("a.list_add_company").click(function(event) {
  event.preventDefault();
  $(this).next('a').show(); 
});
</script>
<?php */ ?>
<div>
<?php
$places = $placePager->getResults();
//$event=Doctrine_Core::getTable('Event')->find(array($eventId));
if(count($places) > 0):
	foreach($places as $place):

		//$foring = $places->getForeing();
		$placeTitle = $place->getCompany()->getCompanyTitleByCulture();
		$placeAddress = $place->getCompany()->getDisplayAddress();// .', '. $company->getLocationName();
		//$nCompanyGuid = $company->getGuid();
		$sPlaceText = $placeTitle .' - '. $placeAddress;
		//$place=UsersListPlacesPeer::retrieveByPK($listId, $company_guid);
	
?>
	<p>
	<a class="list_add_company" href="javascript:void(0);" id="<?php echo $place->getId() ?>" title="<?php echo $sPlaceText;?>"> <?php echo $sPlaceText;?></a>
	</p>
<?php endforeach;?>
<?php  echo pager_navigation($placePager, url_for('event/addPage?place='. $placeStr )) ?>	
<div class="clear"></div>
	
<?php else:
	echo __('We couldn\'t find a place beginning with:') ." <b>". $placeStr ."</b>!";
	endif; ?>
</div>
<script type="text/javascript">

$(document).ready(function() {
	  $('#PlacesList .pager a').click(function() {
		  var values = $('#pace').val();
		  var cityId = $('#event_location_id').val();
		$.ajax({
			url: this.href,
			data: {'place': values, 'cityId': cityId},
			beforeSend: function( ) {
				$('#PlacesList').html('<div class="review_list_wrap">loading...</div>');
			  },
			success: function( data ) {
			  $('#PlacesList').html(data);
			}
		});
		return false;
	  })
	  
	  var checkIsSelected = function() {
		  var ids = [];
		  var inArray = function(s, w) {
			  for(var i in s)
			  {
				  if(w == s[i]) { return true; }
			  }
			  return false;
		  }
		  
		  $('.list_of_places input').each(function(i,s) {
			  ids.push($(s).val());
		  })
		$('#PlacesList a').each(function(i,s) {
			if(inArray(ids, $(s).attr('id')))
			{
				$(s).addClass('notActive');
				$(s).attr('onclick','').unbind('click').click(function() {return false });
				$(s).parent().remove();
			}
		})
	  }
		   

	  $("#PlacesList a.list_add_company").click(function() {
		var paceId = $(this).attr('id');
		var value = $(this).attr('title');
		$(this).addClass('notActive');
		$("div.list_of_places").append('<div><input type="hidden" name="event[place_id][]" value="'+paceId+'"><p>'+value+'</p> <a onclick="$(this).parent().remove()">X</a></div>');
		$(this).attr('onclick','').unbind('click').click(function() {return false });
		$(this).parent().remove();
		return false;
	})
	checkIsSelected();
})
</script>
