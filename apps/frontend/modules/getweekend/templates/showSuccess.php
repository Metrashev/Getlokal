<?php slot('facebook') ?>
<?php slot('no_ads') ?>
<meta property="og:url" content="<?php echo $url ?>">
<meta property="og:title" content="<?php echo $item->getTitle() ?>">
<meta property="og:description" content="<?php echo $item->getBody() ?>">
<meta property="og:type" content="video">
<meta property="og:image" content="<?php echo image_path($item->getThumb(), true) ?>">
<meta property="og:video" content="http://www.youtube.com/v/<?php echo $item->getEmbed() ?>">
<meta property="og:video:type" content="application/x-shockwave-flash">
<meta property="og:video:width" content="1280">
<meta property="og:video:height" content="720">
<?php end_slot() ?>
<?php use_javascript('scrollbar.js') ?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=289748011093022";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="getweekend">
<?php   /*
 	<div class="about">
  <?php if ($sf_user->getCountry()->getId() ==  getlokalPartner::GETLOKAL_BG ):?>
  	<span class="image"><?php echo image_tag('getweekend/getweekend1_Rumi.png') ?></span>
    <h2><?php echo __('getWeekend for fun!') ?></h2>
    <p style="margin-bottom: 0.5em;"><?php echo __('Meet Rumi, our getWeekend Girl. Every week Rumi sorts through all the different events and selects the best concerts, parties, art exhibitions, festivals, sports, and fashion activities so you can plan the perfect weekend.') ?></p>

    <p><?php echo __('getWeekend is a production from getlokal –Bulgaria\'s most exciting website for recommendations and reviews. You can see us online at any time /youtube & facebook/ and live on Travel TV, Travel HD, and Community TV') ?></p>

  <?php elseif ($sf_user->getCountry()->getId() ==  getlokalPartner::GETLOKAL_RO ):?>
	<span class="image"><?php echo image_tag('getweekend/icon.png') ?></span>
    <h2>GetLokal Girl</h2>
    <p style="margin-bottom: 0.5em;"><?php echo __('Every week, discover with our getlokal Girl the stories of the city and the events that must not be missed: concerts, parties, art expos, theatre performances or music festivals, alternative classes or board game championships!') ?></p>

    <p><?php echo __('GetWeekend is a getlokal.ro project - we are offering you inspiration for your free time and we have the best going out recommendations!') ?></p>
    <?php endif;?>
	<div class="clear"></div>
  </div>
*/ ?>
  <div class="content">
    <h1>getWeekend</h1>
    <h2><?php echo $item->getTitle() ?></h2>
    <iframe width="925" height="520" src="http://www.youtube.com/embed/<?php echo $item->getEmbed() ?>?rel=0" frameborder="0" allowfullscreen></iframe>
    <div class="social">
      <iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode($url) ?>&amp;send=false&amp;layout=button_count&amp;width=130&amp;show_faces=false&amp;action=recommend&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=289748011093022" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:130px; height:21px;" allowTransparency="true"></iframe>

      <iframe allowtransparency="true" frameborder="0" scrolling="no" src="https://platform.twitter.com/widgets/tweet_button.html" style="width:130px; height:20px;"></iframe>
    </div>
    <p><?php echo $item->getBody() ?></p>
  </div>

  <div class="related" style="padding-top: 25px;">
    <div class="fb-comments" data-href="<?php echo $url ?>" data-num-posts="10" data-width="925"></div>
  </div>

  <?php if(count($item->getCompanies()) || count($item->getEvents())) : ?>
  <div class="related">
  <?php if(count($item->getCompanies())) : ?>
    <div class="col left">
      <h3><?php echo __('Featured Places') ?></h3>
      <div class="scroll">
        <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
        <div class="viewport">
        <ul class="overview">
          <?php foreach($item->getCompanies() as $company): ?>
          <li>
            <?php echo link_to(image_tag($company->getThumb(), 'size=80x80 alt=' . $company), $company->getUri(ESC_RAW), 'class=image title=' . $company) ?>
            <div class="details">
              <?php echo link_to($company, $company->getUri(ESC_RAW), 'class=title title=' . $company) ?>
              <?php echo link_to($company->getClassification(), $company->getClassificationUri(ESC_RAW), 'class=more title=' . $company->getClassification()) ?>
            </div>

            <div class="clear"></div>
          </li>
          <?php endforeach ?>
        </ul>
        </div>
      </div>
    </div>
	<?php endif;?>
	
	<?php if(count($item->getEvents())) : ?>
    <div class="col right">
      <h3><?php echo __('Events') ?></h3>
      <div class="scroll">
        <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
        <div class="viewport">
        <ul class="overview">
          <?php foreach($item->getEvents() as $event): ?>
          <li>
            <?php echo link_to(image_tag($event->getThumb(), 'size=80x80 alt=' . $event), $event->getUrl(ESC_RAW), 'class=image title=' . $event) ?>
            <div class="details">
              <?php echo link_to($event, $event->getUrl(ESC_RAW), 'class=title title='.$event) ?>
              <?php echo link_to($event->getCategory(), $event->getCategoryUrl(ESC_RAW), 'class=more title=' . $event->getCategory()) ?>
            </div>

            <div class="clear"></div>
          </li>
          <?php endforeach ?>
        </ul>
        </div>
      </div>
    </div>
	<?php endif;?>

    <div class="clear"></div>
  </div>

  <?php endif; ?>
  
  <div class="others">
    <h3><?php echo __('Other Episodes') ?></h3>
    <div class="carousel">
      <ul>
        <?php foreach($others as $i => $item): ?>
          <li>
            <?php echo link_to(image_tag($item->getThumb(), array('alt' => $item->getTitle())), 'getweekend/show?id='. $item->getId(), array('title' => $item->getTitle())) ?>
            <?php echo link_to($item->getTitle(), 'getweekend/show?id='. $item->getId(), array('title' => $item->getTitle())) ?>
          </li>
          <?php if($i%3==2):?>
            <li class="clear"></li>
          <?php endif ?>
        <?php endforeach ?>
      </ul>
    </div>
    <?php /*<div class="dots">
      <a href="#" class="active"></a>
      <a href="#"></a>
      <a href="#"></a>
      <div class="clear"></div>
    </div>*/?>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  /*_x = 0;
  $('.others .dots a').click(function() {
    $('.others .dots a').removeClass('active');
    $(this).addClass('active');
    _x = $(this).index() * 925 * -1;
    $('.carousel ul').animate({'left': _x});

    return false
  })*/

  $('.left .scroll').tinyscrollbar();
  $('.right .scroll').tinyscrollbar();

})
</script>