<div class="footer_wrap">
    <div class="content_footer">
        <div class="footer_wrapper <?php echo $sf_user->getCulture() ?>">
            <div class="content_footer_in firstItem">
                <div class="footer_item">
                    <?php
                    if ($sf_user->getAttribute('country_id') != getlokalPartner::GETLOKAL_RO):
                        ?>
                        <div class="footer_title">
                            <h2><?php echo __('For You'); ?></h2>
                        </div>
                        <div class="footer_alias">
                            <h3><?php echo __('Do you know your city?'); ?></h3>
                            <?php /*
                              <ul>
                              <li><?php echo __('Review places you like and unlock badges'); ?></li>
                              <li><?php echo __('Get deals and discounts. Check out events'); ?></li>
                              <li><?php echo __('Manage lists of your favourite places'); ?></li>
                              </ul>
                             */ ?>
                            <?php if (!$sf_user->getGuardUser()): ?>
                                <a href="<?php echo url_for('@sf_guard_signin'); ?>" class="button_pink"><?php echo __('getIn!'); ?></a>

                            <?php else: ?>

                                <a href="<?php echo url_for('userSettings/index'); ?>" class="button_pink"><?php echo __('getIn!'); ?></a>
                            <?php endif; ?>
                        </div>

                    <?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
                        <div class="footer_title">
                            <h2><?php echo __('Users'); ?></h2>
                        </div>
                        <div class="footer_alias">
                            <h3><?php echo __('Do you know your city?'); ?></h3>
                            <?php /*         <ul>
                              <li><?php echo __('Express your opinion and win badges on our site!'); ?></li>
                              <li><?php echo __('Be the first to find out about deals and discounts in the places you like!'); ?></li>
                              <li><?php echo __('getlokal with your place reviews, your shares, your likes and dislikes!'); ?></li>
                              </ul>
                             */ ?>
                            <?php if (!$sf_user->getGuardUser()): ?>
                                <a href="<?php echo url_for('@sf_guard_signin'); ?>" class="button_pink"><?php echo __('getIn!'); ?></a>

                            <?php else: ?>

                                <a href="<?php echo url_for('userSettings/index'); ?>" class="button_pink"><?php echo __('getIn!'); ?></a>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>

                </div>
            </div>
            <div class="content_footer_in secondItem">
                <div class="footer_item">
                    <?php $isRUPA = (bool) count(sfOutputEscaper::unescape($sf_user->getAdminCompanies())); ?>

                    <?php
                    if ($sf_user->getAttribute('country_id') != getlokalPartner::GETLOKAL_RO):
                        ?>
                        <div class="footer_title">
                            <h2><?php echo __('For Your Business'); ?></h2>
                        </div>    
                        <div class="footer_alias">
                            <h3><?php echo __('Do you engage with your customers?'); ?></h3>
                            <?php if (!$sf_user->getGuardUser()): ?>
                                <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG or $sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
                                    <a href="http://business.getlokal.com/<?php echo $sf_user->getCulture(); ?>" class="button_pink bussines" target="_glbusiness"><?php echo __('getBusiness!'); ?></a>
                                <?php else: ?> 
                                    <a href="http://business.getlokal.com/en" class="button_pink bussines" target="_glbusiness"><?php echo __('getBusiness!'); ?></a>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if ($isRUPA) : ?>
                                    <a href="<?php echo url_for('userSettings/companySettings'); ?>" class="button_pink bussines"><?php echo __('getBusiness!'); ?></a>
                                <?php else : ?>
                                    <?php if ($sf_user->getAttribute('country_id') != getlokalPartner::GETLOKAL_BG and $sf_user->getAttribute('country_id') != getlokalPartner::GETLOKAL_RO): ?>
                                        <a href="http://business.getlokal.com/en" class="button_pink bussines" target="_glbusiness"><?php echo __('getBusiness!'); ?></a>
                                    <?php else: ?> 
                                        <a href="http://business.getlokal.com/<?php echo $sf_user->getCulture(); ?>" class="button_pink bussines" target="_glbusiness"><?php echo __('getBusiness!'); ?></a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>    
                    <?php else: ?>
                        <div class="footer_title">
                            <h2><?php echo __('Business'); ?></h2>
                        </div>    
                        <div class="footer_alias">
                            <h3><?php echo __('Engage with your customers!'); ?></h3>
                        </div>  
                        <?php if (!$sf_user->getGuardUser()): ?>
                            <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG or $sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
                                <a href="http://business.getlokal.com/<?php echo $sf_user->getCulture(); ?>" class="button_pink bussines" target="_glbusiness"><?php echo __('getBusiness!'); ?></a>
                            <?php else: ?> 
                                <a href="http://business.getlokal.com/en" class="button_pink bussines" target="_glbusiness"><?php echo __('getBusiness!'); ?></a>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if ($isRUPA) : ?>
                                <a href="<?php echo url_for('userSettings/companySettings'); ?>" class="button_pink bussines"><?php echo __('getBusiness!'); ?></a>
                            <?php else : ?>
                                <?php if ($sf_user->getAttribute('country_id') != getlokalPartner::GETLOKAL_BG and $sf_user->getAttribute('country_id') != getlokalPartner::GETLOKAL_RO): ?>
                                    <a href="http://business.getlokal.com/en" class="button_pink bussines" target="_glbusiness"><?php echo __('getBusiness!'); ?></a>
                                <?php else: ?> 
                                    <a href="http://business.getlokal.com/<?php echo $sf_user->getCulture(); ?>" class="button_pink bussines" target="_glbusiness"><?php echo __('getBusiness!'); ?></a>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>  



                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="footer_middle_wrapper">
        <div class="footer_columns_wrapper">
            <div class="footer_column">
                <ul>
                    <li>
                        <p><?php echo __('About Us'); ?></p>
                    </li>
                    <li>
                        <?php echo link_to(__('getlokalNews'), 'http://news.getlokal.com', array('target' => 'blank')) ?>
                    </li>
                    <li>
                        <?php echo link_to(__('About getlokal', null, 'messages'), '@static_page?slug=about-us'); ?>
                    </li>
                    <li>
                        <?php echo link_to(__('Team', null, 'messages'), '@static_page?slug=our-team'); ?>
                    </li>
                    <li>
                        <?php echo link_to(__('Timeline', null, 'messages'), '@static_page?slug=timeline'); ?>
                    </li>
                    <?php /* <li>
                      <?php echo link_to(__('Performance'), 'home/directory'); ?>
                      </li>

                     */ ?>
                    <li>
                        <?php echo link_to(__("FAQ's", null, 'messages'), '@static_page?slug=faq'); ?>
                    </li>
                </ul>
            </div>
            <?php /*            <div class="footer_column">
              <ul>
              <li>
              <?php echo link_to(__('Content'), 'home/directory'); ?>
              </li>
              <?php if (($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG) || ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO)): ?>
              <li><?php echo link_to('getWeekend', 'getweekend/index', array('title' => 'GetWeekend', 'target' => '_blank')); ?></li>
              <?php endif; ?>
              <?php if ($sf_user->getCountry()->getSlug() == 'bg'): ?>
              <li><a href="http://blog.getlokal.com"  target="_blank"><?php echo __('Blog', null, 'messages'); ?></a></li>
              <?php elseif ($sf_user->getCountry()->getSlug() == 'mk'): ?>
              <li><a href="http://blog.getlokal.com"  target="_blank"><?php echo __('Blog', null, 'messages'); ?></a></li>
              <?php endif; ?>
              <li>
              <?php echo link_to(__('Directory'), 'home/directory'); ?>
              </li>
              </ul>
              </div>
             */ ?> 
            <div class="footer_column">
                <ul>
                    <li>
                        <p><?php echo __('Legal Info', null, 'contact'); ?></p>
                    </li>
                    <li><?php echo link_to(__('Terms of Use', null, 'contact'), '@static_page?slug=terms-of-use') ?></li>
                    <li>
                        <?php echo link_to(__('Privacy Policy', null, 'contact'), '@static_page?slug=privacy-policy') ?>
                    </li>
                    <li>
                        <?php echo link_to(__('General Terms & Conditions'), '@static_page?slug=advertising-rules') ?>
                    </li>
                    <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG or $sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_MK or $sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
                        <li>
                            <?php echo link_to(__('Rules of games', null, 'messages'), '@static_page?slug=promo-rules') ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="footer_column">
                <ul>
                    <li>
                        <p><?php echo __('Contact Us'); ?></p>
                    </li>
                    <li>
                        <?php echo link_to(__('Office Addresses', null, 'messages'), 'contact/getlokaloffices') ?>
                    </li>
                    <li>
                        <?php echo link_to(__('Contact form'), 'contact/getlokal'); ?>
                    </li>           
                </ul>
            </div>
            <div class="footer_column country_choise">
                <ul>
                    <li><p><?php echo __('Select Country', null, 'messages'); ?></p></li>

                    <ul class="country_list left">
                        <?php $countries = sfConfig::get('app_domain_slugs_old'); ?>
                        <?php foreach ($countries as $country): ?>
                            <?php $current_culture = sfConfig::get('app_domain_to_culture_' . strtoupper($country)) ?>
                            <li <?php echo $sf_user->getCountry()->getSlug() == $current_culture ? 'class="current"' : ''; ?>><a href="http://www.getlokal.<?php echo $country ?>/"><?php echo __(sfConfig::get('app_countries_' . $country)) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php if ($sf_user->getAttribute('country_id') != getlokalPartner::GETLOKAL_FI): ?>
                        <ul class="footer_cities_wrap" style=" min-width: 100px;">
                            <?php foreach ($sf_user->getCountry()->getDefaultCities() as $city): ?>
                                <li <?php echo (strtolower($sf_user->getCity()->getLocation()) == strtolower($city->getLocation())) ? 'class="current"' : ''; ?>>
                                    <a href="<?php echo url_for('@home?city=' . $city->getSlug()) ?>">
                                        <?php echo $city->getLocation(); ?>
                                        <?php echo (strtolower($sf_user->getCity()->getLocation()) == strtolower($city->getLocation())) ? '<img alt="---" src="/images/gui/menu_tick_black.png"/>' : ''; ?>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    <?php endif; ?>
                    <div class="clear"></div>
                </ul>
            </div>

            <div class="footer_column last">
                <div class="social_links_wrap">
                    <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG): ?>

                        <a href="https://twitter.com/getlokal" target="_blank"><?php echo image_tag('gui/icon_twitter_t_big.png', array('alt' => "Twitter")) ?></a>
                        <a href="http://www.youtube.com/getlokal" target="_blank"><?php echo image_tag('gui/icon_youtube_big.png', array('alt' => "Youtube")) ?></a>
                        <a href="https://www.facebook.com/getlokal" target="_blank"><?php echo image_tag('gui/footerImg/icon_facebook_big.png', array('alt' => "Facebook")) ?></a>
                        <a href="https://plus.google.com/107281061798826098705/posts" rel="publisher" target="_blank"><?php echo image_tag('gui/footerImg/icon_gplus_big.png', array('alt' => "G+")) ?></a>
                        <a href="http://www.linkedin.com/company/2404523?trk=prof-0-ovw-curr_pos" target="_blank"><?php echo image_tag('gui/icon_linkedin_big.png', array('alt' => "Linkedin")) ?></a>
                        <a href="http://pinterest.com/getlokal/getlokal-%D0%B1%D1%8A%D0%BB%D0%B3%D0%B0%D1%80%D0%B8%D1%8F/" target="_blank"><?php echo image_tag('gui/icon_pinterest.png', array('alt' => "Pinterest")) ?></a>

                    <?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>

                        <a href="https://twitter.com/getlokalro" target="_blank"><?php echo image_tag('gui/icon_twitter_t_big.png', array('alt' => "Twitter")) ?></a>
                        <a href="http://www.youtube.com/getlokalro" target="_blank"><?php echo image_tag('gui/icon_youtube_big.png', array('alt' => "Youtube")) ?></a>
                        <a href="https://www.facebook.com/getlokal.ro" target="_blank"><?php echo image_tag('gui/footerImg/icon_facebook_big.png', array('alt' => "Facebook")) ?></a>
                        <a href="https://plus.google.com/105307511231555757137/posts" rel="publisher" target="_blank"><?php echo image_tag('gui/footerImg/icon_gplus_big.png', array('alt' => "G+")) ?></a>
                        <a href="http://www.linkedin.com/company/2404523?trk=prof-0-ovw-curr_pos" target="_blank"><?php echo image_tag('gui/icon_linkedin_big.png', array('alt' => "Linkedin")) ?></a>
                        <a href="http://pinterest.com/getlokal/getlokal-rom%C3%A2nia/" target="_blank"><?php echo image_tag('gui/icon_pinterest.png', array('alt' => "Pinterest")) ?></a>

                    <?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_MK): ?>

                        <a href="https://twitter.com/getlokalMK" target="_blank"><?php echo image_tag('gui/icon_twitter_t_big.png', array('alt' => "Twitter")) ?></a>
                        <a href="http://www.youtube.com/getlokalmk" target="_blank"><?php echo image_tag('gui/icon_youtube_big.png', array('alt' => "Youtube")) ?></a>
                        <a href="https://www.facebook.com/getlokal.mk" target="_blank"><?php echo image_tag('gui/footerImg/icon_facebook_big.png', array('alt' => "Facebook")) ?></a>
                        <a href="https://plus.google.com/u/0/101550121514033570313/posts" rel="publisher" target="_blank"><?php echo image_tag('gui/footerImg/icon_gplus_big.png', array('alt' => "G+")) ?></a>
                        <a href="http://www.linkedin.com/company/2404523?trk=prof-0-ovw-curr_pos" target="_blank"><?php echo image_tag('gui/icon_linkedin_big.png', array('alt' => "Linkedin")) ?></a>
                        <a href="http://pinterest.com/getlokal/getlokal-%D0%BC%D0%B0%D0%BA%D0%B5%D0%B4%D0%BE%D0%BD%D0%B8ja/" target="_blank"><?php echo image_tag('gui/icon_pinterest.png', array('alt' => "Pinterest")) ?></a>

                    <?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RS): ?>

                        <a href="https://twitter.com/getlokalrs" target="_blank"><?php echo image_tag('gui/icon_twitter_t_big.png', array('alt' => "Twitter")) ?></a>
                        <!--<a href=""><?php echo image_tag('gui/icon_youtube_big.png') ?></a>-->
                        <a href="https://www.facebook.com/getlokal.rs" target="_blank"><?php echo image_tag('gui/footerImg/icon_facebook_big.png', array('alt' => "Facebook")) ?></a>
                        <a href="https://plus.google.com/u/0/107641928245143400221/posts" rel="publisher" target="_blank"><?php echo image_tag('gui/footerImg/icon_gplus_big.png', array('alt' => "G+")) ?></a>
                        <a href="http://www.linkedin.com/company/2404523?trk=prof-0-ovw-curr_pos" target="_blank"><?php echo image_tag('gui/icon_linkedin_big.png', array('alt' => "Linkedin")) ?></a>
                        <a href="http://pinterest.com/getlokal/getlokal-%D1%81%D1%80%D0%B1%D0%B8%D1%98%D0%B0/" target="_blank"><?php echo image_tag('gui/icon_pinterest.png', array('alt' => "Pinterest")) ?></a>

                    <?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_FI): ?>

                        <a href="https://twitter.com/getlokal" target="_blank"><?php echo image_tag('gui/icon_twitter_t_big.png', array('alt' => "Twitter")) ?></a>
                        <a href="http://www.youtube.com/getlokal" target="_blank"><?php echo image_tag('gui/icon_youtube_big.png', array('alt' => "Youtube")) ?></a>
                        <a href="https://www.facebook.com/getlokal" target="_blank"><?php echo image_tag('gui/footerImg/icon_facebook_big.png', array('alt' => "Facebook")) ?></a>
                        <a href="https://plus.google.com/107281061798826098705/posts" rel="publisher" target="_blank"><?php echo image_tag('gui/footerImg/icon_gplus_big.png', array('alt' => "G+")) ?></a>
                        <a href="http://www.linkedin.com/company/2404523?trk=prof-0-ovw-curr_pos" target="_blank"><?php echo image_tag('gui/icon_linkedin_big.png', array('alt' => "Linkedin")) ?></a>
                        <a href="http://pinterest.com/getlokal/getlokal-%D0%B1%D1%8A%D0%BB%D0%B3%D0%B0%D1%80%D0%B8%D1%8F/" target="_blank"><?php echo image_tag('gui/icon_pinterest.png', array('alt' => "Pinterest")) ?></a>
                    <?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_ME): ?>

                        <a href="https://twitter.com/getlokal" target="_blank"><?php echo image_tag('gui/icon_twitter_t_big.png', array('alt' => "Twitter")) ?></a>
                        <a href="http://www.youtube.com/getlokal" target="_blank"><?php echo image_tag('gui/icon_youtube_big.png', array('alt' => "Youtube")) ?></a>
                        <a href="https://www.facebook.com/getlokal" target="_blank"><?php echo image_tag('gui/footerImg/icon_facebook_big.png', array('alt' => "Facebook")) ?></a>
                        <a href="http://www.linkedin.com/company/2404523?trk=prof-0-ovw-curr_pos" target="_blank"><?php echo image_tag('gui/icon_linkedin_big.png', array('alt' => "Linkedin")) ?></a>
                    <?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RU): ?>

                        <a href="https://twitter.com/getlokal" target="_blank"><?php echo image_tag('gui/icon_twitter_t_big.png', array('alt' => "Twitter")) ?></a>
                        <a href="http://www.youtube.com/getlokal" target="_blank"><?php echo image_tag('gui/icon_youtube_big.png', array('alt' => "Youtube")) ?></a>
                        <a href="https://www.facebook.com/getlokal" target="_blank"><?php echo image_tag('gui/footerImg/icon_facebook_big.png', array('alt' => "Facebook")) ?></a>
                        <a href="http://www.linkedin.com/company/2404523?trk=prof-0-ovw-curr_pos" target="_blank"><?php echo image_tag('gui/icon_linkedin_big.png', array('alt' => "Linkedin")) ?></a>

                    <?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_HU): ?>
                        <a href="https://www.facebook.com/getlokal.co" target="_blank"><?php echo image_tag('gui/footerImg/icon_facebook_big.png', array('alt' => "Facebook")) ?></a>
                        <a href="http://www.linkedin.com/company/2404523?trk=prof-0-ovw-curr_pos" target="_blank"><?php echo image_tag('gui/icon_linkedin_big.png', array('alt' => "Linkedin")) ?></a>
                        <a href="http://www.pinterest.com/getlokal" target="_blank"><?php echo image_tag('gui/icon_pinterest.png', array('alt' => "Pinterest")) ?></a>     
                    <?php endif; ?>   
                </div>
                <div class="copywrite_msg">
                    <b><?php echo __('© Copyright Getlokal 2014'); ?></b>
                </div>

            </div>

            <div class="clear"></div>

            <?php if ($sf_user->getCountry()->getSlug() == 'bg'): ?>
                <div class="footer_top">
                    <a href="http://www.icantoo.eu/" target="_blank"><img src="/images/banners/icantoo.png" title="I Can Too" alt="I Can Too" align="absmiddle" /></a> getlokal за <a href="http://www.icantoo.eu/" target="_blank">I Can Too</a>
                </div>
            <?php endif; ?>

        </div>
    </div>
    <div class="clear"></div>
