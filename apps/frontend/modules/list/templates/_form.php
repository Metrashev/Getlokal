<div class="row">
    <div class="default-container default-form-wrapper col-sm-12">

        <?php if ($sf_user->getFlash('newerror')) { ?>
            <div class="form-message error">
                <?php echo __($sf_user->getFlash('newerror'), null, 'list'); ?>
            </div>
        <?php } ?>
        <?php if ($sf_user->getFlash('newsuccess')): ?> 
            <div class="form-message success">
                <?php echo __($sf_user->getFlash('newsuccess'), null, 'list') ?>
            </div> 
        <?php endif; ?>
        <form id ="listForm" action="<?php echo url_for('list/' . ($form->getObject()->isNew() ? 'create' : 'edit') . (!$form->getObject()->isNew() ? '?id=' . $form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
            <?php $lng = mb_convert_case(getlokalPartner::getLanguageClass(getlokalPartner::getInstanceDomain()), MB_CASE_LOWER, 'UTF-8');
                  $tab_lng = sfConfig::get('app_cultures_en_' . $lng); ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="default-input-wrapper required <?php echo $form[$lng]['title']->hasError() ? 'incorrect' : '' ?>">
                        <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                        <label class="default-label"><?php echo $form[$lng]['title']->renderPlaceholder() . ' (' . __($tab_lng, null, 'company') . ')' ?></label>
                        <?php echo $form[$lng]['title']->render(array('placeholder' => __('Name this list...', null, 'list'), 'id' => 'name', 'class' => 'default-input')); ?>
                        <div class="error-txt"><?php echo $form[$lng]['title']->renderError() ?></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="default-input-wrapper <?php echo $form['en']['title']->hasError() ? 'incorrect' : '' ?>">
                        <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                        <label class="default-label"><?php echo $form['en']['title']->renderPlaceholder() . ' (' . __('English') . ')' ?></label>
                        <?php echo $form['en']['title']->render(array('placeholder' => __('Name in English', null, 'list'), 'id' => 'name-EN', 'class' => 'default-input')); ?>
                        <div class="error-txt"><?php echo $form['en']['title']->renderError() ?></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="default-input-wrapper <?php echo $form[$lng]['description']->hasError() ? 'incorrect' : '' ?>">
                        <label class="default-label"><?php echo $form[$lng]['description']->renderPlaceholder() . ' (' . __($tab_lng, null, 'company') . ')' ?></label>
                        <?php echo $form[$lng]['description']->render(array('placeholder' => __('What is this list about...', null, 'list'), 'id' => 'desc', 'class' => 'default-input')); ?>
                        <div class="error-txt"><?php echo $form[$lng]['description']->renderError() ?></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="default-input-wrapper required <?php echo $form['en']['description']->hasError() ? 'incorrect' : '' ?>">
                        <label class="default-label"><?php echo $form['en']['description']->renderPlaceholder() . ' (' . __('English') . ')' ?></label>
                        <?php echo $form['en']['description']->render(array('placeholder' => __('Description in English', null, 'list'), 'id' => 'desc-EN', 'class' => 'default-input')); ?>
                        <div class="error-txt"><?php echo $form['en']['description']->renderError() ?></div>
                    </div>
                </div>
            </div>

            <div class="form_box form_label_inline <?php echo $form['is_open']->hasError() ? 'incorrect' : '' ?>">
                <div class="custom-row">
                    <div class="default-checkbox">
                        <?php echo $form['is_open'] ?>
                        <div class="fake-box"></div>
                    </div>
                    <?php echo $form['is_open']->renderLabel(null, array('class' => 'default-checkbox-label')) ?>
                </div><!-- Form Checkbox -->
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="default-input-wrapper <?php echo $form['caption']->hasError() ? 'incorrect' : '' ?>">
                        <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                        <?php echo $form['caption']->renderLabel(null, array('for' => 'caption', 'class' => 'default-label')) ?>
                        <?php echo $form['caption']->render(array('placeholder' => $form['caption']->renderPlaceholder(), 'id' => 'caption', 'class' => 'default-input')) ?>
                        <div class="error-txt"><?php echo $form['caption']->renderError() ?></div>
                    </div>

                    <div class="file-input-wrapper <?php echo $form['file']->hasError() ? 'incorrect' : '' ?>">
                        <label for="fileUpload" class="file-label">
                            <?php echo __('No File chosen', null, 'form'); ?>
                            <?php echo $form['file']->render(array('placeholder' => __('Caption', null, 'form'), 'id' => 'fileUpload', 'class' => 'file-input')) ?>
                        </label>
                        <div class="error-txt"><?php echo $form['file']->renderError() ?></div>
                    </div>

                </div>

                <div class="upload-wrapper col-sm-6">
                    <?php
                    if ($form->getObject()->getImageId()) {
                        echo image_tag($form->getObject()->getThumb(0), array('size' => '170x130', 'alt' => $form->getObject()->getImage()->getCaption()));
                    }
                    ?>
                </div>
            </div>


            <?php if (!$form->getObject()->isNew()) : ?>
                <h2 class="form-title"><?php echo __('Click to add places to your list!', null, 'list'); ?></h2>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="default-input-wrapper <?php echo $form['location_id']->hasError() ? 'incorrect' : '' ?>">
                            <label for="place" class="default-label"><?php echo __('Company', null, 'company') ?></label>
                            <input type="text" placeholder="<?php echo __('Company', null, 'company') ?>" id="place" class="default-input">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="default-input-wrapper <?php echo $form['location_id']->hasError() ? 'incorrect' : '' ?>">
                            <?php echo $form['location_id']->renderLabel(null, array('for' => 'town', 'class' => 'default-label')) ?>
                            <?php echo $form['location_id']->render(array('placeholder' => __('City', null, 'company'), 'class' => 'default-input')) ?>
                            <?php echo $form['location_id']->renderError() ?>
                            <a href="javascript:void(0);" id="search_city_name"></a>
                        </div>

                    </div>
                </div>

                <div class="form_box show-list">
                    <div id="PlacesList" class="list_of_places places_dropdown">
                    <ul class="list-details-company">
                        <a href="javascript:void(0)" id="form_close"></a>
                        <div>
                            <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                            <div class="viewport">
                                <div class="overview">
                                <ul class="list-details-company"></ul>
                                </div>
                            </div>
                        </div>
                    </ul>
                    </div>
                </div>

                <div class="list_of_places" id="list_of_places">
                <ul class="list-details-company">
                    <?php
                    $options = array('places' => $form->getObject()->getListPage(),
                        'culture' => $sf_user->getCulture(),
                        'user' => $user,
                        'listUserId' => $form->getObject()->getUserId(),
                        'listId' => $form->getObject()->getId(),
                        'is_place_admin_logged' => $is_place_admin_logged);

                    include_partial('places', $options);
                    ?>

                    <?php //include_partial('list/places', $options); ?>
                </ul>
                </div>

            <?php endif; ?>

            <div class="row">
                <div class="col-sm-12 form-btn-row">
                    <input type="submit" value="<?php echo __('Publish', null, 'messages'); ?>" class="default-btn success pull-right " />
                    <?php if (!$form->getObject()->isNew()): ?>
                        <a class="default-btn delete pull-right" id="delete_list" method="delete" href="<?php echo url_for("list/delete?id=" . $form->getObject()->getId()); ?>"><?php echo __("Delete") ?></a>
                    

                <?php endif; ?>
                    <a href="<?php echo url_for('list/index') ?>" class="default-btn pull-right"><?php echo __("Back to 'Lists'", null, 'list') ?></a>
                </div>
            </div>

            <?php echo $form->renderHiddenFields(); ?>

        </form>
    </div>

