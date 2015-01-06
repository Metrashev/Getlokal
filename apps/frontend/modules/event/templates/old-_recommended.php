<?php use_helper('Pagination'); ?> 
<?php
$events = $pager->getResults();
$eventscount = $pager->getNbResults();
?>
<?php if ( !$eventscount): ?>
	<p><?php echo __("Sorry, we don't have any events just yet. Please help us by posting the events you know about and sharing them with us. Thank you!", null, 'events'); ?></p>
	<?php if($selected_tab == "active"):?>
	<script type='text/javascript'>
		$(document).ready(function(){$("#future-events").trigger("click");})
	</script>
	<?php endif;?>
<?php else: ?>
	<ul class="event_pictures">
		<?php foreach ($events as $event):?>
		<li>
				<?php include_partial('event/event',array('event'=>$event,'city'=>$city));?>
		</li>
		<?php endforeach;?>
	</ul>
	<div class="clear"></div>
	
<?php endif; ?>

<?php 
//$url = url_for('@event');
//$url = url_for('@event');
//if ($tickets) $url = url_for('event',array('tickets'=>'1') );
?>
<div class="standard_tabs_in_footer">
	<?php 
		if(!isset($is_component)){
			$is_component = 0;
		}
		echo ajax_pager_navigation($pager, $sf_request->getUri(),$is_component); 
	?>
</div>


<!--Recommendations-->
<?php /* 
            <?php if ($eventscount == 0): ?>
                <p>
                    <?php echo __("Sorry, we don't have any events just yet. Please help us by posting the events you know about and sharing them with us. Thank you!", null, 'events'); ?>
                </p>
            <?php else: ?>
                <div class="list_event_wrap">
                    <?php foreach ($events as $event): ?>           
                        <?php include_partial('event/event', array('event' => $event)); ?>
                    <?php endforeach; ?>
                </div>   
                <div class="clear"></div>
                <?php echo pager_navigation($pager, $sf_request->getUri()); ?>
            <?php endif; ?>
*/?>