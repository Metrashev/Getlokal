<?php $place_company = $place->getCompanyPage()->getCompany(); ?>

<li class="list-details-company-item" id="item_<?= $place->getId(); ?>">
	<div class="list-details-company-image"
		id="item_<?= $place->getId(); ?>">
		<a href="<?php echo url_for($place_company->getUri(ESC_RAW)) ?>">
		<?php echo image_tag($place->getCompanyPage()->getCompany()->getThumb(0),array('size'=>'150x100','alt'=>  $place->getCompanyPage()->getCompany()->getImage()? $place->getCompanyPage()->getCompany()->getImage()->getCaption():'' )); ?>
		</a>
	</div>
	<div class="list-details-company-desc">
		<h4>
			<a href="<?php echo url_for($place_company->getUri(ESC_RAW)) ?>"
				title="<?php echo $place_company->getCompanyTitle($culture) ?>"> <?php echo $place->getCompanyPage()->getCompany()->getCompanyTitle($culture) ?>
			</a>
		</h4>
		<div class="stars-holder big">
			<ul>
				<li class="gray-star"><i class="fa fa-star"></i>
				</li>
				<li class="gray-star"><i class="fa fa-star"></i>
				</li>
				<li class="gray-star"><i class="fa fa-star"></i>
				</li>
				<li class="gray-star"><i class="fa fa-star"></i>
				</li>
				<li class="gray-star"><i class="fa fa-star"></i>
				</li>
				<li>
					<p class="reviews-number">
						<?php echo format_number_choice('[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $place->getCompanyPage()->getCompany()->getNumberOfReviews()), $place->getCompanyPage()->getCompany()->getNumberOfReviews()); ?>
					</p>
				</li>
			</ul>
			<div class="top-list">
				<div class="hiding-holder" style="width: <?= $place->getCompanyPage()->getCompany()->getRating() ?>%;">
					<ul class="spans-holder">
						<li class="red-star"><i class="fa fa-star"></i>
						</li>
						<li class="red-star"><i class="fa fa-star"></i>
						</li>
						<li class="red-star"><i class="fa fa-star"></i>
						</li>
						<li class="red-star"><i class="fa fa-star"></i>
						</li>
						<li class="red-star"><i class="fa fa-star"></i>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<p class="places">
			<i class="fa fa-tags"></i>
			<?php echo link_to($place->getCompanyPage()->getCompany()->getClassification(), $place->getCompanyPage()->getCompany()->getClassificationUri(ESC_RAW),array('class'=>'category')) ?>
		</p>
		<p><?php echo $place->getCompanyPage()->getCompany()->getDisplayAddress(); ?></p>
		
		<!--  DELETE BUTTON  -->
		<a id="<?php echo $place->getId()?>" class="button_gray" href="javascript:void(0);"><?php echo __('Delete')?></a>
		<!-- END DELETE BUTTON -->
		
	</div> <!-- end list-details-company-desc --> <?php if ($review = $place_company->getReviews()->getFirst()): ?>
	<div class="list-details-review-writter">
		<?php if ($review->getUserProfile()): ?>
		<div class="list-details-wrap-img">
			<a href="#"> <?php echo image_tag($review->getUserProfile()->getThumb(),array('size'=>"50x50"))?>
				<!-- 					<img src="http://lorempixel.com/55/55/" alt=""> -->
			</a>
		</div>
		<?php endif;?>
		<div class="list-details-wrap-txt">
			<?php if ($review->getUserProfile()): ?>
			<a href="#"><h5>
					<?php echo $review->getUserProfile()->getLink(ESC_RAW) ?>
				</h5> </a>
			<?php endif; ?>
			<p>
				<?php echo strip_tags(truncate_text(html_entity_decode ($review->getText()), 100, '...', true)); ?>
			</p>
		</div>
	</div> <!-- end list-details-review --> <?php endif;?>
</li>

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