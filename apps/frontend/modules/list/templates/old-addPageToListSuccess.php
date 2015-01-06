<?php 
		//$placeTitle = $place->getCompanyPage()->getCompany()->getCompanyTitle($culture);
		//$placeAddress = $place->getCompanyPage()->getCompany()->getDisplayAddress();// .', '. $company->getLocationName();
		//$sPlaceText = $placeTitle .' - '. $placeAddress;
?>
<div id="item_<?php echo $place->getId(); ?>" class="listing_place">
		<a class="listing_place_img" href="#">
			<img class="list_movable" src="/images/gui/list_move.png" />
		<?php 	echo image_tag($place->getCompanyPage()->getCompany()->getThumb(0),array('size'=>'100x100','alt'=>  $place->getCompanyPage()->getCompany()->getImage()? $place->getCompanyPage()->getCompany()->getImage()->getCaption():'' )); ?>
		</a>
		<div class="listing_place_in">
			<a href="<?php echo url_for($place->getCompanyPage()->getCompany()->getUri(ESC_RAW)) ?>" title="<?php echo $place->getCompanyPage()->getCompany()->getCompanyTitle($culture) ?>" class="pink">
                <?php echo $place->getCompanyPage()->getCompany()->getCompanyTitle($culture) ?>
            </a>
            
            <div class="listing_place_rateing">
					<div class="listing_place_rateing">
						<div class="rateing_stars">
					        <div style="width: <?php echo $place->getCompanyPage()->getCompany()->getRating() ?>%;" class="rateing_stars_orange"></div>
					    </div>
					    
						<span><?php echo format_number_choice('[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $place->getCompanyPage()->getCompany()->getNumberOfReviews()), $place->getCompanyPage()->getCompany()->getNumberOfReviews()); ?></span>
						<br/>
					
					</div>
				</div>
				
            
			<?php echo link_to($place->getCompanyPage()->getCompany()->getClassification(), $place->getCompanyPage()->getCompany()->getClassificationUri(ESC_RAW),array('class'=>'category')) ?>
			<p><?php echo $place->getCompanyPage()->getCompany()->getDisplayAddress(); ?></p>
		
			<a id="<?php echo $place->getId()?>" class="button_gray" href="javascript:void(0);"><?php echo __('Delete')?></a>
			
				<?php if(!$is_place_admin_logged):?>
					<!-- <a class="button_pink">Add a tip</a> -->
					<a class="tipec button_pink" href="<?php echo url_for('list/review?place_id='.$place->getCompanyPage()->getCompany()->getId().'&list_id='.$listId )?>"><?php echo __('Write a Review') ?></a>
				<?php endif;?>
				
				<br/>
				<div class="desc_full">
					<div>
					<?php if ( $place->getCompanyPage()->getCompany()->getReviews()->getFirst() ):?>
						<span class="user"><?php echo $place->getCompanyPage()->getCompany()->getReviews()->getFirst()->getUserProfile()->getLink(ESC_RAW) ?></span> <?php echo '>>' ?>
						<?php echo $place->getCompanyPage()->getCompany()->getReviews()->getFirst()->getText() ?>
				    	<div class="clear"></div>
					<?php /*elseif ( $place->getCompanyPage()->getCompany()->getTopReview()->getId() ): ?>
						<span class="user"><?php echo $place->getCompanyPage()->getCompany()->getTopReview()->getUserProfile()->getLink(ESC_RAW) ?></span> <?php echo '>>>' ?>
						<?php echo $place->getCompanyPage()->getCompany()->getTopReview()->getText() ?>
				    	<div class="clear"></div>
				    <?php */endif;?>
				    </div>
				    <a href="javascript:void(0)" class="hide_full_desc"><?php echo __('hide',null,'messages')?></a>
				    <a href="javascript:void(0)" class="read_full_desc"><?php echo __('read more...',null,'messages')?></a>
				</div>
			
			<div class="clear"></div>
			
			<div class="list_review_box"></div>
		
		</div>
					
		<div class="clear"></div>
	</div>
	<script type="text/javascript">
	
$(document).ready(function() {	
	$("#list_of_places a.button_gray").click(function() {
			var listPageId = $(this).attr('id');
			//var value = $(this).attr('title');
			var thisEl = $(this);
			var row = $(this).parent();
			

			$.ajax({
				url: '<?php echo url_for("list/delPageFromList") ?>',
					data: {'listPageId': listPageId},
				success: function(data, url) {
					$(row).parent().remove();
					console.log('success');
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