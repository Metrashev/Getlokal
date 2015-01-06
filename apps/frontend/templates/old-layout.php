<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <?php  if (isset($_COOKIE['visit']) && $_COOKIE['visit'] == "true") : ?>
       <?php else:?> 
      <?php setcookie("visit", "true", time() + 600*6, '/'); ?>
    <?php $device = '';?>
		 <?php if(stristr($_SERVER['HTTP_USER_AGENT'],"iPhone")):?> 
			<?php $device = "iPhone";?>
                        <?php $bodyClass = 'iphone-bg'?>
		 <?php elseif( stristr($_SERVER['HTTP_USER_AGENT'],'android') ) :?>
            	 <?php	$device = "android";?>
                    <?php $bodyClass = 'andr-bg'?>
		<?php// else:?>
                    <?php // $device = "desktop"; ?>
                    <?php // $bodyClass = 'andr-bg'?>
                <?php endif;?>
		<?php if ($device == 'android' or $device == 'iPhone'):?>
<html class="<?php echo $bodyClass;?>" xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml" xml:lang="en" lang="en">
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

        <?php if($sf_user->getCountry()->getSlug() == 'ro'): ?>
          <meta name="p:domain_verify" content="adb09443ff261f2b10c46d103e43c7b2"/>
        <?php else: ?>
          <meta name="p:domain_verify" content="6e2b3488e1c589cb20f7c90a61fd85db"/>
        <?php endif; ?>
        
        <?php if(has_slot('meta_noindex_follow')):?>
        	<meta name="robots" content="noindex,follow" />
        <?php endif;?>
        <link rel="stylesheet" href="css/font-awesome.min.css" />
		<link rel="stylesheet" href="css/bootstrap.css" >
		<link rel="stylesheet" href="css/style.css" />
		<link rel="shortcut icon" type="image/x-icon" href="/../css/images/favicon.ico" />
		<script type="text/javascript" src="js/jquery.js"></script>
		<link rel="stylesheet" type="text/css" href="css/style1.css" media="screen" />
		<script type="text/javascript" src="js/jquery.themepunch.tools.min.js"></script>
		<script type="text/javascript" src="js/jquery.themepunch.revolution.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/settings.css" media="screen" />
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
                   <?php
                  switch ($device):
                      case 'iPhone':
                          include_component('mobilepop', 'ios');
                          return sfView::NONE;
                          break;
                      case 'android':
                           include_component('mobilepop', 'android');
                            return sfView::NONE;
                          break;
                      default:
                          continue;
                          break;
                  endswitch;
                  ?>
    </body>
</html>   
	<?php endif;?>
	<?php endif;?>


<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml" xml:lang="en" lang="en" <?php echo ($sf_request->getParameter('module')=='event'? 'class="special"': '' );?>>

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

    <?php if($sf_user->getCountry()->getSlug() == 'ro'): ?>
      <meta name="p:domain_verify" content="adb09443ff261f2b10c46d103e43c7b2"/>
    <?php else: ?>
      <meta name="p:domain_verify" content="6e2b3488e1c589cb20f7c90a61fd85db"/>
    <?php endif; ?>
    
        <?php if(has_slot('meta_noindex_follow')):?>
        	<meta name="robots" content="noindex,follow" />
        <?php endif;?>
    
		<link rel="shortcut icon" href="/images/gui/favicon.ico?v=2" />
                <link rel="apple-touch-icon" href="/images/gui/apple-touch-icon.png" />
                <link rel="apple-touch-icon-precomposed" href="/images/gui/apple-touch-icon-precomposed.png" />
	              <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,latin-ext,cyrillic,cyrillic-ext' rel='stylesheet' type='text/css'>
                <link rel="stylesheet" type="text/css" media="screen" href="/css/fontAwesome/font-awesome.min.css">    
		<?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <script type="text/javascript" src="http<?php echo (@$_SERVER['HTTPS'])?'s':'';?>://maps.google.com/maps/api/js?sensor=true&libraries=places&language=<?php echo $sf_user->getCulture() ?>"></script>               
  
    <?php if((!substr_count(get_slot('sub_module'),'vip')) && !has_slot('no_ads')): ?>
        <?php include_partial('global/ads', array('type' => 'head')); ?>
    <?php endif; ?>

	<?php if (has_slot('prev') ):?> <link rel="prev" href="<?php echo get_slot("prev"); ?>" /><?php endif;?>
	<?php if (has_slot('next') ):?> <link rel="next" href="<?php echo get_slot("next"); ?>" /><?php endif;?>
        
	
