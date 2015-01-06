<div class="header_wrapper">
	<div class="header-top">
			<div class="container">

				<div class="row">
					<!-- <div class="col-sm-12 relative"> -->
						<div class="row">
							<div class="col-xs-12 col-md-7 static regions">
								<span class="label"><?php echo __('Region and Language', null, 'company'); ?></span>
								<div class="nav-tabs">
									<div class="nav-tabs-head">
										<ul class="nav-utilities">
											<li lang="js-country">
												<a href="#"><?php echo $sf_user->getCountry()->getCountryNameByCulture(); ?><i class="fa fa-angle-down"></i></a>
											</li>
										
											<li lang="js-city">
												<a href="#">
													<?php if ($sf_request->getParameter('county',false) || (getlokalPartner::getInstanceDomain() == 78)){ ?>
											        	<?php echo $sf_user->getCounty()->getLocation(); ?>
											    	<?php } else{ ?>
											        	<?php echo $sf_user->getCity()->getLocation(); ?>
											    	<?php } ?>
											    	<i class="fa fa-angle-down"></i>
											    </a>
											</li>
										
											<li lang="js-lang">
												<a href="#">
													<?php echo image_tag('/images/gui/flag_'. $sf_user->getCulture() .'.gif', array('class' => 'flag')); ?>
													<?php echo sfConfig::get('app_culture_native_'.strtolower($sf_user->getCulture())); ?><i class="fa fa-angle-down"></i>
												</a>
											</li>
										</ul>
									</div><!-- nav-tabs-head -->
								
									<div class="tabs-body">
										<div class="nav-tab" lang="js-country">
											<ul>
											<?php $countries = sfConfig::get('app_domain_slugs_old'); 
			                                foreach ($countries as $country){ 
			                                	$cultureToDomain = $sf_user->getCountry()->getSlug(); 
			                                	if($sf_user->getCountry()->getSlug() == 'sr'){
			                                		$cultureToDomain = 'rs';
			                                	}
			                                ?>
			                                    <li <?php echo $cultureToDomain == $country ? 'class="current"' : ''; ?>>
				                                    <a href="http://www.getlokal.<?php echo $country ?>/">
														<?php echo $cultureToDomain == $country ? '<i class="fa fa-check"></i>' : ''; 
															  echo __(sfConfig::get('app_countries_' . $country)); ?>
				                                    </a>
			                                    </li>
			                                <?php } ?>
											</ul>
					
											<div class="ico-closing-tabs">
												<i class="fa fa-times"></i>
											</div>
										</div><!-- nav-tab -->
								
										<div class="nav-tab" lang="js-city">
											<ul>
											<?php foreach ($sf_user->getCountry()->getDefaultCities() as $city){ 
			                                      if ($sf_request->getParameter('county', false) || (getlokalPartner::getInstanceDomain() == 78)){ ?>
			                                        <li <?php echo (strtolower($sf_user->getCounty()->getLocation()) == strtolower($city->getCounty()->getLocation())) ? 'class="current"' : ''; ?>>
			                                            <a href="<?php echo url_for('@homeCounty?county=' . $city->getCounty()->getSlug()) ?>">
			                                                <?php 
			                                                	echo (strtolower($sf_user->getCounty()->getLocation()) == strtolower($city->getCounty()->getLocation())) ? '<i class="fa fa-check"></i>' : '';
			                                                	echo $city->getCounty()->getLocation(); 
			                                                ?>
			                                            </a>
			                                        </li>
			                                    <?php } else{ ?>
			                                        <li <?php echo (strtolower($sf_user->getCity()->getLocation()) == strtolower($city->getLocation())) ? 'class="current"' : ''; ?>>
			                                            <a href="<?php echo url_for('@home?city=' . $city->getSlug()) ?>">
			                                                <?php 
			                                                	echo (strtolower($sf_user->getCity()->getLocation()) == strtolower($city->getLocation())) ? '<i class="fa fa-check"></i>' : '';
			                                                	echo $city->getLocation();
			                                                ?>
			                                            </a>
			                                        </li>
			                                    <?php } ?>
		                                	<?php } ?>
											</ul>
											<div class="ico-closing-tabs">
												<i class="fa fa-times"></i>
											</div>
										</div><!-- nav-tab -->
								
										<div class="nav-tab" lang="js-lang">
											<?php include_component('home', 'languages'); ?>
											<div class="ico-closing-tabs">
												<i class="fa fa-times"></i>
											</div>
										</div><!-- nav-tab -->
			
									</div><!-- tabs-body -->
								</div><!-- nav-tabs -->
							</div>
			
							<div class="col-sm-5 hidden-sm">
								 <div class="section-mobile">
								 	<h3>
								 		<span class="mobile-ico">
								 			<i class="fa fa-mobile fa-2x"></i>
								 		</span>
								 			<?php echo __('Install'); ?>
								 			<a href="#"> <?php echo __('Getlokal app'); ?></a>
								 	</h3>
									<div class="popup-menu wrapp-popup">
										<div class="hover-linker"></div>
						                <div class="popover-arrow"></div>
						                <div class="download-app">

						        
						                    <p> <?php echo __('Download'); ?> <strong class="purple-txt"><?php echo __('Getlokal'); ?> <?php echo __('app'); ?> </strong> <?php echo __('via:'); ?></p>

						                </div>
						                <div class="scan-code">
						                    <a href="#"><img src="<?= image_path('/css/images/qr-code.png'); ?>" alt=""></a>
						                    <p><?php echo __('Scan this code with your smartphone'); ?><br/><img src="<?= image_path('/css/images/arrow-qr.png'); ?>" alt=""></p>
						                </div>
