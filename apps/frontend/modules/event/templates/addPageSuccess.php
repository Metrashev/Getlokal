<?php use_helper('Pagination');?>
						
<?php $places = $placePager->getResults();
if(count($places) > 0):
	foreach($places as $place):
		$placeTitle = $place->getCompany()->getCompanyTitleByCulture();
		$placeAddress = $place->getCompany()->getDisplayAddress();// .', '. $company->getLocationName();
		$sPlaceText = $placeTitle .' - '. $placeAddress;
?>
	<p>
		<a class="list_add_company" href="javascript:void(0);" id="<?php echo $place->getId() ?>" title="<?php echo $sPlaceText;?>"> <?php echo $sPlaceText;?></a>
	</p>
<?php endforeach;?>
<!-- <?php echo ajax_pager_navigation($placePager, url_for('event/addPage?place='. $placeStr )) ?>	-->
	
<?php else:
	echo __('We couldn\'t find a place beginning with:') ." <b>". $placeStr ."</b>!";
	endif; ?>

<script type="text/javascript">

// $(document).ready(function() {
	  $('#PlacesList .pager a').click(function() {
		  var values = $('#place').val();
		  var cityId = $('#event_location_id').val();
		$.ajax({
			url: this.href,
			data: {'place': values, 'cityId': cityId},
			beforeSend: function( ) {
				$('#PlacesList').html(LoaderHTML);
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
		  });
		$('#PlacesList a').each(function(i,s) {
			if(inArray(ids, $(s).attr('id')))
			{
				$(s).addClass('notActive');
				$(s).attr('onclick','').unbind('click').click(function() {return false });
				$(s).parent().remove();
			}
		});
	  }
		   

	  $('.list_add_company').click(function() {
		var paceId = $(this).attr('id');
		var value = $(this).attr('title');
		$(this).addClass('notActive');
		$("ul.tag-wrapper").append('<li class="tag"><input type="hidden" name="event[place_id][]" value="'+paceId+'">'+value+' <a onclick="$(this).parent().remove()"><i class="close"></i></a></li>');
		$(this).attr('onclick','').unbind('click').click(function() {return false });
		$(this).parent().remove();
		return false;
	});
	checkIsSelected();
// })
</script>
