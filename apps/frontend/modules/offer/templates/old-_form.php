<?php use_stylesheet('ui-lightness/jquery-ui-1.8.16.custom.css'); ?>
<?php use_javascript('init_date_picker.js'); ?>
<?php use_javascript('jquery-ui-i18n-' . mb_convert_case(getlokalPartner::getLanguageClass(), MB_CASE_LOWER, 'UTF-8') . '.js'); ?>
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
        <div class="flash_error global_error">
            <?php echo __($sf_user->getFlash('newerror')) ?>
        </div>
    <?php endif; ?>
    <?php if ($form->hasGlobalErrors()): ?>
        <div class="flash_error">
            <?php foreach ($form->getGlobalErrors() as $error): ?>
                <?php echo $error; ?><br>
            <?php endforeach ?>
        </div>
    <?php endif; ?>
    <?php echo $form->renderHiddenFields(false) ?>
    <?php if(isset($form['active_from']) || isset($form['active_to'])): ?>
    <div class="additional_info_gray_bg">
        <?php //echo $form->renderHiddenFields(false) ?>
        <?php if (isset($form['active_from'])): ?>
            <div class="form_box tip form_label_inline<?php echo $form['active_from']->hasError() ? 'error' : '' ?>">
                <?php echo $form['active_from']->renderLabel() ?>
                <span class="pink">&nbsp;*</span>
                <?php echo $form['active_from']->render(array('readonly' => "readonly")) ?>
                <?php echo $form['active_from']->renderError() ?>
                <?php if (($formObject->isNew() || $formObject->getIsDraft()) && $formObject->getAdServiceCompany()->getActiveFrom()): ?>
                    <?php $product_end_date = strtotime('+3 months', strtotime($formObject->getAdServiceCompany()->getActiveFrom())); ?>
                    <?php $offerEndDate = strtotime('+3 months',strtotime($formObject->getAdServiceCompany()->getActiveFrom())); ?>
                    <a class="tip activeFrom">
                        <span class="details"><?php echo sprintf(__('The offer start date can not be later than %s', null, 'form'), date('d.m.Y', $product_end_date)); ?></span>
                    </a>
                <?php endif; ?>
               
            </div>
        <?php endif; ?>
        <?php if (isset($form['active_to'])): ?>
            <div class="form_box tip form_label_inline<?php echo $form['active_to']->hasError() ? 'error' : '' ?>">
                <?php echo $form['active_to']->renderLabel() ?>
                <span class="pink">&nbsp;*</span>
                <?php echo $form['active_to']->render(array('readonly' => "readonly")) ?>
                <?php echo $form['active_to']->renderError() ?>
                <?php $product_end_date = strtotime('+29 days', strtotime($formObject->getActiveFrom())); ?>
                <?php $dealActiveTo = strtotime('+1 days', strtotime($formObject->getActiveFrom())); ?>
                <?php $voucherMinDate = strtotime(($formObject->getActiveFrom())); ?>
                <?php if (!$formObject->isNew() && !$formObject->getIsDraft() && $formObject->getActiveFrom()): ?>
                    <a class="tip endDate">
                        <span class="details"><?php echo sprintf(__('The offer end date can not be later than %s', null, 'form'), date('d.m.Y', $product_end_date)); ?></span>
                    </a>
                    <?php $offerEndDate = strtotime('+29 days', strtotime($formObject->getActiveFrom())); ?>
                <?php elseif ($formObject->getAdServiceCompany()->getActiveFrom()): ?>
                    <?php $offer_max_end_date = strtotime('+30 days', $product_end_date); ?>
                    <a class="tip endDate" style="display: none;">
                        <?php /* <span class="details"><?php echo sprintf(__('The offer end date can not be later than %s', null, 'form'), date('d.m.Y', $offer_max_end_date)); ?></span> */ ?>
                    </a>

                  <?php elseif ((!$formObject->isNew() || $formObject->getIsDraft()) && $formObject->getAdServiceCompany()->getActiveFrom()): ?>
                    <?php $product_end_date = strtotime('+3 months', strtotime($formObject->getAdServiceCompany()->getActiveFrom())); ?>
                    <?php // $offerEndDate = strtotime($formObject->getAdServiceCompany()->getActiveTo()); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <?php if (isset($form['valid_from'])): ?>
        <?php $voucherMinDate = strtotime(($formObject->getActiveFrom())); ?>
        <div class="form_box form_label_inline<?php echo $form['valid_from']->hasError() ? 'error' : '' ?>">
            <?php echo $form['valid_from']->renderLabel() ?>
            <span class="pink">&nbsp;*</span>
            <?php echo $form['valid_from']->render(array('readonly' => "readonly")) ?>

            <?php echo $form['valid_from']->renderError() ?>
        </div>
    <?php endif; ?>
    <?php if (isset($form['valid_to'])): ?>
        <div class="form_box form_label_inline<?php echo $form['valid_to']->hasError() ? 'error' : '' ?>">
            <?php echo $form['valid_to']->renderLabel() ?>
            <span class="pink">&nbsp;*</span>
            <?php echo $form['valid_to']->render(array('readonly' => "readonly")) ?>
            <?php echo $form['valid_to']->renderError() ?>
        </div>
    <?php endif; ?>
    <div class="additional_info_gray_bg">
        <div class="form_box <?php echo $form['max_vouchers']->hasError() ? 'error' : '' ?>">
            <?php echo $form['max_vouchers']->renderLabel() ?>
            <?php echo $form['max_vouchers']->render() ?>
            <?php echo $form['max_vouchers']->renderError() ?>
        </div>
        <div class="form_box form_label_inline<?php echo $form['max_per_user']->hasError() ? 'error' : '' ?>" style="width:420px">
            <?php echo $form['max_per_user']->renderLabel() ?>
            <span class="pink">&nbsp;*</span>
            <?php echo $form['max_per_user']->render() ?>
            <?php echo $form['max_per_user']->renderError() ?>
        </div>
    </div>
    <div class="form_box<?php if ($formObject->isNew()): ?> form_label_inline<?php endif;?><?php echo $form['file']->hasError() ? 'error' : '' ?>"style="width:450px;display: inline-block;">
        <?php echo $form['file']->renderLabel(); ?>
        <?php if ($formObject->isNew()): ?>
            <span class="pink image_required">&nbsp;*</span>
        <?php endif;?>
        <?php echo $form['file']->render(array('accept'=>"image/*")); ?>
        <a id="clearImage" class="button_pink" style="display:none;"><?php echo __('Clear image', null, 'form')?></a>
        <?php echo $form['file']->renderError(); ?>
       <ul class="error_list image-invalid" style="display:none;max-width:272px;"><li><?php echo __('The file you submitted is not in a valid format. Please upload a JPG, GIF or PNG image file.', null, 'form')?></li></ul>
       <ul class="error_list no-image" style="display:none; max-width:272px;"><li><?php echo __('The field is mandatory', null, 'form'); ?></li></ul>
    </div>
    <div class="image_crop_wrapper" style="display:none">
        <ul class="error_list image_no_selection" style="display:none;"><li>Please make a selection</li></ul>
        <div class="crop_tool_labels">
           <label id="crop"><?php echo __('Select the area from the image that you want to appear in your Offer', null, 'form')?></label>
           <label id="image_preview"><?php echo __('Image Preview', null, 'form')?></label>
        </div>
        <div id="preview-pane" >
          <div class="preview-container" >
            <img id ="smallPreview" class="jcrop-preview"/>
          </div>
      </div>
      <div id="imgDiv">
          <img  id="bigPreview"/>
      </div>
    </div>
      <?php if (!$formObject->isNew()  && $formObject->getImageId()): ?>
        <?php // echo image_tag($formObject->getImage()->getThumb(2),array('class'=>'offer_image_preview')) ?>
        <div class="current_offer_image">
            <label class="current_img_label"><?php echo __('Offer image', null, 'form')?></label>
            <?php echo image_tag($formObject->getImage()->getFile(), array('class'=>'current_image')); ?>
        </div>
    <?php endif; ?>
