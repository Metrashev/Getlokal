<div class="buttons clearfix">
    <a href="getlokal://review" class="review col-xs-6">
        <div class="inner">
	        <i class="icon"></i>
	        <?php echo __('Review'); ?>
        </div>
    </a>
    <?php 
        $fav_text = $is_favorite ? __("Unfollow") : __("Follow");
    ?>
    <a href="getlokal://favorite" class="follow col-xs-6 <?php echo $is_favorite ? 'active' : ''; ?>">
        <div class="inner">
	        <i class="icon"></i>
	        <span data-follow-text="<?php echo __('Follow'); ?>" data-unfollow-text="<?php echo __('Unfollow') ?>">
                <?php echo $is_favorite ? __('Unfollow') : __('Follow'); ?>
            </span>
        </div>
    </a>
    <?php 
        $add_pic = __("Add Pic");
    ?>
    <a href="getlokal://takephoto" class="photo col-xs-6">
        <div class="inner">
            <i class="icon"></i>
            <?php echo __('Add Pic') ?>
        </div>
    </a>
    <?php 
        $checkin_text = __("Check-in");
    ?>
    <a href="getlokal://checkin" class="check-in col-xs-6 <?php echo $is_check_in ? 'active' : ''; ?>">
        <div class="inner">
	        <i class="icon"></i>
	        <?php echo __('Check-in') ?>
        </div>
    </a>
</div>

<script>
    (function ($) {
        jQuery(function () {

            function adjustButtons() {
                // set compact class to elements with smaller height than max
                $(".buttons a").each(function () {
                    if ($(this).height() > 60) {
                        $(this).addClass('compact');
                    } else {
                        $(this).removeClass('compact');
                        if ($(this).height() > 60) {
                            $(this).addClass('compact');
                        }   
                    }
                });

            }

            $("a[href~=getlokal://favorite]").click(function () {
                var $span = $(this).find('span');
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    // sadly .data() method is not working in this jquery version :(
                    $span.html($span.attr('data-follow-text'));
                    adjustButtons();
                } else {
                    $(this).addClass('active');
                    $span.html($span.attr('data-unfollow-text'));
                    $(this).blur();
                    adjustButtons();
                }
            });

            $("a[href~=getlokal://checkin]").click(function () {
                $(this).addClass('active');
            });

            adjustButtons();
            setTimeout(adjustButtons, 200);
            // maybe rotates android tablet? check height too
            $(window).resize(adjustButtons);
        }); 
    })(jQuery);
</script>
