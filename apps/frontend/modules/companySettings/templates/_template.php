<?php
$active_key = null;
$hasDrafts = CompanyOfferTable::getHasDrafts($company->getId());

if ($company->getActivePPPService(true)) {
  $menu = array(
    'companySettings/basic' => array(
      'name' => __('Dashboard', null, 'user'),
      'sub' => array(
        'companySettings/basic' => __('Place Information', null, 'company'),
        'companySettings/classification' => __('Classification',null,'company'),
        'companySettings/hours' => __('Working Hours', null, 'company'),
        'companySettings/details' => __('Description', null, 'company'),
        'companySettings/statistics' => __('Stats', null, 'company'),
        'companySettings/menu' => __('Menu', null, 'company')
      )
    ),
    'companySettings/reviews' => array(
      'name' =>  __('Reviews'),
      'sub' => array(
        'companySettings/reviews'  => __('Reviews'),
      )
    ),
    'companySettings/images' => array(
      'name' => __('Photos', null, 'company'),
      'sub' => array(
        'companySettings/images'    => __('Photos', null, 'company'),
        'companySettings/upload'    => __('Add Photo', null, 'company'),
        'companySettings/uploadCover'    => __('Аdd Cover Photo', null, 'company'),
        'companySettings/coverImages'    => __('Cover Photos', null, 'company')
      )
    ),
  );

  if (
    count($company->getCompanyOffer()) ||
    $company->getActiveDealServiceAvailable(true) ||
    $company->getRegisteredDealService(true)
  ) {
    $menu2 = array(
      'companySettings/offers' => array(
        'name' => __('Offers', null, 'offer'),
        'sub' => array(
          'companySettings/offers'    => __('Offers',null,'offer'),
        )
      )
    );
    if ($hasDrafts) {
      $menu2['companySettings/offers']['sub']['companySettings/offers?drafts=1'] = __('Offer Drafts', null, 'offer');
    }
    if ($company->getActiveDealServiceAvailable(true) || $company->getRegisteredDealService(true)) {
      $menu2['companySettings/offers']['sub']['offer/new'] = __('Create an Offer', null, 'offer');
    }
    $menu = array_merge($menu, $menu2);
  }
  if ($company->getFollowers(true)) {
    $menu = array_merge($menu, array(
      'companySettings/followers' => array(
        'name' =>  __('Followers'),
        'sub' => array(
          'companySettings/followers'    =>  __('Followers'),
          'companySettings/contactFollowers'    =>  __('Contact Followers'),
        )
      ),
      'companySettings/conversations' => array(
        'name' =>  __('Messages'),
        'sub' => array(
          'companySettings/conversations'    =>  __('Messages')
        )
      )
    ));
  }
  $menu = array_merge($menu, array(
    'companySettings/videos' => array(
      'name' =>  __('Video',null,'company'),
      'sub' => array(
        'companySettings/videos'    =>  __('Video',null,'company'),
      )
    )
  ));
} else {
  $menu = array(
    'companySettings/basic' => array(
      'name' => __('Dashboard', null, 'user'),
      'sub' => array(
        'companySettings/basic' => __('Place Information', null, 'company'),
        'companySettings/classification' => __('Classification', null, 'company'),
        'companySettings/hours' => __('Working Hours', null, 'company'),
        'companySettings/details' => __('Description', null, 'company')
      )
    ),
    'companySettings/reviews' => array(
      'name' =>  __('Reviews'),
      'sub' => array(
        'companySettings/reviews' => __('Reviews'),
      )
    ),
    'companySettings/images' => array(
      'name' => __('Photos', null, 'company'),
      'sub' => array(
        'companySettings/images' => __('Photos', null, 'company'),
        'companySettings/upload' => __('Add Photo', null, 'company')
      )
    ),
  );
  if (
    count($company->getCompanyOffer()) ||
    $company->getActiveDealServiceAvailable(true) ||
    $company->getRegisteredDealService(true)
  ) {
    $menu2 = array(
      'companySettings/offers' => array(
        'name' => __('Offers', null, 'offer'),
        'sub' => array(
          'companySettings/offers'    => __('Offers',null,'offer'),
        )
      )
    );
    if ($hasDrafts) {
      $menu2['companySettings/offers']['sub']['companySettings/offers?drafts=1'] = __('Offer Drafts', null, 'offer');
    }
    if ($company->getActiveDealServiceAvailable(true) || $company->getRegisteredDealService(true)) {
      $menu2['companySettings/offers']['sub']['offer/new'] = __('Create an Offer', null, 'offer');
    }

    $menu = array_merge($menu, $menu2);
  }
  if ($company->getFollowers(true)) {
    $menu = array_merge($menu, array(
      'companySettings/followers' => array(
        'name' =>  __('Followers'),
        'sub' => array('companySettings/followers' => __('Followers'))
      )
    ));
  }

  if ($company->getVideos()) {
    $menu = array_merge($menu, array(
      'companySettings/videos' => array(
        'name' => __('Video', null, 'company'),
        'sub' => array(
          'companySettings/videos' => __('Video', null, 'company'),
        )
      )
    ));
  }
}

$menu = array_merge($menu, array('companySettings/changePassword' => array(
  'name' => __('Change Password'),
  'sub' => array(
    'companySettings/changePassword' => __('Change Password'),
  )
)));

