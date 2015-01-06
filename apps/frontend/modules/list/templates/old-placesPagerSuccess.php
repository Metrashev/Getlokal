<?php use_helper('Pagination');?>
<?php $culture =$sf_user->getCulture(); ?>
<div class="list_of_places" id="list_of_places">
<?php $placeUser=false;
	foreach ($pager->getResults() as $place):
		if ($user && $user->getId() == $place->getUserId()) $placeUser=true;
		?> 
		<div class="listing_place" id="item_<?php echo $place->getId(); ?>">
			<a class="listing_place_img" href="#">
			<?php 	echo image_tag($place->getCompanyPage()->getCompany()->getThumb(0),array('size'=>'100x100','alt'=>  $place->getCompanyPage()->getCompany()->getImage()? $place->getCompanyPage()->getCompany()->getImage()->getCaption():'' )); ?>
			</a>
			<div class="listing_place_in">
				<div class="listing_place_rateing">
					<div class="listing_place_rateing">
						<div class="rateing_stars">
					        <div style="width: <?php echo $place->getCompanyPage()->getCompany()->getRating() ?>%;" class="rateing_stars_orange"></div>
					    </div>
					    
						<span><?php echo format_number_choice('[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $place->getCompanyPage()->getCompany()->getNumberOfReviews()), $place->getCompanyPage()->getCompany()->getNumberOfReviews()); ?></span>
						<br/>
					
					</div>
				</div>
			
			
				<a href="<?php echo url_for($place->getCompanyPage()->getCompany()->getUri(ESC_RAW)) ?>" title="<?php echo $place->getCompanyPage()->getCompany()->getCompanyTitle($culture) ?>" class="pink">
                	<?php echo $place->getCompanyPage()->getCompany()->getCompanyTitle($culture) ?>
              	</a>
              	
				<?php echo link_to($place->getCompanyPage()->getCompany()->getClassification(), $place->getCompanyPage()->getCompany()->getClassificationUri(ESC_RAW),array('class'=>'category')) ?>
				
				<p><?php echo $place->getCompanyPage()->getCompany()->getDisplayAddress(); ?></p>
				
				<?php if ( $user && ( $user->getId() == $place->getUserId() || $user->getId() == $listUserId ) ):?>
					<a id="<?php echo $place->getId()?>" class="button_gray" href="javascript:void(0);"><?php echo __('Delete')?></a>
				<?php endif;?>
				
				<?php if(!$is_place_admin_logged):?>
					<a class="tipec button_pink" href="javascript:void(0);" onClick="_gaq.push(['_trackEvent', 'Review', 'Write', 'list']);" data="<?php echo url_for('list/review?place_id='.$place->getCompanyPage()->getCompany()->getId().'&list_id='.$listId )?>"><?php echo __('Write a Review') ?></a>
				<?php endif;?>
				<div class="clear"></div>
				<div class="list_review_box"></div>
				<div class="desc_full">
					<div>
					<?php if ( $place->getCompanyPage()->getCompany()->getReview()->getLast() ):?>
						<span class="user"><?php echo $place->getCompanyPage()->getCompany()->getReview()->getLast()->getUserProfile()->getLink(ESC_RAW) ?></span> <?php echo '>>' ?>
						<?php echo $place->getCompanyPage()->getCompany()->getReview()->getLast()->getText() ?>
				    	<div class="clear"></div>
					<?php elseif ( $place->getCompanyPage()->getCompany()->getTopReview() ):?>
						<span class="user"><?php echo $place->getCompanyPage()->getCompany()->getTopReview()->getUserProfile()->getLink(ESC_RAW) ?></span> <?php echo '>>' ?>
						<?php echo $place->getCompanyPage()->getCompany()->getTopReview()->getText() ?>
				    	<div class="clear"></div>
				    <?php endif;?>
				    </div>
				    <a href="javascript:void(0)" class="hide_full_desc"><?php echo __('hide',null,'messages')?></a>
				    <a href="javascript:void(0)" class="read_full_desc"><?php echo __('read more...',null,'messages')?></a>
				</div>
			</div>
			<div class="clear"></div>
			<?php /*
			<p>Created by <a href="#" class="place"><?php echo $place->getUserProfile()->getLink(ESC_RAW) ?></a></p>
			*/ ?>
			<div class="ajax"></div>
		</div>
		<?php 
	endforeach;
	?>
	<div class="clear"></div>
	<!-- PESHO PLEASE ADD 
	<div class="pager_combined">
		<div class="pager_item_count">
			Per Page: 
			<select id="n_pages">
				<option value="10" >10</option>
				<option value="20">20</option>
				<option value="30">30</option>
				<option value="40">40</option>
			</select>
		</div>
	 -->
	 <div id="places_pager">
	<?php echo pager_navigation($pager, 'list/placesPager?id='.$listId.'&listUserId='.$listUserId  )?>
	</div>
	<!-- PESHO PLEASE ADD  
		<div class="clear"></div>
	</div>
	  -->
	
<?php if ( $user && ( $placeUser || $user->getId() == $listUserId ) ):?>	
	<script type="text/javascript">
	
$(document).ready(function() {	
	$("#list_of_places a.button_gray").click(function() {
			var listPageId = $(this).attr('id');
			//var value = $(this).attr('title');
			var thisEl = $(this);
			var row = $(this).parent().parent();
			

			$.ajax({
				url: '<?php echo url_for("list/delPageFromList") ?>',
					data: {'listPageId': listPageId},
				success: function(data, url) {
					$(row).remove();
					$('#spanPlaceCount').text(parseInt($('#spanPlaceCount').text())-1);
					//console.log('success');
			    },
			    error: function(e, xhr)
			    {
			        console.log(xhr);
			    }
			});
			
			return false;
		})
		
})
</script>
<?php endif;?>
	<script type="text/javascript">
	
$(document).ready(function() {	
	  var loading= false;
	  $('.tipec').live('click', function() {
	      var element = this;
	      var href = $(this).attr('data');
	      if(loading) return false;
	      loading = true;
	      $(this).parent().find('.desc_full').css('display', 'none');
	      $('.listing_place_in .list_review_box').html('').css('display', 'none');
		  $(this).parent().children('.list_review_box').css('display', 'block');
	      $.ajax({
	          url: href,
	          beforeSend: function() {
	            $(element).parent().find('.list_review_box').html('loading...');
	          },
	          success: function(data, url) {
	            $(element).parent().find('.list_review_box').html(data);
	            $(element).parent().find('.list_review_box').children('.add_review').append('<a id="special_close" href="javascript:void(0);"></a>');
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
		  $('#places_pager a').click(function() {
	          $.ajax({
	              url: this.href,
	              beforeSend: function( ) {
	                $('#list_of_places').html('<div class="review_list_wrap">loading...</div>');
	              },
	              success: function( data ) {
	                $('#list_of_places').html(data);
	              }
	          });
	          return false;
	      });
		  $('#special_close').live('click', function() {
		      $(this).parent().parent().parent().children('.desc_full').css('display', 'block');
		      $(this).parent().parent().html('').css('display', 'none');
	      });
	   <?php /*?>   
		  $("#n_pages").change(function () { 
			  var np = $(this).val();
			  var uri = '<?php echo url_for("list/placesPager?id=".$listId."&listUserId=".$listUserId."&page=1&nPages=") ?>'

		      $.ajax({
	              url: uri+np,
	              beforeSend: function( ) {
	                $('#list_of_places').html('<div class="review_list_wrap">loading...</div>');
	              },
	              success: function( data ) {
	                $('#list_of_places').html(data);
	              }
	          });
	          return false;
	        });
	   <?php */ ?>
})
</script>
</div>