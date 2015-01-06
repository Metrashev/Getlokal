<div id="loading-overlay" class="loading-overlay" style="display: none;"></div> 
<?php slot('canonical') ?>
    <link rel="canonical" href="<?php echo $company->getCanonicalUrl() ?>">
    <?php foreach(sfConfig::get('app_domain_slugs') as $iso): ?>
      <link rel="alternate" hreflang="en-<?php echo $iso ?>" href="<?php echo $company->getPermalink($iso, 'en') ?>">
      <link rel="alternate" hreflang="<?php echo $iso ?>-<?php echo $iso ?>" href="<?php echo $company->getPermalink($iso, $sf_user->getCulture()) ?>">
    <?php endforeach ?>
<?php end_slot() ?> 
<?php use_helper('Date', 'XssSafe');?>
<?php $hasSocialScripts = true;?>
<?php $hasSocialHTML = false;?>
<div class="vip_gallery_wrap">
  <div class="vip_gallery_tabs_top">
    <div>
      <?php if ($company->getCoverImageId()): ?>
        <a class="current" title="<?php echo __('Cover Photo', null, 'company');?>" href="javascript:void(0);" rel="header_photo_wrap"><?php echo __('Cover Photo', null, 'company');?></a>
      <?php endif;?>
      <?php if (count($images)>0 || $company->getImageId()):?>
        <a <?php echo (!$company->CoverImage->getId() ) ? 'class="current"' : '' ?> title="<?php echo __('Photos', null, 'company');?>" href="#photo" rel="photo_gallery"><?php echo __('Photos', null, 'company');?></a>
          <?php endif;?>
      <?php if ($videos):?>
            <a title="<?php echo __('Videos', null, 'company');?>" href="#video" rel="video_gallery"><?php echo __('Videos', null, 'company');?></a>
          <?php endif;?>

          <a <?php echo (!count($images) && !$company->getImageId()  && !$company->CoverImage->getId() ) ? 'class="current"' : '' ?> title="<?php echo __('Map');?>" href="#map"  rel="map_gallery" ><?php echo __('Map');?></a>
      <div class="clear"></div>
    </div>
  </div>
  <div class="vip_gallery_tabs_in"> 

        <?php if ($company->getCoverImageId()):?>
      <div class="header_photo_wrap gallery_tab_content">
        <img src="<?php echo  sfConfig::get('app_cover_photo_dir').$company->CoverImage->getFilename() ?>" alt="<?php echo ($company->CoverImage->getCaption() ? $company->CoverImage->getCaption() : $company->getCompanyTitle())?>" />
      </div>
    <?php endif;?>

    <?php if (count($images) || $company->getImageId()):?>
      <div class="photo_gallery gallery_tab_content" <?php echo $company->CoverImage->getId() ? 'style="display:none"' : ''; ?>>
          <div class="photo_gallery_content">
            <?php $profileImage=0 ; ?>
             <?php if ($company->getImageId()):?>
             <?php $profileImage=1 ; ?>
                <a rel="group"
                name="<?php echo ($company->Image->UserProfile->getIsCompanyAdmin($company) ? $company->getCompanyTitle() : $company->Image->UserProfile->getLink());?>"
                rev="<?php echo ($company->Image->UserProfile->getIsCompanyAdmin($company) ? url_for( $company->getUri(ESC_RAW)) : $company->Image->UserProfile->getUrl());?>"
                title="<?php echo ($company->Image->getCaption()) ?>"
                class="grouped_elements"
                href="<?php echo $company->Image->getThumb('preview')?>"></a>

              <div class="image_desc">
                  <?php echo image_tag($company->Image->getThumb(2), array('size=139x100', 'alt'=> $company->getCompanyTitle() . (($company->Image->getCaption()) ?  ' - '. $company->Image->getCaption() :''))) ?>
              <div class="content" <?php echo ( $company->Image->UserProfile->getIsCompanyAdmin($company) ) ? '' : 'style="padding-left: 2px;"'?>>
                    <?php if ( $company->Image->UserProfile->getIsCompanyAdmin($company) ):?>
                  <img alt="<?php echo __("Official") ?>" src="/images/gui/bg_official.png" />
                <?php endif;?>
                <div>
                  <p><?php echo simple_format_text($company->Image->getCaption()) ?> </p>
                  <p><?php echo __('by') .' '.( $company->Image->UserProfile->getIsCompanyAdmin($company) ?
                  '<a href="'.url_for( $company->getUri(ESC_RAW)).'">'.$company->getCompanyTitle().'</a>' :
                  $company->Image->UserProfile->getLink(false, null, '', ESC_RAW));  ?></p>
                  </div>
                </div>
              </div>
        <?php endif;?>

          <?php foreach($images as $image): ?>
          <a rel="group"
              name="<?php echo ($image->UserProfile->getIsCompanyAdmin($company) ? $company->getCompanyTitle() : $image->UserProfile->getLink());?>"
              rev="<?php echo ($image->UserProfile->getIsCompanyAdmin($company) ? url_for( $company->getUri(ESC_RAW)) : $image->UserProfile->getUrl());?>"
              title="<?php echo ($image->getCaption()) ?>"
              class="grouped_elements"
              href="<?php echo $image->getThumb('preview')?>"></a>

          <div class="image_desc">
                <?php echo image_tag($image->getThumb(2), array('size=139x100', 'alt'=> $company->getCompanyTitle() . (($image->getCaption()) ?  ' - '. $image->getCaption() :''))) ?>
              <div class="content" <?php echo ( $image->UserProfile->getIsCompanyAdmin($company) ) ? '' : 'style="padding-left: 2px;"'?>>
                <?php if ( $image->UserProfile->getIsCompanyAdmin($company) ):?>
                  <img alt="<?php echo __("Official") ?>" src="/images/gui/bg_official.png" />
                <?php endif;?>
                <div>
                  <p><?php echo simple_format_text($image->getCaption()) ?></p>
                  <p><?php echo __('by').' '.
                  ( $image->UserProfile->getIsCompanyAdmin($company) ?
                  '<a href="'.url_for( $company->getUri(ESC_RAW)).'">'.$company->getCompanyTitle().'</a>' :
                  $image->UserProfile->getLink(false, null, '', ESC_RAW)); ?></p>
                </div>
              </div>
          </div>
        <?php endforeach; ?>
          </div>
      </div>
      <?php endif;?>

      <?php if ($videos):?>
      <div class="video_gallery gallery_tab_content" style="display: none;">
        <ul>
          <?php foreach($videos as $video): ?>
            <li>
              <iframe style="display:block; margin: 0px auto;" width="485" height="296" src="http://www.youtube.com/embed/<?php echo $video->getLink();?>?wmode=transparent" frameborder="0" allowfullscreen></iframe>
              <?php /*?>
              <div class="photo_gallery_upload_options photo_gallery_video_upload_options">
                <span class="photo_number"></span>
                <?php echo $video->UserProfile->getLink(false, null, 'class=photo_gallery_upload_options_personName', ESC_RAW) ?>
                <?php echo simple_format_text($video->getDescription()) ?>
                </div>
                */ ?>
            </li>
            <?php endforeach ?>
            </ul>
            <?php if (count($videos) > 1):?>
              <a href="#" id="prev_video" style="display:none"><img src="/images/gui/big_arrow_left.png" alt="&lt" /></a>
          <a href="#" id="next_video"><img src="/images/gui/big_arrow_right.png" alt="&gt" /></a>
        <?php endif;?>
      </div>
    <?php endif;?>
    <div class="map_gallery gallery_tab_content" <?php echo (count($images) || $company->getImageId() || $company->CoverImage->getId () ) ? 'style="display:none"' : '' ?>;>
      <div id="map_canvas" style="width: 950px; height: 300px;"></div>
      </div>
      <div class="tour_gallery gallery_tab_content" style="display: none;"></div>
  </div>
</div>
<div class="social_share_wrap">
  <?php include_partial('global/social', array('embed' => 'place', 'company' => $company, 'hasSocialScripts' => false, 'hasSocialHTML' => true))?>
</div>


