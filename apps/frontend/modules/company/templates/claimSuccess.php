<div class="slider_wrapper pp">
  <div class="slider-image">
    <div class="dim"></div>
  </div>
  <div class="slider-separator"></div>  
</div><!-- slider_wrapper -->

<div class="container set-over-slider">
    <div class="row">
        <div class="container">
            <div class="row">
                <h1 class="col-xs-12 main-form-title"><?php echo __('Claim Your Company', null, 'company'); ?></h1>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="default-container default-form-wrapper col-sm-12">

            <?php if ($sf_user->getFlash('newerror')) { ?>
                <div class="form-message error">
                    <p><?php echo __($sf_user->getFlash('newerror'), null, 'list'); ?></p>
                </div>
            <?php } ?>
            <?php if ($sf_user->getFlash('newsuccess')): ?> 
                <div class="form-message success">
                    <p><?php echo __($sf_user->getFlash('newsuccess'), null, 'list') ?></p>
                </div> 
            <?php endif; ?>

            <form action="<?php echo url_for('company/claim?slug=' . $company->getSlug()) ?>" method="post">
                
                <?php echo $form[$form->getCSRFFieldName()]; ?>


                <?php if (isset($form['user_profile']['sf_guard_user']) && isset($form['user_profile']['sf_guard_user']['first_name'])): ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="default-input-wrapper active <?php echo $form['user_profile']['sf_guard_user']['first_name']->hasError() ? 'incorrect' : '' ?>">
                                <?php echo $form['user_profile']['sf_guard_user']['first_name']->renderLabel(null, array('class' => 'default-label')) ?>
                                <?php echo $form['user_profile']['sf_guard_user']['first_name']->render(array('class' => 'default-input')); ?>
                                <div class="error-txt"><?php echo $form['user_profile']['sf_guard_user']['first_name']->renderError() ?></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($form['user_profile']['sf_guard_user']) && isset($form['user_profile']['sf_guard_user']['last_name'])): ?>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="default-input-wrapper active <?php echo $form['user_profile']['sf_guard_user']['last_name']->hasError() ? 'incorrect' : '' ?>">
                                <?php echo $form['user_profile']['sf_guard_user']['last_name']->renderLabel(null, array('class' => 'default-label')) ?>
                                <?php echo $form['user_profile']['sf_guard_user']['last_name']->render(array('class' => 'default-input')); ?>
                                <div class="error-txt"><?php echo $form['user_profile']['sf_guard_user']['last_name']->renderError() ?></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>


                <?php if (isset($form['user_profile']['birthdate'])): ?>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="default-input-wrapper active <?php echo $form['user_profile']['birthdate']->hasError() ? 'incorrect' : '' ?>">
                                <?php echo $form['user_profile']['birthdate']->renderLabel(null, array('class' => 'default-label')) ?>
                                <?php echo $form['user_profile']['birthdate']->render(array('class' => 'default-input')); ?>
                                <div class="error-txt"><?php echo $form['user_profile']['birthdate']->renderError() ?></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <?php /* 
                    <?php  if (isset($form['user_profile']['phone_number'])): ?>
                        <p class="form-description"><?php echo __('The correct format to use is 023456789 or for mobile phones 0888888888. Add only the local area code for landlines. Only add digits – any other characters or spaces between characters are not allowed.', null, 'company'); ?></p>
                    <?php endif; ?>
                    */ ?>
