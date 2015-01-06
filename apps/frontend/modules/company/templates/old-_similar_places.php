<?php if (count($similar_places) > 0): ?>
    <div class="similar_places_container" style="height:555px; overflow: hidden;">
        <h2><?php __('Similar Places') ?></h2>
        <ul class="similar_items">
            
            <?php foreach ($similar_places as $places): ?>
            <?php if (count($places)>0):?>
                <?php foreach ($places as $place):?>
	            <?php $place_title = $place->Translation[$sf_user->getCulture()]['title'];?>
                <li>  
                    <div class="similar_place_item <?php if( $sf_user->getCulture()!= 'en'):?><?php echo 'lg_'.$sf_user->getCulture()?><?php endif;?>">
                        <?php if ($place->getAllOffers()):?>
                           <div class="offer_available"><?php echo __('Offer', null, 'dashboard'); ?></div>
                        <?php endif;?>
                           <div class="place_image_wrap">
                                <?php echo link_to_company($place, array('image_size' => 2,'title'=>$place_title), array('size' => '180x135', 'alt' => $place_title)) ?>
                                <?php if ($place->getActivePPPService(true)):?>
                                    <div class="vip_bagde"></div>
                                    <div class="official_page"><?php echo __('Official page', null, 'company'); ?></div>
                                <?php endif;?>
                           </div>   
                            <div class="company_stats">    
                                <h3><?php echo link_to_company($place,array('title'=>$place_title)) ?></h3>

                                <div class="place_rateing">
                                    <div class="rateing_stars">
                                        <div style="width: <?php echo $place->getRating() ?>%;" class="rateing_stars_orange"></div>
                                    </div>
                                    <?php echo format_number_choice('[0]No reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $place->getNumberOfReviews()), $place->getNumberOfReviews(), 'user'); ?>
                                </div>
                            </div>    
                    </div>
                </li>
                <?php endforeach;?>
                <?php endif;?>
            <?php endforeach ?>
        </ul>

        <div class="clear"></div>
    </div>
    <div class="find_more_wrap">
        <div class="similar_places_more button_pink">
            <?php echo image_tag('gui/magnifier_icon_big.png') ?>
            <?php if ((getlokalPartner::getInstanceDomain() == 78) || $sf_request->getParameter('county', false)): ?>
                <a href="<?php echo url_for('@classificationCounty?slug='. $place->getClassification ()->getSlug (). '&sector='. $place->getSector ()->getSlug (). '&county='. $place->getCity()->getCounty()->getSlug(),true); ?>"><?php echo __('Find Similar Places'); ?></a>
                
            <?php else: ?>
                <a href="<?php echo url_for($place->getClassificationUri(ESC_RAW)); ?>"><?php echo __('Find Similar Places'); ?></a>
            <?php endif; ?>
        </div> 
    </div>    
<?php endif; ?>   