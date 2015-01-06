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
<div class="header-company-settings col-sm-12">
	<!-- <?php foreach($companies as $item){ ?>
		<div class="col-sm-4">
		    	<label><a <?=$company->getId() == $item->getId()? 'current': '' ?> href="<?=url_for('companySettings/index?slug='. $item->getSlug()) ?>"><?=$item->getCompanyTitle() ?></a></label>
		    </div>
		<?php } ?>
		<label><a href="<?php echo url_for($company->getUri(ESC_RAW)) ?>" ><?php echo __('See Place Page', null, 'company');?></a></label>
		 -->	
		 <h2><?php echo $company->getCompanyTitle(); ?></h2>
</div>