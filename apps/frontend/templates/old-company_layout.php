<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php /*<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" class="<?php echo $sf_request->getParameter('module')=='event'? 'special': '' ?>"> */ ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php include_http_metas() ?>
		<?php include_metas() ?>
		<?php include_page_title() ?>
		<?php echo get_slot('facebook')?>	
		<link rel="shortcut icon" href="/images/gui/favicon.ico" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css' />
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
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&libraries=places&language=<?php echo $sf_user->getCulture() ?>"></script>
	
	
	<body class="<?php echo $sf_request->getParameter('module')=='event'? 'special': '' ?>">
		<div class="page_wrap">
			<div class="header_wrap">
				<div class="header_top">
					<div class="header_location">
      					<div id="header_country">
        					<div class="header_dropdown">
          						<a href="#"><?php echo __($sf_user->getCountry()->getName()); ?></a>
							    <ul>
									<?php if ($sf_user->getCountry()->getSlug() != 'bg'):?>
										<li><a href="http://www.getlokal.com/" class="<?php echo $sf_user->getCountry()->getSlug() == 'bg'? 'current': '' ?>"><?php echo __('Bulgaria')?></a></li>
									<?php endif ?>
									<?php if ($sf_user->getCountry()->getSlug() != 'ro'):?>
										<li><a href="http://www.getlokal.ro/" class="<?php echo $sf_user->getCountry()->getSlug() == 'ro'? 'current': '' ?>"><?php echo __('Romania')?></a></li>
									<?php endif;?>
									<?php if ($sf_user->getCountry()->getSlug() != 'mk'):?>
										<li><a href="http://www.getlokal.mk/" class="<?php echo $sf_user->getCountry()->getSlug() == 'mk'? 'current': '' ?>"><?php echo __('Macedonia')?></a></li>
									<?php endif;?>
                                                                                <?php if ($sf_user->getCountry()->getSlug() != 'fi'):?>
										<li><a href="http://www.getlokal.fi/" class="<?php echo $sf_user->getCountry()->getSlug() == 'fi'? 'current': '' ?>"><?php echo __('Finland')?></a></li>
									<?php endif;?>
							   	</ul>
        					</div>
      					</div>
	      				<div id="header_city">
		        			<div class="header_dropdown">
		          				<a href="#"><?php echo $sf_user->getCity()->getLocation() ?></a>
		          				<ul>
		            				<?php foreach($sf_user->getCountry()->getDefaultCities() as $city): ?>
		              					<li><a href="<?php echo url_for('@home?city='. $city->getSlug()) ?>"><?php echo $city->getLocation(); ?></a></li>
		            				<?php endforeach ?>
		         				</ul>
		        			</div>
	      				</div>
    				</div>
					<div class="header_menu_bar">
						<?php if($sf_user->getCountry()->getSlug()== 'bg'):?>
							<a href="http://blog.getlokal.com"  target="_blank"><?php echo __('Blog',null, 'messages'); ?></a>
						<?php elseif($sf_user->getCountry()->getSlug()== 'ro'):?>
							<a href="http://blog.getlokal.ro"  target="_blank"><?php echo __('Blog',null, 'messages'); ?></a>
						<?php elseif($sf_user->getCountry()->getSlug()== 'mk'):?>
							<a href="http://blog.getlokal.mk"  target="_blank"><?php echo __('Blog',null, 'messages'); ?></a>
						<?php endif;?>
					</div>
					<div>
						<?php include_component('home', 'languages');?>
					</div>
				</div>

				<div class="header">
					<div class="main_menu">
						<?php echo link_to(image_tag('gui/logo_getlokal.png'), '@homepage') ?>
						<div class="menu_wrap">
							<div class="menu_wrap_content">
								<?php /* <h2><?php echo link_to(__('Home'), '@homepage') ?></h2> */ ?>
								<h2><?php echo link_to(__('Lists'), 'list/index') ?></h2>
								<h2><?php echo link_to(__('Events'), 'event/recommended') ?></h2>
								<h2><?php echo link_to(__('Directory'), 'home/directory') ?></h2>					
							</div>
							<img src="/images/gui/menu_border.png" />
							<?php if($sf_user->isAuthenticated() && $sf_user->getPageAdminUser ()): ?>
								<div class="header_user_wrap">	
									<ul class="header_user">
										<li>
											<?php //echo image_tag($sf_user->getProfile()->getThumb());?>
											<div class="header_user_info">
												<p><?php echo __('Hi', null ,'user'); ?></p>
												<p><b><?php echo $sf_user->getPageAdminUser()->getUsername(); ?></b></p>
											</div>
											<a id="header_user_options_button" href="javascript:void(0)"></a>
											<div class="clear"></div>
										</li>
										<li>
											<?php echo link_to(__('Log Out', null, 'user'), 'user/signout', array('class'=>'button_pink')) ?>
											<?php if($sf_user->getPageAdminUser() && $sf_user->getGuardUser()):?>
												<?php echo link_to(__('My Places', null, 'user'), 'userSettings/companySettings', array('class'=>'button_pink')) ?>
												<?php echo link_to(sprintf(__('Login as %s', null, 'user'), $sf_user->getGuardUser()->getUserProfile()) , 'companySettings/logout', array('class'=>'button_pink')) ?>
											<?php endif;?>
											<div class="clear"></div>
										</li>
										<li>
											<div class="clear"></div>
										</li>
									</ul>
								</div>
							<?php else: ?>
								<a class="header_login_button" href="javascript:void(0)"><?php echo __('Login') ?></a>
							<?php endif ?>
						</div>
						<div class="header_login_pointer"></div>
					</div>
					<?php if(!($sf_user->getPageAdminUser())): ?>
						
						<div id="header_login_form_wrap">
							<a href="javascript:void(0)" id="header_white_close"></a>
							<div class="header_login_content">
								<?php include_partial('companySettings/pageadmin_signin_form',array('form'=> new SigninPageAdminForm()));?>
							</div>
						</div>
						<div class="clear"></div>
					<?php endif ?>
				</div>
			
					
			</div>
			<?php include_partial('global/cta') ?>
			<div class="content_wrap <?php echo $sf_request->getParameter('module')=='event'? 'events_wrap': '' ?>">
			
				<?php include_partial('global/breadCrumb') ?>
				<?php if(has_slot('sub_module')): ?>
					<?php include_partial(get_slot('sub_module'). '/template', array_merge(get_slot('sub_module_parameters', array()), array('sf_content' => $sf_content))) ?>
				<?php else: ?>
					<?php echo $sf_content ?>
				<?php endif ?>
				<div class="clear"></div>
	      
				
			</div>
	    	<?php  include_partial('global/footer') ?>
		</div>
	</body>
</html>