<?php 
	use_helper('Date');
	use_helper('TimeStamps');
?>
<li>
	<div class="comments">
		<div class="comment-image">
			<?php if (is_object($review->getUserProfile())):  ?>
	            <?=image_tag($review->getUserProfile()->getThumb(0), 'alt="'.$review->getUserProfile()->getFirstName().'" height="80px" width="80px"')?>
	        <?php else: ?>
	            <a	href="<?php echo url_for($company->getUri(ESC_RAW)) ?>" class="review_list_img"> <?php echo image_tag($company->getThumb(0), array('size' => '80x80', 'alt' => $company->getCompanyTitle())) ?></a>
	        <?php endif ?>
		</div><!-- comment-image -->
		
		<div class="comment-content">
			<div class="comment-content-head">
				<div class="name-rating">
					<h3><?php echo $review->getUserProfile()->getFirstName()." ".$review->getUserProfile()->getLastName()?></h3>
					<div class="stars-holder small">					
						<ul>
							<li class="gray-star"><i class="fa fa-star"></i></li>
							<li class="gray-star"><i class="fa fa-star"></i></li>
							<li class="gray-star"><i class="fa fa-star"></i></li>
							<li class="gray-star"><i class="fa fa-star"></i></li>
							<li class="gray-star"><i class="fa fa-star"></i></li>
						</ul>
						<div class="top-list">
							<div class="hiding-holder" style="width: <?php echo round($review->getRating() * 20)?>%;">
								<ul class="spans-holder small">
									<li class="red-star"><i class="fa fa-star"></i></li>
									<li class="red-star"><i class="fa fa-star"></i></li>
									<li class="red-star"><i class="fa fa-star"></i></li>
									<li class="red-star"><i class="fa fa-star"></i></li>
									<li class="red-star"><i class="fa fa-star"></i></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<p><?php echo ezDate(date('d.m.Y H:i', strtotime($review->getCreatedAt())));
				if (in_array($review->getReferer(), array('ios', 'android'))){
					echo '<i class="fa fa-mobile fa-2x"></i>';
				}
				?></p>
			</div><!-- comment-content-head -->
		
			<div class="comment-content-body">
				<p class="comment">
					<span class="comment-txt">
						<?php echo $review->getText()?>
					</span>
				</p><!-- comment -->
				
				<div class="vote-report">				
					<?php include_partial('like/like', array('object' => $review->getActivityReview()));
					if (!$user || ($review->getUserId() != $user->getId())){ ?> 
					<a id="<?php echo $review->getId() ?>" href="javascript:void(0);" data="<?php echo url_for('report/review?id=' . $review->getId()) ?>" class="report">
						<?php echo __('report') ?>
					</a>
		            <?php } ?>
				</div><!-- vote-report -->
				<div class="ajax"></div>
			</div><!-- comment-content-body -->
		</div><!-- comment-content -->
	</div><!-- comments -->
</li>