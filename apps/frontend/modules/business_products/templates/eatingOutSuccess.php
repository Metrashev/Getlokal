<?php
function substr_unicode($str, $s, $l = null) {
    return join("", array_slice(
        preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $s, $l));
}
?>
<?php $culture = sfContext::getInstance()->getUser()->getCulture();?>
<?php $domain = sfContext::getInstance()->getRequest()->getHost();?>
<div id="banner-wrap" class="banner-wrap">
    <header>
        <a target="_blank" href="http://<?php echo $domain?>/<?php echo $culture;?>/d/search/index?reference=&s=Eating+Out<?php echo '&w='.$city.'&utm_source='.$source.'&utm_medium='.$medium.'&utm_term='.$term.'&utm_campaign='.$campaign?>" target="_blank">
            <div class="logo"><img src="/images/banners/logo-mini.png"></div>
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
        </a>
    </header> 
    <section class="places-slider">
        <div class="flexslider">
            <ul class="slides">
                <?php foreach ($companies as $c):?>
                <li>
                    <a href="<?php echo url_for($c->getUri(ESC_RAW).'&utm_source='.$source.'&utm_medium='.$medium.'&utm_term='.$term.'&utm_campaign='.$campaign) ?>" target="_blank">
                        <p><?php echo substr_unicode($c->getCompanyTitle(), 0, 17)?><?php echo (mb_strlen($c->getCompanyTitle(), 'UTF-8') > 17 ? '...' : '') ;?></p>
                        <div class="img-wrap">
                            <?php echo image_tag($c->getThumb(3), 'class=company-image alt=' . $c->getCompanyTitle());?>
                            <img class="shake" src="/images/banners/write_review_<?php echo $culture;?>.png"/>
                        </div> 
                        <div class="place_rateing">
                            <div itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
                                <div itemprop="ratingValue" content="<?php echo $c->getAverageRating();?>"></div>
                                <div itemprop="reviewCount" content="3"></div>
                            </div>
                            <div class="rateing_stars">
	                            <div class="rateing_stars_orange" style="width: <?php echo $c->getRating() ?>%;"></div>
                            </div>
                            <span><?php echo $c->getAverageRating();?> / 5</span>
                            <div class="clear"></div>
                            <span class="review_count"><?php echo format_number_choice('[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $c->getNumberOfReviews()), $c->getNumberOfReviews()); ?></span>
                        </div>
                    </a>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
    </section>
</div>
<script type="text/javascript">
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        slideshowSpeed: 5000,
        directionNav: true,
        controlNav: false,
        animationLoop: true,
        pauseOnAction: true,
        pauseOnHover: true,
        nextText: " ",
        prevText: " "
      })
	$('.shake').hide().css('display','').fadeIn(600);
            setInterval(function(){ 
                
                $('.shake').toggleClass('now');  
                setTimeout(function(){
                    $('.shake').toggleClass('now');  
                },1000)
            },3500);
    });
  </script>