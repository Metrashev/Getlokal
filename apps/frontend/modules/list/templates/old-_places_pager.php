<?php use_helper('Pagination'); ?>
<div class="list_of_places" id="list_of_places">
    <?php $placeUser = false; ?>
    <ul class="alt-content">
        <?php foreach ($pager->getResults() as $place): ?>
            <li class="list-place-item">
                <?php if ($user && $user->getId() == $place->getUserId()) 
                $placeUser = true; ?> 
                <div class="listing_place" id="item_<?php echo $place->getId(); ?>">
                    <?php $place->getCompanyPage()->getCompany()->getImage() && $place->getCompanyPage()->getCompany()->getImage()->getCaption() ? $img_title = $place->getCompanyPage()->getCompany()->getImage()->getCaption() : $img_title = $place->getCompanyPage()->getCompany()->getCompanyTitle(); ?>
                    <a class="listing_place_img" title="<?php echo $img_title ?>" href="<?php echo url_for($place->getCompanyPage()->getCompany()->getUri(ESC_RAW)) ?>">
                        <?php echo image_tag($place->getCompanyPage()->getCompany()->getThumb(0), array('size' => '100x100', 'alt' => $img_title)); ?>
                    </a>
                    <div class="listing_place_in">

                        <div class="listing_place_rateing">
                            <div class="listing_place_rateing">
                                <div class="rateing_stars">
                                    <div style="width: <?php echo $place->getCompanyPage()->getCompany()->getRating() ?>%;" class="rateing_stars_orange"></div>
                                </div>
                                <span><?php echo format_number_choice('[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $place->getCompanyPage()->getCompany()->getNumberOfReviews()), $place->getCompanyPage()->getCompany()->getNumberOfReviews()); ?></span>
                                <br/>
                            </div>
                        </div>
                        
                        <a href="<?php echo url_for($place->getCompanyPage()->getCompany()->getUri(ESC_RAW)) ?>" title="<?php echo $place->getCompanyPage()->getCompany()->getCompanyTitle($culture) ?>" class="pink">
                            <?php echo $place->getCompanyPage()->getCompany()->getCompanyTitle($culture) ?>
                        </a>

                        <?php echo link_to($place->getCompanyPage()->getCompany()->getClassification(), $place->getCompanyPage()->getCompany()->getClassificationUri(ESC_RAW), array('class' => 'category')) ?>

                        <p class="<?php echo (!$is_place_admin_logged) ? 'short' : '' ?>"><?php echo $place->getCompanyPage()->getCompany()->getDisplayAddress(); ?></p>
                        <?php // USE $is_place_admin_logged ?>

                        <?php if ($user && ( $user->getId() == $place->getUserId() || $user->getId() == $listUserId )): ?>
                            <a id="<?php echo $place->getId() ?>" class="button_gray" href="javascript:void(0);"><?php echo __('Delete') ?></a>
                        <?php endif; ?>

                        <?php if (!$is_place_admin_logged): ?>
                            <a class="tipec button_pink" href="javascript:void(0);" onClick="_gaq.push(['_trackEvent', 'Review', 'Write', 'list']);" data="<?php echo url_for('list/review?place_id=' . $place->getCompanyPage()->getCompany()->getId() . '&list_id=' . $listId) ?>"><?php echo __('Write a Review') ?></a>
                        <?php endif; ?>
                        <div class="clear"></div>
                        <div class="list_review_box"></div>
                    </div>
                    <div class="clear"></div>
                    <?php /*
                      <p>Created by <a href="#" class="place"><?php echo $place->getUserProfile()->getLink(ESC_RAW) ?></a></p>
                     */ ?>
                    <div class="desc_full create_list_added_place">
                        <div>
                            <?php if ($place->getCompanyPage()->getCompany()->getReviews()->getFirst()): ?>

                                <?php if ($place->getCompanyPage()->getCompany()->getReviews()->getFirst()->getUserProfile()): ?>
                                    <span class="user"><?php echo $place->getCompanyPage()->getCompany()->getReviews()->getFirst()->getUserProfile()->getLink(ESC_RAW) ?></span> 
                                    <?php echo image_tag('gui/quotation_icon.png', array('class' => 'quotation_icon')) ?>
                                <?php endif; ?>
                                <p><?php echo $place->getCompanyPage()->getCompany()->getReviews()->getFirst()->getText() ?></p>

                                <div class="clear"></div>
                            <?php /* elseif ( $place->getCompanyPage()->getCompany()->getTopReview() ):?>
                              <span class="user"><?php echo $place->getCompanyPage()->getCompany()->getTopReview()->getUserProfile()->getLink(ESC_RAW) ?></span> <?php echo '>>' ?>
                              <?php echo $place->getCompanyPage()->getCompany()->getTopReview()->getText() ?>
                              <div class="clear"></div>
                              <?php */endif; ?>
                        </div>
                        <a href="javascript:void(0)" class="hide_full_desc"><?php echo __('hide', null, 'messages') ?></a>
                        <a href="javascript:void(0)" class="read_full_desc"><?php echo __('read more...', null, 'messages') ?></a>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="pager-center"></div>
    <div class="clear"></div>
    <?php // echo pager_navigation($pager, 'list/placesPager?id='.$listId.'&listUserId='.$listUserId  )?>
    <?php if ($user && ( $placeUser || $user->getId() == $listUserId )): ?>	
        <script type="text/javascript">
            $(document).ready(function() {	
                $("#list_of_places a.button_gray").click(function() {
                    var listPageId = $(this).attr('id');
                    //var value = $(this).attr('title');
                    var thisEl = $(this);
                    var row = $(this).parent().parent();
    			

                    $.ajax({
                        url: '<?php echo url_for("list/delPageFromList") ?>',
                        data: {'listPageId': listPageId},
                        success: function(data, url) {
                            $(row).remove();
                            $('#spanPlaceCount').text(parseInt($('#spanPlaceCount').text())-1);
                            //console.log('success');
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
    <?php endif; ?>
</div>