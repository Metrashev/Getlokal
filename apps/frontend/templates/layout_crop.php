<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" class="<?php echo $sf_request->getParameter('module')=='event'? 'special': '' ?>">
	<head>
		<?php include_http_metas() ?>
		<?php include_metas() ?>
		<?php if (has_slot('canonical')): ?>
	      <?php echo get_slot('canonical')?>
	    <?php endif;?>
		<?php echo get_slot('facebook')?>
		<?php include_page_title() ?>
		<?php if (has_slot('description')): ?><meta name="description" content="<?php echo get_slot('description')?>" /><?php endif;?>
		<link rel="shortcut icon" href="/images/gui/favicon.ico" />
		<link href='http<?php echo (@$_SERVER['HTTPS'])?'s':'';?>://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=latin,cyrillic-ext,greek-ext,greek,latin-ext,cyrillic' rel='stylesheet' type='text/css' />
		<?php include_stylesheets() ?>
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

    <?php include_javascripts() ?>
    <script type="text/javascript" src="http<?php echo (@$_SERVER['HTTPS'])?'s':'';?>://maps.google.com/maps/api/js?sensor=true&libraries=places&language=<?php echo $sf_user->getCulture() ?>"></script>
	<?php include_partial('global/google_analytics');?>
	</head>
	
	<body>
		
		<div class="page_wrap">
			<div class="cta_wrap">				
				<?php include_partial('global/cta') ?>
			</div>
			<div style="padding: 0px 25px;">
			<?php if(has_slot('sub_module')): ?>
					<?php include_partial(get_slot('sub_module'). '/template', array_merge(get_slot('sub_module_parameters', array()), array('sf_content' => $sf_content))) ?>
				<?php else: ?>
					<?php echo $sf_content ?>
				<?php endif ?>
				<div class="clear"></div>
	      
				<?php if(!$sf_user->isAuthenticated()): ?>
	      			<?php  include_partial('global/content_footer') ?>
	      		<?php endif ?>
			</div>
	   
		</div>
	</body>
</html>