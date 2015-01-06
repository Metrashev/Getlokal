<?php //include_partial('pppSlider', array('company' => $company))?>

<?php 
	$county = sfContext::getInstance()->getRequest()->getParameter('county', false);

	if ($county || (getlokalPartner::getInstanceDomain() == 78)){
		$locationLink = link_to($company->getCity()->getCounty()->getLocation(), '@homeCounty?county='. $sf_user->getCounty()->getSlug(), array('class' => 'path-item-ppp'));
		
		$hrefSector = url_for('@sectorCounty?slug='. $company->getSector()->getSlug(). '&county='. $company->getCounty()->getSlug());
		$hrefClassification= url_for('@classificationCounty?slug='. $company->getClassification()->getSlug(). '&sector='. $company->getSector()->getSlug(). '&county='. $company->getCounty()->getSlug(),true);

	}else{
		$locationLink = link_to($company->getCity()->getDisplayCity(), '@home?city='. $sf_user->getCity()->getSlug(), array('class' => 'path-item-ppp'));
		
		$hrefSector = url_for('@sector?slug='. $company->getSector()->getSlug(). '&city='. $company->getCity()->getSlug());
		$hrefClassification= url_for('@classification?slug='. $company->getClassification()->getSlug(). '&sector='. $company->getSector()->getSlug(). '&city='. $sf_user->getCity()->getSlug(),true);
	
	}
?>

<?php 
  slot('description');
    if ($page == 1){
      echo sprintf(__('%s in %s - information in getlokal: see address, telephone, working hours, photos and user reviews for %s, %s', null, 'pagetitle'),$company->getCompanyTitle(),$company->getCity()->getLocation(), $company->getCompanyTitle(), $company->getCity()->getLocation());
    } else{
      echo sprintf(__('Find up-to-date reviews, comments and ratings of customer for %s in %s. Add your own review!', null, 'pagetitle'), $company->getCompanyTitle(), $company->getCity()->getLocation());
    }
    end_slot();
?>

<?php 
  slot('facebook');
  $culture = $sf_user->getCulture(); ?>
  <meta property="fb:app_id" content="<?php echo sfConfig::get('app_facebook_app_'.$sf_user->getCountry()->getSlug().'_id'); ?>"/>
  <meta property="og:title" content="<?php echo $company->getCompanyTitle().' | ' .$company->getClassification()->getTitle(). ' | Getlokal'; ?>" />
  <meta property="og:url" content="<?php echo url_for($company->getUri(ESC_RAW), true);?>" />
  <?php if($company->getImageId()){ ?>
    <meta property="og:image" content="<?php echo image_path($company->getThumb(3), true);  ?>" />
  <?php } else{ ?>
    <meta property="og:image" content="<?php echo image_path('/images/gui/getlokal_thumbnail_200x200.jpg', true);  ?>" />
  <?php } ?>  
  <meta property="og:type" content="business.business" />
  <meta property="og:image" content="<?php echo image_path($company->getThumb(), true)  ?>" />
  <meta property="business:contact_data:country_name" content="<?php echo mb_convert_case($sf_user->getCountry()->getSlug(), MB_CASE_UPPER) ?>" />
  <meta property="business:contact_data:locality" content="<?php echo $company->getCity()->getLocation(); ?>" />
  <meta property="business:contact_data:website" content="<?php echo $sf_request->getUriPrefix(); ?>" />
 
  <?php if($company->getCompanyDescription($culture)){ ?>
    <meta property="og:description" content="<?php echo $company->getCompanyDescription($culture)?>" />
  <?php } ?>

  <?php if($company->getLocation()->getPostcode() != ''){ ?>
    <?php $postal_code = $company->getLocation()->getPostcode(); ?>
  <?php } else{ ?>
    <?php $postal_code = myTools::getPostcode($company->getLocation()->getLatitude(), $company->getLocation()->getLongitude());?>
  <?php } ?>

  <meta property="business:contact_data:postal_code" content="<?php echo $postal_code;?>" />
  <meta property="business:contact_data:street_address" content="<?php echo $company->getDisplayAddress();?>" />
  <meta property="place:location:latitude" content="<?php echo $company->getLocation()->getLatitude() ?>" /> 
  <meta property="place:location:longitude" content=" <?php echo $company->getLocation()->getLongitude() ?>" /> 
<?php end_slot() ?>

<?php slot('canonical'); ?>
  <link rel="canonical" href="<?php echo $company->getCanonicalUrl() ?>">
  <?php foreach(sfConfig::get('app_domain_slugs') as $iso){ ?>
  <link rel="alternate" hreflang="en-<?php echo $iso ?>" href="<?php echo $company->getPermalink($iso, 'en') ?>">
  <link rel="alternate" hreflang="<?php echo $iso ?>-<?php echo $iso ?>" href="<?php echo $company->getPermalink($iso, $iso) ?>">
  <?php } ?>
<?php end_slot(); ?>

<?php CompanyStatsTable::saveStatsLog (sfConfig::get ( 'app_log_actions_page_view' ), $company->getId () );?>

