jQuery(function ($) {

    if ($('.embedding').length === 0) {
        return;
    }

    var $embed = $('.embedding'),
        data = $embed.data(),
        $btn = $embed.find('.btn'),
        $box = $embed.find('.box'),
        props = {
            $color: $embed.find('#background'),
            $width: $embed.find('#width'),
            $height: $embed.find('#height'),
            $category: $embed.find('#category'),
            $location: $embed.find('#location')
        },
        $code = $embed.find('#code'),
        src = '%URL%?width=%WIDTH%&height=%HEIGHT%&color=%COLOR%',
        template;

    switch (data.type) {
        case 'events':
            src = '%URL%?width=%WIDTH%&height=%HEIGHT%&color=%COLOR%&category=%CATEGORY%&location=%LOCATION%';
            break;
    }

    template = '<iframe src="' + src + '" name="gl_widget" scrolling="%SCROLLING%" width="%WIDTH%" height="%HEIGHT%" frameborder="0"></iframe>';

    function close(e) {
        if ($(e.target).parents('.embedding').length > 0) {
            return;
        }

        $box.hide();
        $('body').unbind('click', close);
    }

    $btn.click(function (e) {
        e.preventDefault();
        $box.toggle();

        if ($box.is(':visible')) {
            // add close event for body
            setTimeout(function () {
                $('body').bind('click', close);
            }, 0);
        }
    });

    function format(options) {
        var r, v,
            tpl = template;

        for (var o in options) {
            v = options[o];
            tpl = tpl.replace(new RegExp('%' + o + '%', 'gi'), v);
        }
        return tpl;
    }

    $code.click(function () {
        this.select();
    });

    for (var p in props) {
        props[p].change(update);
    }

    // update code using params
    function update() {
        var options = {
            url: data.url,
            color: props.$color.val(),
            width: props.$width.val(),
            height: props.$height.val(),
            category: props.$category.val(),
            location: props.$location.val(),
            scrolling: 'no'
        };

        // calculate height
        switch (data.type) {
            case 'place':
                options.height = options.width > 500 ? 220 : 400;
                break;
                
            case 'events':
                options.width = 317;
                options.scrolling = 'auto';
                break;
        }
        $code.val(format(options));
    }
    update();
    
});
