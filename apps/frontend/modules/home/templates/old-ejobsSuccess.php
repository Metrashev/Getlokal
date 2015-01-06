<?php slot('no_map'); end_slot(); ?>
<div class="sector-classification-wrap">
    <?php include_component('box', 'boxCategoriesMenu') ?>
</div>
<div class="content_in ejobs-iframe">
  <iframe id="ejobs-iframe" src="//ejobs.ro/getlokal" frameborder="0"></iframe>
</div>

<div class="sidebar">
    <div style="margin-top: 42px">
           <?php include_component('box', 'boxOffers') ?>
    </div>
    <?php include_component('box', 'boxVip') ?>
    <?php //include_component('box', 'boxReviews', array('box' => $reviews, 'sector'=>$sector)) ?>
    <?php include_component('home','social_sidebar'); ?>
    <?php //include_component('box', 'column', array('key' => 'home', 'column' => 2));  ?>
</div>

<script>
    (function ($) {
        function resize() {
            $("#ejobs-iframe").height($(".sidebar").innerHeight() - 55);
        }
        jQuery(resize);
        // social plugins may load slowly
        setTimeout(resize, 500);
        setTimeout(resize, 1000);
        setTimeout(resize, 2000);
    })(jQuery);
</script>