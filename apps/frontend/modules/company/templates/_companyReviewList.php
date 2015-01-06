<ul class="user-comment">
	<?php 
		$reviewsList = $reviews->getResults();
		foreach ($reviewsList as $review){
			include_partial('companyReviewListItem', array('review' => $review, 'user'=>$user));
		}	
		
	?>
</ul>
<div class="wrapper-pager">
	<div class="ajaxPager paging paging-number" style="clear: both;">
		<?php 
			$PagerData = myTools::getPager($reviews->getPage(), $reviews->getNbResults(),null,Review::FRONTEND_REVIEWS_PER_TAB); 
		?>
		<div class="pagerLeft">
			<?=$PagerData['pagerLeft']?>
		</div>
		<div class="pagerCenter">
			<?=$PagerData['pagerCenter']?>
		</div>
		<div class="pagerRight">
	    	<?=$PagerData['pagerRight']?>
	    </div>
	</div>
</div>
<script type="text/javascript">
	var review_target = '#company_review_container';
	var company_id = '<?=$company_id?>';
	var review_type = 'reviews';
	
	$(review_target+" .pagerCenter a").click(function(e){
		var page = $(this).attr("value");
		$(review_target+" .pagerCenter a").removeClass("current");
		$(this).addClass("current");
		ajaxPaging(page,review_target,company_id,review_type);
	});

	$(review_target+" .pagerLeft a").click(function(e){
		var page = $(this).attr("value");
		$(review_target+" .pagerCenter a").removeClass("current");
		$(review_target+" #page-"+page).addClass("current");
		ajaxPaging(page,review_target,company_id,review_type);
	});

	$(review_target+" .pagerRight a").click(function(e){
		var page = $(this).attr("value");
		$(review_target+" .pagerCenter a").removeClass("current");
		$(review_target+" #page-"+page).addClass("current");
		ajaxPaging(page,review_target,company_id,review_type);
	});

	$('.report').click(function(e){
	      var href = $(this).attr('data');
	      
	      var element = $(this).parent().parent().children('.ajax');
	      element.stop(true, true).slideToggle();
	      loading = true;
	      $.ajax({
	          url: href,
	          beforeSend: function() {
	        	 $(element).html('');
	          },
	          success: function(data, url) {
	        	 element.html(data);
	            loading = false;
	            
	            //console.log(id);
	          },
	          error: function(e, xhr)
	          {
	            console.log(e);
	          }
	      });
	      return false;
    });
		
</script>