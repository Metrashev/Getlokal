
<div class="content_in_full">
	<h2><?php echo __('Added Places', null, 'company');?></h2>
	<div class="places_list_wrap">
		<?php /*
	    <p><?php echo format_number_choice('[0]No places|[1]1 place|(1,+Inf]%count% places', array('%count%' => $pager->getNbResults()), $pager->getNbResults(),'user'); ?></p>
		*/ ?>
	<?php if ($pager->getNbResults() > 0): ?>
		<div class="profile_places_scroll">
			<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
			<div class="viewport">
				<ul class="overview">
				    <?php include_partial('places', array ('pager' => $pager,  'user' => $user))?>
		    	</ul>
		    </div>
		</div>
	<?php endif;?>
	</div>
	<div class="clear"></div>
</div>
<script type="text/javascript">
$(document).ready(function() {
      $('a.lightbox').fancybox({
  	    titlePosition: 'over',
  	    cyclic:        true
  	  });
  	  
  	  $('a.iframe').each(function(i,s) {
  	    $(s).fancybox({
  	      type  : 'iframe',
  	        width : 800,
  	        height: 600,
  	        href  : $(s).attr('href')+ '?modal=1'
  	    })
  	  });

    <?php if ($pager->getNbResults() > UserProfile::FRONTEND_REVIEWS_PER_TAB): ?>
		$('.profile_places_scroll').tinyscrollbar({size:580});
	
		var page = 2;
		var alreadyloading = false;
		var max = <?php echo $pager->getNbResults(); ?>;
		$('.profile_places_scroll').bind("Scrolled", function(e, bottom, current_position) {
		    if (bottom < 100) {
	            if (alreadyloading == false) {
	                alreadyloading = true;
	                if (max > $('.overview li.user_place').length) {
		                var url = "<?php echo url_for('profile/places?username='. $pageuser->getUsername().'&page='); ?>" + page;
	
		            	
		        	    page = page + 1;

		                $.post(url, function(data) {
		                	if (data.replace(/^\s+|\s+$/g, '') != '')
			                {
			                	$('.profile_places_scroll .viewport ul').append(data);
			                    $('.profile_places_scroll').tinyscrollbar_update('relative');
			                    alreadyloading = false;
			                }
		                });
	                }
	            }
	        }
		});
	<?php else: ?>
		$('.profile_places_scroll .overview').css({position: 'static', width: '925px'});
		$('.profile_places_scroll .viewport').css({height: 'auto', overflow: 'visible'});
		$('.profile_places_scroll .scrollbar').remove();
	<?php endif; ?>
});
</script>