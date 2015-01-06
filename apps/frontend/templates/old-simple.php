<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml" xml:lang="en" lang="en">
    <head>
    <?php include_page_title() ?>

    <?php include_http_metas() ?>
    <?php include_metas() ?>

    <?php if (has_slot('canonical')): ?>
      <?php echo get_slot('canonical')?>
    <?php endif;?>

    <?php echo get_slot('facebook')?>
    <?php echo get_slot('facebook_article_script')?>

    <?php if (has_slot('keywords')): ?>
      <meta name="keywords" content="<?php echo get_slot('keywords') ?>" />
    <?php endif ?>

    <?php if (has_slot('description')): ?>
      <meta name="description" content="<?php echo get_slot('description') ?>" />
    <?php endif;?>
    <meta name="p:domain_verify" content="6e2b3488e1c589cb20f7c90a61fd85db"/>

    <link rel="shortcut icon" href="/images/gui/favicon.ico" />
    <link href='http<?php echo (@$_SERVER['HTTPS'])?'s':'';?>://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=latin,cyrillic-ext,greek-ext,greek,latin-ext,cyrillic' rel='stylesheet' type='text/css' />

    <?php include_stylesheets() ?>

    <?php include_javascripts() ?>

    <script type='text/javascript'>
      var googletag = googletag || {};
      googletag.cmd = googletag.cmd || [];
      (function() {
      var gads = document.createElement('script');
      gads.async = true;
      gads.type = 'text/javascript';
      var useSSL = 'https:' == document.location.protocol;
      gads.src = (useSSL ? 'https:' : 'http:') +
      '//www.googletagservices.com/tag/js/gpt.js';
      var node = document.getElementsByTagName('script')[0];
      node.parentNode.insertBefore(gads, node);
      })();
    </script>

    <?php include_partial('global/google_analytics');?>
  </head>
    <body>
    <?php include_partial('global/header', array('form'=> new sfGuardFormSignin(), 'no_map' => true)) ?>

    <div class="page_wrap">
      <?php echo $sf_content; ?>
      <?php include_partial('global/footer') ?>
    </div>
  </body>
</html>
