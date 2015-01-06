<?php 
  include_partial('ppSlider', array('company' => $company));
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

<div class="profile-page boxesToBePulledDown">
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <div class="profile">
          <div class="profile-information pp-share">
            <div class="profile-page-image alignleft">
              <?php include_partial('global/gallery_preview', array('images' => $images, 'company' => $company));
              if (is_numeric($company->getImageId())) {
				$imageCount = count($images) ? count($images) : 1;
              ?>
	              <div class="profile-page-image-hover">
	                <div class="hover-bckg"></div>
	                <div class="hover-info">
	                  <i class="fa fa-th"></i>
	                  <div class="counter">See all <?=$imageCount?> photos</div>
	                </div>
	              </div>
              <?php }?>
            </div><!-- profile-page-image -->
            
            <div class="profile-page-content alignright">
              <div class="profile-content-head">
                <div class="wrapper-section-share-page">
                  <div class="share-page-ppp">
                    <h4><?php echo __('SHARE', null, 'company'); ?></h4>
                    <div class="wrapper-social-page-ppp">
                      <div class="socials-container-ppp">
                        <?php include_partial('global/social', array('embed' => 'place', 'company' => $company, 'hasSocialScripts' => false, 'hasSocialHTML' => true)); ?>
                        <!-- <a href="#" class="btn-embed">Embed <i class="fa fa-angle-down"></i></a> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div><!-- profile-content-head -->
            
              <div class="profile-content-body s-h-functionality">
                <div class="text-descripion-ppp child-text-container">
                  <?php if ($company->getCompanyDescription()){ ?>
                      <p><?php echo $company->getCompanyDescription(); ?></p>
                  <?php } else{ ?>
                      <p>
                        <?php 
                          echo sprintf(__('If you have been to %s in %s, leave your rating and review or photo to help other users searching in %s.', null, 'company'), $company->getCompanyTitle(), $company->getCity()->getLocation(), $company->getClassification());
                          echo sprintf(__('You can find %s at %s, telephone %s.', null, 'company'), $company->getCompanyTitle(), $company->getDisplayAddress(), $company->getPhoneFormated()); 
                        ?>
                      <p>
                  <?php } ?>

                  <?php 
                    if ($sf_user->getCulture() != 'sr'){ 
                      $vr1 = $company->getCompanyTitle();
                      $vr2 = link_to(__('claim it', null, 'company'), 'company/claim?slug=' . $company->getSlug());
                    } else{
                      $vr1 = link_to(__('claim it', null, 'company'), 'company/claim?slug=' . $company->getSlug());
                      $vr2 = $company->getCompanyTitle();
                    }
                  ?>

                  <?php 
                    if (!$company->getIsClaimed() && !$user_is_not_approved_admin){ 
                      if ($company->getStatus() == 0){ 
						$businesGetlokal = 'http://business.getlokal.com/';
						switch ( $sf_user->getCulture() ){
							case 'bg': $businesGetlokal .= 'bg'; break;
							case 'ro': $businesGetlokal .= 'ro'; break;
							default: $businesGetlokal .= 'en'; break;
						} 
                  ?>
                      <br /><br />
                      <p><?php echo sprintf(__('If you are a representative of %s, %s and manage this information. It\'s free and easy and %s.', null, 'company'), $vr1, $vr2, link_to(__('just a few steps away', null, 'company'), $businesGetlokal, 'target="_blank"')); ?></p>
                  <?php 
                      } 
                    } 
                  ?>
                  </span>
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
              </div><!-- profile-content-body -->                 

              <?php if ($company->getCompanyDetail() && $company->getCompanyDetail()->getHourFormatCPage('wed')){ ?>          
                <div class="profile-content-foot">
                  <h4><?php echo __('Working Hours', null, 'company') ?></h4>
                  <table>
                    <thead></thead>
                    <tbody>

                      <tr class="week-days">
                      <?php foreach (array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun') as $day){ ?>
                        <th class="<?php echo ($company->getCompanyDetail()->getHourFormatCPage($day) == 'closed' ? 'gray' : '')?>"><?php echo __(ucfirst($day)); ?></th>
                      <?php } ?>
                      </tr>

                      <tr>
                        <?php 
                          foreach (array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun') as $day){ 
                            if ($company->getCompanyDetail()->getHourFormatCPage($day)){
                              echo ($company->getCompanyDetail()->getHourFormatCPage($day) == 'closed' ? '<td class="gray">-</td>' : '<td>' . $company->getCompanyDetail()->getHourFormatCPage($day)) . '</td>';
                            }
                          }
                        ?>
                      </tr>

                    </tbody>
                    <tfoot></tfoot>
                  </table>
                </div><!-- profile-content-foot -->
              <?php } ?>

            </div><!-- profile-page-content -->
          </div><!-- profile-information -->
          
          <div class="write-review">

            <?php
             if (!$is_other_place_admin_logged && !$user_is_admin && !$user_is_company_admin){ ?>
              <a href="javascript:void(0);" onClick="_gaq.push(['_trackEvent', 'Review', 'Write', 'company']);" class="default-btn action write-review-btn">
                <i class="fa fa-comment"></i><?php echo __('Write a Review', null, 'company') ?>
              </a>
            <?php } ?>

          <?php if ($user_is_company_admin && !$user_is_admin){ ?>
    				<a href="<?php echo url_for('company/addImage?id=' . $company->getId(), array(), true) ?>" onclick="getAddPhotoForm(this); return false;"  class="default-btn add-photo"><i class="fa fa-camera"></i><?php echo __('Add a Photo', null, 'company') ?></a>
    			<?php } elseif(!$is_other_place_admin_logged){ ?>
    				<?php if($user){ ?>
             		<a href="<?php echo url_for('company/addImage?id=' . $company->getId(), array(), true) ?>" class="default-btn add-photo" onclick="getAddPhotoForm(this); return false;"><i class="fa fa-camera"></i><?php echo __('Add a Photo', null, 'company'); ?></a>
             	<?php } else{ ?>
             		<a href="javascript:void(0);" id="pp_login" class="default-btn" onclick="loginForm(); return false;"><i class="fa fa-camera"></i><?php echo __('Add a Photo', null, 'company'); ?></a>
    	       <?php } ?>
    			<?php } ?>

          <?php if ($user_is_company_admin && !$user_is_admin){ ?>
            <a href="<?php echo url_for('company/addToList?id='.$company->getId()."&type=none",array(),true)?>" onclick="getAddPhotoForm(this); return false;" class="default-btn add-list"><i class="fa fa-list-ul"><?php echo __('Add to List', null, 'company') ?></a>
          <?php } elseif(!$is_other_place_admin_logged){ ?>
            <?php if($user){ ?>
                <a href="<?php echo url_for('company/addToList?id='.$company->getId()."&type=none",array(),true)?>" class="default-btn add-list" onclick="getAddToListForm(this); return false;"><i class="fa fa-list-ul"></i><?php echo __('Add to List', null, 'company'); ?></a>
              <?php } else{ ?>
                <a href="javascript:void(0);" id="pp_login" class="default-btn" onclick="loginForm(); return false;"><i class="fa fa-list-ul"></i><?php echo __('Add to List', null, 'company'); ?></a>
             <?php } ?>
          <?php } ?>

            <?php if ($user_is_admin or $user_is_company_admin or $sf_user->isGetlokalAdmin() or $sf_user->isGetlokalLocalAdmin($company->getCountry()->getSlug())): ?>
              <a href="<?php echo url_for('companySettings/basic?slug=' . $company->getSlug()); ?>" class="default-btn edit">
                <i class="fa fa-wrench"></i><?php echo __('Place Administration', null, 'company');?>
              </a>
            <?php endif; ?>

            <?php if($sf_user->hasFlash('noticeImg')): ?>
              <?php if ($is_other_place_admin_logged || $user_is_admin || $user_is_company_admin ):?>
                <div class="form-message success notice-img">
                  <?php echo __($sf_user->getFlash('noticeImg')) ?>
                </div>
              <?php else:?>
                <div class="form-message success notice-img">
                  <?php echo __($sf_user->getFlash('noticeImg')) ?>
                </div>
              <?php endif; ?>
            <?php endif; ?>

            <div class="add_photo_content"></div>
            <div id="add_list_wrap"></div>

            <div id="login_form_ppp" style="display:none">
              <?php if(!$user){
                include_component('user', 'signinRegister',array('trigger_id' => 'pp_login', 'button_close' => true));
              } elseif($user_is_company_admin && !$user_is_admin){
                    include_partial('companySettings/pageadmin_signin_form', array('form'=>$formLogin));
              }
              ?>
            </div>

          </div><!-- write-review -->

          <?php include_component('company','vote', array('company'=>$company, 'title'=> '' ) ); ?>

          <!-- ===================================================== OFFERS START ============================================================= -->

        <?php
          if(isset($offers) && count($offers) && $offers){
        ?>      
          <div class="wrapper-offers-ppp"> <!-- start wrapper-offers-ppp -->
            <div class="section-offers-pp-head"> <!-- section-offers-pp-head -->
              <h3>Offers</h3>
            </div> <!-- end section-offers-pp-head -->

            <ul class="section-body-offers-unsorted-list">
              <?php foreach($offers as $offer){ ?>
                <li>
                <a href="#">
                  <div class="section-offers-body">
                  <div class="wrapper-section-offers-image">
                    <div class="section-offers-body-image">
                      
                        <?php 
                          if ($offer->getImageId()){
                                      if ($image = Doctrine_Core::getTable ( 'Image' )->findOneById($offer->getImageId())){ 
                                        echo image_tag($image->getFile(), array('size' => '150x100','alt_title'=> truncate_text(html_entity_decode ($offer->getTitle()), 20, '...', true)));
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
                    <a href="#"><h5><?php echo $offer->getDisplayTitle(); ?></h5></a>
                    <h6><?php echo $company->getCompanyTitle(); ?>,<span><?php echo $company->getCity()->getDisplayCity(); ?></span></h6>
                   <div class="section-body-offers-clock">
                      <div class="section-body-offers-clock-wrapper">
                      <i class="fa fa-clock-o"></i>
                        <?php 
                                    $remaining = Doctrine::getTable('CompanyOffer')->getRemainingTime($offer);
                                    echo format_number_choice('[0]%time%|[1]1 day %time%|(1,+Inf]%days% days %time%', array('%days%' => $remaining->format('%d'), '%time%' => $remaining->format('%h:%i:%s')), $remaining->format('%d'), 'offer'); 
                                ?>
                      </div>
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
                </a>
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

          <?php if (!$company->getIsClaimed()){ ?>
            <?php if ((!$user_is_admin or !$user_is_company_admin) && !$is_other_place_admin_logged && !$user_is_not_approved_admin){ ?>
                
              <div class="bussiness">
                <div class="bussiness-ico">
                  <i class="fa fa-briefcase fa-3x"></i>
                </div>

                <div class="bussiness-content">
                    <h2><?php echo __('Is this your business?', null, 'company'); ?>
                        <span><?php echo __('Claim it!', null, 'company'); ?></span>
                    </h2>
                    <p><?php echo __('Take control of your online reputation and talk to your customers.', null, 'company'); ?></p>
                </div>  

                <div class="bussiness-btn">
                  <?php echo link_to(__('Claim it', null, 'company'), 'company/claim?slug=' . $company->getSlug(), array('class' => 'start-now default-btn')); ?>
                </div><!-- business-btn -->
              </div><!-- bussiness -->
              <?php } ?>
          <?php } ?>

        </div><!-- profile -->
      </div><!-- col-sm-8 -->

      <div class="col-sm-4 sidebar-margin">
        <div class="sidebar">
          <?php include_partial('pp_info',array('company'=>$company))?>

          <div class="widget similar-places">
            <div class="similar-places-head">
              <h3><?php echo __('SIMILAR PLACES', null, 'company') ?></h3>
            </div><!-- similar-places-head -->

            <div class="similar-places-body">
              <ul class="similar-places">
              	<?php foreach($similar_places as $sub_similar_places):?>
	              	<?php foreach($sub_similar_places as $splace):?>
		                <?php include_partial('sidebar_company_list_item',array("company"=>$splace))?>
	                <?php endforeach;?>
                <?php endforeach;?>
              </ul>
            </div><!-- similar-places-body -->
          </div><!-- widget-similar-places -->
            <?php /*
          <div class="widget advertisement">
            <div class="sponsored-advertisement">
              <div class="place-sponsored">
                <div class="sponsored-head">
                  <h3><?php echo __('Sponsored'); ?></h3>
                </div>
                <div class="sponsored-body">                
                    <?php 
                      include_partial('global/ads', array('type' => 'box')); 
                      if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO){ 
                        include_partial('global/ads', array('type' => 'box2'));
                      } 
                    ?> 
                </div><!-- ad-block -->
              </div>
            </div>
          </div><!-- widget advertisement -->
			*/?>
          <div class="widget facebook-likes">
            <div class="facebook-like">
              <div class="facebook-likes-body">
                <?php include_component('home','social_sidebar', array('type' => 'box')); ?>
              </div><!-- facebook-likes-body -->
            </div><!-- facebook-likes -->
          </div><!-- widget facebook-likes --> 

        </div><!-- sidebar -->
      </div><!-- col-sm-4 -->
    </div>
  </div><!-- container -->
</div><!-- profile-page -->

<div class="testimonials_review_wrapper">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="testimonial-wrapper">
          <div class="testimonial-wrapper-head">
            <h3><?php echo __('REVIEWS FOR SIMILAR PLACES', null, 'company'); ?></h3>
          </div><!-- testimonial-wrapper-head -->
          
          <div class="testimonial-wrapper-body">
            <ul class="testimonial-wrapper-list">

              <?php 
                $count = 0;
                  foreach($similar_places as $sub_similar_places){
                    foreach($sub_similar_places as $company){
                      if($count == 2){
                        break;
                      }
                      if($company->getReviews()){      
                        foreach ($company->getReviews(1) as $review) {    
                ?>

                <li class="testimonial-list">
                  <div class="testimonial-list-image">
                    <?php echo link_to(image_tag($review->getUserProfile()->getThumb(1), 'size=70x70 alt= ' . $review->getUserProfile()->__toString()), $review->getCompany()->getUri(ESC_RAW)) ?>
                  </div><!-- testimonial-list-image -->
          
                  <div class="testimonial-list-content">
                    <h4><?php echo link_to($review->getUserProfile()->__toString(), $review->getCompany()->getUri(ESC_RAW)); ?></h4>
                    <span class="comment-txt"><?php echo truncate_text(html_entity_decode($review->getText()), 200, ' ...', true); ?></span>

                    <ul class="testimonial-list-category">
                      <li class="list-category width-100">
                        <h6><?php echo link_to_company($company, array('title' => $company->getCompanyTitle())) ?></h6>
                      </li>

                      <li class="list-category stars-testimonial-list">
                        <div class="stars-holder small wrapper-stars-holder-pp" style="width: <?php echo $company->getRating() ?>%;">          
                          <ul>
                            <li class="gray-star"><i class="fa fa-star"></i></li>
                            <li class="gray-star"><i class="fa fa-star"></i></li>
                            <li class="gray-star"><i class="fa fa-star"></i></li>
                            <li class="gray-star"><i class="fa fa-star"></i></li>
                            <li class="gray-star"><i class="fa fa-star"></i></li>
                          </ul>
                          <div class="top-list">
                            <div class="hiding-holder" style="width: <?php echo $company->getRating() ?>%;">
                              <ul class="spans-holder small">
                                <li class="red-star"><i class="fa fa-star"></i></li>
                                <li class="red-star"><i class="fa fa-star"></i></li>
                                <li class="red-star"><i class="fa fa-star"></i></li>
                                <li class="red-star"><i class="fa fa-star"></i></li>
                                <li class="red-star"><i class="fa fa-star"></i></li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </li>

                      <li class="list-category width-60">
                        <p>
                          <strong>
                            <?php echo format_number_choice('[0]No reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $company->getNumberOfReviews()), $company->getNumberOfReviews(), 'user'); ?>
                          </strong>
                        </p>
                      </li>
                    </ul>

                    <ul class="list-places">
                      <li class="m-top-5"><i class="fa fa-tags"></i>
                        <?php echo link_to($company->getClassification()->getTitle(), $company->getClassificationUri(ESC_RAW), array('title' => $company->getClassification()->getTitle())); ?>
                      </li>
                    </ul>
                  </div><!-- testimonial-list-content -->
                </li>     

                <?php 
                 $count++;
                        }
                      } 
                    }
                  }
                ?>

                <?php if($count == 0){ ?>
                  <li><?php echo __('There are no reviews', null, 'user'); ?></li>
                <?php } ?>

            </ul><!-- testimonial-wrapper-list -->
          </div><!-- testimonial-wrapper-body -->
        </div><!-- testimonial-wrapper -->
      </div>
    </div>
  </div>
</div><!-- testimonials_review_wrapper -->

<script>

  <?php if($sf_user->hasFlash('noticeImg')){ ?>
    $('html, body').animate({
      scrollTop: $(".notice-img").offset().top - 200
    }, 1000);
    $(".notice-img").fadeOut(8000);
  <?php } ?>

	$('.pp-tabs .pp-tab').hide();
    $('.pp-tabs .pp-tab:eq(0)').click(function(){
          $(this).show();
    });
    $('.pp-tabs-head ul li').click(function() {
        var idx = $(this).index();
        if(!$(this).hasClass('current')){
              $('.pp-tabs-head ul li').removeClass('current');
              $(this).addClass('current');
              $('.pp-tabs .pp-tab').hide();
              var activeTab = $('.pp-tab').eq(idx).fadeToggle(); 
        }else{

        }
        return false;
    });

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