<div class="wrapInner">
    <div class="done">
        <div class="left_wrap">
                <?php //<img src="/images/facebook/v1/bg/bg_award.png" /> ?>
                <?php echo image_tag($image->getFile()->getUrl()); ?>
                <div class="drink_wrap">
                        <p class="drink_title">и пиеш:</p>
                        <div class="a<?php echo $drink; ?>"></div>
                </div>
        </div>
        <div class="right_wrap">
                <a class="rules" href="http://www.getlokal.com/bg/page/promo-rules" target="_blank">Правила на играта</a>
                <div class="right_content">
                        <p>Можеш да споделиш твоето парти име с приятелите си</p>
                        <a class="share button button_left button_first" href="#">сподели във facebook</a>
                        <a class="invite button button_left" href="#">покани приятел</a>
                        <div class="clear"></div>
                        <a class="button button_center button_big" href="<?php echo url_for('facebook/game1bg?reset=1') ?>">Играй отново</a>
                </div>
        </div>
    </div>
</div>

<div id="fb-root"></div>
<script src="//connect.facebook.net/en_US/all.js"></script>

<script type="text/javascript">
FB.init({
  appId  : '135295206626676',
  frictionlessRequests: true
});

$('a.share').click(function() {
  FB.ui({
    method: 'stream.publish',
    message: 'Сподели с приятели парти името си!',
    attachment: {
      name: 'Как е твоето парти име?',
      caption: 'Моето парти име е <?php echo $name ?>',
      description: (
        'Научи своето парти име и спечели iPad mini!'
      ),
      href: 'http://apps.facebook.com/getlokal-pname-bg',
      media: [
        {
          type: 'image',
          href: '<?php echo $image->getFile()->getUrl(null, true) ?>',
          src: '<?php echo $image->getFile()->getUrl(null, true) ?>'
        }
      ],
    },
    action_links: [
      { text: 'fbrell', href: 'http://apps.facebook.com/getlokal-pname-bg' }
    ],
    user_prompt_message: 'Сподели с приятели'
  });
})

$('a.invite').click(function() {
  FB.ui({method: 'apprequests',
    message: 'Покани приятелите си и спечели iPad mini!'
  }, requestCallback);
})

function requestCallback(response) {
  // Handle callback here
}

</script>