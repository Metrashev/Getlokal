<?php
function substr_unicode($str, $s, $l = null) {
    return join("", array_slice(
        preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $s, $l));
}
?>
<?php $domain = sfContext::getInstance()->getRequest()->getHost();?>
<?php $culture = sfContext::getInstance()->getUser()->getCulture();?>
<div id="banner-wrap" class="banner-wrap">
    <header>
        <a target="_blank" href="http://<?php echo $domain?>/<?php echo $culture;?>/d/search/index?reference=&s=Eating+Out<?php echo '&w='.$city.'&utm_source='.$source.'&utm_medium='.$medium.'&utm_term='.$term.'&utm_campaign='.$campaign?>" target="_blank">
            <section>
                  <h2> 
                <?php if(substr_unicode($city, 0, 1) == 'В' or substr_unicode($city, 0, 1) == 'Ф'):?>
                    <?php echo __('See all in ',null, 'exception' ); ?>
                    <?php echo __($city); ?>
                <?php else:?>
                     <?php echo __('See all in ',null, 'messages' ); ?>
                     <?php echo __($city); ?>
                <?php endif;?>
                </h2>
            </section>
            <div class="logo"><img src="/images/banners/logo_gl.png"></div>
        </a>
    </header>
    <section class="places-slider">
        <div id="my-carousel">
            <ul><?php $j = 0;?>
                <?php $counter = count($companies);?>
                <?php for ($i=0; $i<=$counter/2; $i++):?>
                <li>
                    <a href="<?php echo url_for($companies[$i]->getUri(ESC_RAW).'&utm_source='.$source.'&utm_medium='.$medium.'&utm_term='.$term.'&utm_campaign='.$campaign) ?>" target="_blank">
                        <p><?php echo substr_unicode($companies[$i]->getCompanyTitle(), 0, 15)?><?php echo (mb_strlen($companies[$i]->getCompanyTitle(), 'UTF-8') > 15 ? '...' : '') ;?></p>
                        <div class="img-wrap">
                            <?php echo image_tag($companies[$i]->getThumb(2), 'class=company-image alt=' . $companies[$i]->getCompanyTitle());?>
                            <img class="shake" src="/images/banners/write_review_small_<?php echo $culture;?>.png"/>
                        </div> 
                        <div class="place_rateing">
                            <div itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
                                <div itemprop="ratingValue" content="<?php echo $companies[$i]->getAverageRating();?>"></div>
                                <div itemprop="reviewCount" content="3"></div>
                            </div>
                            <div class="rateing_stars">
	                            <div class="rateing_stars_orange" style="width: <?php echo $companies[$i]->getRating() ?>%;"></div>
                            </div>
                            <span><?php echo $companies[$i]->getAverageRating();?> / 5</span>
                            <div class="clear"></div>
                            <div class="review_count"><?php echo format_number_choice('[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $companies[$i]->getNumberOfReviews()), $companies[$i]->getNumberOfReviews()); ?></div>
                        </div>
                    </a>
                </li>
                <?php $j++ ;?>
                <?php endfor;?>
                
            </ul>    
        </div>
        
         <div id="my-carousel1">
            <ul>
                <?php $counter = count($companies);?>
                <?php for ($i=$j; $i<$counter; $i++):?>
                <li>
                    <a href="<?php echo url_for($companies[$i]->getUri(ESC_RAW).'&utm_source='.$source.'&utm_medium='.$medium.'&utm_term='.$term.'&utm_campaign='.$campaign) ?>" target="_blank">
                        <p><?php echo substr_unicode($companies[$i]->getCompanyTitle(), 0, 15)?><?php echo (mb_strlen($companies[$i]->getCompanyTitle(), 'UTF-8') > 15 ? '...' : '') ;?></p>
                        <div class="img-wrap">
                            <?php echo image_tag($companies[$i]->getThumb(2), 'class=company-image alt=' . $companies[$i]->getCompanyTitle());?>
                            <img class="shake" src="/images/banners/write_review_small_<?php echo $culture;?>.png"/>
                        </div> 
                        <div class="place_rateing">
                            <div itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
                                <div itemprop="ratingValue" content="<?php echo $companies[$i]->getAverageRating();?>"></div>
                                <div itemprop="reviewCount" content="3"></div>
                            </div>
                            <div class="rateing_stars">
	                            <div class="rateing_stars_orange" style="width: <?php echo $companies[$i]->getRating() ?>%;"></div>
                            </div>
                            <span><?php echo $companies[$i]->getAverageRating();?> / 5</span>
                            <div class="clear"></div>
                            <div class="review_count"><?php echo format_number_choice('[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $companies[$i]->getNumberOfReviews()), $companies[$i]->getNumberOfReviews()); ?></div>
                        </div>
                    </a>
                </li>
                <?php endfor;?>  
            </ul>
             <a id="simplePrevious" class="prev"></a>
             <a id="simpleNext" class="next"></a>
        </div>
        
    </section>
</div>
	
<script type="text/javascript">
     $(document).ready(function(){
          $('#my-carousel').carousel('#simplePrevious', '#simpleNext');
           $('#my-carousel1').carousel('#simplePrevious', '#simpleNext');
    /*      setInterval(function() {
            $('#simpleNext').trigger('click');  
        }, 3500);  */
    });  
    
    
   
    
</script>
