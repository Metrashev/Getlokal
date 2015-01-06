<?php if($sf_user->getCountry()->getSlug() == 'sr'): ?>
<html xmlns:fb="http://ogp.me/ns/fb#">
<body>
<div id="fb-root"></div>
<script src="//connect.facebook.net/en_US/all.js"></script>

<script>
  window.fbAsyncInit = function() {
  FB.init({
    appId      : '685816038129660',
    status     : true, // check login status
    cookie     : true, // enable cookies to allow the server to access the session
    xfbml      : true  // parse XFBML
  });

  FB.login(function(response) {
    if (response.authResponse) {
        // user is logged in and granted some permissions.
    } else {
        window.location = "https://www.facebook.com/getlokal.rs"
    }
  }, {scope:'read_stream,publish_stream,offline_access'});

  FB.Event.subscribe('auth.authResponseChange', function(response) { 
    if (response.status === 'connected') {
      testAPI();
    } 
    else if (response.status === 'not_authorized') {
    } 
    else {
      FB.login();
    }
  });
  };

  // Load the SDK asynchronously
  (function(d){
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all.js";
   ref.parentNode.insertBefore(js, ref);
  }(document));

  function testAPI() {
    FB.api('/me/likes/348813735232427', function(response) {
      console.log(response.data.length);
        if (response.data.length == 1) {
//            alert("page liked already");
            $(".game_content").show();
            $(".like_fb_page").hide();
        } else {
//            alert("page is NOT liked ");
             $(".game_content").hide();
             $(".like_fb_page").show();
        }
    });
  }

</script>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/bg_BG/all.js#xfbml=1&appId=685816038129660";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>

<div style="display:none;" class="like_fb_page">
  <fb:like href="http://www.facebook.com/getlokal.rs" layout="button_count" action="like" show_faces="false" share="false"></fb:like>
  <?php echo image_tag('facebook/v2/mallorca_1.jpg', array('style' => 'margin:50px 0;')) ?>
</div>
<?php endif; ?>

<?php if($sf_user->getCountry()->getSlug() == 'sr'): ?>
<fb:like href="http://www.facebook.com/getlokal.rs" layout="button_count" action="like" show_faces="false" share="false"></fb:like>
<div style="display:none;" class="game_content">
<?php endif; ?>

<div class="<?php echo $sf_user->getCountry()->getSlug() ?>">
  <div class="top">
    <?php if ($sf_user->getCountry()->getSlug() == 'ro'):?>
      <div class="app_icon">
        <?php echo link_to(image_tag('facebook/v2/app.png', 'align=left').__('Get our<br />free app!'), 'http://app.getlokal.com/app/ro/?utm_source=reviewromania&utm_medium=facebook&utm_campaign=reviewromania', 'target=_blank')?>
      </div>
    <?php elseif ($sf_user->getCountry()->getSlug() == 'sr'): ?>
      <div class="app_icon">
        <?php echo link_to(image_tag('facebook/v2/app.png', 'align=left').__('Get our<br />free app!'), 'http://app.getlokal.com/?lang=sr', 'target=_blank')?>
      </div>
    <?php endif;?>
    <?php echo image_tag('facebook/v2/dots.png', 'class=dots') ?>
  <?php if($sf_user->getCountry()->getSlug() == 'bg'): ?>
    <a href="http://www.getlokal.com/bg/page/rules-reivew-mania3" target="_blank" class="rules"><?php echo __('Rules &amp; Prizes') ?></a>
  <?php elseif($sf_user->getCountry()->getSlug() == 'mk'): ?>
    <a href="http://www.getlokal.mk/mk/page/reviewmania-rules" target="_blank" class="rules"><?php echo __('Rules &amp; Prizes') ?></a>
  <?php elseif($sf_user->getCountry()->getSlug() == 'sr'): ?>
    <?php /*<a href="http://www.getlokal.rs/sr/page/rules-reviewmania-x3" target="_blank" class="rules"><?php echo __('Rules &amp; Prizes') ?></a> */?>
  <?php else: ?>
    <a href="http://blog.getlokal.ro/2012/11/am-lansat-reviewromania-776" target="_blank" class="rules"><?php echo __('Rules &amp; Prizes') ?></a>
  <?php endif ?>
