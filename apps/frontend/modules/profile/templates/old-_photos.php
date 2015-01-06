<?php use_stylesheet('ui-lightness/jquery-ui-1.8.16.custom.css'); ?>
<?php use_javascript('jquery.ui.dialog.js'); ?> 
<?php foreach ($pager->getResults() as $image): ?>
    <li class="current_picture">
        <a href="<?php echo $image->getThumb('preview') ?>" target="_blank" class="lightbox" rel="group" title="<?php echo $image->getCaption() ?>">
            <?php echo image_tag($image->getThumb()) ?>
        </a>

        <?php if ($is_current_user): ?>
            <?php if ($image->getStatus() == 'approved'): ?>
                <?php if ($image->getId() != $user->getUserProfile()->getImageId()): ?>
                    <a href="<?php echo url_for('userSettings/setProfile?id=' . $image->getId()) ?>" class="button_green"><?php echo __('set as profile photo', null, 'company') ?></a>
                <?php else: ?>
                <?php endif; ?>
            <?php else: ?>
                <?php echo $image->getStatus(); ?>
            <?php endif ?>
            <?php echo link_to(__('delete', null, 'company'), 'userSettings/deleteImage?id=' . $image->getId(), 'class=button_confirm') ?>
        <?php endif ?>
        <div class="clear"></div>
    </li>

<?php endforeach ?>
<div id="dialog-confirm" title="<?php echo __('Delete this image?', null, 'company') ?>" style="display:none;">
    <p><?php echo __('Are you sure you want to delete this image?', null, 'company') ?></p>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('a.button_confirm').click(function() {
            var delelePhotoLink = $(this).attr('href');        
            $("#dialog-confirm").dialog({
                resizable: false,
                height: 250,
                width:340,
                buttons: {
                    "<?php echo __('delete', null) ?>": function() {
                       window.location.href = delelePhotoLink;
                    },
                    <?php echo __('cancel', null) ?>: function() {
                        $(this).dialog("close");
                    }
                }
            });
            return false;
        });
    });




</script>