<header class="getApp">
  <?php echo image_tag('mobile/redirecto-logo.png') ?>
</header>

<section class="getApp">
  <p>
    Getlokal mobile app is available for Android and iOS. You will be redirect to the appropriate store in 3s. If you are not redirected please click one of the two:
  </p>

  <ul>
    <li>iPhone, iPad or iPod touch: <?php echo link_to('download now from App Store', $url['apple'])?></li>
    <li>Android devices: <?php echo link_to('get it now from Google Play', $url['google'])?></li>
  </ul>

  <p>For more details see <?php echo link_to('our app site', 'http://app.getlokal.com')?>.</p>
</section>

<script>

    (function(i,s,o,g,r,a,m){iGoogleAnalyticsObject?=r;i[r]=i[r](i[r].q=i[r].q
    function(){
    []).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-1443488-20', 'auto');
    ga('send', 'pageview');

</script>