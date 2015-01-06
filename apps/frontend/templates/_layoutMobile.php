<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html class="<?=($device == 'iPhone' ? 'iphone-bg' : 'andr-bg')?>" xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml" xml:lang="en" lang="en">
<head>
    <?php include_page_title() ?>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <link rel="shortcut icon" href="/images/gui/favicon.ico?v=2" />
    <link rel="apple-touch-icon" href="/images/gui/apple-touch-icon.png" />
    <link rel="apple-touch-icon-precomposed" href="/images/gui/apple-touch-icon-precomposed.png" />
    <link rel="stylesheet" type="text/css" href="/css/mobile/mobile_fonts.css">
    <link rel="stylesheet" type="text/css" href="/css/mobile/mobile-landing.css">
	<meta name="viewport" content="width=device-width">
</head>
<body>
<?php
    if($device == 'iPhone'){
		include_component('mobilepop', 'ios');
		return sfView::NONE;
	}else{
		include_component('mobilepop', 'android');
		return sfView::NONE;
	}
?>
</body>
</html>