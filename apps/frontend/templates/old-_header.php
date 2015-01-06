<?php
$search_city = $sf_request->getParameter('w');
$ac_where = $sf_request->getParameter('ac_where');
$ac_where_ids = $sf_request->getParameter('ac_where_ids');
$wherePlaceholder = $sf_request->getParameter('placeholder');

if ($sf_user->getCountry()->getSlug() == 'fi') {
    $placeholder = $sf_user->getCounty();
} else {
    $placeholder = $sf_user->getCity();
}
?>
<script type="text/javascript">
    var searchHeaderWherePlaceholder = '<?php echo $placeholder; ?>';
</script>
    <div class="header">
        <div class="main_menu_wrap main_menu_mini">
            <div class="header_wrapper">
                <div class="main_menu">
                    <div id="logo">
                        <a href="<?php echo url_for('@home3') ?>" class="logo_wrap">
                            <?php echo image_tag('gui/logo_getlokal_small.png', array('width' => '146', 'alt' => __("Logo"))) ?>
                            <i class="fa fa-chevron-down"></i>
                        </a>
                        <div class="location_wrap">
                            <ul class="country_list">
                                <?php $countries = sfConfig::get('app_domain_slugs_old'); ?>

                                <?php foreach ($countries as $country): ?>
                                    <li <?php echo $sf_user->getCountry()->getSlug() == $country ? 'class="current"' : ''; ?>><a href="http://www.getlokal.<?php echo $country ?>/"><?php echo __(sfConfig::get('app_countries_' . $country)) ?></a></li>
                                <?php endforeach; ?>

                            </ul>
                            <ul class="city_list">
                                <?php foreach ($sf_user->getCountry()->getDefaultCities() as $city): ?>
                                    <?php if ($sf_request->getParameter('county', false) || (getlokalPartner::getInstanceDomain() == 78)): ?>
                                        <li <?php echo (strtolower($sf_user->getCounty()->getLocation()) == strtolower($city->getCounty()->getLocation())) ? 'class="current"' : ''; ?>>
                                            <a href="<?php echo url_for('@homeCounty?county=' . $city->getCounty()->getSlug()) ?>">
                                                <?php echo $city->getCounty()->getLocation(); ?>
                                                <?php echo (strtolower($sf_user->getCounty()->getLocation()) == strtolower($city->getCounty()->getLocation())) ? '<img src="/images/gui/menu_tick.png" alt="Current city"/>' : ''; ?>
                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li <?php echo (strtolower($sf_user->getCity()->getLocation()) == strtolower($city->getLocation())) ? 'class="current"' : ''; ?>>
                                            <a href="<?php echo url_for('@home?city=' . $city->getSlug()) ?>">
                                                <?php echo $city->getLocation(); ?>
                                                <?php echo (strtolower($sf_user->getCity()->getLocation()) == strtolower($city->getLocation())) ? '<img src="/images/gui/menu_tick.png" alt="Current city"/>' : ''; ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach ?>
                            </ul>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="header_search_wrapper">
                        <form action="<?php echo url_for('search/index') ?>" method="get" id="search-form">
                            <input type="hidden" name="reference" id="search_header_where_reference"
                                   value="<?php echo trim($sf_request->getParameter('reference')) ?>">
                            <div class="input_box what_box">
                                <p><?php echo __('Search for'); ?></p>
                                <?php if ($sf_user->getCountry()->getSlug() == 'mk'): ?>
                                    <input placeholder="<?php echo __("e.g. pizza, Trend"); ?>" type="text" id="search_header_what" name="s" value="<?php echo trim($sf_request->getParameter('s')) ?>"/>
                                <?php elseif ($sf_user->getCountry()->getSlug() == 'sr'): ?>
                                    <input placeholder="<?php echo __("e.g. restaurant, hairdresser"); ?>" type="text" id="search_header_what" name="s" value="<?php echo trim($sf_request->getParameter('s')) ?>"/>
                                <?php else: ?>
                                    <input placeholder="<?php echo __("e.g. pizza, Starbucks"); ?>" type="text" id="search_header_what" name="s" value="<?php echo trim($sf_request->getParameter('s')) ?>"/>
                                <?php endif; ?>

                            </div>
                            <div class="input_box header_box">
                                <p><?php echo __('Where'); ?></p>
                                <input type="hidden" id="ac_where" name="ac_where" value="<?php echo $ac_where; ?>">
                                <input type="hidden" id="ac_where_ids" name="ac_where_ids" value="<?php echo $ac_where_ids; ?>">
                                <input placeholder="<?php echo __($placeholder); ?>" type="text" id="search_header_where" name="w" value="<?php echo $wherePlaceholder ? $wherePlaceholder : $search_city; ?>" />             
                            </div>
                            <div class="search_icon">
                                <div id="search-holder">
                                    <input type="submit" class="hidden" value="<?php echo __(''); ?>" />
                                    <i class="fa fa-search"></i>
                                </div>     
                            </div>
                            <div class="vertical_separator"></div>

                        </form>

                    </div>
                    <div class="user_personal_wrap">
                        <div class="header_user_wrap">
                            <div class="header_user_content">
                                <?php if ($sf_user->isAuthenticated()): ?>
                                    <?php if ($sf_user->getPageAdminUser()): ?>
                                        <span class="user_greeting">
                                            <?php $first_name = $sf_user->getPageAdminUser()->getUsername(); ?>
                                            <strong class="pink"><?php echo $first_name; ?></strong>
                                        </span>
                                        <a id="header_login_button" href="javascript:void(0);"></a>
                                        <div class="clear"></div>
                                        <div class="mask"></div>
                                        <div id="header_dropdown_wrap">

                                            <div class="dropdown_row dropdown_companyrow">
                                                <p><?php echo __('use <i>getlokal</i> as:'); ?></p>
                                                <div class="user_scroll">
                                                    <div class="scrollbar"><div class="track"><div class="thumb"></div></div></div>
                                                    <div class="viewport">
                                                        <ul class="overview">
                                                            <li>
                                                                <a href="<?php echo url_for('companySettings/logout') ?>" title="<?php echo $sf_user->getGuardUser()->getUserProfile(); ?>">
                                                                    <img src="<?php echo $sf_user->getGuardUser()->getUserProfile()->getThumb(1); ?>" />
                                                                    <?php echo $sf_user->getGuardUser()->getUserProfile(); ?>
                                                                </a>
                                                                <div class="clear"></div>
                                                            </li>
                                                            <?php if ($sf_user->getPageAdminUser()->getIsOtherPlaceAdmin()): ?>
                                                                <?php foreach ($sf_user->getPageAdminUser()->getIsOtherPlaceAdmin() as $place_admin): ?>
                                                                    <?php $company = $place_admin->getCompanyPage()->getCompany(); ?>
                                                                    <li>
                                                                        <?php if ($place_admin->getUsername()): ?>
                                                                            <a href="<?php echo url_for('@company_settings?slug=' . $company->getSlug() . '&action=login'); ?>" title="<?php echo $company->getCompanyTitle(); ?>">
                                                                            <?php else: ?>
                                                                                <a href="<?php echo url_for('userSettings/companySettings#' . $company->getId()) ?>" title="<?php echo $company->getCompanyTitle(); ?>">
                                                                                <?php endif; ?>
                                                                                <?php echo image_tag($company->getThumb(0), array('alt' => $company->getCompanyTitle())) ?>
                                                                                <?php echo $company->getCompanyTitle(); ?>
                                                                            </a>
                                                                            <div class="clear"></div>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="dropdown_row dropdown_links">
                                                <?php if ($sf_user->getGuardUser()): ?>
                                                    <?php echo link_to(__('My Places', null, 'user'), 'userSettings/companySettings') ?>
                                                <?php endif; ?>
                                                <div class="clear"></div>
                                            </div>
                                            <div class="dropdown_row dropdown_center">
                                                <?php echo link_to(__('Log Out', null, 'user'), 'user/signout') ?>
                                            </div>
                                        </div>
                                    <?php elseif ($sf_user->getGuardUser()): ?>
                                        <?php echo image_tag($sf_user->getGuardUser()->getUserProfile()->getThumb(1)); ?>

                                        <span class="user_greeting">

                                            <?php $first_name = $sf_user->getGuardUser()->getUserProfile()->getFirstName();
                                            ?>

                                            <span><?php echo __('Hello', null, 'user') . ','; ?></span>
                                            <strong class="pink"><?php echo (mb_strlen($first_name, 'UTF8') <= 13 ) ? $first_name : mb_substr($first_name, 0, 10, 'UTF8') . '...'; ?></strong>
                                        </span>
                                        <a id="header_login_button" href="javascript:void(0);"></a>
                                        <div class="clear"></div>
                                        <div class="mask"></div>
                                        <div id="header_dropdown_wrap">
                                            <?php if ($sf_user->getGuardUser()->getIsPageAdmin()): ?>
                                                <div class="dropdown_row dropdown_companyrow">
                                                    <p><?php echo __('use <i>getlokal</i> as:'); ?></p>
                                                    <div class="user_scroll">
                                                        <div class="scrollbar"><div class="track"><div class="thumb"></div></div></div>
                                                        <div class="viewport">
                                                            <ul class="overview">

                                                                <?php foreach ($sf_user->getGuardUser()->getIsPlaceAdmin() as $place_admin): ?>
                                                                    <?php $company = $place_admin->getCompanyPage()->getCompany(); ?>
                                                                    <li>
                                                                        <?php if ($place_admin->getUsername()): ?>
                                                                            <a href="<?php echo url_for('@company_settings?slug=' . $company->getSlug() . '&action=login'); ?>" title="<?php echo $company->getCompanyTitle(); ?>" >
                                                                            <?php else: ?>
                                                                                <a href="<?php echo url_for('userSettings/companySettings#' . $company->getId()) ?>" title="<?php echo $company->getCompanyTitle(); ?>">
                                                                                <?php endif; ?>
                                                                                <?php echo image_tag($company->getThumb(0), array('alt' => $company->getCompanyTitle())) ?>
                                                                                <?php echo $company->getCompanyTitle(); ?>
                                                                            </a>
                                                                            <span class="clear"></span>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <div class="dropdown_row dropdown_links">
                                                <div class="item_count">
                                                    <p><?php echo __('Badges') . ':' ?> <?php echo $sf_user->getGuardUser()->getUserProfile()->getBadges() > 0 ? link_to($sf_user->getGuardUser()->getUserProfile()->getBadges(), url_for('profile/badges?username=' . $sf_user->getGuardUser()->getUsername())) : $sf_user->getGuardUser()->getUserProfile()->getBadges() ?></p>
                                                    <p><?php echo __('Reviews') . ':' ?> <?php echo $sf_user->getGuardUser()->getUserProfile()->getReviews() > 0 ? link_to($sf_user->getGuardUser()->getUserProfile()->getReviews(), url_for('profile/reviews?username=' . $sf_user->getGuardUser()->getUsername())) : $sf_user->getGuardUser()->getUserProfile()->getReviews() ?></p>
                                                    <p><?php echo __('Photos', null, 'company') . ':' ?> <?php echo $sf_user->getGuardUser()->getUserProfile()->getImages() > 0 ? link_to($sf_user->getGuardUser()->getUserProfile()->getImages(), url_for('profile/photos?username=' . $sf_user->getGuardUser()->getUsername())) : $sf_user->getGuardUser()->getUserProfile()->getImages() ?></p>
                                                    <div class="clear"></div>
                                                </div>
                                                <?php echo link_to(__('Settings', null, 'user'), 'userSettings/index') ?>
                                                <?php echo link_to(__('Profile', null, 'user'), 'profile/index?username=' . $sf_user->getGuardUser()->getUsername()) ?>
                                                <?php echo link_to(__('My Vouchers'), 'profile/vouchers') ?>
                                                <?php echo link_to(__('Invite a Friend', null, 'user'), '@invite') ?>
                                                <?php if ($sf_user->getGuardUser()->getIsPageAdmin()): ?>
                                                    <?php echo link_to(__('My Places', null, 'user'), 'userSettings/companySettings') ?>
                                                <?php endif; ?>
                                                <div class="clear"></div>
                                            </div>
                                            <div class="dropdown_row dropdown_center">
                                                <?php echo link_to(__('Log Out', null, 'user'), 'user/signout') ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <p class="title"><?php echo __('Login') ?></p>
                                    <span class="title">
                                        <strong class="pink"><?php echo __('Login') . ' / ' . __('Sign Up'); ?></strong>
                                    </span>
                                    <a class="not_logged" id="header_login_button" href="javascript:void(0);"></a>
                                    <div class="clear"></div>
                                    <div id="header_dropdown_wrap" class="no_border">
                                        <form action="<?php echo url_for('user/signin') ?>" method="post" class="login_form">
                                            <?php if (isset($publish_item)): ?>
                                                <h3><?php printf(__('If you want to add %s, please log into your getlokal profile.'), $publish_item); ?></h3>
                                            <?php endif; ?>
                                            <?php if (isset($title_message)): ?>
                                                <h3><?php echo $title_message; ?></h3>
                                            <?php endif; ?>

                                            <?php echo $form[$form->getCSRFFieldName()] ?>
                                            <div class="input_box form_box<?php if ($form['username']->hasError()): ?> error<?php endif; ?>">
                                                <?php // echo $form['username']->renderLabel(); ?>
                                                <?php echo $form['username']->render(array('placeholder' => __('Username', null, 'form'))); ?>
                                            </div>

                                            <div class="input_box form_box form_box_spaced<?php if ($form['password']->hasError()): ?> error<?php endif; ?>">
                                                <?php // echo $form['password']->renderLabel(); ?>
                                                <?php echo $form['password']->render(array('placeholder' => __('Password', null, 'form'))); ?>
                                            </div>
                                            <div class="form_box form_label_inline">
                                                <?php echo $form['remember']->render(); ?>
                                                <?php echo $form['remember']->renderLabel(); ?>
                                            </div>
                                            <input type="submit" class="button_pink" value="<?php echo __('Login'); ?>" />
                                            <div class="clear"></div>
                                            <div class="login_more">
                                                <?php echo link_to(__('Forgot Password?', null, 'user'), '@sf_guard_password') ?>
                                                <?php echo link_to(__('Sign Up', null, 'user'), '@user_register', array('class' => 'blue')) ?>
                                            </div>

                                            <div class="login_facebook_wrap">
                                                <a href="<?php echo url_for('user/FBLogin') ?>" title="Facebook Connect" class="header_facebook_button"><span>f</span>Connect</a>
                                                <span><?php echo __('or'); ?></span>
                                                <div class="clear"></div>
                                            </div>
                                            <div class="clear"></div>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php ?>
                            <?php if ($sf_user->isAuthenticated()): ?>
                                <?php include_component('home', 'notificationsss'); ?>
                                <?php include_component('home', 'messageNotificationsss'); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="vertical_separator second"></div>
                    <div class="language_wrap">
                        <?php include_component('home', 'languages'); ?>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="header_navigation_tabs">
                    <ul>
                        <li <?php echo ($sf_params->get('module') == 'article') ? ' class="active"' : ''; ?>>
                            <?php echo link_to(__('Articles'), '@article_index') ?>
                        </li>
                        
                        <li <?php echo ($sf_params->get('module') == 'list') ? ' class="active"' : ''; ?>>
                            <?php echo link_to(__('Lists'), 'list/index') ?>
                        </li>

                        <li <?php echo ($sf_params->get('module') == 'event') ? ' class="active"' : ''; ?>>
                            <?php echo link_to(__('Events'), 'event/recommended') ?>
                        </li>

                        <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
                            <li <?php echo ($sf_params->get('module') == 'getweekend') ? ' class="active"' : ''; ?>>
                            <?php if (($sf_user->getCulture() == 'en')): ?>
                                    <?php echo link_to(__('Video'), 'getweekend/index') ?>
                                <?php elseif ($sf_user->getCulture() == 'ro'): ?>
                                    <?php echo link_to(__('Video'), 'getweekend/index') ?>
                                <?php endif; ?>
                            </li>
                        <?php endif; ?>

                        <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG): ?>
                            <li <?php echo ($sf_params->get('module') == 'getweekend') ? ' class="active"' : ''; ?>>
                                <?php if (($sf_user->getCulture() == 'en')): ?>
                                    <?php echo link_to(__('Video'), 'getweekend/index') ?>
                                <?php elseif ($sf_user->getCulture() == 'bg'): ?>
                                    <?php echo link_to(__('Video'), 'getweekend/index') ?>
                                <?php endif; ?>
                            </li>
                        <?php endif; ?>

                        <li <?php echo ($sf_params->get('module') == 'home' && ($sf_params->get('action') == 'directory' || $sf_params->get('action') == 'locations')) ? ' class="active"' : ''; ?>>
                            <?php echo link_to(__('Directory'), 'home/directory') ?>
                        </li>

                        <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_MK): ?>
                            <?php /*  <li><?php if (($sf_user->getCulture()== 'en')): ?>
                              <?php echo link_to(__('Blog'), 'http://blog.getlokal.mk') ?>
                              <?php elseif ($sf_user->getCulture() == 'mk'):?>
                              <?php echo link_to(__('Blog'), 'http://blog.getlokal.mk') ?>
                              <?php endif;?>

                              </li>

                             */ ?>
                        <?php endif; ?>
                        <?php $countryId = $sf_user->getAttribute('country_id'); ?>
                        <?php if (in_array($countryId, array(getlokalPartner::GETLOKAL_RO, getlokalPartner::GETLOKAL_BG, getlokalPartner::GETLOKAL_MK, getlokalPartner::GETLOKAL_RS))): ?>
                            <li <?php echo ($sf_params->get('module') == 'offer' && ($sf_params->get('action') == 'index' || $sf_params->get('action') == 'show')) ? ' class="active"' : ''; ?>>
                                <?php echo link_to(__('Offers', null, 'offer'), 'offer/index') ?>
                            </li>
                        <?php endif ?>

                        <li <?php echo ($sf_params->get('module') == 'company' && $sf_params->get('action') == 'addCompany') ? ' class="active"' : ''; ?>>
                        <?php echo link_to(__('Add a place', null, 'company'), 'company/addCompany', array('title' => __('Add Place'))); ?></li>
                        
                        <?php if ($countryId == getlokalPartner::GETLOKAL_RO): ?>
                            <!-- <li <?php echo ($sf_params->get('module') == 'review' && $sf_params->get('action') == 'index') ? ' class="active"' : ''; ?>><?php echo link_to(__('Write and win!'), 'review/index', array('title' => __('Write and win!'))); ?></li> -->
                        <?php endif; ?>
                        
                            <?php if ($sf_user->getCulture() == 'bg'): ?>
                            <li title="с приложенията ни за iOS и Android ">
                                <div>
                                    <?php echo link_to(__('getMobile'), 'http://app.getlokal.com/app/bg/', array('class' => 'mobileLink', 'target' => '_blank')) ?>
                                    <a class="mobile_icons" target="_blank" href="http://app.getlokal.com/app/bg/">
                                        <i class="fa fa-apple"></i>
                                        <i class="fa fa-android"></i>
                                    </a>
                                </div>
                            </li>

                        <?php elseif ($sf_user->getCulture() == 'ro'): ?>
                            <li title="getMobile cu aplicația noastră de iOS sau Android">
                                <div>
                                    <?php echo link_to(__('getMobile', null, 'user'), 'http://app.getlokal.com/app/ro/', array('class' => 'mobileLink', 'target' => '_blank')) ?>
                                    <a class="mobile_icons" target="_blank" href="http://app.getlokal.com/app/ro/">
                                        <i class="fa fa-apple"></i>
                                        <i class="fa fa-android"></i>
                                    </a>
                                </div>
                            </li>

                        <?php elseif ($sf_user->getCulture() == 'mk'): ?>
                            <li title="со нашата мобилна апликација за iOS и Android">
                                <div>
                                    <?php echo link_to(__('getMobile'), 'http://app.getlokal.com/?lang=mk', array('class' => 'mobileLink', 'target' => '_blank')) ?>
                                    <a class="mobile_icons" target="_blank" href="http://app.getlokal.com/?lang=mk">
                                        <i class="fa fa-apple"></i>
                                        <i class="fa fa-android"></i>
                                    </a>
                                </div>
                            </li>

                        <?php elseif ($sf_user->getCulture() == 'sr'): ?>
                            <li>
                                <div>
                                    <?php echo link_to(__('getMobile'), 'http://app.getlokal.com/?lang=sr', array('class' => 'mobileLink', 'target' => '_blank')); ?>
                                    <a class="mobile_icons" target="_blank" href="http://app.getlokal.com/?lang=sr">
                                        <i class="fa fa-apple"></i>
                                        <i class="fa fa-android"></i>
                                    </a>
                                </div>
                            </li>

                        <?php elseif ($sf_user->getCulture() == 'fi'): ?>
                            <li title="meidän sovelluksia iOS ja Android">
                                <div>
                                    <?php echo link_to(__('getMobile', null, 'user'), 'http://app.getlokal.com/app/fi/', array('class' => 'mobileLink', 'target' => '_blank')) ?>
                                    <a class="mobile_icons" target="_blank" href="http://app.getlokal.com/app/fi/">
                                        <i class="fa fa-apple"></i>
                                        <i class="fa fa-android"></i>
                                    </a>
                                </div>
                            </li>

                        <?php elseif ($sf_user->getCulture() == 'ru'): ?>
                            <li title="Our aplication for iOS and Android">
                                <div>
                                    <?php echo link_to(__('getMobile', null, 'user'), 'http://app.getlokal.com/', array('class' => 'mobileLink', 'target' => '_blank')) ?>
                                    <a class="mobile_icons" target="_blank" href="http://app.getlokal.com/">
                                        <i class="fa fa-apple"></i>
                                        <i class="fa fa-android"></i>
                                    </a>
                                </div>
                            </li>

                        <?php elseif ($sf_user->getCulture() == 'en'): ?>
                            <li>
                                <div>
                                    <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO or $sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_FI): ?>
                                        <?php echo link_to(__('getMobile', null, 'user'), 'http://app.getlokal.com', array('class' => 'mobileLink', 'target' => '_blank')) ?>
                                        <a class="mobile_icons" target="_blank" href="http://app.getlokal.com">
                                            <i class="fa fa-apple"></i>
                                        <i class="fa fa-android"></i>
                                        </a>
                                    <?php else: ?>
                                        <?php echo link_to(__('getMobile'), 'http://app.getlokal.com', array('class' => 'mobileLink', 'target' => '_blank')); ?>
                                        <a class="mobile_icons" target="_blank" href="http://app.getlokal.com">
                                            <i class="fa fa-apple"></i>
                                            <i class="fa fa-android"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </li>

                        <?php elseif ($sf_user->getCulture() == 'hu'): ?>
                            <li title="A application iOS és Android">
                                <div>
                                    <?php echo link_to(__('Vagyunk mobile', null, 'user'), 'http://app.getlokal.com/', array('class' => 'mobileLink', 'target' => '_blank')) ?>
                                    <a class="mobile_icons" target="_blank" href="http://app.getlokal.com/">
                                        <i class="fa fa-apple"></i>
                                        <i class="fa fa-android"></i>
                                    </a>
                                </div>
                            </li>

                        <?php elseif ($sf_user->getCulture() == 'me'): ?>
                            <li>
                                <div>
                                    <?php echo link_to(__('getMobile', null, 'user'), 'http://app.getlokal.com/', array('class' => 'mobileLink', 'target' => '_blank')) ?>
                                    <a class="mobile_icons" target="_blank" href="http://app.getlokal.com/">
                                        <i class="fa fa-apple"></i>
                                        <i class="fa fa-android"></i>
                                    </a>
                                </div>
                            </li>
                        <?php endif; ?>

                    </ul>
                    <div class="clear"></div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        
        <div class="clear"></div>

        <?php if ((!substr_count(get_slot('sub_module'), 'vip')) && !has_slot('no_map') && !isset($no_map)): ?>
            <div class="search_bar">
                <div class="map_activator"></div>
                <div id="google_map"></div>
                <div class="map_navigation">
                    <div class="right">
                        <a id="map_reload" href="javascript:void(0)"><span></span><img alt="<?php echo __("Reload") ?>" src="/images/gui/icon_reload.png" /><?php echo __('Show Places Nearby'); ?></a>
                        <a class="nav_arrow" href="#"><img src="/images/gui/icon_enlarge.png" alt="<?php echo __("Zoom") ?>" /><?php echo __('Larger'); ?></a>
                        <a class="nav_arrow" style="display:none" href="#"><img src="/images/gui/icon_reduce.png" alt="<?php echo __("Smaller") ?>" /><?php echo __('Smaller'); ?></a>
                    </div>
                </div>
                <?php //var_dump($sf_user->getCity()); exit(); ?>
            </div>
        <?php else: ?>
            <div id="google_map"></div>
        <?php endif; ?>
    </div> 

    <div class="clear"></div>

    <script type="text/javascript">
        $(document).ready(function() {
            map.lat = <?php echo $sf_user->getCity()->getLat(); ?>;
            map.lng = <?php echo $sf_user->getCity()->getLng(); ?>;

            map.loadUrl = '<?php echo url_for('search/searchNear') ?>';
            map.autocompleteUrl = '<?php echo url_for('search/autocomplete') ?>';
            map.init();
        });
    </script>