<?php $requestUrl = sfContext::getInstance()->getRequest()->getUri();?>
<?php $culture = sfContext::getInstance()->getUser()->getCulture();?>
<div class="ios-wrap">
    <section class="middle">
        <img src="/images/gui/mobile-logo.png"/>
        <p><?php echo __('Find places around you,'); ?></p>
        <p class="small"><?php echo __('download getlokal app.'); ?></p>
        <a href="https://itunes.apple.com/bg/app/getlokal/id563521118?mt=8&utm_source=MobilePopUp&utm_medium=mobile&utm_campaign=App-MobilePopUp-AppStore" target="itunes_store" class="download-btn">
            <?php if ($culture == 'mk' || $culture == 'sr'):?> 
               
                <img src="/images/gui/ios_Landing/app-store-btn_en.svg"/>
            <?php else:?>
                <img src="/images/gui/ios_Landing/app-store-btn_<?php echo $culture ?>.svg"/>
            <?php endif;?>    
        </a>
    </section>
    <section class="bottom">
        <a target="_blank" href="<?php echo $requestUrl?>"><?php echo __('Continue to the website'); ?></a>
        <img src="/images/gui/ios_Landing/arrows.png"/>
    </section>
</div>

