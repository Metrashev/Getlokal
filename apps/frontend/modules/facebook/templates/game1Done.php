<div id="fb-root"></div>
<script src="//connect.facebook.net/en_US/all.js"></script>
<div class="done">
  <?php echo image_tag($image->getFile()->getUrl()) ?>
  
  <h1>Arată-le și prietenilor tăi ce nume fain ai:</h1>
  
  <div class="share">
    <span>Pe Wall</span>
    <a href="#"></a>
    <div class="clear"></div>
  </div>
  <div class="embed">
    <span>Pe blogul tau</span>
    <textarea rows="1"><a href="http://www.getlokal.ro/"><?php echo image_tag($image->getFile()->getUrl(null, true), 'border=0') ?></a><br><a href="https://apps.facebook.com/getlokal-party-name/">Află și tu</a> care este numele tău lokalnic de PARTY.</textarea>
    <div class="clear"></div>
  </div>
  <div class="clear"></div>
  
  <div class="invite">
    <h1>Vezi ce nume au și prietenii tăi</h1>
    <a href="#"></a>
  </div>
  <div class="again">
    <h1>Nu-ți place numele?<br/>Răspunde la întrebări</h1>
    <a href="<?php echo url_for('facebook/game1?reset=1') ?>"></a>
  </div>
  
  <div class="clear"></div>
</div>

<script type="text/javascript">
FB.init({
  appId  : '293718400743527',
  frictionlessRequests: true
});

$('.share a').click(function() {
  FB.ui({
    method: 'stream.publish',
    message: 'Arată-le prietenilor tăi numele tău de party!',
    attachment: {
      name: 'Care e numele tau de party?',
      caption: 'Eu am aflat ca numele meu de party este <?php echo $name ?>',
      href: 'http://apps.facebook.com/getlokal-party-name',
      media: [
        {
          type: 'image',
          href: '<?php echo $image->getFile()->getUrl(null, true) ?>',
          src: '<?php echo $image->getFile()->getUrl(null, true) ?>'
        }
      ],
    },
    action_links: [
      { text: 'fbrell', href: 'http://apps.facebook.com/getlokal-party-name' }
    ],
    user_prompt_message: 'Arată-le şi prietenilor tăi'
  });
})

$('.invite a').click(function() {
  FB.ui({method: 'apprequests',
    message: 'Află şi tu care e numele tău de party şi poţi câstiga un iPad'
  }, requestCallback);
})

function requestCallback(response) {
  // Handle callback here
}

</script>
