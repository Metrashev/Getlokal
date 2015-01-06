<div class="col-sm-12">
<?php use_helper('Date')?>
<?php if(count($events) == 0){ ?>
<div class="events_empty">
	<div class="events-title">
		<?php echo sprintf(__('RECOMMENDATIONS FOR EVENTS IN %s', null, 'events'), "<span>".$sf_user->getCity()->getDisplayCity()."</span>"); ?>
	</div><!-- events-title -->

	<div class="event-content-empty">
		<div class="empty-image">
			<img src="/css/images/cash.png" alt="">
		</div>
		<p><?php echo __("Sorry, we don't have any events just yet. Please help us by posting the events you know about and sharing them with us. Thank you!", null, 'events'); ?></p>
		<?php echo link_to('<i class="fa fa-plus"></i>' . __('Add Event', null, 'events'), 'event/create', array('title' => __('Event'), 'class' => 'empty-button', 'target' => '_blank')); ?>
	</div><!-- event-content-empty -->
</div><!-- events_empty -->

<?php } else{ ?>
<div class="section-events">
	<div class="events-title">
		<?php echo sprintf(__('RECOMMENDATIONS FOR EVENTS IN %s', null, 'events'), "<span>".$sf_user->getCity()->getDisplayCity()."</span>"); ?>
	</div>
	<div class="events-content event-list-content-small">
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
	</div>
</div>
<!-- events_wrapper -->
<?php } ?>
</div>
<style>
.events-content:after, .offers-content:after{
	height: 302px;
}
.events-content:before, .offers-content:before{
	height: 302px;
}
</style>