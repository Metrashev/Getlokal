 <?php 
//use_javascript('jquery.countdown.js');

if (count($offers)){ ?>

<div class="offers_wrapper<?=$smallerContainer ? ' smaller-offers-slide-wraper' : ''?>">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="section-offers">
                    <div class="offers-title">
                        <?php echo __('OFFERS IN', null, 'offer'); ?><span> <?php echo $sf_user->getCity()->getDisplayCity(); ?></span>
                    </div>
                    <span class="visit-more"></span>
                    <div class="offers-content">
                        <div id="offers-wrapper">
                            <div id="offers-carousel">
                                <ul class="offer-slider offer-slider-more">
                                    <?php 
                                        foreach ($offers as $offer){
                                            include_partial("offer/offer", array('offer' => $offer));
                                        }
                                    ?>
                                </ul>
                                <div class="clearfix"></div>
                                <a id="offers-prev" class="offers-prev offers-prev-more" href="#"><i class="fa fa-chevron-left fa-2x"></i></a>
                                <a id="offers-next" class="offers-next offers-next-more" href="#"><i class="fa fa-chevron-right fa-2x"></i></a>
                            </div>
                        </div>
                    </div>
                    <div id="offers-pager" class="offers-pager offers-pager-more"></div>
                </div>
            </div>
        </div>
    </div>
</div><!--offers_wrapper -->
<?php } ?>


<!-- <div class="offers_heading_wrap">
   <h2><a href="<?php //echo url_for('offer/index') ?>" title="<?php //echo __('view all offers'); ?>"><?php //echo __('Offers', null, 'offer') ?></a></h2>
   <a href="<?php //echo url_for('offer/index') ?>" class="btn-more-events" id="hp_2columns_offer_list_show"><?php //echo __('see all', null, 'messages') ?></a> 
</div> -->