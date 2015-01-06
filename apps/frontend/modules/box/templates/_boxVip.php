<?php if (count($vips)){ ?>
    <div class="col-sm-12 events-premium-places">
        <div class="premium-places-header">
            <h3><?php echo __('Recommended Places', null, 'events') ?></h3>
        </div>
        <ul>
            <?php foreach ($vips as $vip){ ?>
                <li class="events-places">
                    <div class="events-place-image">
                        <?php echo link_to(image_tag($vip->getThumb(), array('size' => '45x45', 'alt' => $vip->getCompanyTitle())), $vip->getUri(ESC_RAW), array('title' => "asd")) ?>
                    </div><!-- place-image -->
                    <div class="event-place-content">
                        <div class="place-content">
                            <a href="<?php echo url_for($vip->getUri(ESC_RAW)); ?>"><h4 class="premium-place-title"><?php echo $vip->getCompanyTitle(); ?></h4></a>
                                     <div class="stars-holder small">                  
                                        <ul>
                                            <li class="gray-star"><i class="fa fa-star"></i></li>
                                            <li class="gray-star"><i class="fa fa-star"></i></li>
                                            <li class="gray-star"><i class="fa fa-star"></i></li>
                                            <li class="gray-star"><i class="fa fa-star"></i></li>
                                            <li class="gray-star"><i class="fa fa-star"></i></li>
                                            
                                        </ul>
                                    <div class="top-list">
                                        <div class="hiding-holder" style="width: <?php echo $vip->getRating(); ?>%;">
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
                            <p class="events-review-number"><span><?php echo $vip->getNumberOfReviews(); ?></span><?php echo __('reviews') ?></p>
                        </div><!-- place-content -->
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>