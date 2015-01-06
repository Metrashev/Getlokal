<?php slot('no_map');?> 
<div class="settings_content">
<?php if (isset($company)):?>
<?php $form_url = url_for('userSettings/forgotPassword?slug='.$company->getSlug());?>
<h2><?php echo sprintf(__('Forgotten password for %s'), link_to_company($company));?></h2>
<?php else: ?>
<?php $form_url = url_for('userSettings/forgotPassword');?>
<?php endif;?>
<form action="<?php echo $form_url; ?>" method="post" >
	<?php echo $form[$form->getCSRFFieldName()]; ?>
	<div class="form_box<?php if( $form['username']->hasError() or $sf_user->hasFlash('error')):?> error<?php endif;?>">
		<?php echo $form['username']->renderLabel('Username') ?>
		<?php echo $form['username']->render(); ?>
		<?php echo $form['username']->renderError() ?>
		<?php if($sf_user->hasFlash('ferror')): ?>  
		<ul class="error_list">
    <li><?php echo  __($sf_user->getFlash('ferror')) ?></li></ul>
     <?php endif ;?>
	</div>
	<?php if (sfConfig::get('app_recaptcha_active', false)): ?>
		<div class="form_box captcha_out">
			<?php echo $form['captcha']->renderLabel(); ?>
			<?php echo $form['captcha']->render(); ?>
			<?php echo $form['captcha']->renderError() ?>
		</div>
	<?php endif;?>
	<div class="form_box">
                <?php if ($user && isset($company)): ?>
                    <?php $page_admin = $user->getPlaceAdmin($company); ?>
                    <?php if ($page_admin): ?>
                        <?php if ($page_admin->getUsername()): ?>
                            <?php echo link_to(__('Send me my Username', null, 'user'), 'userSettings/sendMeMyAdminUsername?slug=' . $company->getSlug(), array('class' => 'button_pink')); ?>
                            <?php // echo link_to(__('My Places', null, 'user'), 'userSettings/companySettings'); ?>
                        <?php endif ?>
                    <?php endif; ?>
                <?php endif; ?>
            <input type="submit" class="button_green" value="<?php echo __('Send');?>" />
	</div>
</form>
</div>