</div><!-- END default-form-wrapper -->

<div id="dialog-confirm" title="<?php echo __('Deleting List', null, 'messages') ?>" style="display:none;" >
        <p><?php echo __('Are you sure you want to delete your list?', null, 'messages') ?></p>
</div>       

<script type="text/javascript">

    $('a#delete_list').click(function(event) {
        var deleleReviewLink = $(this).attr('href');

    $("#dialog-confirm").data('id', deleleReviewLink).dialog('open');
        $(".ui-dialog").css("z-index", "1000");
        return false; 

    });
        
    $("#dialog-confirm").dialog({
        draggable:false,
        resizable: false,
        autoOpen: false,
        height: 250,
        width:340,
        buttons: {
            "<?php echo __('delete', null) ?>": function() {
                window.location.href =  $("#dialog-confirm").data('id');
            },
            <?php echo __('cancel', null, 'company') ?>: function() {
                               $(this).dialog("close");
            }
        }
    });

    $('#place').keyup(function() {

        var values = $(this).val();
        var cityId = $('#list_location_id').val();
        var listId = <?php echo $form->getObject()->getId() ?>;
        // $('.viewport').css({height: '138px'});
        if (values.length > 2) {
            $("#PlacesList").css("display", "block");
            $.ajax({
                url: '<?php echo url_for("list/getPage") ?>',
                data: {'place': values, 'listId': listId, 'cityId': cityId},
                beforeSend: function() {
    	          $('#PlacesList .overview').html(LoaderHTML);
    	        },
                success: function(data, url) {
                    $("#PlacesList .overview").html(data);
                    $("#PlacesList .overview div div a").each(function() {
                        $(this).html($(this).html().replace(values, '<span>' + values + "</span>"));
                    });

                    $("#PlacesList > div").tinyscrollbar_update();
                    if ($('#PlacesList .overview').outerHeight() < $('#PlacesList .viewport').outerHeight()) {
                        $('#PlacesList .viewport').css('height', $('#PlacesList .overview').outerHeight());
                        $('#PlacesList').css('height', 'auto');
                    }                  
                },
                error: function(e, xhr)
                {
                    console.log(xhr);
                }
            });
        }
        else {
            $("#PlacesList").css("display", "none");
        }
    });

</script>