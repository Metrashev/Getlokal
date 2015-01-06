<?php use_helper('Pagination'); ?>

<div class="content_in_full">
	<?php 
		$my_events_url = ($is_current_user)?  url_for('profile/events?username='. $pageuser->getUsername().'&my=true') : url_for('profile/events?my=true');
		$attending_events_url = ($is_current_user)?  url_for('profile/events?username='. $pageuser->getUsername().'&attending=true') : url_for('profile/events?attending=true');
	?>
	
	<h2><?php echo __('Events'); ?></h2>
	<?php 
		echo link_to( __('My Events',null,'events'), $my_events_url, 'id="my_events" class="default-btn success"');
		echo link_to( __('Attended Events',null,'events'), $attending_events_url, 'id="attending_events" class="default-btn success attending-events-btn"');			
		echo link_to( __('New Event',null,'events'), 'event/create', 'class="default-btn pull-right"'); 
	?>
	
	<?php if ($pager->getNbResults() == 0){ ?>
		<p class="flash_error"><?php echo __('There are no events', null, 'events'); ?></p>
	<?php } else{ ?>

	<div class="upcoming-events-list" id="company_events_container">
		<ul class="upcoming-event-list">
	        <?php foreach ($pager->getResults() as $event){

	            $attending = ($event->getIsAttendedByUser($pageuser)) ? true : false;

	            if (!function_exists('format_date')) {
	                use_helper('Date');
	            }

	            $User = sfContext::getInstance()->getUser();
	            $culture = $User->getCulture();

	            $buy_url = $event->getBuyUrl();
	            $display_title = $event->getDisplayTitle();
	            $event_id = $event->getId();
	            $from_date = format_date($event->getStartAt(), 'dd MMM yyyy', $culture);
	            $category = $event->Category;
	            $city = $event->getCity();

	            $company = $event->EventPage[0]->CompanyPage->Company;
	        ?>

	            <li class="event-list-item <?php echo ($is_current_user && $event->getUserProfile()->getId() == $user->getId()) ? 'hover-events-list-item' : '' ?>">
	                <a href="<?= url_for('event/show?id=' . $event->getId()); ?>">
	                    <div class="upcoming-event-head">
	                        <?php echo '<h6>' . $display_title . '</h6>' ?>
	                        <?php echo '<h5>' . $company->Translation[$culture]['title'] . '</h5>'; ?>
	                    </div>

	                    <div class="upcoming-event-body">
	                        <?php
	                        if (!$event->getImage()) {
	                            $sector_id = 1;
	                            $image_path = "http://static.getlokal.com/images/gui/default_event_" . $sector_id . ".jpg";
	                            $caption = "";
	                        } elseif ($event->getImage()->getType() == 'poster') {
	                            $image_path = "http://static.getlokal.com/" . $event->getThumb('preview');
	                            $caption = $event->getImage()->getCaption();
	                        } else {
	                            $image_path = "http://static.getlokal.com/" . $event->getThumb(2);
	                            $caption = $event->getImage()->getCaption();
	                        }
	                        echo image_tag($image_path, array('raw_name' => true, 'size' => '101x135', 'alt' => $caption));
	                        if ($event->hasTickets()) {
	                            ?>
	                            <div class="available-tickets">
	                                <i class="fa fa-ticket"></i><?php echo __('Tickets Available', null, 'offer'); ?>
	                            </div>
	    					<?php } ?>
	                    </div><!-- event-body -->
						
						<div class="wrapper-hover-events-tabs">
		                    <div class="upcoming-event-foot">
		                        <div class="upcoming-section-date">
		                            <div class="upcoming-date"><?php echo __('from'); ?>: <span><?php echo $from_date ?></span></div>
		                            <div class="alignright"><span></span></div>
		                        </div><!-- section-date -->

		                        <div class="upcoming-section-place">
		                            <span><?php echo $city ?></span>	
		                        </div><!-- section-place -->

		                        <div class="upcoming-section-event-type">
		                            <div class="alignleft"><i class="fa fa-tag"></i><?php echo $category ?></div>
		                        </div><!-- section-event-type -->
		                    </div><!-- event-foot -->
		                    <div class="hover-btns-events-tabs">
		                        <a class="event_delete default-btn small delete delete-btn-profile" href="<?php echo url_for('profile/deleteEvent?event_id='.$event->getId() )?>"><i class="fa fa-long-arrow-right"></i><?php echo __('delete')?></a><br>
	                        	<a class="event_edit default-btn small edit-btn-profile" href="<?php echo url_for('event/edit?id='.$event->getId() )?>" onclick='setEditAttribute()'><i class="fa fa-long-arrow-right"></i><?php echo __('edit')?></a><br>
	                    	</div>
	                    </div>
	                    
	                </a>

                    <?php if ($is_current_user && $event->getUserProfile()->getId() == $user->getId()){ ?>
                      	<!-- <div class="hover-btns-events-tabs">
                      	                                   	<a class="event_delete default-btn small white report-btn" href="<?php echo url_for('profile/deleteEvent?event_id='.$event->getId() )?>"><i class="fa fa-long-arrow-right"></i><?php echo __('delete')?></a><br>
                      	                                   	<a class="event_edit default-btn small white report-view-btn" href="<?php echo url_for('event/edit?id='.$event->getId() )?>" onclick='setEditAttribute()'><i class="fa fa-long-arrow-right"></i><?php echo __('edit')?></a><br>
                      	           	                	</div>
                      	           	      -->           <?php }	?>
	            </li>
			<?php } ?>
	    </ul>
	</div>
	<?php } ?>
</div>

<?php echo pager_navigation($pager, url_for('profile/events?username='. $pageuser->getUsername())); ?>

<div id="dialog-confirm" title="<?php echo __('Deleting Event', null, 'messages') ?>" style="display:none;">
    <p><?php echo __('Are you sure you want to delete your event?', null, 'messages') ?></p>
</div>

<script type="text/javascript">
	$('a.event_delete').click(function(event) {
	  var deleleReviewLink = $(this).attr('href');
	    $("#dialog-confirm").data('id', deleleReviewLink).dialog('open');
	    return false;
	});

	$("#dialog-confirm").dialog({
	        resizable: false,
	        autoOpen: false,
	        height: 250,
	        width:340,
	        buttons: {
	            "<?php echo __('delete', null) ?>": function() {
	                 window.location.href =  $("#dialog-confirm").data('id');
	            },
	        <?php echo __('cancel', null, 'company') ?>: function() {
	          $(this).dialog("close");
	      }
	    }
	});
</script>