<div class="buttons clearfix">
    <a href="getlokal://review" class="review col-xs-3">
        <i class="icon"></i>
        <?php echo __('Review'); ?>
    </a>
    <a href="getlokal://takephoto" class="photo col-xs-3">
        <i class="icon"></i>
        <?php echo __('Add Pic') ?>
    </a>
    <a href="getlokal://favorite" class="follow col-xs-3 <?php echo $is_favorite ? 'active' : ''; ?>">
        <i class="icon"></i>
        <span data-follow-text="<?php echo __('Follow'); ?>" data-unfollow-text="<?php echo __('Unfollow') ?>">
            <?php echo $is_favorite ? __('Unfollow') : __('Follow'); ?>
        </span>
    </a>
    <a href="getlokal://checkin" class="check-in col-xs-3 <?php echo $is_check_in ? 'active' : ''; ?>">
        <i class="icon"></i>
        <?php echo __('Check-in') ?>
    </a>
</div>

<script>
    (function ($) {
        jQuery(function () {
            $("a[href~=getlokal://favorite]").click(function () {
                var $span = $(this).find('span');
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    $span.html($span.attr('data-follow-text'));
                } else {
                    $(this).addClass('active');
                    $span.html($span.attr('data-unfollow-text'));
                    $(this).blur();
                }
            });

            $("a[href~=getlokal://checkin]").click(function () {
                $(this).addClass('active');
            });
        });
    })(jQuery);
</script>
