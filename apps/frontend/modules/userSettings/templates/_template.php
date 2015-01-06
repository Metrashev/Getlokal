<?php 
  $menu = array(
    'userSettings/index' => array(
      'name' => __('Account Settings'),
      'sub' => array(
        'userSettings/index'  => __('Personal Information'),
        //'userSettings/changeUsername' => __('Change Username')
      )),
    'userSettings/security' => array(
      'name' => __('Security Settings'),
      'sub' => array(
        'userSettings/security'     => __('Change Password'),
        'userSettings/changeEmail'  => __('Change Email')
       , //'userSettings/deactivateAccount'  => __('Leave getlokal')
      )),
    'userSettings/images' => array(
      'name' => __('Photos', null, 'company'),
      'sub' => array(
        'userSettings/images'      => __('Photos', null, 'company'),
        'userSettings/upload' => __('Add Photo', null, 'company')
      )),
      /*'userSettings/findMyCompany' => array(
      'name' =>  __('Find My Company',null,'company'),
      'sub' => array(
        'userSettings/findMyCompany'      => __('Find your company in getlokal',null,'company')
      )),*/
      'userSettings/communication' => array(
      'name' =>  __('Communication',null,'company'),
      'sub' => array(
        'userSettings/communication'      => __('Communication',null,'company')
      )),
     /* 'userSettings/follow' => array(
      'name' =>  __('Follow Settings',null,'company'),
      'sub' => array(
        'userSettings/follow'      => __('Follow Settings',null,'company')
      )),*/
     
  ); 

 if($sf_user->getProfile()->getIsPageAdmin()):
 $menu2 = array(
 'userSettings/companySettings' => array(
      'name' =>  __('My Places', null, 'user'),
      'sub' => array(
        'userSettings/companySettings'      => __('My Places', null, 'user'),
        'userSettings/forgotPassword'      => __('Forgotten Password'),
         
      )),
      
      );
   $menu = array_merge($menu, $menu2);
endif;
$key = $sf_request->getParameter('module') . '/' . $sf_request->getParameter('action');
$forgotTab = 'userSettings/forgotPassword';
if ($sf_context->getActionName() == 'forgotPassword'):
    $forgotTabShow = true;
endif;
if(!isset($showTabs) || !$showTabs){?>
	<div class="user_settings">
		<?php include_partial('dashboard/top', array('protect_msg' => false)) ?>
		<ul class="categories-list">
			<?php foreach($menu as $link => $item): ?>
				<?php if($active = in_array($key, array_keys($item['sub']))) $active_key = $link;  ?>
					<li <?php echo $active? ' class="selected" ': '';?> >
						<div class="marker"></div>
						<a href="<?php echo url_for($link) ?>" class="<?php echo $active? 'current': '';?>"><?php echo $item['name'] ?></a>
					</li>
			<?php endforeach ?>
		</ul>
	</div>
<?php 
}
if(isset($showTabs) && $showTabs === true){
	echo '<ul class="nav nav-tabs default-form-tabs sec-tab-user-settings m-t-20" role="tablist" id="myTab" style="margin-bottom: 15px;">';
	foreach ($menu[$tab]['sub'] as $link => $tab){
		echo '<li '.($link == $selected ? 'class="active"' : '').'>'.link_to($tab, $link).'</li>';
	}
	echo '</ul>';
}?>