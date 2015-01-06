$(document).ready(function(){
    var $document = $(document),
    $element = $('.main_menu_wrap'),
    className = 'hasScrolled';

    $document.scroll(function() {
        if ($document.scrollTop() === 0) {
            // user scrolled 0 pixel
            $element.removeClass('offset-coord')
            .removeClass(className);
        } 
        else if (!$('.main_menu_wrap').isOnScreen()) {
            $element.addClass('offset-coord');
            setTimeout(function(){
                $element.addClass(className);
            }, 100);
        }
    });	
    /*=-=-=-Footer slide menu=-=-=-=*/
    var citiesWrap =  $('.footer_column.country_choise ul ul.footer_cities_wrap');
    var countriesWrap =  $('.footer_wrap .footer_columns_wrapper .footer_column ul ul.country_list.left');
    var currentCountry = $('.footer_wrap .footer_columns_wrapper .footer_column ul ul.country_list.left li.current');
    countriesWrap.css('height',citiesWrap.outerHeight());
    currentCountry.hover(function() {
        citiesWrap.css({
            'visibility':'visible',
            'left':'0'
        });
    }, function() {
        citiesWrap.css({
            'visibility':'hidden',
            'left':'-82px'
        });
    });
    citiesWrap.mouseenter( function() { 
        $(this).css({
            'visibility':'visible',
            'left':'0'
        });
    });
    citiesWrap.mouseleave(function() { 
        $(this).css({
            'visibility':'hidden',
            'left':'-84px'
        });
    
    });
    /*=-=-=-=End Footer slide menu-*/
    $("#delay_demo").addClass("activation");
    $("#delay_demo a#close").click(function(){
        $('.welcome_message').hide();
    });
    setTimeout(function()
    {
        $('.welcome_message').show();
    }, 300);

    setTimeout(function()
    {
        $('.welcome_message').hide();
    }, 12000);  

    $('.embedding a.btn').click(function () {
        $('.email_form_wrap').removeClass('email_form_wrap_opened');
    });
       
    $('.place_main_vip > .place_right .place_item_gray').css({
        'height': ($('.place_main_vip > .place_left .place_contact_info').outerHeight()+1)
    });
	
    $('body').bind('click', function(e) {
        if($(e.target).closest('.header_user_content').length == 0) {
            HideHeaderDropdown();
        }
        if($(e.target).closest('.header_user_notif').length == 0) {
            $('.header_user_notif').children('.dropdown_wrap').slideUp(100);
            $('.header_user_notif div.notification_icon').removeClass("black");
        }
        if($(e.target).closest('.header_user_msg').length == 0) {
            $('.header_user_msg').children('.dropdown_wrap').slideUp(100);
            $('.header_user_msg div.message_icon').removeClass("black");
        }
    });
	
    $('.main_menu_mini .menu_wrap').mouseenter(function() {
        $('.menu_link_wrap').stop().slideDown('fast');
    });
    $('.main_menu_mini .menu_wrap').mouseleave(function() {
        $('.menu_link_wrap').stop().slideUp('fast');
    });
  
    $('#logo').hover(function() {
        $('div.main_menu .location_wrap').stop().slideDown('fast');
    }, function() {
        $('div.main_menu .location_wrap').stop().slideUp('fast');
    });
    $('.menu_wrap').on('mouseenter', function() { 
        $('div.main_menu .location_wrap').stop().slideUp('fast');
    });

    $('.header_user_content').hover(function() {
        if (!$('.header_user_content').hasClass('header_user_content_opened'))
        {
            $('.header_user_content .input_box input').width($('.header_user_content').outerWidth() - 41);
            $('.header_user_content').stop().animate({
                height: $('#header_dropdown_wrap').outerHeight() + 38 + 'px'
            }, 100);
            $('#header_dropdown_wrap').stop().slideDown(100);
            $('.dropdown_wrap').slideUp(100)
            if ($('.not_logged').length > 0)
            {
                $('.header_user_content p').show();
                $('.header_user_content').children('span').hide();
                $('#header_dropdown_wrap').css('top', '56px');
            }
            else {
                $('.header_user_content .mask').css({
                    display: 'block', 
                    'width': $('.header_user_content').outerWidth() - 2
                });
                if ($('.header_user_content').parent().parent().parent().hasClass('main_menu_mini'))
                    $('#header_dropdown_wrap').css('marginLeft', ($('.header_user_content').outerWidth() - $('#header_dropdown_wrap').outerWidth() - 4));
                else
                    $('#header_dropdown_wrap').css('marginLeft', ($('.header_user_content').outerWidth() - $('#header_dropdown_wrap').outerWidth() - 9));
            }
        }
    }, function() {
        if (!$('.header_user_content').hasClass('header_user_content_opened'))
        {
            HideHeaderDropdown();
        }
    });
	
    function HideHeaderDropdown() {
        if ($('.not_logged').length > 0)
        {
            $('.header_user_content p').hide();
            $('.header_user_content').children('span').show();
            $('.header_user_content').children('img').hide();
        }
        if ($('.header_user_content').parent().parent().parent().hasClass('main_menu_mini'))
            $('.header_user_content').stop().animate({
                height: '36'
            }, 100);
        else
            $('.header_user_content').stop().animate({
                height: '36'
            }, 100);
        
        $('#header_dropdown_wrap').stop().slideUp(100, function() {
            $('.header_user_content .mask').hide();
        });
    }
	
    $('.header_user_content input[type="text"], .header_user_content input[type="password"]').focus(function() {
        $('.header_user_content').addClass('header_user_content_opened');
    }).blur(function() {
        $('.header_user_content').removeClass('header_user_content_opened');
    });
	
    if ($('.user_scroll li').length > 3) {
        $('.user_scroll').tinyscrollbar();
    }
    else {
        $('.user_scroll .overview').css('position', 'static');
        $('.user_scroll .viewport').css('height', $('.user_scroll .viewport ul').outerHeight());
        $('.user_scroll .scrollbar').remove();
    }
    if ($('.item_count').outerHeight() < $('.dropdown_links').outerHeight()) {
        $('.item_count').css('height', $('.dropdown_links').height());
    }
    $('#header_dropdown_wrap').css({
        'display':'none', 
        'visibility': 'visible'
    });
        
    $('.header_user_notif').click(function() {
        $('.header_user_notif div.notification_icon').toggleClass("black");
        if ($(this).children('.dropdown_wrap').find('li').length > 1) {
            $(this).children('.dropdown_wrap').slideToggle(100);
            $(this).find('span').hide();
        }
    });
    $('.header_user_msg').click(function() {
        $('.header_user_msg div.message_icon').toggleClass("black");
        if ($(this).children('.dropdown_wrap').find('li').length > 1) {
            $(this).children('.dropdown_wrap').slideToggle(100);
            $(this).find('span').hide();
        }
    });
	
        
        
    setInterval(function() {
        $('.input_box input').each(function(i,s) {
            if($(s).val()) $(s).parent().find('label').hide();
        })
    }, 1000)
	
    $('.input_box input, .input_box textarea').each(function(i,s) {
        s = $(s);
        if(s.val()) {
            s.parent().find('label').hide();
        }

        s.focus(function() {
            $(this).parent().find('label').hide();
        }).blur(function() {
            if(!$(this).val()) $(this).parent().find('label').show();
        })
    });


    //Header login button
    var login_clicked = false;
    $("a.header_login_button").click(function() {
        if (!login_clicked)
        {
            login_clicked = true;
            if ($("#header_login_form_wrap").css('display') == 'none')
            {
                $(".header_login_pointer").toggle();
                $("#header_login_form_wrap").slideDown("fast");
                $(".search_bar_form").animate({
                    top: '+=40'
                }, 'fast', function() {
                    login_clicked = false;
                });
            }
            else
            {
                $("#header_login_form_wrap").slideUp("fast");
                $(".search_bar_form").animate({
                    top: '-=40'
                }, 'fast', function() {
                    $(".header_login_pointer").toggle();
                    login_clicked = false;
                });
            }
        }
    	
    });
    $("#header_login_form_wrap a#header_close, #header_login_form_wrap a#header_white_close").click(function() {
        $("#header_login_form_wrap").slideUp("fast");
        $(".header_login_pointer").slideUp("fast");
		
    });
	
    $(".login_form_wrap a#header_close, .login_form_wrap a#header_white_close").click(function() {
        $(".login_form_wrap").slideUp("fast", function() {
            $('body.special .page_wrap').height($('.content_events').outerHeight() + 46);
        });
    });
	
    //place_contacts (company page 2 column)
    if ($('.place_contacts li').length > 2)
    {
        $('.place_contacts li a.facebook').parent().css('position', 'absolute');
        $('.place_contacts li a.facebook').parent().css('right', '2px');
        $('.place_contacts li a.facebook').parent().css('top', '12px');
    }
	
    //header login button nice hover effect
    loginBtnWidth = $('a.header_login_button').width();
    $('a.header_login_button').mouseenter(function() {
        $('a.header_login_button').width(loginBtnWidth);
    });
    $('a.header_login_button').mouseleave(function() {
        $('a.header_login_button').width('auto');
    });
	
    //header user options menu dropdown 
    $("#header_user_options_button").click(function(){
        if ($(".header_user li:last-child").css("display") == 'none') {
            $(".header_user li:gt(0)").toggle("fast", function() {
                $("a#header_user_options_button").css("background-Image", "url(/images/gui/arrow_up_big.gif");
            });
        }
        else {
            $(".header_user li:gt(0)").toggle("fast", function() {
                $("a#header_user_options_button").css("background-Image", "url(/images/gui/arrow_down_big.gif");
            });
        }
    });
   
   
   
    $('a.button_clickable').click(function() {
        if ($(this).hasClass('button_clicked')) 
            $(this).removeClass('button_clicked');
        else
            $(this).addClass('button_clicked');
    });
    
    //tooltips
    $('.tooltip').each(function() {
        var element = null;
        var tooltip_text = $(this).parent().children('div.tooltip_body');
        if ($(this).parent().children('input').length > 0)
            element = $(this).parent().children('input');
        else if ($(this).parent().children('textarea').length > 0)
            element = $(this).parent().children('textarea');
        var leftOffset = element.outerWidth() - parseInt($(this).outerWidth());
        var topOffset = -tooltip_text.outerHeight() - $(this).outerHeight() - 4;
        $(this).css({
            'left': leftOffset, 
            'marginTop': (-element.outerHeight() - $(this).outerHeight() - 4)
        });
        tooltip_text.css({
            'left': (leftOffset - 2), 
            'top': topOffset-8
        });
    });
    $('.tooltip_body').hide();
    
    $('.tooltip').hover(function() {
        $(this).parent().children('.tooltip_body').show();
    }, function() {
        $(this).parent().children('.tooltip_body').hide();
    });
    $('input').each(function() {
        if (!($(this).hasClass('star')))
        {
            $(this).ezMark();
        }
    });
	
    
    if($("#google_map").length===0){
        $("#ado_brand").css("margin-top", "20px");
        $("div#ado_billboard").css("margin-top", "30px"); 
    } 

    /*Banners margins*/
    if($("div#ado_brand").length!==0 && $('.search_bar')===0){
        $(".page_wrap").css("padding-top", "20px");    
    }
    else{
        $(".page_wrap").css("margin-top", "0px");
    }
    if($("div#ado_brand").length != 0){
        var selectMenu = $(".related_category.event_dropdown");
        var eventBreadcrumb = $('.events_wrap .breadcrumb');
        var eventHeading = $("h1.dotted_event_heading");
        selectMenu.addClass("more-padding");
        eventBreadcrumb.addClass("more-padding");  
        eventHeading.addClass("more-padding");
    }
    /*END Banners margins*/
    /*Cta banners*/
    if ($('.page_wrap .cta_wrap').children().length < 2 || $('.search_bar').is(":hidden")){
        $('.page_wrap').css('paddingTop', '20px');
    }
    /*END cta banners*/

    var overlayDesabler = $('.map_activator');        
    overlayDesabler.click(function() {
        $(this).hide();
    });  
   
});// ========END OF DOCUMENT==============//

$.fn.isOnScreen = function(){
    
    var win = $(window);
    
    var viewport = {
        top : win.scrollTop(),
        left : win.scrollLeft()
    };
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height();
    
    var bounds = this.offset();
    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();
    
    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
    
};