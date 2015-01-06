<?php slot('description') ?>
<?php echo sprintf(__('See information for %s and all their reviews in getlokal!', null, 'pagetitle'),  $pageuser->getName());?> 
  <?php end_slot() ?>

<?php //include_javascripts('review.js') ?>

<?php if ($pager->getNbResults() > 0):?>
<div class="content_in_full">
	<h2><?php echo __('Articles');?></h2>
	<div class="profile_article_scroll">
		<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
		<div class="viewport">
			<ul class="overview">
				  <?php include_partial('articles', array ('pager' => $pager,  'user' => $user, 'is_current_user'=>$is_current_user))?>
			</ul>
		</div>
	</div>
<div class="clear"></div>
</div>
<?php endif;?>
<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function() {
	$('.banner').css('display', 'none');
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
		$('.profile_article_scroll').tinyscrollbar({size:586});

		var page = 2;
		var alreadyloading = false;
    	var max = <?php echo $pager->getNbResults(); ?>;
		$('.profile_article_scroll').bind("Scrolled", function(e, bottom, current_position) {
		    if (bottom < 100) {
	            if (alreadyloading == false) {
	                alreadyloading = true;

	                if (max > $('.overview li.article_item').length) {
		                var url = "<?php echo url_for('profile/articles?username='. $pageuser->getUsername().'&page='); ?>" + page;
		            	

		        	    page = page + 1;
		        	    
		                $.post(url, function(data) {
			                if (data.replace(/^\s+|\s+$/g, '') != '')
			                {
			                	$('.profile_article_scroll .viewport ul').append(data);
			                    $('.profile_article_scroll').tinyscrollbar_update('relative');
			                    alreadyloading = false;
			                }
		                });
	                }
	            }
	        }
		});

	<?php else: ?>
		$('.profile_article_scroll .overview').css({position: 'static', width: '925px'});
		$('.profile_article_scroll .viewport').css({height: 'auto', overflow: 'visible'});
		$('.profile_article_scroll .scrollbar').remove();
	<?php endif; ?>

	$('.article_item a').live('mouseenter', function() {
		$(this).parent().children('.tooltip_body2').fadeIn(100);
	});
	$('.article_item a').live('mouseleave', function() {
		$(this).parent().children('.tooltip_body2').fadeOut(100);
	});
});
</script>