<div class="upcoming-events-list">
	<ul>
		
			<p class="not-found-events-results">
			<?php 
				if(count($events) == 0){
					echo __("Sorry, we don't have any events just yet. Please help us by posting the events you know about and sharing them with us. Thank you!", null, 'events');
				}

				foreach($events as $k=>$event){
					if($k == 3 && ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO)){?>
							<div class="col-sm-12">
								<div class="default-container">
									<div class="content">
										<?php include_partial('global/ads', array('type' => 'event_native')) ?>
									</div>
									<!-- END content -->
								</div>
							</div>
					<?php }
					include_partial("event/event",array('event'=>$event));
				}
				?>
			</p>
		
	</ul>
	<div class="wrapper-pager">
		<div class="ajaxPager paging paging-number" style="clear: both;">
			<?php $PagerData = myTools::getPager($currentPage, $eventscount); ?>
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
</div>

<script type="text/javascript">
	<!--
	$(".pagerCenter a").click(function(e){
		var id = $(this).attr("value");
		$(".pagerCenter a").removeClass("current");
		$(this).addClass("current");
		listEvents();
	});

	$(".pagerLeft a").click(function(e){
		var id = $(this).attr("value");
		$(".pagerCenter a").removeClass("current");
		$("#page-"+id).addClass("current");
		listEvents();
	});

	$(".pagerRight a").click(function(e){
		var id = $(this).attr("value");
		$(".pagerCenter a").removeClass("current");
		$("#page-"+id).addClass("current");
		listEvents();
	});
	//-->
</script>
