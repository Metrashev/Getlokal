<div class="buttons clearfix">
    <a href="getlokal://review" class="review col-xs-6">
        <div class="inner">
	        <i class="icon"></i>
	        <?php echo __('Review'); ?>
        </div>
    </a>
    <?php 
        $fav_text = $is_favorite ? __("Unfollow") : __("Follow");
        $fav_class = '';
        if (mb_strlen($fav_text, 'UTF-8') > 16 && strpos($fav_text, ' ') !== false) {
            $fav_class = ' compact ';
        }
    ?>
    <a href="getlokal://favorite" class="follow col-xs-6 <?php echo $fav_class; echo $is_favorite ? 'active' : ''; ?>">
        <div class="inner">
	        <i class="icon"></i>
	        <span data-follow-text="<?php echo __('Follow'); ?>" data-unfollow-text="<?php echo __('Unfollow') ?>">
                <?php echo $is_favorite ? __('Unfollow') : __('Follow'); ?>
            </span>
        </div>
    </a>
    <?php 
        $add_pic = __("Add Pic");
        $add_pic_class = ''; 
        
        if (mb_strlen($add_pic, 'UTF-8') > 16 && strpos($add_pic, ' ') !== false) {
            $add_pic_class = ' compact';
        }
    ?>
    <a href="getlokal://takephoto" class="photo col-xs-6<?php echo $add_pic_class; ?>">
        <div class="inner">
            <i class="icon"></i>
            <?php echo __('Add Pic') ?>
        </div>
    </a>
    <?php 
        $checkin_text = __("Check-in");
        $checkin_class = '';
        if (mb_strlen($checkin_text, 'UTF-8') > 16 && strpos($checkin_text, ' ') !== false) {
            $checkin_class = ' compact ';
        }
    ?>
    <a href="getlokal://checkin" class="check-in col-xs-6 <?php echo $checkin_class; echo $is_check_in ? 'active' : ''; ?>">
        <div class="inner">
	        <i class="icon"></i>
	        <?php echo __('Check-in') ?>
        </div>
    </a>
</div>

<script>
    (function ($) {
        jQuery(function () {
            $("a[href~=getlokal://favorite]").click(function () {
                var $span = $(this).find('span');
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    // sadly .data() method is not working in this jquery version :(
                    $span.html($span.attr('data-follow-text'));
                    if ($span.attr('data-follow-text').length > 16) {
                        $(this).addClass('compact');
                    } else {
                        $(this).removeClass('compact');
                    }
                } else {
                    $(this).addClass('active');
                    $span.html($span.attr('data-unfollow-text'));
                    $(this).blur();
                    if ($span.attr('data-unfollow-text').length > 16) {
                        $(this).addClass('compact');
                    } else {
                        $(this).removeClass('compact');
                    }
                }
            });

            $("a[href~=getlokal://checkin]").click(function () {
                $(this).addClass('active');
            });
        }); 
    })(jQuery);
</script>