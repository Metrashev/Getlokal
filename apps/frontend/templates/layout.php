<?php  
if (!isset($_COOKIE['visit']) || $_COOKIE['visit'] != "true"){ 
	setcookie("visit", "true", time() + 600*6, '/'); 
	$device = '';
	if(stristr($_SERVER['HTTP_USER_AGENT'],"iPhone")){ 
		$device = "iPhone";
		$bodyClass = 'iphone-bg';
	}elseif( stristr($_SERVER['HTTP_USER_AGENT'],'android') ){
		$device = "android";
		$bodyClass = 'andr-bg';
	}
	//$device = 'iPhone';
	if ($device == 'android' || $device == 'iPhone'){
		include_partial('global/layoutMobile', array('device' => $device));
		die();
	}
}
$module = $sf_context->getModuleName();
$action = $sf_context->getActionName();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:700italic,600,400&subset=cyrillic-ext,latin,latin-ext' rel='stylesheet' type='text/css'>
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width" />
  <?php 
		include_http_metas();
    	include_metas(); 
    	if (has_slot('canonical')){
    		echo get_slot('canonical');
    	}
    	
		include_page_title();
		include_stylesheets();
		
		echo javascript_include_tag(javascript_path('jquery.js'));
		//echo javascript_include_tag(javascript_path('jquery-ui.js'));
		//echo javascript_include_tag(javascript_path('map.js'));
		//echo javascript_include_tag(javascript_path('document.ready.js'));
		//echo javascript_include_tag(javascript_path('philip.js'));
		//echo javascript_include_tag(javascript_path('floatlabels.min.js'));
		//echo javascript_include_tag(javascript_path('parsley.min.js'));
		//echo javascript_include_tag(javascript_path('jquery.prettyPhoto.js'));
		//echo javascript_include_tag(javascript_path('embed.js'));
		//echo javascript_include_tag(javascript_path('jquery.tinyscrollbar.min.js'));		
    	//echo javascript_include_tag(javascript_path('classie.js'));

	?>
	<?php include_javascripts();?>
	<script type="text/javascript" src="/min/g=home&141201"></script>

  <?php 
    if(($module == 'offer' && $action == 'new') || ($module == 'offer' && $action == 'edit')){
      include_javascripts();
    }
  ?>
  
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
	<script type="text/javascript" src="http<?php echo (@$_SERVER['HTTPS'])?'s':'';?>://maps.google.com/maps/api/js?sensor=true&libraries=places&language=<?php echo $sf_user->getCulture() ?>"></script>
	<script type="text/javascript"> var ModuleAction = '<?=$module."-".$action?>';</script>
	<?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
		<?php if((!substr_count(get_slot('sub_module'),'vip')) && !has_slot('no_ads')): ?>
	        <?php include_partial('global/ads', array('type' => 'head')); ?>
	    <?php endif; ?>	
    <?php endif; ?>	
	<?php include_partial('global/google_analytics');?>
</head>

<body>
<?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
		<?php if((!substr_count(get_slot('sub_module'),'vip')) && !has_slot('no_ads')): ?>
	        <?php include_partial('global/ads', array('type' => 'interstitial')); ?>
	    <?php endif; ?>	
    <?php endif; ?>	
<?php 
	$app_culture = $sf_user->getCulture() == "ro" ? "ro" : "bg";
	$app_id = sfConfig::get("app_facebook_app_".$app_culture."_id","");?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=<?= $app_id?>&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script src="https://apis.google.com/js/platform.js" async defer>
  {lang: 'en'}
</script>

<script type="text/javascript">
window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));
</script>

