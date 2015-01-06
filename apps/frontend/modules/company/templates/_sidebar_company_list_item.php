<?php
	$company_title = $company->getCompanyTitle()
	?>
<li class="similar-place">
	<div class="similar-place-image">
		<?php echo link_to_company($company, array('image_size' => 2,'title'=>$company_title), array('size' => '110x75', 'alt' => $company_title)) ?>
	</div>
	<!-- similar-place-image -->

	<div class="similar-place-content">
		<h5>
			<?php echo link_to_company($company,array('title'=>$company_title)) ?>
		</h5>

		<div class="stars-holder small wrapper-stars-holder">
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
			</ul>
			<div class="top-list">
				<div class="hiding-holder" style="width: <?php echo $company->getRating() ?>%;">
					<ul class="spans-holder small">
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

		<p><?php echo format_number_choice('[0]No reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $company->getNumberOfReviews()), $company->getNumberOfReviews(), 'user'); ?></p>
	</div>
	<!-- similar-place-content -->
</li>
