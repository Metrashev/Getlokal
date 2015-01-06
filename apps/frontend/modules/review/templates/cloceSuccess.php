<?php if ( !$review->getParentId() ) : ?>
	<div class="stars-holder small">                    
                <ul>
                    <li class="gray-star"><i class="fa fa-star"></i></li>
                    <li class="gray-star"><i class="fa fa-star"></i></li>
                    <li class="gray-star"><i class="fa fa-star"></i></li>
                    <li class="gray-star"><i class="fa fa-star"></i></li>
                    <li class="gray-star"><i class="fa fa-star"></i></li>
                </ul>
                <div class="top-list">
                    <div class="hiding-holder" style="width: <?php echo round($review->getRating() * 20) ?>%;">
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
	<p class="comment">	        	
        <?php
            if ($review->getUserId() == 5712) {
				echo simple_format_text_review(htmlspecialchars_decode($review->getText(ESC_RAW)));
			}
			else {
				echo simple_format_text_review(htmlspecialchars($review->getText(ESC_RAW)));
			}
		?>	            
    </p><!-- comment -->
    
    <div class="vote-report">
        <?php include_partial('like/like', array('object' => $review->getActivityReview())); ?>

        <?php if ($review->recommended_at) { ?>        
	    	<span class="review_list_top_review"><?php echo __('Top Review') ?></span>
        <?php } ?>
        
        <?php if (!$user || ($review->getUserId() != $user->getId())) { ?> 
        	 <a id="<?php echo $review->getId() ?>" href="javascript:void(0);" data="<?php echo url_for('report/review?id=' . $review->getId()) ?>" class="report">
        	 	<?php echo __('report') ?>
        	 </a>
        <?php } ?>
        <?php 
        	if ($user && $user->getId() != $review->getUserId()) {
            	if ($user_is_admin) { ?>
                	<a href="javascript:void(0);" data="<?php echo url_for('review/reply?review_id=' . $review->getId()) ?>" class="reply">
                		<?php echo __('reply') ?>
                	</a>
                <?php 
                	if (sfConfig::get('app_enable_messaging')) {
                    	$follower = Doctrine::getTable('FollowPage')->getFollowPage($review->getUserProfile()->getId(), $sf_user->getPageAdminUser()->getId());
                    	
                    	if ($follower) {
                        	if ($follower->getInternalNotification() && $company->getActivePPPService(true)) {
                            	echo link_to('Reply privately', 'message/compose?username=' . $review->getUserProfile()->getsfGuardUser()->getUsername());
                        	}
                     	}
                 	}
            	}
            	elseif ($user_is_company_admin) { ?>		
                	<a href="javascript:void(0);" data="<?php echo url_for('companySettings/login?slug=' . $company->getSlug() . '&login=true') ?>" class="reply_test">
                		<?php echo __('reply') ?>
                	</a>
        <?php 
				}
        	}
        	
        	if (!isset($review_user) && $user && $user->getId() == $review->getUserId()) {
            	echo link_to(__('delete'), 'profile/deleteReview?review_id=' . $review->getId(), array('class' => 'delete'));
        	} 
        	elseif (isset($review_user) && $user && $user->getId() == $review->getUserId()) {
            	echo link_to(__('delete'), 'review/deleteReview?review_id=' . $review->getId() . '&company_id=' . $company->getId(), array('class' => 'delete'));
        	}

        	if ($user && $user->getId() == $review->getUserId() 
					&& !$review->getAnswers() 
					&& $review->getActivityReview()->getTotalLikes() == 0) { ?>
	        	<a href="javascript:void(0);" data="<?php echo url_for('review/edit?review_id=' . $review->getId()) ?>" class="edit">
	                <?php echo __('edit') ?>
	            </a> 
         <?php
			} ?>
	</div> <!-- end vote-report -->
	    
	<div class="ajax"></div>
<?php else :?>
	<?php use_helper('TimeStamps'); ?>
<p class="review_date">
                                    	<?php echo ezDate(date('d.m.Y H:i', strtotime($review->getCreatedAt()))); //echo format_date($answer->getCreatedAt(), 'dd MMM yyyy',$culture); ?>
                                    </p>

                                    <?php if (!$user || ($review->getUserId() != $user->getId())): ?>
                                        <a id="<?php echo $review->getId() ?>" href="javascript:void(0);" data="<?php echo url_for('report/review?id=' . $review->getId()) ?>" class="report"><?php echo __('report') ?></a>
                                    <?php endif ?>

                                    <?php if ($user && $user->getId() == $review->getUserId()): ?>
                                        <?php if ($user_is_admin): ?>
                                            <a href="javascript:void(0);" data="<?php echo url_for('review/edit?review_answer_id=' . $review->getId()) ?>" class="edit"><?php echo __('edit') ?></a>
                                        <?php elseif ($user_is_company_admin): ?>
                                            <a href="javascript:void(0);" data="<?php echo url_for('companySettings/login?slug=' . $company->getSlug() . '&login=true') ?>" class="edit"><?php echo __('edit') ?></a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if (!isset($review_user) && ($user && $user->getId() == $review->getUserId())): ?>
                                        <?php if ($user_is_admin): ?>
                                            <?php echo link_to(__('delete'), 'review/deleteReview?review_id=' . $review->getId() . '&company_id=' . $review->getCompanyId(), array('class' => 'delete')); ?>
                                        <?php elseif ($user_is_company_admin): ?>
                                            <?php echo link_to(__('delete'), 'companySettings/login?slug=' . $company->getSlug() . '&login=true', array('class' => 'delete')); ?>
                                        <?php endif; ?>
                                    <?php elseif (isset($review_user) && ($user && $user->getId() == $review->getUserId())): ?>
                                        <?php if ($user_is_admin): ?>		
                                            <?php echo link_to(__('delete'), 'review/deleteReview?review_id=' . $review->getId() . '&company_id=' . $review->getCompanyId(), array('class' => 'delete')); ?>
                                        <?php elseif ($user_is_company_admin): ?>
                                            <?php echo link_to(__('delete'), 'companySettings/login?slug=' . $company->getSlug() . '&login=true', array('class' => 'delete')); ?>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php echo simple_format_text($review->getText()); ?>
	
	
<?php endif;?>
<?php //echo simple_format_text($review->getText()) ?>