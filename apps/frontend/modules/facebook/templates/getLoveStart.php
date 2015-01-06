<?php use_stylesheet('facebook/gameGetLove.css') ?>

<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
      appId      : '177346862345547', // App ID from the App Dashboard
      channelUrl : '//getlokal.ro/channel.html', // Channel File for x-domain communication
      status     : true, // check the login status upon init?
      cookie     : true, // set sessions cookies to allow your server to access the session?
      xfbml      : true  // parse XFBML tags on this page?
    });

    // Additional initialization code such as adding Event Listeners goes here
    FB.getLoginStatus(function(response) {
      if(response.status == 'connected')
      {
        FB.api('/me/likes/311234832285176', { accessToken: response.authResponse }, function(response) {
          if(!response.data.length) $('.home .disabled').show();
        });
      }
      else
      {
        FB.login(function(response) {
          FB.api('/me/likes/311234832285176', function(response) {
            if(!response.data) $('.home .disabled').show();
          });
        })
      }
    });
  };

  // Load the SDK's source Asynchronously
  // Note that the debug version is being actively developed and might 
  // contain some type checks that are overly strict. 
  // Please report such bugs using the bugs tool.
  (function(d, debug){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
     ref.parentNode.insertBefore(js, ref);
   }(document, /*debug*/ false));
</script>
<div id="wrapper" class="disabled">
  <div class="home">
    <?php echo link_to(image_tag('facebook/v4/landing_page.jpg'), 'facebook/getLove?step=2'); ?>
    <div class="disabled" style="display: none"><?php echo image_tag('facebook/v4/overlay.png'); ?></div>
  </div>
  <div style="text-align: center;">
    <a href="http://www.getlokal.ro/ro/article/am-lansat-aplicatia-getlove" target="_blank"><?php echo image_tag('facebook/v4/coftable.jpg') ?></a>
    <a href="http://www.getlokal.ro/ro/article/am-lansat-aplicatia-getlove" target="_blank"><?php echo image_tag('facebook/v4/donia.jpg') ?></a>
    <a href="http://www.getlokal.ro/ro/article/am-lansat-aplicatia-getlove" target="_blank"><?php echo image_tag('facebook/v4/squin.jpg') ?></a>
    <a href="http://www.getlokal.ro/ro/article/am-lansat-aplicatia-getlove" target="_blank"><?php echo image_tag('facebook/v4/sky.jpg') ?></a>
    <a href="http://www.getlokal.ro/ro/article/am-lansat-aplicatia-getlove" target="_blank"><?php echo image_tag('facebook/v4/meta.jpg') ?></a>
    <p>
      <a href="http://www.getlokal.ro/ro/page/promo-rules" style="color: #00bbbe; text-decoration: none;"  target="_blank">- Vezi aici regulamentul -</a>
    </p>
    <?php echo image_tag('facebook/v4/landing_page_bot.jpg') ?>
  </div>
</div>