</div> <!-- top -->

  <form action="" method="post" id="step1">
    <input type="hidden" name="next" value="1" />
    <div class="header">
      <div class="avatar"><img src="https://graph.facebook.com/<?php echo $sf_user->getProfile()->getFacebookUid() ?>/picture?type=normal" /></div>
      <div class="background">
        <p class="user"><?php echo __('Welcome <span>%s</span>', array('%s' => $sf_user->getProfile()->getFirstName())) ?>,</p>
        <?php if($count > 0): ?>
		  <?php if($sf_user->getCountry()->getSlug() == 'sr'): ?>
			<p class="info"><?php echo __('Help others with lokal information by reviewing and rating places on getlokal!') ?></p>
			<p class="places"></p>			
			<p class="places"><?php echo __('So far, you’ve helped others with lokal information about').' '.format_number_choice('[1]1 place|(1,+Inf]%s places', array('%s' => $count), $count, 'messages') ?>		
		  <?php else: ?>
          <p class="info"><?php echo __('So far, you’ve helped others with lokal information about') ?></p>
          <p class="places"><?php echo format_number_choice('[1]1 place|(1,+Inf]%s places', array('%s' => $count), $count, 'messages') ?></p>
		  <?php endif ?>		  
        <?php else: ?>
          <p class="info"><?php echo __('Help others with lokal information by reviewing and rating places on getlokal!') ?></p>
          <p class="places"></p>
        <?php endif ?>
        <p class="lokal"><?php echo __('Your lokal city is <span>%s</span>', array('%s' => $city)) ?><input type="text" value="<?php echo $city ?>" class="city" style="display: none;" /></p>
        <input type="hidden" name="city_id" value="<?php echo $city->getId() ?>" id="city_id" />
        <a href="#" class="submit button city"><?php echo __('Change city') ?></a>
      </div>
    </div>

    <p class="italics"><?php echo __('feel free to modify the selection<br />to match your preference') ?></p>

    <div class="pins">
      <?php foreach($sectors as $i => $sector): ?>
        <a href="#" class="p0<?php echo $i+1 ?> selected"><span>
          <?php echo $sector ?>
          <input type="checkbox" name="sector_id[]" value="<?php echo $sector->getId() ?>" style="display: none;" checked="checked"/>
          <span class="selected">- <?php echo __('SELECTED') ?> -</span>
        </span></a>
      <?php endforeach ?>
      <div class="clear"></div>
    </div> <!-- pins -->

    <div class="clear"></div>
    
    <div class="nextbtn">
      <?php echo image_tag('facebook/v2/next1.gif') ?>
      <input type="submit" class="step" value="<?php echo __('Next step') ?>">
      <?php echo image_tag('facebook/v2/next3.gif', "onclick=$('#step1').submit()") ?>
      <div class="clear"></div>
    </div>
    
  </form>

  <div class="partners">
    <?php if($sf_user->getCountry()->getSlug() == 'ro'): ?>
      <?php include_partial('footer2_ro') ?>
    <?php elseif($sf_user->getCountry()->getSlug() == 'bg'): ?>
      <?php include_partial('footer2_bg') ?>
    <?php elseif($sf_user->getCountry()->getSlug() == 'mk'): ?>
      <?php include_partial('footer2_mk') ?>
	    <?php elseif($sf_user->getCountry()->getSlug() == 'sr'): ?>
      <?php include_partial('footer2_sr') ?> 
    <?php endif ?>
  </div>
</div>

<?php if($sf_user->getCountry()->getSlug() == 'sr'): ?>
</div>
<?php endif; ?>

<script type="text/javascript">
$(function() {
  $('.button.city').click(function() {
    $('input.city').toggle();
    $('.lokal span').toggle();
    
    if($('.lokal span').is(':visible'))
      $('.lokal span').html($('input.city').val());
    
    return false;
  })
  
  $( "input.city" ).autocomplete({
      source: "<?php echo url_for('facebook/autocompleteCity') ?>",
      minLength: 2,
      select: function( event, ui ) {
        $('#city_id').val(ui.item.id)
      }
  });
  
  $('.pins a').click(function() {
    $(this).toggleClass('selected');
    $(this).find('input').attr('checked', $(this).hasClass('selected'));
    return false;
  })
})
</script>

<?php if($sf_user->getCountry()->getSlug() == 'sr'): ?>
<script type="text/javascript">
$(function() {

  FB.Event.subscribe('edge.create',
  function() {
    window.location.reload();
  }
  );
})
</script>
<?php endif; ?>
