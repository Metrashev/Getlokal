<?php slot('no_ads', true) ?>
<?php slot('no_feed', true) ?>
<?php slot('no_map', true) ?>

<?php $lng = mb_convert_case(getlokalPartner::getLanguageClass(), MB_CASE_LOWER, 'UTF-8'); ?>
<?php $current_culture = sfContext::getInstance()->getUser()->getCulture(); ?>
<?php $languages = sfConfig::get('app_languages_' . $lng) ?>
<?php $userCountry = myTools::getUserCountry(); ?>
<?php $campaignCountry = false; ?>
<?php $countries = sfConfig::get('app_domain_slugs_old'); ?>

<div id="loading-overlay" class="loading-overlay" style="display: none;"></div>

<?php if (in_array($userCountry['slug'], array('it', 'se', 'si'))): ?>
    <?php $campaignCountry = true; ?>
    <div id="success-msg2"> 
    <div class="wrapper-thanks">
            <h2><?php echo 'You Rock!'; ?></h2>
            <div>
                <h3><?php echo 'We just added your place to Getlokal !'; ?></h3>
            </div>
            <p><?php echo 'Be the first- upload picture, write comment or create event for your place !'; ?></p>

        <div id="actions">
            <button id="add-more" class="button_green"><i class="fa fa-plus"></i><span><?php echo 'Add more places'; ?></span></button>
            <span><?php echo 'or'; ?></span>
            <a id="to-profile" class="button_pink"><span><?php echo 'See place profile'; ?></span><i class="fa fa-long-arrow-right"></i></a>
        </div>
        
        <?php if (count($profile->getUsersInCountry($userCountry['id'])) > 0): ?>
            <div class="testimonials">
                <p>Users who added places in <?php echo $userCountry['name_en']; ?>:</p>
                <ul>
                    <?php foreach ($profile->getUsersInCountry($userCountry['id']) as $user): ?>
                    <?php $thumb = $user->getCreatedByUser()->getImage()->getFile()->getThumb();
                            if(!$thumb):
                                $thumb = '/images/gui/default_user_80x80.jpg';
                            endif; 
                    ?>
                        <li>
                            <a href="<?php echo url_for('profile/index?username='. $user->getCreatedByUser()->getSfGuardUser()->getUsername()); ?>">
                                <?php echo image_tag($thumb, 'size=80x80', array('alt' => $user->getCreatedByUser()->getSfGuardUser()->getFirstName() . ' ' . $user->getCreatedByUser()->getSfGuardUser()->getLastName())) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    
                    <?php $usersCount = $profile->getUsersCount($userCountry['id']); ?>
                    <?php if($usersCount > 6): ?>
                        <li class="number-list">
                            + <?php echo $profile->getUsersCount($userCountry['id']); ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div><!-- /.testimonials -->
        <?php endif; ?>
    </div><!-- /.wrapper-thanks -->
  </div> 
<?php else: ?>
    <div id="success-msg"> 
        <div class="wrapper-thanks">
            <h2><?php echo __('Thank you', null, 'company'); ?></h2>
            <div>
                <h3><?php echo __('You can now find ', null, 'company'); ?><a id="added_company"></a><?php echo __(' in Getlokal!', null, 'company'); ?></h3>
            </div>
            <p><?php echo __('Be the first one to add a photo, write a review or create an event for ', null, 'company'); ?> <span id="company_title"></span></p>

            <div id="actions">
                <button id="add-more" class="button_green"><i class="fa fa-plus"></i><span><?php echo __('Add more places', null, 'company'); ?></span></button>
                <span><?php echo __('or', null, 'messages'); ?></span>
                <a id="to-profile" class="button_pink"> <span><?php echo __('See place profile', null, 'company'); ?></span><i class="fa fa-long-arrow-right"></i></a>  

                <?php if(!in_array(strtolower($userCountry['slug']), $countries) && $userCountry['slug'] != ''): ?>
                    <div class="contact-form">
                        <p><?php echo __('If you like Getlokal and want it in your country - let us know! Want to be part of a growing team of people passionate about all things local?', null, 'company'); ?></p>
                        <a class="send-mail"><i class="fa fa-envelope"></i><?php echo __('Contact Us'); ?></a>
                    </div>
                    <div class="ajax"></div>
                <?php endif; ?>

            </div>
        </div><!-- /.wrapper-thanks -->
    </div> 
<?php endif; ?>

