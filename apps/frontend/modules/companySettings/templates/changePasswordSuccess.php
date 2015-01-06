<?php
include_partial('global/commonSlider');
$params = array('company' => $company, 'adminuser' => $adminuser, 'companies' => $companies, 'is_getlokal_admin' => $is_getlokal_admin);
?>

<?php use_helper('jQuery') ?>

<div class="container set-over-slider">
    <div class="row"> 
        <div class="container">
            <div class="row">
                <?php include_partial('topMenu', $params); ?> 
            </div>
        </div>            
    </div>    
    <div class="col-sm-4">
        <div class="section-categories">
            <?php include_partial('rightMenu', $params); ?>             
        </div>
    </div>
    <div class="col-sm-8">
        <div class="content-default">             
            <div class="row">
                <div class="default-container default-form-wrapper col-sm-12">
                    <h2 class="form-title"><?php echo __('Change Password') ?></h2>

                    <?php if ($sf_user->getFlash('notice')): ?> 
                        <div class="form-message success">
                            <p><?php echo __($sf_user->getFlash('notice')) ?></p>
                        </div> 
                    <?php endif; ?>

                    <form action="<?php echo url_for('companySettings/changePassword?slug=' . $company->getSlug()) ?>" method="post">
                        <?php echo $form[$form->getCSRFFieldName()]; ?>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="default-input-wrapper required <?php echo $form['old_password']->hasError() ? 'incorrect' : '' ?>">
                                    <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                                    <?php echo $form['old_password']->renderLabel(null, array('for' => $form['old_password']->getName(), 'class' => 'default-label')) ?>
                                    <?php echo $form['old_password']->render(array('class' => 'default-input', 'placeholder' => $form['old_password']->renderPlaceholder())); ?>             
                                    <div class="error-txt"><?php echo $form['old_password']->renderError() ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="default-input-wrapper required <?php echo $form['new_password']->hasError() ? 'incorrect' : '' ?>">
                                    <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                                    <?php echo $form['new_password']->renderLabel(null, array('for' => $form['new_password']->getName(), 'class' => 'default-label')) ?>
                                    <?php echo $form['new_password']->render(array('class' => 'default-input', 'placeholder' => $form['new_password']->renderPlaceholder())); ?>             
                                    <div class="error-txt"><?php echo $form['new_password']->renderError() ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="default-input-wrapper required <?php echo $form['bis_password']->hasError() ? 'incorrect' : '' ?>">
                                    <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                                    <?php echo $form['bis_password']->renderLabel(null, array('for' => $form['bis_password']->getName(), 'class' => 'default-label')) ?>
                                    <?php echo $form['bis_password']->render(array('class' => 'default-input', 'placeholder' => $form['bis_password']->renderPlaceholder())); ?>             
                                    <div class="error-txt"><?php echo $form['bis_password']->renderError() ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 form-btn-row">
                                <input type="submit" value="<?php echo __('Save'); ?>" class="default-btn success pull-right" />
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
