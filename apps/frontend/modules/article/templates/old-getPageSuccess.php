<?php use_helper('Pagination');?>
<div>
<?php $places = $placePager; ?>
<?php if(count($places) > 0): ?>
<?php foreach($places as $place): ?>

<?php
//var_dump($place);
		$placeTitle = $place->getCompany()->getCompanyTitleByCulture();
		$placeAddress = $place->getCompany()->getDisplayAddress();// .', '. $company->getLocationName();
		$sPlaceText = $placeTitle .' - '. $placeAddress;
?>
		<div>
		<?php /**/?>
			<a title="<?php echo $sPlaceText?>" id="<?php echo $place->getId() ?>" class="button_pink" href="javascript:void(0);"><?php echo __('Add',null,'company' )?></a>
			<a href="javascript:void(0);" title="<?php echo $sPlaceText?>" id="<?php echo $place->getId() ?>"><?php echo $sPlaceText?></a>
		<?php /**/ ?>	
			<div class="clear"></div>
		</div>
	
<?php endforeach;?>
<?php  //echo pager_navigation($placePager, url_for('event/addPage?place='. $placeStr )) ?>	
<div class="clear"></div>
	
<?php else:
	echo __("We couldn't find a place beginning with:") ." <b>". $placeStr ."</b>!";
	endif; ?>
</div>
<script type="text/javascript">
$(document).ready(function() {
/*
	  $('#PlacesList .pager a').click(function() {
		  var values = $('#pace').val();
		  var cityId = $('#article_location_id').val();
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
*/		  

	  $("#item_list a").click(function() {
			var articleId = <?php echo $articleId ?>;
			var thisEl = $(this);
			var value = thisEl.attr('title');
			var paceId = thisEl.attr('id');

			$.ajax({
				url: '<?php echo url_for("article/addPageToArticle") ?>',
					data: {'placeId': paceId, 'articleId': articleId},
				beforeSend: function() {
					$(thisEl).addClass('notActive');
					$(thisEl).attr('onclick','').unbind('click').click(function() {return false });
					thisEl.parent().remove();
				},
				success: function(data, url) {
					$("#list_of_places").prepend(data);
					$('.form_list_wrap > div').tinyscrollbar();
					if ($('#list_of_places').parent().outerHeight() > $('#list_of_places').parent().parent().outerHeight())
						$('#list_of_places').parent().width(181);
			    },
			    error: function(e, xhr)
			    {
			        console.log(xhr);
			    }
			});
			
			return false;
		})

	//checkIsSelected();
})
</script>
