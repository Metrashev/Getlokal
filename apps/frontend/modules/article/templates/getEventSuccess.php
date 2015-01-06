<?php use_helper('Pagination');?>
<div>
<?php
$events = $eventPager;
if(count($events) > 0):
	foreach($events as $event):
?>
		<div style="margin-top: 14px">
			<a title="<?php echo $event->getTitle()?>" id="<?php echo $event->getId() ?>" class="button_pink" href="javascript:void(0);"><?php echo __('Add',null,'company' )?></a>
			<a href="javascript:void(0);" title="<?php echo $event->getTitle()?>" id="<?php echo $event->getId() ?>"><?php echo $event->getTitle()?></a>
		<div class="clear"></div>
		</div>
	
<?php endforeach;?>
<div class="clear"></div>
	
<?php else:
	echo __("We couldn't find a place beginning with:") ." <b>". $eventStr ."</b>!";
	endif; ?>
</div>
<script type="text/javascript">
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
					if ($('#list_of_events').parent().outerHeight() > $('#list_of_events').parent().parent().outerHeight())
						$('#list_of_events').parent().width(181);
			    },
			    error: function(e, xhr)
			    {
			        console.log(xhr);
			    }
			});
			
			return false;
		});
</script>
