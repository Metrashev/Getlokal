<ul class="upcoming-event-list">
	<?php 
	foreach($events->getResults() as $event):
	include_partial("event/event",array('event'=>$event));
	endforeach;
	?>
</ul>
<div class="wrapper-pager">
	<div class="ajaxPager paging paging-number" style="clear: both;">
		<?php 
			$PagerData = myTools::getPager($events->getPage(), $events->getNbResults(),null,Event::COMPANY_EVENTS_PER_PAGE);
		?>
		<div class="pagerLeft">
			<?=$PagerData['pagerLeft']?>
		</div>
		<div class="pagerCenter">
			<?=$PagerData['pagerCenter']?>
		</div>
		<div class="pagerRight">
	    	<?=$PagerData['pagerRight']?>
	    </div>
	</div>
</div>

<script type="text/javascript">
	var event_target = '#company_events_container';
	var company_id = '<?=$company_id?>';
	var event_type = '<?=$type?>';
	$(event_target+" .pagerCenter a").click(function(e){
		var page = $(this).attr("value");
		$(event_target+" .pagerCenter a").removeClass("current");
		$(this).addClass("current");
		ajaxPaging(page,event_target,company_id,event_type);
	});

	$(event_target+" .pagerLeft a").click(function(e){
		var page = $(this).attr("value");
		$(event_target+" .pagerCenter a").removeClass("current");
		$(event_target+" #page-"+page).addClass("current");
		ajaxPaging(page,event_target,company_id,event_type);
	});

	$(event_target+" .pagerRight a").click(function(e){
		var page = $(this).attr("value");
		$(event_target+" .pagerCenter a").removeClass("current");
		$(event_target+" #page-"+page).addClass("current");
		ajaxPaging(page,event_target,company_id,event_type);
	});
		
</script>