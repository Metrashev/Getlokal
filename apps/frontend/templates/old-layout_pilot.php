<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml" xml:lang="en" lang="en" <?php echo ($sf_request->getParameter('module')=='event'? 'class="special"': '' );?>>

  <head>
    <title>Getpilot - Getlokal</title>

    <?php include_http_metas() ?>
    <?php include_metas() ?>

    
    <?php if (has_slot('keywords')): ?>
      <meta name="keywords" content="<?php echo get_slot('keywords') ?>" />
    <?php endif ?>

    <?php if (has_slot('description')): ?>
      <meta name="description" content="<?php echo get_slot('description') ?>" />
    <?php endif;?>
    <meta name="p:domain_verify" content="6e2b3488e1c589cb20f7c90a61fd85db"/>

    <link rel="shortcut icon" href="/images/gui/favicon.ico" />
    <link href='http<?php echo (@$_SERVER['HTTPS'])?'s':'';?>://fonts.googleapis.com/css?family=Open+Sans:300,400,700&subset=latin,cyrillic-ext,greek-ext,greek,latin-ext,cyrillic' rel='stylesheet' type='text/css' />

    <?php include_stylesheets() ?>
      
    <script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-1443488-8']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

  </script>


    <?php include_javascripts() ?>
    
  <?php include_partial('global/google_analytics');?>
        
  </head>

  <body>

    <div id="fb-root"></div>
    <script type="text/javascript">
        (function(d, s, id){
             var js, fjs = d.getElementsByTagName(s)[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement(s); js.id = id;
             js.src = (location.protocol=='http:'?'http':'https') + "://connect.facebook.net/en_US/all.js#xfbml=1";
             fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <?php echo $sf_content ?>
   </body>
</html>
<script type="text/javascript">
    $(document).ready(function() {

     $("#delay_demo").addClass("activation");

 setTimeout(function()
         {
        $('.welcome_message').show();
         }, 300);


    setTimeout(function()
         {
        $('.welcome_message').hide();
         }, 12000);

    });


</script>
