<?php use_helper('Pagination'); ?>

<ul class="list-box-wrapper">
<?php foreach($pager->getResults() as $place){ ?>    

	<li class="list-box place">
		<div class="custom-row">
			<?php echo image_tag($place->getThumb(0), array('size' => '110x73', 'alt' => $place->getCompanyTitle(), 'class' => 'profile-img')) ?>
			<div class="info">
				<?php echo link_to($place->getCompanyTitle(), $place->getUri(ESC_RAW), array('target' => '_blank', 'class' => 'name')) ?>
				<div class="stars-holder bigger">					
					<ul>
						<li class="gray-star"><i class="fa fa-star"></i></li>
						<li class="gray-star"><i class="fa fa-star"></i></li>
						<li class="gray-star"><i class="fa fa-star"></i></li>
						<li class="gray-star"><i class="fa fa-star"></i></li>
						<li class="gray-star"><i class="fa fa-star"></i></li>
						<li>
							<p class="reviews-number">
								<?php echo format_number_choice('[0]<span>0</span> reviews|[1]<span>1</span> review|(1,+Inf]<span>%count%</span> reviews', array('%count%' => $place->getNumberOfReviews()), $place->getNumberOfReviews(), 'company'); ?>
							</p>
						</li>
					</ul>
					<div class="top-list">
						<div class="hiding-holder" style="width: <?php echo $place->getRating() ?>%;">
							<ul class="spans-holder">
								<li class="red-star"><i class="fa fa-star"></i></li>
								<li class="red-star"><i class="fa fa-star"></i></li>
								<li class="red-star"><i class="fa fa-star"></i></li>
								<li class="red-star"><i class="fa fa-star"></i></li>
								<li class="red-star"><i class="fa fa-star"></i></li>
							</ul>
						</div>
					</div>
				</div><!-- rating stars -->
				<div class="tag"><i class="fa fa-tags"></i><?php echo $place->getClassification() ?></div>
			</div>
		</div>
	</li><!-- END Place -->

<?php }?>
</ul>

<?php echo pager_navigation($pager, url_for('profile/places?username='. $pageuser->getUsername())); ?>