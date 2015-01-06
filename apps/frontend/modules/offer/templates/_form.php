<?php
$sCulture = $sf_user->getCulture();

// company offer
$formObject = $form->getObject();
if ($formObject->isNew()) {
    $formUri = 'offer/new?slug=' . $company->getSlug();
} else {
    $formUri = 'offer/edit?';
    if ($active) {
        $formUri .= 'active=1&id=%d';
    } else {
        $formUri .= 'id=%d';
    }
    $formUri = sprintf($formUri, $formObject->getId());
}

$action = $sf_request->getParameter('action');

?>
<form class="dealForm" id="offerForm" action="<?php echo url_for($formUri); ?>" method="post" <?php echo $form->isMultipart() ? 'enctype="multipart/form-data"' : ''; ?>>
    <input type="hidden" id="x1" name="x1" value=''/>
    <input type="hidden" id="y1" name="y1" value=''/>
    <input type="hidden" id="x2" name="x2" value=''/>
    <input type="hidden" id="y2" name="y2" value=''/>
    <input type="hidden" id="width" name="width" value=''/>
    <input type="hidden" id="height" name="height" value=''/>

  
    <?php if ($sf_user->hasFlash('newerror')): ?>
        <div class="form-message error">
            <p><?php echo __($sf_user->getFlash('newerror')); ?></p>
        </div>
    <?php endif; ?>
    <?php if ($form->hasGlobalErrors()): ?>
        <div class="form-message error">
            <?php foreach ($form->getGlobalErrors() as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach ?>
        </div>
    <?php endif; ?>

    <?php echo $form->renderHiddenFields(false) ?>

       
        <div class="row">
            <?php if (isset($form['active_from'])): ?>
                <div class="col-sm-6">
                    <div class="default-input-wrapper required <?php echo $form['active_from']->hasError() ? 'incorrect' : '' ?>">
                        <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                        <?php echo $form['active_from']->renderLabel(null, array('for' => $form['active_from']->getName(), 'class' => 'default-label')) ?>
                        <?php echo $form['active_from']->render(array('class' => 'default-input', 'placeholder' => $form['active_from']->renderPlaceholder())); ?>             
                        <div class="error-txt"><?php echo $form['active_from']->renderError() ?></div>
                    </div>

                    <?php if (($formObject->isNew() || $formObject->getIsDraft()) && $formObject->getAdServiceCompany()->getActiveFrom()){
                        $product_end_date = strtotime('+3 months', strtotime($formObject->getAdServiceCompany()->getActiveFrom()));
                        $offerEndDate = strtotime('+3 months',strtotime($formObject->getAdServiceCompany()->getActiveFrom()));
                    ?>
                    <a class="tip activeFrom">
                        <span class="details"><?php echo sprintf(__('The offer start date can not be later than %s', null, 'form'), date('d.m.Y', $product_end_date)); ?></span>
                    </a>
                <?php } ?>
                </div>
            <?php endif; ?>
        
            <?php if (isset($form['active_to'])): ?>
                <div class="col-sm-6">
                    <div class="default-input-wrapper required <?php echo $form['active_to']->hasError() ? 'incorrect' : '' ?>">
                        <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                        <?php echo $form['active_to']->renderLabel(null, array('for' => $form['active_to']->getName(), 'class' => 'default-label')) ?>
                        <?php echo $form['active_to']->render(array('class' => 'default-input', 'placeholder' => $form['active_to']->renderPlaceholder())); ?>             
                        <div class="error-txt"><?php echo $form['active_to']->renderError() ?></div>
                    </div>
                </div>

                <?php 
                    $product_end_date = strtotime('+29 days', strtotime($formObject->getActiveFrom())); 
                    $dealActiveTo = strtotime('+1 days', strtotime($formObject->getActiveFrom()));
                    $voucherMinDate = strtotime(($formObject->getActiveFrom()));
                ?>
                <?php if (!$formObject->isNew() && !$formObject->getIsDraft() && $formObject->getActiveFrom()){ ?>
                    <a class="tip endDate">
                        <span class="details"><?php echo sprintf(__('The offer end date can not be later than %s', null, 'form'), date('d.m.Y', $product_end_date)); ?></span>
                    </a>
                    <?php $offerEndDate = strtotime('+29 days', strtotime($formObject->getActiveFrom())); ?>
                <?php 
                } elseif ($formObject->getAdServiceCompany()->getActiveFrom()){
                    $offer_max_end_date = strtotime('+30 days', $product_end_date);
                } elseif ((!$formObject->isNew() || $formObject->getIsDraft()) && $formObject->getAdServiceCompany()->getActiveFrom()){
                    $product_end_date = strtotime('+3 months', strtotime($formObject->getAdServiceCompany()->getActiveFrom()));
                }
                ?>
            <?php endif; ?>
        </div>

        <div class="row">
            <?php if (isset($form['valid_from'])): ?>
                <div class="col-sm-6">
                    <div class="default-input-wrapper required <?php echo $form['valid_from']->hasError() ? 'incorrect' : '' ?>">
                        <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                        <?php echo $form['valid_from']->renderLabel(null, array('for' => $form['valid_from']->getName(), 'class' => 'default-label')) ?>
                        <?php echo $form['valid_from']->render(array('class' => 'default-input', 'placeholder' => $form['valid_from']->renderPlaceholder(), 'readonly' => "readonly")); ?>             
                        <div class="error-txt"><?php echo $form['valid_from']->renderError() ?></div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($form['valid_to'])): ?>
                <div class="col-sm-6">
                    <div class="default-input-wrapper required <?php echo $form['valid_to']->hasError() ? 'incorrect' : '' ?>">
                        <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                        <?php echo $form['valid_to']->renderLabel(null, array('for' => $form['valid_to']->getName(), 'class' => 'default-label')) ?>
                        <?php echo $form['valid_to']->render(array('class' => 'default-input', 'placeholder' => $form['valid_to']->renderPlaceholder(), 'readonly' => "readonly")); ?>             
                        <div class="error-txt"><?php echo $form['valid_to']->renderError() ?></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>


        <div class="row">
            <div class="col-sm-4">
                <div class="default-input-wrapper <?php echo $form['max_vouchers']->hasError() ? 'incorrect' : '' ?>">
                    <?php echo $form['max_vouchers']->renderLabel(null, array('for' => $form['max_vouchers']->getName(), 'class' => 'default-label')) ?>
                    <?php echo $form['max_vouchers']->render(array('class' => 'default-input', 'placeholder' => $form['max_vouchers']->renderPlaceholder())); ?>             
                    <div class="error-txt"><?php echo $form['max_vouchers']->renderError() ?></div>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="default-input-wrapper required <?php echo $form['max_per_user']->hasError() ? 'incorrect' : '' ?>">
                    <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                    <?php echo $form['max_per_user']->renderLabel(null, array('for' => $form['max_per_user']->getName(), 'class' => 'default-label')) ?>
                    <?php echo $form['max_per_user']->render(array('class' => 'default-input', 'placeholder' => $form['max_per_user']->renderPlaceholder())); ?>             
                    <div class="error-txt"><?php echo $form['max_per_user']->renderError() ?></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="file-input-wrapper upload <?php echo $form['file']->hasError() ? 'incorrect' : '' ?>">
                    <label for="fileUpload" class="file-label">
                        <?php echo __('No File chosen', null, 'form'); ?>
                        <?php echo $form['file']->render(array('id' => 'fileUpload', 'class' => 'file-input', 'accept'=>"image/*")) ?>
                    </label>
                    <a id="clearImage" class="default-btn" style="display:none;"><?php echo __('Clear image', null, 'form')?></a>
                    <div class="error-txt"><?php echo $form['file']->renderError(); ?></div>
                </div>

                <ul class="error_list image-invalid" style="display:none;max-width:272px;"><li><?php echo __('The file you submitted is not in a valid format. Please upload a JPG, GIF or PNG image file.', null, 'form')?></li></ul>
                <ul class="error_list no-image" style="display:none; max-width:272px;"><li><?php echo __('The field is mandatory', null, 'form'); ?></li></ul>

            </div>
        </div>

        <div class="image_crop_wrapper" style="display:none">
            <ul class="error_list image_no_selection" style="display:none;"><li>Please make a selection</li></ul>
            <div class="crop_tool_labels">
               <label id="crop"><?php echo __('Select the area from the image that you want to appear in your Offer', null, 'form')?></label>
               <label id="image_preview"><?php echo __('Image Preview', null, 'form')?></label>
            </div>
            <div id="preview-pane" >
              <div class="preview-container" >
                <img id ="smallPreview" class="jcrop-preview" style="" />
              </div>
            </div>
            <div id="imgDiv">
              <img  id="bigPreview"/>
            </div>
        </div>

        <?php if (!$formObject->isNew()  && $formObject->getImageId()): ?>
            <div class="current_offer_image">
                <div class="row">
                    <div class="col-sm-12">
                        <label class="current_img_label"><?php echo __('Offer image', null, 'form')?></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?php echo image_tag($formObject->getImage()->getFile(), array('class'=>'current_image', 'size' => '260x200')); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div id="message"></div>

        <!-- BENEFITS -->
        <div class="row offer_benefits_wrap">

            <div class="col-sm-6">
                <div class="benefit_choice"<?php echo $form['benefit_choice']->hasError() ? ' error' : '' ?>>
                    <?php echo $form['benefit_choice']->renderLabel(null, array('class' => 'benefit-choice-label')) ?>
                    <?php echo $form['benefit_choice']->render() ?>
                    <?php echo $form['benefit_choice']->renderError() ?>
                </div>
            </div>

            <div class="option_fields_wrap">
                <div class="col-sm-6">
                    <div class="option_1">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="default-input-wrapper <?php echo $form['new_price']->hasError() ? 'incorrect' : '' ?>">
                                    <?php echo $form['new_price']->renderLabel(null, array('for' => $form['new_price']->getName(), 'class' => 'default-label')) ?>
                                    <?php echo $form['new_price']->render(array('class' => 'default-input', 'placeholder' => $form['new_price']->renderPlaceholder())); ?>             
                                    <div class="error-txt"><?php echo $form['new_price']->renderError() ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="default-input-wrapper <?php echo $form['old_price']->hasError() ? 'incorrect' : '' ?>">
                                    <?php echo $form['old_price']->renderLabel(null, array('for' => $form['old_price']->getName(), 'class' => 'default-label')) ?>
                                    <?php echo $form['old_price']->render(array('class' => 'default-input', 'placeholder' => $form['old_price']->renderPlaceholder())); ?>             
                                    <div class="error-txt"><?php echo $form['old_price']->renderError() ?></div>
                                </div>
                            </div>
                        </div>

                        <?php if($sf_user->getCulture() == 'sr'): ?>
                            <p>RSD</p>
                        <?php endif; ?>
                    </div>

                    <div class="option_2">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="default-input-wrapper <?php echo $form['discount_pct']->hasError() ? 'incorrect' : '' ?>">
                                    <?php echo $form['discount_pct']->renderLabel(null, array('for' => $form['discount_pct']->getName(), 'class' => 'default-label')) ?>
                                    <?php echo $form['discount_pct']->render(array('class' => 'default-input', 'placeholder' => $form['discount_pct']->renderPlaceholder())); ?>             
                                    <div class="error-txt"><?php echo $form['discount_pct']->renderError() ?></div>
                                </div>

                                <span class="percent_sign"><?php echo ('% ');?></span>
                                <span><?php echo __('discount', null, 'form');?></span>
                            </div>
                        </div>
                    </div>

                    <div class="option_3">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="default-input-wrapper <?php echo $form['benefit_text']->hasError() ? 'incorrect' : '' ?>">
                                    <?php echo $form['benefit_text']->renderLabel(null, array('for' => $form['benefit_text']->getName(), 'class' => 'default-label')) ?>
                                    <?php echo $form['benefit_text']->render(array('class' => 'default-input', 'placeholder' => $form['benefit_text']->renderPlaceholder())); ?>             
                                    <div class="error-txt"><?php echo $form['benefit_text']->renderError() ?></div>
                                </div>

                                <dt id='stat'><label><span>33</span><?php echo __(' characters left', null, 'form');?></label></dt>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END BENEFITS -->  


    <?php if ($formObject->isNew() or $formObject->canEdit() or $sf_user->isGetlokalAdmin()){
        $number_of_languages = count(getlokalPartner::getEmbeddedLanguages());
        foreach (getlokalPartner::getEmbeddedLanguages() as $lang){
            if (!isset($form[$lang])) {
                continue;
            }
    ?>
            <h2 class="form-title">
                <?php echo ($lang != 'en') ? $form[$lang]['title']->renderPlaceholder() . ' (' . __(sfConfig::get('app_culture_native_'.$lang)) . ')' : $form['en']['title']->renderPlaceholder() . ' (' . __('English') . ')'; ?>
            </h2>
            <div class="row">
                <div class="col-sm-12 <?php echo $form[$lang]['title']->hasError() ? 'error' : '' ?>">
                    <div class="default-input-wrapper <?php echo $form[$lang]['title']->hasError() ? 'incorrect' : '' ?>">
                        <?php echo $form[$lang]['title']->render(array('class' => 'default-input', 'placeholder' => $form[$lang]['title']->renderPlaceholder())); ?>             
                        <div class="error-txt"><?php echo $form[$lang]['title']->renderError() ?></div>
                    </div>
                </div>
            </div>

            <h2 class="form-title">
                <?php echo ($lang != 'en') ? $form[$lang]['content']->renderPlaceholder() . ' (' . __(sfConfig::get('app_culture_native_'.$lang)) . ')' : $form['en']['content']->renderPlaceholder() . ' (' . __('English') . ')'; ?>
            </h2>

            <!-- TODO tooltip -->
            <span class="details"><?php echo(__('When you publish an Offer please give details of its terms, timing and content e.g. "Get 20% off a weekend for two in hotel X. The offer is valid only for the period between 20.08 and 27.08. The discount applies to advanced bookings only.', null, 'form')); ?></span>
            <div class="row">
                <div class="col-sm-12 <?php echo $form[$lang]['content']->hasError() ? 'error' : '' ?>">
                    <div class="default-input-wrapper <?php echo $form[$lang]['content']->hasError() ? 'incorrect' : '' ?>">
                        <?php echo $form[$lang]['content']->render(); ?>             
                        <div class="error-txt"><?php echo $form[$lang]['content']->renderError() ?></div>
                    </div>
                </div>
            </div>
    <?php 
        }
    }
    ?>

    <div class="row">
        <div class="col-sm-12 form-btn-row">
            <input type="submit" value="<?php echo __('Publish', null, 'messages'); ?>" class="default-btn success pull-right input_submit save_offer" />
            <?php if ($formObject->isNew() || $formObject->getIsDraft()): ?>
                <input type="submit" name="draft" value="<?php echo __('Save Draft', null, 'form'); ?>" class="default-btn success pull-right input_submit" />
            <?php endif; ?>
        </div>
    </div>
