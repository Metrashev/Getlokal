<?php if(is_null($protect_msg)) $protect_msg = true; ?>

<div class="user_settings_top">

 <div class="user_settings_name">
    <?php echo link_to(image_tag($sf_user->getProfile()->getThumb(1), 'alt_tile='. $sf_user->getProfile().' class="img-circle"  height="45" width="45"'), 'profile/index') ?></a>
    <h4><?php echo $sf_user->getProfile() ?></h4>
    
  </div>

<?php if ($sf_request->getParameter('action') != 'companySettings'
&& $sf_request->getParameter('action')!= 'registerPageAdmin' ):?>
  <div class="user_settings_menu">
  	<a class="default-btn small" href="<?php echo url_for('profile/index') ?>"><?php echo __('View Profile', null, 'user')?></a>
    <?php echo link_to (__('Add Event', null, 'events'), 'event/create', array( 'class'=>'user_setings_event default-btn  small'));?>
   	<?php echo link_to (__('Add Company', null, 'company'), 'company/addCompany', array( 'class'=>'user_setings_review default-btn  small'));?>
    <?php echo link_to (__('Invite a Friend', null, 'user'), '@invite', array( 'class'=>'user_setings_invite default-btn  small'));?>
  </div>
<?php elseif ($sf_request->getParameter('action') == 'companySettings'): ?>
	<div class="clear"></div>
	<?php if($protect_msg) { 
		include_partial('protect_msg');
    } ?>
<?php endif;?>
	<div class="clear"></div>
</div>

<style>
.user_settings_name a{
	float: left;
}
.user_settings_name h4{
	margin-left: 10px;
	float: left;
}
.user_settings_menu a.default-btn{
	width: 48% !important;
	/*font-size: 14px;*/
	margin-left: 5px;
}
.user_settings_top{
	padding-top: 10px !important;
	background-color: #fcfcfc;
	height: 130px;
	border-bottom: 1px solid rgba(215,215,215,.6);
}
.user_settings_name{
	margin-bottom: 10px !important;
}
</style>