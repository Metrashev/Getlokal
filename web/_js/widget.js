jQuery(function ($) {
    var $body = $('body');
    // center image
    if ($body.hasClass('place')) {
        $('.image').each(function () {
            var $div = $(this),
                $image = $div.find('img');
            $image.on('load', function () {
                var c, i;
                if ($body.hasClass('w')) {
                    c = $div.width();
                    i = $image.width();
                    if (c < i) {
                        $div.scrollLeft((i - c) / 2);
                    }
                } else {
                    c = $div.height();
                    i = $image.height();
                    if (c < i) {
                        $div.scrollTop((i - c) / 2);
                    }
                }
            });
        });
    }

    if ($body.hasClass('events')) {
        $('#tabs li a').click(function (e) {
            e.preventDefault();
            $(this).parent().addClass('a').siblings().removeClass('a');

            $('.tabs ' + $(this).attr('href')).slideDown(500).siblings().slideUp(500);
        });
        $('#tabs li.a a').click();

        $('#change-city a').click(function (e) {
            e.preventDefault();

            $(this).hide();
            $(this).siblings('select').show();
        });
        $('#change-city select').change(function () {
            $(this).parents('form').submit();
        });
    }
});
