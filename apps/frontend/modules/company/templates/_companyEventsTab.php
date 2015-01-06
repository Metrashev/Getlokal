<div class="tab-utilities">
	<?php 
		$type = sfContext::getInstance()->getRequest()->getParameter("type","events_incoming");
		$incoming_class = $type == "events_incoming" ? "class='current'" : "";	
		$past_class = $type == "events_past" ? "class='current'" : "";	
	?>
	<ul class="tab-list" id="events_tabs">
		<li <?= $incoming_class?> id="events_incoming"><a href="javascript:void(0)" onclick="ajaxPaging(1,'#company_events_container','<?= $company_id?>','events_incoming');setCurrent('events_incoming')"><?php echo __('Incoming events', null, 'events'); ?></a>
		</li>
		<li<?= $past_class?> id="events_past"><a href="javascript:void(0)" onclick="ajaxPaging(1,'#company_events_container','<?= $company_id?>','events_past');setCurrent('events_past')"><?php echo __('Past Events', null, 'events'); ?></a>
		</li>
	</ul>
	<!-- tab-list -->
</div>
<!-- tab-utilities -->

<div class="upcoming-events-list" id="company_events_container">
	<ul class="upcoming-event-list">
		<?php 
		include_partial('companyEventsList',array('events'=>$events,'company_id'=>$company_id,'type'=>$type))
		?>
	</ul>
</div>
<script type="text/javascript">
	function setCurrent(type){
		$("#events_tabs li").removeClass("current");
		$("#"+type).addClass("current");
	}
</script>