<div itemscope itemtype="http://schema.org/LocalBusiness">
  <div class="place_main place_main_vip">
    <div class="place_main_top">
      <?php if($user_is_admin or $user_is_company_admin or $sf_user->isGetlokalAdmin()):?>
        <div class="place_admin">
          <a class="button_float" href="<?php echo url_for('companySettings/basic?slug='. $company->getSlug());?>">
            <img src="/images/gui/logo_mobile.png" />
            <?php echo __('Place Administration', null,'company'); ?>
          </a>
        </div>
      <?php endif;?>

      <h1 itemprop="name"><a href="<?php echo url_for('company', array('city' => $company->City->getSlug(), 'slug' => $company->getSlug())) ?>" title="<?php echo $company->getCompanyTitle() ?>"><?php echo $company->getCompanyTitle() ?></a></h1>

      <div class="place_rateing">
		<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
			<?php if ($company->getNumberOfReviews() == 0): ?>
			<meta itemprop="worstRating" content="0">
			<meta itemprop="bestRating" content="5">
			<?php endif; ?>
			<div itemprop="ratingValue" content="<?php echo $company->getAverageRating() ?>"></div>
			<div itemprop="ratingCount" content="<?php echo $company->getNumberOfReviews() == 0 ? 1 : $company->getNumberOfReviews() ?>"></div>
		</div>
		<div class="rateing_stars">
          <div style="width: <?php echo $company->getRating() ?>%" class="rateing_stars_orange"></div>
        </div>
        <span><?php echo $company->getAverageRating() ?> / 5</span>
        <?php if ($company->getNumberOfReviews()> 0 ):?>
          <span class="review_count"><?php echo format_number_choice('[0]No reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $company->getNumberOfReviews()), $company->getNumberOfReviews(),'user'); ?></span>
          <?php endif;?>
          <div class="place_badge">
          <?php echo image_tag('gui/place_oficial_'.$sf_user->getCulture().'.png', array('alt' => __('Official')));?>
        </div>
      </div>
      <div class="clear"></div>

      <div itemprop="image" content="<?php echo image_path($company->getThumb(), true) ?>"></div>

        <div class="category_wrap">
        <ul>
          <?php if ((getlokalPartner::getInstanceDomain() == 78) || $sf_request->getParameter('county', false)): ?>
              <li><?php echo link_to(sprintf(__('%s in %s'), $company->Classification, $company->City->County->getLocation()), '@classificationCounty?slug='. $company->Classification->getSlug (). '&sector='. $company->Sector->getSlug (). '&county='. $company->City->County->getSlug(), array('title' => sprintf(__('%s in %s'), $company->Classification, $company->City->County->getLocation()))) ?></li>
                      <?php if ($company->getAdditionalClassifications()): ?>
                          <?php foreach ($company->getAdditionalClassifications() as $classification): ?>                
                              <li><?php echo link_to(sprintf(__('%s in %s'), $classification, $company->City->County->getLocation()), sprintf('@classificationCounty?slug=%s&county=%s&sector=%s', $classification->getSlug(), $company->City->County->getSlug(), $classification->getPrimarySector()->getSlug()), array('title' => sprintf(__('%s in %s'), $classification, $company->City->County->getLocation()))) ?></li>
                          <?php endforeach; ?>
                      <?php endif; ?>
          <?php else: ?>
              <li><?php echo link_to(sprintf(__('%s in %s'), $company->Classification, $company->City->getDisplayCity()), $company->getClassificationUri(ESC_RAW), array('title' => sprintf(__('%s in %s'), $company->Classification, $company->City->getDisplayCity()))) ?></li>
                <?php if ($company->getAdditionalClassifications()): ?>
                  <?php foreach ($company->getAdditionalClassifications() as $classification):?>
                    <li><?php echo link_to(sprintf(__('%s in %s'), $classification, $company->City->getDisplayCity()), $classification->getUrla($company->City->getSlug(),  ESC_RAW), array('title' => sprintf(__('%s in %s'), $classification, $company->City->getDisplayCity()))) ?></li>
                  <?php endforeach;?>
                <?php endif;?>
          <?php endif; ?>
        </ul>
        <div class="clear"></div>
      </div>
    </div>

    <div class="place_left">
      <div class="place_item_gray">
        <b class="ico-awesome"><a href="<?php echo url_for('@company_suggest?city='.$sf_request->getParameter('city').'&slug='.$sf_request->getParameter('slug')); ?>" title="<?php echo __('Suggest an Edit' , null , 'company') ?>" ><i class="fa fa-edit"></i></a></b>
        <div class="place_contact_info" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
          <?php if ($company->getPhone()):?>
            <?php if ($company->getPhone1() or  $company->getPhone2()):?>
                <a href="#" class="place_phone_number" itemprop="telephone"><?php echo $company->getPhoneFormated() ?></a>
            <?php else: ?>
              <span class="place_phone_number" itemprop="telephone"><?php echo $company->getPhoneFormated() ?><i></i></span>
              <?php endif;?>
          <?php endif;?>

          <?php if ($company->getPhone1()):?>
            <span class="extra_number" style="display:block;"><?php echo $company->getPhoneFormated($company->getPhone1()) ?></span>
          <?php endif;?>

          <?php if ($company->getPhone2()):?>
            <span class="extra_number" style="display:block;margin-bottom:10px;"><?php echo $company->getPhoneFormated($company->getPhone2()) ?></span>
          <?php endif;?>

          <address>
            <meta itemprop="addressCountry" content="<?php echo mb_convert_case($company->getCountry()->getSlug(), MB_CASE_UPPER)?>" />
            <meta itemprop="addressLocality" content="<?php echo $company->City->getLocation();?>" />
            <meta itemprop="addressRegion" content="<?php echo $company->City->County->getRegion();?>" />
            <?php if ($company->getLocation()->getPostcode()):?>
              <meta itemprop="postalCode" content="<?php echo $company->getLocation()->getPostcode();?>" />
            <?php endif;?>
            <?php $address = explode(', ', $company->getDisplayAddress(), 2);?>
            <meta itemprop="streetAddress" content="<?php echo $address[1];?>" />
          </address>

          <p><?php echo $company->getDisplayAddress() ?></p>

          <?php if ($company->getAddressInfo()): ?>
            <p><?php echo $company->getAddressInfo(); ?></p>
          <?php endif;?>

          <?php if ($company->getEmail()):?>
            <div class="email_form_wrap">
              <div class="link">
                <?php echo getSendEmailLink($company);?>
              </div>
              <div class="mask"></div>
              <div class="email_form" id="contact_form"></div>
            </div>
          <?php endif;?>
          <?php if ($company->getWebsiteUrl()):?>
            <?php echo getCompanyWebSite($company);?>
          <?php endif;?>
          <div class="clear"></div>
            </div>
          </div>
        </div>

        <div class="place_right <?php echo ((isset($eventCount) && $eventCount) || (isset($offerCount) && $offerCount)) ? '' : 'place_nav_small' ?>">
          <div class="place_item_gray">
            <div class="place_navigation_bar">
              <?php if (isset($eventCount) && $eventCount) : ?>
                  <a id="show_events" href="#" onclick="getAllEvents(false); return false;" title="<?php echo __('Events') ?>"><?php echo __('Events') ?></a>
              <?php endif; ?>

              <?php if (isset($offerCount) && $offerCount) : ?>
                  <a id="show_offers" href="#" onclick="getAllOffers(); return false;" title="<?php echo __('Offers', null, 'offer') ?>"><?php echo __('Offers', null, 'offer') ?></a>
              <?php endif; ?>
			  
			   <?php if($company->getEmail() && ($company->isRestaurant() || $company->isHotel())): ?>
			           <a id="show_reservation_form" href="#" onclick="getReservationForm(); return false;" title="<?php echo __('Reservation' , null , 'company') ?>"><?php echo __('Reservation', null, 'company') ?></a>
              <?php endif;?> 
                  
        	<?php $menu = $company->getFirstMenu(); 
        		if ($menu) {
        			echo sfOutputEscaperGetterDecorator::unescape($menu->getDownloadLink(__($menu->getName()), 'target = "_blank"'));
        		}
        	?>
              
                  
          <div class="clear"></div>
        </div>
      </div>
    </div>
    <div class="clear"></div>
    <div class="place_content">
      <div id="place_left" class="place_left">
                <div class="report_success" style="display: none; margin: 5px 0 0 25px;">
                  <?php echo __($sf_user->getFlash('notice')) ?>
                </div>

         <?php if ($company->getLogoImageId()):?>
        <div class="place_left_item place_logo_item">
          <?php echo image_tag($company->getLogoImage()->getThumb(0), array('alt'=>($company->getLogoImage()->getCaption()? $company->getLogoImage()->getCaption() : $company->getCompanyTitle())));?>
        </div>
          <?php endif;?>

        <?php if($company->CompanyDetail && $company->CompanyDetail->getHourFormatCPage('wed')): ?>
          <div class="place_left_item place_working_hours">
            <div class="place_work">
              <h3><?php echo __('Working Hours',null,'company') ?></h3>
                  <div id="place_work_in">
                <?php foreach(array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun') as $day): ?>
                  <div class="place_work_item">
                    <b><?php echo __(ucfirst($day)) ?></b>
                        <?php if ($company->CompanyDetail->getHourFormatCPage($day)): ?>
                          <?php echo ($company->CompanyDetail->getHourFormatCPage($day)== 'closed' ? '<img title="'.__('Closed').'" src="/images/gui/locked.png" alt="X" />' : $company->CompanyDetail->getHourFormatCPage($day)); ?>
                        <?php endif; ?>
                      </div>
                    <?php endforeach ?>
                    <div class="clear"></div>
                </div>
            </div>
          </div>
        <?php endif ?>

        <?php if($company->getFacebookUrl() or $company->getGoogleplusUrl() or $company->getFoursquareUrl() or $company->getTwitterUrl() or ($company->getCountryId()==4 && $company->getCompanyDetailSr()->getSrUrl() )): ?>
          <div class="place_item place_left_item place_links">
            <?php if ($company->getFacebookUrl()):?>
              <?php echo getCompanyFacebook($company);?>
            <?php endif;?>
            <?php if ($company->getTwitterUrl()):?>
              <?php echo getCompanyTwitter($company);?>
            <?php endif;?>
            <?php if ($company->getFoursquareUrl()):?>
              <?php echo getCompanyFoursquare($company);?>
            <?php endif;?>
            <?php if ($company->getGoogleplusUrl()):?>
              <?php echo getCompanyGooglePlus($company);?>
            <?php endif;?>
            <?php if ($company->getCountryId()==4 && $company->getCompanyDetailSr()->getSrUrl() ):?>
              <?php echo getCompanyYellowPagesRS($company);?>
            <?php endif;?>
            <div class="clear"></div>
          </div>
        <?php endif; ?>

        <?php if(!is_null($company->getCreatedByUser()->getId())): ?>
          <div class="vip-added-place">
            <div class="added-place">
              <div class="adder-image">
              <?php echo image_tag($company->getCreatedByUser()->getThumb(), 'size=50x50') ?>
                
              </div><!-- adder-image -->

              <div class="adder-content">
                <p><?php echo __('This place was added by', null, 'company') . " "; ?></p>
                <h3>
                  <a href="<?php echo url_for('profile/index?username=' . $company->getCreatedByUser()->getSfGuardUser()->getUsername()); ?>">
                    <?php echo $company->getCreatedByUser()->getSfGuardUser()->getFirstName() . ' ' . $company->getCreatedByUser()->getSfGuardUser()->getLastName(); ?>
                  </a>
                </h3>
              </div><!-- adder-content -->
            </div><!-- added-place -->
          </div><!-- vip-adder-place -->
        <?php endif; ?>

        <div class="place_item place_left_item place_voting">
          <?php include_component('company','pppVote', array('company'=>$company, 'title'=> '' ) ); ?>
        </div>

        <?php if($user && !$user_is_admin && !$is_other_place_admin_logged && !$user_is_company_admin):?>
                                    <?php if (isset($followers) && count($followers)) : ?>
                                        <div class="place_item place_left_item">
            <!-- place_followers start -->
            <div class="place_followers">
              <h2><?php echo __('Followers', null, 'messages'); ?></h2>

              <!-- Follower images start -->
                                                        <div class="img_wrap" <?php echo (count($followers) > 10) ? 'style="height:105px"' : ''; ?>>
                                                            <div>
                                                                <?php foreach ($followers as $follower) : ?>
                                                                    <a href="<?php echo url_for('user_page', array('username' => $follower->UserProfile->SfGuardUser->getUsername()), true) ?>" title="<?php echo $follower->UserProfile->SfGuardUser->getFirstName() . ' ' . $follower->UserProfile->SfGuardUser->getLastName(); ?>">
                                                                        <?php echo image_tag($follower->UserProfile->getThumb(0), array('alt'=>'')); ?>
                                                                    </a>
                                                                 <?php endforeach; ?>

                                                                <div class="clear"></div>
                                                            </div>
                                                        </div>
              <!-- Follower images end -->

              <!-- Follow us link start -->
                <?php if (!$is_followed):?>
                  <?php echo link_to(__('Follow Us'). ' ('. $company->getFollowers(true).')', 'follow/follow?page_id='. $company->getCompanyPage()->getId(), array('class' =>'button_green button_clickable')); ?>
                <?php else:?>
                  <?php echo link_to(__('Unfollow Us'). ' ('. $company->getFollowers(true).')', 'follow/stopFollow?page_id='. $company->getCompanyPage()->getId(), array('class' =>'button_green button_clickable button_clicked')); ?>
                <?php endif;?>
              <!-- Follow us link end -->

                                                        <?php if (count($followers) > 10) : ?>
                                                            <!-- See more start -->
                                                            <a href="#" class="right" id="show_followers">
                                                                    <?php echo __('see all')?>
                                                                    <img src="/images/gui/arrow_down_blue.png" />
                                                            </a>
                                                            <a href="#" class="right" id="hide_followers">
                                                                    <?php echo __('hide')?>
                                                                    <img src="/images/gui/arrow_down_gray.png" />
                                                            </a>
                                                            <!-- See more end -->
                                                        <?php endif; ?>
            </div>
            <!-- place_followers end -->
          </div>
                                    <?php else : ?>
                                      <div class="place_item place_left_item place_no_followers">
                                          <!-- Follow us link start -->
                                          <?php if (!$is_followed):?>
                                                  <?php echo link_to(__('Follow Us'). ' ('. $company->getFollowers(true).')', 'follow/follow?page_id='. $company->getCompanyPage()->getId(), array('class' =>'button_green button_clickable')); ?>
                                          <?php else:?>
                                                  <?php echo link_to(__('Unfollow Us'). ' ('. $company->getFollowers(true).')', 'follow/stopFollow?page_id='. $company->getCompanyPage()->getId(), array('class' =>'button_green button_clickable button_clicked')); ?>
                                          <?php endif;?>
                                          <!-- Follow us link end -->
                                        </div>
                                    <?php endif; ?>
        <?php endif;?>

        <?php  if ($company->getFacebookUrl()): ?>
        <div class="place_item place_left_item place_vip_social_wrap">
            <?php include_partial('company/social_sidebar',array('facebook'=>$company->getFacebookUrl()));?>
        </div>
        <?php else:?>
          
          <?php include_partial('global/social', array('embed' => 'place', 'company' => $company, 'hasSocialScripts' => true, 'hasSocialHTML' => false  ))?>
        <?php endif;?>

        <!--
        <div class="place_item place_left_item tweets_module_wrap">
          <h3>Tweets</h3>
          <p>
            Ce piesa vestimentara sau accesoriu iti place cel mai mult, din cele filmate
            la iHeart Conceptstore?1. Vezi... <a href="#">http://fb.me/28EABl9cz</a>
          </p>
          <p>
            Dragi iubitori de Android, avem vesti bune pentru
            voi :) Am actualizat aplicatia getlokal de Android si
            am... <a href="#">http://fb.me/28EABl9cz</a>
          </p>
        </div>

         -->
         <?php if (count($articles)):?>
        <div class="place_item place_left_item article_module_wrap">
          <h3><?php echo __('Related Articles',null,'article')?></h3>
          <?php foreach ($articles as $article):?>
          <?php $secure = $sf_request->isSecure()? 'https://':'http://'?>
            <a href="<?php echo $secure.str_replace( getlokalPartner::getDomains(),$article->getArticleDomain(),$sf_request->getHost()).'/'.$article->getLangForCP().'/article/'.$article->getSlugForCP() ?>"><?php echo truncate_text( $article->getTitleForCP(), 50, '...', true) ;?></a>
          <?php endforeach;?>
        </div>
        <?php endif;?>
         <?php if (count($lists)):?>
        <div class="place_item_beige place_lists">
          <h3><?php echo __('Lists') ?></h3>
          <div class="list_scroll">
                <div class="scrollbar"><div class="track"><div class="thumb"></div></div></div>
                <div class="viewport">
              <ul class="overview">
                <?php foreach ($lists as $list):?>
                <li>

                  <a href="<?php echo url_for("list/show?id=".$list->getId())?>" title="<?php echo $list->getTitle();?>"  class="img_wrap">
                    <?php if ($list->getImageId()):
                      echo image_tag($list->getThumb(0),array('alt'=>$list->getTitle() ));
                        elseif ($list->getPlaces(true)):
                      $places = $list->getPlaces();
                      $places_count = $list->getPlaces(true);
                      $i = 1;
                      foreach ($places as $place):
                        if ($place->getImageId() || $i == $places_count - 1):
                          echo image_tag($place->getThumb(0),array( 'alt'=> $list->getTitle() ));
                          break;
                        endif;
                        $i++;
                      endforeach;
                    endif; ?>
                  </a>

                  <a href="<?php echo url_for("list/show?id=".$list->getId())?>" title="<?php echo $list->getTitle();?>"><?php echo $list->getTitle();?></a>
                  <p><?php echo __('by')?> <a href="<?php url_for('@user_page?username='.$list->UserProfile->sfGuardUser->getUserName()) ?>" title="<?php echo $list->UserProfile->getName()?>" class="category"><?php echo $list->UserProfile->getName()?></a></p>

                  <img alt="<?php echo $list->getIsOpen() ? 'unlocked' : 'locked'?>" title="<?php echo __($list->getIsOpen() ? 'Open' : 'Closed')?>" src="/images/gui/<?php echo $list->getIsOpen() ? 'unlocked' : 'locked'?>.png" />

                </li>
                <?php endforeach;?>
              </ul>
            </div>
          </div>
        </div>
        <?php else:?>
        <div class="place_item_beige place_lists" style="display:none">
        </div>
        <?php endif;?>
        <!--
        <div class="place_left_item">
          Related Places
        </div>

        <div class="place_item place_left_item">
          APP Link
        </div>
         -->
      </div>

      <div id="place_right" class="place_right">

        <div class="place_item">
          <div class="place_vip_description">
            <h3><?php echo __('About Us');?></h3>
            <span>
              <?php if($company->getCompanyDescription()): ?>
                <?php echo $company->getCompanyDescription(ESC_RAW) ?>
              <?php else:?>
                <?php echo sprintf(__('If you have been to %s in %s, leave your rating and review or photo to help other users searching in %s.', null, 'company'),$company->getCompanyTitle(), $company->City->getLocation(), $company->Classification);?>
                <?php echo sprintf(__('You can find %s at %s, telephone %s.', null, 'company'), $company->getCompanyTitle(), $company->getDisplayAddress(),$company->getPhoneFormated()); ?>
              <?php endif;?>

            </span>

            <?php if ($company->getCompanyContent()):?>
              <span class="extra_desc">
                <?php echo $company->getCompanyContent(ESC_RAW)?>
              </span>
              <a href="javascript:void(0)" class="show_desc" id="show_desc"><?php echo __('read more...'); ?></a>
              <a href="#" style="display: none;" id="hide_desc"><?php echo __('hide')?></a>
            <?php endif; ?>
            <div class="clear"></div>
             <ul class="feature_icons_wrapper">
             <?php foreach ($company->getFeatureCompany() as $ft):?>
                <?php $atl_tile=$company->getCompanyTitle().'-'.$ft->getName(); ?>
                <?php if($ft->getId()==7): ?>
                <li class="outdoor_seats">
                <div class="number"><p><?php echo $company->CompanyDetail->getOutdoorSeats();?></p></div>
                     <?php echo image_tag('gui/rupa_icons/icon-'.$ft->getId().'.png', array('atl'=>$atl_tile,'title'=>$atl_tile)) ?>
                </li>
                <?php elseif ($ft->getId()==8): ?>
                <li class="indoor_seats">
                <div class="number"><p><?php echo $company->CompanyDetail->getIndoorSeats();?></p></div>
                     <?php echo image_tag('gui/rupa_icons/icon-'.$ft->getId().'.png', array('atl'=>$atl_tile,'title'=>$atl_tile)) ?>
                </li>
                <?php elseif ($ft->getId()==9):?>
                <li class="wifi_option">
                <div class="number wifi"><p>
                    <?php if($company->CompanyDetail->getWifiAccess()==0): ?>
                        <?php echo 'Free'; ?>
                    <?php elseif($company->CompanyDetail->getWifiAccess()==1): ?>
                        <?php echo 'Paid';?>
                    <?php endif;?>
                </p></div>
                     <?php echo image_tag('gui/rupa_icons/icon-'.$ft->getId().'.png', array('atl'=>$atl_tile,'title'=>$atl_tile)) ?>
                </li>
                <?php else:?>
                <li>
                    <?php echo image_tag('gui/rupa_icons/icon-'.$ft->getId().'.png', array('atl'=>$atl_tile,'title'=>$atl_tile)) ?>
                </li>
                <?php endif; ?>

             <?php endforeach;?>

            </ul>

          </div>
        </div>

        <div class="place_item">
          <div class="place_user_action">
              <?php if (!$is_other_place_admin_logged && !$user_is_admin && !$user_is_company_admin ):?>
                <a href="javascript:void(0);" onClick="_gaq.push(['_trackEvent', 'Review', 'Write', 'company']);" class="button_pink button_big button_review"><?php echo __('Write a Review') ?></a>
              <?php endif;?>
              <?php if ($user_is_company_admin && !$user_is_admin):?>

                <div class="photo_dropdown_wrap">
                  <div class="link">
                    <a href="<?php echo url_for('companySettings/login?slug='. $company->getSlug().'&login=true') ?>" class="button_pink add_photo button_big button_add_photo"><?php echo __('Add a <br/>Photo', null, 'company') ?></a>

                  </div>
                  <div class="mask"></div>
                  <div class="add_photo_wrap" id="add_photo_wrap" style="display: none"></div>
                </div>
              <?php elseif(!$is_other_place_admin_logged):?>
              <div class="photo_dropdown_wrap">
                    <div class="link">
                        <a href="<?php echo url_for('company/addImage?id='. $company->getId()) ?>" class="button_pink add_photo button_big button_add_photo"><?php echo __('Add a <br/>Photo', null, 'company') ?></a>

                    </div>
                  <div class="mask"></div>
                  <div class="add_photo_wrap" id="add_photo_wrap" style="display: none"></div>

              </div>
              <?php endif;?>
              <?php if (!$is_other_place_admin_logged && !$user_is_admin && !$user_is_company_admin ):?>
              <div class="list_dropdown_wrap">
                                                            <div class="link">
                                                                            <a href="<?php echo url_for('company/addToList?id='. $company->getId()).'?type=ppp' ?>" class="button_pink add_list button_big button_add_list"><?php echo __('Add to <br/>List',null,'list')?></a>
                                                                    </div>
                                                            <div class="mask"></div>
                                                            <div class="add_list_wrap" id="add_list_wrap" style="display: none">
                                                                    <a id="list_form_close" href="#"><img src="/images/gui/close_small.png" /></a>
                                                                    <?php /*if ($user):?>
                                                                                    <?php include_partial('list/form_for_company',array('form'=>$list_form, 'template'=>'ppp', 'page_id'=>$company->getCompanyPage()->getId() ));?>
                                                                            <?php else :?>
                                                                                    <?php ?>
                                                                            <?php endif;*/?>
                                                            </div>
                        </div>
              <?php endif;?>
            <div class="clear"></div>
            <?php if($sf_user->hasFlash('noticeImg')): ?>
                                                <?php if ($is_other_place_admin_logged || $user_is_admin || $user_is_company_admin ):?>
                                                <div class="report_success2" style="margin: 5px 0 0 0px">
                                                      <?php echo __($sf_user->getFlash('noticeImg')) ?>
                                                </div>
                                                <?php else:?>
                                                <div class="report_success2" style="margin: 5px 0 0 154px">
                                                      <?php echo __($sf_user->getFlash('noticeImg')) ?>
                                                </div>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                                <div class="report_success1" style="margin: 5px 0 0 308px; display: none;">
                                                    <?php //echo __($sf_user->getFlash('noticeImg')) ?>
                                                    <?php echo __( 'This place was successfully added to the list!',null,'company') ?>
                                                </div>
          </div>
        </div>


 <?php if ($offers): ?>
                <div class="offer_set_listing premium_place_page">
                    <?php $offers_count = count($offers); ?>
                    <div class="offer_module_wrap">
                        <h3><?php echo __('Current Offers', null, 'offer') ?></h3>
                        <div class="carousel_wrapper">
                            <div class="carousel_content" style="">
                                <ul>
                                    <?php foreach($offers as $offer):?>
                                        <li>
                                            <?php $culture = $sf_user->getCulture(); ?>
                                          <div class="offer_image">
                                                <?php if ($offer->getImageId()): ?>
                                                  <?php echo link_to(image_tag($offer->getImage()->getThumb(), 'size=150x150 alt=' . $offer->getDisplayTitle() . ' title=' . $offer->getDisplayTitle()), 'offer/show?id=' . $offer->getId()) ?>
                                                <?php else : ?>
                                                  <?php echo link_to(image_tag('gui/default_place_150x150.png', 'size=150x150 alt=' . $offer->getDisplayTitle() . ' title=' . $offer->getDisplayTitle()), 'offer/show?id=' . $offer->getId()); ?>
                                                <?php endif; ?>
                                           </div>
                                           <div class="offer_details">
                                                <h4><?php echo link_to((mb_strlen($offer->getDisplayTitle(), 'UTF8') <= 100 )?$offer->getDisplayTitle():mb_substr($offer->getDisplayTitle(), 0, 100, 'UTF8').'...', 'offer/show?id=' . $offer->getId()); ?></h4>

                                                <?php // echo (mb_strlen($offers->getContent(ESC_RAW), 'UTF8') <= 40 )? $offers->getContent(ESC_RAW) : mb_substr($offers->getContent(ESC_RAW), 0, 40, 'UTF8').'...'; ?>

                                                <?php echo link_to(__('Get Voucher!', null, 'offer'), 'offer/show?id=' . $offer->getId(), 'class=button_pink pp_offer'); ?>
                                           </div>
                                        </li>
                                    <?php endforeach;?>
                                </ul>
                                <div class="clear"></div>


                            </div>
                             <?php if ($offers_count > 1): ?>
                                    <div class="carousel_dots">
                                        <?php for ($i = 1; $i <= $offers_count; $i++): ?>
                                            <div class="carousel_dot"></div>
                                        <?php endfor; ?>
                                    </div>
                                <?php endif; ?>
                            <a id="show_offers" class="right" href="#" onclick="getAllOffers(); return false;" title="<?php echo __('see more')?>"><?php echo __('see more')?></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>


                                <?php if (isset($events) && count($events)) : ?>
                                    <div class="place_item">
                                        <div class="event_module_wrap">
                                            <h3><?php echo __('Events')?></h3>

                                            <ul>
                                                <?php foreach ($events as $event):?>
                                                <li>
                                                    <?php /*?>
                                                    <div class="pink_link_wrap">
                                                    <?php echo link_to(__('more info'),'event/show?id='.$event->getId(), array('class'=>'button_pink'));?>
                                                    </div>
                                                    */ ?>

                                                    <?php
                                                        if ($event->getImage()->getType()=='poster' ):
                                                            echo link_to(image_tag($event->getThumb('preview'),array('size'=>'101x135', 'title'=>$event->getDisplayTitle())), 'event/show?id='.$event->getId());
                                                        else :
                                                            echo link_to(image_tag($event->getThumb(2), array( 'size'=>'180x135', 'title'=>$event->getDisplayTitle() ) ), 'event/show?id='.$event->getId());
                                                        endif;
                                                    ?>

                                                    <?php echo link_to($event->getDisplayTitle(),'event/show?id='.$event->getId()); ?>

                                                    <span><?php echo  $event->getDateTimeObject('start_at')->format('d/m/Y') ?></span>

                                                    <?php echo link_to($event->getCategory(),'event/index?category_id='. $event->getCategoryId(), array('class' => "category")) ?>
                                                </li>
                                                <?php endforeach;?>
                                            </ul>

                                            <a class="right" href="#" onclick="getAllEvents(false); return false;" title="<?php echo __('see more')?>"><?php echo __('see more')?></a>
                                        </div>
                                    </div>
                                <?php endif;?>


                                <!-- Statuses -->
                                <div id="status_wrap" class="place_item">
                                    <?php use_helper('Date'); ?>
                                    <?php use_helper('TimeStamps'); ?>

                                    <div class="status_module_wrap">
                                        <div class="listOfStatuses">
                                            <h2><?php echo __('Status updates', null, 'status')?></h2>

                                            <div>
                                                <div class="company_status">
                                                    <?php if ($company->getLogoImageId()) : ?>
                                                        <div class="place_left_item place_logo_item">
                                                            <?php echo image_tag($company->getLogoImage()->getThumb(0), array('alt'=>($company->getLogoImage()->getCaption()? $company->getLogoImage()->getCaption() : $company->getCompanyTitle())));?>
                                                        </div>
                                                    <?php endif;?>

                                                    <p><?php echo $company->getCompanyTitle(); ?> <span><?php echo __('shared', null, 'status') ?></span></p>

                                                </div>
                                            </div>
                                        </div>

                                        <?php if (($user_is_admin && $user_is_company_admin) || $sf_user->isGetlokalAdmin()): ?>
                                            <!-- Errors and successes -->
                                            <p id="status_update_msg"></p>

                                            <form action="?" method="post" id="postStatus">
                                                  <div class="form_box input_box">
                                                      <label for="post_status_text"></label>
                                                      <textarea id="post_status_text" name="message"></textarea>
                          </div>

                          <div class="status_selection">
                                                      <div class="status_selection_tabs">
                                                        <p><?php echo __('Choose to link your Events or Offers', null, 'status'); ?></p>
                                                          <div class="status_tab">
                                                            <label for="events"><?php echo __('Events', null, 'status') ?></label>
                                                            <input id="events" type="radio" name="statusAttachment" value="events" />
                                                          </div>
                                                          <div class="status_tab status_tab2">
                                                            <label for="offers"><?php echo __('Offers', null, 'status') ?></label>
                                                            <input id="offers" type="radio" name="statusAttachment" value="offers" />
                                                          </div>
                                                          <div class="clear"></div>
                                                        </div>
                                                        <div class="status_selection_content">
                                                          <div class="statusEvents" style="display: none">
                                                              <input type="hidden" value="" name="eventId" />
                                                              <input type="text" name="eventsAutocomplete" value="" placeholder="<?php echo __('Please, type event name here...', null, 'status') ?>" />
                                                                    <div class="loader"><img src="/images/gui/loading.gif"/></div>
                                                                    <div class="status_event_scroll">
                                                                        <div class="scrollbar"><div class="track"><div class="thumb"></div></div></div>
                                                                        <div class="viewport">
                                                                            <div class="autocompleteEventsList overview"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="autocompleteEventsResult"></div>

                                                          </div>
                                                          <div class="statusOffers" style="display: none">
                                                              <?php if (isset($offers) && count($offers)) : ?>
                                                                  <select name="statusOffers">
                                                                      <option value="0"><?php echo __('Choose your Offer', null, 'status') ?></option>
                                                                      <?php foreach ($offers as $offer) : ?>
                                                                          <option value="<?php echo $offer->getId() ?>"><?php echo $offer->getTitle(); ?></option>
                                                                      <?php endforeach; ?>
                                                                  </select>
                                                              <?php else : ?>
                                                                  <?php echo __('Offers list is empty!', null, 'status') ?>
                                                              <?php endif; ?>
                                                          </div>
                                                        </div>

                                                    </div>
                                                <div class="form_interaction">
                                                    <div class="left">
                                                        <?php
                                                            $postToFacebook = $sf_user->getFlash('postToFacebook');
                                                            $postToTwitter = $sf_user->getFlash('postToTwitter');
                                                            $postToGoogle = $sf_user->getFlash('postToGoogle');
                                                        ?>

                                                        <input type="checkbox" id="fb_share_ico" name="shareWith[]" value="fb" <?php echo ($postToFacebook) ? 'checked="checked"' : '' ?> />
                                                        <?php /* for a moment
                                                        <input type="checkbox" id="t_share_ico" name="shareWith[]" value="tw" <?php echo ($postToTwitter) ? 'checked="checked"' : '' ?> />
                                                        <input type="checkbox" id="g_share_ico" name="shareWith[]" value="g+" <?php echo ($postToGoogle) ? 'checked="checked"' : '' ?> />
                                                         */ ?>

                                                        <a href="javascript:;" title="Facebook" class="fb_share_ico <?php echo ($postToFacebook) ? 'current' : '' ?>"></a>

                                                        <?php /* for a moment
                                                        <a href="javascript:;" title="Twitter" class="t_share_ico <?php echo ($postToTwitter) ? 'current' : '' ?>"></a>
                                                        <a href="javascript:;" title="G+" class="g_share_ico <?php echo ($postToGoogle) ? 'current' : '' ?>"></a>
                                                        <p class="helpText"><?php echo __('You can link your <strong>Facebook</strong>, <strong>Twitter</strong> and <strong>Google+</strong> accounts too.', null, 'status') ?></p>
                                                         */ ?>


                                                        <?php // comment this after... ?>
                                                        <?php /*<p class="helpText"><?php echo __('You can link your <strong>Facebook</strong> account.', null, 'status') ?></p>*/ ?>

                                                        <?php if (!isset($hasFbStatuses) || !$hasFbStatuses) : ?>
                                                            <p class="helpText"><?php echo __('Link now your <strong>Facebook</strong> page with getlokal.', null, 'status') ?></p>
                                                        <?php else : ?>
                                                            <p class="helpText"><?php echo __('Broadcast this on your <strong>Facebook</strong> page.', null, 'status') ?></p>
                                                        <?php endif; ?>
                                                    </div>
                                                    <input type="submit" value="<?php echo __('Post', null, 'status') ?>" class="button_pink right" />

                                                    <div class="pagesSelect left" style="display: none">
                                                        <select name="fbPages" id="pages">
                                                        </select>
                                                    </div>

                                                    <div class="clear"></div>

                                                    <div id="additinalStatusText" style="font-size: 12px; display: none"><?php echo __('This update will also be posted on your Facebook page', null, 'status') ?></div>

                                                    <div class="clear"></div>
                                                </div>
                                            </form>
                                        <?php endif; ?>
                                    </div>
        </div>
                                <!-- End statuses -->


        <div class="place_item"  id="reviews">
          <div class="standard_tabs_in">
            <?php echo $sf_data->getRaw('sf_content'); ?>
          </div>
        </div>
      </div>
      <div class="clear"></div>
    </div>
  </div>
</div>
<div class="clear"></div>




<script type="text/javascript">
     if($(".message_wrap").is(":visible")){ $('html, body').animate({
         scrollTop: $(".message_wrap").offset().top-300
     }, 2000);}
     $(function() {
         $(".page_wrap").css('paddingTop', '0');
         <?php if (isset($offers_count) && $offers_count > 1): ?>
            var pause = false;
            var max = $('.carousel_content li').length -1;
            var _x = -1;
            var _f = 0;

            var change = function() {
                $('.carousel_dots .carousel_dot').removeClass('active');
                $('.carousel_dots .carousel_dot:nth-child('+ (_x + 1) +')').addClass('active');

                $('.carousel_content ul li').animate({opacity:0.3}, 200, function() {
                    $(this).css('display', 'none');
                    $('.carousel_content ul li:nth-child('+ ((max-_x) + 1) +')').css('display', 'block');
                    $('.carousel_content ul li:nth-child('+ ((max-_x) + 1) +')').animate({opacity:1}, 200);
                });

                _f = 0;
            };

            var next = function() {
                _x++;
                if(_x > max) _x = 0;
                change();
            };

            $('.carousel_dots .carousel_dot').click(function() {
                var index = $(this).parent().children().index(this);
                if(_x != index)
                {
                    _x = index;
                    change();
                }

                return false;
            });

            $('.carousel_wrapper').hover(function() {
                pause = true;
            }, function() {
                pause = false;
            });

            setInterval(function() {
                if(pause) return;
                _f++;
                if(_f>10) {
                    next();
                }
            }, 1000);

            next();
<?php endif; ?>

        // Load Statuses
        getStatuses();
        <?php if (($user_is_admin && $user_is_company_admin) || $sf_user->isGetlokalAdmin()): ?>
          $('input[name="statusAttachment"]').change('live', function() {
             $('.loader').hide();
                $('.status_selection_content').show();
                $('select[name="statusOffers"]').val('0');
                $('input[name="eventId"]').val('');
                $('input[name="eventsAutocomplete"]').val('');
                $('.autocompleteEventsResult').html('');
                $('.autocompleteEventsList').hide();
                $('.autocompleteEventsList').html('');
                $('.status_selection_tabs .status_tab').removeClass('current').removeClass('current2');
                if ($(this).val() == 'events') {
                    $('.statusEvents').show();
                    $('.statusOffers').hide();
                    $(this).parent().parent().addClass('current');
                }
                else {
                    $('.statusEvents').hide();
                    $('.statusOffers').show();
                    $(this).parent().parent().addClass('current2');
                }
                 });

            // Events autocomplete
            $('input[name="eventsAutocomplete"]').keyup('live', function() {

                $('.autocompleteEventsList').hide();

                var value = $(this).val();

                if (value.length > 3) {
                    $('.loader').show();

                    $('.autocompleteEventsList').show(300);

                    $.post("<?php echo url_for('company/getEventsAutocomplete') ?>", { 'keyword': value },
                        function(response){
                            $('.loader').hide();
                            $('.autocompleteEventsList').html(response);
                            $('.status_event_scroll').show();
                            $('.status_event_scroll').tinyscrollbar({size:180});
                        }
                    );
                }
            });

            $('body').bind('click', function(e) {
              if($(e.target).closest('.header_user_content').length == 0) {
                //$('.status_selection_tabs .status_tab').removeClass('current').removeClass('current2');
                //$('.status_selection_content').hide();
                //$('.ez-selected').removeClass('ez-selected');
              }
            });

            // Status button click
            $('.status_module_wrap .form_interaction .left a').click('live', function() {
                if ($(this).hasClass('current')) {
                    $('#additinalStatusText').hide();
                    $(this).removeClass('current');
                    $('#' + $(this).attr('class')).removeAttr('checked');
                }
                else {
                    $('#additinalStatusText').show();
                    $('#' + $(this).attr('class')).attr('checked', 'checked');
                    $(this).addClass('current');
                }

                // Reset all html divs
                clearAllAfterSendPost(false);


                var shareWith = $("input[name='shareWith[]']:checked");
                var shareArr = new Array();

                $.each(shareWith, function() {
                    if ($(this).val() == 'fb') {
                        FB.getLoginStatus(function(response) {
                            if (response.status !== 'connected') {
                                FB.login(function(response) {
                                    // Retrieve pages
                                    FB.api('/me/accounts', function(response) {
                                        $.each(response.data, function(index, object) {
                                            $('.pagesSelect select[name=fbPages]').append('<option value="' + object.id + '">' + object.name + '</option>');
                                        });

                                        if (response.data && response.data.length) {
                                            $('.pagesSelect').slideDown(160);
                                        }
                                        else {
                                            // Logout user
                                            FB.logout(function(response) {});

                                            // Try to login
                                            //FB.login(function(response) {}, {scope: 'user_location,email,user_birthday,offline_access,user_checkins,manage_pages,publish_stream'});
                                        }
                                    });
                                }, {scope: 'user_location,email,user_birthday,offline_access,user_checkins,manage_pages,publish_stream'});
                            }
                            else {
                                <?php
                                //
                                //FB.api('/me', function(response) {
                                //    console.log(response);
                                //});
                                //
                                //var token = response.authResponse.accessToken;
                                //var request = response.authResponse.signedRequest;
                                //
                                ?>

                                // Retrieve pages
                                FB.api('/me/accounts', function(response) {
                                    //console.log(response.data);

                                    $.each(response.data, function(index, object) {
                                        $('.pagesSelect select[name=fbPages]').append('<option value="' + object.id + '">' + object.name + '</option>');
                                    });

                                    if (response.data.length) {
                                        $('.pagesSelect').slideDown(160);
                                    }
                                    else {
                                       // Logout user
                                        FB.logout(function(response) {});

                                        // Try to login
                                        //FB.login(function(response) {}, {scope: 'user_location,email,user_birthday,offline_access,user_checkins,manage_pages,publish_stream'});
                                    }
                                });
                            }
                        });
                    }

                    shareArr.push($(this).val());
                });

                var textLeft = "<?php echo format_number_choice('[0]You can link your|[1]You can link your', null, 0, 'status') ?>";
                var textRight = "<?php echo __('accounts too.', null, 'status') ?> ";

                var textLeftSp = "<?php echo format_number_choice('[0]You can link your|[1]You can link your', null, 1, 'status') ?>";
                var textRightSp = "<?php echo __('account too.', null, 'status') ?> ";
                var text = '';

<?php /* for a moment
                if ($.inArray('fb', shareArr) != -1 && $.inArray('tw', shareArr) != -1 && $.inArray('g+', shareArr) != -1) {
                    $('p.helpText').html('');
                }
                else if ($.inArray('fb', shareArr) == -1 && $.inArray('tw', shareArr) == -1 && $.inArray('g+', shareArr) == -1) {
                    $('p.helpText').html(textLeft + ' ' + '<strong>Facebook</strong>, <strong>Twitter</strong> ' + "<?php echo __('and', null, 'status') ?>" + ' <strong>Google+</strong>' + ' ' + textRight);
                }
                else {
                    var count = 0;

                    if (jQuery.inArray("fb", shareArr) == -1) {
                        count++;

                        text += '<strong>Facebook</strong>';
                    }

                    if ($.inArray('tw', shareArr) == -1) {
                        count++;

                        if (count > 1) {
                            text += ' ' + "<?php echo __('and', null, 'status') ?>" + ' ';
                        }

                        text += '<strong>Twitter</strong>';
                    }

                    if ($.inArray('g+', shareArr) == -1) {
                        count++;

                        if (count > 1) {
                            text += ' ' + "<?php echo __('and', null, 'status') ?>" + ' ';
                        }

                        text += '<strong>Google+</strong>';
                    }

                    if (count > 1) {
                        $('p.helpText').html(textLeft + ' ' + text + ' ' + textRight);
                    }
                    else {
                        $('p.helpText').html(textLeftSp + ' ' + text + ' ' + textRightSp);
                    }
                }
*/ ?>



                <?php // comment this after... ?>
                if ($.inArray('fb', shareArr) != -1) {
                    $('p.helpText').html('');
                }
                else if ($.inArray('fb', shareArr) == -1) {
                    <?php /*$('p.helpText').html("<?php echo __('You can link your <strong>Facebook</strong> account.', null, 'status') ?>");*/ ?>

                    <?php if (!isset($hasFbStatuses) || !$hasFbStatuses) : ?>
                        $('p.helpText').html("<?php echo __('Link now your <strong>Facebook</strong> page with getlokal.', null, 'status') ?>");
                    <?php else : ?>
                        $('p.helpText').html("<?php echo __('Broadcast this on your <strong>Facebook</strong> page.', null, 'status') ?>");
                    <?php endif; ?>
                }



                //return false;
            });

            // Post a status
            $('form#postStatus').submit(function() {
                var shareWith = $("input[name='shareWith[]']:checked");
                var shareArr = new Array();

                $.each(shareWith, function() {
                    if ($(this).val() == 'fb' && $('form#postStatus select[name=fbPages]').val() && $('form#postStatus textarea[name=message]').val()) {
                        sendPostToFacebookWall($('form#postStatus select[name=fbPages]').val(), $('form#postStatus textarea[name=message]').val());
                    }

                    shareArr.push($(this).val());
                });

                if ($('form#postStatus textarea[name=message]').val()) {
                    savePost($('form#postStatus textarea[name=message]').val(), shareArr);
                }

                clearAllAfterSendPost(true);

                return false;
            });
        <?php endif; ?>
    });

    // FB Init
    window.fbAsyncInit = function() {
        FB.init({
                appId: '289748011093022',
                status: true,
                cookie: true,
                oauth: true,

                xfbml: true,
                frictionlessRequests: true
        });
    };

    // Return statuses
    function getStatuses() {
        $.post("<?php echo url_for('company/getListOfCompanyStatuses?slug=' . $company->getSlug() . '&city=' . $company->City->getSlug(), array(), true) ?>", {},
            function(data){
                if ($.trim(data)) {
                    $('.listOfStatuses .status_scroll').remove();
                    $('.listOfStatuses').append(data);
                    $('.listOfStatuses').show();

                  if ($('.status_scroll .viewport ul li').length > 4) {
                    $('.status_scroll').tinyscrollbar({size:248});
                  }
                  else {
                    $('.status_scroll .viewport').css({height:'auto'});
                    $('.status_scroll .overview').css({position:'static'});
                    $('.status_scroll .overview li').css('width', '574px');
                    $('.status_scroll .scrollbar').remove();
                  }
                }
                else {
                  <?php if (($user_is_admin && $user_is_company_admin) || $sf_user->isGetlokalAdmin()): ?>
                      $('.listOfStatuses').hide();
                        <?php else: ?>
                            $('#status_wrap').remove();
                  <?php endif;?>
                }
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

    <?php if (($user_is_admin && $user_is_company_admin) || $sf_user->isGetlokalAdmin()): ?>
        // pageId - must be 'me' or real page id
        function sendPostToFacebookWall(pageId, message, caption) {
            var offerId = $('select[name="statusOffers"]').val();
            var eventId = $('input[name="eventId"]').val();
            var link = '';

            if (eventId) {
                eventId = eventId.split('_');
                eventId = eventId.pop();

                if (eventId > 0) {
                    link = '<?php echo url_for('default', array('module' => 'event', 'action' => 'show'), true) ?>/id/' + eventId;
                }
            }
            else if (offerId && offerId > 0) {
                link = '<?php echo url_for('default', array('module' => 'offer', 'action' => 'show'), true) ?>/id/' + offerId;
            }

            if (link && link.length > 0) {
                FB.api('/' + pageId + '/feed', 'post', { message: message, caption: caption, link: link }, function(response) {
                    if (!response || response.error) {
                        // Error
                    } else {
                        // Success, post id: response.id
                    }
                });
            }
            else {
                FB.api('/' + pageId + '/feed', 'post', { message: message, caption: caption }, function(response) {
                    if (!response || response.error) {
                        // Error
                    } else {
                        // Success, post id: response.id
                    }
                });
            }
        }

        // Clear data and form fields after post action
        function clearAllAfterSendPost(resetAll) {
            if (resetAll) {
                $('textarea[name=message]').val('');
                $('.pagesSelect').hide();
                $('.pagesSelect select[name=fbPages]').html("");

                <?php /*
                    $('p.helpText').html("<?php echo __('You can link your <strong>Facebook</strong>, <strong>Twitter</strong> and <strong>Google+</strong> accounts too.', null, 'status') ?>");
                */?>

                <?php /*$('p.helpText').html("<?php echo __('You can link your <strong>Facebook</strong> account.', null, 'status') ?>");*/ ?>

                <?php if (!isset($hasFbStatuses) || !$hasFbStatuses) : ?>
                    $('p.helpText').html("<?php echo __('Link now your <strong>Facebook</strong> page with getlokal.', null, 'status') ?>");
                <?php else : ?>
                    $('p.helpText').html("<?php echo __('Broadcast this on your <strong>Facebook</strong> page.', null, 'status') ?>");
                <?php endif; ?>

                var shareWith = $("input[name='shareWith[]']:checked");

                $.each(shareWith, function() {
                    $(this).attr('checked', false);
                });


                var selectedHrefs = $('.status_module_wrap .form_interaction .left a.current');
                $.each(selectedHrefs, function() {
                    $(this).removeClass('current');
                });


                $('.statusEvents').hide();
                $('.statusOffers').hide();

                $('select[name="statusOffers"]').val('0');
                $('input[name="eventId"]').val('');
                $('input[name="eventsAutocomplete"]').val('');
                $('.autocompleteEventsResult').html('');
                $('.autocompleteEventsList').hide();
                $('.autocompleteEventsList').html('');

                $('input[name=statusAttachment]:checked').parent().removeClass('ez-selected');
                $('input[name=statusAttachment]').removeAttr('checked');
            }
            else {
                $('.pagesSelect').hide();
                $('.pagesSelect select[name=fbPages]').html("");
            }
        }

        function savePost(message, shareArr) {
            var event = offer = null;

            event = $('input[name=eventId]').val();
            offer = $('select[name="statusOffers"]').val();

            $.post("<?php echo url_for('company/saveCompanyStatus?slug=' . $company->getSlug() . '&city=' . $company->City->getSlug(), array(), true) ?>", { "save": true, "message": message, "publishTo": shareArr, "eventId": event, "offerId": offer },
                function(data){
                    if (data.error != undefined && data.error) {
                        $("#status_update_msg").html("<?php echo __('Your status can`t be saved!', null, 'status') ?>");
                        $("#status_update_msg").removeAttr('class').addClass('flash_error');
                    }
                    else if (data.success != undefined && data.success) {
                        $("#status_update_msg").html("<?php echo __('Your status was published successfully!', null, 'status') ?>");
                        $("#status_update_msg").removeAttr('class').addClass('flash_success');

                        getStatuses();
                    }
                },
                "json"
            );
        }
    <?php endif; ?>

    <?php /* See company/templates/customEventSuccess */ ?>
    // Type must be a true for 'past' or false for incoming
    function getAllEvents(type, nocheck) {
        if (!$('#show_events').hasClass('current') || nocheck) {
                $.post("<?php echo url_for('company/events?slug=' . $company->getSlug() . '&city=' . $company->City->getSlug(), array(), true) ?>", { "past": type, "template": 'customEvent', 'ppp': true },
                    function(data){
                        if ($.trim(data)) {
                            $('.place_content').html(data);
                            $('.place_navigation_bar a').removeClass('current');
                            $('#show_events').addClass('current');
                            var top = 356;
                            $('html,body').animate({scrollTop: top}, 0);
                        }
                    }
                );
        }
    }

    function getAllOffers() {
            if (!$('#show_offers').hasClass('current')) {
                $.post("<?php echo url_for('company/showAllOffers?slug=' . $company->getSlug() . '&city=' . $company->City->getSlug(), array(), true) ?>", { "template": 'customOffer' },
                    function(data){
                        if ($.trim(data)) {
                            $('.place_content').html(data);
                            $('.place_navigation_bar a').removeClass('current');
                            $('#show_offers').addClass('current');
                            var top = 356;
                                    $('html,body').animate({scrollTop: top}, 0);
                        }
                    }
                );
            }
    }
	
		function getReservationForm() {
		  $.ajax({
			  type: "GET",
			  url: "<?php echo url_for('company/reservation?slug=' . $company->getSlug(), array(), true) ?>",
	//            dataType: 'json',
        beforeSend: function(data) {
        document.getElementById("loading-overlay").style.display="block";
                }, 
			  success: function(data) {
        document.getElementById("loading-overlay").style.display="none";
			  if ($.trim(data)) {
				$('.place_content').html(data);
				$('.place_navigation_bar a').removeClass('current');
				$('#show_reservation_form').addClass('current');
				var top = 356;
					$('html,body').animate({scrollTop: top}, 0);
			  }
				  

			  }
			});
		  return false;
  }
</script>


<script type="text/javascript">
$(function() {
  $('.main_menu_wrap').addClass('main_menu_mini main_menu_static');
  $('.menu_link_wrap').css('display', 'none');
  $('.extra_number').toggle();
  $('.social_share_wrap').after($('.path_wrap'));
 // $('.path_wrap').prepend($('.place_badge'));
  $('.path_wrap').addClass('path_wrap_vip');

  $('#contact_form form').live('submit', function(event) {
    event.preventDefault();
      $.ajax({
          type: "POST",
          url: $(this).attr('action'),
            data: $(this).serialize() + '&getFlashOnly=true',
            dataType: 'json',
          success: function(data) {
            //$('#contact_form').html(data);

              if (data.success == true) {
                  $('a#email_form_close').click();
                  $(".report_success").html(data.html);
                  $(".report_success").css('display', 'inline-block');
              }
              else {
                  $('#contact_form').html(data.html);
                  $(".report_success").html("");
                  $(".report_success").css('display', 'hidden');
              }
          }
        });
      return false;
  });

  function formatTitle(title, currentArray, currentIndex, currentOpts) {
    var link = currentArray[currentIndex]['rev'];
    var name = currentArray[currentIndex]['name'];
      return '<?php if($company->Image->UserProfile->getIsCompanyAdmin($company)):?><div class="picture_title" style="position:relative;padding-left:45px;"><img style="position:absolute;top:-15px;left:0px" src="/images/gui/bg_official_big.png" /><?php endif;?><span class="right">' + (currentIndex + 1) + '/' + currentArray.length + '</span>' + (title && title.length ? '<p>'+title+'</p>' : '' ) + '<p>' + "<?php echo __('by')?>" + ' <a href="'+ link + '">' + name + '</a></p>' + '<div class="clear"></div></div>';
  }

  $('.grouped_elements').fancybox({
    'cyclic'      : true,
    'titlePosition'   : 'inside',
    'overlayColor'    : '#000',
    'overlayOpacity'  : 0.6,
    'margin'      : 0,
    'titleFormat'   : formatTitle,
    'index'   : true
  });

  <?php if (count($videos) > 1):?>
    $('#prev_video').click(function() {
      return;
    });
    $('#next_video').click(function() {
      return;
    });
  <?php endif;?>

  <?php $max_img_count = 21; ?>
  <?php $extra_img = 0; ?>
  <?php if ($company->getImageId()):?>
    <?php $extra_img = 1; ?>
  <?php endif;?>

  <?php if (count($images) > $max_img_count - $extra_img ):?>
    var img_cnt = '<?php echo count($images) + $extra_img; ?>';
    var img_width = 139;
    var viewWidth = 975;

    $('.photo_gallery_content').width(img_width * (parseInt(img_cnt / 3) + 1));
    $('.photo_gallery_content').append('<img class="leftScrollWrap" src="/images/gui/gallery_arrow_left.png" />'+
                      '<img id="left_arrow" src="/images/gui/arrow_left_big.png" />' +
                        '<img class="rightScrollWrap" src="/images/gui/gallery_arrow_right.png" />' +
                        '<img id="right_arrow" src="/images/gui/arrow_right_big.png" />');
    $('.photo_gallery_content').mouseenter(function() {
      $(".leftScrollWrap").fadeIn(100);
      $(".rightScrollWrap").fadeIn(100);
      $("#left_arrow").fadeIn(100);
      $("#right_arrow").fadeIn(100);
    });

    $('.photo_gallery_content').mouseleave(function() {
      $(".leftScrollWrap").fadeOut(100);
      $(".rightScrollWrap").fadeOut(100);
      $("#left_arrow").fadeOut(100);
      $("#right_arrow").fadeOut(100);
    });

    var index = 0;
    var speed = 300;

    var hovered_elem = null;

    $('#left_arrow').live('click', function() {
      //var step = -speed*(parseInt($('.photo_gallery_content').css('marginLeft')))/(parseInt($('.photo_gallery_content').css('width'))-viewWidth);
      MoveLeft($(this), speed);
    });

    $('#right_arrow').live('click', function() {
      //var step = speed+speed*(parseInt($('.photo_gallery_content').css('marginLeft')))/(parseInt($('.photo_gallery_content').css('width'))-viewWidth);//speed + parseInt($('.photo_gallery_content').css('marginLeft'))*speed / img_width;
      MoveRight();
    });

    $('.photo_gallery').live('mousemove', function(e) {
      $('.grouped_elements').each(function() {
        if (hovered_elem != null)
        {
          if (!CheckHovered(hovered_elem, e)) {
            hovered_elem = null;
          }
        }
        if (CheckHoverState($(this), e) && (hovered_elem == null)) {
          $(this).addClass('hovered');
          $(this).next().addClass('hovered');
          hovered_elem = $(this);
        }
        else if (!$(this).is(hovered_elem)) {
          $(this).removeClass('hovered');
          $(this).next().removeClass('hovered');
        }
      });
    });
    function MoveRight() {
      $('.photo_gallery_content').animate({'margin-left': Math.max(-(-parseInt($('.photo_gallery_content').css('marginLeft')) + img_width), -($('.photo_gallery_content').outerWidth() - viewWidth))}, speed, function() {

      });
      $('.grouped_elements').animate({'margin-left': Math.max(-(-parseInt($('.photo_gallery_content').css('marginLeft')) + img_width), -($('.photo_gallery_content').outerWidth() - viewWidth))}, speed, function() {

      });
    }

    function MoveLeft(container, speed) {
      $('.photo_gallery_content').animate({'margin-left': Math.min(-(-parseInt($('.photo_gallery_content').css('marginLeft')) - img_width), 0)}, speed, function() {

      });
      $('.grouped_elements').animate({'margin-left': Math.min(-(-parseInt($('.photo_gallery_content').css('marginLeft')) - img_width), 0)}, speed, function() {

      });
    }

    function CheckHoverState(elem,e) {
        var elemWidth = $(elem).width();
        var elemHeight = $(elem).height();
        var elemPosition = $(elem).offset();
        var elemPosition2 = new Object;
        elemPosition2.top = elemPosition.top + elemHeight;
        elemPosition2.left = elemPosition.left + elemWidth;
        if ((e.pageX > elemPosition.left && e.pageX < elemPosition2.left) && (e.pageY > elemPosition.top && e.pageY < elemPosition2.top)) {
        return true;
        }
        else {
          return false;
        }
    }

    function CheckHovered(elem,e) {
        var elemWidth = $(elem).width();
        var elemHeight = $(elem).height();
        var elemPosition = $(elem).offset();
        var elemPosition2 = new Object;
        var elemTopCoord = 0;
        elemPosition2.top = elemPosition.top + elemHeight;
        elemPosition2.left = elemPosition.left + elemWidth;

        if (elem.hasClass('grouped_elements_bottom'))
          elemPosition.top -= 36
      else
        elemPosition2.top += 36

        if ((e.pageX > elemPosition.left && e.pageX < elemPosition2.left) && (e.pageY > elemPosition.top && e.pageY < elemPosition2.top)) {
        return true;
        }
        else {
          return false;
        }
    }
  <?php else:?>
    $('.photo_gallery_content').width($('.photo_gallery_content img').outerWidth() * 7);
    $('.grouped_elements').live('mouseenter', function() {
      $('.image_desc').removeClass('hovered')
      $('.grouped_elements').removeClass('hovered');
      $(this).addClass('hovered');
      $(this).next().addClass('hovered');
    });

    $('.photo_gallery_content').mouseleave(function() {
      $('.image_desc').removeClass('hovered')
      $('.grouped_elements').removeClass('hovered');
    });

  <?php endif;?>

    var y = 0;
    var x = 0;
    var max_el = $('.photo_gallery_content').width()/$('.image_desc').width();
    $('.image_desc').each(function(index, val) {

      $(this).prev().css({top: ($(this).height() * y),
                left: ($(this).width() * x)});
      x = x + 1;

      if (x == max_el) {
        x = 0;
        y = y+1;
      }

      if (y == 2 && x > 0) {
        $(this).prev().addClass('grouped_elements_bottom');
        $(this).addClass('image_desc_bottom');
      }
    });

  $('.email_form_wrap .mask').css('width', $('.email_form_wrap .link').outerWidth());
  $('a#send_mail_company').click(function(event) {
    if ($('.email_form_wrap').hasClass('email_form_wrap_opened'))
      $('.email_form_wrap').removeClass('email_form_wrap_opened');
    else {
      $('.email_form_wrap').addClass('email_form_wrap_opened');

        $.ajax({
        url: this.href,
                dataType: 'json',
        beforeSend: function( ) {
                    $(".report_success").html("");
                    $(".report_success").css('display', 'hidden');
                    $(".embedding .box").css('display', 'none');
          $('#contact_form').html('<div style="text-align:center;margin:0px;width:'+ $('.email_form_wrap .link').width() + 'px' +'"><img src="/images/gui/blue_loader.gif"/></div>');
          },                                                                                                        
        success: function( data ) {
          $("#contact_form").html(data.html);
        }
      });
    }
    return false;
    });

  var cur_height = $('#place_contact_links').height();
  $('#place_contact_links').click(function() {
    $('#place_contact_links_wrap').slideToggle('fast');
    if ($(this).hasClass('button_white')) {
      $(this).removeClass('button_white');
      $(this).children('img').attr('src', '/images/gui/button_green_arrow.png');
    }
    else {
      $(this).addClass('button_white');
      $(this).children('img').attr('src', '/images/gui/button_gray_arrow.png');
    }
    return false;
  });

  $('#show_followers').click(function() {
    $('.place_followers a.right').toggle('fast');
    $('.place_followers .img_wrap').animate({height: $('.place_followers .img_wrap > div').outerHeight()}, 'fast');
    return false;
  });

  $('#hide_followers').click(function() {
    $('.place_followers a.right').toggle('fast');
    $('.place_followers .img_wrap').animate({height: '105px'}, 'fast');
    return false;
  });

  $('.button_review').click(function() {
    var top = $('#add_review_container').offset().top - $('.place_main_top').outerHeight() - 60;
        $('html,body').animate({scrollTop: top}, 1000);
  });

  $('a.place_phone_number').click(function() {
    $(this).parent().children('span').toggle('fast');
    return false;
  })

  $('.place_vip_description > a').live('click', function() {
    if ($('.place_vip_description span.extra_desc').css('display') == 'none') {
      $('.place_vip_description span.extra_desc').slideDown('fast', function() {
        $(this).show();
      });
      $('#show_desc').hide();
      $('#hide_desc').show();
    }
    else {
      $('.place_vip_description span.extra_desc').slideUp('fast', function() {
        $(this).hide();
      });
      $('#show_desc').show();
      $('#hide_desc').hide();
    }
    //return false;
  });

  var map_center = new google.maps.LatLng(<?php echo $company->getLocation()->getLatitude() ?>, <?php echo $company->getLocation()->getLongitude() ?>);

  var myOptions = {
      center: map_center,
      zoom: 17,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      streetViewControl: true
  };

  var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

  var marker = new google.maps.Marker ({
    map: map,
    position: map_center,
    title: <?php echo json_encode($company->getCompanyTitle()) ?>,
    icon: new google.maps.MarkerImage('/images/gui/icons/small_marker_'+<?php echo $company->getSectorId() ?>+'.png', null, null, null, new google.maps.Size(40,40))
  });

  $('.vip_gallery_tabs_top a').click(function() {
    $('.gallery_tab_content').hide();
    $('.vip_gallery_tabs_top a').removeClass('current');
    $('.'+ this.rel).show();
    $(this).addClass('current');
    $(this).parent().parent().css('backgroundPosition', ('0 ' + $(this).position().top + 'px'));
    google.maps.event.trigger(map, 'resize');
    map.setCenter(map_center);
    });

  $('.tu_switch').click(function() {
    if($(this).hasClass('off'))
      {
      $('#map_canvas').show();
      $('#tu_map').hide();
      google.maps.event.trigger(map, 'resize');
      }
      else
      {
      $('#map_canvas').hide();
      $('#tu_map').show();
      }
    $('#ct_map').hide();
    $(this).toggleClass('off');
    return false;
  })

  $('.ct_switch').click(function() {
    if($(this).hasClass('off'))
      {
      $('#map_canvas').show();
      $('#ct_map').hide();
      google.maps.event.trigger(map, 'resize');
      }
      else
      {
      $('#map_canvas').hide();
      $('#ct_map').show();
      }
      $('#tu_map').hide();
      $(this).toggleClass('off');
      return false;
  });

  //*CLOSE DROPDOWN ON ANYWHERE CLICK
            $(document).click(function (event) {
            if ($(event.target).closest('.add_photo_wrap').get(0) == null) {
                  $('#add_photo_wrap').slideUp('fast', function () {
                    $('.photo_dropdown_wrap').removeClass('photo_dropdown_wrap_opened');
                    $('#add_photo_wrap').removeAttr('style');
                     $('a.add_photo').css('padding-bottom', '0px');
                });
            };
          });


        $(document).click(function (event) {
            if (($(event.target).closest('.add_list_wrap').get(0) == null) && (($(event.target).closest('.ui-autocomplete').get(0) == null))) {
                $('#add_list_wrap').slideUp('fast', function () {
                    $('.list_dropdown_wrap').removeClass('list_dropdown_wrap_opened');
                    $('#add_list_wrap').removeAttr('style');
                });
            };

        });

  $('.add_photo').click(function() {
    if ($('.photo_dropdown_wrap').hasClass('photo_dropdown_wrap_opened')) {
      $('#add_photo_wrap').toggle('fast', function() {
        $('.photo_dropdown_wrap').removeClass('photo_dropdown_wrap_opened');
        $('a.add_photo').css('padding-bottom', '0px');
        $('#add_photo_wrap').removeAttr('style');
      });
    }
    else {
                        $('.list_dropdown_wrap').removeClass('list_dropdown_wrap_opened');
                        $('#add_list_wrap').removeAttr('style');
      $('.photo_dropdown_wrap').addClass('photo_dropdown_wrap_opened');
      $('.add_photo_wrap').css('left', $('.button_add_photo').position().left);
      $('.add_photo_wrap').css('top', '58px');
      $('a.add_photo').css('padding-bottom', '10px');
      $('.photo_dropdown_wrap .mask').css('left', $('.button_add_photo').position().left);
      $('.photo_dropdown_wrap .mask').css('top','58px');
      $.ajax({
        url: this.href,
                data: { 'ajaxValidation': true },
        beforeSend: function() {
          $('#add_photo_wrap').html('');
          $('#add_photo_wrap').append('<div style="width:111px;"><img style="display:block" src="/images/gui/pink_loader.gif" /></div>');
              $('#add_photo_wrap').show();
        },
        success: function(data) {
          $('#add_photo_wrap').html(data);
          $('#add_photo_wrap').prepend('<a id="picture_form_close" href="#"><img src="/images/gui/close_small.png" /></a>');
          $('#add_photo_wrap').find('form').attr('action', $('#add_photo_wrap').find('form').attr('action')+'#photo');
        }

      });
    }
      return false;
  });

  $('.add_list').click(function() {
    if ($('.list_dropdown_wrap').hasClass('list_dropdown_wrap_opened')) {
      $('#add_list_wrap').toggle('fast', function() {
        $('.list_dropdown_wrap').removeClass('list_dropdown_wrap_opened');
        $('#add_list_wrap').removeAttr('style');
      });
    }
    else {
      $('.list_dropdown_wrap').addClass('list_dropdown_wrap_opened');
      $('.add_list_wrap').css('left', $('.button_add_list').position().left);
      $('.list_dropdown_wrap .mask').css('left', $('.button_add_list').position().left);
                        $('.photo_dropdown_wrap').removeClass('photo_dropdown_wrap_opened');
            $('#add_photo_wrap').removeAttr('style');
            $('a.add_photo').css('padding-bottom', '0px');
      $.ajax({
        url: this.href,
        beforeSend: function() {
          $('#add_list_wrap').html('');
          $('#add_list_wrap').append('<div style="width:111px;"><img style="display:block" src="/images/gui/pink_loader.gif" /></div>');

              $('#add_list_wrap').show();
        },
        success: function(data) {
          $('#add_list_wrap').html(data);
          $('#add_list_wrap').prepend('<a id="list_form_close" href="#"><img src="/images/gui/close_small.png" /></a>');
        }
      });
    }
      return false;
  });

  $('.list_dropdown_wrap_opened .add_list_wrap > a').live('click', function() {
    $('#add_list_wrap').toggle('fast', function() {
      $('.list_dropdown_wrap').removeClass('list_dropdown_wrap_opened');
      $('#add_list_wrap').removeAttr('style');
    });
    return false;
  });
         /*CLOSE ADD LIST FORM*/
        $('#add_to_list.button_green').live('click', function() {
            $('.list_dropdown_wrap').removeClass('list_dropdown_wrap_opened');
             $('.list_dropdown_wrap').removeAttr('style');
              $('#add_list_wrap').removeAttr('style');
   });

  $('.photo_dropdown_wrap_opened .add_photo_wrap > a').live('click', function() {
    $('#add_photo_wrap').toggle('fast', function() {
      $('.photo_dropdown_wrap').removeClass('photo_dropdown_wrap_opened');
      $('#add_photo_wrap').removeAttr('style');
       $('a.add_photo').css('padding-bottom', '0px');
    });
    return false;
  });

  $('.email_form_wrap_opened .email_form > a').live('click', function() {
              $('#contact_form').toggle('fast', function() {
      $('.email_form_wrap').removeClass('email_form_wrap_opened');
      $('#contact_form').removeAttr('style');
    });
    return false;
  });

  if ($('.flash_error').length > 0) {
    var top = $('#add_review_container').offset().top - 60;
        $('html,body').scrollTop(top);
  }

  if ($('.event_scroll .viewport ul li').length > 3) {
    $('.event_scroll').tinyscrollbar();
  }
  else {
    $('.event_scroll .viewport').css({height:'auto'});
    $('.event_scroll .overview').css({position:'static'});
    $('.event_scroll .viewport ul li').css('width', '500px');
    $('.event_scroll .scrollbar').remove();
  }

  if ($('.list_scroll .viewport ul li').length > 3) {
    $('.list_scroll').tinyscrollbar();
  }
  else {
    $('.list_scroll .viewport').css({height:'auto'});
    $('.list_scroll .overview').css({position:'static'});
    $('.list_scroll .viewport ul li').css('width', '245px');
    $('.list_scroll .scrollbar').remove();
  }

  if ($('#place_left').outerHeight() > $('#place_right').outerHeight()) {
    $('#place_right').css('min-height', $('#place_left').outerHeight() + "px");
  }
        $(".place_right .place_item_gray").css("height", $(".place_main_vip > .place_left .place_item_gray").outerHeight());
        if  (!!($('.place_main_vip .place_right > * > .place_navigation_bar').find('a'))){
            $(".place_main_vip > .place_nav_small").css("border-bottom","2px solid #e8e8e8");
        }



      //redirectTo

        function check(w) {
            w.focus();
            return false;
        }

        $('a.web').click(function() {
            var href= '<?php echo url_for('company/redirectTo?slug=' . $company->getSlug())?>';
            var w=window.open($(this).attr('href') );
            setTimeout(function(){check(w)}, 1000);
            $.ajax({
                url: href,
                success: function( data ) {
                    w.focus();
                    return false;
                }
            });

            w.focus();
            return false;
        });


        $('a.facebook').click(function() {
            var href= '<?php echo url_for('company/redirectToFacebook?slug=' . $company->getSlug())?>';
            var w=window.open($(this).attr('href') );
            setTimeout(function(){check(w)}, 1000);
            $.ajax({
                url: href,
                success: function( data ) {
                    w.focus();
                    return false;
                }
            });

            w.focus();
            return false;
        });

        $('a.twitter').click(function() {
            var href= '<?php echo url_for('company/redirectToTwitter?slug=' . $company->getSlug())?>';
            var w=window.open($(this).attr('href') );
            setTimeout(function(){check(w)}, 1000);
            $.ajax({
                url: href,
                success: function( data ) {
                    w.focus();
                    return false;
                }
            });

            w.focus();
            return false;
        });

        $('a.foursquare').click(function() {
            var href= '<?php echo url_for('company/redirectToFoursquare?slug=' . $company->getSlug())?>';
            var w=window.open($(this).attr('href') );
            setTimeout(function(){check(w)}, 1000);
            $.ajax({
                url: href,
                success: function( data ) {
                    w.focus();
                    return false;
                }
            });

            w.focus();
            return false;
        });

        $('a.gplus').click(function() {
            var href= '<?php echo url_for('company/redirectToGooglePlus?slug=' . $company->getSlug())?>';
            var w=window.open($(this).attr('href') );
            setTimeout(function(){check(w)}, 1000);
            $.ajax({
                url: href,
                success: function( data ) {
                    w.focus();
                    return false;
                }
            });

            w.focus();
            return false;
        });

        $('a.goldenpages').click(function() {
            var href= '<?php echo url_for('company/redirectToYellowPagesRS?slug=' . $company->getSlug())?>';
            var w=window.open($(this).attr('href') );
            setTimeout(function(){check(w)}, 1000);
            $.ajax({
                url: href,
                success: function( data ) {
                    w.focus();
                    return false;
                }
            });

            w.focus();
            return false;
        });
    //end redirectTo



});

if(window.location.hash) {
    var hash = window.location.hash.substring(1);
    if (hash == 'map') {
      $('.gallery_tab_content').hide();
    $('.map_gallery').show();
    $('.gallery_tab').parent().removeClass('current');
    $('.gallery_tab[rel="map_gallery"]').parent().addClass('current');
    }
    <?php if (count($images) || $company->getImageId()):?>
      if (hash == 'photo') {
        $('.gallery_tab_content').hide();
      $('.photo_gallery').show();
      $('.gallery_tab').parent().removeClass('current');
      $('.gallery_tab[rel="photo_gallery"]').parent().addClass('current');
      }
    <?php endif; ?>
    <?php if ($videos):?>
    if (hash == 'video') {
      $('.gallery_tab_content').hide();
      $('.video_gallery').show();
      $('.gallery_tab').parent().removeClass('current');
      $('.gallery_tab[rel="video_gallery"]').parent().addClass('current');
      }
    <?php endif; ?>

    <?php if (isset($events) && count($events)) : ?>
    if (hash == 'event') {
    $('#show_events').trigger('click');
    }
    <?php endif; ?>

    <?php if (isset($lastOffer) && $lastOffer) : ?>
    if (hash == 'offer') {
    $('#show_offers').trigger('click');
    }
    <?php endif; ?>
}


</script>
