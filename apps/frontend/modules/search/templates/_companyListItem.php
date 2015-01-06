<?php 
	/*	 
	 * $dataType is what kind of object is the company object and what needs to be done do be converted (with myTools::companyConvertor) for the template
	 * */
	if(!isset($dataType) || is_null($dataType)){
		$dataType = 1;	
	}
	if(!isset($isHomePage)){
		$isHomePage = 0;
	}
	$companyConverted = myTools::companyConvertor( $company, $dataType, $sf_user->getCulture(), null, $company->getCompanyTitle() );	
?>
		<li class="place<?=(!$companyConverted['is_ppp']) ? '' : ' place-standart'; ?>">
			<div class="place-image place-image-premium">
				<?=$companyConverted['link-image']?>
			</div><!-- place-image -->
		
			<div class="place-content">
				<h4 class="place-title"><?=$companyConverted['link-title']?></h4>
					
				<div class="stars-holder <?=(!$companyConverted['is_ppp']) ? 'small' : 'bigger'; ?>">					
					<ul>
						<li class="gray-star"><i class="fa fa-star"></i></li>
						<li class="gray-star"><i class="fa fa-star"></i></li>
						<li class="gray-star"><i class="fa fa-star"></i></li>
						<li class="gray-star"><i class="fa fa-star"></i></li>
						<li class="gray-star"><i class="fa fa-star"></i></li>
						<li><p class="reviews-number">
							<?php echo format_number_choice('[0]<span>0</span> reviews|[1]<span>1</span> review|(1,+Inf]<span>%count%</span> reviews', array('%count%' => $companyConverted['numberOfReviews']), $companyConverted['numberOfReviews'], 'company'); ?>
							</p></li>
					</ul>
					<div class="top-list">
						<div class="hiding-holder" style="width: <?=$companyConverted['percent_rating']?>%;">
							<ul class="spans-holder">
								<li class="red-star"><i class="fa fa-star"></i></li>
								<li class="red-star"><i class="fa fa-star"></i></li>
								<li class="red-star"><i class="fa fa-star"></i></li>
								<li class="red-star"><i class="fa fa-star"></i></li>
								<li class="red-star"><i class="fa fa-star"></i></li>
							</ul>
						</div>
					</div>
				</div>				
				
				<p class="places"><i class="fa fa-tags"></i><?=$companyConverted['link-classification']?></p>
									
				<ul class="options">
					<?php if($companyConverted['link-events'] != ''){ ?>
						<li class="dark-blue"><a href="<?=$companyConverted['link-events']?>"><i class="fa fa-smile-o"></i><?php echo __('Events', null, 'events'); ?></a></li>
					<?php } ?>
					<?php if($companyConverted['link-offers'] != ''){ ?>
						<li class="dark-blue"><a><?php echo __('GetVoucher', null, 'offer'); ?></a></li>
					<?php } ?>
				</ul><!-- options -->
			</div><!-- place-content -->
	<?php if($companyConverted['is_ppp'] && !$isHomePage && $companyConverted['hasReviews']){ ?>
			<div class="review-writter">
				<div class="writter-image">
					<a href="#"><?=$companyConverted['review-user-img']?></a>
				</div><!-- writter-image -->

				<div class="writter-content">
					<strong><?=$companyConverted['review_user_name']?></strong>
					<span class="comment-txt"><?=truncate_text($companyConverted['review_text'], 200, '...', true);?></span>
				</div><!-- writter-content -->
			</div><!-- review-writter -->
	<?php } ?>
		<div id="overlay_<?php echo $companyConverted['id']?>" class="hidden">
			<div style="background-color:#fff;width:100px;">
			<?php echo html_entity_decode($companyConverted['overlay'])?>
			</div>
		</div>
		</li>