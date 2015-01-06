<?php $requestUrl = sfContext::getInstance()->getRequest()->getUri();?>
<?php $culture = sfContext::getInstance()->getUser()->getCulture();?>
<div class="andr-wrap">
    <section class="middle">
        <img src="/images/gui/mobile-logo.png"/>
        <p><?php echo __('Find places around you,'); ?></p>
        <p class="small"><?php echo __('download getlokal app.'); ?></p>
        <a href="market://details?id=com.getLokal&utm_source=MobilePopUp&utm_medium=mobile&utm_campaign=App-MobilePopUp-GooglePlay" class="download-btn">
            <?php if ($culture == 'mk'):?> 
                <img src="/images/gui/android_Landing/gplay-btn_en.png"/>
            <?php else:?>
                <img src="/images/gui/android_Landing/gplay-btn_<?php echo $culture ?>.png"/>
            <?php endif;?>  
        </a>
    </section>
    <section class="bottom">
        <a target="_blank" href="<?php echo $requestUrl?>"><?php echo __('Continue to the website'); ?></a>
        <img src="/images/gui/android_Landing/andr-arrow.png"/>
    </section>
</div>