<!-- 						                <div class="separator">
						                    <p class="line-on"><span>or</span></p>
						                </div>
						                <div class="send-link-sms">
						                    <p class="send-link-text">Type in your phone number and we'll sms you the link.</p>
						                    <a href="#"><img src="<?= image_path('/css/images/phone-icon.png'); ?>" alt=""></a>
						                    <input type="text" placeholder="+359 8 324 234"/>
						                    <button class="default-btn success">Send link via sms</button>
						                    <p>/ we'll send one single SMS with the download link/</p>
						                </div>
						                <div class="separator">
						                    <p class="line-on"><span class="center-line">or</span></p>
						                </div>
						                <div class="send-link-sms">
						                    <p class="send-link-text">Enter your email addres, and we'll send you the link.</p>
						                    <a href="#"><img src="<?= image_path('/css/images/mail-icon.png'); ?>" alt=""></a>
						                    <input type="text" placeholder="yourmail@example.com"/>
						                    <button class="default-btn success">Send link via sms</button>
						                </div> -->
			            			</div>
								 </div>
							</div>
						</div>
					<!-- </div> -->
				</div>
			</div>
		</div>
		<div class="header-bottom">
		<div class="container">
			<div class="row">
				<div class="col-sm-3 col-md-6">
					<a href="<?php echo url_for('@home3') ?>" class="logo"><img src="/../css/images/logo.jpg" alt=""></a>
					<div class="nav hidden-xs hidden-sm">
						<ul>
	                        <li <?php echo ($sf_params->get('module') == 'event') ? ' class="current main-section"' : 'class="main-section"'; ?>>
	                            <?php echo link_to('<i class="fa fa-ticket fa-lg"></i>' . __('Events'), 'event/recommended') ?>
	                        </li>

							<li <?php echo ($sf_params->get('module') == 'article') ? ' class="current main-section"' : 'class="main-section"'; ?>>
	                            <?php echo link_to('<i class="fa fa-pencil-square-o fa-lg"></i>' . __('Articles'), '@article_index') ?>
	                        </li>
	                        
	                        <li <?php echo ($sf_params->get('module') == 'list') ? ' class="current main-section"' : 'class="main-section"'; ?>>
	                            <?php echo link_to('<i class="fa fa-th-list fa-lg"></i>' . __('Lists'), 'list/index') ?>
	                        </li>
						</ul>
					</div>
				</div>
				
				<div class="col-sm-9 col-md-6">
					<ul class="nav-secondary">
						<li class="nav-item">
							<a href="javascript:void(0)" class="btn-add-dropdown default-btn">
								<div class="fa fa-plus"></div> <?php echo __('Add new'); ?> <div class="fa fa-angle-down fa-lg"></div>
							</a>

							<div class="section-add">
								<div class="border-arrow"></div>
								<ul>
									<li>                       
                        				<?php echo link_to('<i class="fa fa-map-marker fa-lg"></i>' . __('Place'), 'company/addCompany', array('title' => __('Place'))); ?>
									</li>
									
										<?php // echo '<li>'.link_to('<i class="fa fa-stack-exchange fa-lg"></i>' . __('Review'), 'review/index', array('title' => __('Review'))).'</li>'; ?>

									<li>
										<?php echo link_to('<i class="fa fa-ticket fa-lg"></i>' . __('Event', null, 'dashboard'), 'event/create', array('title' => __('Event'))); ?>
									</li>
								</ul>
							</div><!-- section-add -->
						</li>

						<?php if ($sf_user->isAuthenticated()){

							include_component('home', 'messageNotifications');
	                        include_component('home', 'notifications');

	                        $count = 0;

	                    	if ($sf_user->getPageAdminUser()){ 
								$first_name = $sf_user->getPageAdminUser()->getUsername(); 
							    $userPlaces = $sf_user->getPageAdminUser()->getIsOtherPlaceAdmin();

							} elseif ($sf_user->getGuardUser()){
								// echo image_tag($sf_user->getGuardUser()->getUserProfile()->getThumb(1));
								$first_name = $sf_user->getGuardUser()->getUserProfile()->getFirstName(); 
								$userPlaces = $sf_user->getGuardUser()->getIsPlaceAdmin();
							}
						?>							

	                    <li class="nav-item">
							<?php echo link_to($first_name, 'profile/index?username=' . $sf_user->getGuardUser()->getUsername(), array('class' => 'username')); ?>
							<?php echo link_to(image_tag($sf_user->getGuardUser()->getUserProfile()->getThumb(1), array('alt' => $first_name)), 'profile/index?username=' . $sf_user->getGuardUser()->getUsername(), array('class' => 'profile-image', 'title' => $first_name)); ?>


							<div class="image-dropdowns">
								<div class="image-dropdown-head">
									<div class="border-arrow"></div><!-- border-arrow -->

									<ul>
										<li>
											<a href="#">
												<span class="number">
													<?php echo $sf_user->getGuardUser()->getUserProfile()->getBadges(); ?>
												</span>
												<p><?php echo __('Badges'); ?></p>
											</a>
										</li>
										
										<li>
											<a href="#">
												<span class="number">
													<?php echo $sf_user->getGuardUser()->getUserProfile()->getReviews(); ?>
												</span>
												<p><?php echo __('Reviews'); ?></p>
											</a>
										</li>
										
										<li>
											<a href="#">
												<span class="number">
													<?php echo $sf_user->getGuardUser()->getUserProfile()->getImages(); ?>
												</span>
												<p><?php echo __('Photos', null, 'company'); ?></p>
											</a>
										</li>
									</ul>
								</div><!-- image-dropdown-head -->

 								<?php if ($sf_user->getGuardUser()->getIsPageAdmin()){ ?>
 									<div class="image-dropdown-company">
                                     <h5><?php echo __('use <i>getlokal</i> as:'); ?></h5>
                                     
                                         <?php if ($sf_user->getPageAdminUser()){ ?>
                                             <div class="image-dropdown-company-wrapp">
 	                                            <div>
 	                                            	<img class="company-photo" src="<?php echo $sf_user->getGuardUser()->getUserProfile()->getThumb(1); ?>" />
 	                                                <a href="<?php echo url_for('companySettings/logout') ?>" title="<?php echo $sf_user->getGuardUser()->getUserProfile(); ?>">
 	                                                    <p class="company-txt"><?php echo $sf_user->getGuardUser()->getUserProfile(); ?></p>
 	                                                </a>
                                                 </div>
                                             </div>
                                         <?php } ?>

                                         <?php foreach ($userPlaces as $place_admin){ ?>
                                         	<div class="image-dropdown-company-wrapp">
 	                                        	<div>
 	                                            <?php $company = $place_admin->getCompanyPage()->getCompany();
 	                                            	  echo image_tag($company->getThumb(0), array('class' => 'company-photo', 'alt' => $company->getI18nTitle())); ?>

 	                                                <?php if ($place_admin->getUsername()){ ?>
 	                                                    <a href="<?php echo url_for('@company_settings?slug=' . $company->getSlug() . '&action=login'); ?>" title="<?php echo $company->getI18nTitle(); ?>">
 															<p class="company-txt"><?php echo $company->getI18nTitle(); ?></p>
 	                                                    </a>
 	                                                <?php } else{ ?>
 	                                                    <a href="<?php echo url_for('userSettings/companySettings#' . $company->getId()) ?>" title="<?php echo $company->getI18nTitle(); ?>">
 															<p class="company-txt"><?php echo $company->getI18nTitle(); ?></p>
 	                                                    </a>
 	                                                <?php } ?>
 	                                            </div>
                                             </div>
                                         <?php 
                                         $count++;
 	                                        if($count > 4){
 	                                        	break;
 	                                        }
                                         } 
                                         ?>

                                         <?php if(count($userPlaces) > 5){ ?>
                                         	<a class="view-all-company" href="<?php echo url_for('userSettings/companySettings') ?>"><?php echo __('see all'); ?> <span></span></a>
                                         <?php } ?>

                                     </div>
 								<?php } ?>                   
                    							
								<div class="image-dropdown-body">
									<ul>
										<li><?php echo link_to(__('Profile', null, 'user'), 'profile/index?username=' . $sf_user->getGuardUser()->getUsername()); ?></li>
										<li><?php echo link_to(__('Settings', null, 'user'), 'userSettings/index'); ?></li>
										<li><?php echo link_to(__('Invite a Friend', null, 'user'), '@invite'); ?></li>
										<li><?php echo link_to(__('My Vouchers'), 'profile/vouchers'); ?> <span class="count">
											<?php echo Doctrine::getTable('Voucher')->getVouchersCount($sf_user); ?>
										</span></li>

										<?php if ($sf_user->getGuardUser()->getIsPageAdmin()): ?>
					                        <li><?php echo link_to(__('My Places', null, 'user'), 'userSettings/companySettings') ?></li>
					                    <?php endif; ?>
					                    
										<li><?php //echo image_tag($sf_user->getGuardUser()->getUserProfile()->getThumb(1)); ?></li>
										<li><?php echo link_to(__('Log Out', null, 'user'), 'user/signout') ?></li>
									</ul>
								</div><!-- image-dropdown-body -->
							</div><!-- image-dropdowns -->
							<a href="javascript:void(0)" class="profile"><i class="fa fa-angle-down fa-2x profile-ico"></i></a>
						</li>

	                    <?php } else{ ?>
		                    <li class="nav-item">
								<a href="javascript:void(0)" class="sign-in default-btn js-sign-in success">
									<?php echo __('Sign in', null, 'user'); ?>
								</a>
							</li>
	                    <?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div><!-- header-bottom -->
</div><!-- header-wrapper -->
<div class="form-login">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<?php include_partial('user/signin_form',array('form'=> new sfGuardFormSignin()));?>
			</div>
		</div>
	</div>
</div><!-- form-login -->