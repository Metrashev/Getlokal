<?php
    $menu = array(
        'invite_pm' => array(
            'name' => __('Via e-mail', null, 'user'),
            'sub' => array(
                __('Via e-mail', null, 'user') => 'invite_pm',
            )
        ),

        'invite_gy' => array(
            'name' => __('Via Gmail / Yahoo!', null, 'user'),
            'sub' => array(
                __('Via Gmail or Yahoo Mail', null, 'user') => 'invite_gy',
            )
        ),

        'invite_fb' => array(
            'name' => __('Via Facebook', null, 'user'),
            'sub' => array(
                __('Via Facebook', null, 'user') => 'invite_fb',
            )
        ),
    );

    /*
    if (!$sf_user->getProfile()->getAccessToken() || !strlen(trim($sf_user->getProfile()->getAccessToken()))) {
        unset($menu['invite_fb']);
    }
    */

    $routeName = sfContext::getInstance()->getRouting()->getCurrentRouteName();
?>

<div class="user_settings">
    <h1><?php echo __('Invite Your Friends', null, 'user'); ?></h1>
    <?php //include_partial('dashboard/top') ?>

    <div class="standard_tabs_wrap">
        <div id="more_info" class="standard_tabs_top nav-tabs">
            <?php if (isset($menu) && count($menu)) : ?>
                <?php $i = 0; ?>
                <?php foreach ($menu as $route => $item): ?>
                    <?php $active = ''; if (strpos($routeName, $route) !== false) $active = 'current'; ?>

                    <?php if ($routeName == 'invite_gy_check' && $route == 'invite_gy') : ?>
                        <?php $active = 'current'; ?>
                    <?php endif; ?>

                    <a id="tab<?php echo $i ?>" href="<?php echo url_for($route) ?>" class="<?php echo $active; ?>"><?php echo $item['name'] ?></a></li>
                    <?php $i++; ?>
                <?php endforeach ?>
            <?php endif; ?>
            <div class="clear"></div>
        </div>
        <div id="tab-container" class="standard_tabs_in tab-container">
            <?php echo $sf_data->getRaw('sf_content') ?>

            <div class="clear"></div>
        </div>
    </div>






















    <?php /*
    <!-- User Tabs -->
    <div class="settings_tabs_wrap">
        <div class="settings_tabs_top">
            <div class="settings_tab settings_tab_current">
                <a href="javascript:void(0)"><?php echo __('Invite Your Friends', null, 'user'); ?></a>
            </div>
        </div>

        <div class="settings_tabs_in">
            <div class="settings_sidebar">
                <?php if (isset($menu) && count($menu)) : ?>
                    <ul>
                        <?php foreach ($menu as $route => $item): ?>
                            <?php $active = ''; if (strpos($routeName, $route) !== false) $active = 'current'; ?>
                            <li><a href="<?php echo url_for($route) ?>" class="<?php echo $active; ?>"><?php echo $item['name'] ?></a></li>
                        <?php endforeach ?>
                    </ul>
                <?php endif; ?>
            </div>


            <div class="settings_submenu">
                <?php if (isset($menu) && count($menu)) : ?>
                    <?php foreach ($menu as $route => $item): ?>
                        <?php if (strpos($routeName, $route) !== false && isset($item['sub']) && count($item['sub'])) : ?>
                            <?php $horizontalMenu = array(); ?>
                            <?php foreach ($item['sub'] as $subItem => $subRoute) : ?>
                                <?php $active = ''; if (strpos($routeName, $subRoute) !== false) $active = 'current'; ?>
                                <?php $horizontalMenu[] = '<a href="' . url_for($subRoute) . '" class="' . $active . '">' . $subItem . '</a>'; ?>
                            <?php endforeach; ?>

                            <?php echo (count($horizontalMenu)) ? implode(' | ', $horizontalMenu) : ''; ?>
                        <?php endif; ?>
                    <?php endforeach ?>
                <?php endif; ?>
            </div>


            <?php echo $sf_data->getRaw('sf_content') ?>

            <div class="clear"></div>
        </div>
    </div>

    */ ?>
</div>

<script type="text/javascript">
    $('.settings_tabs_in div.settings_content').width(832 - $('.settings_tabs_in div.settings_sidebar').width());
    $('.settings_tabs_in div.settings_submenu').width(882 - $('.settings_tabs_in div.settings_sidebar').width());
    $('.settings_tabs_in div.settings_content ul.user_settings_gallery_list').width(872 - $('.settings_tabs_in div.settings_sidebar').width());
    $('.settings_tabs_in div.settings_content ul.user_settings_gallery_list li').width(($('.settings_tabs_in div.settings_content ul.user_settings_gallery_list').width() / 2) - 54);
    $('.settings_content div.pager_center').width($('.settings_content').width() - 52 - $('.settings_content div.pager_left').width() - $('.settings_content div.pager_right').width());
</script>