<?php /*?>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "3b77a51e-7b24-44f2-bea9-68b3e58b2bf9", doNotHash: false, doNotCopy: false, hashAddressBar: true});</script>
<?php */?>

	</head>
     <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
        <?php if((!substr_count(get_slot('sub_module'),'vip')) && !has_slot('no_ads')): ?>
            <?php include_partial('global/ads', array('type' => 'interstitial')) ?>
        <?php endif; ?>
     <?php endif; ?> 
	<body <?php echo ($sf_request->getParameter('module')=='event'? 'class="special"': '' );?> <?php echo (($sf_request->getParameter('module')=='review' && $sf_request->getParameter('action')=='index') ? 'class="summer-body"': '' );?>>
	
		<!--checks user country and show top banner-->
		<?php $countries = sfConfig::get('app_domain_slugs_old'); ?>
		<?php $userData = myTools::getUserCountry(); ?>
		
		<?php if($sf_params->get('action') != 'addCompany' && !in_array(strtolower($userData['slug']), $countries) && $userData['slug'] != ''): ?>
      <div id="top_banner_container"></div>
			<?php // include_partial('global/top_banner', array('userCountry' => $userData));?>
		<?php endif;?>
    
		<?php include_partial('global/header', array('form'=> new sfGuardFormSignin ( ))) ?>

    <?php if ($sf_user->hasAttribute('home.noticeRUPA') or $sf_user->hasAttribute('home.notice')): ?>
        <div class="welcome_message">
            <div class="background_image">
                <div class="msg_content_wrap">
                        <div class="message_wrap">
                            <?php if ($sf_user->hasAttribute('home.noticeRUPA')):?>
                               <?php  echo $sf_user->getAttribute('home.noticeRUPA', ESC_RAW); $sf_user->setAttribute('home.noticeRUPA', null);  ?>
                            <?php else:?>
                               <?php echo $sf_user->getAttribute('home.notice', ESC_RAW); $sf_user->setAttribute('home.notice', null);  ?>
                            <?php endif;?>    
                        </div>
                    </div>
                <div id="delay_demo" class="shadow hover">
                    <div id="dd_main"></div>
                    <div id="dd1"></div>
                    <div id="dd2"></div>
                    <div id="dd3"></div>
                    <div id="dd4"></div>
                    <div id="dd5"></div>
                    <div id="dd6"></div>
                    <div id="dd7"></div>
                    <div id="dd8"></div>
                    <a title="<?php echo __('Close',null,'messages'); ?>" id="close">&#10006</a>
                </div>
                
            </div>
        </div>
    <?php endif; ?>
