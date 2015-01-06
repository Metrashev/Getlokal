<div class="content_in_full">
	<h2><?php echo __('Photos');?></h2>
	<div class="user_photos photo_list_wrap review_list_wrap">
	<?php $picture_count = $pager->getNbResults();?>
	
	    <p><?php echo format_number_choice('[0]No uploaded photos yet.|[1]1 uploaded photo|(1,+Inf]%count% uploaded photos', array('%count%' => $picture_count), $picture_count,'messages'); ?>
	    </p>
	    <?php if($picture_count > 0 ): ?>
			<div class="profile_photo_scroll">
				<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
				<div class="viewport">
	   				<ul class="user_settings_gallery_list overview">
					 <?php include_partial('photos', array ('pager' => $pager,  'user' => $user, 'is_current_user'=>$is_current_user ))?>
					</ul>
				</div>
			</div>
		<?php endif ?>
		<div class="clear"></div>
	  
	  
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$('a.lightbox').fancybox({
		titlePosition: 'over',
		cyclic:        true
	});

	<?php if ($pager->getNbResults() > UserProfile::FRONTEND_PICTURES_PER_TAB): ?>
		$('.profile_photo_scroll').tinyscrollbar({size:586});
		
		var page = 2;
		var alreadyloading = false;
		var max = <?php echo $pager->getNbResults(); ?>;
		$('.profile_photo_scroll').bind("Scrolled", function(e, bottom, current_position) {
		    if (bottom < 100) {
	            if (alreadyloading == false) {
	                alreadyloading = true;
	                if (max > $('.overview li.current_picture').length) {
		                var url = "<?php echo url_for('profile/photos?username='. $pageuser->getUsername().'&page='); ?>" + page;
	
		            	<?php if ($is_current_user):?>
		        			url = url + "<?php echo '&username='. $pageuser->getUsername(); ?>"
		        	    <?php endif;?>

		        	    page = page + 1;
		        	    
		                $.post(url, function(data) {
			                if (data.replace(/^\s+|\s+$/g, '') != 's')
			                {
			                	$('.profile_photo_scroll .viewport ul').append(data);
			                    $('.profile_photo_scroll').tinyscrollbar_update('relative');
			                    alreadyloading = false;
			                    $('a.lightbox').fancybox({
			                		titlePosition: 'over',
			                		cyclic:        true
			                	});
			                }
		                });
	                }
	            }
	        }
		});
	<?php else: ?>
		$('.profile_photo_scroll .overview').css({position: 'static', width: '950px'});
		$('.profile_photo_scroll .viewport').css({height: 'auto', overflow: 'visible'});
		$('.profile_photo_scroll .scrollbar').remove();
	<?php endif; ?>
});
</script>