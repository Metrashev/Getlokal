<?php if (count($offers) || count($vips)): ?>
        <!--offers slider-->
        <?php if (count($offers)): ?>
            <div class="hp_2columns_left offers_slider" style="margin-top: -22px;">
               <div class="offers_heading_wrap">
                   <h2><a href="<?php echo url_for('offer/index') ?>" title="<?php echo __('view all offers'); ?>"><?php echo __('Offers', null, 'offer') ?></a></h2>
                   <a href="<?php echo url_for('offer/index') ?>" class="btn-more-events" id="hp_2columns_offer_list_show"><?php echo __('see all', null, 'messages') ?></a> 
               </div> 
                <div class="clear"></div>
               <div id ="offers-box-slider" class="flexslider">
                  <ul class="slides">
                    <?php foreach ($offers as $offer): ?>
                                 <li class="offer_image offer-image-box">
                                   <a href="<?php echo url_for('offer/show?id='.$offer->getId()) ?>">
                                       <div class="image_wrap">
                                            <?php if ($offer->getImageId()):?>
                                                <?php if ($image = Doctrine_Core::getTable ( 'Image' )->findOneById($offer->getImageId())):?>
                                                  <!--  <?php //echo image_tag('/uploads/offers/'.$image['filename'],array('alt_title'=>$offer->getDisplayTitle())) ?> -->
                                                  <?php echo image_tag($image->getFile(), array('size' => '290x257','alt_title'=>$offer->getDisplayTitle())) ?>
                                                <?php endif;?>   
                                            <?php endif;?>   
                                                <?php if ($offer->getBenefitChoice()): ?>
                                                <div class="offer_benefits">
                                                    <?php switch ($offer->getBenefitChoice()):
                                                        case 1:
                                                            ?>
                                                            <h4><?php echo $offer->getNewPrice() . ' '; ?><?php echo $offer->getCompany()->getCountry()->getCurrency(); ?>
                                                                <span><?php echo $offer->getOldPrice() . ' '; ?><?php echo $offer->getCompany()->getCountry()->getCurrency(); ?></span>
                                                            </h4>
                                                            <?php break; ?>
                                                        <?php case 2: ?>
                                                            <h4><?php echo $offer->getDiscountPct(); ?><?php echo __('% discount', null, 'form'); ?></h4>
                                                            <?php break; ?>
                                                        <?php case 3: ?>
                                                            <h4><?php echo $offer->getBenefitText(); ?></h4>
                                                        <?php break; ?>
                                                <?php endswitch; ?>
                                                </div>
                                        </div>  
                                       <?php endif; ?>
                                         <p class="offer_title"><?php echo truncate_text(html_entity_decode ($offer->getDisplayTitle()), 70, '...', true) ?></p>
                                         <div class="offer_more_info" style="display:none">
                                             <p class="company_classification"><?php echo $offer->getCompany()->getClassification(); ?></p>
                                            <div class="company_provider">
                                                <?php echo __('from', null, 'company')?> <?php echo link_to_company($offer->getCompany());?>,
                                                <p><?php echo $offer->getCompany()->getCity()->getLocation(); ?>,
                                                <?php echo $offer->getCountry()->getCountryNameByCulture(); ?></p>
                                            </div>
                                         </div> 
                                         
        
                                     </a>
                                  </li>
                               
                     <?php endforeach; ?>
                   </ul>
               </div>
            </div>
    <?php endif;?>
        <!--Lists-->
            <?php if (count($vips)): ?>
            <div class="hp_2columns_right">
                <h2><?php echo __('VIP Places') ?></h2>
                    <?php foreach ($vips as $vip): ?>
                    <div class="short">
            <?php echo link_to(image_tag($vip->getThumb(), array('size' => '45x45', 'alt' => $vip->getCompanyTitle())), $vip->getUri(ESC_RAW)) ?>
                        <h3><?php echo link_to($vip->getCompanyTitle(), $vip->getUri(ESC_RAW), array('title' => $vip->getCompanyTitle())) ?></h3>
                        <div class="review_rateing">
                            <div class="rateing_stars">
                                <div class="rateing_stars_orange" style="width: <?php echo $vip->getRating() ?>%;"></div>
                            </div>
                            <span class=""><?php echo $vip->getAverageRating() ?> / 5</span>
                        </div>
                    </div>
            <?php endforeach ?>
            </div>
    <?php endif ?>
        <div class="clear"></div>

<?php endif
?>