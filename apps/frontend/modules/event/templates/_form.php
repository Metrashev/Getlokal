<div class="row">
    <div class="default-container default-form-wrapper col-sm-12 overflow-visible">

        <?php if ($sf_user->getFlash('newerror')) { ?>
            <div class="form-message error">
                <p><?php echo __($sf_user->getFlash('newerror'), null, 'events'); ?></p>
            </div>
        <?php } ?>
        <?php if ($sf_user->getFlash('newsuccess')): ?> 
            <div class="form-message success">
                <p><?php echo __($sf_user->getFlash('newsuccess'), null, 'events') ?></p>
            </div> 
        <?php endif; ?>

        <form id="eventForm" action="<?php echo url_for('event/' . ($form->getObject()->isNew() ? 'create' : 'edit') . (!$form->getObject()->isNew() ? '?id=' . $form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
            <?php
            $lng = mb_convert_case(getlokalPartner::getLanguageClass(getlokalPartner::getInstanceDomain()), MB_CASE_LOWER, 'UTF-8');
            $tab_lng = sfConfig::get('app_cultures_en_' . $lng);
            ?>

            <h2 class="form-title"><?php echo __('Event Name', null, 'form'); ?></h2>
            <div class="row">
                <div class="col-sm-6">
                    <div class="default-input-wrapper required <?php echo $form[$lng]['title']->hasError() ? 'incorrect' : '' ?>">
                        <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                        <label fpr="name" class="default-label"><?php echo __($tab_lng, null, 'company') ?></label>
                        <?php echo $form[$lng]['title']->render(array('placeholder' => $form[$lng]['title']->renderPlaceholder(), 'id' => 'name', 'class' => 'default-input')); ?>
                        <div class="error-txt"><?php echo $form[$lng]['title']->renderError() ?></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="default-input-wrapper <?php echo $form['en']['title']->hasError() ? 'incorrect' : '' ?>">
                        <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                        <label fpr="name-EN" class="default-label"><?php echo __('English') ?></label>
                        <?php echo $form['en']['title']->render(array('placeholder' => __('Name in English', null, 'list'), 'id' => 'name-EN', 'class' => 'default-input')); ?>
                        <div class="error-txt"><?php echo $form['en']['title']->renderError() ?></div>
                    </div>
                </div>
            </div>

            <h2 class="form-title"><?php echo $form[$lng]['description']->renderPlaceholder() . ' (' . __($tab_lng, null, 'company') . ')' ?></h2>
            <div class="row">
                <div class="col-sm-12">
                    <div class="default-input-wrapper <?php echo $form[$lng]['description']->hasError() ? 'incorrect' : '' ?>">
                        <?php echo $form[$lng]['description']->render(array('placeholder' => __('Name this list...', null, 'list'))); ?>
                        <div class="error-txt"><?php echo $form[$lng]['description']->renderError() ?></div>
                    </div>
                </div>
            </div>
            </br>

            <h2 class="form-title"><?php echo $form['en']['description']->renderPlaceholder() . ' (' . __('English') . ')' ?></h2>
            <div class="row">
                <div class="col-sm-12">
                    <div class="default-input-wrapper <?php echo $form['en']['description']->hasError() ? 'incorrect' : '' ?>">
                        <?php echo $form['en']['description']->render(array('placeholder' => __('Description in English', null, 'list'))); ?>
                        <div class="error-txt"><?php echo $form['en']['description']->renderError() ?></div>
                    </div>
                </div>
            </div>
            </br>

            <div class="row">
                <div class="col-sm-2">
                    <div class="default-input-wrapper <?php echo $form['start_at']->hasError() ? 'incorrect' : '' ?>">
                        <?php echo $form['start_at']->renderLabel(null, array('class' => 'default-label')) ?>
                        <?php echo $form['start_at']->render(array('placeholder' => $form['start_at']->renderPlaceholder(), 'class' => 'default-input', 'id' => 'date_filter_start')) ?>
                        <div class="error-txt"><?php echo $form['start_at']->renderError() ?></div>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="default-input-wrapper select-wrapper active <?php echo $form['start_h']->hasError() ? 'incorrect' : '' ?>">
                        <?php echo $form['start_h']->renderLabel(null, array('class' => 'default-label')) ?>
                        <?php echo $form['start_h']->render(array('placeholder' => $form['start_h']->renderPlaceholder(), 'class' => 'default-input')) ?>
                        <div class="error-txt"><?php echo $form['start_h']->renderError() ?></div>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="default-input-wrapper <?php echo $form['end_at']->hasError() ? 'incorrect' : '' ?>">
                        <?php echo $form['end_at']->renderLabel(null, array('class' => 'default-label')) ?>
                        <?php echo $form['end_at']->render(array('placeholder' => $form['end_at']->renderPlaceholder(), 'class' => 'default-input', 'id' => 'date_filter_end')) ?>
                        <a id="event_calendar_end"></a>
                        <div class="error-txt"><?php echo $form['end_at']->renderError() ?></div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="default-input-wrapper select-wrapper active <?php echo $form['category_id']->hasError() ? 'incorrect' : '' ?>">
                        <?php echo $form['category_id']->renderLabel(null, array('class' => 'default-label')) ?>
                        <?php echo $form['category_id']->render(array('class' => 'default-input')) ?>
                        <div class="error-txt"><?php echo $form['category_id']->renderError() ?></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="default-input-wrapper select-wrapper active <?php echo $form['price']->hasError() ? 'incorrect' : '' ?>">
                        <?php echo $form['price']->renderLabel(null, array('class' => 'default-label')) ?>
                        <?php echo $form['price']->render(array('placeholder' => $form['price']->renderPlaceholder(), 'class' => 'default-input')) ?>
                        <div class="error-txt"><?php echo $form['price']->renderError() ?></div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="default-input-wrapper <?php echo $form['buy_url']->hasError() ? 'incorrect' : '' ?>">
                        <?php echo $form['buy_url']->renderLabel(null, array('class' => 'default-label')) ?>
                        <?php echo $form['buy_url']->render(array('placeholder' => $form['buy_url']->renderPlaceholder(), 'class' => 'default-input')) ?>
                        <div class="error-txt"><?php echo $form['buy_url']->renderError() ?></div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="default-input-wrapper <?php echo $form['info_url']->hasError() ? 'incorrect' : '' ?>">
                        <?php echo $form['info_url']->renderLabel(null, array('class' => 'default-label')) ?>
                        <?php echo $form['info_url']->render(array('placeholder' => $form['info_url']->renderPlaceholder(), 'class' => 'default-input')) ?>
                        <div class="error-txt"><?php echo $form['info_url']->renderError() ?></div>
                    </div>
                </div>
            </div>

            <div class="<?php echo $form['poster']->hasError() ? 'incorrect' : '' ?>">
                <div class="row">
                <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <div class="default-checkbox">
                            <?php echo $form['poster'] ?>
                            <div class="fake-box"></div>
                        </div>
                        <?php echo $form['poster']->renderLabel(null, array('class' => 'default-checkbox-label')) ?>
                    </div>
                </div><!-- Form Checkbox -->    
            </div>

            <div class="row">
                <div class="col-sm-3">
                    <div class="default-input-wrapper <?php echo $form['location_id']->hasError() ? 'incorrect' : '' ?>">
                        <?php echo $form['location_id']->renderLabel(null, array('class' => 'default-label')) ?>
                        <?php echo $form['location_id']->render(array('placeholder' => $form['location_id']->renderPlaceholder(), 'class' => 'default-input')) ?>
                        <div class="error-txt"><?php echo $form['location_id']->renderError() ?></div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="default-input-wrapper <?php echo $form['caption']->hasError() ? 'incorrect' : '' ?>">
                        <?php echo $form['caption']->renderLabel(null, array('class' => 'default-label')) ?>
                        <?php echo $form['caption']->render(array('placeholder' => $form['caption']->renderPlaceholder(), 'class' => 'default-input')) ?>
                        <div class="error-txt"><?php echo $form['caption']->renderError() ?></div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="file-input-wrapper">
                        <label for="fileUpload" class="file-label">
                            <?php echo __('No File chosen', null, 'form'); ?>
                            <?php echo $form['file']->render(array('placeholder' => __('Caption', null, 'form'), 'id' => 'fileUpload', 'class' => 'file-input')) ?>
                        </label>
                        <div class="error-txt"><?php echo $form['file']->renderError() ?></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 z-index-fix">
                    <div class="default-input-wrapper <?php echo $form['caption']->hasError() ? 'incorrect' : '' ?>">
                        <?php echo $form['place_id']->renderLabel(null, array('class' => 'default-label')) ?> 
                        <input id="place" class="default-input" type="text" autocomplete="off" placeholder="<?php echo $form['place_id']->renderPlaceholder(); ?>"/>
                        <div class="list_of_places event_list_of_places">
                            <ul class="tag-wrapper">
                                <?php include_component('event', 'places', array('event' => $form->getObject(), 'form' => $form)); ?>
                            </ul>
                        </div>
                        <div class="error-txt"><?php echo $form['place_id']->renderError() ?></div>
                        <div id='PlacesList' class="eventAdd"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 form-btn-row">
                    <input type="submit" value="<?php echo __('Publish', null, 'messages'); ?>" class="default-btn success pull-right " />
                    <?php if ($sf_user->hasAttribute('profile.edit.event')): ?>
                        <a href="<?php echo url_for('profile/events?username=' . $sf_user->getGuardUser()->getUsername()) ?>" class="default-btn pull-right"><?php echo __('Back to list') ?></a>
                        <?php $sf_user->getAttributeHolder()->remove('profile.edit.event'); ?>
                    <?php else: ?>
                        <a href="<?php echo url_for('event/recommended') ?>" class="default-btn pull-right"><?php echo __('Back to list') ?></a>
                    <?php endif; ?>

                    <?php if (!$form->getObject()->isNew()): ?>
                        <?php echo link_to(__('Delete'), 'event/delete?id=' . $form->getObject()->getId(), array('class' => 'default-btn pull-right', 'id' => 'delete_event')) ?>
                    <?php endif; ?>
                </div>
            </div>

            <?php echo $form->renderHiddenFields(); ?>
        </form>
    </div>

