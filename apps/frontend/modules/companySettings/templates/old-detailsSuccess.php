<?php slot('no_map', true) ?>
<?php slot('no_ads', true) ?>

<?php $lng = mb_convert_case(getlokalPartner::getLanguageClass(), MB_CASE_LOWER,'UTF-8');   ?>
<?php $current_culture = sfContext::getInstance()->getUser()->getCulture();   ?>
<?php $languages = sfConfig::get('app_languages_'.$lng)?>

<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>
<div class="settings_content company_description">
    <h2 class="dotted"><?php echo __('Description', null, 'company') ?></h2>

    <form id="cs-form" action="<?php echo url_for('companySettings/details?slug=' . $company->getSlug()) ?>" method="post"

        <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>  onsubmit="tinyMCE.triggerSave();">
        <?php echo $form['_csrf_token']->render() ?>
        <?php if ($company->getActivePPPService(true) || $company->getRegisteredPPPService(true)): ?>
        <div class="feature_icons">
            <p><?php echo __('Choose features', null, 'company') ?></p>
            <?php  //if ($form->getObject()->getActivePPPService(true)):?>
            <div class="form_box <?php echo $form[$lng]['description']->hasError() ? 'error' : '' ?>">
                <?php //echo $form['feature_company_list']->renderLabel() ?>
                <?php echo $form['feature_company_list']->render() ?>
                <?php //echo $form['feature_company_list']->renderError() ?>
            </div>
            <div class="form_outdoor_seats" style="display:none;">
                <div class="form_outdoor_seats_mask" style="display:none;"></div>
                <label><?php echo __('Number of outdoor seats:', null, 'company') ?></label>
                <?php echo $form['outdoor_seats']->render() ?>
                <a  title="" class="button_green"><?php echo __('Add', null, 'company') ?></a>
                <a title="" alt ="" class="button_green clear_btn"><?php echo __('Clear', null, 'company') ?></a>
                <a title="" id="picture_form_close" href="#">
                    <img alt ="" src="/images/gui/close_small.png">
                </a>
            </div>
            <div class="form_indoor_seats"  style="display:none;">
                <div class="form_indoor_seats_mask" style="display:none;"></div>
                <label><?php echo __('Number of indoor seats:', null, 'company') ?></label>
                <?php echo $form['indoor_seats']->render() ?>
                <a class="button_green"><?php echo __('Add', null, 'company') ?></a>
                <a class="button_green clear_btn"><?php echo __('Clear', null, 'company') ?></a>
                <a id="picture_form_close">
                    <img src="/images/gui/close_small.png">
                </a>
            </div>
            <div class="form_wifi"  style="display:none;">
                <div class="form_wifi_mask" style="display:none;"></div>
                <h3>Wi-Fi</h3>
                <?php echo $form['wifi_access']->render() ?>

                <div class="clear"></div>
                <a class="button_green"><?php echo __('Add', null, 'company') ?></a>
                <a class="button_green clear_btn"><?php echo __('Clear', null, 'company') ?></a>
                <a  id="picture_form_close">
                    <img src="/images/gui/close_small.png">
                </a>
            </div>
        </div>
        <?php endif; ?>
        <div class="form_box <?php echo $form[$lng]['description']->hasError() ? 'error' : '' ?>">
            <!-- Label should be "About us" -->
            <?php echo $form[$lng]['description']->renderLabel() ?>
            <?php echo $form[$lng]['description']->render() ?>

            <?php echo $form[$lng]['description']->renderError() ?>
            
            
        </div>
        <div class="form_box <?php echo $form['en']['description']->hasError() ? 'error' : '' ?>">
            <?php echo __('Description (English)', null, 'form')?>
            <?php echo $form['en']['description']->render(array('value' => $company->getDescription(), 'class'=>'auto_submit_item')); ?>

            <?php echo $form['en']['description']->renderError() ?>
        </div>

        
        <?php if(count($languages)>2):?>
            <?php foreach ($languages as $language):?>
                <?php if($language != 'en' && $language != $lng):?>
                    <div class="form_box <?php echo $form[$language]['description']->hasError() ? 'error' : '' ?>">
                        <?php echo __('Description ('.sfConfig::get('app_cultures_en_'.$language).')', null, 'form')?>
                        <?php echo $form[$language]['description']->render(array('value' => $company->getDescription(), 'class'=>'auto_submit_item')); ?>

                        <?php echo $form[$language]['description']->renderError() ?>
                    </div>
                <?php endif;?>
            <?php endforeach;?>
        <?php endif;?>
        <?php if ($company->getActivePPPService(true) or $company->getRegisteredPPPService(true)): ?>    

            <div class="form_box <?php echo $form[$lng]['content']->hasError() ? 'error' : '' ?>">
                <?php echo $form[$lng]['content']->renderLabel() ?>
                <?php echo $form[$lng]['content']->render(array('class' => 'tinyMCE')) ?>

                <?php echo $form[$lng]['content']->renderError() ?>
            </div>
            <div class="form_box <?php echo $form['en']['content']->hasError() ? 'error' : '' ?>">
                
                <?php echo __('Detailed Description (English)', null, 'form')?>
                <?php echo $form['en']['content']->render(array('class' => 'tinyMCE')) ?>

                <?php echo $form['en']['content']->renderError() ?>
            </div>
        
            <?php if(count($languages)>2):?>
                <?php foreach ($languages as $language):?>
                    <?php if($language != 'en' && $language != $lng):?>
                        <div class="form_box <?php echo $form[$language]['content']->hasError() ? 'error' : '' ?>">
                            <?php echo __('Detailed Description ('.sfConfig::get('app_cultures_en_'.$language).')', null, 'form')?>
                            <?php echo $form[$language]['content']->render(array('class' => 'tinyMCE')) ?>

                            <?php echo $form[$language]['content']->renderError() ?>
                        </div>
                    <?php endif;?>
                <?php endforeach;?>
            <?php endif; ?>
        <?php endif; ?>
        <div class="form_box">
            <input type="submit" value="<?php echo __('Save'); ?>" class="button_green" />
            <div class="clear"></div>
        </div>
    </form>
</div>
<div class="clear"></div>

<script type="text/javascript">
    $(document).ready(function () { 
        <?php if($company->getActivePPPService(true)): ?>
            rupaIcons();
        <?php endif; ?>
    });
    $(window).bind("load", function() {
        $("#descriptions_bg_content_ifr").contents().keydown(function(){ formChanged = true;});
        $("#descriptions_en_content_ifr").contents().keydown(function(){ formChanged = true;});
    });
</script>