<div class="slider_wrapper ppp">
    <div class="slider-image">
        <div class="dim"></div>
    </div>
    <div class="actual-slider-content">

        <div class="container">
            <div id="myCarousel" class="carousel slide ppp-slider-container" data-ride="carousel">
              <ul class="gallery clearfix">
                <div class="carousel-inner">

				  <div class="item active">
				  	<div class="layout">	
				    <?php
				    	if($company->getCoverImageId()) { ?>
				    		<li class="layout-part">
								<a rel="prettyPhoto[gallery]"
						            name="<?php echo $company->CoverImage->getUserProfile()->getIsCompanyAdmin($company) ? $company->getCompanyTitle() : $company->CoverImage->getUserProfile(); ?>"
									rev="<?php echo $company->CoverImage->getUserProfile()->getIsCompanyAdmin($company) ? url_for( $company->getUri(ESC_RAW)) : url_for($company->CoverImage->getUserProfile()->getUri(ESC_RAW)); ?>"
									title="<?php echo ($company->CoverImage->getCaption() ? $company->CoverImage->getCaption() : $company->getCompanyTitle())?>"
									href="<?php echo sfConfig::get('app_cover_photo_dir').$company->CoverImage->getFilename(); ?>">
						               <?php echo image_tag(sfConfig::get('app_cover_photo_dir').$company->CoverImage->getFilename(), array('alt' => $company->getCompanyTitle() . (($company->getImage()->getCaption()) ? ' - ' . $company->getImage()->getCaption() : ''))) ?>
						        </a>
						    </li>
						    </div></div><div class="item"><div class="layout">
				    	<?php }
						foreach($images as $key => $image) { $key++; ?>
							<li class="layout-part">
								<a rel="prettyPhoto[gallery]"
								   class="img-holder"
						           name="<?php echo ($company->getImage()->getUserProfile()->getIsCompanyAdmin($company) ? $company->getCompanyTitle() : $image->getUserProfile());?>"
						           rev="<?php echo ($company->getImage()->getUserProfile()->getIsCompanyAdmin($company) ? url_for( $company->getUri(ESC_RAW)) : url_for($image->getUserProfile()->getUri(ESC_RAW)) );?>"
						           title="<?php echo($image->getCaption(ESC_RAW)) ?> "
						           href="<?php echo $image->getThumb('preview')?>">
						               <?php echo image_tag($image->getThumb('preview'), array('alt' => $company->getCompanyTitle() . (($company->getImage()->getCaption()) ? ' - ' . $company->getImage()->getCaption() : ''))) ?>
						        </a>
						    </li>

					        <?php if( ($key % 6 == 0 && $key != 1) && ($key != count($images))) { ?>
					        	</div></div><div class="item"><div class="layout">
					        <?php }
						}
				    ?>
						</div>
					</div>
                </div>
              </ul>
              <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"><span class="sl-arrow-left"></span></a>
              <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"><span class="sl-arrow-right"></span></a>
            </div><!-- /.carousel -->
        </div>

    </div>
</div>

<script type="text/javascript" charset="utf-8">
		$(document).ready(function(){

			$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',theme:'facebook',slideshow:3000, autoplay_slideshow: false}); //add , info_markup: 	<?php echo json_encode($sf_data->getRaw('images')); ?> for comments and etc. in image preview

		});
</script>

