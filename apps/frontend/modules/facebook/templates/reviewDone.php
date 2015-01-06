<?php use_javascript('scrollbar.js') ?>
<div id="fb-root"></div>
<script src="//connect.facebook.net/en_US/all.js"></script>

<div class="top">
  <?php if ($sf_user->getCountry()->getSlug() == 'ro'):?>
     <div class="app_icon"> 
       <?php echo link_to(image_tag('facebook/v2/app.png', 'align=left').__('Get our<br />free app!'), 'http://app.getlokal.com', 'target=_blank')?>
     </div>
  <?php elseif ($sf_user->getCountry()->getSlug() == 'sr'): ?>
      <div class="app_icon">
        <?php echo link_to(image_tag('facebook/v2/app.png', 'align=left').__('Get our<br />free app!'), 'http://app.getlokal.com/?lang=sr', 'target=_blank')?>
      </div>
  <?php endif;?>
  <?php echo link_to(image_tag('facebook/v2/dots_2.png'), 'facebook/review', 'absolute=true class=dots') ?>
  
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


<div class="header2">
  <p class="page_title">
    <?php echo format_number_choice('[0]We found <span>%s</span> places on getlokal that match your search criteria.|[1]We found <span>1</span> place on getlokal that match your search criteria.|(1,+Inf]We found <span>%s</span> places on getlokal that match your search criteria.', array('%s' => $count),  $count,'messages'); ?>
  </p>
  
  <p class="class">
    <?php foreach($sectors as $i => $sector): ?>
      <?php echo $sector ?> <?php if($i < count($sectors) - 1) echo '/' ?>
      <input type="hidden" name="sector_id[]" value="<?php echo $sector->getId() ?>" class="sectors" />
    <?php endforeach ?>
     
    <input type="hidden" name="city_id" value="<?php echo $city->getId() ?>" class="sectors" />
    <span class="bold"><?php echo __('in') ?> <?php echo $city->getDisplayCity() ?></span>.
  </p>
  <a href="<?php echo url_for('facebook/review') ?>" class="submit button"><?php echo __('Change filtering') ?></a>
</div>

<div class="chance <?php echo $sf_user->getCulture() ?>">
  <div class="image"><img src="https://graph.facebook.com/<?php echo $sf_user->getProfile()->getFacebookUid() ?>/picture?type=normal" /></div>
  <div class="background">
    <div class="reviews">
      <div><?php echo format_number_choice('[0]<b>0</b> reviews|[1]<b>1</b> review|(1,+Inf]<b>%s</b> reviews', array('%s' => $reviews_count), $reviews_count,'messages'); ?></div>
      <?php echo format_number_choice('[0]<b>0</b> chances|[1]<b>1</b> chance|(1,+Inf]<b>%s</b> chances', array('%s' => floor($reviews_count / 3)), floor($reviews_count / 3),'messages'); ?>
    </div>
    <div class="clear"></div>
  </div>
</div>


<div class="noResults" style="display: <?php echo $count > 2?'none':'block'; ?>">
  <span><?php echo __('PUT YOUR CITY ON THE GETLOKAL MAP') ?></span>
  <a href="<?php echo url_for('company/addCompany') ?>" target="_blank" class="submit button pink"><?php echo __('Add а New Place') ?></a>
</div>

<?php if($sf_user->getCountry()->getSlug() == 'ro' OR $sf_user->getCountry()->getSlug() == 'sr'): ?>
  <p class="bottom"><?php echo __('Help your lokal community take informed decisions by writing a short review about your experience in any of the places below. If you haven’t been there, you can skip a place.') ?></p>
<?php endif ?>

<?php foreach($places as $place): ?>
  <?php include_partial('placeBox', array('company' => $place, 'form' => new ReviewForm())) ?>
<?php endforeach ?>

<div class="clear"></div>

<?php if($sf_user->getCountry()->getSlug() != 'ro' AND $sf_user->getCountry()->getSlug() != 'sr'): ?>
  <p class="bottom"><?php echo __('Help your lokal community take informed decisions by writing a short review about your experience in any of the places below. If you haven’t been there, you can skip a place.') ?></p>
<?php endif ?>

<div class="chance second <?php echo $sf_user->getCulture() ?>">
  <div class="image"><img src="https://graph.facebook.com/<?php echo $sf_user->getProfile()->getFacebookUid() ?>/picture?type=normal" /></div>
  <div class="background">
    <div class="reviews">
      <div><?php echo format_number_choice('[0]<b>0</b> reviews|[1]<b>1</b> review|(1,+Inf]<b>%s</b> reviews', array('%s' => $reviews_count), $reviews_count,'messages'); ?></div>
      <?php echo format_number_choice('[0]<b>0</b> chances|[1]<b>1</b> chance|(1,+Inf]<b>%s</b> chances', array('%s' => floor($reviews_count / 3)), floor($reviews_count / 3),'messages'); ?>
    </div>
    <div class="clear"></div>
  </div>
</div>

