<li class="offers-list-item">
    <a href="<?php echo url_for('offer/show?id='.$offer->getId()) ?>">

        <div class="offer-head">
            <h6><?php echo truncate_text(html_entity_decode ($offer->getDisplayTitle()), 70, '...', true); ?></h6>
            <h5><?php echo truncate_text(html_entity_decode ($offer->getCompany()->getCompanyTitle()), 27, '...', true); ?></h5>
        </div>

        <div class="offers-body">                     
            <div>
                <?php 
                    if ($offer->getImageId()){
//                         if ($image = Doctrine_Core::getTable ( 'Image' )->findOneById($offer->getImageId())){
                        if ($image = $offer->getImage()){
                            echo image_tag($image->getFile(), array('size' => '220x170','alt_title'=> truncate_text(html_entity_decode ($offer->getTitle()), 20, '...', true)));
                        }   
                    } 
                ?>             
            </div>
                      
            <?php if ($offer->getBenefitChoice() == '1'){ ?>
                <div class="offers-discount"><?php echo Doctrine::getTable('CompanyOffer')->getDiscount($offer); ?>%</div>
            <?php } elseif($offer->getBenefitChoice() == '2'){ ?>
                <div class="offers-discount"><?php echo $offer->getDiscountPct(); ?>%</div>
            <?php } ?>
            
            <div class="offers-time"><i class="fa fa-clock-o"></i>
                <?php 
                    $remaining = Doctrine::getTable('CompanyOffer')->getRemainingTime($offer);
                    echo format_number_choice('[0]%time%|[1]1 day %time%|(1,+Inf]%days% days %time%', array('%days%' => $remaining->format('%d'), '%time%' => $remaining->format('%h:%i:%s')), $remaining->format('%d'), 'offer'); 
                ?>
            </div>
        </div>

        <div class="offers-foot">
            <?php if ($offer->getBenefitChoice()){ ?>
                <?php switch ($offer->getBenefitChoice()){
                    case 1:
                        ?>
                        <div class="offers-section-prize">
                            <div class="alignleft">
                                <?php echo __('Price', null, 'form'); ?>
                                <span class="offers-prize">
                                    <?php echo $offer->getNewPrice() . ' '; ?><?php echo $offer->getCompany()->getCountry()->getCurrency(); ?>
                                </span>
                            </div>
                            <div class="alignright">
                                <?php echo __('Old price', null, 'form'); ?>
                                <span class="old-offers-prize">
                                    <?php echo $offer->getOldPrice() . ' '; ?><?php echo $offer->getCompany()->getCountry()->getCurrency(); ?>
                                </span>
                            </div>
                            <img src="/../css/images/temp/prize-tick.png" alt="" class="prize-tick">
                        </div>
                        <?php break; ?>

                    <?php case 2: ?>
                        <div class="offers-section-prize">
                            <?php echo __('discount', null, 'form'); ?>
                            <span class="offers-prize">
                               <?php echo $offer->getDiscountPct(); ?>%
                            </span>
                        </div>
                        <?php break; ?>

                    <?php case 3: ?>
                        <div class="offers-section-prize">
                        	<?php echo truncate_text(html_entity_decode($offer->getBenefitText()), 30, '...', true); ?>
                        </div>
                    <?php break; ?>
                <?php } ?>
            <?php } ?>

            <div class="offers-section-place">
                <span><?php echo $offer->getCompany()->getCity()->getLocation(); ?></span>  
            </div><!-- section-place -->

            <div class="offers-section-event-type">
                <div class="alignleft"><i class="fa fa-tag"></i><?php echo $offer->getCompany()->getClassification(); ?></div>
            </div><!-- section-event-type -->
        </div>

    </a>
</li>