<div class="profile-page ppp boxesToBePulledDown">
	<div class="container">
		<div class="row">
			<div class="col-sm-8">
				<div class="profile">
					<div class="profile-information profile-information-ppp">
						<div class="profile-information-image alignleft">
							<?php echo image_tag($company->getThumb(0), array('size' => '150x150', 'alt' => $company->getCompanyTitle() . (($company->getImage()->getCaption()) ? ' - ' . $company->getImage()->getCaption() : ''))) ?>
						</div> <!-- profile-page-image -->
						<div class="wrapper-ppp-header">
							<div class="path-holder-ppp-details">
								<?php include_partial('global/breadCrumb'); ?>
								<!-- <?php echo $locationLink; ?>
								        <span>/</span>
								        <a href="<?php echo $hrefSector?>" title="" class="path-item-ppp"><?php echo $company->getSector()->getTitle() ?></a>
								        <span>/</span>
								        <a href="<?php echo $hrefClassification?>" title="" class="path-item-ppp"><?php echo $company->getClassification()->getTitle()?></a>
								 -->
	            			</div><!-- /.path-holder -->
        
     						<h1 class="top-info-heading-offers-details"><?php echo $company->getCompanyTitle(); ?>
     							<?php if ($company->getIsClaimed()){ ?>
				                	<span class="page-icon verified" title="<?php echo __('This page has been claimed by the Place Owner.', null, 'company'); ?>"> <!-- !!!!!! change class premium / verified to change icon -->
										<span class="wrapper-tooltip-ppp"><span class="tooltip-arrow-ppp"></span><span class="tooltip-body-ppp">
											<?php echo __('This page has been claimed by the Place Owner.', null, 'company'); ?>
										</span></span>
									</span>
								<?php } ?>
			                </h1>

				            <div class="reviews-holder review-holder-ppp">
								<div class="stars-holder bigger stars-holder-ppp">					
									<ul>
										<li class="gray-star"><i class="fa fa-star"></i></li>
										<li class="gray-star"><i class="fa fa-star"></i></li>
										<li class="gray-star"><i class="fa fa-star"></i></li>
										<li class="gray-star"><i class="fa fa-star"></i></li>
										<li class="gray-star"><i class="fa fa-star"></i></li>
										<li class="review-rating review-rating-ppp"><span><?php echo $company->getAverageRating();?></span><span>/</span><span>5</span><span class="dash-separator-ppp">-</span></li>
										<li class="reviews-number-ppp">
											<p class="reviews-number">
												<?php echo format_number_choice('[0]No reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $company->getNumberOfReviews()), $company->getNumberOfReviews(), 'user'); ?>
               								</p>
               							</li>
									</ul>
									<div class="top-list">
										<div class="hiding-holder" style="width: <?php echo $company->getRating() ?>%;">
											<ul class="spans-holder">
												<li class="red-star"><i class="fa fa-star"></i></li>
												<li class="red-star"><i class="fa fa-star"></i></li>
												<li class="red-star"><i class="fa fa-star"></i></li>
												<li class="red-star"><i class="fa fa-star"></i></li>
												<li class="red-star"><i class="fa fa-star"></i></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div> <!-- end wrapper-ppp-header -->

						<div class="profile-description s-h-functionality">
							<div class="text-descripion-ppp child-text-container">				              
				                <?php if ($company->getCompanyDescription()){ ?>
				                    <p><?php echo $company->getCompanyDescription(ESC_RAW); ?></p>
				                <?php } else{ ?>
				                    <p>
				                      <?php 
				                        echo sprintf(__('If you have been to %s in %s, leave your rating and review or photo to help other users searching in %s.', null, 'company'),$company->getCompanyTitle(), $company->City->getLocation(), $company->Classification);
				                        echo sprintf(__('You can find %s at %s, telephone %s.', null, 'company'), $company->getCompanyTitle(), $company->getDisplayAddress(),$company->getPhoneFormated());
				                      ?>
				                    <p>
				                <?php } ?>

				                <?php if ($company->getCompanyContent()){ ?>
				                	<p><?php echo $company->getCompanyContent(ESC_RAW);?></p>
				                <?php } ?>

				                <!-- <a href="javascript:void(0)" class="abs-set read-more-description-ppp"><?php echo __('read more...'); ?></a>
				                <a href="javascript:void(0)" class="abs-set read-less-description-ppp"><?php echo __('hide') ?></a> -->

								<div class="show-more-less-container abs-set">
					                <div class="row">
										<div class="col-sm-12">
											<div class="custom-row toggle-row show-more">
												<div class="center-block txt-more">
													<i class="fa fa-angle-double-down fa-lg"></i>
													<span><?php echo __('SHOW MORE', null, 'company'); ?></span>
													<i class="fa fa-angle-double-down fa-lg"></i>
												</div>

												<div class="center-block txt-less">
													<i class="fa fa-angle-double-up fa-lg"></i>
													<span><?php echo __('SHOW LESS', null, 'company'); ?></span>
													<i class="fa fa-angle-double-up fa-lg"></i>
												</div>
											</div><!-- Form Show-more-less Bar -->
										</div>
									</div>
								</div>

							</div>
						</div>

						<div class="profile-category-ppp">
							<div class="section-type-ppp">
							<?php 
								if ((getlokalPartner::getInstanceDomain() == 78) || $sf_request->getParameter('county', false)){
		                    	echo link_to('<i class="fa fa-tags"></i>' . sprintf(__('%s in %s'), $company->getClassification(), $company->getCity()->getCounty()->getLocation()), '@classificationCounty?slug='. $company->getClassification ()->getSlug (). '&sector='. $company->getSector ()->getSlug (). '&county='. $company->getCity()->getCounty()->getSlug(), array('title' => sprintf(__('%s in %s'), $company->getClassification(), $company->getCity()->getCounty()->getLocation())));
			                    	if ($company->getAdditionalClassifications()){
				                    	foreach ($company->getAdditionalClassifications() as $classification){                
				                        echo link_to('<i class="fa fa-tags"></i>' . sprintf(__('%s in %s'), $classification, $company->getCity()->getCounty()->getLocation()), sprintf('@classificationCounty?slug=%s&county=%s&sector=%s', $classification->getSlug(), $company->getCity()->getCounty()->getSlug(), $classification->getPrimarySector()->getSlug()), array('title' => sprintf(__('%s in %s'), $classification, $company->getCity()->getCounty()->getLocation())));
				                        }
			                        }
		                        } else{
		                      		echo link_to('<i class="fa fa-tags"></i>' . sprintf(__('%s in %s'), $company->getClassification(), $company->getCity()->getDisplayCity()), $company->getClassificationUri(ESC_RAW), array('title' => sprintf(__('%s in %s'), $company->getClassification(), $company->getCity()->getDisplayCity())));
			                        if ($company->getAdditionalClassifications()){
				                    	foreach ($company->getAdditionalClassifications() as $classification){
				                    	echo link_to('<i class="fa fa-tags"></i>' . sprintf(__('%s in %s'), $classification, $company->getCity()->getDisplayCity()), $classification->getUrla($company->getCity()->getSlug(), ESC_RAW), array('title' => sprintf(__('%s in %s'), $classification, $company->getCity()->getDisplayCity())));
				                    	} 
			                    	}
		                    	}
		                    ?>
	                        </div>
						</div>

					</div><!-- profile-information and profile-information-ppp-->

					
					<div class="write-review">

						<?php if (!$is_other_place_admin_logged && !$user_is_admin && !$user_is_company_admin){ ?>
				        	<a class="default-btn action write-review-btn">
				        	<i class="fa fa-comment"></i><?php echo __('Write a Review', null, 'company') ?>
				        	</a>
				        <?php } ?>

						<?php 
						if ($user_is_company_admin && !$user_is_admin){ ?>
							<a href="<?php echo url_for('company/addImage?id=' . $company->getId(), array(), true) ?>" onclick="getAddPhotoForm(this); return false;" class="default-btn add-photo"><i class="fa fa-camera"></i><?php echo __('Add a Photo', null, 'company') ?></a>
						<?php } elseif(!$is_other_place_admin_logged){ ?>
							<?php if($user){ ?>
				           	<a href="<?php echo url_for('company/addImage?id=' . $company->getId(), array(), true) ?>" class="default-btn add-photo" onclick="getAddPhotoForm(this); return false;"><i class="fa fa-camera"></i><?php echo __('Add a Photo', null, 'company'); ?></a>
				           	<?php } else{ ?>
				           	<a href="javascript:void(0);" id="ppp_login" class="default-btn" onclick="loginForm(); return false;"><i class="fa fa-camera"></i><?php echo __('Add a Photo', null, 'company'); ?></a>
 				           	<?php } ?>
						<?php } ?>

						<?php 
						if ($user_is_company_admin && !$user_is_admin){ ?>
							<a href="<?php echo url_for('company/addToList?id='.$company->getId()."&type=none",array(),true)?>" onclick="getAddPhotoForm(this); return false;" class="default-btn add-list"><i class="fa fa-list-ul"></i><?php echo __('Add to List', null, 'company') ?></a>
						<?php } elseif(!$is_other_place_admin_logged){ ?>
							<?php if($user){ ?>
 				           	<a href="<?php echo url_for('company/addToList?id='.$company->getId()."&type=none",array(),true)?>" class="default-btn add-list" onclick="getAddToListForm(this); return false;"><i class="fa fa-list-ul"></i><?php echo __('Add to List', null, 'company'); ?></a>
				           	<?php } else{ ?>
				           	<a href="javascript:void(0);" id="ppp_login" class="default-btn" onclick="loginForm(); return false;"><i class="fa fa-list-ul"></i><?php echo __('Add to List', null, 'company'); ?></a>
				           	<?php } ?>
						<?php } ?>
						
						<?php if($company->getEmail() && ($company->reservationType() != false)): ?>
							<a href="javascript:void(0)" class="default-btn" id="show_reservation_form" href="#" onclick="reservationForm('<?=url_for('company/reservation?slug=' . $company->getSlug(), array(), true) ?>'); return false;" title="<?php echo __('Reservation' , null , 'company') ?>"><i class="fa fa-plus"></i><?php echo __('Reservation', null, 'company'); ?></a>
	    					<div class="reservation_content"></div>
	    				<?php endif;?> 

						<?php if ($user_is_admin or $user_is_company_admin or $sf_user->isGetlokalAdmin() or $sf_user->isGetlokalLocalAdmin($company->getCountry()->getSlug())): ?>
			              <a href="<?php echo url_for('companySettings/basic?slug=' . $company->getSlug()); ?>" class="default-btn edit">
			                <i class="fa fa-wrench"></i><?php echo __('Place Administration', null, 'company');?>
			              </a>
			            <?php endif; ?>

			            <?php 
			            if($sf_user->hasFlash('noticeImg')){ 
			            	if ($is_other_place_admin_logged || $user_is_admin || $user_is_company_admin ){ ?>
				                <div class="form-message success notice-img">
				                  <?php echo __($sf_user->getFlash('noticeImg')) ?>
				                </div>
			              <?php } else{ ?>
				                <div class="form-message success notice-img">
				                  <?php echo __($sf_user->getFlash('noticeImg')) ?>
				                </div>
			            <?php 
			        		}
			            } ?>

						<div class="add_photo_content"></div>
				        <div id="add_list_wrap"></div>

				        <div id="login_form_ppp" style="display:none">
			              <?php if(!$user){
			                include_component('user', 'signinRegister',array('trigger_id' => 'ppp_login', 'button_close' => true));
			              } elseif($user_is_company_admin && !$user_is_admin){
			                    include_partial('companySettings/pageadmin_signin_form', array('form'=>$formLogin));
			              }
			              ?>
			            </div>

					</div><!-- write-review -->

					<div class="wrapper-section-share-page ppp-share">
					  <div class="share-page-ppp">
					    <h4><?php echo __('SHARE', null, 'company'); ?></h4>
					    <div class="wrapper-social-page-ppp">
					    <!-- <a href="#" class="btn-embed-ppp"><?php echo __('Embed'); ?> <i class="fa fa-angle-down"></i></a> -->
					      <div class="socials-container-ppp">
					        <?php include_partial('global/social', array('embed' => 'place', 'company' => $company, 'hasSocialScripts' => false, 'hasSocialHTML' => true)); ?>
					        <!-- <a href="#" class="btn-embed">Embed <i class="fa fa-angle-down"></i></a> -->
					      </div>
					    </div>
					  </div>
					</div>
									
					<?php include_component('company','vote', array('company'=>$company, 'title'=> '' ) ); ?>

					<div class="status-updates"></div><!-- status-updates --> 

<!-- ===================================================== EVENTS START ============================================================= -->

					<?php
						$eventsCount = 0;
						if(isset($events) && count($events)){
					?>
						<div class="section-events-pp">
								<div class="section-events-pp-head">
									<h3><?php echo __('Events', null, 'events'); ?></h3>
								</div><!-- section-events-pp-head -->
								
	                            <?php foreach ($events as $event){ ?>
									<div class="wrapper-all-events-ppp">
									<div class="section-events-pp-body">
										<div class="section-events-pp-list no-border-top">
											<div class="section-events-pp-body-image">
											<?php
												if($event->getImage()){
				                                    if ($event->getImage()->getType()=='poster' ){
				                                        echo link_to(image_tag($event->getThumb('preview'),array('size'=>'150x100', 'title'=>$event->getDisplayTitle())), 'event/show?id='.$event->getId());
				                                    } 
				                                } else{
				                                    echo link_to(image_tag($event->getThumb(1), array( 'size'=>'150x100', 'title'=>$event->getDisplayTitle() ) ), 'event/show?id='.$event->getId());
				                                }
			                                ?>
											</div><!-- section-events-pp-body-image -->
											 
											<div class="section-events-pp-body-content">
												<a href="<?php echo url_for('event/show?id='.$event->getId()); ?>"><h3><?php echo $event->getDisplayTitle(); ?></h3></a>
												
												<h6>
									                <?php echo $company->getCompanyTitle(); ?>, 
													<span><?php echo $event->getCity(); ?></span>
												</h6>
											
												<div class="events-pp-date">
													<ul>
														<li>
															<p><?php echo __("From",null,"events")?>: <span><?php echo  $event->getDateTimeObject('start_at')->format('d/m/Y') ?></span></p>
														</li>
											
														<?php
															$start_at = $event->getDateTimeObject('start_at');
															$end_at = $event->getDateTimeObject('end_at');
															
													     	if ($start_at->format('H:i:s') == '00:00:00') :
																$from = $start_at->format('d.m.Y');
															else:
																$from = $start_at->format('d.m.Y H:i')."h";
															endif;
															
															$to = false;
															
															if($end_at->format("dmYHis") != $start_at->format("dmYHis")){
																if ($end_at->format('H:i:s') == '00:00:00') :
																	$to = $end_at->format('d.m.Y');
																else:
																	$to = $end_at->format('d.m.Y H:i')."h";
																endif;
															} 
														?>

														<?php if($to):?>
															<li>
																<p><?php echo __("To",null,"events")?>: <span><?php echo $to?></span></p>
															</li>
														<?php endif;?>
														
													</ul>
												</div><!-- date -->
											
												<div class="events-pp-categories">
													<ul>
														<li>
															<a href="<?php url_for('event/index?category_id='. $event->getCategoryId()); ?>"><p><i class="fa fa-tags"></i><?php echo $event->getCategory();?></p></a>
														</li>
													</ul>
												</div><!-- events-pp-categories -->
											</div><!-- section-events-pp-body-content -->
										</div><!-- section-events-pp-body-list -->
									</div><!-- section-events-pp-body -->
								</div> 
								<?php 
									$eventsCount++;
										if($eventsCount == 3){
				                            break;
				                        }
									} 
								?>
								
								<?php if($eventsCount > 3){ ?>		
									<div class="section-events-pp-foot">
										<a href="#" class="view-all">view all <i class="fa fa-angle-double-right"></i></a>
									</div>
								<?php } ?>
							
						</div><!-- section-events-pp -->
					<?php } ?>

<!-- ===================================================== OFFERS START ============================================================= -->

				<?php
					if(isset($offers) && count($offers) && $offers){
				?>			
					<div class="wrapper-offers-ppp"> <!-- start wrapper-offers-ppp -->
						<div class="section-offers-pp-head"> <!-- section-offers-pp-head -->
							<h3><?php echo __('Offers', null, 'offer'); ?></h3>
						</div> <!-- end section-offers-pp-head -->

						<ul class="section-body-offers-unsorted-list">
							<?php foreach($offers as $offer){ ?>
								<li>
									<div class="section-offers-body">
									<div class="wrapper-section-offers-image">
										<div class="section-offers-body-image">
											
												<?php 
													if ($offer->getImageId()){
								                    	if ($image = Doctrine_Core::getTable ( 'Image' )->findOneById($offer->getImageId())){ 
								                    		echo link_to(image_tag($image->getFile(), array('size' => '150x100','alt_title'=> truncate_text(html_entity_decode ($offer->getTitle()), 20, '...', true))),'offer/show?id='.$offer->getId());
								                    	}   
								                	} 
								                ?>
								         

											<!-- <img src="http://lorempixel.com/150/100/" alt=""></a> -->
											<?php if ($offer->getBenefitChoice() == '1'){ ?>
								                <div class="section-body-image-discount"><?php echo Doctrine::getTable('CompanyOffer')->getDiscount($offer); ?>%</div>
								            <?php } elseif($offer->getBenefitChoice() == '2'){ ?>
								            	<div class="section-body-image-discount"><?php echo $offer->getDiscountPct(); ?>%</div>
								            <?php } ?>
										</div> <!-- section-offers-body-image -->
									</div> <!-- wrapper-section-offers-image -->

									<div class="section-body-offers-description">
										<h5><?php echo link_to($offer->getDisplayTitle(),'offer/show?id='.$offer->getId());?></h5>
										<h6><?php echo $company->getCompanyTitle(); ?>,<span><?php echo $company->getCity()->getDisplayCity(); ?></span></h6>
										<div class="section-body-offers-clock">
											<div class="section-body-offers-clock-wrapper">
											<i class="fa fa-clock-o"></i>
												<?php 
								                    $remaining = Doctrine::getTable('CompanyOffer')->getRemainingTime($offer);
								                    echo format_number_choice('[0]%time%|[1]1 day %time%|(1,+Inf]%days% days %time%', array('%days%' => $remaining->format('%d'), '%time%' => $remaining->format('%h:%i:%s')), $remaining->format('%d'), 'offer'); 
								                ?>
											</div> <!-- section-body-offers-clock-wrapper -->
										</div><!-- section-body-offers-clock -->
									</div>

									<div class="section-body-offers-price">
							            <?php if ($offer->getBenefitChoice()){ ?>
							                <?php switch ($offer->getBenefitChoice()){
							                    case 1:
							                        ?>
													<div class="wrapper-section-body-offers-old-price">
														<p class="section-body-offers-old-price"><?php echo __('Old price', null, 'form'); ?>: <span><?php echo $offer->getOldPrice() . ' '; ?><?php echo $offer->getCompany()->getCountry()->getCurrency(); ?></span></p>
													</div>
													<p class="section-body-offers-new-price"><?php echo __('Price', null, 'form'); ?>: <span><?php echo $offer->getNewPrice() . ' '; ?><?php echo $offer->getCompany()->getCountry()->getCurrency(); ?></span></p>
							                        <?php break; ?>
							                    <?php case 2: ?>
													<p class="section-body-offers-new-price"><?php echo __('Discount', null, 'form'); ?>: <span><?php echo $offer->getDiscountPct(); ?>%</span></p>
							                        <?php break; ?>
							                    <?php case 3: ?>
							            	        <span>
							                           <?php echo truncate_text(html_entity_decode($offer->getBenefitText()), 30, '...', true); ?>
							                        </span>
							                    <?php break; ?>
							                <?php } ?>
							            <?php } ?>
									</div>
								</div><!--end section-offers-body -->
								</li>
							<?php } ?>
						</ul>
					</div><!-- start wrapper-offers-ppp -->
				<?php } ?>
<!-- ===================================================== OFFERS END ============================================================= -->

					<div class="pp-tabs z-index-fix">
						<div class="pp-tabs-head">
							<ul class="default-form-tabs">
							  <li <?=!isset($_REQUEST['tab']) || $_REQUEST['tab'] == 'reviews' ? ' class="current" ' : ''?>>
							  	<a href="#"><?php echo format_number_choice('[0]<span>0</span> reviews|[1]<span>1</span> review|(1,+Inf]<span>%count%</span> reviews', array('%count%' => $reviews->getNbResults()), $reviews->getNbResults(),'company'); ?></a>
			                  </li>
			                  <?php if($events->getNbResults()){ ?>
							  <li <?=isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'events' ? ' class="current" ' : ''?>>
							  	<a href="#"><?php echo format_number_choice('[0]<span>0</span> events|[1]<span>1</span> event|(1,+Inf]<span>%count%</span> events', array('%count%' => $events->getNbResults()), $events->getNbResults(), 'company'); ?></a>
			                  </li>
			                  <?php }
			                  		if($lists->getNbResults()){ ?>
							  <li <?=isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'lists' ? ' class="current" ' : ''?>>
							  	<a href="#"><?php echo format_number_choice('[0]<span>0</span> lists|[1]<span>1</span> list|(1,+Inf]<span>%count%</span> lists', array('%count%' => $lists->getNbResults()), $lists->getNbResults(), 'company'); ?></a>
							  </li>
							  <?php }?>
							</ul>
						</div><!-- pp-tabs-head -->		

						<div class="pp-tabs-body">
						
							<div class="pp-tab">
								<?php include_partial('companyReviewsTab', array('reviewSuccess' => $reviewSuccess, 'reviews' => $reviews, 'company' => $company, 'user'=>$user, 'user_is_admin'=>$user_is_admin, 'user_is_company_admin'=>$user_is_company_admin, 'formRegister' => $formRegister, 'form' => $form, 'formLogin' => $formLogin, 'is_other_place_admin_logged' => $is_other_place_admin_logged)); ?>
							</div><!-- pp-tab -->
							<?php if($events->getNbResults()){ ?>
									<div class="pp-tab">
										<?php include_partial('companyEventsTab', array('events' => $events,'company_id'=>$company->getId())); ?>
									</div><!-- pp-tab -->	
							<?php }
			                  	  if($lists->getNbResults()){ ?>
									<div class="pp-tab">
										<?php include_partial('companyListsTab', array('lists' => $lists,'company_id'=>$company->getId())); ?>
									</div><!-- pp-tab -->		
							<?php } ?>
						</div><!-- pp-tabs-body -->
					</div><!-- tabs --> 

		          <div class="section-followers">
		            <div class="followers">
		              <?php if (isset($followers) && count($followers)){ 
		                    $count = 0;?>
		                <h4><?php echo __('Followers', null, 'messages') . ' (' . count($followers) . ')'; ?></h4>
		                
		                <ul>
		                  <?php foreach ($followers as $follower){ ?>
		                    <li>
		                      <?php if($follower->getUserProfile()->getId() == sfContext::getInstance()->getUser()->getId()){ ?>
		                        <a href="<?php echo url_for('follow/stopFollow?page_id=' . $company->getCompanyPage()->getId()); ?>">
		                          <div class="unfollow" title="unfollow" data-toggle="tooltip" data-placement="top">
		                            <i class="fa fa-times fa-lg"></i>
		                          </div>
		                          <?php echo image_tag($follower->getUserProfile()->getThumb(1), array('alt' => '')); ?>
		                        </a>

		                      <?php } else{ ?>
		                        <a href="<?php echo url_for('user_page', array('username' => $follower->getUserProfile()->getSfGuardUser()->getUsername()), true); ?>">
		                          <?php echo image_tag($follower->getUserProfile()->getThumb(1), array('alt' => '')); ?>
		                        </a>
		                      <?php } ?>
		                    </li>
		                  <?php $count++;
		                      if($count == 7){
		                        break;
		                      }
		                    } 
		                  ?>

		                  <?php if(count($followers) > 7){ 
		                    $leftFollowers = count($followers) - 7; ?>
		                    <li>
		                      <a class="counter-followers-company"><?php echo '+ ' . $leftFollowers;?></a>
		                    </li>
		                  <?php } ?>
		                </ul>

		              <?php } ?>

		              <?php if (!$is_followed && $user && !$user_is_admin && !$is_other_place_admin_logged && !$user_is_company_admin){ ?>
		                <div>
		                    <?php echo link_to(__('Follow Us'), 'follow/follow?page_id=' . $company->getCompanyPage()->getId(), array('class' => 'default-btn success pull-right')); ?>
		                </div>
		              <?php } ?>

		            </div>
		          </div><!-- section-followers -->
				</div><!-- profile -->
			</div><!-- col-sm-8 -->

			<div class="col-sm-4 sidebar-margin-ppp">
				<div class="sidebar">

				<?php include_partial('ppp_info',array('company'=>$company)); ?>
					
					<?php if(count($company->getFeatureCompany())){ ?>
						<div class="widget section-features">
							<div class="features-head">
								<h3>Features</h3>
							</div><!-- features-head -->

							<div class="features-body">
								<ul>
									<?php foreach ($company->getFeatureCompany() as $ft){ ?>
						                <?php 
						                	$atl_tile = $ft->getName();
						                	$images = array('1' => 'free-parking', '2' => 'pay-parking', '3' => 'pay-with-card', '4' => 'private-party', '5' => 'weddings', '6' => 'self-service', 
						                					'7' => 'place-out', '8' => 'place-in', '9' => 'free-wi-fi', '10' => 'delivery', '11' => 'invalid-place', '12' => 'child-place');
						                ?>
						                <?php if($ft->getId() == 7){ ?>
						    				<li>
												<div title="<?php echo $atl_tile; ?>" class="features-ppp place-out" href="#"></div><span><?php echo $company->CompanyDetail->getOutdoorSeats();?></span>
											</li>
						                <?php } elseif ($ft->getId() == 8){ ?>
						    				<li>
												<div title="<?php echo $atl_tile; ?>" class="features-ppp place-in" href="#"></div><span><?php echo $company->CompanyDetail->getIndoorSeats();?></span>
											</li>
						                <?php } elseif ($ft->getId() == 9){ ?>
						    				<li>
												<div title="<?php echo $atl_tile; ?>" class="features-ppp free-wi-fi" href="#"></div>
													<span>
													    <?php 
														    if($company->CompanyDetail->getWifiAccess() == 0){
														    	echo 'Free';
														    } elseif($company->CompanyDetail->getWifiAccess() == 1){
														    	echo 'Paid';
														    }
													     ?>
													</span>
											</li>
						                <?php } else{ ?>
						                	<li>
												<div title="<?php echo $atl_tile; ?>" class="features-ppp <?php echo $images[$ft->getId()]; ?>" href="#"></div>
											</li>
						                <?php } ?>
						             <?php } ?>
								</ul>
							</div><!-- features-body -->
						</div><!-- widget -->
					<?php } ?>

					<?php  if ($company->getFacebookUrl()){ ?>
						<div class="widget facebook-likes">
							<div class="facebook-like">
								<div class="facebook-likes-body">
									<?php include_partial('home/social_sidebar',array('facebook'=>$company->getFacebookUrl(), 'type' => 'box'));?>
								</div><!-- facebook-likes-body -->
							</div><!-- facebook-likes -->
						</div><!-- widget facebook-likes -->
					<?php } 
					if(is_object($company->getCreatedByUser()) && $company->getCreatedByUser()->getSfGuardUser()->getFirstName() != ''){
							?>
							<div class="widget adder">
								<div class="adder-information">
									<div class="adder-image">
										<a href="#"><?php echo image_tag($company->getCreatedByUser()->getThumb(), 'size=50x50') ?></a>
									</div><!-- adder-image -->
		
									<div class="adder-content">
										<p><?php echo __('This place was added by', null, 'company'); ?></p>
										<h3>
											<a href="<?php echo url_for('profile/index?username=' . $company->getCreatedByUser()->getSfGuardUser()->getUsername()); ?>">
												<?php echo $company->getCreatedByUser()->getSfGuardUser()->getFirstName() . ' ' . $company->getCreatedByUser()->getSfGuardUser()->getLastName(); ?>
											</a>
										</h3>
									</div><!-- adder-content -->
								</div><!-- adder-information -->
							</div><!-- widget -->
					<?php }?>
				</div><!-- sidebar -->
			</div><!-- col-sm-4 -->
		</div>
	</div><!-- container -->
</div><!-- profile-page -->

<script type="text/javascript">

	<?php if($sf_user->hasFlash('noticeImg')){ ?>
		$('html, body').animate({
		scrollTop: $(".notice-img").offset().top - 200
		}, 1000);
		$(".notice-img").fadeOut(8000);
	<?php } ?>

     // $(function() {
        // Load Statuses
        getStatuses();

    // });

    // Return statuses
    function getStatuses() {
        $.post("<?php echo url_for('company/getListOfCompanyStatuses?slug=' . $company->getSlug() . '&city=' . $company->City->getSlug(), array(), true) ?>", {},
            function(data){
                if ($.trim(data)) {
                    // $('.listOfStatuses .status_scroll').remove();
                    $('.status-updates').append(data);
                    $('.status-updates').show();
                }
                // else {
                //   <?php if (($user_is_admin && $user_is_company_admin) || $sf_user->isGetlokalAdmin()): ?>
                //       $('.status-updates-body').hide();
                //         <?php else: ?>
                //             $('.status-updates').hide();
                //   <?php endif;?>
                // }
            }
        );
    }

    function removeStatus(id) {
        $.post("<?php echo url_for('company/removeCompanyStatus?slug=' . $company->getSlug() . '&city=' . $company->City->getSlug(), array(), true) ?>", { "remove": true, "statusId": id },
            function(data){
                if (data.success != undefined && data.success) {
                    $("#status_update_msg").html("<?php echo __('Your status update was deleted from getlokal. However it cannot be deleted from the other sites it was published on. In order to do so you will need to log into each of your other accounts where the status was published and delete it manually.', null, 'status') ?>");
          $("#status_update_msg").removeAttr('class').addClass('flash_success');
                    getStatuses();
                }
            },
            "json"
        );
    }

$(document).ready(function(){
  $("#hide").click(function(){
    $("p").hide();
  });
});

  function getReservationForm() {
		$('.reservation_content').html('');
		$('.add_photo_content').html('');
		$('#add_list_wrap').html('');
		$('#buttons_login_form').hide();
	  
	}
</script>

<script type="text/javascript" src="/js/pp_ppp.js"></script>

<style>
  .notice-img.success {
    background: #41d49a;
  }

  .notice-img {
    width: 100%;
    padding: 5px 0;
    margin: 0 0 15px;
    font-family: OpenSans-Semibold;
    font-size: 14px;
    text-align: center;
    color: #fff;
  }
</style>