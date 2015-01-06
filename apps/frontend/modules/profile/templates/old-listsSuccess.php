<?php use_helper('Pagination');?>
<?php //use_javascript('review.js') ?>
<?php if (count($pager->getNbResults())):?>
<div class="content_in_full">
	<h2><?php echo __('Lists'); ?></h2>
	<div class="profile_list_scroll">
		<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
		<div class="viewport">
			<ul class="overview">
				<?php include_partial( 'lists', array ('pager' => $pager,  'user' => $user, 'pageuser'=>$pageuser, 'is_current_user'=>$is_current_user ) );?>
			</ul>
		</div>
	</div>
</div>
<?php endif;?>

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
      
      	var loading = false;
        $(".close_form_report").click(function() {
            $(this).parent().parent().parent().html("");
        });
        
        $(".review_interaction a.report").click(function() {
            var element = $(this).parent().parent().find('.ajax');

            $.ajax({
                url: $(this).attr('data'),
                beforeSend: function() {
                  $(element).html('<img src="/images/gui/blue_loader.gif"/>');
                },
                success: function(data){
                  $(element).html(data);
                }
            });

            return false;
        });

      <?php if ($pager->getNbResults() > UserProfile::FRONTEND_REVIEWS_PER_TAB): ?>
		$('.profile_list_scroll').tinyscrollbar({size:586});
	
		var page = 2;
		var alreadyloading = false;
		var max = <?php echo $pager->getNbResults(); ?>;
		$('.profile_list_scroll').bind("Scrolled", function(e, bottom, current_position) {
		    if (bottom < 100) {
	            if (alreadyloading == false) {
	                alreadyloading = true;
	                if (max > $('.overview li.listing_content').length) {
		                var url = "<?php echo url_for('profile/lists?username='. $pageuser->getUsername().'&page='); ?>" + page;
		            	

		        	    page = page + 1;
		        	    
		                $.post(url, function(data) {
			                if (data.replace(/^\s+|\s+$/g, '') != '')
			                {
			                	$('.profile_list_scroll .viewport ul').append(data);
			                    $('.profile_list_scroll').tinyscrollbar_update('relative');
			                    alreadyloading = false;
			                }
		                });
	                }
	            }
	        }
		});
	<?php else: ?>
		$('.profile_list_scroll .overview').css({position: 'static', width: '925px'});
		$('.profile_list_scroll .viewport').css({height: 'auto', overflow: 'visible'});
		$('.profile_list_scroll .scrollbar').remove();
	<?php endif; ?>
  });
</script>