<div class="form-wrap">
    <!--checks user country and show landing page-->
    <?php if (in_array($userCountry['slug'], array('it', 'se', 'si'))): ?>
        <?php include_partial('company/add_company_campaign', array('company' => $company, 'review' => $review, 'profile' => $profile, 'userCountry' => $userCountry, 'city' => $city)); ?>
    <?php endif; ?>
    
    <div class="addCompany">
        <div class="companyHeader">
            <h1 class="border"><?php echo __('Add a place', null, 'company'); ?></h1>
        </div>
        <div class="error_message" style="display:none">
            <p><?php echo __('There is missing info and/or errors. Please check again!', null, 'company'); ?></p>
        </div>

        <form id ="addCompanyForm" action="<?php echo url_for('company/addCompany'); ?>" method="post" class="right"> 

            <?php echo $form['company_location']['latitude']->render() ?>
            <?php echo $form['company_location']['longitude']->render() ?>
            <?php echo $form['company_location']['sublocation']->render() ?>
            <?php echo $form['_csrf_token']->render() ?>

            <section class="capitalize no-border">
                <?php if (in_array($userCountry['slug'], array('it', 'se', 'si'))): ?>
                    <?php echo $form['city']->renderLabel(null, array('class' => 'required')) ?>
                    <?php echo $form['city']->render(array('style' => '', 'placeholder' => __('City', null, 'form'))); ?>
                <?php endif; ?>
            </section>

            <section class="two-inputs capitalize no-padding-top">
                <?php if (in_array(strtolower($userCountry['slug']), $countries)): ?>
                    <?php echo $form[$lng]['title']->renderLabel(null, array('class' => 'required')); ?>
                <?php else: ?>
                    <?php echo $form[$lng]['title']->renderLabel(__('Place/business name', null, 'form'), array('class' => 'required')); ?>
                <?php endif; ?>

                <div class="form_box <?php echo $form[$lng]['title']->hasError() ? 'error' : '' ?>">
                    <div class="autocomplete-company-title">
                        <?php // <span class="pink">&nbsp;*</span> ?>
                        <?php if($userCountry['language'] == 'latin'): ?>
                            <?php echo $form[$lng]['title']->render(array('style' => '', 'placeholder' => __('Name in your local language', null, 'company'))); ?>
                        <?php else: ?>
                            <?php echo $form[$lng]['title']->render(array('style' => '')); ?>
                        <?php endif; ?>
                        <?php echo $form[$lng]['title']->renderError() ?>
                    </div>
                </div>
                <div class="fixing-width"><?php if($userCountry['language'] != 'latin'): ?>
                        <div class="form_box no-margin <?php echo $form[$lng]['title']->hasError() ? 'error' : '' ?>">
                            <?php echo $form['en']['title']->hasError() ? '' : '' ?>
                            <?php // echo $form['en']['title']->renderLabel() ?>
                            <?php echo $form['en']['title']->render(array('placeholder' => __('in English', null, 'form'))); ?>
                            <?php echo $form['en']['title']->renderError() ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <section id="classifications" class="capitalize">
                <div class="add_field <?php echo $form['classification_id']->hasError() ? 'error' : '' ?>">
                    <?php echo $form['classification']->renderLabel(null, array('class' => 'required')) ?>
                    <?php //  <span class="pink">&nbsp;*</span> ?>
                    <div class="limit_error classification_limit" style="display:none">
                        <p><?php echo __('You can add up to 5 classifications!', null, 'company'); ?></p>
                    </div>
                    <div class="form_box tooltip-input left-float">
                        <?php echo $form['classification']->render(array('placeholder' => __('E.g. restaurant', null, 'messages'))) ?>
                        <a id="classification" class="tool-tip" data-tip="<?php echo __('Start typing the place type e.g. ‘restaurant’ or ‘hairdressers’ and select the most appropriate category for the place you’re adding', null, 'company') ?>"></a>
                    </div> 
                    <a class="button_green" id="add_classification"><?php echo __('+', null, 'company'); ?></a>
                    <?php echo $form['sector_id']->render() ?>
                    <?php echo $form['classification_id']->render() ?>
                    <?php echo $form['classification_id']->renderError() ?>

                    <div class="clear"></div>

                    <section class="added_items" id="list_of_classifications" <?php echo!isset($classification_list_id) ? ('style="display:none"') : '' ?>>
                        <?php if (isset($classification_list_id)) : ?>
                            <?php foreach ($classification_list_id as $key => $cll): ?>
                                <div class="added_item">
                                    <p><?php echo $classification_list_title[$key]; ?></p>
                                    <a>×</a>
                                    <input type="hidden" name="company[classification_list_title][]" id="classification_list_title_<?php echo $cll; ?>" value="<?php echo $classification_list_title[$key]; ?>">
                                    <input type="hidden" name="company[classification_list_id][]" id="classification_list_id_<?php echo $cll; ?>" value="<?php echo $cll; ?>">
                                    <input type="hidden" name="company[sector_list_id][]" id="sector_list_id_<?php echo $sector_list_id[$key]; ?>" value="<?php echo $sector_list_id[$key]; ?>">
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </section>
                </div> 
            </section>  

            <section class="capitalize no-border">
                <label class="required"><?php echo __('Address and location', null, 'company') ?></label>
                <div class="form_box no-margin<?php echo $form['country_id']->hasError() ? 'error' : '' ?>">
                    <?php echo $form['country']->render(array('style' => '', 'placeholder' => __('Country', null, 'form'))); ?>
                    <?php echo $form['country_id']->render(); ?>
                    <?php echo $form['country_id']->renderError() ?>
                </div>
                <p></p>
                <div class="form_box no-margin<?php echo $form['city_id']->hasError() ? 'error' : '' ?>">
                    <?php // echo $form['city']->renderLabel() ?>
                    <?php if (in_array(strtolower($userCountry['slug']), $countries)){
                            echo $form['city']->render(array('style' => '', 'placeholder' => __('City', null, 'form')));
                        } elseif(!in_array($userCountry['slug'], array('it', 'se', 'si'))) {
                            echo $form['city']->render(array('style' => '', 'placeholder' => __('e.g. Paris or London', null, 'company')));
                        }
                    ?>

                    <?php echo $form['city_id']->render(); ?>
                    <?php echo $form['city_id']->renderError() ?>
                </div>
            </section> 
            <section id="full-width" class="no-border no-padding-top">    
                <div class="three-inputs no-border">
                    <div class="form_box small <?php echo $form['company_location']['street_type_id']->hasError() ? 'error' : '' ?>">
                        <?php echo $form['company_location']['street_type_id']->render(array('value' => 1)); ?>
                        <?php echo $form['company_location']['street_type_id']->renderError() ?>
                    </div>

                    <div class="form_box tooltip-input middle  <?php echo $form['company_location']['street']->hasError() ? 'error' : '' ?>">
                        <?php if (in_array(strtolower($userCountry['slug']), $countries)): ?>
                            <?php echo $form['company_location']['street']->render(array('placeholder' => __('Street', null, 'form'))) ?>
                        <?php else: ?>
                            <?php echo $form['company_location']['street']->render(array('placeholder' => __('e.g. Any Road', null, 'company'))) ?>
                        <?php endif; ?>

                        <a class="tool-tip" data-tip="<?php echo __('If you type in the address – street name and number - the position of the market showing where the place is will change. If the positioning doesn’t seem correct you can move the marker. This will not change the address you’ve already written.', null, 'company') ?>"></a>

                        <?php echo $form['company_location']['street']->renderError() ?>
                    </div>

                    <div class="form_box small no-margin <?php echo $form['company_location']['street_number']->hasError() ? 'error' : '' ?>">
                        <?php echo $form['company_location']['street_number']->render(array('placeholder' => __('Number', null, 'form'))); ?>
                        <?php echo $form['company_location']['street_number']->renderError() ?>
                    </div>
                    <div class="location-hint">
                        <p class="fade"><?php echo __('<span class="regular">Start typing the </span><span class="highlight">place address</span> <span class="regular"> and a marker will be placed on the map.</span>', null, 'company'); ?></p>
                    </div>
                </div>
            </section>    
            <section class="map-container no-padding-top">
                <div id="map_canvas"></div>
                <div class="map_navigation">
                    <div class="bottom right">
                        <a class="nav_arrow" href="#"><img src="/images/gui/icon_enlarge.png" /><?php echo __('Larger'); ?></a>
                        <a class="nav_arrow" style="display:none" href="#"><img src="/images/gui/icon_reduce.png" /><?php echo __('Smaller'); ?></a>
                    </div>
                </div>
            </section>

            <?php if(in_array(strtolower($userCountry['slug']), $countries)): ?>     
                <div class="trigger">
                    <a id="show_address"><?php echo __('More address info', null, 'company'); ?></a>
                </div>
                <div class="clear"></div>   

                <section id="expandable" class="three-inputs " style="display: none;">
                    <?php if (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_BG): ?>
                        <div class="form_box small <?php echo $form['company_location']['location_type']->hasError() ? 'error' : '' ?>">
                            <?php echo $form['company_location']['location_type']->render(array('value' => 2)); ?>
                            <?php echo $form['company_location']['location_type']->renderError() ?>
                        </div>

                        <div class="form_box middle <?php echo $form['company_location']['neighbourhood']->hasError() ? 'error' : '' ?>">
                            <?php // echo $form['company_location']['neighbourhood']->renderLabel(); ?>
                            <?php echo $form['company_location']['neighbourhood']->render(array('placeholder' => __('Neighbourhood', null, 'company'))); ?>
                            <?php echo $form['company_location']['neighbourhood']->renderError() ?>
                        </div>

                        <div class="form_box small no-margin <?php echo $form['company_location']['building_no']->hasError() ? 'error' : '' ?>">
                            <?php // echo $form['company_location']['building_no']->renderLabel() ?>
                            <?php echo $form['company_location']['building_no']->render(array('placeholder' => __('Bl.', null, 'company'))); ?>
                            <?php echo $form['company_location']['building_no']->renderError() ?>
                        </div>
                        <div class="clear"></div>
                    <?php endif; ?>

                    <div class="form_box full-width no-margin <?php echo $form['company_location']['address_info']->hasError() ? 'error' : '' ?>">
                        <?php // echo $form['company_location']['address_info']->renderLabel() ?>
                        <?php echo $form['company_location']['address_info']->render(array('placeholder' => __('Is this place easy to find? Add directions if necessary.', null, 'company'))); ?>
                        <?php echo $form['company_location']['address_info']->renderError() ?>
                    </div>
                </section>
            <?php endif;?>

            <section class="three-equal capitalize">
                <label><?php echo __('Contacts', null, 'contact') ?></label>
                <div class="form_box tooltip-input <?php echo $form['phone']->hasError() ? 'error' : '' ?>">
                    <?php // echo $form['phone']->renderLabel() ?>
                    <div class="invalid_error phone" style="display:none">
                        <p><?php echo __('Invalid Phone Number', null, 'form'); ?></p>
                    </div>

                    <a class="tool-tip" data-tip="<?php echo __('The correct format to use is 023456789 or for mobile phones 0888888888. Add only the local area code for landlines. Only add digits – any other characters or spaces between characters are not allowed.', null, 'company') ?>"></a>

                    <div class="form_box <?php echo $form['phone']->hasError() ? 'error' : '' ?>">
                        <?php echo $form['phone']->render(array('placeholder' => __('Phone', null, 'form'))) ?>
                        <?php echo $form['phone']->renderError() ?>
                    </div>
                    <?php // echo $form['phone1']->renderError() ?>
                    <?php // echo $form['phone2']->renderError() ?>

                    <div class="added_items" id="list_of_phones" <?php echo!isset($phone_list) ? ('style="display:none"') : '' ?>>
                        <?php if (isset($phone_list)) : ?>
                            <?php foreach ($phone_list as $phl): ?>
                                <div class="added_item">
                                    <p><?php echo $phl; ?></p>
                                    <a>×</a>
                                    <input type="hidden" name="company[ph][]" value="<?php echo $phl ?>" >
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form_box <?php echo $form['website_url']->hasError() ? 'error' : '' ?>">
                    <?php echo $form['website_url']->render(array('placeholder' => __('Website'))) ?>
                    <?php echo $form['website_url']->renderError() ?>
                </div>

                <div class="form_box no-margin <?php echo $form['email']->hasError() ? 'error' : '' ?>">
                    <?php // echo $form['email']->renderLabel(); ?>
                    <?php echo $form['email']->render(array('placeholder' => __('E-mail'))); ?>
                    <?php echo $form['email']->renderError() ?>
                </div>
            </section>

            <?php /*
              <div class="two_inputs">

              <div class="form_box add_field<?php echo $form['phone']->hasError() ? 'error' : '' ?>">
              <?php echo $form['phone']->renderLabel() ?>
              <div class="phone_limit" style="display:none; position:relative;">
              <p><?php echo __('You can add up to 3 telephone numbers!', null, 'company'); ?></p>
              </div>
              <div class="invalid_error phone" style="display:none">
              <p><?php echo __('Invalid Phone Number', null, 'form'); ?></p>
              </div>
              <a class="tip phone_tip">
              <span class="details"><?php echo __('The correct format to use is 023456789 or for mobile phones 0888888888. Add only the local area code for landlines. Only add digits – any other characters or spaces between characters are not allowed.', null, 'company') ?></span>
              </a>
              <input type="text" <?php echo isset($phone_number) ? 'value="' . $phone_number . '"' : '' ?> name="company[phone_number]" id="phone_number" style="margin-top: -20px;">
              <?php echo $form['phone']->renderError() ?>
              <?php echo $form['phone1']->renderError() ?>
              <?php echo $form['phone2']->renderError() ?>

              <div class="clear"></div>
              <div class="added_items" id="list_of_phones" <?php echo!isset($phone_list) ? ('style="display:none"') : '' ?>>
              <?php if (isset($phone_list)) : ?>
              <?php foreach ($phone_list as $phl): ?>
              <div class="added_item">
              <p><?php echo $phl; ?></p>
              <a>×</a>
              <input type="hidden" name="company[ph][]" value="<?php echo $phl ?>" >
              </div>
              <?php endforeach; ?>
              <?php endif; ?>
              </div>


              <?php /*   <a class="tip">
              <span class="details"><?php echo __('The correct format to use is 023456789 or for mobile phones 0888888888. Add only the local area code for landlines. Only add digits вЂ“ any other characters or spaces between characters are not allowed.', null, 'company') ?></span>
              </a>


              </div>


              <div class="form_box add_button">
              <a class="button_green" id="add_phone"><?php echo __('Add', null, 'company'); ?></a>
              </div>
             */ ?>



            <?php if ($sf_user->isAuthenticated() && in_array(strtolower($userCountry['slug']), $countries)): ?>
                <div class="trigger">
                    <a id="owners-details"><?php echo __('Are you the owner?', null, 'company'); ?></a>  
                </div>

                <div class="owners_company_info"  <?php echo $owner ? '' : 'style="display: none;"'; ?>>


                    <?php if (isset($form['page_admin'])): ?>
                        <section class="two-inputs no-border">
                            <?php if (isset($form['page_admin']['user_profile']['sf_guard_user']) && isset($form['page_admin']['user_profile']['sf_guard_user']['first_name'])): ?>
                                <div class="form_box <?php echo $form['page_admin']['user_profile']['sf_guard_user']['first_name']->hasError() ? 'error' : '' ?>">
                                    <?php // echo $form['page_admin']['user_profile']['sf_guard_user']['first_name']->renderLabel() ?>
                                    <?php echo $form['page_admin']['user_profile']['sf_guard_user']['first_name']->render(array('class' => 'owner_username', 'placeholder' => __('Name'))); ?>
                                    <?php echo $form['page_admin']['user_profile']['sf_guard_user']['first_name']->renderError(); ?>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($form['page_admin']['user_profile']['sf_guard_user']) && isset($form['page_admin']['user_profile']['sf_guard_user']['last_name'])): ?>
                                <div class="form_box no-margin <?php echo $form['page_admin']['user_profile']['sf_guard_user']['last_name']->hasError() ? 'error' : '' ?>">
                                    <?php // echo $form['page_admin']['user_profile']['sf_guard_user']['last_name']->renderLabel() ?>
                                    <?php echo $form['page_admin']['user_profile']['sf_guard_user']['last_name']->render(array('placeholder' => __('Surname'))); ?>
                                    <?php echo $form['page_admin']['user_profile']['sf_guard_user']['last_name']->renderError(); ?>
                                </div>
                            <?php endif; ?>
                        </section>


                        <section class="three-equal no-border no-padding-top">
                            <?php if (isset($form['page_admin']['username'])): ?>
                                <div class="form_box tooltip-input <?php echo $form['page_admin']['username']->hasError() ? 'error' : '' ?>">
                                    <?php // echo $form['page_admin']['username']->renderLabel() ?>
                                    <?php echo $form['page_admin']['username']->render(array('placeholder' => __('Username', null, 'form'))); ?>
                                    <?php echo $form['page_admin']['username']->renderError(); ?>
                                    <a id="phone-tip" class="tool-tip" data-tip="<?php echo __('Your username should contain only alphanumeric characters, dash, dot or underscore') ?>"></a>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($form['page_admin']['password'])): ?>
                                <div class="form_box <?php echo $form['page_admin']['password']->hasError() ? 'error' : '' ?>">
                                    <?php // echo $form['page_admin']['password']->renderLabel() ?>
                                    <?php echo $form['page_admin']['password']->render(array('placeholder' => __('Password', null, 'form'))); ?>
                                    <?php echo $form['page_admin']['password']->renderError(); ?>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($form['page_admin']['user_profile']['gender'])): ?>
                                <div class="form_box no-margin <?php echo $form['page_admin']['user_profile']['gender']->hasError() ? 'error' : '' ?>">
                                    <?php // echo $form['page_admin']['user_profile']['gender']->renderLabel() ?>
                                    <?php echo $form['page_admin']['user_profile']['gender']->render(); ?>
                                    <?php echo $form['page_admin']['user_profile']['gender']->renderError(); ?>
                                </div>
                            <?php endif; ?>
                        </section>
                        <section class="three-equal no-padding-top">   
                            <?php if (isset($form['page_admin']['user_profile']['phone_number'])): ?>
                                <div class="form_box <?php echo $form['page_admin']['user_profile']['phone_number']->hasError() ? 'error' : '' ?>">
                                    <?php // echo $form['page_admin']['user_profile']['phone_number']->renderLabel() ?>
                                    <?php echo $form['page_admin']['user_profile']['phone_number']->render(array('placeholder' => __('Phone', null, 'form'))); ?>
                                    <?php echo $form['page_admin']['user_profile']['phone_number']->renderError(); ?>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($form['registration_no'])): ?>
                                <div class="form_box <?php echo $form['registration_no']->hasError() ? 'error' : '' ?>">
                                    <?php // echo $form['registration_no']->renderLabel() ?>      
                                    <?php echo $form['registration_no']->render(array('placeholder' => __('Enter your EIK/Bulstat'))); ?>
                                    <?php echo $form['registration_no']->renderError() ?>
                                </div>
                            <?php endif; ?>
                            <div class="form_box no-margin<?php echo $form['page_admin']['position']->hasError() ? 'error' : '' ?>">
                                <?php // echo $form['page_admin']['position']->renderLabel() ?>
                                <?php echo $form['page_admin']['position']->render(); ?>
                                <?php echo $form['page_admin']['position']->renderError(); ?>
                            </div>
                        </section>  
                        <div class="clear"></div>
                        <section class="checkboxes">
                            <?php if (isset($form['page_admin']['authorized'])): ?>
                                <div class="form_box <?php echo $form['page_admin']['authorized']->hasError() ? 'error' : '' ?>">
                                    <?php echo $form['page_admin']['authorized']->render(array('class' => 'input_check')); ?>
                                    <?php echo $form['page_admin']['authorized']->renderLabel() ?>

                                    <?php if ($form['page_admin']['authorized']->hasError()): ?>
                                        <p class="error"><?php echo $form['page_admin']['authorized']->renderError(); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($form['page_admin']['allow_b_cmc'])): ?>
                                <div class="form_box no-margin <?php echo $form['page_admin']['allow_b_cmc']->hasError() ? 'error' : '' ?>">
                                    <?php echo $form['page_admin']['allow_b_cmc']->render(); ?>
                                    <?php // echo $form['page_admin']['allow_b_cmc']->renderLabel() ?>
                                    <?php echo __('I would like to receive getlokal\'s Business Newsletter and Notifications.'); ?>
                                    <?php echo $form['page_admin']['allow_b_cmc']->renderError(); ?>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($form['page_admin']['accept'])): ?>
                                <div class="form_box no-margin <?php echo $form['page_admin']['accept']->hasError() ? 'error' : '' ?>">
                                    <?php echo $form['page_admin']['accept']->render(); ?>
                                    <?php echo sprintf(__('I have the necessary representative powers and agree with the %s and the %s'), link_to(__('Terms of Use'), '@static_page?slug=terms-of-use', array('popup' => true)), link_to(__('Policy for Use and Protection of the Information of Getlokal'), '@static_page?slug=privacy-policy', array('popup' => true))); ?>
                                    <?php echo $form['page_admin']['accept']->renderError(); ?>
                                </div>
                            <?php endif; ?>
                        </section>

                    <?php endif; ?> 
                </div>
            <?php endif; ?>
            <section id="full-width" class="no-border">
                <div class="two-inputs capitalize no-border">
                    <label><?php echo __('Social networks', null, 'company') ?></label>
                    <div class="form_box tooltip-input <?php echo $form['googleplus_url']->hasError() ? 'error' : '' ?>">
                        <?php // echo $form['facebook_url']->renderLabel() ?>
                        <?php echo $form['facebook_url']->render(array('class' => 'fb-icon', 'placeholder' => __('http://www.facebook.com/page-name', null, 'company'))); ?>
                        <?php echo $form['facebook_url']->renderError() ?>      
                    </div>
                    <div class="form_box tooltip-input no-margin <?php echo $form['facebook_url']->hasError() ? 'error' : '' ?>">
                        <?php // echo $form['googleplus_url']->renderLabel() ?>
                        <?php echo $form['googleplus_url']->render(array('class' => 'g-icon', 'placeholder' => __('https://plus.google.com/page-id', null, 'company'))); ?>
                        <?php echo $form['googleplus_url']->renderError() ?>         
                    </div>
                    <div class="social-tip">
                        <p><?php echo __('Let\'s link the place with its other <span class="highlight">online profiles!</span>', null, 'company'); ?></p>
                    </div>   
                </div>  
            </section>   

            <section class="two-inputs no-padding-top">
                <div class="form_box tooltip-input <?php echo $form['twitter_url']->hasError() ? 'error' : '' ?>">
                    <?php // echo $form['twitter_url']->renderLabel() ?>
                    <?php echo $form['twitter_url']->render(array('class' => 'tw-icon', 'placeholder' => __('@Twitter handle', null, 'company'))); ?>
                    <?php echo $form['twitter_url']->renderError() ?> 
                </div>

                <div class="form_box tooltip-input no-margin <?php echo $form['foursquare_url']->hasError() ? 'error' : '' ?>">
                    <?php // echo $form['foursquare_url']->renderLabel() ?>
                    <?php echo $form['foursquare_url']->render(array('class' => 'fsq-icon', 'placeholder' => __('Foursquare place URL', null, 'company'))) ?>
                    <?php echo $form['foursquare_url']->renderError() ?>
                </div>
            </section>
            <?php /*
            <section id="captcha">
                <?php if (sfConfig::get('app_recaptcha_active', false)): ?>
                    <div class="form_box no-margin <?php if ($form['captcha']->hasError()): ?> error<?php endif; ?>">
                        <div class="captcha_out">
                            <label><?php echo __('Security check. Enter the characters from the picture below', null, 'form') ?><span class="pink"><i class="fa fa-asterisk"></i></span></label>
                            <?php echo $form['captcha']->render(); ?>
                        </div>
                        <?php if ($form['captcha']->hasError()): ?>
                            <p class="error"><?php echo $form['captcha']->renderError(); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </section>
            */ ?>

            <section class="mandatory_notice no-border submit">
                <p><?php echo __('All fields marked with <span>*</span> are mandatory', null, 'company') ?></p>

                <input type="submit" value="<?php echo __('Send') ?>" class="button_green" id="btn-no-scroll" />

            </section>    
        </form> 	           
    </div>
