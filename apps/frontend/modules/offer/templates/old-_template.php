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
        'companySettings/statistics' => __('Stats', null, 'company')
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
          'companySettings/offers'    => __('Offers', null, 'offer'),
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
          'companySettings/offers'    => __('Offers',null,'offer')
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

if ($adminuser  && !$sf_user->isGetLokalAdmin()) {
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
if ($key == 'offer/edit') {
  $menu['companySettings/offers']['sub']['offer/edit'] = __('Edit Offer', null, 'offer');
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
      <a href="<?php echo url_for($company->getUri(ESC_RAW)) ?>" class="button_pink"><?php echo __('See Place Page');?></a>

   	  <h1><?php echo $company->getCompanyTitle(); ?></h1>
      <div class="settings_sidebar">
        <ul>
          <?php foreach($menu as $link => $item): ?>
            <?php if ($active = in_array($key, array_keys($item['sub']))) $active_key = $link;  ?>
            <li><a href="<?php echo url_for($link.'?slug='. $company->getSlug()) ?>" class="<?php echo $active? 'current': '';?>"><?php echo $item['name'] ?></a></li>
          <?php endforeach ?>
        </ul>
      </div>
      <div class="settings_content_in">
		<div class="standard_tabs_wrap" <?php echo (count($menu[$active_key]['sub']) > 1) ? '' : 'style="padding-top: 0px;"'?>>
	      <?php if (count($menu[$active_key]['sub']) > 1): ?>
	        <div id="more_info" class="standard_tabs_top nav-tabs">
	          <?php foreach($menu[$active_key]['sub'] as $link => $name): ?>
                <?php if (strstr($link, '?')): ?>
                  <?php echo link_to($name, $link. '&slug='. $company->getSlug(), 'class='.($link == $key? 'current': '')) ?>
                <?php else: ?>
	               <?php echo link_to($name, $link. '?slug='. $company->getSlug(), 'class='.($link == $key? 'current': '')) ?>
                <?php endif ?>
			  <?php endforeach ?>
	          <div class="clear"></div>
	        </div>
	      <?php endif ?>
		  <div id="tab-container-1" class="standard_tabs_in">
      		<?php echo $sf_data->getRaw('sf_content') ?>
      	  </div>
        </div>
        <div class="clear"></div>
      </div>
	</div>
  </div>
  <div class="clear"></div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$('.settings_sidebar').css('background-position', ('right ' + $('.settings_sidebar a.current').position().top + 'px'));

	$('.settings_tab a').click(function() {
		var elem = $(this);
		var parent = $(this).parent();
		if (!parent.hasClass('settings_tab_current') && !parent.hasClass('settings_tab_clicked')) {
			$.ajax({
				url: elem.attr('href'),
				beforeSend: function () {
					$('.settings_tab_clicked').css('width', 'auto');
					$('.settings_tab_clicked').removeClass('settings_tab_clicked');
					parent.css({width: elem.width()});
					parent.addClass('settings_tab_clicked');
					$('.settings_tab_content').css({top: (parent.position().top + 30), left: (parent.position().left), width: parent.width()});
					$('.settings_tab_content').html('<img src="/images/gui/loading.gif" style="margin-left:'+($('.settings_tab_content').width()/2 - 15)+ 'px" />').show();
				},
				success: function(data) {
					$('.settings_tab_content').css({width: '266px'});
					$('.settings_tab_content').html(data);
					$('.settings_tab_content').prepend('<a id="close_login_company" class="right" href="#"><img src="/images/gui/close_small.png" /></a>')
				}
			});
		}
		return false;
	});

	$('#close_login_company').live('click', function() {
		$('.settings_tab_content').toggle(100, function() {
			$('.settings_tab_clicked').css('width', 'auto');
			$('.settings_tab_clicked').removeClass('settings_tab_clicked');
		});
	});
});
</script>
