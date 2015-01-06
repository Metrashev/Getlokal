<?php use_helper('Date', 'Pagination');?>
<?php use_helper('Date', 'XssSafe');?>
  <?php $culture= $sf_user->getCulture();?>
<?php $count = 0; ?>
<div class="content_in_full index_offers">
  <?php if(!$pager->getNbResults()): ?>
    <p><?php echo __('There are no offers', null, 'offer')?></p>
</div>
  <?php else: ?>

<h2 class="dotted"><?php  echo  __('Offers',null,'offer'); ?></h2>
<p class="offer_hint">
              <?php echo __('Choose an offer, download the voucher now and pay when you use it in the place.', null, 'form')?>
             
</p>
 <?php include_partial('offer/formIndex', array(
        'form' => $form,
        //'company' => $company,
        //'active'=> isset($active) && $active == 1 ? 1 : null
    ));  ?>  
<div id="grid" class="all_offers_wrap">
<?php foreach($pager->getResults() as $company_offer): ?>
     <?php
            $current =  strtotime(date('Y-m-d H:i:s'));
            $timeToOfferEnd = strtotime($company_offer["active_to"]. '+3GMT');

            $hours_diff = ($timeToOfferEnd -$current)/3600 ;
            $offerStartDate =date("Y-m-d", strtotime($company_offer["active_from"]));
            $offerEndDate =date("Y-m-d", strtotime($company_offer["active_to"]));

    ?>

    <div data-groups="[&quot;<?php echo $company_offer->getCompany()->getCityId()?>&quot;, &quot;<?php echo $company_offer->getCompany()->getSectorId();?>&quot;]"
         data-sectorId="[&quot;<?php echo $company_offer->getCompany()->getSectorId();?>&quot; &quot;all-sectors&quot;]"  
         data-title="[&quot;<?php echo $company_offer->getCompany()->getSector()->getStitle();?>&quot;]" 
         class="element-item single_offer_wrap <?php echo ($hours_diff < 0 or $company_offer->getAvailableVouchers()==FALSE) ? 'expired_offer' : ''; ?> <?php echo $company_offer->getCompany()->getCityId()?>"
         data-category="<?php echo $company_offer->getCompany()->getSector()->getStitle()?>"
         data-date-created="<?php echo $offerStartDate;?>"
         data-date-expires="<?php echo $offerEndDate;?>"
         data-low-high="<?php switch ($company_offer->getBenefitChoice()):
                             case 1:?>
                                <?php $priceDiff = ($company_offer->getNewPrice()/$company_offer->getOldPrice())*100; ?>
                                <?php echo $ptcDiscount = 100 - $priceDiff; ?>
                            <?php break; ?>
                            <?php case 2:?>
                                 <?php echo $company_offer->getDiscountPct();?>
                            <?php break; ?>
                            <?php case 3:?>
                                 <?php echo $company_offer->getBenefitText();?>
                            <?php break; ?>
                         <?php endswitch;?>"
        sector-id="<?php echo $company_offer->getCompany()->getSectorId() ?>" 
        category-id="<?php echo $company_offer->getCompany()->getId(); ?>"
        c-lat="<?php echo $company_offer->getCompany()->getLocation()->getLatitude() !=0 ? ($company_offer->getCompany()->getLocation()->getLatitude()): ($company_offer->getCompany()->getCity()->getLat()) ?>"
        c-long="<?php echo $company_offer->getCompany()->getLocation()->getLongitude()!=0 ? ( $company_offer->getCompany()->getLocation()->getLongitude() ):($company_offer->getCompany()->getCity()->getLng()) ?>"
        time-left="<?php echo $timeToConvert = (1000 * strtotime($company_offer["active_to"]. '+3GMT')); ?> "
        c-id="<?php echo $company_offer->getCompany()->getId(); ?>"
        c-title="<?php echo $company_offer->getCompany()->getCompanyTitle() ?>"
        o-id="<?php echo $count;?>"
        c-l="<?php echo $sf_user->getCulture()?>"
        premuim="<?php echo($company_offer->getCompany()->getActivePPPService(true)) ? (true):(0)?>"                 
         >
        <input type="hidden" class="sector-id" value="<?php echo $company_offer->getCompany()->getSectorId();?>"/>
        <input type="hidden"class="sectors-all" value="0"/>
        <input type="hidden" class="city-id" value="<?php echo $company_offer->getCompany()->getCityId()?>"/>
        <input type="hidden"class="city-all" value="0"/>
       <?php echo link_to(__(' ', null, 'offer'),'offer/show?id='.$company_offer->getId(), array('class'=>'link_to_offer')); ?>
        <?php if ($company_offer->getImageId()):?>
                <?php if ($image = Doctrine_Core::getTable ( 'Image' )->findOneById($company_offer->getImageId())):?>
                        <div class="offer_image">
                             <?php $class_img = '' ?>
                             <?php if (($hours_diff>0 && $hours_diff<24) && $company_offer->getAvailableVouchers()>0):?>
                                <?php $class_img = 'expiring_soon' ?>
                                <div class="expiration_strip">
                                    <?php echo __('Expiring soon',null,'form')?>
                                </div>
                             <?php endif;?>
                             <?php if ($hours_diff<0 or $company_offer->getAvailableVouchers()==FALSE):?>
                                <?php $class_img = 'expiring_soon' ?>
                                <div class="expiration_strip expired" overflow='hidden'>
                                    <?php echo __('Not available',null,'form')?>
                                </div>
                             <?php endif;?>

                            <?php // echo image_tag($image->getThumb(3), array('size' => '290x257', 'alt_title'=>$company_offer->getDisplayTitle(), 'class'=>$class_img )) ?>
                            <?php echo image_tag($image->getFile(), array('size' => '292x220', 'alt_title'=>$company_offer->getDisplayTitle(), 'class'=>$class_img )) ?>
                             <?php if($company_offer->getBenefitChoice()): ?>
                             <div class="offer_benefits">
                                 <ul>
                                     <li>
                                        <?php switch ($company_offer->getBenefitChoice()):
                                           case 1:?>
                                               <a><?php echo $company_offer->getNewPrice(). ' ';?><?php echo $company_offer->getCompany()->getCountry()->getCurrency(); ?>
                                                   <span><?php echo $company_offer->getOldPrice(). ' ';?><?php echo $company_offer->getCompany()->getCountry()->getCurrency(); ?></span>
                                               </a>
                                           <?php break; ?>
                                           <?php case 2:?>
                                               <a><?php echo $company_offer->getDiscountPct();?><?php echo __('% discount', null, 'form');?></a>
                                           <?php break; ?>
                                           <?php case 3:?>
                                               <a><?php echo $company_offer->getBenefitText();?></a>
                                           <?php break; ?>
                                        <?php endswitch;?>
                                    </li>
                                 </ul>
                                 <p class="offer_description"><?php echo truncate_text(html_entity_decode ($company_offer->getDisplayTitle()), 160, '...', true) ?></p>       
                              </div>
                             <?php endif;?>
                        </div>
                <?php endif;?>
           <?php endif;?>  
    <div class="offer_content">
        <p class="offer_description"><?php echo truncate_text(html_entity_decode ($company_offer->getDisplayTitle()), 75, '...', true) ?></p>
 <?php /*       <h2><?php echo link_to($company_offer->getDisplayTitle(),'offer/show?id='.$company_offer->getId());?></h2> */ ?>
        <p class="company_classification"><?php echo $company_offer->getCompany()->getClassification(); ?></p>
        <div class="company_provider">
            <?php echo __('from', null, 'company')?> <?php echo link_to_company($company_offer->getCompany());?>,
            <p><?php echo $company_offer->getCompany()->getCity()->getLocation(); ?>,
            <?php echo $company_offer->getCountry()->getCountryNameByCulture(); ?></p>
           
        </div>



        <?php /* echo link_to(__('Order Voucher', null, 'offer'),'offer/show?id='.$company_offer->getId(), 'class=button_pink'); */ ?>
        <div class="clear"></div>
        <div class="bottom_wrap">
            <?php if ($hours_diff>0):?>
                <div id ="countDownTimer" class="count_down_timer">
                    <p><?php echo __('Time left to get it:',null,'form')?></p>
                    <div id="offerCountdown<?php echo $count ?>"></div>
                </div>
                <?php echo link_to(__('getVoucher', null, 'offer'),'offer/show?id='.$company_offer->getId(), array('class'=>'button_pink getVoucherBtn')); ?>
                <div class="clear"></div>
                <div class="remaining_vouchers">
                    <?php
                       if ($company_offer->getMaxVouchers()) {
                      $vouchersRemaining = $company_offer->getMaxVouchers() -  $company_offer->getCountVoucherCodes()  ;
                           if ($vouchersRemaining > 99){
                               $vouchersRemaining = 99;
                               echo ($vouchersRemaining. '+');
                          }
                          else {
                           echo $vouchersRemaining;
                          }
                     }
                     else{
                         $vouchersRemaining = 99;
                         echo ($vouchersRemaining. '+');
                     }

                    ?>
                </div>
           <?php endif;?>
             <div class="clear"></div>
        </div>

    </div>
       <div class="clear"></div>

   </div>  
