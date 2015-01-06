<?php use_helper('Date')?>
<?php $culture = $sf_user->getCulture();?>
<?php if (count($events)): ?>
<div class="section-events">
	<div class="events-title">
		<?php echo sprintf(__('RECOMMENDATIONS FOR EVENTS IN %s', null, 'events'), "<span>".$city."</span>"); ?>
	</div>
	<span class="visit-more"> <?php echo __('Choose to see', null, 'events'); ?>
		<a href="<?=url_for('@event?selected_tab=active')?>"><?=__("Today's events", null, 'events') ?></a> , <a href="<?=url_for('@event?selected_tab=future')?>"><?=__('Future Events', null, 'events')?></a> <?php echo __('or'); ?> <a href="<?=url_for('@event?selected_tab=past')?>"><?=__('Past Events', null, 'events')?></a>
	</span>


	<div class="events-content">
		<div id="carousel">
			<div class="upcoming-events-list">
				<ul>
					<?php 
					foreach($events as $event):
						include_partial("event/event",array('event'=>$event));
					endforeach;
					?>
				</ul>
			</div>
			<div class="clearfix"></div>
			<a id="prev_slider" class="prev_slider" href="javascript:void(0)">
				<i class="fa fa-chevron-left fa-2x"></i> 
			</a>
			<a id="next_slider" class="next_slider" href="javascript:void(0)">
				<i class="fa fa-chevron-right fa-2x"></i> 
			</a>
		</div>
		<div id="pager" class="pager"></div>
	</div>
</div>
<?php endif; // count events?>