<div class="overlay" style="display: none;"></div>
<div class="lightbox" style="display: none;">
  <a href="#" class="play" style="float:left" title="<?php echo __('Play again') ?>">
    <?php echo image_tag('facebook/v2/play-again.png', 'align=absmiddle') ?> <?php echo __('Play again')?>
  </a>
  <a href="#" class="close"><?php echo image_tag('facebook/v2/reload.png') ?></a>
  <h2><?php echo __('Congratulations') ?></h2>

  <p><?php echo __('You just scored <strong>1 chance</strong> for the getlokal prizes'); ?></p>

  <div><?php echo __('In total you have written <strong class="reviews"><span>%s</span> reviews</strong> and you have', array('%s' => $reviews_count));?>
  <?php echo __('<strong class="chance"><span>%s chances</span></strong>', array('%s' => floor($reviews_count / 3)));?></div>

  <a href="#" class="submit button share"><?php echo __('Share this on your wall') ?></a>
  <a href="#" class="submit button pink invite"><?php echo __('Invite your friends to play') ?></a>
  
  
</div>

<div class="partners">
  <div style="width: 550px; margin: 0 auto;">
    <a href="#" class="submit button share" style="float: left; width: 200px;"><?php echo __('Share this on your wall') ?></a>
    <a href="#" class="submit button pink invite" style="float: right; width: 200px;"><?php echo __('Invite your friends to play') ?></a>
    <div class="clear"></div>
  </div>
  
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

<script type="text/javascript">
FB.init({
  appId  : '<?php echo $app_id[$sf_user->getCountry()->getSlug()] ?>',
  frictionlessRequests: true
});
FB.Canvas.scrollTo(0,0);
$(function() {
  var submited = false;

  $('.lightbox .play').click(function() {
    $('.reload').click();
    $('.lightbox .close').click();
    return false;
  });
  
  $('.lightbox .close').click(function() {
    $('.overlay').hide();
    $('.lightbox').hide();
    
    return false;
  })
  
  $('.invite').click(function() {
    FB.ui({method: 'apprequests',
      message: '<?php echo __('Write reviews for the places in your city and you can win cool prizes from getlokal.') ?>'
    }, function() {
      $('.overlay').hide();
      $('.lightbox').hide();
    });
    return false;
  })
  
  $('.share').click(function() {
    FB.ui({
      method: 'stream.publish',
      message: '<?php echo __('fb_share_message') ?>',
      attachment: {
        name: '<?php echo __('fb_share_title') ?>',
        caption: '<?php echo __('fb_share_caption', array('%url' => url_for($sf_user->getProfile()->getUrl(), true))) ?>',
        description: (
          ' '
        ),
        href: 'http://apps.facebook.com/reviewmania-x-<?php echo $sf_user->getCountry()->getSlug() ?>',
        media: [
          {
            type: 'image',
            href: 'http://apps.facebook.com/reviewmania-x-<?php echo $sf_user->getCountry()->getSlug() ?>',
            src: '<?php echo image_path('facebook/v2/share.jpg', true) ?>'
          }
        ],
      },
      action_links: [
        { text: 'fbrell', href: 'http://apps.facebook.com/reviewmania-x-<?php echo $sf_user->getCountry()->getSlug() ?>' }
      ],
      user_prompt_message: '<?php echo __('fb_share_user_promp_message') ?>'
    });
    
    return false;
  })
  
  $('.review_form').submit(function() {
    var element = this;
    
    if(submited) return false;
    submited = true;
    
    $.ajax({
      url:      element.action,
      type:     'POST',
      data:     $(this).serialize(),
      success:  function(data) {
        $(element).html(data);
        submited = false;
      }
    });
    
    return false;
  })

})
var init = function(id) {
  var submited = false;
  
  if(!$('.place_box').length) {
    $('.noResults').show();
    $('.chance.second').hide();
  }
  
  $('.star').removeClass('checked');
  
  $('.other_reviews').tinyscrollbar();
  
  $('.rating').parent().each(function(i,s) {
    $(s).find('.star:lt('+ $(s).parent().find('.rating').val() +')').addClass('checked');    
  })
  
  
  $('#'+id +' .reload').click(function() {
    var element = $(this).parent().parent();
    $.ajax({
      url:  '<?php echo url_for('facebook/loadReview') ?>',
      data: element.serialize() + '&' + $('.ids').serialize() + '&' + $('.sectors').serialize(),
      success: function(data) {
        element.html(data);        
      }
    })
    
    return false;
  })
    
  $('.star').click(function() {
    $(this).parent().find('.star:lt('+ this.rel +')').addClass('checked');
    $(this).parent().find('.rating').val(this.rel);
    return false;
  }).hover(function() {
    $(this).parent().find('.star').removeClass('checked');
    $(this).parent().find('.star:lt('+ this.rel +')').addClass('checked');
  }, function() {
    $(this).parent().find('.star').removeClass('checked');
    $(this).parent().find('.star:lt('+ $(this).parent().find('.rating').val() +')').addClass('checked');
  })
  
  $('label').each(function(i,s) {
    $(s).click(function() {
      $(this).parent().find('textarea').focus();
    })
    if($(s).parent().find('textarea').val()) $(s).hide();
    if($(s).parent().find('.error_list').length) $(s).hide();
  })
  
  $('.body textarea').focus(function() {
    $(this).parent().find('label, .error_list').hide();
  }).blur(function() {
    if(!$(this).val()) $(this).parent().find('label, .error_list').show();
  })
}
</script>