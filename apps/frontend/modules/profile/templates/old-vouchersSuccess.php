<?php //include_partial($partial,  array('pageUser' => $pageUser, 'pager' => $pager, 'is_current_user' => $is_current_user));?>
<?php use_helper('Date', 'Pagination');?>
<?php 
$vouchers = $pager->getResults();
$vouchers_count = $pager->getNbResults();
?>
<div class="content_in_full">
<div class="review_list_wrap">
	<?php if ($pager->getNbResults() == 0): ?>
		<p><?php echo __('No vouchers have been ordered yet', null, 'offer') ?></p>
	<?php else:?>
	<div class="profile_review_scroll">
	<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
	<div class="viewport">
		<ul class="overview">
		 <?php include_partial('vouchers', array ('pager' => $pager,  'user' => $user ))?>
		</ul>
	    </div>
	</div>
	<?php endif;?>
</div>
	<div class="clear"></div>
</div>

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
  $('.edit').click(function() {
	var id = this.id;
	$.ajax({
		url: this.href,
		beforeSend: function() {
			$("#edit-"+id).html('loading...');
			$("#edit-"+id).toggle();
		},
		success: function(data, url) {
			$("#edit-"+id).html(data);
			//console.log(id);
	    },
	    error: function(e, xhr)
	    {
	        console.log(e);
	    }
	});
	return false;
  });
  $('.report').click(function() {
		var id = this.id;
		var href= $(this).attr('data');
		$.ajax({
			url: href,
			beforeSend: function() {
				$("#report-"+id).html('loading...');
				$("#report-"+id).toggle();
				//console.log(id);
			},
			success: function(data, url) {
				$("#report-"+id).html(data);
				//console.log(id);
		    },
		    error: function(e, xhr)
		    {
		        console.log(e);
		    }
		});
		return false;
	  });
    /* attach a submit handler to the form */


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
		                var url = "<?php echo url_for('profile/vouchers?username='. $pageuser->getUsername().'&page='); ?>" + page;
	
		            	
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


}) 
</script>