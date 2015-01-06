<?php use_helper('Pagination');?>
<div>
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
	<?php /*
		<a class="listing_place_img" href="#">
			<img width="100" height="100" title="" alt="" src="">
		</a>
		<div class="listing_place_in">
			<div class="listing_place_rateing">
				<div class="listing_place_rateing">
					<div class="rateing_stars">
						<div class="rateing_stars_orange" style="width: 97%;"></div>
					</div>
					<span class="">6 reviews</span>
				</div><br/><br/>
				<div class="listing_place_rateing">
					<a class="button_pink">Add a tip</a>
					<a title="<?php echo $sPlaceText?>" id="<?php echo $place->getId() ?>" class="button_green round circle_left" href="javascript:void(0);">Save</a>
				</div>
			</div>
			<span class="pink"><?php echo $sPlaceText?></span>
			<a class="category" href="#" title="">Category</a>
			<p>
				Description <br /> 
				02 400 9988 <br />
			</p>
		</div>
		<div class="clear"></div>
		<div class="listing_place_review">
			<strong><a href="#">Sender</a></strong>
			<q>
				<div class="desc_full">
			        <div>Sender said bla bla bla
			        <div class="clear"></div></div>
			        <a href="javascript:void(0)" id="hide_full_desc"><?php echo __('hide',null,'messages')?></a>
			        <a href="javascript:void(0)" id="read_full_desc"><?php echo __('read more...',null,'messages')?></a>
			    </div>
			</q>
		</div>
		<div class="clear"></div>
		*/ ?>
<?php endforeach;?>
<?php  //echo pager_navigation($placePager, url_for('event/addPage?place='. $placeStr )) ?>	
<div class="clear"></div>
	
<?php else:
	echo __("We couldn't find a place beginning with:") ." <b>". $placeStr ."</b>!";
	endif; ?>
</div>
<script type="text/javascript">

$(document).ready(function() {
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
					$("#list_of_places").prepend(data);
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
})
</script>
