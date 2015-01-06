<?php slot('no_map', true) ?>
<div class="settings_content">
    <h2><?php echo __('Communication', null, 'company') ?></h2>
    <h4><?php echo __('I would like to receive:', null, 'company') ?></h4>
    <form action="<?php echo url_for('userSettings/communication') ?>" method="post">
        <div class="form_box <?php echo $form['allow_contact']->hasError() ? 'error' : '' ?>">
            <?php if ($user->getUserProfile()->getUserSetting()->getAllowContact()) : ?>
                <input <?php echo ($user->getUserProfile()->getUserSetting()->getAllowContact()) ? 'checked="checked"' : '' ?>  onclick="showhideText(this,'all')" type="checkbox" id="communication_settings_allow_contact" name="communication_settings[allow_contact]">
            <?php else : ?>
                <input onclick="showhideText(this,'all')" type="checkbox" id="communication_settings_allow_contact" name="communication_settings[allow_contact]">
            <?php endif; ?>

            <?php echo __('General Communication', null, 'user') ?>

            <?php //echo $form['allow_contact']->render(array('onclick' => "showhideText(this,'all')")) ?>
            <?php //echo __('I agree to receive messages from getlokal and/or their partners.', null, 'user') ?>
            <?php /*<a href="<?php echo url_for('@static_page?slug=terms-of-use'); ?>"><?php echo __('Terms of Use') ?></a>*/ ?>
            <?php echo $form['allow_contact']->renderError() ?>
        </div>

        <?php //if (isset($usernewsletters) && $usernewsletters): ?>
        <?php 
            if ($user->getUserProfile()->getCountry()->getSlug() == 'bg') {
                $newsletterUser = 'Развлекателни бюлетини';
                $newsletterBusiness = 'Бизнес бюлетини';
                $newsletterPromo = 'Известия за игри и промоции';

                $newsletterGroups = array($newsletterUser, $newsletterBusiness, $newsletterPromo);
            } 
            elseif ($user->getUserProfile()->getCountry()->getSlug() == 'ro') {
                $newsletterUser = 'Newsletter de comunitate';
                $newsletterBusiness = 'Newsletter business';
                $newsletterPromo = 'Jocuri si promotii';

                $newsletterGroups = array($newsletterUser, $newsletterBusiness, $newsletterPromo);
            }
            else {
                $newsletterUser = 'Community newsletters';
                $newsletterBusiness = 'Business newsletters';
                $newsletterPromo = 'Games and promotions';

                $newsletterGroups = array($newsletterUser, $newsletterBusiness, $newsletterPromo);
            }
        ?>
        
            <div class="newsletter" id="all" <?php if (!$user->getUserProfile()->getUserSetting()->getAllowContact()): ?>style="display: none;"<?php endif; ?>>
                <div class="form_box <?php echo $form['allow_newsletter']->hasError() ? 'error' : '' ?>">
                    
                    <?php if ($user->getUserProfile()->getUserSetting()->getAllowNewsletter()) : ?>
                        <?php //echo $form['allow_newsletter']->render(array('onclick' => "showhideText(this,'newsletters')", 'checked' => 'checked')); ?>
                        <input onclick="showhideText(this,'newsletters')" type="checkbox" id="communication_settings_allow_newsletter" checked="checked" name="communication_settings[allow_newsletter]" />
                    <?php else : ?>
                        <?php //echo $form['allow_newsletter']->render(array('onclick' => "showhideText(this,'newsletters')", 'checked' => '')); ?>
                        <input onclick="showhideText(this,'newsletters')" type="checkbox" id="communication_settings_allow_newsletter" name="communication_settings[allow_newsletter]" />
                    <?php endif; ?>
                    <?php //echo __('I want to receive newsletters', null, 'user') ?>
                    <?php echo __('Community newsletters', null, 'user') ?>
                    <?php echo $form['allow_newsletter']->renderError() ?>
                </div>
                <?php if (isset($usernewsletters) && $usernewsletters) : ?>
                    <div id="newsletters" <?php if (!$user->getUserProfile()->getUserSetting()->getAllowNewsletter()): ?>style="display: none;"<?php endif; ?>>
                        <?php foreach ($usernewsletters as $key => $value): ?>
                            <?php $newsletter = Doctrine_Core::getTable('Newsletter')->findOneById($key); ?>


                            <?php if ($newsletter && $newsletter->getUserGroup() == $newsletterUser /*&& $newsletter->getCountryId() == $sf_user->getProfile()->getCountryId()*/): ?>
                                <?php $newsletterStatus = NewsletterUserTable::getPerUserAndNewsletter($user->getId(), $newsletter->getId()); ?>

                                <div>
                                    <input type="checkbox" id="communication_settings_newsletter_<?php echo $key; ?>" <?php echo ($newsletterStatus && $newsletterStatus->getIsActive()) ? 'checked="checked"' : '' /*if ($value == 1) { ?>CHECKED ="CHECKED"<?php }*/ ?>  name="communication_settings[newsletter_<?php echo $key; ?>]">
                                    <?php //echo sprintf(__('I want to receive getlokal\'s %s'), $newsletter->getName()); ?>
                                    <?php echo $newsletter->getName(); ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php //if ($user->getIsPageAdmin()): ?>
                <?php if ($user->getIsPageAdmin() || $sf_user->getProfile()->getUserSetting()->getAllowBCmc()): ?>
                    <div class="form_box <?php echo $form['allow_b_cmc']->hasError() ? 'error' : '' ?>">
                        <?php //echo $form['allow_b_cmc']->render(array('onclick' => "showhideText(this,'b_contact')")) ?>
                        
                        <?php if ($user->getUserProfile()->getUserSetting()->getAllowBCmc()) : ?>
                            <input onclick="showhideText(this,'b_contact')" type="checkbox" id="communication_settings_allow_b_cmc" checked="checked" name="communication_settings[allow_b_cmc]" />
                        <?php else : ?>
                            <input onclick="showhideText(this,'b_contact')" type="checkbox" id="communication_settings_allow_b_cmc" name="communication_settings[allow_b_cmc]" />
                        <?php endif ?>

                        <?php //echo __('I would like to receive getlokal\'s Business Newsletter and Notifications.', null, 'user') ?>
                        <?php echo __('Business newsletters', null, 'user') ?>
                        <?php echo $form['allow_b_cmc']->renderError() ?>
                    </div>

                    <?php if (isset($usernewsletters) && $usernewsletters) : ?>
                        <div id="b_contact" <?php if (!$user->getUserProfile()->getUserSetting()->getAllowBCmc()): ?>style="display: none;"<?php endif; ?>>
                            <?php foreach ($usernewsletters as $key => $value): ?>

                                <?php $newsletter = Doctrine_Core::getTable('Newsletter')->findOneById($key); ?>
                                <?php if ($newsletter && $newsletter->getUserGroup() == $newsletterBusiness): ?>
                                    <?php $newsletterStatus = NewsletterUserTable::getPerUserAndNewsletter($user->getId(), $newsletter->getId()); ?>

                                    <div>
                                        <input type="checkbox" id="communication_settings_newsletter_<?php echo $key; ?>" <?php echo ($newsletterStatus && $newsletterStatus->getIsActive()) ? 'checked="checked"' : '' /*echo ($value == 1) ? 'checked="checked"' : '';*/ ?>  name="communication_settings[newsletter_<?php echo $key; ?>]">
                                        <?php //echo sprintf(__('I want to receive getlokal\'s %s'), $newsletter->getName()); ?>
                                        <?php echo $newsletter->getName(); ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>


                <!-- Promo -->
                <div class="form_box <?php echo $form['allow_promo']->hasError() ? 'error' : '' ?>">
                    <?php //echo $form['allow_promo']->render(array('onclick' => "showhideText(this,'promo')")) ?>

                    <?php if ($user->getUserProfile()->getUserSetting()->getAllowPromo()) : ?>
                        <input onclick="showhideText(this,'promo')" type="checkbox" id="communication_settings_allow_promo" checked="checked" name="communication_settings[allow_promo]" />
                    <?php else : ?>
                        <input onclick="showhideText(this,'promo')" type="checkbox" id="communication_settings_allow_promo" name="communication_settings[allow_promo]" />
                    <?php endif ?>

                    <?php //echo __('I want to receive promo newsletters', null, 'user') ?>
                    <?php echo __('Games and promotions', null, 'user') ?>
                    <?php echo $form['allow_promo']->renderError() ?>
                </div>

                <?php if (isset($usernewsletters) && $usernewsletters) : ?>
                    <div id="promo" <?php if (!$user->getUserProfile()->getUserSetting()->getAllowPromo()): ?>style="display: none;"<?php endif; ?>>
                        <?php foreach ($usernewsletters as $key => $value): ?>

                            <?php $newsletter = Doctrine_Core::getTable('Newsletter')->findOneById($key); ?>
                            <?php if ($newsletter && $newsletter->getUserGroup() == $newsletterPromo): ?>
                                <?php $newsletterStatus = NewsletterUserTable::getPerUserAndNewsletter($user->getId(), $newsletter->getId()); ?>

                                <div>
                                    <input type="checkbox" id="communication_settings_newsletter_<?php echo $key; ?>" <?php echo ($newsletterStatus && $newsletterStatus->getIsActive()) ? 'checked="checked"' : '' /*echo ($value == 1) ? 'checked="checked"' : '';*/ ?>  name="communication_settings[newsletter_<?php echo $key; ?>]">
                                    <?php //echo sprintf(__('I want to receive getlokal\'s %s'), $newsletter->getName()); ?>
                                    <?php echo $newsletter->getName(); ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>


            </div>
        <?php //endif; ?>
        <?php echo $form['_csrf_token']->render() ?>
        <div class="form_box">
            <input type="submit" value="<?php echo __('Save') ?>" class="input_submit" />
        </div>
    </form>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('.path_wrap').css('display', 'none');
//        $('.search_bar').css('display', 'none');
        $(".banner").css("display", "none");
    });

    function showhideText(boxName,divId) {
        var ele = document.getElementById(divId);

        if(boxName.checked == true) {
            $(ele).show();
            //$(ele).attr('checked', true);
            //$(ele).children('div').children('input').attr('checked', true);
            //$(ele).children('div').children('div').children('input').attr('checked', true);
        }
        else {
            $(ele).hide();
            if (divId == 'all') {
                $("#newsletters, #b_contact, #promo").hide();
            }

            $('#' + divId).find('input[type="checkbox"]').removeAttr('checked');
            if ($('#' + divId).find('input[type="checkbox"]').parent().hasClass('ez-checked')) {
                $('#' + divId).find('input[type="checkbox"]').parent().removeClass('ez-checked');
            }

            //	$(ele).removeAttr('checked');
            //	$(ele).children('div').children('input').removeAttr('checked');
            //	$(ele).children('div').children('div').children('input').removeAttr('checked');
        }
    }
</script>