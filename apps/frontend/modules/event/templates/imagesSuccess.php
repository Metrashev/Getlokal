<?php use_helper('Pagination') ?>

<div class="wrapper-tabs-event-details">
    <a href="<?php echo url_for('event/images?event=' . $event->getId()); ?>" id="by_author"><?php echo __('By Author', null, 'events') ?></a> |
    <a href="<?php echo url_for('event/images?event=' . $event->getId() . '&contributors=1'); ?>" id="by_contributors"><?php echo __('By Attendees', null, 'events') ?></a>
    <h2><?php echo __('Event Photo Gallery'); ?></h2>

    <div class="tab-photo-event-details">
        <?php $picture_count = $pager->getNbResults(); ?>
        <p><?php echo format_number_choice('[0]No uploaded photos yet.|[1]1 uploaded photo|(1,+Inf]%count% uploaded photos', array('%count%' => $picture_count), $picture_count, 'messages'); ?></p>
        <ul class="user-profile-images-tab gallery clearfix">
            <?php if ($pager->getNbResults() > 0): ?>
                <?php foreach ($pager->getResults() as $image): ?>.
                    <li>
                        <a href="<?php echo $image->getThumb('preview') ?>" target="_blank" class="lightbox" rel="prettyPhoto[gallery2]" title="<?php echo $image->getCaption() ?>">
                            <?php echo image_tag($image->getThumb()) ?>
                        </a>

                        <div class="wrapper-upload-photo-event-details">
                            <?php if ($image->getId() != $event->getImageId()): ?>
                                <a href="<?php echo url_for('event/setEvent?id=' . $image->getId() . '&event_id=' . $event->getId()) ?>" class="default-btn small profile-picture-btn"><?php echo __('set as event photo') ?></a>
                            <?php endif ?>
                            <?php echo link_to(__('delete', null, 'company'), 'event/deleteImage?id=' . $image->getId(), 'class=default-btn small delete-picture-btn delete') ?>
                        </div>
                    </li>
                <?php endforeach ?>
            <?php endif ?>
        </ul>
    </div>
    <?php echo pager_navigation($pager, url_for('event/images?event=' . $event->getId())); ?>
</div>

<div id="dialog-confirm" title="<?php echo __('Delete this image?', null, 'company') ?>" style="display:none;">
    <p><?php echo __('Are you sure you want to delete this image?', null, 'company') ?></p>
</div>
<script type="text/javascript">
    $('a.delete-picture-btn').click(function() {
        var delelePhotoLink = $(this).attr('href');
        $("#dialog-confirm").dialog({
            resizable: false,
            height: 250,
            width: 340,
            buttons: {
                "<?php echo __('delete', null) ?>": function() {
                    window.location.href = delelePhotoLink;
                },
                <?php echo __('cancel', null, 'company') ?>: function() {
                    $(this).dialog("close");
                }
            }
        });
        return false;
    });
    $('#by_author, #by_contributors').click(function() {
        $.ajax({
            url: this.href,
            beforeSend: function( ) {
                $('.event_settings_content').html('<div class="review_list_wrap">loading...</div>');
            },
            success: function(data) {
                $('.event_settings_content').html(data);
            }
        });
        return false;
    });
</script>



<style>
    .user-profile-images-tab li img {
        width: 150px;
        height: 150px;
    }
    .user-profile-images-tab li {
        width: 150px;
    }
</style>