<?php if ($sf_user->hasAttribute('not.logged')): ?>
    <?php $sf_user->setAttribute('redirect', $sf_request->getUri()); ?>
    <div id="openModal" class="modalDialog bottom-ico">
        <div>
            <a href="#close" class="close"><i title="Close" aria-hidden="true" class="fa fa-times"></i></a>
            <section class="no-border">
                <h2><?php echo __('Login / Register', null, 'messages'); ?></h2>
                <p><?php echo __('Log in/Register to link the places you added with your account!', null, 'messages'); ?></p>
                <a href="<?php echo url_for('user/FBLogin')?>" class="btn-icon f-connect w-300">
                    <i class="fa fa-facebook"></i><?php echo __('Login with Facebook', null, 'messages'); ?>
                </a>
                <br>
                <a href="<?php echo url_for('user/signin') ?>" class="btn-icon email-login w-300">
                    <i class="fa fa-envelope-o"></i><?php echo __('Login with Email', null, 'messages'); ?>
                </a>
                <p class="small-reg"><?php echo __('Not registered?', null, 'messages'); ?> <?php echo link_to(__('Sign Up', null, 'user'), '@user_register') ?></p>
            </section>
        </div>
    </div>
 <?php endif; ?>



    <div class="page_wrap <?php echo ($sf_request->getParameter('module')=='review' && $sf_request->getParameter('action')=='index' && ($sf_user->getCountry()->getSlug() == 'bg' || $sf_user->getCountry()->getSlug() == 'ro')) ? 'reviews_wrap': '' ?>">
      <div class="cta_wrap <?php echo $sf_request->getParameter('module')=='event'? 'special': '' ?>">
          <?php if((!substr_count(get_slot('sub_module'),'vip')) && !has_slot('no_ads')): ?>
            <?php include_partial('global/ads', array('type' => 'branding')) ?>
            <?php include_partial('global/ads', array('type' => 'leader')) ?>
           <?php endif; ?>
           <?php include_partial('global/cta') ?>
      </div>

        <div class="content_wrap <?php echo $sf_request->getParameter('module')=='event'? 'events_wrap': '' ?>">
              <?php 
                if (has_slot('pre_content')) {
                    echo get_slot('pre_content');
                }
              ?>
              <?php include_partial('global/breadCrumb') ?>
              <?php if(has_slot('sub_module')): ?>
              <?php if (substr_count(get_slot('sub_module'),'vip')):?>
              <?php $module_name = str_replace('_vip', "", get_slot('sub_module'));?>
              <?php include_partial($module_name. '/template_vip', array_merge(get_slot('sub_module_parameters', array()), array('sf_content' => $sf_content))) ?>
                      <?php else:?>
              <?php include_partial(get_slot('sub_module'). '/template', array_merge(get_slot('sub_module_parameters', array()), array('sf_content' => $sf_content))) ?>
              <?php endif;?>
              <?php else: ?>
                      <?php echo $sf_content ?>
                      <?php if ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->getUserProfile()->getFollowedPages(true)):?>
                        <?php if(!has_slot('no_feed')): ?>
                          <div class="follow_feed no-print">
                          <?php include_component('home', 'feed', array('page' => (isset($page)? $page : 1), 'user'=> $sf_user->getGuardUser()));?>
                          </div>
                        <?php endif; ?>
                     <?php endif; ?>
              <?php endif ?>

              <div class="clear"></div>
        </div>
       
    </div>

    <?php include_partial('global/footer') ?>       
    <?php echo javascript_include_tag(javascript_path('map.js')) ?>
    <?php echo javascript_include_tag(javascript_path('select2.min.js')) ?>
    <?php if (!($sf_params->get('module') == 'offer' && ($sf_params->get('action') == 'index'))): ?>        
        <?php echo javascript_include_tag(javascript_path('front-end.js')) ?>
        <?php echo javascript_include_tag(javascript_path('/fancybox/jquery.fancybox-1.3.4.pack.js')) ?>
    <?php endif; ?>   
    <?php echo javascript_include_tag(javascript_path('jqache-0.1.1.min.js')) ?>   
    <?php echo javascript_include_tag(javascript_path('jquery.flexslider.js')) ?>
    <?php echo javascript_include_tag(javascript_path('jquery.selectBox.js')) ?>
    <?php echo javascript_include_tag(javascript_path('jquery.tinyscrollbar.min.js')) ?>
    <?php echo javascript_include_tag(javascript_path('jquery.mobile.custom.min.js')) ?>
    <?php echo javascript_include_tag(javascript_path('jquery.ezmark.js')) ?>
    <?php echo javascript_include_tag(javascript_path('jquery.sticky.js')) ?>
    <?php echo javascript_include_tag(javascript_path('embed.js')) ?>
    <?php echo javascript_include_tag(javascript_path('jquery.carouFredSel-6.2.1.js')) ?>
    <?php if ($sf_user->hasAttribute('not.logged')): ?>
          <?php echo javascript_include_tag(javascript_path('sign.in.js')) ?>   
          <?php $sf_user->getAttributeHolder()->remove('not.logged'); ?>
    <?php endif; ?>        
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
    <?php include_partial('global/gemius'); ?>        
    <?php include_partial('global/google_analytics');?>
    <?php echo javascript_include_tag('filters_labels/select2_locale_'.mb_convert_case(sfContext::getInstance()->getUser()->getCulture(), MB_CASE_LOWER,'UTF-8').'.js'); ?> 

<?php // =-=-=-=Google Code for Remarketing Tag=-=-=-=-//;?>
<?php $ip = $_SERVER['REMOTE_ADDR']; ?>
<?php if($ip != '92.247.180.170'): ?>
<script type="text/javascript">
var google_conversion_id = 995389959;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
var google_conversion_format = 3;
</script>
<script type="text/javascript" src="/js/conversion.js"></script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/995389959/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<?php // =-=-=Facebook Remarketing=-=-=-=//;?>
<script>(function(){
  window._fbds = window._fbds || {};
  _fbds.pixelId = 215040618697521;
  var fbds = document.createElement('script');
  fbds.async = true;
  fbds.src = '//connect.facebook.net/en_US/fbds.js';
  var s = document.getElementsByTagName('script')[0];
  s.parentNode.insertBefore(fbds, s);
})();
window._fbq = window._fbq || [];
window._fbq.push(["track", "PixelInitialized", {}]);
</script>
<noscript>
<img height="1" width="1" border="0" alt="" style="display:none" src="https://www.facebook.com/tr?id=215040618697521&amp;ev=NoScript" />
</noscript>
<?php endif; ?>

  <script type="text/javascript">
    window.onload=function(){
      $( "#top_banner_container" ).load( "<?php echo url_for('home/topBanner') ?>" );
    }
  </script>

  </body>
</html>



