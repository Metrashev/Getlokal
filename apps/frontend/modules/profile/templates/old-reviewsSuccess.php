<?php slot('description') ?>
<?php echo sprintf(__('See information for %s and all their reviews in getlokal!', null, 'pagetitle'),  $pageuser->getName());?> 
  <?php end_slot() ?>

<?php //include_javascripts('review.js') ?>
<?php include_partial('review/reviewJs');?>
<?php use_stylesheet('jquery.rating.css');?>

<div class="content_in_full">
	<h2><?php echo __('Reviews');?></h2>
	<div class="review_list_wrap">
	    <p><?php echo format_number_choice('[0]No reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $pager->getNbResults()), $pager->getNbResults(),'user'); ?></p>
	<div class="review_edit_success"></div>  
	
	<?php if ($pager->getNbResults() > 0): ?>
		<div class="profile_review_scroll">
			<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
			<div class="viewport">
				<ul class="overview">
				    <?php include_partial('reviews', array ('pager' => $pager,  'user' => $user, 'is_other_place_admin_logged'=>$is_other_place_admin_logged, 'page_admin' =>$page_admin ))?>
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
		$('.profile_review_scroll').tinyscrollbar({size:580});
	
		var page = 2;
		var alreadyloading = false;
		var max = <?php echo $pager->getNbResults(); ?>;
		$('.profile_review_scroll').bind("Scrolled", function(e, bottom, current_position) {
		    if (bottom < 100) {
	            if (alreadyloading == false) {
	                alreadyloading = true;
	                if (max > $('.overview li.user_review').length) {
		                var url = "<?php echo url_for('profile/reviews?username='. $pageuser->getUsername().'&page='); ?>" + page;
	
		            	
		        	    page = page + 1;

		                $.post(url, function(data) {
		                	if (data.replace(/^\s+|\s+$/g, '') != '')
			                {
			                	$('.profile_review_scroll .viewport ul').append(data);
			                    $('.profile_review_scroll').tinyscrollbar_update('relative');
			                    alreadyloading = false;
			                }
		                });
	                }
	            }
	        }
		});
	<?php else: ?>
		$('.profile_review_scroll .overview').css({position: 'static', width: '925px'});
		$('.profile_review_scroll .viewport').css({height: 'auto', overflow: 'visible'});
		$('.profile_review_scroll .scrollbar').remove();
	<?php endif; ?>
});
</script>