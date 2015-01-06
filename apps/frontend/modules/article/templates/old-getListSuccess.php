<?php use_helper('Pagination');?>
<div>
<?php
$lists = $listPager;
if(count($lists) > 0):
	foreach($lists as $list):
?>
		<div style="margin-top: 14px">
			<a title="<?php echo $list->getTitle()?>" id="<?php echo $list->getId() ?>" class="button_pink" href="javascript:void(0);"><?php echo __('Add',null,'company' )?></a>
			<a href="javascript:void(0);" title="<?php echo $list->getTitle()?>" id="<?php echo $list->getId() ?>"><?php echo $list->getTitle()?></a>
		<div class="clear"></div>
		</div>
	
<?php endforeach;?>
<?php  //echo pager_navigation($listPager, url_for('event/addPage?place='. $listStr )) ?>	
<div class="clear"></div>
	
<?php else:
	echo __("We couldn't find a place beginning with:") ." <b>". $listStr ."</b>!";
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
			var listId = thisEl.attr('id');

			$.ajax({
				url: '<?php echo url_for("article/addListToArticle") ?>',
					data: {'articleId': articleId, 'listId': listId},
				beforeSend: function() {
					$(thisEl).addClass('notActive');
					$(thisEl).attr('onclick','').unbind('click').click(function() {return false });
					thisEl.parent().remove();
				},
				success: function(data, url) {
					$("#list_of_lists").prepend(data);
					$('.form_list_wrap > div').tinyscrollbar();
					if ($('#list_of_lists').parent().outerHeight() > $('#list_of_lists').parent().parent().outerHeight())
						$('#list_of_lists').parent().width(181);
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
