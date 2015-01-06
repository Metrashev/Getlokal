<?php
use_helper('Date');
use_helper('TimeStamps');
use_helper('Pagination');
use_stylesheet('ui-lightness/jquery-ui-1.8.16.custom.css'); 
slot('no_ads', true);
$reviews = $pager->getResults();
$reviewscount = $pager->getNbResults();
?>

<div class="slider_wrapper pp">
  <div class="slider-image">
    <div class="dim"></div>
  </div>
  <div class="slider-separator"></div>  
</div><!-- slider_wrapper -->


<div class="container set-over-slider campaign-content">
    <div class="row">
        <div class="container">
            <div class="row">
                <h2 class="col-xs-12 list-header"><?php echo __('Reviews'); ?></h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 campaign-cover">
            <img  class="img-responsive" src="/images/winter-getlokal.jpg"/>
        </div>
        <div class="custom-row campaign-msg"><?php echo __('* Important: Duplicated or obscene reviews will be deleted'); ?></div>
    </div>

    <div class="row two-cols-container">

        <div class="default-container review-page col-sm-7 col-md-8">



            <div class="pp-tabs">
                <div class="pp-tabs-body m-lr-5">
                    <div class="pp-tab">
                        <div class="review-lists">
                            <div class="user-comments" id="company_review_container">
                                <ul class="user-comment">
                                    <?php
                                    if ($reviewscount > 0):
                                        foreach ($reviews as $review):
                                            ?>
                                            <li class="list-item-reviews">
                                                <div class="comments">
                                                    <div class="comment-image">
                                                        <?php if (is_object($review->getUserProfile())): ?>
                                                            <img src="<?= myTools::getImageSRC($review->getUserProfile()->getThumb(0), 'user') ?>" alt="<?= $review->getUserProfile()->getFirstName() ?>" height="80px" width="80px">
                                                        <?php else: ?>
                                                            <a  href="<?php echo url_for($company->getUri(ESC_RAW)) ?>" class="review_list_img"> <?php echo image_tag($company->getThumb(0), array('size' => '80x80', 'alt' => $company->getCompanyTitle())) ?></a>
                                    <?php endif ?>
                                                    </div><!-- comment-image -->

                                                    <div class="comment-content">
                                                        <div class="comment-content-head write-review-activity">
                                                            <div class="name-rating">
                                                                <h6><?php echo $review->getUserProfile()->getLink(ESC_RAW) ?></h6>
                                                                <h4 class="place-title"><?php echo link_to($review->getCompany()->getCompanyTitle(), $review->getCompany()->getUri(ESC_RAW)) ?></h4>
                                                                <p class="places"><i class="fa fa-tags"></i><?php echo link_to($review->getCompany()->getClassification(), $review->getCompany()->getClassificationUri(ESC_RAW), 'class=category') ?></p>

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

                                                                    <?php if(!isset($review_user) && $user && $user->getId() == $review->getUserId() && !$review->getAnswers()){ ?>
                                                                        <a id="<?php echo $review->getId() ?>" href="javascript:void(0);" data="<?php echo url_for('profile/deleteReview?review_id='. $review->getId()) ?>" class="delete">
                                                                            <?php echo __('delete') ?>
                                                                        </a>
                                                                    <?php } ?>
                                                            </div><!-- vote-report -->
                                                            <div class="ajax"></div>
                                                        </div><!-- comment-content-body -->
                                                        <!-- <div class="ajax"></div> -->
                                                    </div><!-- comment-content -->
                                                </div><!-- comments -->
                                            </li>

                                            <?php                                           
                                        endforeach;
                                        echo pager_navigation($pager, url_for('review/index'));
                                    endif;
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-5 col-md-4 col-lg-4 m-0">
               <div class="m-0"> <?php include_component('box', 'boxVip2') ?> </div>              
        </div>
        <div class="custom-row campaign-prices">
           <h2 class="campaign-title"><?php echo __('Prizes'); ?></h2>
        </div>
    </div>
</div>

<div id="dialog-confirm" title="<?php echo __('Deleting Review', null, 'messages') ?>" style="display:none;">
    <p><?php echo __('Are you sure you want to delete your review?', null, 'messages') ?></p>
</div>

<script type="text/javascript">
    $('a.delete').click(function(event) {
        var deleleReviewLink = $(this).attr('href');
        $("#dialog-confirm").data('id', deleleReviewLink).dialog('open');
        // $(".ui-dialog").css("z-index", "2");
        return false;
    });

    $("#dialog-confirm").dialog({
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

    $("a.report").click(function() {
        var element = $(this).parent().parent().find('.ajax');

        $.ajax({
            url: $(this).attr('data'),
            beforeSend: function() {
              $(element).html(LoaderHTML);
            },
            success: function(data){
              $(element).html(data);
              // loading = false;
            }
        });

        return false;
    });
</script>