<?php $count++; ?>
<?php endforeach; ?>
</div>
<div class="offer_hint business">
        <p><?php echo __('Have a business and want to include your offers?', null, 'form')?><br>
            <?php if ($sf_user->getCulture()== 'bg'): ?>
                <span><?php echo __('Create one now - click'.' ', null, 'form')?></span><a target="_blank" href="http://business.getlokal.com/steps-to-success/deals/"><?php echo __('here', null, 'form')?></a></p>
            <?php else: ?>
                <span><?php echo __('Create one now - click'.' ', null, 'form')?></span><a target="_blank" href="http://business.getlokal.com/en/steps-to-success/deals/"><?php echo __('here', null, 'form')?></a></p>
            <?php endif; ?>  
      <div class="clear"></div>
 </div>
  <?php $vars = $order ? array_merge($sf_data->getRaw('page_param'), array('order' => $order)) : $sf_data->getRaw('page_param'); ?>    
  <?php echo pager_navigation($pager, url_for(sfContext::getInstance()->getRouting()->getCurrentRouteName(), $vars )); ?>
</div>

<script type="text/javascript">
$(document).ready(function(){
    var redirectUrl = '<?php echo $url2; ?>';
    offerSelectMenus(); 
    <?php if ($sf_user->getCulture() == 'en'): ?>
    <?php elseif ($sf_user->getCulture() == 'bg'): ?>
    offersLayoutBG();
    <?php elseif ($sf_user->getCulture() == 'mk'): ?>
     offersLayoutMK();
    <?php elseif ($sf_user->getCulture() == 'sr'): ?>
    <?php elseif ($sf_user->getCulture() == 'ro'): ?>
      offerLayoutRO();
    <?php endif; ?>
    test(redirectUrl);
  //  showPins(); 

<?php if ($pager->getResults()): ?>  
    <?php $count1 =0; ?> 
      $('#grid').on('filtered.shuffle', function() {
        <?php foreach ($pager->getResults() as $company_offer): ?>
          google.maps.event.addListener(map.markers[<?php echo $company_offer->getCompany()->getId(); ?>], 'click', function() {
                map.overlay.load(<?php echo json_encode(get_partial('search/item_overlay', array('company' => $company_offer->getCompany())));?>);
                      map.overlay.setCenter(new google.maps.LatLng(<?php echo $company_offer->getCompany()->getLocation()->getLatitude(); ?>, <?php echo $company_offer->getCompany()->getLocation()->getLongitude(); ?>));
                      map.overlay.show();
                      $('.nav_arrow2').hide();
                      $('#hide_sim_places').show();
                  });
        <?php $count1++; ?>    
        <?php endforeach;?>      
});

<?php endif;?>        
    });  
</script>
<?php endif; ?>
 