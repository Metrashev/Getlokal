<?php use_helper('Pagination');?>
<div>
<?php
$categories = $categoryPager;
if(count($categories) > 0):
	foreach($categories as $category):
?>
		<div style="margin-top: 14px">
			<a title="<?php echo $category->getTitle()?>" id="<?php echo $category->getId() ?>" class="button_pink" href="javascript:void(0);"><?php echo __('Add',null,'company' )?></a>
			<a href="javascript:void(0);" title="<?php echo $category->getTitle()?>" id="<?php echo $category->getId() ?>"><?php echo $category->getTitle().' '.$category->getId().' '.$category->getLang()?></a>
		<div class="clear"></div>
		</div>
	
<?php endforeach;?>
<?php  //echo pager_navigation($categoryPager, url_for('event/addPage?place='. $categoryStr )) ?>	
<div class="clear"></div>
	
<?php else:
	echo __("We couldn't find a place beginning with:") ." <b>". $categoryStr ."</b>!";
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
			data: {'list': values, 'cityId': cityId},
			beforeSend: function( ) {
				$('#ListList').html('loading...');
			  },
			success: function( data ) {
			  $('#ListList').html(data);
			}
		});
		return false;
	  })
		*/  

	  $("#item_list a").click(function() {
			var articleId = <?php echo $articleId ?>;
			var thisEl = $(this);
			var value = thisEl.attr('title');
			var eventId = thisEl.attr('id');

			$.ajax({
				url: '<?php echo url_for("article/addEventToArticle") ?>',
					data: {'articleId': articleId, 'eventId': eventId},
				beforeSend: function() {
					$(thisEl).addClass('notActive');
					$(thisEl).attr('onclick','').unbind('click').click(function() {return false });
					thisEl.parent().remove();
				},
				success: function(data, url) {
					$("#list_of_events").prepend(data);
					$('.form_list_wrap > div').tinyscrollbar();
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
