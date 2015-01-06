<?php slot('no_ads', true) ?>
<?php slot('no_map', true) ?>
<?php use_helper('jQuery') ?>
<div class="settings_content place_classification">
    <h2 class="dotted"><?php echo __('Classifications', null, 'company')?></h2>
        <?php
            foreach ($form->getErrorSchema() as $field => $error)
            {
                printf("%s: %s\n", $field, $error->getMessage());
            }
        ?> 

    <form class="classForm" id="cs-form" action="<?php echo url_for('companySettings/classification?slug='. $company->getSlug());?>" method="post">
        <?php $i=0;?>
        <?php foreach ($form['orderclass'] as $addclassification): ?>
            <?php $i++;?>
            <div <?php echo ($i > 1) ? 'class="additional_info_gray_bg"' : ''; ?>>
                <div class="form_wrap two_fields" id="company_classification<?php echo $i?>">
                    <div class="form_box <?php echo $addclassification['sector_id']->hasError()? 'error': ''?>">
                        <?php echo $addclassification['sector_id']->renderLabel() ?>
                        <?php // echo $addclassification['sector_id']->render()?>
                        <?php echo $addclassification['sector_id']->render(array(
                        'onchange'=>jq_remote_function(array(
                          'update'=>'classification_id'. $i , //dom id
                          'url'=>'companySettings/changeClassification?slug='. $company->getSlug(), //the action to be called
                          'method'=>'get',
                          'with'=>"'sector_id=' + this.options[this.selectedIndex].value+'&embedded_index='+".$i,
                          'complete'=>"$('#classification_id". $i ."').show();",
                        ))
                         )) ?>
                        <?php echo $addclassification['sector_id']->renderError() ?>
                    </div>

                    <div id ="classification_id<?php echo $i?>" class="form_box <?php echo $addclassification['classification_id']->hasError()? 'error': ''?>">
                        <?php if ($i != 1 && $addclassification['classification_id']->getValue()):?>
                        <?php echo jq_link_to_remote( '<span class="category"> '. __('delete',null,'company') .'</span>', array(
                        'update' => 'company_classification'.$i,					       
                        'url'    => 'companySettings/removeClassification?classification_id='.$addclassification['classification_id']->getValue().'&slug='.$company->getSlug(),
                        'onclick'=>'return true'
                        ));?>
                    <?php endif;?>
                      <?php echo $addclassification['classification_id']->renderLabel() ?>
                      <?php echo $addclassification['classification_id']->render(); ?>
                      <?php echo $addclassification['classification_id']->renderError() ?>
                    </div>    
                    <div class="clear"></div>

                </div>
            </div>
        <?php endforeach;?>
          <div class="clear"></div>

        <?php $classifications_count= count($company->getCompanyClassification());?>	
        <?php $ads_count= $company->getActivePPPService(true);?>

        <?php  if (($ads_count 
            && ($classifications_count) < (($ads_count * AdServiceTable::CLASSIFICATIONS_COUNT)+CompanyTable::MAX_CLASSIFICATION_COUNT)) or (!$ads_count && $i < CompanyTable::MAX_CLASSIFICATION_COUNT )):?>
           <!-- 6: 1 primary classification + 5 CompanyTable::MAX_CLASSIFICATION_COUNT -->
           <?php $next = $i+1;?>
           <div class="add_classification_link ">
             <div class="additional_info_gray_bg">
                <div class="form_wrap two_fields" id="classification_id_<?php echo $next;?>">

                <?php  echo  jq_link_to_remote(__('Add new classification', null, 'company'), array(
                    'update' => 'classification_id_'.$next,
                    'url'    => 'companySettings/addClassificationForm?num='.$next.'&slug='.$company->getSlug(),
                    'with'=>"'sector_id='+". $company->getSectorId(),
                    'onclick'=>'return true'

                ));?>

                </div>
                 <div class="clear"></div>
            </div>
            </div>

           <div class="clear"></div>
        <?php endif;?>			

        <?php echo $form['_csrf_token']->render()?>
         <div class="clear"></div>
        <div class="form_box">
            <input type="hidden" style="display: none; visibility: none" name="hiddenLink" value="" />
            <input type="submit" value="<?php echo __('Save');?>" class="button_green" />
        </div>

        <?php //echo $form->renderHiddenFields();?>
    </form>
</div>

<script type="text/javascript">
$(document).ready(function () { 
	$('.path_wrap').remove();

    $('input[name="hiddenLink"]').val($('.add_classification_link > div > div > a').attr('onclick'));
    $('.add_classification_link > div > div > a').click(function() {    
        $('.add_classification_link > div').css('paddingBottom', '55px');
    });
    
    
    $('.settings_content.place_classification span.category').click(function() {
        $(this).parent().parent().parent().parent().remove();
    
    });
            
});

    
            
</script>