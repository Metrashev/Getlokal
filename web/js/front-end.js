 //==-=Globals=-=-=-=//
 var formChanged = false;
 var xhr = null;
 var tabLink = null; 
$(document).on('submit','#search-form',function(){
    if($('#search_header_where').val() == ''){
        $('#search_header_where').val(searchHeaderWherePlaceholder);
    }
});
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
         }
    });

    // window.onload = (function(){
      $(document).scroll(function () { 
        if( $(document).scrollTop() > 270 ) {
          $element.addClass(className);
        }
      });
    // });         
    
    $(".social_share_wrap").stick_in_parent({
        offset_top:200
    });
    $(".events_desc_share").stick_in_parent({
        offset_top:200
    });
    
    /*-=-=-=Offers box Slider-=-=-=-=*/
    $('#offers-box-slider').flexslider({
        slideshowSpeed: 8000,
        animation: "slide",
        directionNav: true,
        controlNav: false,
        animationLoop: true,
        pauseOnAction: true,
        pauseOnHover: true,
        nextText: " ",
        prevText: " "
    });
    $('#offers-box-slider .flex-direction-nav a').mouseenter(function(){
        $(".offer_more_info").show();
    });
    $('#offers-box-slider .flex-direction-nav a').mouseleave(function(){
        $(".offer_more_info").hide();
    });
    $( ".offer-image-box" ).hover(
        function() {
            $(this).children(".offer_more_info").show();
            var offerBenefitHeight =  $(this).children().children().children(".offer_benefits").outerHeight();
            if(offerBenefitHeight>54){
                $(this).children().children().children(".offer_benefits").css({
                    'marginTop': '-75px', 
                    'marginBottom':'10px'
                });
            }
        }, function() {
            $(this).children(".offer_more_info").hide();
            $(this).children().children().children(".offer_benefits").css({
                'marginTop': '-46px', 
                'marginBottom':'0px'
            });
            $(this).children().children().children(".offer_benefits").children().css("font-size", "16px");
        }
        );

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
    
        
        
    /*setInterval(function() {
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
    });*/
  

    // Category menu
    $("#category_menu_colapse2").css("display","none");
    $(".category_menu li:gt(10)").css("display","none");
    $("#category_menu_colapse, #category_menu_colapse2").click(function() {
        $("#category_menu_colapse").toggle("fast");
        $("#category_menu_colapse2").toggle("fast");
        $(".category_menu li:gt(10)").toggle("fast");
    });
    
    // Voting in place page
    $("#vote_menu_colapse2_li").css("display", "none");
    $(".sidebar div.hp_2columns_right ul.hp_2columns_voting_list li:gt(4)").css("display", "none");
    $(".sidebar #vote_menu_colapse_li").css("display", "block");
    $("#vote_menu_colapse_li").click(function(){
        $(".sidebar div.hp_2columns_right ul.hp_2columns_voting_list li:gt(4)").toggle("fast");
        $(this).css("display", "none");
        $(".sidebar #vote_menu_colapse2_li").css("display", "block");
    });
    $("#vote_menu_colapse2_li").click(function(){
        $(".sidebar div.hp_2columns_right ul.hp_2columns_voting_list li:gt(4)").toggle("fast");
        $(this).css("display", "none");
        $(".sidebar #vote_menu_colapse_li").css("display", "block");
    });
  

    if ($('#tab2').length != 0) {
        $('#read_more_info').css("display", "block");
    }
    
    $('#read_more_address').click(function() {
        $('#read_more_address').css('display', 'none');
        $('.place_addres span').css('display', 'block');
    });
    
    // show / hide event full desc
    $(".desc_full").each(function() {
        if ($(this).height() > 98) {
            $(this).css({
                height:"98px"
            });
            $(this).children("div").css("height","84px");
            $(this).children(".read_full_desc").css("display","inline");
        }
    });
    $("a.read_full_desc").on("click", function(){
        var parent = $(this).parent();
        parent.children("div").css({
            height: ''
        });
        var div_height = parent.children('div').outerHeight() + 20;
        parent.animate({
            height: div_height
        },500, function(){ });
        parent.children(".read_full_desc").css("display","none");
        parent.children(".hide_full_desc").css("display","inline");
    });
    $("a.hide_full_desc").on("click", function(){
        var parent = $(this).parent();
        parent.animate({
            height: 100
        },500, function(){ });
        parent.children('div').animate({
            height: 78
        },500, function(){ });
        parent.children(".read_full_desc").css("display","inline");
        parent.children(".hide_full_desc").css("display","none");
    });
    
    //review interaction buttons
    $(".review_list_company,.review_list_users,.review_company_content").on({
        mouseenter : function() {
            $(this).children("div.review_interaction").children("a.report,a.edit,a.reply,a.delete").fadeIn("fast");
        },
        mouseleave : function() {
            $(this).children("div.review_interaction").children("a.edit,a.delete,a.report,a.reply").fadeOut("fast");
        }
    });
    $(".listing_profile_wrap .listing_content").on({
        mouseenter : function() {
            $(this).children('div').children('div').children("a.report,a.list_report,a.edit,a.list_edit,a.delete,a.list_delete").fadeIn("fast");
        },
        mouseleave : function() {
            $(this).children('div').children('div').children("a.edit,a.list_edit,a.report,a.list_report,a.delete,a.list_delete").fadeOut("fast");
        }
    });

    $(".listing_content").on({
        mouseenter : function() {
            $(this).children('div.review_interaction').children("a.report,a.list_report,a.edit,a.list_edit,a.delete,a.list_delete").fadeIn("fast");
        },
        mouseleave : function() {
            $(this).children('div.review_interaction').children("a.report,a.list_report,a.edit,a.list_edit,a.delete,a.list_delete").fadeOut("fast");
        }
    });
    
    $(".review_content").on({
        mouseenter : function() {
            $(this).children("a.report,a.edit,a.delete").fadeIn("fast");
        },
        mouseleave : function() {
            $(this).children("a.edit,a.report,a.delete").fadeOut("fast");
        }
    });
    //Header login button
    var login_clicked = false;
    $("a.header_login_button").click(function() {
        if (!login_clicked)
        {
            login_clicked = true;
            if ($("#header_login_form_wrap").css('display') == 'block')
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
    

    /*MK Sticky banners*/  
    //    $("#ado_right, #ado_left").sticky({ topSpacing: 98, bottomSpacing:354 });
    /*End Sticky banners*/
    
    
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
   
 if($("#category-menu").length != 0 || $("#event-category").length != 0 || $("#search-by-sector").length != 0){
        /*Article dropdown menu*/
        $('#category-menu').select2({
            minimumResultsForSearch: -1
        });
        $('#category-menu').change(function() {
            window.location = $(this).find("option:selected").attr('value');
            $(this).find("option:selected").attr('selected', 'value');
        });
   
        /*Events dropdown menu*/
        $('#event-category').select2({
            minimumResultsForSearch: -1
        });
        $('#event-category').change(function(sCalendarPropertyURL) {         
           var currentCitySelection = $(this).find("option:selected").attr('all-in-city');
           var noDateSelected = $(this).find("option:selected").attr('no-date-selected');
           var indexPageUrl = $(this).find("option:selected").attr('index');
           var currentOptionSelection = $(this).find("option:selected").val();
           if(currentCitySelection){

           
//                window.location.href = currentOptionSelection;
           }
           else if(noDateSelected){

           
//               window.location.href = currentOptionSelection;
           }
            else if(indexPageUrl){
           
//               window.location.href = currentOptionSelection;
           }
           else{
                var combinedUrl;
                var currentCategoryId = $(this).find("option:selected").attr('data-type');
                var sDate = $("#datepicker").datepicker().val();
                var oDate = new Date(sDate);
                var nDay = oDate.getDate();
                var nMonth = oDate.getMonth() + 1;
                var nYear = oDate.getFullYear();
                var sCalendarPropertyURL = 'nDay=' + nDay + '&nMonth=' + nMonth + '&nYear=' + nYear;
                combinedUrl = '?category_id=' + currentCategoryId + '&' + sCalendarPropertyURL;
                //window.location = combinedUrl;
           }
        });
    
        /*Sectors dropdown menu*/      
        $('#search-by-sector').change(function() {
            window.location = $(this).find("option:selected").attr('value');
            $(this).find("option:selected").attr('selected', 'value');
        });
    }  
     
     /*=-=-=-Shuffle ul li=-=-=-=-*/
    $.fn.shuffle = function() {
        var allElems = this.get(),
        getRandom = function(max) {
            return Math.floor(Math.random() * max);
        },
        shuffled = $.map(allElems, function(){
            var random = getRandom(allElems.length),
            randEl = $(allElems[random]).clone(true)[0];
            allElems.splice(random, 1);
            return randEl;
        });
 
        this.each(function(i){
            $(this).replaceWith($(shuffled[i]));
        });
 
        return $(shuffled);
 
    };
    /*=-=-=-=END Shuffle function=-=-=-*/ 
     setInterval(function () {
        $('ul.similar_items').find('li').shuffle();
    },30000); 
/*=======Company Settings form detection=========*/
    $("#cs-form :input,.img_feature_company, .ez-checkbox ").on('change click keyup paste onpropertychange', function() {
      formChanged = true;     
      
    });  

});// ========END OF DOCUMENT==============//
function companySettingFormSubmition(href){
     tabLink = href;
    $( ".ui-draggable" ).draggable();
        if($('.error_list').length===0){
         if (formChanged) {
            if($('.cta').find('.flash_success').length){
                 window.location.href = tabLink;
                return true;
            }
            else{
                console.log(formChanged);
                $("#dialog-confirm").show();
                $("#form-processing").hide();
                     $("#save-proceed").click(function() {
                       if ($('.tinyMCE').length > 0){
                           tinyMCE.triggerSave();
                       }  
                        var formData = $('#cs-form');
                        var url = formData.attr('action');
                    xhr = $.ajax({
                        type: "POST",
                        url: url,
                        data: formData.serialize(), // serializes the form's elements.
                        beforeSend: function () {
                            $("#form-processing").show();
                            
                        },
                        success: function(data)   
                        {  
                            try
                            {
                                var json = JSON.parse(data);
                                $("#form-processing").hide();
                                $("#save-completed").show();
                                
                                setTimeout(function(){
                                  window.location.href = tabLink;
                                },100);
                            }
                            catch(e)
                            { 
                                $('#tab-container-1').html(data);
                                $("#form-processing").hide();
                                $("#dialog-confirm").hide();  
                            }
                        }
                    });
                    return false; // avoid to execute the actual submit of the form.

                });
                return false;
            }
        }
        else{
           
            window.location.href = tabLink;
        }
    }
    else{
     //   $("#dialog-confirm").show();
      window.location.href = tabLink;
        return true;
    }
}

function abortSending(){
    if(xhr != null){
        xhr.abort();
    }
    setTimeout(function(){
        $("#dialog-confirm").hide();
    },100);
    if(tabLink != null){
        window.location.href = tabLink;
    }  
}
function closeMsg(){
    if(xhr != null){
        xhr.abort();
    }
    setTimeout(function(){
        $("#dialog-confirm").hide();
    },100);
} 
function csFormRegSubmit(){
    $('#cs-form .button_green, #cs-form .input_submit').trigger('click');
}
function staticPagesLayout()
{
    $(".content_wrap").css("min-height", "520px");
    $(".footer_wrap").css({
        "position": "relative", 
        "z-index": "999"
    });
    $('.search_bar').remove();
    $(".banner").remove();
    $("#ado_billboard").css("padding-top", "20px");
    $('ul.tree li a').each(function(){
        if($(this).attr('href') == window.location.pathname) { 
            $(this).addClass('current');
            $(this).parent().children('ul').show();
            $("ul.sub_page_wrapper li a.current").parent().parent().slideDown();
        }; 
    });
        
    $('.static_page_wrapper .sidebar_nav ul.tree li ul.sub_page_wrapper').filter(function(index) {
        var subchild =$('li', this).length;
        //  $(this).children().eq(0).append('<div class="left_sub_arrow"></div>');
        if(subchild >= 1){    
            $(this).prev().css("font-weight", "bolder");
            $(this).prev().append('<div class="pink_arrow_up_down down"></div>');
            $("ul.tree li > ul.sub_page_wrapper").children().children().css("font-weight", "bold");
            $("ul.tree li > ul.sub_page_wrapper li > ul.sub_page_wrapper li a").css("font-weight", "normal");
            $('.pink_arrow_up_down').on('click', function(event){  
                $(this).toggleClass('up down')
                event.preventDefault();
            });   
        }
            
    });
}
function accordeonMenu(){
    // Store variables
    var accordion_head = $('.sub_page_wrapper > li > a'),
    accordion_body = $('.sub_page_wrapper > li > .sub_page_wrapper');
    // Open the first tab on load
    //   accordion_head.first().addClass('active').next().slideDown('normal');
    // Click function
    accordion_head.on('click', function (event) {
        // Disable header links
        //   event.preventDefault();
        // Show and hide the tabs on click
        if ($(this).attr('class') != 'active') {
            accordion_body.slideUp('normal');
            $(this).next().stop(true, true).slideToggle('normal');
            accordion_head.removeClass('active');
            $(this).addClass('active');
        }
    });
}
/*=-=-==-=-=Flash error message 5 sec timeout=-=-=-=-*/ 
function flashErrorMessage() {
    if ($('.flash_error').length > 0) {
        setTimeout(function()
        {
            $('.flash_error.global_error').fadeOut()
        }, 5000)
    }
}
/*=-=-=**END Flash error message 5 sec timeout=-=-*/ 
/*=-=-=-=-RUPA icons=-=-=-=-*/
function rupaIcons(){  
    $('ul.feature_icons_wrapper li').click(function() {
        $(this).children('.img_feature_company').toggleClass('selected');
        var checkBoxes = $(this).children('.ez-checkbox').children("input.ez-hide");
        checkBoxes.attr("checked", !checkBoxes.attr("checked"));
        $(this).children('.ez-checkbox').toggleClass('ez-checked')
    });
         
    $('ul.feature_icons_wrapper li.outdoor_seats').click(function() {
        // $(this).children('.img_feature_company').toggleClass('selected');
        $(this).toggleClass('more_padding');
        $('.form_outdoor_seats_mask').slideToggle('fast');
        $('.feature_icons .form_outdoor_seats').slideToggle('fast');            
    });
    $(':not(ul.feature_icons_wrapper li.outdoor_seats)').click(function (event) {
        if (($(event.target).closest('.feature_icons .form_outdoor_seats').get(0) == null) && ($(event.target).closest('ul.feature_icons_wrapper li.outdoor_seats').get(0) == null) ) {
            if($('#descriptions_outdoor_seats').val().length !=0 ){ 
                $('ul.feature_icons_wrapper li.outdoor_seats .img_feature_company').addClass('selected');
                $('#descriptions_feature_company_list_7').attr("checked", true);
                var outdoor_number = $('input#descriptions_outdoor_seats').val();
                $('ul.feature_icons_wrapper li.outdoor_seats .number p').text(outdoor_number);
            }
            else{
                $('ul.feature_icons_wrapper li.outdoor_seats .img_feature_company').removeClass('selected');
                $('#descriptions_feature_company_list_7').attr("checked", false);
                var outdoor_number = $('input#descriptions_outdoor_seats').val();
                $('ul.feature_icons_wrapper li.outdoor_seats .number p').text(outdoor_number);
            }
            $('.feature_icons .form_outdoor_seats').slideUp('fast');
            $('.form_outdoor_seats_mask').slideUp('fast');
            $('ul.feature_icons_wrapper li.outdoor_seats').removeClass('more_padding');
            $('ul.feature_icons_wrapper li.outdoor_seats').find('input').prop('checked', false); 
        };
    });
    $('ul.feature_icons_wrapper li.indoor_seats').click(function() {
        $(this).toggleClass('selected');
        $(this).toggleClass('more_padding');    
        $('.feature_icons .form_indoor_seats').slideToggle('fast');      
        $('.form_indoor_seats_mask').slideToggle('fast');
    });
        
    $(':not(ul.feature_icons_wrapper li.indoor_seats)').click(function (event) {
        if (($(event.target).closest('.feature_icons .form_indoor_seats').get(0) == null) && ($(event.target).closest('ul.feature_icons_wrapper li.indoor_seats').get(0) == null) ) {
            if($('#descriptions_indoor_seats').val().length !=0 ){ 
                $('ul.feature_icons_wrapper li.indoor_seats .img_feature_company').addClass('selected');
                $('#descriptions_feature_company_list_8').attr("checked", true);
                var outdoor_number = $('input#descriptions_indoor_seats').val();
                $('ul.feature_icons_wrapper li.indoor_seats .number p').text(outdoor_number);
            }
            else{
                $('ul.feature_icons_wrapper li.indoor_seats .img_feature_company').removeClass('selected');
                $('#descriptions_feature_company_list_8').attr("checked", false);
                var outdoor_number = $('input#descriptions_indoor_seats').val();
                $('ul.feature_icons_wrapper li.indoor_seats .number p').text(outdoor_number);
            }        
            $('.feature_icons .form_indoor_seats').slideUp('fast');
            $('.form_indoor_seats_mask').slideUp('fast');
            $('ul.feature_icons_wrapper li.indoor_seats').removeClass('more_padding');

        };
    }); 
      
    $('.form_indoor_seats a.button_green.clear_btn').on('click',function() {
        $('input.indoor_number').val('');
        $('input#descriptions_indoor_seats').val('');
        $('ul.feature_icons_wrapper li.indoor_seats').removeClass('selected');
        $('ul.feature_icons_wrapper li.indoor_seats .number p').text('');
        $('ul.feature_icons_wrapper li.indoor_seats .img_feature_company').removeClass('selected');
        $("#descriptions_feature_company_list_8").attr("checked", false);
    });
      
      
    $('ul.feature_icons_wrapper li.wifi_option').click(function() {
        $(this).toggleClass('selected');
        $(this).toggleClass('more_padding');    
        $('.feature_icons .form_wifi').slideToggle('fast');      
        $('.form_wifi_mask').slideToggle('fast');
    });
          
    $(':not(ul.feature_icons_wrapper li.wifi_option)').click(function (event) {
        if (($(event.target).closest('.feature_icons .form_wifi').get(0) == null) && ($(event.target).closest('ul.feature_icons_wrapper li.wifi_option').get(0) == null) ) {
            if($('#descriptions_wifi_access_0').is(':checked') || $('#descriptions_wifi_access_1').is(':checked')){
                var accessTypeFree = 'Free';
                var accessTypePaid = 'Paid';
                if($("input#descriptions_wifi_access_0:checked" ).val()==0){
                    $('ul.feature_icons_wrapper li.wifi_option .number p').text(accessTypeFree);
                    $('#descriptions_feature_company_list_9').attr("checked", true);
                }
                if($( "input#descriptions_wifi_access_1:checked" ).val()==1){
                    $('ul.feature_icons_wrapper li.wifi_option .number p').text(accessTypePaid);
                    $('#descriptions_feature_company_list_9').attr("checked", true);
                }
                $('ul.feature_icons_wrapper li.wifi_option .img_feature_company').addClass('selected');
            }
            $('.feature_icons .form_wifi').slideUp('fast');
            $('.form_wifi_mask').slideUp('fast');
            $('ul.feature_icons_wrapper li.wifi_option').removeClass('more_padding');
       
        };
    });

    $('.form_outdoor_seats a.button_green').click(function() {
        var outdoor_number = $('input#descriptions_outdoor_seats').val();
        if(outdoor_number==""){
            $('ul.feature_icons_wrapper li.outdoor_seats .img_feature_company').removeClass('selected');
        }else{
            $('ul.feature_icons_wrapper li.outdoor_seats .img_feature_company').addClass('selected');
        }
        $('ul.feature_icons_wrapper li.outdoor_seats .number p').text(outdoor_number);
        $('.feature_icons .form_outdoor_seats').slideUp('fast');
        $('.form_outdoor_seats_mask').slideUp('fast');
        $('ul.feature_icons_wrapper li.outdoor_seats').removeClass('more_padding');
             
    });
        
    $('.form_outdoor_seats a.button_green.clear_btn').click(function() {     
        $('input.outdoor_number').val('');
        $('input#descriptions_outdoor_seats').val('');
        $('ul.feature_icons_wrapper li.outdoor_seats .number p').text('');
        $('ul.feature_icons_wrapper li.outdoor_seats .img_feature_company').removeClass('selected');
        $("#descriptions_feature_company_list_7").attr("checked", false);
    });
        
        
    $('.form_indoor_seats a.button_green').click(function() {
        var indoor_number = $('input#descriptions_indoor_seats').val();
        if(indoor_number==""){
            $('ul.feature_icons_wrapper li.indoor_seats .img_feature_company').removeClass('selected');
        }else{
            $('ul.feature_icons_wrapper li.indoor_seats .img_feature_company').addClass('selected');
        }
        $('ul.feature_icons_wrapper li.indoor_seats .number p').text(indoor_number);
       
        $('.feature_icons .form_indoor_seats').slideUp('fast');
        $('.form_indoor_seats_mask').slideUp('fast');
        $('ul.feature_icons_wrapper li.indoor_seats').removeClass('more_padding');
    });
    $('.form_outdoor_seats input, .form_indoor_seats input').keypress(function (e){
        if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)){
            return false;
      
        }

    });

    function isNumber (o) {
        return ! isNaN (o-0);
    }
    $(".form_outdoor_seats input, .form_indoor_seats input").keyup(function(e){
        var txtVal = $(this).val();  
        if(isNumber(txtVal) && txtVal.length>3)
        {
            $(this).val(txtVal.substring(0,3) )
        }
    });
        
    $('.form_wifi a.button_green').on('click',function() {
        if($('.form_wifi .ez-radio').hasClass('ez-selected')){
            var accessTypeFree = 'Free';
            var accessTypePaid = 'Paid';
            if($("input#descriptions_wifi_access_0:checked" ).val()==0){
                $('ul.feature_icons_wrapper li.wifi_option .number p').text(accessTypeFree);
            }
            if($( "input#descriptions_wifi_access_1:checked" ).val()==1){
                $('ul.feature_icons_wrapper li.wifi_option .number p').text(accessTypePaid);
            }
            $('ul.feature_icons_wrapper li.wifi_option .img_feature_company').addClass('selected');    
            $('.feature_icons .form_wifi').slideUp('fast');
            $('.form_wifi_mask').slideUp('fast');
            $('ul.feature_icons_wrapper li.wifi_option').removeClass('more_padding');
           
        }
            
    });
    $('.form_wifi a.button_green.clear_btn').on('click',function() {
        $('.form_wifi .ez-radio').removeClass('ez-selected');
        $('#descriptions_feature_company_list_9').attr("checked", false);
        $('ul.feature_icons_wrapper li.wifi_option .number p').text('');
        $('ul.feature_icons_wrapper li.wifi_option .img_feature_company').removeClass('selected');
        $('#descriptions_wifi_access_0').attr("checked", false);
        $('#descriptions_wifi_access_1').attr("checked", false);
    });   
    /*Close forms on X */    
   
    $('.form_outdoor_seats a#picture_form_close img').on('click',function(){ 
        if($('#descriptions_outdoor_seats').val().length !=0 ){ 
            $('ul.feature_icons_wrapper li.outdoor_seats .img_feature_company').addClass('selected');
                   
        }
        else if($('#descriptions_outdoor_seats').val().length ==0 ){ 
            $('ul.feature_icons_wrapper li.outdoor_seats .img_feature_company').removeClass('selected');
                 
        }
        $('.feature_icons .form_outdoor_seats').slideUp('fast');
        $('.form_outdoor_seats_mask').slideUp('fast');
        $('ul.feature_icons_wrapper li.outdoor_seats').removeClass('more_padding');
    });
    
    $('.form_indoor_seats a#picture_form_close img').on('click',function(){
        if($('#descriptions_indoor_seats').val().length !=0 ){ 
            $('ul.feature_icons_wrapper li.indoor_seats .img_feature_company').addClass('selected');
                   
        }
        else if($('#descriptions_indoor_seats').val().length ==0 ){ 
            $('ul.feature_icons_wrapper li.indoor_seats .img_feature_company').removeClass('selected');
                 
        }
        $('.feature_icons .form_indoor_seats').slideUp('fast');
        $('.form_indoor_seats_mask').slideUp('fast');
        $('ul.feature_icons_wrapper li.indoor_seats').removeClass('more_padding');
    });
    
    $('.form_wifi a#picture_form_close img').on('click',function(){ 
       
        if($('#descriptions_wifi_access_0').is(':checked') || $('#descriptions_wifi_access_1').is(':checked')){
            var accessTypeFree = 'Free';
            var accessTypePaid = 'Paid';
            if($("input#descriptions_wifi_access_0:checked" ).val()==0){
                $('ul.feature_icons_wrapper li.wifi_option .number p').text(accessTypeFree);
                $('#descriptions_feature_company_list_9').attr("checked", true);
            }
            if($( "input#descriptions_wifi_access_1:checked" ).val()==1){
                $('ul.feature_icons_wrapper li.wifi_option .number p').text(accessTypePaid);
                $('#descriptions_feature_company_list_9').attr("checked", true);
            }
            $('ul.feature_icons_wrapper li.wifi_option .img_feature_company').addClass('selected');
        }else if(!$('#descriptions_wifi_access_0').is(':checked') || !$('#descriptions_wifi_access_1').is(':checked')) {
            $('ul.feature_icons_wrapper li.wifi_option .img_feature_company').removeClass('selected');
            $('#descriptions_feature_company_list_9').attr("checked", false);
        }
        $('.feature_icons .form_wifi').slideUp('fast');
        $('.form_wifi_mask').slideUp('fast');
        $('ul.feature_icons_wrapper li.wifi_option').removeClass('more_padding');
    });
  
    if($('.feature_icons .form_indoor_seats input[type=text]').val().lenght !==0){
        var indoor_number = $('input#descriptions_indoor_seats').val();
        $('ul.feature_icons_wrapper li.indoor_seats .number p').text(indoor_number);
    }
 
    if($('.feature_icons .form_outdoor_seats input[type=text]').val().lenght !==0){
        var outdoor_number = $('input#descriptions_outdoor_seats').val();
        $('ul.feature_icons_wrapper li.outdoor_seats .number p').text(outdoor_number);
    }
 
    if($('#descriptions_wifi_access_0').is(':checked') || $('#descriptions_wifi_access_1').is(':checked')){
        var accessTypeFree = 'Free';
        var accessTypePaid = 'Paid';
        if($("input#descriptions_wifi_access_0:checked" ).val()==0){
            $('ul.feature_icons_wrapper li.wifi_option .number p').text(accessTypeFree);
            $('#descriptions_feature_company_list_9').attr("checked", true);
        }
        if($( "input#descriptions_wifi_access_1:checked" ).val()==1){
            $('ul.feature_icons_wrapper li.wifi_option .number p').text(accessTypePaid);
            $('#descriptions_feature_company_list_9').attr("checked", true);
        }
        $('ul.feature_icons_wrapper li.wifi_option .img_feature_company').addClass('selected');
    }

    if($('#descriptions_outdoor_seats').val().length !=0 ){ 
        $('ul.feature_icons_wrapper li.outdoor_seats .img_feature_company').addClass('selected');
    }
    if($('#descriptions_indoor_seats').val().length !=0 ){ 
        $('ul.feature_icons_wrapper li.indoor_seats .img_feature_company').addClass('selected');
    }

}    
/*=-=-=-=-RUPA icons END=-=-=-=*/
/*Clear inputs contac form*/
function clearContactInputs(){
 
    var textareaValue = $('form.offices_contact textarea, form.add-company-mail textarea');
    
    if (($('#contact_email').val().length == 0)) {
        $('#contact_email').prev().show();
    }
    if ($('#contact_name').next().next().is('.error_list')) {
           
        $('#contact_name').prev().show();
    }   
    if ((textareaValue.val().length == 0) || (textareaValue.next().next().is('.error_list'))) {
        textareaValue.prev().show();
    }
     
    if (($('#contact_email').val().length > 0)) {
        $('#contact_email').prev().hide();
    }
    if (($('#contact_name').val().length > 0)) {
        $('#contact_name').prev().hide();
    }
    if (($('#contact_phone').val().length > 0)) {
        $('#contact_phone').prev().hide();
    }
    if ((textareaValue.val().length > 0) ) {
        textareaValue.prev().hide();
    }
    if(($("#contact_phone").next().next().is('.error_list'))){
    {
        $("#contact_phone").prev().hide();
    }
    }

    $('form.offices_contact .form_box.label_in input[type=text], form.offices_contact textarea, form.add-company-mail .form_box.label_in input[type=text], form.add-company-mail textarea').on('focus', function() {
        $(this).prev().hide();
    });
    $('form.offices_contact .form_box.label_in input[type=text], form.add-company-mail .form_box.label_in input[type=text]').on('blur', function() {
        if($(this).val().length > 0){
            $(this).prev().hide();
        }else
        {
            $(this).prev().show();
        }
          
    });
    $('form.offices_contact textarea, form.add-company-mail textarea').on('blur', function() {
        if($(this).val().length > 0){
            $(this).prev().hide();
        }else
        {
            $(this).prev().show();
        }
          
    });
    if ($('form.offices_contact .captcha_out, form.add-company-mail .captcha_out').next().next().is('.error_list')) {
        $('form.offices_contact .captcha_out, form.add-company-mail .captcha_out').next().next().addClass("get_captcha_width");
    }
}
/*END Clear inputs contact form*/

