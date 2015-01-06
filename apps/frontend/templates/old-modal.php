<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <?php include_slot("fb_meta"); ?>
    <link href='http<?php echo (@$_SERVER['HTTPS'])?'s':''; ?>://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href='http<?php echo (@$_SERVER['HTTPS'])?'s':''; ?>://fonts.googleapis.com/css?family=Open+Sans&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css' />
    <link rel="shortcut icon" href="/images/gui/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <?php if (!in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) : ?>
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
    <?php endif; ?>

    <?php
        include_slot("fb_meta");
    ?>

  </head>
  <body>
  <div class="wrap">
    <?php echo $sf_content ?>
    </div>
  </body>
</html>
