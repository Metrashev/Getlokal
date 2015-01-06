<div class="footer_wrapper">
	<div class="footer-top">
		<div class="container">
			<div class="row">
				<div class="col-sm-9 col-md-8 col-lg-8">
					<h3 class="col-sm-12"><?php echo __('Powerful tools to get your Business on the Getlokal map!', null, 'company'); ?></h3>
				</div>
				<div class="col-sm-3 col-md-4 col-lg-4">
				    <?php $isRUPA = (bool) count(sfOutputEscaper::unescape($sf_user->getAdminCompanies())); ?>
                    <?php if (!$sf_user->getGuardUser()){ ?>
                        <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG || $sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO){ ?>
                            <a href="http://business.getlokal.com/<?php echo $sf_user->getCulture(); ?>" class="learn-more" target="_glbusiness"><?php echo __('Learn more', null, 'company'); ?></a>
                        <?php } else{ ?> 
                            <a href="http://business.getlokal.com/en" class="learn-more" target="_glbusiness"><?php echo __('Learn more', null, 'company'); ?></a>
                        <?php } ?>
                    <?php } else{ ?>
                        <?php if ($isRUPA){ ?>
                            <a href="<?php echo url_for('userSettings/companySettings'); ?>" class="learn-more"><?php echo __('Learn more', null,'company'); ?></a>
                        <?php } else{ ?>
                            <?php if ($sf_user->getAttribute('country_id') != getlokalPartner::GETLOKAL_BG and $sf_user->getAttribute('country_id') != getlokalPartner::GETLOKAL_RO){ ?>
                                <a href="http://business.getlokal.com/en" class="learn-more" target="_glbusiness"><?php echo __('Learn more', null, 'company'); ?></a>
                            <?php } else{ ?> 
                                <a href="http://business.getlokal.com/<?php echo $sf_user->getCulture(); ?>" class="learn-more" target="_glbusiness"><?php echo __('Learn more', null,'company'); ?></a>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
				</div>
			</div>
		</div>
	</div><!-- footer-top -->

	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<div class="col-sm-2 col-md-2 col-lg-2">
					<h3><?php echo __('About Us'); ?></h3>
					<ul>
						<li><?php echo link_to(__('About getlokal', null, 'messages'), '@static_page?slug=about-us'); ?></li>
						<li><?php echo link_to(__('Team', null, 'messages'), '@static_page?slug=our-team'); ?></li>
						<li><?php echo link_to(__('Timeline', null, 'messages'), '@static_page?slug=timeline'); ?></li>
						<li><?php echo link_to(__("FAQ's", null, 'messages'), '@static_page?slug=faq'); ?></li>
					</ul>
				</div>
			
				<div class="col-sm-4 col-md-2 col-lg-2">
					<h3><?php echo __('Legal Info', null, 'contact'); ?></h3>
					<ul>
						<li><?php echo link_to(__('Terms of Use', null, 'contact'), '@static_page?slug=terms-of-use') ?></li>
						<li><?php echo link_to(__('Privacy Policy', null, 'contact'), '@static_page?slug=privacy-policy') ?></li>
						<li><?php echo link_to(__('General Terms & Conditions'), '@static_page?slug=advertising-rules') ?></li>
						<?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG || $sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_MK || $sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO){ ?>
                        	<li><?php echo link_to(__('Rules of games', null, 'messages'), '@static_page?slug=promo-rules') ?></li>
                    	<?php } ?>
					</ul>
				</div>
			
				<div class="col-sm-3 col-md-2 col-lg-2">
					<h3><?php echo __('Contact Us'); ?></h3>
					<ul>
						<li><?php echo link_to(__('Office Addresses', null, 'messages'), 'contact/getlokaloffices') ?></li>
						<li><?php echo link_to(__('Contact form'), 'contact/getlokal'); ?></li>
					</ul>
				</div>
			
				<div class="col-sm-3 col-md-2 col-lg-2">
					<h3><?php echo __('Other', null, 'contact'); ?></h3>
					<ul>
						<li><?php echo link_to(__('Directory'), 'home/directory') ?></li>
						<?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG || $sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO){ ?>
                            <li><a href="http://business.getlokal.com/<?php echo $sf_user->getCulture(); ?>" class="learn-more" target="_glbusiness"><?php echo __('Advertise'); ?></a></li>
                        <?php } else{ ?> 
                            <li><a href="http://business.getlokal.com/en" class="learn-more" target="_glbusiness"><?php echo __('Advertise'); ?></a></li>
                        <?php } ?>
					</ul>
				</div>
			
				<div class="col-sm-12 col-md-4 col-lg-4">
					<h3><?php echo __('Like and follow us'); ?></h3>
					<div class="socials">
						<ul>
							<?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG){ ?>
							 	<li><a class="link-facebook" href="https://www.facebook.com/getlokal" target="_blank"><i class="fa fa-facebook fa-2x"></i></a></li>
							 	<li><a class="link-googleplus" href="https://plus.google.com/107281061798826098705/posts" rel="publisher" target="_blank"><i class="fa fa-google-plus fa-2x"></i></a></li>
		                        <li><a class="link-twitter" href="https://twitter.com/getlokal" target="_blank"><i class="fa fa-twitter fa-2x"></i></a></li>
		                        <li><a class="link-pinterest" href="http://pinterest.com/getlokal/getlokal-%D0%B1%D1%8A%D0%BB%D0%B3%D0%B0%D1%80%D0%B8%D1%8F/" target="_blank"><i class="fa fa-pinterest fa-2x"></i></a></li>
		                        <li><a class="link-youtube" href="http://www.youtube.com/getlokal" target="_blank"><i class="fa fa-youtube fa-2x"></i></a></li>
		                        <li><a class="link-linkedin" href="http://www.linkedin.com/company/2404523?trk=prof-0-ovw-curr_pos" target="_blank"><i class="fa fa-linkedin fa-2x"></i></a></li>
		                    <?php } elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO){ ?>
		                    	<li><a class="link-facebook" href="https://www.facebook.com/getlokal.ro" target="_blank"><i class="fa fa-facebook fa-2x"></i></a></li>
		                    	<li><a class="link-googleplus" href="https://plus.google.com/105307511231555757137/posts" rel="publisher" target="_blank"><i class="fa fa-google-plus fa-2x"></i></a></li>
		                        <li><a class="link-twitter" href="https://twitter.com/getlokalro" target="_blank"><i class="fa fa-twitter fa-2x"></i></a></li>
		                        <li><a class="link-pinterest" href="http://pinterest.com/getlokal/getlokal-rom%C3%A2nia/" target="_blank"><i class="fa fa-pinterest fa-2x"></i></a></li>
		                        <li><a class="link-youtube" href="http://www.youtube.com/getlokalro" target="_blank"><i class="fa fa-youtube fa-2x"></i></a></li>
		                       	<li><a class="link-linkedin" href="http://www.linkedin.com/company/2404523?trk=prof-0-ovw-curr_pos" target="_blank"><i class="fa fa-linkedin fa-2x"></i></a></li>
		                    <?php } elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_MK){ ?>
		                    	<li><a class="link-facebook" href="https://www.facebook.com/getlokal.mk" target="_blank"><i class="fa fa-facebook fa-2x"></i></a></li>
		                    	<li><a class="link-googleplus" href="https://plus.google.com/u/0/101550121514033570313/posts" rel="publisher" target="_blank"><i class="fa fa-google-plus fa-2x"></i></a></li>
		                        <li><a class="link-twitter" href="https://twitter.com/getlokalMK" target="_blank"><i class="fa fa-twitter fa-2x"></i></a></li>
		                        <li><a class="link-pinterest" href="http://pinterest.com/getlokal/getlokal-%D0%BC%D0%B0%D0%BA%D0%B5%D0%B4%D0%BE%D0%BD%D0%B8ja/" target="_blank"><i class="fa fa-pinterest fa-2x"></i></a></li>
		                        <li><a class="link-youtube" href="http://www.youtube.com/getlokalmk" target="_blank"><i class="fa fa-youtube fa-2x"></i></a></li>
		                        <li><a class="link-linkedin" href="http://www.linkedin.com/company/2404523?trk=prof-0-ovw-curr_pos" target="_blank"><i class="fa fa-linkedin fa-2x"></i></a></li>
		                    <?php } elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RS){ ?>
		                    	<li><a class="link-facebook" href="https://www.facebook.com/getlokal.rs" target="_blank"><i class="fa fa-facebook fa-2x"></i></a></li>
		                    	<li><a class="link-googleplus" href="https://plus.google.com/u/0/107641928245143400221/posts" rel="publisher" target="_blank"><i class="fa fa-google-plus fa-2x"></i></a></li>
		                        <li><a class="link-twitter" href="https://twitter.com/getlokalrs" target="_blank"><i class="fa fa-twitter fa-2x"></i></a></li>
		                        <li><a class="link-pinterest" href="http://pinterest.com/getlokal/getlokal-%D1%81%D1%80%D0%B1%D0%B8%D1%98%D0%B0/" target="_blank"><i class="fa fa-pinterest fa-2x"></i></a></li>
		                        <li><a class="link-linkedin" href="http://www.linkedin.com/company/2404523?trk=prof-0-ovw-curr_pos" target="_blank"><i class="fa fa-linkedin fa-2x"></i></a></li>
		                    <?php } elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_FI){ ?>
		                    	<li><a class="link-facebook" href="https://www.facebook.com/getlokal" target="_blank"><i class="fa fa-facebook fa-2x"></i></a></li>
		                    	<li><a class="link-googleplus" href="https://plus.google.com/107281061798826098705/posts" rel="publisher" target="_blank"><i class="fa fa-google-plus fa-2x"></i></a></li>
		                        <li><a class="link-twitter" href="https://twitter.com/getlokal" target="_blank"><i class="fa fa-twitter fa-2x"></i></a></li>
		                        <li><a class="link-pinterest" href="http://pinterest.com/getlokal/getlokal-%D0%B1%D1%8A%D0%BB%D0%B3%D0%B0%D1%80%D0%B8%D1%8F/" target="_blank"><i class="fa fa-pinterest fa-2x"></i></a></li>
		                        <li><a class="link-youtube" href="http://www.youtube.com/getlokal" target="_blank"><i class="fa fa-youtube fa-2x"></i></a></li>
		                        <li><a class="link-linkedin" href="http://www.linkedin.com/company/2404523?trk=prof-0-ovw-curr_pos" target="_blank"><i class="fa fa-linkedin fa-2x"></i></a></li>
		                    <?php } elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_ME){ ?>
		                    	<li><a class="link-facebook" href="https://www.facebook.com/getlokal" target="_blank"><i class="fa fa-facebook fa-2x"></i></a></li>
		                        <li><a class="link-twitter" href="https://twitter.com/getlokal" target="_blank"><i class="fa fa-twitter fa-2x"></i></a></li>
		                        <li><a class="link-youtube" href="http://www.youtube.com/getlokal" target="_blank"><i class="fa fa-youtube fa-2x"></i></a></li>
		                        <li><a class="link-linkedin" href="http://www.linkedin.com/company/2404523?trk=prof-0-ovw-curr_pos" target="_blank"><i class="fa fa-linkedin fa-2x"></i></a></li>
		                    <?php } elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RU){ ?>
		                    	<li><a class="link-facebook" href="https://www.facebook.com/getlokal" target="_blank"><i class="fa fa-facebook fa-2x"></i></a></li>
		                        <li><a class="link-twitter" href="https://twitter.com/getlokal" target="_blank"><i class="fa fa-twitter fa-2x"></i></a></li>
		                        <li><a class="link-youtube" href="http://www.youtube.com/getlokal" target="_blank"><i class="fa fa-youtube fa-2x"></i></a></li>   
		                        <li><a class="link-linkedin" href="http://www.linkedin.com/company/2404523?trk=prof-0-ovw-curr_pos" target="_blank"><i class="fa fa-linkedin fa-2x"></i></a></li>
		                    <?php } elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_HU){ ?>
		                        <li><a class="link-facebook" href="https://www.facebook.com/getlokal.co" target="_blank"><i class="fa fa-facebook fa-2x"></i></a></li>
		                        <li><a class="link-pinterest" href="http://www.pinterest.com/getlokal" target="_blank"><i class="fa fa-pinterest fa-2x"></i></a></li>
		                        <li><a class="link-linkedin" href="http://www.linkedin.com/company/2404523?trk=prof-0-ovw-curr_pos" target="_blank"><i class="fa fa-linkedin fa-2x"></i></a></li>                 
		                    <?php } ?>   
						</ul>
					</div><!-- socials -->
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="copyright">
					<?php echo __('© Copyright Getlokal 2014'); ?>
				</div><!-- copyright -->
			</div>
		</div>
	</div><!-- footer-bottom -->
</div><!-- footer_wrapper -->