function recommendedTabs(){
      $('#login').click(function() {
        $('.login_form_wrap').slideToggle();
    });
    if($('.cta_wrap.special').outerHeight() > 0){
        $('.cta_wrap.special').css('marginTop', '40px')
    }

    $('.standard_links_top a').click(function() {
        $('.standard_links_top a').removeClass('current');
        $(this).addClass('current');
        $.ajax({
            url: this.href,
            beforeSend: function( ) {
                $('.standard_links_in').html('<div class="review_list_wrap"><img src="/images/gui/horizontal_loader.GIF"/></div>');
            },
            success: function( data ) {
                $('.standard_links_in').html(data);
            }
        });
        return false;
    });
    $('.hp_2columns_left').css('margin','0');
}

function loadPage(url,page,is_component){
    
    if(is_component){
        if(url.indexOf("selected_tab") < 0){
            url += "/selected_tab/"+$("input[name=selected_tab]").val();
        }
        if(url.indexOf("category_id") < 0){
            url += "/category_id/"+$("#event-category").val();
        }
    }
    
    $(".recomend_events_tabs_wrap .standard_tabs_in_footer").append('<div class="review_list_wrap"><img src="/images/gui/horizontal_loader.GIF"/></div>');
    if(!is_component){
        $(".recomend_events_tabs_wrap").load(url+"?page="+page+" .standard_links_wrap",function(){
            $(".recomend_events_tabs_wrap .standard_tabs_in_footer .review_list_wrap");
            loadDatepickerTab();
        })
    }else{
        $.get(url+"?page="+page,{},function(html){
            $('.standard_links_top a').removeClass('current');

            if(url.indexOf("active") > -1){
                $('.standard_links_top a#active-events').addClass('current');
            }

            if(url.indexOf("future") > -1){
                $('.standard_links_top a#future-events').addClass('current');
            }

            if(url.indexOf("past") > -1){
                $('.standard_links_top a#past-events').addClass('current');
            }
            $(".standard_links_in").html(html);
        })
        
    }
}

function clearDateText(){
    $(".date_text").html("<em></em>")
}

function userCompanyForm(elem){
     $('.settings_user_company_form_error div.settings_user_company_form').css('display', 'block');
}
/*$(document).click(function (event) {
        if (($(event.target).closest('.settings_user_company_form').get(0) == null)&& ($(event.target).closest('.button_green').get(0) == null))
        { $(".settings_user_company_form.user_settings_login").slideUp('fast')
           
             $('.button_green').removeClass('formOpened');
        }
        
        if (($(event.target).closest('.settings_user_company_form').get(0) == null)&& ($(event.target).closest('.button_green').get(0) == null))
        { $(".settings_user_company_form").slideUp('fast') 
           
             $('.button_green').removeClass('formOpened');
        }
   
});
*/

function openSignUserForm(elem){
    $('.button_green').removeClass('formOpened');
    $(elem).addClass("formOpened");
    $('.settings_user_company_form').hide();
    $(elem).siblings().closest('.settings_user_company_form').slideToggle();
    $('.settings_user_company a#header_close').click(function(){
        $(".settings_user_company_form").slideUp('fast');
        $('.button_green').removeClass('formOpened');
    }); 
}

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