</form>

<script type="text/javascript">
    //Prevent Multiple records in DB on submit multiple click
   
    <?php 
        if (!isset($offerEndDate)) {
		    if (isset($company_offer)) {
        	    if ($company_offer->getAdServiceCompany()->getStatus() != 'registered') {
				    $offerEndDate = strtotime('+3 months', strtotime($company_offer->getAdServiceCompany()->getActiveFrom()));
				}
			}
        }
        
    ?>
   $(document).ready(function(){
     offerFormJS();
     // flashErrorMessage();
         // <?php if ($sf_user->getCulture() == 'en'): ?>     
         //    <?php elseif ($sf_user->getCulture() == 'bg'): ?>
         //      offerBenefitChoiseBG();
         //    <?php elseif ($sf_user->getCulture() == 'mk'): ?>
         //       offerBenefitChoiseMK(); 
         //    <?php elseif ($sf_user->getCulture() == 'sr'): ?>
         //      offerBenefitChoiseSR();
         //    <?php elseif ($sf_user->getCulture() == 'ro'): ?>
         //       offerBenefitChoiseRO();
         //    <?php endif; ?> 
     <?php if (isset($offerEndDate)):?>
        var offerMaxEndDate = '<?php echo date("d.m.y 23:59:59", $offerEndDate) ?>';
        var voucherMinDate = '<?php echo date("d.m.y", $voucherMinDate) ?>';
        var dealActiveTo = '<?php echo date("d.m.y", $dealActiveTo) ?>';
        var sCulture = '<?php echo $sCulture; ?>';
        var str = '<?php echo __("The offer end date can not be later than", null, 'form'); ?>';
        offerDatepickers(offerMaxEndDate, voucherMinDate, dealActiveTo, sCulture, str);
     <?php endif; ?>
});
</script>

<style>
#ui-datepicker-div {
    z-index: 999!important;
}
.input_submit{
    margin-top: 20px;
}
.benefit_choice .radio_list{
    list-style: none;
}
</style>