if ($adminuser  && !$is_getlokal_admin) {
  $menu=array_merge($menu, array('companySettings/admins' => array(
    'name' => __('Company Admins'),
    'sub' => array(
      'companySettings/admins' => __('Company Admins'),
    )
  )));
}


$key = $sf_request->getParameter('module') . '/' . $sf_request->getParameter('action');
if ($sf_request->getParameter('drafts')) {
  $key = 'companySettings/offers?drafts=1';
}
?>

<div class="user_settings">
  <div class="settings_tabs_wrap">
    <h2><?php echo __('My Places', null, 'user'); ?></h2>
    <div class="settings_tabs_top">
      <?php foreach($companies as $item): ?>
        <div class="settings_tab <?php echo $company->getId() == $item->getId()? 'settings_tab_current': '' ?>">
          <a href="<?php echo url_for('companySettings/index?slug='. $item->getSlug()) ?>"><?php echo $item->getCompanyTitle() ?></a>
        </div>
      <?php endforeach ?>
      <div class="clear"></div>
      <div class="settings_tab_content"></div>
    </div>

    <div class="settings_tabs_in">
      <a href="<?php echo url_for($company->getUri(ESC_RAW)) ?>" class="button_pink"><?php echo __('See Place Page', null, 'company');?></a>
      <h1><?php echo $company->getCompanyTitle(); ?></h1>
      <div class="settings_sidebar">
        <ul>
          <?php foreach($menu as $link => $item): ?>
            <?php if($active = in_array($key, array_keys($item['sub']))) $active_key = $link;  ?>
              <li><a href="<?php echo url_for($link.'?slug='. $company->getSlug()) ?>" class="<?php echo $active? 'current': '';?>"><?php echo $item['name'] ?></a></li>
          <?php endforeach ?>
        </ul>
      </div>
      <div class="settings_content_in">
        <div class="standard_tabs_wrap" <?php echo (isset($active_key) && count($menu[$active_key]['sub']) > 1) ? '' : 'style="padding-top: 0px;"'?>>
          <?php if (isset($active_key) && count($menu[$active_key]['sub']) > 1): ?>
            <div id="more_info" class="standard_tabs_top nav-tabs">
              <?php foreach($menu[$active_key]['sub'] as $link => $name): ?>
                <?php if (strstr($link, '?')): ?>
                  <?php 
                    // echo link_to($name, $link. '&slug='. $company->getSlug(), 'class='.($link == $key? 'current': ''))
                  ?>
                <a href="<?php echo url_for($link.'?slug='. $company->getSlug()) ?>" onclick="companySettingFormSubmition(href);return false;" class="<?php echo $link == $key? 'current': '';?>"><?php echo $name;?></a>
                <?php else: ?>
                 <?php // echo link_to($name, $link. '?slug='. $company->getSlug(), 'class='.($link == $key? 'current': '')) ?>
                <a href="<?php echo url_for($link.'?slug='. $company->getSlug()) ?>" onclick="companySettingFormSubmition(href);return false;" class="<?php echo $link == $key? 'current': '';?>"><?php echo $name;?></a>
                <?php endif ?>
              <?php endforeach ?>
              <div class="clear"></div>
            </div>
          <?php endif ?>
          <div id="tab-container-1" class="standard_tabs_in">
            <?php echo $sf_data->getRaw('sf_content') ?>
          </div>
        </div>
      </div>
      <div class="clear"></div>
    </div>
  </div>
  <div class="clear"></div>
</div>
<div id="dialog-confirm" draggable="true" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable ui-dialog-buttons" tabindex="-1" role="dialog" aria-labelledby="ui-id-1" style="outline: 0px; z-index: 2; height: auto; width: 445px; top: 12%; left: 40%; display: none;"><div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix"><span id="ui-id-1" class="ui-dialog-title"><?php echo __('Changes to "My Places"', null); ?></span><a class="ui-dialog-titlebar-close ui-corner-all" role="button"><span onclick="closeMsg()" class="ui-icon ui-icon-closethick">close</span></a></div>
    <div  style="width: auto; min-height: 0px; height: 105px;" class="ui-dialog-content ui-widget-content" scrolltop="0" scrollleft="0">
        <p><?php echo __('You made some changes. What do you want to do with them?', null); ?></p>
        <div style="display:none;" id="form-processing">
            <p><?php // echo __('Saving your data', null); ?></p>
            <img src="/images/gui/horizontal_loader.GIF"/>
        </div>
        <p style="display:none;" id="save-completed"><?php // echo __('Saved', null); ?></p>
    </div>
    <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
        <?php if(($sf_params->get('module') == 'companySettings' && $sf_context->getActionName() == 'classification') || ($sf_params->get('module') == 'companySettings' && $sf_context->getActionName() == 'menu')):?>
          <a onclick="csFormRegSubmit()" id="submit-btn" class="ui-button-text"><?php echo __('Save', null); ?></a>
        <?php else:?>  
         <a id="save-proceed"><?php echo __('Save', null); ?></a>
        <?php endif;?>
       
        <a id="cancel" onclick="abortSending()" class="ui-button-text"><?php echo __('Continue without saving', null); ?></a>
    </div>
</div>