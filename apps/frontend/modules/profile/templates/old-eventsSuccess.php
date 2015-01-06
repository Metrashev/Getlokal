<?php use_helper('Pagination');?>
<?php use_javascript('review.js') ?>

	<div class="content_in_full">
		<?php $my_events_url = ($is_current_user)?  url_for('profile/events?username='. $pageuser->getUsername().'&my=true') : url_for('profile/events?my=true')?>
		<?php $attending_events_url = ($is_current_user)?  url_for('profile/events?username='. $pageuser->getUsername().'&attending=true') : url_for('profile/events?attending=true')?>
		<h2>
			<span class="left"><?php echo __('Events'); ?></span>
			<?php echo link_to( __('My Events',null,'events'), $my_events_url, 'id="my_events" class="left button_pink button_profile_category"'); ?>
			<?php echo link_to( __('Attended Events',null,'events'), $attending_events_url, 'id="attending_events" class="left button_pink button_profile_category"'); ?>			
			<?php echo link_to( __('New Event',null,'events'), 'event/create', 'class="right button_pink button_profile_category"')?>
			<span class="clear"></span>
		</h2>
<?php if ($pager->getNbResults() == 0): ?>
	<p class="flash_error"><?php echo __('There are no events', null, 'events'); ?></p>
<?php else:?>
		<div class="profile_event_scroll">
			<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
			<div class="viewport">
				<ul class="overview event_pictures">
					<?php include_partial( 'events', array ('pager' => $pager,  'user' => $user, 'pageuser'=>$pageuser, 'is_current_user'=>$is_current_user ) );?>
				</ul>
			</div>
		</div>
<?php endif;?>
	</div>
	<div class="clear"></div>


<div class="clear"></div>
<script type="text/javascript">
  $(document).ready(function() {
      $('.pager a').click(function() {
          $.ajax({
              url: this.href,
              beforeSend: function( ) {
                $('.standard_tabs_in').html('<div class="review_list_wrap">loading...</div>');
              },
              success: function( data ) {
                $('.standard_tabs_in').html(data);
              }
          });
          return false;
      });

      <?php if ($sf_request->getParameter('my',false)): ?>
      		$("#my_events").addClass('button_clicked');
	  <?php elseif ($sf_request->getParameter('attending',false)): ?>
	  		$("#attending_events").addClass('button_clicked');
      <?php endif; ?>

      <?php if ($pager->getNbResults() > UserProfile::FRONTEND_REVIEWS_PER_TAB): ?>
		  $('.profile_event_scroll').tinyscrollbar({size:586});
		  
		  var page = 2;
		  var alreadyloading = false;
		  var max = <?php echo $pager->getNbResults(); ?>;
		  
	      $('.profile_event_scroll').bind("Scrolled", function(e, bottom, current_position) {	    		
	    	    if (bottom < 100) {
	                if (alreadyloading == false) {
	                    alreadyloading = true;
	                    if (max > $('.overview li.user_event').length) {
		                    var url = '';
							
							if ($('.button_clicked').length > 0)
	    	            		url = $('.button_clicked').attr('href') + '&page=' + page;
							else
								url = "<?php echo url_for('profile/events?username='. $pageuser->getUsername().'&page='); ?>" + page;
							
					    

		        	    	page = page + 1;
								
	    	                $.post(url, function(data) {
	        	                if (data.replace(/^\s+|\s+$/g, '') != '') 
	        	                {
		    	                	$('.profile_event_scroll .viewport ul').append(data);
		    	                    $('.profile_event_scroll').tinyscrollbar_update('relative');
		    	                    alreadyloading = false;
	        	                }
	    	                });
	                    }
	                }
	            }
	      });
      <?php else: ?>
      	$('.profile_event_scroll .overview').css({position: 'static', width: '925px'});
		$('.profile_event_scroll .viewport').css({height: 'auto', overflow: 'visible'});
		$('.profile_event_scroll .scrollbar').remove();
<?php endif; ?>
  })
</script>