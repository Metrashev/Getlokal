<?php use_helper('Date', 'jQuery'); ?>
<?php $i18n = $sf_user->getCulture(); ?>
<?php $ad_company = $company->getActivePPPService(true); ?>
<?php use_helper('Date', 'XssSafe');?>

<?php  slot('facebook') ?>
<meta property="fb:app_id" content="<?php echo sfConfig::get('app_facebook_app_' . $sf_user->getCountry()->getSlug() . '_id'); ?>"/>
<meta property="og:type" content="website" /> 
<meta property="og:title" content="<?php echo $company->getCompanyTitle(); ?>" />
<meta property="og:locality" content="<?php echo $company->getCity()->getLocation(); ?>" />
<meta property="og:image" content="<?php echo image_path($company->getThumb(3), true) ?>" />
<?php if($company->getCompanyDescription($culture)):?>
    <meta property="og:description" content="<?php echo $company->getCompanyDescription($culture)?>" />
<?php endif;?>
<meta property="og:site_name" content="<?php echo $sf_request->getHost() ?>" />
<meta property="og:country-name" content="<?php echo $sf_user->getCountry()->getSlug() ?>" />
<meta property="og:url" content="<?php echo $company->getUri(); ?>" />

<?php end_slot() ?>


<?php /* slot('facebook') ?>
<meta property="fb:app_id" content="<?php echo sfConfig::get('app_facebook_app_' . $sf_user->getCountry()->getSlug() . '_id'); ?>"/>
<meta property="og:title" content="<?php echo $company->getCompanyTitle(); ?>" />
<meta property="og:image" content="<?php echo image_path($company->getThumb(), true) ?>" />
<meta property="og:site_name" content="<?php echo $sf_request->getHost() ?>" />
<meta property="og:country-name" content="<?php echo $sf_user->getCountry()->getSlug() ?>" />
<meta property="og:url" content="<?php echo $company->getUri(); ?>" />
<?php end_slot() */ ?>

<?php slot('canonical') ?>
<link rel="canonical" href="<?php echo $company->getCanonicalUrl() ?>">
<?php foreach (sfConfig::get('app_domain_slugs') as $iso): ?>
    <link rel="alternate" hreflang="en-<?php echo $iso ?>" href="<?php echo $company->getPermalink($iso, 'en') ?>">
    <link rel="alternate" hreflang="<?php echo $iso ?>-<?php echo $iso ?>" href="<?php echo $company->getPermalink($iso, $iso) ?>">
<?php endforeach ?>
<?php end_slot() ?>
<?php $hasSocialScripts = true?>
<?php $hasSocialHTML = false;?> 
<div id="social_share_wrap" class="social_share_wrap">
    <?php //include_partial('global/social', array('embed' => 'place', 'company' => $company)); ?>
    <?php  include_partial('global/social', array('embed' => 'place', 'company' => $company,  'hasSocialScripts' => false,'hasSocialHTML' => true )) ?>
</div>    
<?php if ($company->getIsClaimed() && $company->getStatus() == CompanyTable::VISIBLE): ?>
                    <div class="place_badge absolute">
                        <?php echo image_tag('gui/place_claim_' . $sf_user->getCulture() . '.png'); ?>
                        <a href="javascript:void(0)" class="verified_tip">?</a>
                        <div class="verified_tips">
                            <img src="/images/gui/tip_arrow.png" />
                            <div>
                                <?php echo __('This page has been claimed by the Place Owner.', null, 'company'); ?>
                            </div>
                        </div>
                        <?php /* $img_tag_official = image_tag('gui/place_oficial_'.$sf_user->getCulture().'.png'); ?>
                          <?php $img_tag_claim = image_tag('gui/place_claim_'.$sf_user->getCulture().'.png', 'alt_title='.  __('Is this your business? Claim it!', null, 'company')); ?>
                          <?php if ($company->getIsClaimed() && $company->getStatus()==0):?>
                          <?php if($user_is_admin):?>
                          <?php echo link_to($img_tag_official, 'companySettings/basic?slug='. $company->getSlug()); ?>
                          <?php elseif($user_is_company_admin):?>
                          <?php echo link_to($img_tag_official, 'companySettings/login?slug='. $company->getSlug()); ?>
                          <?php elseif(!$is_other_place_admin_logged  && !$user_is_not_approved_admin ): ?>
                          <?php echo link_to($img_tag_official, 'company/claim?slug='. $company->getSlug()); ?>
                          <?php else: ?>
                          <?php echo $img_tag_official;?>
                          <?php endif;?>
                          <?php else:?>
                          <?php if(!$user_is_not_approved_admin && !$is_other_place_admin_logged && $company->getStatus()==0 ):?>
                          <?php echo link_to($img_tag_claim, 'company/claim?slug='. $company->getSlug()); ?>
                          <?php else:?>
                          <?php echo $img_tag_claim;?>
                          <?php endif;?>
                          <?php endif; */ ?>
                    </div>
