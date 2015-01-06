<?php use_stylesheet('facebook/gameGetLove.css') ?>
<div id="fb-root"></div>
<script src="//connect.facebook.net/en_US/all.js"></script>
<div class="done">

  <?php echo image_tag($image->getFile()->getUrl()) ?>
  
  <div class="bottom">
    <a href="#" class="share">Da share pe Wall</a>
    <a href="#" class="invite">Invită-ți prietenii</a>
    <a href="<?php echo url_for('facebook/getLove?from=getLove') ?>" class="again">Din nou?</a>
  </div>
  <div class="clear"></div>
</div>

<script type="text/javascript">
FB.init({
  appId  : '127234997453806',
  frictionlessRequests: true
});
var friend = '<?php echo $friend_name;?>';
$('.share').click(function() {
  FB.ui({
    method: 'stream.publish',
    message: "Cu getLove by @getlokal am aflat detalii despre relatia mea pe Facebook cu ' + friend + '! Incerci si tu? http://apps.facebook.com/getlokal-getlove!",
    attachment: {
      name: 'getLove - Vezi cate lucruri aveti in comun!',
      caption: 'Alege-ti un prieten din lista de pe Facebook (iubit/iubita sau un simplu amic) si aplicatia getLove iti genereaza date despre relatia voastra - ce filme va plac, locuri in care iesiti, artisti pe care ii ascultati impreuna sau separat! Cine stie, poate e un motiv bun sa-ti redescoperi relatia sau sa afli ceva nou despre ea! In plus, daca postezi poza-rezultat pe wall poti sa castigi (prin tragere la sorti) si cateva premii de la partenerii getlokal.ro: Coftale, Bacania cu suflet, Sequin Beauty, Sky Karting si Metamorphosis Style. Succes!',
      description: (
        'Incerci si tu? http://apps.facebook.com/getlokal-getlove'
      ),
      href: 'http://apps.facebook.com/getlokal-getlove',
      media: [
        {
          type: 'image',
          href: '<?php echo $image->getFile()->getUrl(null, true) ?>',
          src: '<?php echo $image->getFile()->getUrl(null, true) ?>'
        }
      ],
    },
    action_links: [
      { text: 'fbrell', href: 'http://apps.facebook.com/getlokal-getlove' }
    ],
    user_prompt_message: 'Arată-le şi prietenilor tăi'
  });
  
  return false;
})

$('.invite').click(function() {
  FB.ui({method: 'apprequests',
    message: 'Am descoperit o aplicatie faina! O incerci si tu?'
  }, requestCallback);
  
  return false;
})

function requestCallback(response) {
  // Handle callback here
}

</script>