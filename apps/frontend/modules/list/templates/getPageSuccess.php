<?php use_helper('Pagination');?>
<ul class="list-details-company">
<?php
$places = $placePager;
if(count($places) > 0):
	foreach($places as $place):

		$placeTitle = $place->getCompany()->getCompanyTitleByCulture();
		$placeAddress = $place->getCompany()->getDisplayAddress();// .', '. $company->getLocationName();
		$sPlaceText = $placeTitle .' - '. $placeAddress;
	
?>
		<div>
			<a title="<?php echo $sPlaceText?>" id="<?php echo $place->getId() ?>" class="button_pink" href="javascript:void(0);"><?php echo __('Add',null,'company' )?></a>
			<a href="javascript:void(0);" title="<?php echo $sPlaceText?>" id="<?php echo $place->getId() ?>"><?php echo $sPlaceText?></a>
			<p><?php echo $placeAddress; ?></p>
		</div>

<?php endforeach;?>
<?php  //echo pager_navigation($placePager, url_for('event/addPage?place='. $placeStr )) ?>	
<div class="clear"></div>
	
<?php else:
	echo __("We couldn't find a place beginning with:") ." <b>". $placeStr ."</b>!";
	endif; ?>

<script type="text/javascript">

// $(document).ready(function() {
	  $('#PlacesList .pager a').click(function() {
		  var values = $('#pace').val();
		  var cityId = $('#list_location_id').val();
		$.ajax({
			url: this.href,
			data: {'place': values, 'cityId': cityId},
			beforeSend: function( ) {
				$('#PlacesList').html('loading...');
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
		$('#PlacesList .overview a').each(function(i,s) {
			if(inArray(ids, $(s).attr('id')))
			{
				$(s).addClass('notActive');
				$(s).attr('onclick','').unbind('click').click(function() {return false });
				$(s).parent().remove();
			}
		})
	  }
		  

	  $("#PlacesList .overview a").click(function() {
			var listId = <?php echo $listId ?>;
			var thisEl = $(this);
			var value = thisEl.attr('title');
			var paceId = thisEl.attr('id');

			$.ajax({
				url: '<?php echo url_for("list/addPageToList") ?>',
					data: {'placeId': paceId, 'listId': listId},
				beforeSend: function() {
					//$("#PlacesList").html('loading...');
					//$("#PlacesList").toggle();
					$(thisEl).addClass('notActive');
					$(thisEl).attr('onclick','').unbind('click').click(function() {return false });
					//console.log(paceId+'Send');
				},
				success: function(data, url) {
					$("#list_of_places ul.list-details-company").prepend(data);
					if ($("#PlacesList").attr('data') == 'show')
						$("#list_of_places .listing_place").first().find('.list_movable').remove();
					else
						$("#list_of_places .listing_place").first().find('.list_movable').css({marginRight:'5px', width:'auto' });
					thisEl.parent().remove();
					//$("div.list_of_places").append('<div><input type="hidden" name="list[place_id][]" value="'+paceId+'"><p>'+value+'</p> <a onclick="$(this).parent().remove()">X</a></div>');
					$('#spanPlaceCount').text(parseInt($('#spanPlaceCount').text())+1);
					//console.log('success');
			    },
			    error: function(e, xhr)
			    {
			        console.log(xhr);
			    }
			});
			
			return false;
		})

	checkIsSelected();
// })
</script>