<br/>
 
<div id="message"></div>

<!-- BENEFITS -->
<div class="additional_info_gray_bg">
    <div class="offer_benefits_wrap"> 
        <div class="benefit_choice"<?php echo $form['benefit_choice']->hasError() ? ' error' : '' ?>>
            <?php echo $form['benefit_choice']->renderLabel() ?>
            <?php echo $form['benefit_choice']->render() ?>
            <?php echo $form['benefit_choice']->renderError() ?>
        </div>
        <div class="option_fields_wrap">
            <div class="option_1">
                <div class="form_box <?php echo $form['new_price']->hasError() ? ' error' : '' ?>">
                    <?php echo $form['new_price']->renderLabel() ?>
                    <span class="pink">&nbsp;*</span>
                    <?php echo $form['new_price']->render() ?>
                    <?php echo $form['new_price']->renderError() ?>
                </div>

                <?php if($sf_user->getCulture() == 'sr'): ?>
                    <p>RSD</p>
                <?php endif; ?> 

                <div class="clear"></div>
                <div class="form_box<?php echo $form['old_price']->hasError() ? ' error' : '' ?>">
                    <?php echo $form['old_price']->renderLabel() ?>
                    <span class="pink">&nbsp;*</span>
                    <?php echo $form['old_price']->render() ?>
                    <?php echo $form['old_price']->renderError() ?>
                </div>

                <?php if($sf_user->getCulture() == 'sr'): ?>
                    <p>RSD</p>
                <?php endif; ?>
                
                <div class="clear"></div>
            </div>  
            <div class="option_2">
                <div class="form_box<?php echo $form['discount_pct']->hasError() ? ' error' : '' ?>">
                    <?php echo $form['discount_pct']->renderLabel() ?>
                    <span class="pink">&nbsp;*</span>
                    <?php echo $form['discount_pct']->render() ?>
                    <?php echo $form['discount_pct']->renderError() ?>
                    <span class="percent_sign"><?php echo ('% ');?></span>
                    <span><?php echo __('discount', null, 'form');?></span>
                </div>
                <div class="clear"></div>
            </div>
            <div class="option_3">
                <div class="form_box<?php echo $form['benefit_text']->hasError() ? ' error' : '' ?>">
                    <?php echo $form['benefit_text']->renderLabel() ?>
                    <span class="pink">&nbsp;*</span>
                    <?php echo $form['benefit_text']->render() ?>
                    <?php echo $form['benefit_text']->renderError() ?>
                </div>
               
                <dt id='stat'><label><span>33</span><?php echo __(' characters left', null, 'form');?></label></dt>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
     </div>
    </div>
