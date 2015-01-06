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
    <div class="col-sm-3">
        <div class="section-categories">
            <!-- div class="categories-title">
                </div><!-- categories-title -->
            <?php include_partial('rightMenu', $params); ?>	            
        </div>
    </div>
    <div class="col-sm-9">
        <div class="content-default">	            
            <div class="row">
                <div class="default-container default-form-wrapper col-sm-12 p-15">
                    <!--  -->
                    <div class="col-sm-12">
                        <?php include_partial('tabsMenu', $params); ?>	   
                    </div>
                    <h2 class="form-title"><?php echo __('Classifications', null, 'company') ?></h2>
                    <!-- Form Start -->

                    <?php if ($sf_user->getFlash('newerror')) { ?>
                        <div class="form-message error">
                            <p><?php echo __($sf_user->getFlash('newerror')); ?></p>
                        </div>
                    <?php } ?>
                    <?php if ($sf_user->getFlash('newsuccess')): ?> 
                        <div class="form-message success">
                            <p><?php echo __($sf_user->getFlash('newsuccess')) ?></p>
                        </div> 
                    <?php endif; ?>

                    <form class="classForm" id="cs-form" action="<?php echo url_for('companySettings/classification?slug=' . $company->getSlug()); ?>" method="post">
                        <?php $i = 0; ?>
                        <?php foreach ($form['orderclass'] as $addclassification): ?>
                            <?php $i++; ?>

                            <div id="company_classification<?php echo $i ?>">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="default-input-wrapper select-wrapper active <?php echo $addclassification['sector_id']->hasError() ? 'incorrect' : '' ?>">
                                            <?php echo $addclassification['sector_id']->renderLabel(null, array('class' => 'default-label')) ?>
                                            <?php
                                            echo $addclassification['sector_id']->render(array(
                                                'onchange' => jq_remote_function(array(
                                                    'update' => 'classification_id' . $i, //dom id
                                                    'url' => 'companySettings/changeClassification?slug=' . $company->getSlug(), //the action to be called
                                                    'method' => 'get',
                                                    'with' => "'sector_id=' + this.options[this.selectedIndex].value+'&embedded_index='+" . $i,
                                                    'complete' => "$('#classification_id" . $i . "').show();"
                                                )),
                                                'class' => 'default-input'
                                            ))
                                            ?>
                                            <div class="error-txt"><?php echo $addclassification['sector_id']->renderError() ?></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div id ="classification_id<?php echo $i ?>" class="default-input-wrapper select-wrapper active <?php echo $addclassification['classification_id']->hasError() ? 'incorrect' : '' ?>">
                                            <?php if ($i != 1 && $addclassification['classification_id']->getValue()): ?>
                                                <?php
                                                echo jq_link_to_remote('<span class="category"> ' . __('delete', null, 'company') . '</span>', array(
                                                    'update' => 'company_classification' . $i,
                                                    'url' => 'companySettings/removeClassification?classification_id=' . $addclassification['classification_id']->getValue() . '&slug=' . $company->getSlug(),
                                                    'onclick' => 'return true',
                                                    'class' => 'default-link'
                                                ));
                                                ?>
                                            <?php endif; ?>
                                            <?php echo $addclassification['classification_id']->renderLabel(null, array('class' => 'default-label')) ?>
                                            <?php echo $addclassification['classification_id']->render(array('class' => 'default-input')) ?>
                                            <div class="error-txt"><?php echo $addclassification['classification_id']->renderError() ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <?php $classifications_count = count($company->getCompanyClassification()); ?>	
                        <?php $ads_count = $company->getActivePPPService(true); ?>

                        <?php if (($ads_count && ($classifications_count) < (($ads_count * AdServiceTable::CLASSIFICATIONS_COUNT) + CompanyTable::MAX_CLASSIFICATION_COUNT)) or ( !$ads_count && $i < CompanyTable::MAX_CLASSIFICATION_COUNT )):
                            ?>
                            <?php $next = $i + 1; ?>

                            <div class="add_classification_link">
                                <div class="default-input-wrapper active" id="classification_id_<?php echo $next; ?>">
                                    <?php
                                    echo jq_link_to_remote(__('Add new classification', null, 'company'), array(
                                        'class' => 'default-link',
                                        'update' => 'classification_id_' . $next,
                                        'url' => 'companySettings/addClassificationForm?num=' . $next . '&slug=' . $company->getSlug(),
                                        'with' => "'sector_id='+" . $company->getSectorId(),
                                        'onclick' => 'return true',
                                        'complete' => "addClassificationSuccess()"
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="loader"></div>
                            <script type="text/javascript">
                                function addClassificationSuccess() {
                                    $('.loader').hide();
                                    $('.add_classification_link').fadeIn();
                                }

                                $(function() {
                                    $('.loader').append(LoaderHTML).hide();
                                    $('.add_classification_link a').click( function() {
                                        $('.add_classification_link').hide();
                                        $('.loader').show();
                                    });
                                });
                            </script>

                        <?php endif; ?>			

                        <?php echo $form['_csrf_token']->render() ?>

                        <div class="row">
                            <div class="col-sm-12 form-btn-row">
                                <input type="hidden" style="display: none; visibility: none" name="hiddenLink" value="" />
                                <input type="submit" value="<?php echo __('Save'); ?>" class="default-btn success pull-right" />
                            </div>
                        </div>

                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('input[name="hiddenLink"]').val($('.add_classification_link > div > a').attr('onclick'));
        $('.add_classification_link > div > a').click(function() {
            $('.add_classification_link > div').css('paddingBottom', '55px');
        });

        $('span.category').click(function() {
            $(this).parent().parent().parent().parent().remove();
        });
    });
</script>