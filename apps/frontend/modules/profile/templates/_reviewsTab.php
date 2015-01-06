<?php 
use_helper('Date');
use_helper('TimeStamps');
use_helper('Pagination');

use_javascript('jquery.ui.dialog.js');
use_stylesheet('ui-lightness/jquery-ui-1.8.16.custom.css');
?>
<div class="row">
	<div class="default-container default-form-wrapper col-sm-12">

		<div class="pp-tabs">
			<div class="pp-tabs-body">
				<div class="pp-tab">
				<h2><?php echo __('Reviews');?></h2>
				<p><?php echo format_number_choice('[0]No reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $pager->getNbResults()), $pager->getNbResults(),'user'); ?></p>
					<div class="review-lists">
						<div class="user-comments" id="company_review_container">
							<ul class="user-comment">
								<?php
									if (count($pager->getResults()) > 0):
									foreach ($pager->getResults() as $review):
										$company = $review->getCompany();
								?>
									<li>
                                        <div class="comments">
                                                    <div class="comment-image">
                                                    
                                                        <?php if (is_object($review->getUserProfile()) && isset($review_user)): ?>
                                                            <img src="<?= myTools::getImageSRC($review->getUserProfile()->getThumb(0), 'user') ?>" alt="<?= $review->getUserProfile()->getFirstName() ?>" height="80px" width="80px">
                                                        <?php else: ?>
                                                            <a  href="<?php echo url_for($company->getUri(ESC_RAW)) ?>" class="review_list_img"> <?php echo image_tag($company->getThumb(0), array('size' => '80x80', 'alt' => $company->getCompanyTitle())) ?></a>
                                    					<?php endif ?>
                                                    </div><!-- comment-image -->

                                                    <div class="comment-content">
                                                        <div class="comment-content-head">
                                                            <div class="name-rating">
                                                            <?php if (!isset($review_user)): ?>
													            <label><?php echo link_to($company->getCompanyTitle(), $company->getUri(ESC_RAW)) ?></label>
													            <div class="tag"><i class="fa fa-tags"></i><?php echo link_to($company->getClassification(), $company->getClassificationUri(ESC_RAW), 'class=category') ?></div>
													        <?php else: ?>
                                                                <h3><?php echo $review->getUserProfile()->getFirstName() . " " . $review->getUserProfile()->getLastName() ?></h3>
                                                            <?php endif; ?>    
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
                                                            </div>
                                                            <p><?php
                                                                echo ezDate(date('d.m.Y H:i', strtotime($review->getCreatedAt())));
                                                                if (in_array($review->getReferer(), array('ios', 'android'))) {
                                                                    echo '<i class="fa fa-mobile fa-2x"></i>';
                                                                }
                                                                ?></p>
                                                        </div><!-- comment-content-head -->

                                                        <div class="comment-content-body">
                                                            <p class="comment">
                                                                <span class="comment-txt">
                                                                    <?php echo $review->getText() ?>
                                                                </span>
                                                            </p><!-- comment -->

                                                            <div class="vote-report">               
                                                                    <?php include_partial('like/like', array('object' => $review->getActivityReview()));
                                                                    
                                                                    if (!$user || ($review->getUserId() != $user->getId())) {?> 
                                                                        <a id="<?php echo $review->getId() ?>" href="javascript:void(0);" data="<?php echo url_for('report/review?id=' . $review->getId()) ?>" class="report">
                                                                            <?php echo __('report') ?>
                                                                        </a>
                                                                    <?php } ?>
                                                                    <?php if (!isset($review_user) && $user && $user->getId() == $review->getUserId()): ?>
															            <?php echo link_to(__('delete'), 'profile/deleteReview?review_id=' . $review->getId(), array('class' => 'delete')); ?>
															        <?php elseif (isset($review_user) && $user && $user->getId() == $review->getUserId()): ?>
															            <?php echo link_to(__('delete'), 'company/deleteReview?review_id=' . $review->getId() . '&company_id=' . $company->getId(), array('class' => 'delete')); ?>
															        <?php endif; ?>
															        
															        <?php if ($user && $user->getId() == $review->getUserId() && !$review->getAnswers() && $review->getActivityReview()->getTotalLikes() == 0): ?> 
															        <a
														                href="javascript:void(0);"
														                data="<?php echo url_for('review/edit?review_id=' . $review->getId()) ?>"
														                class="edit"><?php echo __('edit') ?></a>
														            <?php endif; ?> 
														            
                                                            </div><!-- vote-report -->
                                                            <div class="ajax"></div>
                                                        </div><!-- comment-content-body -->
                                                    </div><!-- comment-content -->
                                                </div><!-- comments -->
                                            </li>
                                            <div id="dialog-confirm" title="<?php echo __('Deleting Review', null, 'messages') ?>" style="display:none;">
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

                                            <?php                                           
                                        endforeach;
                                        echo pager_navigation($pager, url_for('profile/reviews?username='. $pageuser->getUsername()));
                                    endif;
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
