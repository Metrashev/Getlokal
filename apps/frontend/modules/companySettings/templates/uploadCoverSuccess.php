<?php
use_helper('Pagination');
include_partial('global/commonSlider');
$params = array('company' => $company, 'adminuser' => $adminuser, 'companies' => $companies, 'is_getlokal_admin' => $is_getlokal_admin);
$is_with_order = $company->getActivePPPService(true);
?>
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

            <form action="<?php echo url_for('companySettings/uploadCover?slug=' . $company->getSlug()) ?>" enctype="multipart/form-data" method="post">
                <?php echo $form['_csrf_token']->render() ?>

                <div class="row">
                    <div class="default-container default-form-wrapper col-sm-12">

                        <div class="col-sm-12">
                            <?php include_partial('tabsMenu', $params); ?>     
                        </div>

                        <h2 class="form-title"><?php echo __('Cover Photo', null, 'company') ?></h2>

                        <?php if ($sf_user->getFlash('error')): ?> 
                            <div class="form-message error">
                                <p><?php echo __($sf_user->getFlash('error'), null, 'form') ?></p>
                            </div> 
                        <?php endif; ?>
                        
                        <p>
                            <?php echo __('The cover photo template is <strong>975x300 px</strong>. For best results, we recommend that you upload pictures of that size.', null, 'company'); ?><br />
                            <strong><?php echo __('Upload your photo here, crop it if necessary and then save it.', null, 'company'); ?></strong>
                        </p>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="file-input-wrapper upload <?php echo $form['file']->hasError() ? 'incorrect' : '' ?>">
                                    <label for="fileUpload" class="file-label">
                                        <?php echo __('No File chosen', null, 'form'); ?>
                                        <?php echo $form['file']->render(array('id' => 'fileUpload', 'class' => 'file-input')) ?>
                                    </label>
                                    <div class="error-txt"><?php echo $form['file']->renderError(); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="default-input-wrapper required <?php echo $form['caption']->hasError() ? 'incorrect' : '' ?>">
                                    <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                                    <?php echo $form['caption']->renderLabel(null, array('for' => $form['caption']->getName(), 'class' => 'default-label')) ?>
                                    <?php echo $form['caption']->render(array('class' => 'default-input', 'placeholder' => $form['caption']->renderPlaceholder())); ?>             
                                    <div class="error-txt"><?php echo $form['caption']->renderError() ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 form-btn-row">
                                <input type="submit" value="<?php echo __('Save'); ?>" class="default-btn success pull-right input_submit" />
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    setTimeout(function() {
        $(".success").fadeOut().empty();
    }, 8000);

    $('.input_submit').click(function() {
        var that = this;
        $.fancybox(
                {
                    'autoDimensions': true,
                    'width': 350,
                    'height': 'auto',
                    'transitionIn': 'none',
                    'transitionOut': 'none',
                    'href': '\apps\frontend\modules\crop\templates\placePhotoSuccess.php'
                }
        );
    });
</script>