</div>
<p hidden id="mandatory"><?php echo __('The field is mandatory', null, 'form'); ?></p>
<p hidden id="title-en-error"><?php echo __('The place name in English has to be written with Latin characters', null, 'form'); ?></p>
<p hidden id="facebook-error"><?php echo __('Invalid format. E.g. http://www.facebook.com/getlokal', null, 'errors'); ?></p>
<p hidden id="googleplus-error"><?php echo __('Invalid format. E.g. https://plus.google.com/', null, 'form'); ?></p>
<p hidden id="twitter-error"><?php echo __('Invalid format. E.g. @getlokal', null, 'form'); ?></p>
<p hidden id="foursquare-error"><?php echo __('Invalid format. E.g. https://foursquare.com/', null, 'form'); ?></p>
<p hidden id="min-7"><?php echo __('Your phone number should be at least 7 digits long', null, 'form'); ?></p>
<p hidden id="min-3"><?php echo __('Username must contain at least %min_length% characters', array('%min_length%' => 3), 'errors'); ?></p>
<p hidden id="min-6"><?php echo __('Your password should be at least %min_length% characters long', array('%min_length%' => 6), 'errors'); ?></p>
<p hidden id="class-url"><?php echo url_for('company/autocompleteClassification') ?></p>
<p hidden id="city-url"><?php echo url_for('user/getCitiesAutocomplete') ?></p>
<p hidden id="country-url"><?php echo url_for('user/getCountriesAutocomplete') ?></p>