<div id="st-container" class="st-container">
   
   <div class="st-pusher">

      <div class="small-sidemenu">
          
        <div class="small-holder">




          <ul class="side-nav">
            <li class="main-section current">

                <ul class="sub-section-list" data-effect="st-effect-3">
                  <li class="main-section sub-section">
                      <i class="fa fa-search fa-lg"></i>
                      <span class="txt"><?php echo __('Categories'); ?></span>
                  </li>
                </ul>

            </li>
            <li <?php echo ($sf_params->get('module') == 'event') ? ' class="current main-section"' : 'class="main-section"'; ?>>
                <?php echo link_to('<i class="fa fa-ticket fa-lg"></i>' . __('Events'), 'event/recommended') ?>

                <ul class="sub-section-list" data-effect="st-effect-3">
                  <li class="main-section sub-section">
                      <i class="fa fa-search fa-lg"></i>
                      <span class="txt"><?php echo __('Categories'); ?></span>
                  </li>
                </ul>

            </li>
            <li <?php echo ($sf_params->get('module') == 'article') ? ' class="current main-section"' : 'class="main-section"'; ?>>
                <?php echo link_to('<i class="fa fa-pencil-square-o fa-lg"></i>' . __('Articles'), '@article_index') ?>

                <ul class="sub-section-list" data-effect="st-effect-3">
                  <li class="main-section sub-section">
                      <i class="fa fa-search fa-lg"></i>
                      <span class="txt"><?php echo __('Categories'); ?></span>
                  </li>
                </ul>

            </li>
                        
            <li <?php echo ($sf_params->get('module') == 'list') ? ' class="current main-section"' : 'class="main-section"'; ?>>
                <?php echo link_to('<i class="fa fa-list-alt fa-lg"></i>' . __('Lists'), 'list/index') ?>

            </li>
          </ul>

        </div>
      </div>

      <nav class="st-menu st-effect-3" id="menu-3">

          <?php 
          if (has_slot('side_categories')){
    		echo get_slot('side_categories');
          }else{
			//ako nqma slot, vsi4ki stranici v modula article 6e sa s tva menu
		  	if($module == 'article'){
				include_component('article', 'category');
			}else{
				include_component('box','boxCategories');	
			}
		  }
          
          
          ?>

          <div class="x-marks-the-spot"><a href="javascript:void(0)"><i class="fa fa-times"></i></a></div>
      

      </nav>

       <div class="st-content">
           <div class="st-content-inner">

               <?php 
               	include_partial('global/header');		
               	if($module."-".$action != 'home-index'){
               		include_partial('global/search_form_all');
               	}	
               ?>

               <div class="container side-banners-container">

                 <!-- SIDE BANNERS -->

                 <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
                  <?php if((!substr_count(get_slot('sub_module'),'vip')) && !has_slot('no_ads')): ?>
                   <div class="side-banner left">
                    <?php include_partial('global/ads', array('type' => 'sky')) ?>
                   </div>
                   <div class="side-banner right">
                    <?php include_partial('global/ads', array('type' => 'sky')) ?>
                   </div>
                  <?php endif; ?>
                 <?php endif; ?>
                 <!-- END OF SIDE BANNERS -->
               </div>

               <?php if ($sf_user->hasAttribute('home.noticeRUPA') or $sf_user->hasAttribute('home.notice')): ?>
                   <div class="row welcome_message">
                       <div class="container">
                           <div class="msg_content_wrap">
                               <?php if ($sf_user->hasAttribute('home.noticeRUPA')):?>
                                  <?php  echo $sf_user->getAttribute('home.noticeRUPA', ESC_RAW); $sf_user->setAttribute('home.noticeRUPA', null);  ?>
                               <?php else:?>
                                  <?php echo $sf_user->getAttribute('home.notice', ESC_RAW); $sf_user->setAttribute('home.notice', null);  ?>
                               <?php endif;?>    
                           </div>
                           <button title="<?php echo __('Close',null,'messages'); ?>" type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">&#10006</span></button>
                       </div>
                   </div>
               <?php endif; ?>

               <?php
               	echo $sf_content;
               	include_partial('global/footer');
               ?> 

               <!-- HAVE TO BE AT THE BOTTOM OF THE PAGE CODE -->
               <?php if ($sf_user->hasAttribute('not.logged')): ?>
                   <?php $sf_user->setAttribute('redirect', $sf_request->getUri()); ?>
                   <div id="openModal" class="modalDialog bottom-ico active">
                   	<div>
                   		<a href="#close" class="close"><i title="Close" aria-hidden="true" class="fa fa-times"></i></a>
                   		<section class="no-border">
                   			<h2><?php echo __('Login / Register', null, 'messages'); ?></h2>
                   			<p><?php echo __('Log in/Register to link the places you added with your account!', null, 'messages'); ?></p>
                   			<div class="row">
                   				<div class="col-xs-12">
                   					<a href="<?php echo url_for('user/FBLogin')?>" class="default-btn fb w-300"><?php echo __('Login with Facebook', null, 'messages'); ?></a>
                   				</div>
                   			</div>
                   			<div class="row">
                   				<div class="col-xs-12">
                   					<a href="<?php echo url_for('user/signin') ?>" class="default-btn w-300"><?php echo __('Login with Email', null, 'messages'); ?></a>
                   				</div>
                   				<div class="custom-row">
                   					<p><?php echo __('Not registered?', null, 'messages'); ?> <?php echo link_to(__('Sign Up', null, 'user'),  '@user_register', array('class' => 'default-form-link')) ?></p>
                   				</div>
                   			</div>
                   		</section>
                   	</div>
                   </div>
                   <?php $sf_user->getAttributeHolder()->remove('not.logged'); ?>
                <?php endif; ?>

           </div>
       </div>

   </div>

</div>

    <?php
      echo javascript_include_tag(javascript_path('modernizr.custom.js'));
      echo javascript_include_tag(javascript_path('sidebarEffects.js'));
    ?>

</body>
</html>