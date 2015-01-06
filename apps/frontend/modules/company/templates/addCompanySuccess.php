<?php 
    $lng = mb_convert_case(getlokalPartner::getLanguageClass(), MB_CASE_LOWER, 'UTF-8'); 
    $tab_lng = sfConfig::get('app_cultures_en_' . $lng);
?>

<?php $current_culture = sfContext::getInstance()->getUser()->getCulture(); ?>
<?php $languages = sfConfig::get('app_languages_' . $lng) ?>
<?php $userCountry = myTools::getUserCountry(); ?>
<?php $campaignCountry = false; ?>
<?php $countries = sfConfig::get('app_domain_slugs_old'); ?>

<div class="slider_wrapper pp">
    <div class="slider-image">
        <div class="dim"></div>
    </div>
    <div class="slider-separator"></div>
</div><!-- slider_wrapper -->

<div class="container set-over-slider" id="success-msg" style="display: none;">
    <div class="row">
        <div class="container">
            <div class="row">
                <h3 class="col-xs-12 main-form-title"><?php echo __('Thank you', null, 'company'); ?></h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="default-container default-form-wrapper col-sm-12">
            <div>
                <h3><?php echo __('You can now find ', null, 'company'); ?><a id="added_company"></a><?php echo __(' in Getlokal!', null, 'company'); ?></h3>
            </div>
            <p><?php echo __('Be the first one to add a photo, write a review or create an event for ', null, 'company'); ?> <span id="company_title"></span></p>
            <div id="actions">
 
                <?php echo link_to('<i class="fa fa-plus"></i>' . __('Add more places', null, 'company'), 'company/addCompany', array('id' => 'add-more', 'class' => 'default-btn success')); ?>
                

                <span class="or"><?php echo __('or', null, 'messages'); ?></span>
                <a id="to-profile" class="default-btn"> <?php echo __('See place profile', null, 'company'); ?><i class="fa fa-long-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="container set-over-slider" id="add_company_form_wrap">
    <div class="row">
        <div class="container">
            <div class="row">
                <h3 class="col-xs-12 main-form-title"><?php echo __('Add a place', null, 'company'); ?></h1>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="default-container default-form-wrapper col-sm-12 boxesToBePulledDown">

            <?php if ($sf_user->getFlash('newerror')) { ?>
                <div class="form-message error">
                    <p><?php echo __($sf_user->getFlash('newerror'), null, 'company'); ?></p>
                </div>
            <?php } ?>

            <form id ="addCompanyForm" action="<?php echo url_for('company/addCompany'); ?>" method="post" class="right"> 

                <div id="add-place-loading"></div>  
                <?php echo $form['company_location']['latitude']->render() ?>
                <?php echo $form['company_location']['longitude']->render() ?>
                <?php echo $form['company_location']['sublocation']->render() ?>
                <?php echo $form['_csrf_token']->render() ?>

                <h2 class="form-title"><?php echo __('Place Name', null, 'form'); ?></h2>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="default-input-wrapper required <?php echo $form[$lng]['title']->hasError() ? 'incorrect' : '' ?>">
                            <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                            <label for="name" class="default-label"><?php echo __($tab_lng, null, 'company') ?></label>
                            <?php echo $form[$lng]['title']->render(array('placeholder' => $form[$lng]['title']->renderPlaceholder(), 'class' => 'default-input')); ?>
                            <div class="error-txt"><?php echo $form[$lng]['title']->renderError() ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="default-input-wrapper <?php echo $form['en']['title']->hasError() ? 'incorrect' : '' ?>">
                            <label for="name-EN" class="default-label"><?php echo __('English') ?></label>
                            <?php echo $form['en']['title']->render(array('placeholder' => __('Name in English', null, 'list'), 'class' => 'default-input')); ?>
                            <div class="error-txt"><?php echo $form['en']['title']->renderError() ?></div>
                        </div>
                    </div>
                </div>

                <h2 class="form-title"><?php echo __('Classification', null, 'form'); ?></h2>
                <p class="form-description"><?php echo __('Start typing the place type e.g. ‘restaurant’ or ‘hairdressers’ and select the most appropriate category for the place you’re adding', null, 'company') ?></p>
                <div class="row">
                    <div class="col-sm-8 col-md-9 col-lg-10">
                        <div class="default-input-wrapper required add_field <?php echo $form['classification_id']->hasError() ? 'error' : '' ?>">
                            <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                            <?php echo $form['classification']->renderLabel(null, array('class' => 'default-label')) ?>

                            <div class="limit_error classification_limit" style="display:none">
                                <p><?php echo __('You can add up to 5 classifications!', null, 'company'); ?></p>
                            </div>

                            <?php echo $form['classification']->render(array('placeholder' => __('E.g. restaurant'), 'class' => 'default-input')); ?>
                            <div class="error-txt"><?php echo $form['classification_id']->renderError() ?></div>
                            <?php echo $form['sector_id']->render() ?>
                            <?php echo $form['classification_id']->render() ?>
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-3 col-lg-2">
                        <input class="default-btn success" id="add_classification" type="button" value="<?php echo __('Add Classification', null, 'company'); ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                          <div class="added_items" id="list_of_classifications" <?php echo!isset($classification_list_id) ? ('style="display:none"') : '' ?>>
                          <ul class="tag-wrapper added_classifications">
                            <?php if (isset($classification_list_id)) : ?>
                                <?php foreach ($classification_list_id as $key => $cll): ?>
                                     <li class="tag added_item">
                                        <?php echo $classification_list_title[$key]; ?>
                                         <a><i class="close"></i></a>
                                        <input type="hidden" name="company[classification_list_title][]" id="classification_list_title_<?php echo $cll; ?>" value="<?php echo $classification_list_title[$key]; ?>">
                                        <input type="hidden" name="company[classification_list_id][]" id="classification_list_id_<?php echo $cll; ?>" value="<?php echo $cll; ?>">
                                        <input type="hidden" name="company[sector_list_id][]" id="sector_list_id_<?php echo $sector_list_id[$key]; ?>" value="<?php echo $sector_list_id[$key]; ?>">
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <h2 class="form-title"><?php echo __('Address and location', null, 'company') ?></h2>
                <p class="form-description"><?php echo __('<span class="regular">Start typing the </span><span class="highlight">place address</span> <span class="regular"> and a marker will be placed on the map.</span>', null, 'company'); ?></p>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="default-input-wrapper required <?php echo $form['country_id']->hasError() ? 'incorrect' : '' ?>">
                            <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                            <?php echo $form['country']->renderLabel(null, array('class' => 'default-label')) ?>
                            <?php echo $form['country']->render(array('placeholder' => $form['country']->renderPlaceholder(), 'class' => 'default-input')); ?>
                            <?php echo $form['country_id']->render(); ?>
                            <div class="error-txt"><?php echo $form['country_id']->renderError() ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="default-input-wrapper <?php echo $form['city_id']->hasError() ? 'incorrect' : '' ?>">
                            <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                            <?php echo $form['city']->renderLabel(null, array('class' => 'default-label')) ?>
                            <?php echo $form['city']->render(array('placeholder' => $form['city']->renderPlaceholder(), 'class' => 'default-input')); ?>
                            <?php echo $form['city_id']->render(); ?>
                            <div class="error-txt"><?php echo $form['city_id']->renderError() ?></div>
                        </div>
                    </div>
                </div>
     
                <div class="row">
                    <div class="col-sm-2">
                        <div class="default-input-wrapper select-wrapper required <?php echo $form['company_location']['street_type_id']->hasError() ? 'incorrect' : '' ?>">
                            <?php echo $form['company_location']['street_type_id']->render(array('value' => 1, 'class' => 'default-input')); ?>
                            <div class="error-txt"><?php echo $form['company_location']['street_type_id']->renderError() ?></div>
                        </div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9">
                        <div class="default-input-wrapper <?php echo $form['company_location']['street']->hasError() ? 'incorrect' : '' ?>">
                            <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                            <?php echo $form['company_location']['street']->renderLabel(null, array('class' => 'default-label')) ?>
                            <?php echo $form['company_location']['street']->render(array('placeholder' => __('Street', null, 'company'), 'class' => 'default-input')); ?>
                            <div class="error-txt"><?php echo $form['company_location']['street']->renderError() ?></div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-2 col-lg-1">
                        <div class="default-input-wrapper <?php echo $form['company_location']['street_number']->hasError() ? 'incorrect' : '' ?>">
                            <?php echo $form['company_location']['street_number']->renderLabel(null, array('class' => 'default-label')) ?>
                            <?php echo $form['company_location']['street_number']->render(array('placeholder' => __('Number', null, 'company'), 'class' => 'default-input')); ?>
                            <div class="error-txt"><?php echo $form['company_location']['street_number']->renderError() ?></div>
                        </div>
                    </div>
                </div>
                <p class="form-description"><?php echo __('If you type in the address – street name and number - the position of the market showing where the place is will change. If the positioning doesn’t seem correct you can move the marker. This will not change the address you’ve already written.', null, 'company') ?></p>

                <div class="row">
                    <div class="col-sm-12">
                        <section class="map-container no-padding-top">
                            <div id="map_canvas"></div>