<?php $company = $form->getObject(); ?>
<script type="text/javascript">

    window.onload=function(){
        setCountry();
        $('#company_page_admin_username').val('');
        $('#company_page_admin_password').val('');
    }

    $(document).ready(function() {

//    $(".follow_feed").css("display", "none");

<?php if (isset($clear_class_id) && $clear_class_id): ?>
        $("#company_classification_id").val('');
                $("#company_sector_id").val('');
<?php endif; ?>

<?php if ($userCountry['slug'] == 'it'): ?>
    lat = '41.8761127';
    lng = '12.4851003';
<?php elseif ($userCountry['slug'] == 'se'): ?>
    lat = '59.3293992';
    lng = '18.0683166';
<?php elseif ($userCountry['slug'] == 'si'): ?>
    lat = '46.0564116';
    lng = '14.5070157';
<?php else: ?>
    lat = $('#company_company_location_latitude').val()? $('#company_company_location_latitude').val(): '<?php echo $sf_user->getCity()->getLat() ?>';
    lng = $('#company_company_location_longitude').val()? $('#company_company_location_longitude').val(): '<?php echo $sf_user->getCity()->getLng() ?>';
<?php endif; ?>

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
            var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

            var marker = new google.maps.Marker({
            map: map,
//                    position: map_center,
                    draggable: true,
                    title: '<?php echo $company->getCompanyTitle() ?>',
                    icon: new google.maps.MarkerImage('/images/gui/icons/pin.svg', null, null, null, new google.maps.Size(35, 40))

            });

            geocoder.geocode({ 'address': $('#company_country').val(), bounds: map.getBounds()}, function(results, status) {
            if (status != google.maps.GeocoderStatus.OK) return;

                <?php if(in_array(strtolower($userCountry['slug']), $countries) || $userCountry['slug'] == ''): ?>
                    map.setCenter(map_center);
                    marker.setPosition(map_center);
                    var lat = $('#company_company_location_latitude').val()? $('#company_company_location_latitude').val(): '<?php echo $sf_user->getCity()->getLat() ?>';
                    var lng = $('#company_company_location_longitude').val()? $('#company_company_location_longitude').val(): '<?php echo $sf_user->getCity()->getLng() ?>';
                <?php else: ?>
                    map.setCenter(results[0].geometry.location);
                    marker.setPosition(results[0].geometry.location);
                    var lat = marker.getPosition().lat();
                    var lng = marker.getPosition().lng();
                <?php endif; ?>

                var map_center_offset = new google.maps.LatLng(lat, lng);
                setTimeout(function() { map.panToWithOffset(map_center_offset, 0, - 110); }, 1000);
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
            infoBubble_default.open(map, marker);
            google.maps.event.addListener(marker, 'click', function() {
            infoBubble_default.open(map, marker);
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
            infoBubble_iftyping.open(map, marker);
            google.maps.event.addListener(marker, 'click', function() {
            infoBubble_iftyping.open(map, marker);
            });
    });
            google.maps.Map.prototype.panToWithOffset = function(latlng, offsetX, offsetY) {
            var map = this;
                    var ov = new google.maps.OverlayView();
                    ov.onAdd = function() {
                    var proj = this.getProjection();
                            var aPoint = proj.fromLatLngToContainerPixel(latlng);
                            aPoint.x = aPoint.x + offsetX;
                            aPoint.y = aPoint.y + offsetY;
                            map.panTo(proj.fromContainerPixelToLatLng(aPoint));
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
            map.setCenter(marker.getPosition());
            setTimeout(function() { map.panToWithOffset(marker.getPosition(), 0, - 110); }, 1);
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


            geocoder.geocode({ 'address': $('#company_company_location_street').val() + $('#company_company_location_street_number').val() + ", " + $('#company_city').val(), bounds: map.getBounds()}, function(results, status) {


            if (status != google.maps.GeocoderStatus.OK) return;
                    map.setCenter(results[0].geometry.location);
                    map.setZoom(18);
                    setTimeout(function() {
                    map.panToWithOffset(marker.getPosition(), 0, - 115);
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
        geocoder.geocode({ 'address': $('#company_company_location_street').val() + $('#company_company_location_street_number').val() + ", " + $('#company_city').val(), bounds: map.getBounds()}, function(results, status) {
        if (status != google.maps.GeocoderStatus.OK) return;
                map.setCenter(results[0].geometry.location);
                map.setZoom(18);
                setTimeout(function() {
                map.panToWithOffset(marker.getPosition(), 0, - 115);
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
        geocoder.geocode({ 'address': $('#company_company_location_location_type option:selected').html() + ' ' + $('#company_company_location_neighbourhood').val() + ", " + $('#company_city').val(), bounds: map.getBounds()}, function(results, status) {

        if (status != google.maps.GeocoderStatus.OK) return;
                map.setCenter(results[0].geometry.location);
                marker.setPosition(results[0].geometry.location);
                $('#company_company_location_latitude').val(marker.getPosition().lat());
                $('#company_company_location_longitude').val(marker.getPosition().lng());
        });
    });
        
        $('#company_country').autocomplete({
            source: $('#country-url').text(),
            minLength: 2,
            position: {
            of: $('#company_country').parent()
            },
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

                    map.setCenter(results[0].geometry.location);
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

        <?php if($campaignCountry == true): ?>
var thing = $('#company_<?php echo $lng; ?>_title').autocomplete({
                source: '<?php echo url_for('company/autocomplete') ?>',
                minLength: 2,
                select: function( event, ui ) {
                    $('#company_<?php echo $lng; ?>_title').val(ui.item.id);
                },
            })
            thing.data("ui-autocomplete")._renderMenu = function( ul, items ) {
                var self = this;
                ul.append('<label class="place-autocomplete-label">Added Places</label>');
                  $.each( items, function( index, item ) {
                    self._renderItemData( ul, item );
                  });
            }
            thing.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                return $('<li class="add-place-autocomplete"></li>')
                .data( "ui-autocomplete-item", item )
                .append( '<span class="autocomplete-city">' + item.value + "</span>" + "<br>" +  '<span class="city-adress">' + item.address + '</span>' )
                .appendTo( ul );
            };
        <?php endif; ?>
 

    $.validator.addMethod(
        "titleEnCheck", 
        function (value, element) {
            var alphabet = "<?php echo $userCountry['language']?>";

                if(alphabet == 'cyrillic' || alphabet == 'other'){
                    return value !== '';
                }
                else{
                    return true;
                } 
    }, "");

    });
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
                    $("#company_city_id").val('');
                            $("#company_city_id").val('');
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