</div>
<?php
$ins = sfContext::getInstance();
if ($sf_user->getCountry()->getSlug() == 'ro' && (
        ($ins->getModuleName() == 'home' && $ins->getActionName() == 'index') ||
        ($ins->getModuleName() == 'home' && $ins->getActionName() == 'locations') ||
        ($ins->getModuleName() == 'home' && $ins->getActionName() == 'classification') ||
        ($ins->getModuleName() == 'home' && $ins->getActionName() == 'category') ||
        ($ins->getModuleName() == 'staticpage' && $ins->getActionName() == 'index') ||
        ($ins->getModuleName() == 'list' && $ins->getActionName() == 'index') ||
        ($ins->getModuleName() == 'list' && $ins->getActionName() == 'show') ||
        ($ins->getModuleName() == 'article' && $ins->getActionName() == 'index') ||
        ($ins->getModuleName() == 'article' && $ins->getActionName() == 'show') ||
        ($ins->getModuleName() == 'company' && $ins->getActionName() == 'show') ||
        ($ins->getModuleName() == 'event' && $ins->getActionName() == 'index') ||
        ($ins->getModuleName() == 'event' && $ins->getActionName() == 'show') ||
        ($ins->getModuleName() == 'home' && $ins->getActionName() == 'directory')
        )) {
    include_partial('global/avandor');
}
?>