<!--                             <div class="map_navigation">
                                <div class="bottom right">
                                    <a class="nav_arrow" href="#"><img src="/images/gui/icon_enlarge.png" /><?php echo __('Larger'); ?></a>
                                    <a class="nav_arrow" style="display:none" href="#"><img src="/images/gui/icon_reduce.png" /><?php echo __('Smaller'); ?></a>
                                </div>
                            </div> -->
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="custom-row toggle-row show-more address-click" lang="expandable">
                            <div class="center-block txt-more">
                                <i class="fa fa-angle-double-down fa-lg"></i>
                                <span id="address-info"><?php echo __('More address info', null, 'company'); ?></span>
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

                <div id="expandable">
                    <?php if (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_BG){ ?>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="default-input-wrapper select-wrapper <?php echo $form['company_location']['location_type']->hasError() ? 'incorrect' : '' ?>">
                                <?php echo $form['company_location']['location_type']->render(array('value' => 2, 'class' => 'default-input')); ?>
                                <div class="error-txt"><?php echo $form['company_location']['location_type']->renderError() ?></div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="default-input-wrapper <?php echo $form['company_location']['neighbourhood']->hasError() ? 'incorrect' : '' ?>">
                                <?php echo $form['company_location']['neighbourhood']->renderLabel(null, array('class' => 'default-label')) ?>
                                <?php echo $form['company_location']['neighbourhood']->render(array('placeholder' => __('Neighbourhood', null, 'form'), 'class' => 'default-input')); ?>
                                <div class="error-txt"><?php echo $form['company_location']['neighbourhood']->renderError() ?></div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="default-input-wrapper <?php echo $form['company_location']['building_no']->hasError() ? 'incorrect' : '' ?>">
                                <?php echo $form['company_location']['building_no']->renderLabel(null, array('class' => 'default-label')) ?>
                                <?php echo $form['company_location']['building_no']->render(array('placeholder' => __('Bl.', null, 'list'), 'class' => 'default-input')); ?>
                                <div class="error-txt"><?php echo $form['company_location']['building_no']->renderError() ?></div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="default-input-wrapper required <?php echo $form['company_location']['address_info']->hasError() ? 'incorrect' : '' ?>">
                                <?php echo $form['company_location']['address_info']->renderLabel(null, array('class' => 'default-label')) ?>
                                <?php echo $form['company_location']['address_info']->render(array('placeholder' => __('Is this place easy to find? Add directions if necessary.', null, 'company'), 'class' => 'default-input')); ?>
                                <div class="error-txt"><?php echo $form['company_location']['address_info']->renderError() ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="form-title"><?php echo __('Contacts', null, 'contact') ?></h2>
                <p class="form-description"><?php echo __('The correct format to use is 023456789 or for mobile phones 0888888888. Add only the local area code for landlines. Only add digits – any other characters or spaces between characters are not allowed.', null, 'company') ?></p>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="default-input-wrapper <?php echo $form['phone']->hasError() ? 'incorrect' : '' ?>">
                            <?php echo $form['phone']->renderLabel(null, array('class' => 'default-label')) ?>
                            <?php echo $form['phone']->render(array('placeholder' => __('Phone', null, 'form'), 'class' => 'default-input')); ?>
                            <div class="error-txt"><?php echo $form['phone']->renderError() ?></div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="default-input-wrapper <?php echo $form['website_url']->hasError() ? 'incorrect' : '' ?>">
                            <?php echo $form['website_url']->renderLabel(null, array('class' => 'default-label')) ?>
                            <?php echo $form['website_url']->render(array('placeholder' => __('Website'), 'class' => 'default-input')); ?>
                            <div class="error-txt"><?php echo $form['website_url']->renderError() ?></div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="default-input-wrapper <?php echo $form['email']->hasError() ? 'incorrect' : '' ?>">
                            <?php echo $form['email']->renderLabel(null, array('class' => 'default-label')) ?>
                            <?php echo $form['email']->render(array('placeholder' => __('E-mail'), 'class' => 'default-input')); ?>
                            <div class="error-txt"><?php echo $form['email']->renderError() ?></div>
                        </div>
                    </div>
                </div>

                <?php if ($sf_user->isAuthenticated() && isset($form['page_admin'])){ ?>
                <div class="trigger center-block txt-more owner-global">
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="owners-details" class="custom-row toggle-row show-more address-click" lang="owners-company-info">
                                    <div class="center-block txt-more">
                                        <i class="fa fa-angle-double-down fa-lg"></i>
                                        <span id="owners-details-error"><?php echo __('Are you the owner?', null, 'company'); ?></span>
                                        <i class="fa fa-angle-double-down fa-lg"></i>
                                    </div>

                                    <div class="center-block txt-less">
                                        <i class="fa fa-angle-double-up fa-lg"></i>
                                        <span><?php echo __('Are you the owner?', null, 'company'); ?></span>
                                        <i class="fa fa-angle-double-up fa-lg"></i>
                                    </div>
                                </div><!-- Form Show-more-less Bar -->
                            </div>
                        </div>
                </div>

                <div id="owners-company-info">
                    <div class="row">
                    <?php if (isset($form['page_admin']['username'])){ ?>
                        <div class="col-sm-6">
                            <div class="default-input-wrapper <?php echo $form['page_admin']['username']->hasError() ? 'incorrect' : '' ?>">
                                <?php echo $form['page_admin']['username']->renderLabel(null, array('class' => 'default-label')) ?>
                                <?php echo $form['page_admin']['username']->render(array('placeholder' => __('Username', null, 'form'), 'class' => 'default-input')); ?>
                                <div class="error-txt"><?php echo $form['page_admin']['username']->renderError() ?></div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($form['page_admin']['password'])){ ?>
                        <div class="col-sm-6">
                            <div class="default-input-wrapper <?php echo $form['page_admin']['password']->hasError() ? 'incorrect' : '' ?>">
                                <?php echo $form['page_admin']['password']->renderLabel(null, array('class' => 'default-label')) ?>
                                <?php echo $form['page_admin']['password']->render(array('placeholder' => __('Password', null, 'form'), 'class' => 'default-input')); ?>
                                <div class="error-txt"><?php echo $form['page_admin']['password']->renderError() ?></div>
                            </div>
                        </div>
                    <?php } ?>
                    </div>

                    <div class="row">
                    <?php if (isset($form['registration_no'])){ ?>
                        <div class="col-sm-6">
                            <div class="default-input-wrapper <?php echo $form['registration_no']->hasError() ? 'incorrect' : '' ?>">
                                <?php echo $form['registration_no']->renderLabel(null, array('class' => 'default-label')) ?>
                                <?php echo $form['registration_no']->render(array('placeholder' => __('Enter your EIK/Bulstat'), 'class' => 'default-input')); ?>
                                <div class="error-txt"><?php echo $form['registration_no']->renderError() ?></div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($form['page_admin']['position'])){ ?>
                        <div class="col-sm-6">
                            <div class="default-input-wrapper select-wrapper <?php echo $form['page_admin']['position']->hasError() ? 'incorrect' : '' ?>">
                                <?php echo $form['page_admin']['position']->render(array('class' => 'default-input')); ?>
                                <div class="error-txt"><?php echo $form['page_admin']['position']->renderError() ?></div>
                            </div>
                        </div>
                    <?php } ?>
                    </div>

                    <div class="row">
                    <?php if (isset($form['page_admin']['user_profile']['phone_number'])){ ?>
                        <div class="col-sm-6">
                            <div class="default-input-wrapper <?php echo $form['page_admin']['user_profile']['phone_number']->hasError() ? 'incorrect' : '' ?>">
                                <?php echo $form['page_admin']['user_profile']['phone_number']->renderLabel(null, array('class' => 'default-label')) ?>
                                <?php echo $form['page_admin']['user_profile']['phone_number']->render(array('placeholder' => __('Phone', null, 'form'), 'class' => 'default-input')); ?>
                                <div class="error-txt"><?php echo $form['page_admin']['user_profile']['phone_number']->renderError() ?></div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($form['page_admin']['user_profile']['gender'])){ ?>
                        <div class="col-sm-6">
                            <div class="default-input-wrapper select-wrapper <?php echo $form['page_admin']['user_profile']['gender']->hasError() ? 'incorrect' : '' ?>">
                                <?php echo $form['page_admin']['user_profile']['gender']->render(array('class' => 'default-input')); ?>
                                <div class="error-txt"><?php echo $form['page_admin']['user_profile']['gender']->renderError() ?></div>
                            </div>
                        </div>
                    <?php } ?>
                    </div>

                    <div class="row margin-bottom">
                        <div class="col-sm-12">
                        <?php if (isset($form['page_admin']['allow_b_cmc'])): ?>
                            <div class="custom-row">
                                <div class="default-checkbox <?php echo $form['page_admin']['allow_b_cmc']->hasError() ? 'incorrect' : '' ?>">
                                    <?php echo $form['page_admin']['allow_b_cmc']->render(array('class' => 'checkbox')); ?>
                                    <div class="fake-box"></div>
                                    <div class="error-txt"><?php echo $form['page_admin']['allow_b_cmc']->renderError() ?></div>
                                </div>
                                <label class="default-checkbox-label"><?php echo __("I would like to receive Getlokal's Business Newsletter and Notifications.", null, 'company'); ?></label>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>

                    <div class="row margin-bottom">
                        <div class="col-sm-12">
                        <?php if (isset($form['page_admin']['accept'])){ ?>
                            <div class="custom-row">
                                <div class="default-checkbox <?php echo $form['page_admin']['accept']->hasError() ? 'incorrect' : '' ?>">
                                    <?php echo $form['page_admin']['accept']->render(array('class' => 'checkbox')); ?>
                                    <div class="fake-box"></div>
                                    <div class="error-txt"><?php echo $form['page_admin']['accept']->renderError() ?></div>
                                </div>
                                <label class="default-checkbox-label"><?php echo sprintf(__('I have the necessary representative powers and agree with the %s and the %s'), link_to(__('Terms of Use'), '@static_page?slug=terms-of-use', array('popup' => true)), link_to(__('Policy for Use and Protection of the Information of Getlokal'), '@static_page?slug=privacy-policy', array('popup' => true))); ?></label>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <h2 class="form-title"><?php echo __('Social networks', null, 'company') ?></h2>
                <p class="form-description"><?php echo __("Let's link the place with its other online profiles!", null, 'company'); ?></p>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="default-input-wrapper <?php echo $form['facebook_url']->hasError() ? 'incorrect' : '' ?>">
                            <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                            <div class="error-txt"><?php echo $form['facebook_url']->renderError() ?></div>
                            <label for="Facebook" class="default-label">Facebook</label>
                            <?php echo $form['facebook_url']->render(array('placeholder' => __('http://www.facebook.com/page-name', null, 'company'), 'class' => 'default-input')); ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="default-input-wrapper <?php echo $form['googleplus_url']->hasError() ? 'incorrect' : '' ?>">
                            <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                            <div class="error-txt"><?php echo $form['googleplus_url']->renderError() ?></div>
                            <label for="town" class="default-label">Google Plus</label>
                            <?php echo $form['googleplus_url']->render(array('placeholder' => __('https://plus.google.com/page-id', null, 'company'), 'class' => 'default-input')); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="default-input-wrapper <?php echo $form['twitter_url']->hasError() ? 'incorrect' : '' ?>">
                            <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                            <label for="town" class="default-label">Twitter</label>
                            <div class="error-txt"><?php echo $form['twitter_url']->renderError() ?></div>
                            <?php echo $form['twitter_url']->render(array('placeholder' => __('@Twitter handle', null, 'company'), 'class' => 'default-input')); ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="default-input-wrapper <?php echo $form['foursquare_url']->hasError() ? 'incorrect' : '' ?>">
                            <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                            <label for="town" class="default-label">Foursquare</label>
                            <div class="error-txt"><?php echo $form['foursquare_url']->renderError() ?></div>
                            <?php echo $form['foursquare_url']->render(array('placeholder' => __('Foursquare place URL', null, 'company'), 'class' => 'default-input')); ?>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="geocode" name="geocode" value="">
                
                <input class="default-btn success pull-right " type="submit" value="<?php echo __('Send') ?>">
 
            </form>
        </div>

    </div><!-- END default-form-wrapper -->
</div>

<p hidden id="class-url"><?php echo url_for('company/autocompleteClassification') ?></p>
<p hidden id="city-url"><?php echo url_for('user/getCitiesAutocomplete') ?></p>
<p hidden id="country-url"><?php echo url_for('user/getCountriesAutocomplete') ?></p>


<script>

setTimeout(function(){
$('#company_page_admin_username').val('');
$('#company_page_admin_password').val('');
}, 1000);
    
</script>

<?php $company = $form->getObject(); ?>
<script type="text/javascript">

    setCountry();

    setTimeout(function(){
        $('#company_page_admin_username').val('');
        $('#company_page_admin_password').val('');  
    },1000)

    <?php if (isset($clear_class_id) && $clear_class_id): ?>
        $("#company_classification_id").val('');
        $("#company_sector_id").val('');
    <?php endif; ?>

lat = $('#company_company_location_latitude').val()? $('#company_company_location_latitude').val(): '<?php echo $sf_user->getCity()->getLat() ?>';
lng = $('#company_company_location_longitude').val()? $('#company_company_location_longitude').val(): '<?php echo $sf_user->getCity()->getLng() ?>';

<?php if ($sf_user->getCountry()->getSlug() == 'ro'): ?>
        var listarraynei = {};
                var listarray = {
                'Bulevardul' : 1,
                        'Cartier' : 2,
                        'Strada' : 6,
                        'Calea' : 10,
                        'Prelungirea' : 12,
                        'Piata': 5,
                        'Drumul' : 14,
                        'Intrarea' : 7,
                        'И�oseaua' : 17,
                        'Aleea' : 18
                };
<?php elseif ($sf_user->getCountry()->getSlug() == 'bg'): ?>
        var listarray = {
        'булевард' : 1,
                'улица' : 6,
                'площад' : 5,
                'шосе': 17,
                'bulevard' : 1,
                'ulitsa' : 6,
                'ploshtad' : 5

        };
                var listarraynei = {
                'жк' : 2,
                        'кв.' : 3,
                        'м.': 4,
                        'п.к.' : 7,
                        'к-с': 8
                }
<?php else: ?>
        var listarraynei = {};
                //var listarray = {};
                var listarray = new Array();
    <?php $phpArray = CompanyLocation::$street_types; ?>

        listarray = {
    <?php foreach ($phpArray as $kay => $arr) : ?>
            "<?php echo $arr ?>" : <?php echo $kay ?>,
    <?php endforeach; ?>
        }
<?php endif ?>


    var is_dragged = false, is_entered = false;
            var map_center = new google.maps.LatLng(lat, lng);
            var myOptions = {
 //           center: map_center,
                    zoom: 14,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    streetViewControl: true

            };
            var geocoder = new google.maps.Geocoder();
            var map_company = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

            var marker = new google.maps.Marker({
            map: map_company,
//                    position: map_center,
                    draggable: true,
                    title: '<?php echo $company->getCompanyTitle() ?>',
                    icon: new google.maps.MarkerImage('/images/gui/icons/pin.svg', null, null, null, new google.maps.Size(35, 40))

            });

            geocoder.geocode({ 'address': $('#company_country').val(), bounds: map_company.getBounds()}, function(results, status) {
            if (status != google.maps.GeocoderStatus.OK) return;

                <?php if(in_array(strtolower($userCountry['slug']), $countries) || $userCountry['slug'] == ''): ?>
                    map_company.setCenter(map_center);
                    marker.setPosition(map_center);
                    var lat = $('#company_company_location_latitude').val()? $('#company_company_location_latitude').val(): '<?php echo $sf_user->getCity()->getLat() ?>';
                    var lng = $('#company_company_location_longitude').val()? $('#company_company_location_longitude').val(): '<?php echo $sf_user->getCity()->getLng() ?>';
                <?php else: ?>
                    map_company.setCenter(results[0].geometry.location);
                    marker.setPosition(results[0].geometry.location);
                    var lat = marker.getPosition().lat();
                    var lng = marker.getPosition().lng();
                <?php endif; ?>

                var map_center_offset = new google.maps.LatLng(lat, lng);
                setTimeout(function() { map_company.panToWithOffset(map_center_offset, 0, - 110); }, 1000);
            });


            infoBubble_default = new google.maps.InfoWindow({
            //  map: map,

            content: '<p><?php echo __('<span class="regular">If you do not know the address, just</span><span class="highlight"> drag the marker</span><span class="regular"> to where you know the place is and</span><span class="highlight"> we will get the address</span><span class="regular"> details.</span>', null, 'company'); ?></p>',
                    shadowStyle: 10,
                    padding: '10px',
                    backgroundColor: '#fff',
                    borderRadius: 0,
                    maxWidth: 330,
                    minHeight:90,
                    disableAnimation : true,
                    arrowSize: 10,
                    //    borderWidth:1,
                    borderColor: '#a1a1a1',
                    disableAutoPan: false,
                    hideCloseButton: false,
                    arrowPosition: 55,
                    backgroundClassName: 'pin_hint',
                    //  pixelOffset: new google.maps.Size(200, 200),
                    arrowStyle: 0

            });
            infoBubble_default.setPosition(marker.getPosition());
            infoBubble_default.open(map_company, marker);
            google.maps.event.addListener(marker, 'click', function() {
            infoBubble_default.open(map_company, marker);
            });
            infoBubble_iftyping = new google.maps.InfoWindow({
            //  map: map,
            content: '<p><?php echo __('<span class="highlight">If the marker is not in the right location</span><span class="regular"> on the map you can move it. We</span><span class="highlight"> will not change the address details</span><span class="regular"> in the form.</span>', null, 'company'); ?></p>',
                    // position: marker,
                    shadowStyle: 10,
                    padding: '20px',
                    backgroundColor: '#fff',
                    borderRadius: 0,
                    maxWidth: 330,
                    minHeight:90,
                    disableAnimation : true,
                    arrowSize: 10,
                    //      borderWidth:1,
                    borderColor: '#a1a1a1',
                    disableAutoPan: false,
                    hideCloseButton: false,
                    arrowPosition: 55,
                    backgroundClassName: 'pin_hint',
                    //  pixelOffset: new google.maps.Size(200, 200),
                    arrowStyle: 0

            });
            $('#company_company_location_street').keyup(function() {

    infoBubble_default.close();
            infoBubble_iftyping.setPosition(marker.getPosition());
            infoBubble_iftyping.open(map_company, marker);
            google.maps.event.addListener(marker, 'click', function() {
            infoBubble_iftyping.open(map_company, marker);
            });
    });
            google.maps.Map.prototype.panToWithOffset = function(latlng, offsetX, offsetY) {
            var map_company = this;
                    var ov = new google.maps.OverlayView();
                    ov.onAdd = function() {
                    var proj = this.getProjection();
                            var aPoint = proj.fromLatLngToContainerPixel(latlng);
                            aPoint.x = aPoint.x + offsetX;
                            aPoint.y = aPoint.y + offsetY;
                            map_company.panTo(proj.fromContainerPixelToLatLng(aPoint));
                    };
                    ov.draw = function() {};
                    ov.setMap(this);
            };
//            var map_center_offset = new google.maps.LatLng(lat, lng);
//            setTimeout(function() { map.panToWithOffset(map_center_offset, 0, - 110); }, 1000);
            function setFocus()
            {
            document.getElementById("company_company_location_street").focus();
            }
    google.maps.event.addListener(marker, 'dragend', function() {
    is_dragged = true;
            var caa = '';
            if (is_dragged){
    setFocus();
            $(".location-hint p").removeClass('fade-in');
            $(".location-hint p").addClass('fade-out');
            setTimeout(function() {
            $(".location-hint p").html('<p><?php echo __('<span class="regular">You positioned the marker</span><span class="highlight"> to where the place is. If the details we filled in based on the location are not correct</span><span class="regular"> you can change the address in the form.</span>', null, 'company'); ?></p>')
                    .addClass('fade-in');
            }, 1000);
            map_company.setCenter(marker.getPosition());
            setTimeout(function() { map_company.panToWithOffset(marker.getPosition(), 0, - 110); }, 1);
    }


    //if(is_entered) return;

    geocoder.geocode({ 'latLng': marker.getPosition(), 'language': 'bg'}, function(results, status) {
    if (status != google.maps.GeocoderStatus.OK) return;
            if (!is_entered){
    $(results[0].address_components).each(function(i, s) {

    if (s.types[0] == 'street_number'){
    $('#company_company_location_street_number').val(s.long_name);
    } else if (s.types[0] == 'route')
    {
    var str = s.long_name;
            firstword = str.split(" ", 1);
            caa = firstword[0];
            rest = str.replace(caa, '');
            if (listarray[caa] != undefined){
    $('#company_company_location_street_type_id').val(listarray[caa]);
            $('#company_company_location_street').val(rest);
            $('#company_company_location_location_type').val('');
            $('#company_company_location_neighbourhood').val('');
            $('#company_company_location_building_no').val('');
            $('#company_company_location_sublocation').val(s.long_name);
    } else if (listarraynei[caa] != undefined){
    $('#company_company_location_location_type').val(listarraynei[caa]);
            $('#company_company_location_neighbourhood').val(rest);
            $('#company_company_location_street').val('');
            $('#company_company_location_street_type_id').val('');
            $('#company_company_location_street_number').val('');
            $('#company_company_location_sublocation').val(s.long_name);
    } else{
    $('#company_company_location_street').val(s.long_name);
            $('#company_company_location_sublocation').val(s.long_name);
    }

    } else if (s.types[0] == 'postal_code'){
    $('#company_company_location_postcode').val(s.long_name);
    } else if (s.types[0] == 'locality'){
    $('#autocomplete_company_city_id').val(s.long_name);
            $('#company_city').val(s.long_name);
    } else if (s.types[0] == 'country'){
    $('#autocomplete_company_country_id').val(s.long_name);
            $('#company_country').val(s.long_name);
    }

    })
    }
    $('#company_company_location_latitude').val(marker.getPosition().lat());
            $('#company_company_location_longitude').val(marker.getPosition().lng());
    });
    });
            
    $('#company_company_location_street, #company_company_location_street_type, #company_company_location_street_number').change(function() {
        is_entered = true;
        if(is_dragged) return;

    var list = {};
            for (var i in listarray) {
    list[listarray[i]] = i;
    };
            //console.log(list,listarray);

            //var selected = list[$('#company_company_location_street_type_id')[0].selectedIndex];

            var selected = list[$('#company_company_location_street_type_id').val()];
            //console.log(selected);


            geocoder.geocode({ 'address': $('#company_company_location_street').val() + $('#company_company_location_street_number').val() + ", " + $('#company_city').val(), bounds: map_company.getBounds()}, function(results, status) {


            if (status != google.maps.GeocoderStatus.OK) return;
                    map_company.setCenter(results[0].geometry.location);
                    map_company.setZoom(18);
                    setTimeout(function() {
                    map_company.panToWithOffset(marker.getPosition(), 0, - 115);
                    }, 10);
                    marker.setPosition(results[0].geometry.location);
                    var markerLat = marker.getPosition().lat();
                    var markerLong = marker.getPosition().lng();
                    $('#company_company_location_latitude').val(markerLat);
                    $('#company_company_location_longitude').val(markerLong);
                    $("#map_canvas").animate({height:"450px"});
                    $('.bottom.right').children().eq(1).show();
                    $('.bottom.right').children().eq(0).hide();
                    // google.maps.event.trigger(map.map, "resize");
            });
    });
    
//    drag the pin to the selected city
    $('ul.places-list > li').click(function() {
        var list = {};
                for (var i in listarray) {
        list[listarray[i]] = i;
        };
        
        var selected = list[$('#company_company_location_street_type_id').val()];
        geocoder.geocode({ 'address': $('#company_company_location_street').val() + $('#company_company_location_street_number').val() + ", " + $('#company_city').val(), bounds: map_company.getBounds()}, function(results, status) {
        if (status != google.maps.GeocoderStatus.OK) return;
                map_company.setCenter(results[0].geometry.location);
                map_company.setZoom(18);
                setTimeout(function() {
                map_company.panToWithOffset(marker.getPosition(), 0, - 115);
                }, 10);
                marker.setPosition(results[0].geometry.location);
                var markerLat = marker.getPosition().lat();
                var markerLong = marker.getPosition().lng();
                $('#company_company_location_latitude').val(markerLat);
                $('#company_company_location_longitude').val(markerLong);
                $("#map_canvas").animate({height:"450px"});
                $('.bottom.right').children().eq(1).show();
                $('.bottom.right').children().eq(0).hide();
                // google.maps.event.trigger(map.map, "resize");
        });
    });
    
    $('#company_company_location_neighbourhood').change(function() {
        is_entered = true;
        if (is_dragged) return;
        geocoder.geocode({ 'address': $('#company_company_location_location_type option:selected').html() + ' ' + $('#company_company_location_neighbourhood').val() + ", " + $('#company_city').val(), bounds: map_company.getBounds()}, function(results, status) {

        if (status != google.maps.GeocoderStatus.OK) return;
                map_company.setCenter(results[0].geometry.location);
                marker.setPosition(results[0].geometry.location);
                $('#company_company_location_latitude').val(marker.getPosition().lat());
                $('#company_company_location_longitude').val(marker.getPosition().lng());
        });
    });

    // /*Removal of added classification*/
    // $('.added_item a').click(function(){
    //     $(this).parent().remove();  
    //     // if($('#list_of_classifications').children().length==0){
    //     //     setTimeout(function(){
    //     //         $('#list_of_classifications').fadeOut();
    //     //     }, 1200);
    //     // }
    // });

    /*Classification autocomplete*/
    $('#company_classification').autocomplete({
        source: $('#class-url').text(),
        minLength: 2,
        position: {
            of: $('#company_classification').parent()
        },
        select: function( event, ui ) {
            $('#company_classification_id').val(''+ui.item.id);
            $('#company_sector_id').val(''+ui.item.sector_id);
        },
        open: function (event, ui) {
            var menu = $(this).data("uiAutocomplete").menu
            , i = 0
            , $items = $('li', menu.element)
            , item
            , text
            , startsWith = new RegExp("^" + this.value, "i");
            for (; i < $items.length && !item; i++) {
                text = $items.eq(i).text();
                if (startsWith.test(text)) {
                    item = $items.eq(i);
                }
            }
            
            if (item) {
                menu.focus(null, item);
            }
        }
    }).autocomplete( "widget" ).addClass( "classification-autocomplete" );
    // var geocoder = new google.maps.Geocoder();     
       
    /*=-=-Add classifications=-=-*/        
    $("#add_classification").click(function(){
        var classificationLimit=$(".added_classifications li").length;
        if(classificationLimit < 5 && $("#company_classification_id").val()){
            $("#list_of_classifications.added_items").css("display","inline-block");
            $(".added_classifications").append(
                '<li class="tag added_item">'+
                $("#company_classification").val()+
                '<a onclick="$(this).parent().remove()"><i class="close"></i></a>'+
                '<input type="hidden" name="company[classification_list_id][]" id="classification_list_id_'+$("#company_classification_id").val()+'" value="'+$("#company_classification_id").val()+'">'+
                '<input type="hidden" name="company[classification_list_title][]" id="classification_list_title_'+$("#company_classification_id").val()+'" value="'+$("#company_classification").val()+'">'+
                '<input type="hidden" name="company[sector_list_id][]" id="sector_list_id_'+$("#company_sector_id").val()+'" value="'+$("#company_sector_id").val()+'">'+
                '</li>'
                );

            $("#company_classification").val('');
            $("#company_classification_id").val('');
            $("#company_sector_id").val('');
        }
        if(classificationLimit== 5){
            $(".limit_error.classification_limit").css("display","block");
            setTimeout(function(){
                $(".limit_error.classification_limit").fadeOut();
            }, 3000);
        }

    });
    
    /*Map navigation*/
    $(".nav_arrow").click(function() {
        var height = $("#map_canvas").height();
      //  var getCen = map.getCenter();
        if(height<350)
        {
            $("#map_canvas").animate({
                height:"450px"
            });
            $(".nav_arrow").toggle();
        }
        else{
            $("#map_canvas").animate({
                height:"250px"
            });
            $(".nav_arrow").toggle();

        }
        return false;
    });
        
        $('#company_country').autocomplete({
            source: $('#country-url').text(),
            minLength: 2,
            // position: {
            // of: $('#company_country').parent()
            // },
            change: function(event, ui) {
                $('#company_company_location_street').val('');
                $('#company_company_location_street_number').val('');
            setCountry();
            },
            select: function(event, ui) {
            $("#company_city").val('');
                    $("#company_city_id").val('');
                    $('#company_country_id').val(ui.item.id);
                    $('#company_country').val(ui.item.value);
                    var id = ui.item.id;
                    var value = ui.item.value;
                    setCountry(id, value);
                    //            document.getElementById('company_city').disabled = false;
            }
        });


        /*=-=-City autocomplete=-=-*/       
        $('#company_city').autocomplete({
            source: $('#city-url').text(),
            minLength: 2,
            select: function( event, ui ) {
                $('#company_city_id').val(ui.item.id);
                geocoder.geocode( {
                    'address': ui.item.value
                }, function(results, status) {
                    if (status != google.maps.GeocoderStatus.OK) return;

                    map_company.setCenter(results[0].geometry.location);
                    marker.setPosition(results[0].geometry.location);

                    $('#company_company_location_latitude').val(marker.getPosition().lat());
                    $('#company_company_location_longitude').val(marker.getPosition().lng());
                });

                    setCity(ui.item.id, ui.item.value);
            },
            change: function(event, ui) {
                setCity();
                $('#company_company_location_street').val('');
                $('#company_company_location_street_number').val('');
            }
        });

        $('#addCompanyForm').submit(function(){

            $.ajax({
                url:'http://maps.googleapis.com/maps/api/geocode/json?address=' + $('#company_city').val() + ',' + $('#company_country').val() + 'sensor=false',
                async: false,
                type: "GET",
                success:function(result){
                    if(result.status == "ZERO_RESULTS"){
                      console.log('Zero results');
                    } else{
                        var coodinates = result.results[0].geometry.location;
                        var lat = coodinates.lat;
                        var lng = coodinates.lng;
                        var addresses = result.results[0].address_components;
                        var city_en = findThis("locality", addresses);
                        var county_en = findThis("administrative_area_level_1", addresses);

                        if(county_en == '' || county_en == undefined){
                            county_en = findThis("administrative_area_level_2", addresses);

                            if(county_en == '' || county_en == undefined){
                                county_en = findThis("administrative_area_level_3", addresses);
                            }
                        }
                        var country_en = findThis("country", addresses);

                        $('#geocode').val(lat + ',' + lng + ',' + city_en + ',' + county_en + ',' + country_en);
                    }
                },
                error: function(){
                    console.log('error');
                }
            });//end ajax

            var element = $(this).parent().parent().parent();
            $.ajax({
                url: $("#addCompanyForm").attr('action'),
                cache: false,
                type: 'POST',
                data: $(this).serialize(),
                beforeSend: function(data) {
                     $('html, body').animate({
                        scrollTop: 0
                    }, 100);   
                    $('#add-place-loading').html(LoaderHTML);
                }, 
                success: function(data, url) {
                    try {
                        var json = jQuery.parseJSON(data);
                        $('#add_company_form_wrap').hide();
                        $('#added_company, #to-profile').attr("href", json.url);
                        $('#added_company').text(json.title);
                        $('#company_title').text(json.title);
                        $('#success-msg').css('display', 'block');
                    } catch(error) {
                        $('.page_wrap').addClass('centered');
                        $('.content_wrap').addClass('appended').html(data);
                    } 

                    $('#add_company_form_wrap').html(data);

                    if($("#owners-company-info .error_list").length > 0){
                        $("#owners-company-info").slideDown();  
                    }

                    $("#address-info").click(function(){
                        $('#expandable').slideToggle("fast");
                    });

                    $("#owners-details-error").click(function(){
                        $('#owners-company-info').slideToggle("fast");
                    });

                },
                error: function(e, xhr)
                {
                  console.log(e);
                }
            });
            return false;

        });

        function findThis(type, address){
            for(var i = 0; i < address.length; i++){
                if(address[i].types[0] == type){
                    return address[i].long_name;
                }
            }
        }

        function setCountry(cId, cName) {
            var countryId = countryName = null;
                    if (cId && cName) {
            countryId = cId;
                    countryName = cName;
            }
            else {
            countryId = $("#company_country_id").val();
                    countryName = $("#company_country").val();
            }

            $.ajax({
            type: 'POST',
                    url: '<?php echo url_for('@user_set_country') ?>',
                    //data: {countryId: countryId },
                    data: {countryName: countryName},
                    dataType: 'json', //text

                    // callback handler that will be called on success
                    success: function(response, textStatus, jqXHR) {
                        if (response.success == true && response.resetCity == true) {
                            // $("#company_city_id").val('');
                            if (response.countryId != null && response.countryId != undefined) {
                                $('#company_country_id').val(response.countryId);
                                $('#company_country').val(countryName);
                            }
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                    // log the error to the console
                    //console.log("The following error occured: " + textStatus, errorThrown);
                    },
                    complete: function(){
                    }
            });
        }

        function setCity(cId, cName) {
            var cityId = cityName = null;
            if (cId && cName) {
                cityId = cId;
                cityName = cName;
            }
            else {
                cityId = $("#company_city_id").val();
                cityName = $("#company_city").val();
            }
            
            $.ajax({
            type: 'POST',
            url: '<?php echo url_for('@user_set_city') ?>',
            data: {cityId: cityId, cityName: cityName},
            dataType: 'json', //text
                success: function(response, textStatus, jqXHR) {
                },
                error: function(jqXHR, textStatus, errorThrown) {
                },
                complete: function(){
                }
            });
        }
</script>