<div class="clear"></div>
<!-- END BENEFITS -->  
    <?php if ($formObject->isNew() or $formObject->canEdit() or $sf_user->isGetlokalAdmin()): ?>
         <?php $number_of_languages = count(getlokalPartner::getEmbeddedLanguages())?>
        <?php foreach (getlokalPartner::getEmbeddedLanguages() as $lang): ?>
            <?php
            if (!isset($form[$lang])) {
                continue;
            }
            ?>
            <div class="additional_info_gray_bg<?php echo ($lang == 'en') ? ' offer_in_english' : ''; ?>">
                <div class="form_box form_label_inline<?php echo $form[$lang]['title']->hasError() ? 'error' : '' ?>">
                    <?php echo $form[$lang]['title']->renderLabel() ?>
                    <label>&nbsp;<?php echo ($lang != 'en' && $number_of_languages >2) ? ' (' . __(sfConfig::get('app_culture_native_'.$lang)) . ')' : ''; ?></label>
                    <label>&nbsp;<?php echo ($lang == 'en') ? ' (' . __('English') . ')' : ''; ?></label>
                    <span class="pink">&nbsp;*</span>         
                     <?php echo $form[$lang]['title']->render(); ?>
                    <?php echo $form[$lang]['title']->renderError() ?>
                </div>
            </div>
            <div class="form_box form_label_inline <?php echo ($lang == 'en') ? ' offer_in_english' : ''; ?><?php echo $form[$lang]['content']->hasError() ? 'error' : '' ?>">
                <?php echo $form[$lang]['content']->renderLabel(); ?>
                <label>&nbsp;<?php echo ($lang != 'en' && $number_of_languages > 2) ? ' (' . __(sfConfig::get('app_culture_native_'.$lang)) . ')' : ''; ?></label>
                <label>&nbsp;<?php echo ($lang == 'en') ? ' (' . __('English') . ')' : ''; ?></label>
                <span class="pink">&nbsp;*</span>
                <a class="tip">
                    <span class="details"><?php echo(__('When you publish an Offer please give details of its terms, timing and content e.g. "Get 20% off a weekend for two in hotel X. The offer is valid only for the period between 20.08 and 27.08. The discount applies to advanced bookings only.', null, 'form')); ?></span>
                </a>
                <?php echo $form[$lang]['content']->render() ?>
                <?php echo $form[$lang]['content']->renderError() ?>
            </div>
            <?php if ($lang != 'en' && $lang == getlokalPartner::getDefaultCulture()): ?>
            <div class="dotted">
                <h2 class="en_offer_desc"><?php echo __('Post offer in English', null, 'form'); ?></h2>
                <div class="arrow_up_down down"></div>
            </div>
         <?php endif; ?> 
    <?php endforeach; ?>
        
    <?php endif; ?>
        <div class="clear"></div>
    <input type="submit" name="save" value="<?php echo __('Publish', null, 'form'); ?>" class="input_submit save_offer" />
    <?php if ($formObject->isNew() || $formObject->getIsDraft()): ?>
        <input type="submit" name="draft" value="<?php echo __('Save Draft', null, 'form'); ?>" class="input_submit" />
    <?php endif; ?>
        <div class="clear"></div>
    <div class="mandatory_notice">
       <p><?php echo __('All fields marked with <span>*</span> are mandatory', null, 'company') ?></p>
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
     flashErrorMessage();
         <?php if ($sf_user->getCulture() == 'en'): ?>     
            <?php elseif ($sf_user->getCulture() == 'bg'): ?>
              offerBenefitChoiseBG();
            <?php elseif ($sf_user->getCulture() == 'mk'): ?>
               offerBenefitChoiseMK(); 
            <?php elseif ($sf_user->getCulture() == 'sr'): ?>
              offerBenefitChoiseSR();
            <?php elseif ($sf_user->getCulture() == 'ro'): ?>
               offerBenefitChoiseRO();
            <?php endif; ?> 
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