</div><!-- END default-form-wrapper -->

<?php if (!$form->getObject()->isNew()): ?>
    <div class="event_settings_content"></div>
    
    <div id="dialog-confirm" title="<?php echo __('Deleting Event', null, 'messages') ?>" style="display:none;">
            <p><?php echo __('Are you sure you want to delete your event?', null, 'messages') ?></p>
    </div>
    <script type="text/javascript">
        // $(document).ready(function() {
            $.ajax({
            url: '<?php echo url_for('event/images?event=' . $form->getObject()->getId()); ?>',
                    beforeSend: function() {
                    $('.event_settings_content').html('<div class="review_list_wrap">loading...</div>');
                    },
                    success: function(data) {
                    $('.event_settings_content').html(data);
                    }
            });
        // })
    </script>
<?php endif; ?>


<script type="text/javascript">

    $('a#delete_event').click(function(event) {
        var deleleEventLink = $(this).attr('href');

    $("#dialog-confirm").data('id', deleleEventLink).dialog('open');
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

    $("#date_filter_start").datepicker({
        dateFormat: 'dd/mm/yy',
        onSelect: function(dateText, inst) {
            $("#date_filter").val(dateText);
        }
    });

    $("#date_filter_end").datepicker({
        dateFormat: 'dd/mm/yy',
        onSelect: function(dateText, inst) {
            $("#date_filter_end").val(dateText);
        }
    });
    
    $("html").click( function() {
        $("#PlacesList").hide();
    });

    $('#place').keyup (function(){
        //console.log($('#event_location_id').val());
        var values = $(this).val();
        var cityId = $('#event_location_id').val();
        <?php if (!$form->getObject()->isNew()): ?>
            var iventId = <?php echo $form->getObject()->getId() ?>;
        <?php endif; ?>
        if (values.length > 2){
            $.ajax({
                url: '<?php echo url_for("event/addPage") ?>',
                <?php if (!$form->getObject()->isNew()): ?>
                        data: {'place': values, 'eventId': iventId, 'cityId': cityId},
                <?php else: ?>
                        data: {'place': values, 'cityId': cityId},
                <?php endif; ?>
                beforeSend: function() {
                $("#PlacesList").show();
                $("#PlacesList").html(LoaderHTML);
                        //$("#PlacesList").toggle();
                        //console.log(values + 'Send');
                },
                success: function(data, url) {
                $("#PlacesList").html(data);
                        //console.log('success');
                },
                error: function(e, xhr)
                {
                console.log(e);
                }
            });
        }
    });

</script>