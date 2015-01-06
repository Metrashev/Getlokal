<?php
	use_helper('Date');
	use_helper('TimeStamps');
	$culture = $sf_user->getCulture();
	if(empty($company)) $company = $review->getCompany();
	use_javascript('jquery.ui.dialog.js');
	use_stylesheet('ui-lightness/jquery-ui-1.8.16.custom.css');
	if (!isset($user_is_company_admin)) $user_is_company_admin = false; 
	if (!isset($user_is_admin)) $user_is_admin = false; 
	
?>

<div class="comments"	id="review-<?php echo $review->getId() ?>">
    <div class="comment-image">
        <?php if (is_object($review->getUserProfile()) && isset($review_user)): ?>
            <img src="<?= myTools::getImageSRC($review->getUserProfile()->getThumb(0), 'user') ?>" alt="<?= $review->getUserProfile()->getFirstName() ?>" height="80px" width="80px">
        <?php else: ?>
            <a  href="<?php echo url_for($company->getUri(ESC_RAW)) ?>" class="review_list_img"> <?php echo image_tag($company->getThumb(0), array('size' => '80x80', 'alt' => $company->getCompanyTitle())) ?></a>
        <?php endif ?>
    </div><!-- comment-image -->
    
    <div class="comment-content">
	    <div class="comment-content-head">
	    	<!-- Meta !!!!! --> <!-- 
	    	<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                <meta itemprop="worstRating" content = "0">
                <meta itemprop="ratingValue" content = "<?php echo ( $review->getRating() != 0 ? $review->getRating() : '2.5') ?> ">
                <meta itemprop="bestRating" content = "5">
            </div>
            -->
	        <div class="name-rating">
	            <?php if (!isset($review_user)): ?>
					<label><?php echo link_to($company->getCompanyTitle(), $company->getUri(ESC_RAW)) ?></label>
					<div class="tag"><i class="fa fa-tags"></i><?php echo link_to($company->getClassification(), $company->getClassificationUri(ESC_RAW), 'class=category') ?></div>
				<?php else: ?>
	                <h3 class="m-0"><a class="user" title="<?php echo $review->getUserProfile()?>"
							href="<?php echo  url_for('@user_page?username='. $review->getUserProfile()->getSfGuardUser()->getUsername()) ?>"><b><?php echo $review->getUserProfile()?>
						</b> </a><?php //echo $review->getUserProfile()->getFirstName() . " " . $review->getUserProfile()->getLastName() ?></h3>
	            <?php endif; ?>    
	            
	        </div>
	        <p><?php
	             echo ezDate(date('d.m.Y H:i', strtotime($review->getCreatedAt())));
	             if (in_array($review->getReferer(), array('ios', 'android'))) {
	                 echo '<i class="fa fa-mobile fa-2x"></i>';
	             }
	            ?></p>
	    </div><!-- comment-content-head -->
  

    <div class="comment-content-body">
	    <div class="review-content-body">
    		<div class="stars-holder small holder-stars-cs">                    
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
            
	    	<!-- <meta itemprop="datePublished" content="<?php echo $review->getCreatedAt(); ?>"> -->
	    	
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
		        <?php 
		        	include_partial('like/like', array('object' => $review->getActivityReview()));
		
		        	if ($review->recommended_at) {
		        ?>
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
		                	<a href="javascript:void(0);" data="<?php echo url_for('review/reply?review_id=' . $review->getId()) ?>" class="reply answer-company-settings">
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
		            	echo link_to(__('delete'), 'review/deleteReview?review_id=' . $review->getId() . '&company_id=' . $company->getId(), array('class' => 'delete default-btn-answer-delete pull-right'));
		        	}
		
		        	if ($user && $user->getId() == $review->getUserId() 
							&& !$review->getAnswers() 
							&& $review->getActivityReview()->getTotalLikes() == 0) { ?>
			        	<a href="javascript:void(0);" data="<?php echo url_for('review/edit?review_id=' . $review->getId()) ?>" class="edit default-btn-answer-edit pull-right">
			                <?php echo __('edit') ?>
			            </a> 
		         <?php
					} ?>
		    </div> <!-- end vote-report -->
		    
		    <div class="ajax"></div>
	    </div>
    </div>
    
    
    <?php if ($review->getReview()): ?>
        <?php $answers = $review->getAnswers(); ?>

        <?php if ($answers): ?>
            <div class="review_company_container additional-reply m-0 p-top-10">
                <div class="review_company_content">
                    
                    <div class="comment-content pull-left w-100">
                        <div class="comment-content-head">
                            <div class="name-rating w-100">
                                

                                <?php foreach ($answers as $answer): ?>
                                    <?php if ($answer): ?>
                                    <div class="review_company_content_wrap">
                                            <div class="review-content-body review_company_content_in">
                                            <h3 class="pull-left owner-answer"><?php echo __('from'); ?> <?php echo $company->getCompanyTitle() ?></h3>
                                                <p class="review_date">
                                                	<?php echo ezDate(date('d.m.Y H:i', strtotime($answer->getCreatedAt()))); //echo format_date($answer->getCreatedAt(), 'dd MMM yyyy',$culture); ?>
                                                </p>
                                                <?php echo simple_format_text($answer->getText(), array('class' => 'review-text-company-settings')); ?>
                                
                                                <?php if (!$user || ($answer->getUserId() != $user->getId())): ?>
                                                    <a id="<?php echo $review->getId() ?>" href="javascript:void(0);" data="<?php echo url_for('report/review?id=' . $review->getId()) ?>" class="report"><?php echo __('report') ?></a>
                                                <?php endif ?>

                                                <?php if ($user && $user->getId() == $answer->getUserId()): ?>
                                                    <?php if ($user_is_admin): ?>
                                                        <a href="javascript:void(0);" data="<?php echo url_for('review/edit?review_answer_id=' . $answer->getId()) ?>" class="edit pull-right default-btn-answer-edit"><?php echo __('edit') ?></a>
                                                    <?php elseif ($user_is_company_admin): ?>
                                                        <a href="javascript:void(0);" data="<?php echo url_for('companySettings/login?slug=' . $company->getSlug() . '&login=true') ?>" class="edit"><?php echo __('edit') ?></a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <?php if (!isset($review_user) && ($user && $user->getId() == $answer->getUserId())): ?>
                                                    <?php if ($user_is_admin): ?>
                                                        <?php echo link_to(__('delete'), 'review/deleteReview?review_id=' . $answer->getId() . '&company_id=' . $answer->getCompanyId(), array('class' => 'delete')); ?>
                                                    <?php elseif ($user_is_company_admin): ?>
                                                        <?php echo link_to(__('delete'), 'companySettings/login?slug=' . $company->getSlug() . '&login=true', array('class' => 'delete')); ?>
                                                    <?php endif; ?>
                                                <?php elseif (isset($review_user) && ($user && $user->getId() == $answer->getUserId())): ?>
                                                    <?php if ($user_is_admin): ?>		
                                                        <?php echo link_to(__('delete'), 'review/deleteReview?review_id=' . $answer->getId() . '&company_id=' . $answer->getCompanyId(), array('class' => 'default-btn-answer-delete delete pull-right')); ?>
                                                    <?php elseif ($user_is_company_admin): ?>
                                                        <?php echo link_to(__('delete'), 'companySettings/login?slug=' . $company->getSlug() . '&login=true', array('class' => 'delete ')); ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>

                                                    </div>
                                        <div class="ajax"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>
                        <?php endforeach; ?>
                    </div>
            </div><?php endif ?>
    <?php endif ?>
    </div> 
</div>
<div id="dialog-confirm" title="<?php echo __('Deleting Review', null, 'messages') ?>" style="display:none;" >
        <p><?php echo __('Are you sure you want to delete your review?', null, 'messages') ?></p>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        /*Delete review */ 
        $('a.delete').on('click',function(event) {
            var deleleReviewLink = $(this).attr('href');
            $("#dialog-confirm").data('id', deleleReviewLink).dialog('open');
            $(".ui-dialog").css("z-index", "1000");
            return false; 
            /*END Delete review */
            
        });
        
    });
    
    $("#dialog-confirm").dialog({
        draggable:false,
        resizable: false,
        autoOpen: false,
        height: 250,
        width:340,
        buttons: {
            "<?php echo __('delete', null) ?>": function() {
                window.location.href =  $("#dialog-confirm").data('id');
            },
            <?php echo __('cancel', null, 'company') ?>: function() {
                               $(this).dialog("close");
                           }
                       }
    });

    
</script>                    