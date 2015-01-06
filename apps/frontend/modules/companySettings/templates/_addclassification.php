<?php use_helper('jQuery'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="default-input-wrapper select-wrapper active">

            <?php echo $form['orderclass'][$num]['sector_id']->renderLabel(null, array('class' => 'default-label')) ?>
            <?php
            echo $form['orderclass'][$num]['sector_id']->render(array(
                'onchange' => jq_remote_function(array(
                    'update' => 'classification_id' . $num, //dom id
                    'url' => 'companySettings/changeClassification?slug=' . $company->getSlug(), //the action to be called
                    'method' => 'get',
                    'with' => "'sector_id=' + this.options[this.selectedIndex].value+'&embedded_index='+" . $num,
                    'complete' => "$('#classification_id" . $num . "').show();",
                )),
                'class' => 'default-input'
            ))
            ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div id="classification_id<?php echo $num; ?>" style="display:none" class="default-input-wrapper select-wrapper active">
            <?php echo $form['orderclass'][$num]['classification_id']->renderLabel(null, array('class' => 'default-label')) ?>     
            <?php echo $form['orderclass'][$num]['classification_id']->render(array('class' => 'default-input')) ?>
        </div>
    </div>
</div>

<?php
$next = $num + 1;
$classifications_count = count($company->getCompanyClassification());
$ads_count = $company->getActivePPPService(true);
?>

<?php
if (($ads_count && ($classifications_count) < (($ads_count * AdServiceTable::CLASSIFICATIONS_COUNT) + CompanyTable::MAX_CLASSIFICATION_COUNT) && ($next) <= (($ads_count * AdServiceTable::CLASSIFICATIONS_COUNT) + CompanyTable::MAX_CLASSIFICATION_COUNT)
        ) or ( !$ads_count && $next <= CompanyTable::MAX_CLASSIFICATION_COUNT )):
    ?>

    <div class="row">
        <div class="col-sm-12">
            <div id="classification_id_<?php echo $next; ?>" class="default-input-wrapper select-wrapper active">
                <?php
                echo jq_link_to_remote(__('Add', null, 'company'), array(
                    'update' => 'classification_id_' . $next,
                    'url' => 'companySettings/addClassificationForm?num=' . $next . '&slug=' . $company->getSlug(),
                    'onclick' => 'return true',
                    'class' => 'default-link'
                ));
                ?>
                <a class="delete_link default-link"><?php echo __('cancel', null, 'company') ?></a>
            </div>
        </div>
    </div>

<?php endif; ?>

<script type="text/javascript">
    $(function() {
        $('div.add_classification_link a span').ready(function() {
            $('.delete_link').css('right', $('div.add_classification_link a span').outerWidth() + 42);

        });

        $('.delete_link').click(function() {
            $('.add_classification_link .form_box').remove();
            $('.add_classification_link > div').css('paddingBottom', '20px')

            var href = "<a href=\"#\" class=\"default-link\" onclick=\"" + $('input[name="hiddenLink"]').val() + "\"><?php echo __('Add new classification', null, 'company') ?></a>";
            $('.add_classification_link .default-input-wrapper').html(href);
        });
    });
</script>