<!-- accept terms of use and pivacy policy error --> <div class="form-message error p-none clearfix">
                                    <?php echo $form['accept']->renderError() ?>
                                </div> <!-- accept terms of use and pivacy policy -->

                    <?php if (isset($form['user_profile']['gender'])): ?>
                        <div class="col-sm-3">
                            <div class="default-input-wrapper select-wrapper <?php echo $form['user_profile']['gender']->hasError() ? 'incorrect' : '' ?>">
                                <?php echo $form['user_profile']['gender']->renderLabel(null, array('class' => 'default-label')) ?>
                                <?php echo $form['user_profile']['gender']->render(array('class' => 'default-input')); ?>
                                <div class="error-txt"><?php echo $form['user_profile']['gender']->renderError() ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($form['user_profile']['phone_number'])): ?>
                        <div class="col-sm-3">
                            <div class="default-input-wrapper <?php echo $form['user_profile']['phone_number']->hasError() ? 'incorrect' : '' ?>">
                                <?php echo $form['user_profile']['phone_number']->renderLabel(null, array('class' => 'default-label')) ?>
                                <?php echo $form['user_profile']['phone_number']->render(array('class' => 'default-input')); ?>
                                <div class="error-txt"><?php echo $form['user_profile']['phone_number']->renderError() ?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                                            

                    <div class="col-sm-6">
                        <div class="default-input-wrapper active select-wrapper required <?php echo $form['position']->hasError() ? 'incorrect' : '' ?>">
                            <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                            <?php echo $form['position']->renderLabel(null, array('class' => 'default-label')) ?>
                            <?php echo $form['position']->render(array('class' => 'default-input')); ?>
                            <div class="error-txt"><?php echo $form['position']->renderError() ?></div>
                        </div>
                    </div>
                </div>

            <?php if (isset($form['registration_no']) && $sf_user->getAttribute('country_id') != getlokalPartner::GETLOKAL_MK): ?>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="default-input-wrapper required <?php echo $form['registration_no']->hasError() ? 'incorrect' : '' ?>">
                            <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>

                            <label class="default-label">
                                <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG): ?>
                                    <?php echo __('Enter your EIK/Bulstat'); ?>
                                <?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
                                    <?php echo __('Enter the CUI of your business'); ?>
                                <?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RS): ?>
                                    <?php echo __('Enter your EIK/Bulstat'); ?>
                                <?php else: ?>
                                    <?php echo __('Enter your EIK/Bulstat'); ?>
                                <?php endif; ?>
                            </label>

                            <?php echo $form['registration_no']->render(array('class' => 'default-input')); ?>
                            <div class="error-txt"><?php echo $form['registration_no']->renderError() ?></div>
                        </div>
                    </div>

                    <?php if (isset($form['username'])): ?>
                        <div class="col-sm-4">
                            <div class="default-input-wrapper required <?php echo $form['username']->hasError() ? 'incorrect' : '' ?>">
                                <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                                <?php echo $form['username']->renderLabel(null, array('class' => 'default-label')) ?>
                                <?php echo $form['username']->render(array('class' => 'default-input')); ?>
                                <div class="error-txt h-19"><?php echo $form['username']->renderError() ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($form['password'])): ?>
                        <div class="col-sm-4">
                            <div class="default-input-wrapper active required <?php echo $form['password']->hasError() ? 'incorrect' : '' ?>">
                                <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                                <?php echo $form['password']->renderLabel(null, array('class' => 'default-label')) ?>
                                <?php echo $form['password']->render(array('class' => 'default-input')); ?>
                                <div class="error-txt"><?php echo $form['password']->renderError() ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

            <?php if (isset($form['allow_b_cmc'])): ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="default-checkbox <?php echo $form['allow_b_cmc']->hasError() ? 'incorrect' : '' ?>">
                            <?php echo $form['allow_b_cmc']->render(array('class' => 'checkbox', 'id' => 'newsletter')); ?>
                            <div class="fake-box"></div>
                            <div class="error-txt"><?php echo $form['allow_b_cmc']->renderError() ?></div>
                        </div>
                        <label for="newsletter"class="default-checkbox-label">
                            <?php echo __("I would like to receive Getlokal's Business Newsletter and Notifications.", null, 'company'); ?>
                        </label>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($form['accept'])): ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="default-checkbox <?php echo $form['accept']->hasError() ? 'incorrect' : '' ?>">
                            <?php echo $form['accept']->render(array('class' => 'checkbox', 'id' => 'rules')); ?>
                            <div class="fake-box"></div>
                            <div class="error-txt"></div>
                        </div>
                        <label for="rules" class="default-checkbox-label">
                            <?php echo sprintf(__('I have the necessary representative powers and I agree to the %s and the %s'), link_to(__('Terms of Use'), '@static_page?slug=terms-of-use', array('popup' => true, 'class' => 'default-link')), link_to(__('Policy for Use and Protection of the Information on the Getlokal Website', null, 'user'), '@static_page?slug=privacy-policy', array('popup' => true, 'class' => 'default-link'))); ?>
                        </label>
                    </div>
                </div>
            <?php endif; ?>


            <div class="row">
                <div class="col-sm-12 form-btn-row">
                    <input type="submit" value="<?php echo __('Send'); ?>" class="default-btn success pull-right " />
                </div>
            </div>

        </form>
    </div>
</div><!-- END default-form-wrapper -->
</div>

