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
       , 'userSettings/deactivateAccount'  => __('Leave getlokal')
      )),
    'userSettings/images' => array(
      'name' => __('Photos', null, 'company'),
      'sub' => array(
        'userSettings/images'      => __('Photos', null, 'company'),
        'userSettings/upload' => __('Add Photo', null, 'company')
      )),
      'userSettings/findMyCompany' => array(
      'name' =>  __('Find My Company',null,'company'),
      'sub' => array(
        'userSettings/findMyCompany'      => __('Find your company in getlokal',null,'company')
      )),
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

 if($user->getIsPageAdmin()):
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
?>
<div class="user_settings">
	<?php include_partial('dashboard/top') ?>
	<div class="settings_tabs_wrap">
	    <div class="settings_tabs_in">
			<div class="settings_sidebar">
				<ul>
					<?php foreach($menu as $link => $item): ?>
						<?php if($active = in_array($key, array_keys($item['sub']))) $active_key = $link;  ?>
							<li><a href="<?php echo url_for($link) ?>" class="<?php echo $active? 'current': '';?>"><?php echo $item['name'] ?></a></li>
					<?php endforeach ?>
				</ul>
			</div>
			<div class="settings_content_in">
				<div class="standard_tabs_wrap" <?php echo (isset($menu) && isset($active_key) && isset($menu[$active_key]['sub'])) ? '' : 'style="padding-top: 0px;"'?>>
					<?php if (isset($menu) && isset($active_key) && isset($menu[$active_key]['sub'])): ?>
                                    <div id="more_info" class="standard_tabs_top nav-tabs user-settings <?php echo (isset($forgotTabShow) ? 'forgot-tab-show': '') ?>">
							<?php foreach($menu[$active_key]['sub'] as $link => $name): ?>
								<?php if ( $link == 'userSettings/deactivateAccount'):?>
									<?php echo link_to($name, $link, array('class' =>($link == $key? 'current': '') , 'confirm' =>__('Proceed to deletion of your getlokal account'))) ?>
								<?php else:?>     
									<?php echo link_to($name, $link, 'class='.($link == $key? 'current': '').' '.($link == $forgotTab? 'forgot-tab': '')) ?>
								<?php endif;?>  
							<?php endforeach; ?>
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
</div>

<script type="text/javascript">
$(document).ready(function() {
	$('.settings_sidebar').css('background-position', ('right ' + $('.settings_sidebar a.current').position().top + 'px'));
});
</script>