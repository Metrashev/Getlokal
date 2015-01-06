<?php slot('no_map');?> 
<?php slot('no_ads');?> 
<?php end_slot() ?> 
<div class="settings_content">
    <h2><?php echo __('My Places', null, 'user'); ?></h2>
    <?php if ($companies): ?><?php $i = 1; ?>
        <?php foreach ($companies as $firm): ?>
            <?php if ($sf_user->hasFlash('formerror')): ?>
                <?php if (isset($company) && $company && ($company->getId() == $firm->getId())): ?>
                    <div class="flash_error">
                        <?php if ($sf_user->hasFlash('formerror') == 'with_company'): ?>
                            <?php echo sprintf(__('The username and/or password you entered for %s are invalid or you don\'t have enough credentials', null, 'form'), link_to_company($company)); ?>
                        <?php else: ?>
                            <?php echo __('The username and/or password you entered are invalid or you don\'t have enough credentials', null, 'form'); ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <div class="settings_user_company dotted" id="<?php echo $company->getId() ?>">
                <span><?php echo $firm->getCompanyTitle(); ?></span>

                <?php if ($page_admin = $user->getUserProfile()->getIsCompanyAdmin($firm)): ?>
                    <?php if (!($page_admin->getUsername())): ?>
                        <?php if (isset($company) && $company && ($company->getId() == $firm->getId())): ?>
                            <!-- <div class="settings_user_company_form_error"> -->
                                <?php if (isset($form)) : ?>
                                    <a class="button_green long" onclick="openSignUserForm(this)"><?php echo __('Create Username and Password'); ?></a>
                                    <p><?php echo $firm->getDisplayAddress(); ?></p>
                                    <?php include_partial('companySettings/pageadmin_reg_old_form', array('form' => $form)); ?>
                                <?php else: ?>
                                    <a class="button_green long" onclick="openSignUserForm(this)"><?php echo __('Create Username and Password'); ?></a>
                                    <p><?php echo $firm->getDisplayAddress(); ?></p>
                                    <?php include_partial('companySettings/pageadmin_reg_old_form', array('form' => new PageAdminForm(Doctrine::getTable('PageAdmin')->findOnebyId($page_admin->getId())))); ?>
                                <?php endif; ?>
                            <!-- </div> -->
                        <?php else: ?>
                            <a class="button_green long" onclick="openSignUserForm(this)"><?php echo __('Create Username and Password'); ?></a>
                            <p><?php echo $firm->getDisplayAddress(); ?></p>
                            <?php include_partial('companySettings/pageadmin_reg_old_form', array('form' => new PageAdminForm(Doctrine::getTable('PageAdmin')->findOnebyId($page_admin->getId())))); ?>
                                <?php endif; ?>
                        <?php $i++; ?>
                    <?php else: ?>
                        <a class="button_green" onclick="openSignUserForm(this)"><?php echo __('Login'); ?></a>
                        <p><?php echo $firm->getDisplayAddress(); ?></p>
                        <?php include_partial('companySettings/pageadmin_signin_form', array('form' => new SigninPageAdminForm(null, array('company' => $firm)), 'company' => $firm, 'user' => $user)); ?>
                        <?php echo link_to(__('Forgot Password?', null,'user'),'userSettings/forgotPassword?slug='.$firm->getSlug(), 'class=forgot-pass')?>
                    <?php endif; ?>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    <?php elseif ($company): ?>
        <?php echo $company->getCompanyTitle(); ?>
    <?php endif; ?>
    <div class="clear"></div>
</div>