<?php endif; ?>    
<div itemscope itemtype="http://schema.org/LocalBusiness">
    <div class="place_main">

        <div class="place_left">
            <?php /* <div class="place_icons">
              <?php echo image_tag('gui/ico_p.gif') ?>
              <div class="clear"></div>
              </div> */ ?>
            <div class="place_main_top pp_place_name">
            <h1 itemprop="name"><?php echo $company->getCompanyTitle() ?></h1>
            <div itemprop="image" content="<?php echo image_path($company->getThumb(), true) ?>"></div>

            <div class="place_rateing"> 
                <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                	<?php if ($company->getNumberOfReviews() == 0): ?>
                	<meta itemprop="worstRating" content = "0">
                    <meta itemprop="bestRating" content = "5">
                    <?php endif; ?>
                    <div itemprop="ratingValue" content="<?php echo $company->getAverageRating() ?>"></div>
                    <div itemprop="ratingCount" content="<?php echo $company->getNumberOfReviews() == 0 ? 1 : $company->getNumberOfReviews() ?>"></div>
                </div>
                <div class="rateing_stars">
                    <div style="width: <?php echo $company->getRating() ?>%" class="rateing_stars_orange"></div>
                </div>
                <span><?php echo $company->getAverageRating() ?> / 5</span>
                <?php if ($company->getNumberOfReviews() > 0): ?>
                    <span class="review_count"><?php echo format_number_choice('[0]No reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $company->getNumberOfReviews()), $company->getNumberOfReviews(), 'user'); ?></span>
                <?php endif; ?>
                
            </div>
            <div class="clear"></div>
             <?php if ($user_is_admin or $user_is_company_admin or $sf_user->isGetlokalAdmin()): ?>
                <div class="right">
                    <?php echo link_to(__('Place Administration', null, 'company'), 'companySettings/basic?slug=' . $company->getSlug(), array('class' => 'button_pink')); ?>

                </div>
            <?php endif; ?>
            <div class="category_wrap">
                <ul>
                  <?php if ((getlokalPartner::getInstanceDomain() == 78) || $sf_request->getParameter('county', false)): ?>
                      <li><?php echo link_to(sprintf(__('%s in %s'), $company->getClassification(), $company->getCity()->getCounty()->getLocation()), '@classificationCounty?slug='. $company->getClassification ()->getSlug (). '&sector='. $company->getSector ()->getSlug (). '&county='. $company->getCity()->getCounty()->getSlug(), array('title' => sprintf(__('%s in %s'), $company->getClassification(), $company->getCity()->getCounty()->getLocation()))) ?></li>
                      <?php if ($company->getAdditionalClassifications()): ?>
                          <?php foreach ($company->getAdditionalClassifications() as $classification): ?>                
                              <li><?php echo link_to(sprintf(__('%s in %s'), $classification, $company->getCity()->getCounty()->getLocation()), sprintf('@classificationCounty?slug=%s&county=%s&sector=%s', $classification->getSlug(), $company->getCity()->getCounty()->getSlug(), $classification->getPrimarySector()->getSlug()), array('title' => sprintf(__('%s in %s'), $classification, $company->getCity()->getCounty()->getLocation()))) ?></li>
                          <?php endforeach; ?>
                      <?php endif; ?>
                  <?php else: ?>
                      <li><?php echo link_to(sprintf(__('%s in %s'), $company->getClassification(), $company->getCity()->getDisplayCity()), $company->getClassificationUri(ESC_RAW), array('title' => sprintf(__('%s in %s'), $company->getClassification(), $company->getCity()->getDisplayCity()))) ?></li>
                        <?php if ($company->getAdditionalClassifications()): ?>
                            <?php foreach ($company->getAdditionalClassifications() as $classification): ?>
                                <li><?php echo link_to(sprintf(__('%s in %s'), $classification, $company->getCity()->getDisplayCity()), $classification->getUrla($company->getCity()->getSlug(), ESC_RAW), array('title' => sprintf(__('%s in %s'), $classification, $company->getCity()->getDisplayCity()))) ?></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                  <?php endif; ?>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
            <div class="photo_gallery gallery gallery_tab_content" style="display: block">
                <ul>
                    <?php if (count($images) || $company->getImageId()): ?>
                        <?php $profileImage = 0; ?>
                        <?php if ($company->getImageId()): ?>
                            <?php $profileImage = 1; ?>
                            <li>
                                <a rel="gallery" class="fancybox"
                                   title="<?php echo($company->getImage()->getCaption(ESC_XSSSAFE))?>"
                                   name="<?php echo ($company->getImage()->getUserProfile()->getIsCompanyAdmin($company) ? $company->getCompanyTitle() : $company->getImage()->getUserProfile());?>"
                                   rev="<?php echo ($company->getImage()->getUserProfile()->getIsCompanyAdmin($company) ? url_for( $company->getUri(ESC_RAW)) : url_for($company->getImage()->getUserProfile()->getUri(ESC_RAW)) );?>"
                                    href="<?php echo $company->getImage()->getThumb('preview')?>">
                                       <?php echo image_tag($company->getImage()->getThumb(0), array('size' => '150x150', 'alt' => $company->getCompanyTitle() . (($company->getImage()->getCaption()) ? ' - ' . $company->getImage()->getCaption() : ''))) ?>
                                </a>

                                <div class="photo_gallery_upload_options">
                                    <span class="photo_number"></span>
                                    <p class="company_name_caption"><?php
                                    echo
                                    ( $company->getImage()->getUserProfile()->getIsCompanyAdmin($company) ?
                                             truncate_text($company->getCompanyTitle(ESC_XSSSAFE), 42, '...', true) :
                                            $company->getImage()->getUserProfile()->getLink(false, null, 'class=photo_gallery_upload_options_personName', ESC_RAW));
                                    ?></p>
                                    <p><?php echo ESC_XSSSAFE(truncate_text($company->getImage()->getCaption(), 30, '...', true)); ?></p>
                                    
                                   
                                </div>
                            </li>
                        <?php endif; ?>
                        <?php foreach ($images as $image): ?>
                            <li>
                                <a rel="gallery"
                                   name="<?php echo ($company->getImage()->getUserProfile()->getIsCompanyAdmin($company) ? $company->getCompanyTitle() : $image->getUserProfile());?>"
                                   rev="<?php echo ($company->getImage()->getUserProfile()->getIsCompanyAdmin($company) ? url_for( $company->getUri(ESC_RAW)) : url_for($image->getUserProfile()->getUri(ESC_RAW)) );?>"
                                   title="<?php echo($image->getCaption(ESC_XSSSAFE)) ?> "
                                   class="fancybox"
                                   href="<?php echo $image->getThumb('preview')?>">
                                       <?php echo image_tag($image->getThumb(0), array('size=150x150', 'alt' => $company->getCompanyTitle() . (($image->getCaption()) ? ' - ' . $image->getCaption() : '' ))) ?>
                                </a>
                                <?php // echo image_tag($image->getThumb(0), array('size=150x150', 'alt' => $company->getCompanyTitle() . (($image->getCaption()) ? ' - ' . $image->getCaption() : ''))) ?>
                                <div class="photo_gallery_upload_options">
                                    <span class="photo_number"></span>
                                    <p class="company_name_caption">
                                        <?php
                                         echo $image->getUserProfile()->getLink(false, null, 'class=photo_gallery_upload_options_personName', ESC_RAW);
                                       
                                        ( $image->getUserProfile()->getIsCompanyAdmin($company) ?
                                                truncate_text($company->getCompanyTitle(ESC_XSSSAFE), 42, '...', true) :
                                                $image->getUserProfile()->getLink(false, null, 'class=photo_gallery_upload_options_personName', ESC_RAW));
                                        ?>
                                    </p>
                                    <p><?php echo ESC_XSSSAFE(truncate_text($image->getCaption(), 30, '...', true)); ?></p>
                                </div>

                            </li>
                        <?php endforeach ?>
                    <?php else: ?>
                        <li><?php echo image_tag('gui/default_place_150x150.png') ?></li>
                    <?php endif ?>
                </ul>
                <?php if (count($images) + $profileImage > 1): ?>
                    <a href="javascript:void(0)" class="back"></a>
                    <a href="javascript:void(0)" class="next"></a>
                <?php endif ?>
            </div>

            <div class="tour_gallery gallery_tab_content" style="display: none;"></div>
            <div class="form_tab_content gallery_tab_content"></div>
            <div class="place_contact_info place_addres" style="position:relative;" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                <?php if ($company->getPhone()): ?>
                <b class="ico-awesome" itemprop="telephone"><?php echo $company->getPhoneFormated() ?></b>
                <?php endif; ?>
                <b class="ico-awesome"><a href="<?php echo url_for('@company_suggest?city='.$sf_request->getParameter('city').'&slug='.$sf_request->getParameter('slug')); ?>" title="<?php echo __('Suggest an Edit' , null , 'company') ?>"><i class="fa fa-edit"></i></a></b>
                
                <address>
                    <meta itemprop="addressCountry" content="<?php echo mb_convert_case($company->getCountry()->getSlug(), MB_CASE_UPPER) ?>" />
                    <meta itemprop="addressLocality" content="<?php echo $company->getCity()->getLocation(); ?>" />
                    <meta itemprop="addressRegion" content="<?php echo $company->getCity()->getCounty()->getRegion(); ?>" />
                    <?php if ($company->getLocation()->getPostcode()): ?>
                        <meta itemprop="postalCode" content="<?php echo $company->getLocation()->getPostcode(); ?>" />
                    <?php endif; ?>
                    <?php $address = explode(', ', $company->getDisplayAddress(), 2); ?>
                    <?php if(isset($address[1])):?>
                        <meta itemprop="streetAddress" content="<?php echo $address[1]; ?>" />
                    <?php endif;?>
                </address>
                    
                <p><?php echo $company->getDisplayAddress() ?></p>

                <?php if ($company->getAddressInfo()): ?>
                    <a href="javascript:void(0)" id="read_more_address"><?php echo __('read more...') ?></a>
                    <span><?php echo $company->getAddressInfo(); ?></span>
                <?php endif; ?>

                <?php if ($company->getEmail()): ?>
                    <div class="email_form_wrap">
                        <div class="link">
                            <?php echo getSendEmailLink($company); ?>
                        </div>
                        <div class="mask"></div>
                        <div class="email_form" id="contact_form" style="width:282px"></div>
                    </div>
                <?php endif; ?>
                <?php if ($company->getWebsiteUrl()): ?>
                    <?php echo getCompanyWebSite($company); ?>
                <?php endif; ?>
                <div class="clear"></div>
                <div class="report_success" style="display: none;">
                    <?php echo __($sf_user->getFlash('notice')) ?>
                </div>
            </div>



            <div id="place_desc" class="place_desc"><span>
                    <?php if ($company->getCompanyDescription()): ?>
                        <?php echo $company->getCompanyDescription() ?>
                    <?php else: ?>
                        <?php echo sprintf(__('If you have been to %s in %s, leave your rating and review or photo to help other users searching in %s.', null, 'company'), $company->getCompanyTitle(), $company->getCity()->getLocation(), $company->getClassification()); ?>
                        <?php echo sprintf(__('You can find %s at %s, telephone %s.', null, 'company'), $company->getCompanyTitle(), $company->getDisplayAddress(), $company->getPhoneFormated()); ?>
                    <?php endif; ?>

                    <?php if ($sf_user->getCulture() != 'sr') : ?>
                        <?php $vr1 = $company->getCompanyTitle() ?>
                        <?php $vr2 = link_to(__('claim it', null, 'company'), 'company/claim?slug=' . $company->getSlug()) ?>
                    <?php else : ?>
                        <?php $vr1 = link_to(__('claim it', null, 'company'), 'company/claim?slug=' . $company->getSlug()) ?>
                        <?php $vr2 = $company->getCompanyTitle() ?>
                    <?php endif; ?>

                    <?php if (!$company->getIsClaimed() && !$user_is_not_approved_admin): ?>
                        <?php if ($company->getStatus() == 0): ?><br /><br />
                            <?php echo sprintf(__('If you are a representative of %s, %s and manage this information. It\'s free and easy and %s.', null, 'company'), $vr1, $vr2, link_to(__('just a few steps away', null, 'company'), url_for('@for_business'))); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </span>
                <a href="javascript:void(0)" class="show_desc" id="show_desc" style="display:none"><?php echo __('read more...'); ?></a>
                <a href="#" style="display:none"><?php echo __('hide') ?></a>
            </div>

            <div id="place_desc_nav"></div>
     <div class="place_work pp">
            <?php if ($company->getCompanyDetail() && $company->getCompanyDetail()->getHourFormatCPage('wed')): ?>

                    <div class="timetable">
                        <h3><?php echo __('Working Hours', null, 'company') ?></h3>
                        <div id="place_work_in">
                            <?php foreach (array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun') as $day): ?>
                                <div class="place_work_item">
                                    <b><?php echo __(ucfirst($day)) ?></b>
                                    <?php if ($company->getCompanyDetail()->getHourFormatCPage($day)): ?>
                                        <?php echo ($company->getCompanyDetail()->getHourFormatCPage($day) == 'closed' ? '<img title="' . __('Closed') . '" src="/images/gui/locked.png" alt="X" />' : $company->getCompanyDetail()->getHourFormatCPage($day)); ?>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach ?>
                            <div class="clear"></div>
                        </div>
                    </div>

                <?php endif; ?>
                <?php if ($company->getFacebookUrl() or $company->getGoogleplusUrl() or $company->getFoursquareUrl() or $company->getTwitterUrl() or ($company->getCountryId() == 4 && $company->getCompanyDetailSr()->getSrUrl())): ?>

                     <div class="place_links_wrap">
                        <div class="place_links">
                            <?php if ($company->getFacebookUrl()): ?>
                                <?php echo getCompanyFacebook($company); ?>
                            <?php endif; ?>
                            <?php if ($company->getTwitterUrl()): ?>
                                <?php echo getCompanyTwitter($company); ?>
                            <?php endif; ?>
                            <?php if ($company->getFoursquareUrl()): ?>
                                <?php echo getCompanyFoursquare($company); ?>
                            <?php endif; ?>
                            <?php if ($company->getGoogleplusUrl()): ?>
                                <?php echo getCompanyGooglePlus($company); ?>
                            <?php endif; ?>
                            <?php if ($company->getCountryId() == 4 && $company->getCompanyDetailSr()->getSrUrl()): ?>
                                <?php echo getCompanyYellowPagesRS($company); ?>
                            <?php endif; ?>
                            <div class="clear"></div>
                        </div>
                    </div>

                 <?php endif; ?>
              </div>
           <div class="clear"></div>

          <?php if(!is_null($company->getCreatedByUser()->getId())): ?>
            <div class="test-class-for-user">
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
            </div>
          <?php endif; ?>

            <div class="place_user_action">

                <?php if (!$is_other_place_admin_logged && !$user_is_admin && !$user_is_company_admin): ?>
                    <a href="javascript:void(0);" onClick="_gaq.push(['_trackEvent', 'Review', 'Write', 'company']);" class="button_pink button_big button_review"><?php echo __('Write a Review') ?></a>
                <?php endif; ?>

                <?php if ($user_is_company_admin && !$user_is_admin): ?>
                    <div class="photo_dropdown_wrap">
                        <div class="link">
                            <a href="<?php echo url_for('companySettings/login?slug=' . $company->getSlug() . '&login=true') ?>" class="button_pink add_photo button_big button_add_photo"><?php echo __('Add a <br/>Photo', null, 'company') ?></a>
                        </div>
                        <div class="mask"></div>
                        <div class="add_photo_wrap" id="add_photo_wrap" style="display: none"></div>
                    </div>
                <?php elseif (!$is_other_place_admin_logged): ?>
                    <div class="photo_dropdown_wrap">
                        <div class="link">
                            <a href="<?php echo url_for('company/addImage?id=' . $company->getId()) ?>" class="button_pink add_photo button_big button_add_photo"><?php echo __('Add a <br/>Photo', null, 'company') ?></a>
                        </div>
                        <div class="mask"></div>

                        <div class="add_photo_wrap" id="add_photo_wrap" style="display: none;"></div>

                    </div>
                <?php endif; ?>
                <?php if (!$is_other_place_admin_logged && !$user_is_admin && !$user_is_company_admin): ?>
                    <div class="list_dropdown_wrap">
                        <div class="link">
                            <a href="<?php echo url_for('company/addToList?id=' . $company->getId()) . '?type=pp' ?>" class="button_pink add_list button_big button_add_list"><?php echo __('Add to <br/>List', null, 'list') ?></a>
                        </div>
                        <div class="mask"></div>
                        <div class="add_list_wrap" id="add_list_wrap" style="display: none">
                            <a id="list_form_close" href="#"><img src="/images/gui/close_small.png" alt="<?php echo __("close") ?>" /></a>
                            <?php /* if ($user):?>
                              <?php include_partial('list/form_for_company',array('form'=>$list_form, 'template'=>'pp', 'page_id'=>$company->getCompanyPage()->getId() ));?>
                              <?php endif; */ ?>
                        </div>
                    </div>
                <?php endif; ?>


                <div class="report_success1" style="margin: 10px 0; display: none;padding: 1px 12px">
                    <?php //echo __($sf_user->getFlash('noticeImg'))  ?>
                    <?php echo __('This place was successfully added to the list!', null, 'company') ?>
                </div>
                <div class="clear"></div>
                <?php if ($sf_user->hasFlash('noticeImg')): ?>
                    <div class="report_success2" style="margin: 10px 0">
                        <?php echo __($sf_user->getFlash('noticeImg')) ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($offers): ?>
                <div class="offer_set_listing place_page">
                    <?php  $offers_count = count($offers); ?>
                    <div class="offer_module_wrap">
                        <h3><?php echo __('Current Offers', null, 'offer') ?></h3>
                        <div class="carousel_wrapper">
                            <div class="carousel_content" style="height: auto">
                                <ul>
                                    <?php foreach($offers as $offers):?>
                                        <li>
                                            <?php $culture = $sf_user->getCulture(); ?>
                                          <div class="offer_image">
                                                <?php if ($offers->getImageId()): ?>
                                                  <?php echo link_to(image_tag($offers->getImage()->getThumb(), 'size=100x100 alt=' . $offers->getDisplayTitle() . ' title=' . $offers->getDisplayTitle()), 'offer/show?id=' . $offers->getId()) ?>
                                                <?php else : ?>
                                                  <?php echo link_to(image_tag('gui/default_offer_100x100.jpg', 'size=100x100 alt=' . $offers->getDisplayTitle() . ' title=' . $offers->getDisplayTitle()), 'offer/show?id=' . $offers->getId()); ?>
                                                <?php endif; ?>
                                           </div>
                                           <div class="offer_details">
                                                <h4><?php echo link_to((mb_strlen($offers->getDisplayTitle(), 'UTF8') <= 100 )?$offers->getDisplayTitle():mb_substr($offers->getDisplayTitle(), 0, 100, 'UTF8').'...', 'offer/show?id=' . $offers->getId()); ?></h4>

                                                <?php // echo (mb_strlen($offers->getContent(ESC_RAW), 'UTF8') <= 40 )? $offers->getContent(ESC_RAW) : mb_substr($offers->getContent(ESC_RAW), 0, 40, 'UTF8').'...'; ?>

                                                <?php echo link_to(__('Get Voucher!', null, 'offer'), 'offer/show?id=' . $offers->getId(), 'class=button_pink pp_offer'); ?>
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
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="place_right">
            <?php /*      <div class="gallery_wrap">
              <div class="gallery_tabs_top">
              <a class="gallery_tab gallery_tab_current current" href="javascript:void(0)" rel="photo_gallery"><?php echo __('Photos', null, 'company')?></a>
              <?php /*?>
              <?php if ($videos):?>
              <a class="gallery_tab" href="javascript:void(0)" rel="video_gallery"><?php echo __('Videos', null, 'company')?></a>
              <?php endif;?>
              <a class="gallery_tab <?php echo ( count($images)|| $company->getImageId() ) ?'': 'gallery_tab_current' ?>" href="javascript:void(0)" rel="map_gallery"><?php echo __('Map')?></a>
              <?php */ ?>
            <?php /*       </div>


              <div class="gallery_tabs_in">

              </div>
              </div>
             */ ?>
            <?php include_partial('company/similar_places', array('similar_places' => $similar_places)); ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>


    <!-- Content Area -->



    <div class="content_in" id="reviews">
        <div id="contact_form" style="display: none"></div>

        <!-- User Tabs -->
        <div class="standard_tabs_wrap">
            <a name="tabs"></a>
            <div class="standard_tabs_top" id="more_info">
                <a id="tab0" class="current" href="javascript:void(0);" data="<?php echo url_for($company->getUri(ESC_RAW)); ?>">
                    <?php echo __('Reviews') . ' <span>(' . $company->getNumberOfReviews() . ')</span>'; ?></a>

                <?php if ($eventCount > 0): ?>
                    <a id="tab1" href="javascript:void(0);" data="<?php echo url_for('company/events?slug=' . $company->getSlug() . '&city=' . $company->getCity()->getSlug()); ?>"><?php echo __('Events') . ' <span>(' . $eventCount . ')</span>'; ?></a>
                <?php endif; ?>

                <?php if ($listsCount > 0): ?>
                    <a id="tab2" href="javascript:void(0);" data="<?php echo url_for('company/lists?pageId=' . $company->getCompanyPage()->getId()); ?>"><?php echo __('Lists') . ' <span>(' . $listsCount . ')</span>'; ?></a>
                <?php endif; ?>

                <div class="clear"></div>
            </div>

            <div id="tab-container-1" class="standard_tabs_in">
                <div class="info"><?php echo $sf_data->getRaw('sf_content') ?></div>
            </div>

            <?php if (!$company->getIsClaimed()): ?>
                <?php if ($company->getStatus() == 0 && (!$user_is_admin or !$user_is_company_admin) && !$is_other_place_admin_logged && !$user_is_not_approved_admin): ?>
                    <div class="claim_wrapper">
                        <img src="/images/gui/bg_clame.gif" />
                        <div class="company_clame">
                            <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
                                <b><?php echo __('This company is yours?', null, 'company'); ?>
                                <?php echo link_to(__('Claim it!', null, 'company'), 'company/claim?slug=' . $company->getSlug()); ?></b>
                                <p><?php echo __('Make some getlokal friends!', null, 'company'); ?></p>
                                <span><?php echo __('Start a getlokal conversation about the details that matter and share your news!', null, 'company'); ?></span>
                            <?php else: ?>
                                <b><?php echo __('Is this your business?', null, 'company'); ?>
                                <?php echo link_to(__('Claim it!', null, 'company'), 'company/claim?slug=' . $company->getSlug()); ?></b>
                                <p><?php echo __('Take control of your online reputation and talk to your customers.', null, 'company'); ?></p>
                                <span><?php echo __('It\'s free! Start now!', null, 'company'); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

        </div>
        <div class="clear"></div>
    </div>
</div>


<?php if (!$is_other_place_admin_logged && !$user_is_admin && !$user_is_company_admin): ?>
     <?php //Sidebar for all users ;?>
    <div class="sidebar" style="padding-top: 60px">
        <?php
        $partner = getlokalPartner::getInstanceDomain();
        if (in_array($partner, getlokalPartner::getAllPartners()/*array(getlokalPartner::GETLOKAL_BG, getlokalPartner::GETLOKAL_RS, getlokalPartner::GETLOKAL_RO)*/)) {
            // include getlokal social sidebar if in BG or RS
             include_component('home', 'social_sidebar');
        } elseif ($company->getFacebookUrl()) {
            $arr = explode('/', $company->getFacebookUrl());
            $id = $arr[sizeof($arr) - 1];
            if ($id == '')
                $id = $arr[sizeof($arr) - 2];

            $fql_multiquery_url = 'http://graph.facebook.com/' . $id . '?metadata=1';

            $fql_multiquery_result = @file_get_contents($fql_multiquery_url);
            if ($fql_multiquery_result !== FALSE) {
                //$fql_multiquery_result = file_get_contents($fql_multiquery_url);
                $fql_multiquery_obj = json_decode($fql_multiquery_result, true);

                if (isset($fql_multiquery_obj['metadata']) && $fql_multiquery_obj['metadata']['type'] == 'page') {
                 //   include_partial('company/social_sidebar', array('facebook' => $company->getFacebookUrl()));
                }
            }
        }
        else{
             include_component('home', 'social_sidebar');
        }
        ?>
        <div style="margin: 44px 0px 20px 0px;"><?php include_component('box', 'boxOffers') ?></div>
        <div class="clear"></div>
        <?php if ($user && !$user_is_admin && !$is_other_place_admin_logged && !$user_is_company_admin): ?>
            <?php if (isset($followers) && count($followers)) : ?>
                <div class="place_followers">
                    <h2><?php echo __('Followers', null, 'messages'); ?></h2>

                    <!-- Follower images start -->
                    <div class="img_wrap" <?php echo (count($followers) > 10) ? 'style="height:105px"' : ''; ?>>
                        <div><?php foreach ($followers as $follower) : ?> <a
                                    href="<?php echo url_for('user_page', array('username' => $follower->getUserProfile()->getSfGuardUser()->getUsername()), true) ?>"
                                    title="<?php echo $follower->getUserProfile()->getSfGuardUser()->getFirstName() . ' ' . $follower->getUserProfile()->getSfGuardUser()->getLastName(); ?>">
                                        <?php echo image_tag($follower->getUserProfile()->getThumb(0), array('alt' => '')); ?>
                                </a> <?php endforeach; ?>

                            <div class="clear"></div>
                        </div>
                    </div>
                    <?php if (!$is_followed): ?>
                        <div>
                            <?php echo link_to(__('Follow Us') . ' (' . $company->getFollowers(true) . ')', 'follow/follow?page_id=' . $company->getCompanyPage()->getId(), array('class' => 'button_green button_clickable')); ?>
                        </div>
                    <?php else: ?>
                        <div>
                            <?php echo link_to(__('Unfollow Us') . ' (' . $company->getFollowers(true) . ')', 'follow/stopFollow?page_id=' . $company->getCompanyPage()->getId(), array('class' => 'button_green button_clickable button_clicked')); ?>
                        </div>
                    <?php endif; ?>
                    <!-- Follower images end -->
                    <?php if (count($followers) > 10) : ?>
                        <a href="#" class="right" id="show_followers"> 
                            <?php echo __('see all') ?>
                            <img src="/images/gui/arrow_down_blue.png" /> 
                        </a> 
                        <a href="#" class="right" id="hide_followers"> <?php echo __('hide') ?> 
                            <img src="/images/gui/arrow_down_gray.png" />
                        </a>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <?php if (!$is_followed): ?>
                    <?php echo link_to(__('Follow Us') . ' (' . $company->getFollowers(true) . ')', 'follow/follow?page_id=' . $company->getCompanyPage()->getId(), array('class' => 'button_green button_clickable right', 'style' => 'margin-bottom:25px')); ?>
                <?php else: ?>
                    <?php echo link_to(__('Unfollow Us') . ' (' . $company->getFollowers(true) . ')', 'follow/stopFollow?page_id=' . $company->getCompanyPage()->getId(), array('class' => 'button_green button_clickable button_clicked right', 'style' => 'margin-bottom:25px')); ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

        <?php include_component('box', 'boxVote', array('company' => $company, 'title' => __('Vote'))); ?>
        <?php include_partial('global/ads', array('type' => 'box')); ?>
        <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
            <?php  include_partial('global/ads', array('type' => 'box2')); ?>  
        <?php endif;?> 
    </div>
    <?php else:?>
    <?php //Sidebar for other place admins ;?>
     <div class="sidebar" style="padding-top: 60px">
        <?php
        $partner = getlokalPartner::getInstanceDomain();
        if (in_array($partner, array(getlokalPartner::GETLOKAL_BG, getlokalPartner::GETLOKAL_RS))) {
            // include getlokal social sidebar if in BG or RS
             include_component('home', 'social_sidebar');
        } elseif ($company->getFacebookUrl()) {
            $arr = explode('/', $company->getFacebookUrl());
            $id = $arr[sizeof($arr) - 1];
            if ($id == '')
                $id = $arr[sizeof($arr) - 2];

            $fql_multiquery_url = 'http://graph.facebook.com/' . $id . '?metadata=1';

            $fql_multiquery_result = @file_get_contents($fql_multiquery_url);
            if ($fql_multiquery_result !== FALSE) {
                //$fql_multiquery_result = file_get_contents($fql_multiquery_url);
                $fql_multiquery_obj = json_decode($fql_multiquery_result, true);

                if (isset($fql_multiquery_obj['metadata']) && $fql_multiquery_obj['metadata']['type'] == 'page') {
                 //   include_partial('company/social_sidebar', array('facebook' => $company->getFacebookUrl()));
                }
            }
        }
        ?>
        <div style="margin: 44px 0px 20px 0px;"><?php include_component('box', 'boxOffers') ?></div>
        <div class="clear"></div>
        <?php include_partial('global/ads', array('type' => 'box')); ?>
        <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
            <?php  include_partial('global/ads', array('type' => 'box2')); ?>  
        <?php endif;?> 
    </div>
    <?php endif; ?>  
<div class="clear"></div>

<script type="text/javascript">
    $(document).ready(function() {
        if($(".message_wrap").is(":visible")){ $('html, body').animate({
                scrollTop: $(".message_wrap").offset().top-300
            }, 2000);}
          $('.hp_2columns_left').css('margin', '-26px 20px 0px 0px');

 //images
<?php
/*echo
( $company->getImage()->getUserProfile()->getIsCompanyAdmin($company) ?
        $company->getCompanyTitle() :
        $company->getImage()->getUserProfile()->getLink(false, null, 'class=photo_gallery_upload_options_personName', ESC_RAW));

 */
?>

 <?php //echo $company->getCompanyTitle(); ?>
 function formatTitle(title, currentArray, currentIndex, currentOpts) {
    //var a_title;
    var link = currentArray[currentIndex]['rev'];
    var name = currentArray[currentIndex]['name'];
      return '<?php if($company->getImage()->getUserProfile()->getIsCompanyAdmin($company)):?><div class="picture_title" style="position:relative;padding-left:45px;"><img style="position:absolute;top:-15px;left:0px" src="/images/gui/bg_official_big.png" /><?php endif;?><span class="right">' + (currentIndex + 1) + '/' + currentArray.length + '</span>' + (title && title.length ? '<p>'+title+'</p>' : '' ) + '<p>' + "<?php echo __('by')?>" + ' <a href="'+ link + '">' + name + '</a></p>' + '<div class="clear"></div></div>';
  }

  $('.fancybox').fancybox({
    'cyclic'      : true,
    'titlePosition'   : 'inside',
    'overlayColor'    : '#000',
    'overlayOpacity'  : 0.6,
    'margin'      : 0,
    'titleFormat'   : formatTitle,
    'index'   : true
  });
// end images
        <?php if (($company->getCompanyDetail() && $company->getCompanyDetail()->getHourFormatCPage('wed'))): ?>
              <?php if ($company->getFacebookUrl() or $company->getGoogleplusUrl() or $company->getFoursquareUrl() or $company->getTwitterUrl() or ($company->getCountryId() == 4 && $company->getCompanyDetailSr()->getSrUrl())): ?>
                    $('.place_work .place_links_wrap').addClass('working_and_social');
              <?php endif; ?>
        <?php endif; ?>
      <?php if (!($company->getCompanyDetail() && $company->getCompanyDetail()->getHourFormatCPage('wed'))): ?>
             <?php if (!($company->getFacebookUrl() or $company->getGoogleplusUrl() or $company->getFoursquareUrl() or $company->getTwitterUrl() or ($company->getCountryId() == 4 && $company->getCompanyDetailSr()->getSrUrl()))): ?>
                    $('.place_work.pp').hide();
             <?php endif; ?>
      <?php endif; ?>

        $('.path_wrap').addClass('path_wrap_place');
        $('.menu_link_wrap').css('display', 'none');
        $('.verified_tip').hover(function() {
            $('.verified_tips').show();
        }, function() {
            $('.verified_tips').hide();
        });

        $('.video_gallery ul li').mouseenter(function() {
            $(this).parent().parent().css('height', 150 + $(this).children('.photo_gallery_video_upload_options').outerHeight());
            $(this).css('height', 150 + $(this).children(".photo_gallery_video_upload_options").outerHeight());
            $(this).children('.photo_gallery_video_upload_options').css('display', 'block');
        });

        $('.video_gallery').mouseleave(function() {
            $(this).css('height', 150);
            $(this).children('ul').children('li').css('height', 'auto');
            $(this).children('ul').children('li').children('.photo_gallery_video_upload_options').css('display', 'none');
        });
        var update = false;

        $('.gallery').each(function(i,s) {
            var _x = 0;
            $(s).find('ul').width($(s).find('li').length * 150);
            var max = $(s).find('li').length - 1;
            var count = 1;
            $(this).children('ul').children('li').each(function() {
                $(this).children('.photo_gallery_upload_options').children('.photo_number').text(count + '/' + (max + 1));
                count = count + 1;
            });
            $(s).find('.next').click(function() {
                _x += 1;
                if(_x > max) _x = 0;
                $(".photo_gallery_upload_options").css("display", "none");
                $(s).find('ul').animate({left: (_x * -150) + 'px'}, 500, function() {
                    $(".photo_gallery_upload_options").css("display", "block");
                });

                return false;
            })
            $(s).find('.back').click(function() {
                _x -= 1;
                if(_x < 0) _x = max;
                $(".photo_gallery_upload_options").css("display", "none");
                $(s).find('ul').animate({left: (_x * -150) + 'px'}, 500, function() {
                    $(".photo_gallery_upload_options").css("display", "block");
                });
                return false;
            })
        });

        $('.standard_tabs_top a').click(function() {
            if(update) return;
            if ($(this).hasClass('current')) return;
            update = true;
            var href= $(this).attr('data');
            $('.standard_tabs_top a').removeClass('current');
            $(this).addClass('current');
            $.ajax({
                url: href,
                beforeSend: function( ) {
                    $('.standard_tabs_in').html('<div class="review_list_wrap">loading...</div>');
                },
                success: function( data ) {
                    $('.standard_tabs_in').html(data);
                    update = false;
                }
            });
            return false;
        });
        $('#read_more_info').click(function() {
            if (!$('#tab_info').hasClass('current')) {
                $('.standard_tabs_top a').removeClass('current');
                $('#tab_info').addClass('current');
                $.ajax({
                    url: $('#tab_info').attr("data"),
                    beforeSend: function( ) {
                        console.log($('#tab_info').href);
                        $('.standard_tabs_in').html('<div class="review_list_wrap">loading...</div>');
                        var top = $('#more_info').offset().top - 60;
                        $('html,body').animate({scrollTop: top}, 1000);
                    },
                    success: function( data ) {
                        $('.standard_tabs_in').html(data);
                    }
                });
            }
            else {
                var top = $('#more_info').offset().top - 60;
                $('html,body').animate({scrollTop: top}, 1000);
            }
            //return false;
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
                        $('#contact_form').html('<div style="text-align:center;"><img src="/images/gui/blue_loader.gif"/></div>');
                    },
                    success: function( data ) {
                        $("#contact_form").html(data.html);
                    }
                });
            }
            return false;
        });

        $('.email_form_wrap_opened .email_form > a').live('click', function() {
            $('#contact_form').toggle('fast', function() {
                $('.email_form_wrap').removeClass('email_form_wrap_opened');
                $('#contact_form').removeAttr('style');
                 $('#contact_form').css({"width": "282px"});
            });
            return false;
        });

        $('#contact_form form').live('submit',function(event) {
            //event.preventDefault();
            var loading = false;

            if(loading) return false;

            var element = $(this);

            loading = true;

            $.ajax({
                url: this.action,
                type: 'POST',
                data: $(this).serialize() + '&getFlashOnly=true',
                dataType: 'json',
                beforeSend: function() {

                    $(element).html('<img src="/images/gui/blue_loader.gif"/>');
                },
                success: function(data, url) {
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

                    loading = false;
                },
                error: function(data,e, xhr)
                {
                    console.log(e);
                }
            });

            return false;
        });

        $('.button_review').click(function() {
            if (!$('#tab0').hasClass('current')) {
                $('.standard_tabs_top a').removeClass('current');
                $('#tab0').addClass('current');
                var href = $('#tab0').attr("data");
                $.ajax({
                    url: href,
                    beforeSend: function( ) {
                        $('.standard_tabs_in').html('<div class="review_list_wrap">loading...</div>');
                    },
                    success: function( data ) {
                        $('.standard_tabs_in').html(data);
                        var top = $('#add_review_container').offset().top - 60;
                        $('html,body').animate({scrollTop: top}, 1000);
                    }
                });
            }
            else {
                var top = $('#add_review_container').offset().top - 60;
                $('html,body').animate({scrollTop: top}, 1000);
            }
        });

        /*
  var map_center = new google.maps.LatLng(<?php // echo $company->getLocation()->getLatitude() ?>, <?php // echo $company->getLocation()->getLongitude() ?>);

  var myOptions = {
      center: map_center,
      zoom: 14,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      streetViewControl: true
  };

  var map = new google.maps.Map(document.getElementById("google_map"), myOptions);

  var marker = new google.maps.Marker ({
    map: map,
    position: map_center,
    title: '<?php echo $company->getCompanyTitle() ?>',
    icon: '/images/gui/icons/gray_small_marker_'+<?php echo $company->getSectorId() ?>+'.png'
  });
         */

        point = new google.maps.LatLng(<?php echo $company->getLocation()->getLatitude() ?>, <?php echo $company->getLocation()->getLongitude() ?>);
        map.map.markers = new google.maps.Marker({
            title: <?php echo json_encode($company->getCompanyTitle()) ?>,
            map: map.map,
            draggable: false,
            position: point,
            icon: new google.maps.MarkerImage('/images/gui/icons/gray_small_marker_'+<?php echo $company->getSectorId() ?>+'.png', null, null, null, new google.maps.Size(40,40))
        });
        map.map.setZoom(17);    
        map.map.setCenter(point);
        

        $('a.gallery_tab').click(function() {
            $('.gallery_tab_content').hide();
            $('.gallery_tab').removeClass('gallery_tab_current');
            $('.'+ this.rel).show();
            $(this).addClass('gallery_tab_current');
            google.maps.event.trigger(map, 'resize');
            map.setCenter(map_center);
            return false;
        });

        $('.tu_switch').click(function() {
            if($(this).hasClass('off'))
            {
                $('#google_map').show();
                $('#tu_map').hide();
                google.maps.event.trigger(map, 'resize');
            }
            else
            {
                $('#google_map').hide();
                $('#tu_map').show();
            }
            $('#ct_map').hide();
            $(this).toggleClass('off');
            return false;
        })

        $('.ct_switch').click(function() {
            if($(this).hasClass('off'))
            {
                $('#google_map').show();
                $('#ct_map').hide();
                google.maps.event.trigger(map, 'resize');
            }
            else
            {
                $('#google_map').hide();
                $('#ct_map').show();
            }
            $('#tu_map').hide();
            $(this).toggleClass('off');
            return false;
        });

        //*CLOSE DROPDOWN ON ANYWHERE CLICK
        $(':not(.add_photo_wrap)').click(function (event) {
            if ($(event.target).closest('.add_photo_wrap').get(0) == null) {
                $('#add_photo_wrap').slideUp('fast', function () {
                    $('.photo_dropdown_wrap').removeClass('photo_dropdown_wrap_opened');
                    $('#add_photo_wrap').removeAttr('style');
                });

            }
            ;

        });
        $(':not(.add_list_wrap)').click(function (event) {
            if (($(event.target).closest('.add_list_wrap').get(0) == null) && (($(event.target).closest('.ui-autocomplete').get(0) == null))) {
                $('#add_list_wrap').slideUp('fast', function () {
                    $('.list_dropdown_wrap').removeClass('list_dropdown_wrap_opened');
                    $('#add_list_wrap').removeAttr('style');
                });


            }
            ;
        });
        if (!$('.place_user_actions').hasClass('report_success2')) {
    setTimeout(function() {
             $(".report_success2").fadeOut().empty();
             }, 8000);
  }
        $('.add_photo').click(function() {
            if ($('.photo_dropdown_wrap').hasClass('photo_dropdown_wrap_opened')) {
                $('#add_photo_wrap').toggle('fast', function() {
                    $('.photo_dropdown_wrap').removeClass('photo_dropdown_wrap_opened');
                    $('#add_photo_wrap').removeAttr('style');
                });
            }
            else {
                $('.photo_dropdown_wrap').addClass('photo_dropdown_wrap_opened');
                $('.add_photo_wrap').css('left', $('.button_add_photo').position().left);
                $('.photo_dropdown_wrap_opened .mask').css('top', '+60px');
                $('.photo_dropdown_wrap_opened .add_photo_wrap').css('top', '+60px');
                $('.photo_dropdown_wrap .mask').css('left', $('.button_add_photo').position().left);
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
                        $('#add_photo_wrap').css("padding", "22px 16px");
                        $('#add_photo_wrap').prepend('<a id="picture_form_close" href="#"><img alt="close" src="/images/gui/close_small.png" /></a>');
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
                $('.list_dropdown_wrap_opened .mask').css('top', '+50px');
                $('.list_dropdown_wrap_opened .add_list_wrap').css('top', '+50px');
                $('.list_dropdown_wrap .mask').css('left', $('.button_add_list').position().left);
                $.ajax({
                    url: this.href,
                    beforeSend: function() {
                        $('#add_list_wrap').html('');
                        $('#add_list_wrap').append('<div style="width:111px;"><img style="display:block" src="/images/gui/pink_loader.gif" /></div>');
                        $('#add_list_wrap').show();
                    },
                    success: function(data) {
                        $('#add_list_wrap').html(data);
                          $('#add_list_wrap').css("padding", "22px 16px");
                        $('#add_list_wrap').prepend('<a id="list_form_close" href="#"><img alt="close" src="/images/gui/close_small.png" /></a>');
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
            });
            return false;
        });

        if ($('.flash_error').length > 0) {
            var top = $('#add_review_container').offset().top - 60;
            $('html,body').scrollTop(top);
        }


        var max_desc_height = 64;
        var desc_height = $('.place_desc > span').outerHeight() + 12;
        if ($('.place_desc span').outerHeight() > max_desc_height)
        {
            $('.place_desc span').css('height', max_desc_height);
            $('.place_desc a.show_desc').css('display', 'block');
        }

        $('.place_desc > a').click(function() {
            $('.place_desc > a').toggle('fast');
            if ($(this).hasClass('show_desc'))
                $('.place_desc span').animate({"height": desc_height});
            else
                $('.place_desc span').animate({"height": max_desc_height});
            return false;
        });

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

        //redirectTo

        function check(w) {
            w.focus();
            return false;
        }

        $('a.web').click(function() {
            var href= '<?php echo url_for('company/redirectTo?slug=' . $company->getSlug()) ?>';
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
            var href= '<?php echo url_for('company/redirectToFacebook?slug=' . $company->getSlug()) ?>';
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
            var href= '<?php echo url_for('company/redirectToTwitter?slug=' . $company->getSlug()) ?>';
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
            var href= '<?php echo url_for('company/redirectToFoursquare?slug=' . $company->getSlug()) ?>';
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
            var href= '<?php echo url_for('company/redirectToGooglePlus?slug=' . $company->getSlug()) ?>';
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
            var href= '<?php echo url_for('company/redirectToYellowPagesRS?slug=' . $company->getSlug()) ?>';
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
</script>
