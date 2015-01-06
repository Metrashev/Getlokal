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
        <?php echo $is_favorite ? __('Unfollow') : __('Follow'); ?>
    </a>
    <a href="getlokal://checkin" class="check-in col-xs-3 <?php echo $is_check_in ? 'active' : ''; ?>">
        <i class="icon"></i>
        <?php echo __('Check-in') ?>
    </a>
</div>
