$(function() {
	$('#carousel ul').carouFredSel({
        items: 1,
		prev: '#prev',
		next: '#next',
		pagination: "#pager",
		scroll: 700,
		auto: false,
	});

    $('#offers-carousel ul').carouFredSel({
        items: 1,
        prev: '#offers-prev',
        next: '#offers-next',
        pagination: "#offers-pager",
        scroll: 1500,
        auto: false,
    });

    $(".testimonials").niceScroll({
        touchbehavior:false ,
        cursorcolor:"#dadada" ,
        cursorwidth: '10px' ,
        zindex: "30",
    });

        $("html").niceScroll({
        touchbehavior:false ,
        cursorcolor:"#000" ,
        cursorwidth: '10px' ,
        zindex: "50"
    });

    $('.profile-ico').click(function(){
        var isOpen = $(this).attr("is-open")
        if(isOpen == "yes"){
            hideProfile();
        }else{
            showProfile();
        }
    });

    $(".image-dropdowns").click(function(e){
        e.stopPropagation();
    });

$('.notification-ico').click(function(){
        var isOpen = $(this).attr("is-open")
        if(isOpen == "yes"){
            hideNotif();
        }else{
            showNotif();
        }
    });

    $(".section-notifications").click(function(e){
        e.stopPropagation();
    });

    $("span.new-mail-circle").click(function(){
        $(this).addClass("notification-ico");
    });

    $('.btn-add-dropdown').click(function(){
        var isOpen = $(this).attr("is-open")
        if(isOpen == "yes"){
            hide();
        }else{
            show();
        }
    });

    $(".section-add").click(function(e){
        e.stopPropagation();
    });

    $(".fa-angle-down").click(function(){
        $(this).addClass("btn-add-dropdown");
    });

    $('.ico-messages').click(function(){
        var isOpen = $(this).attr("is-open")
        if(isOpen == "yes"){
            hideSection();
        }else{
            showSection();
        }
    });

    $(".section-messages").click(function(e){
        e.stopPropagation();
    });

    $("span.new-mail-message-circle").click(function(){
       $(this).addClass("ico-messages");
    });

   $('.see-more').click(function() {
        $('.categories-list').animate({
            scrollTop: '+=999'
        }, 600);
    });

        $('.scroll-top').click(function() {
        $('.categories-list').animate({
            scrollTop: '-=999'
        }, 600);
    });

    $('.categories-list').bind('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight) {
            $('.scroll-top').show();
            $('.see-more').hide();
        }
    });

    $('.categories-list').bind('scroll', function() {
        if ($(this).scrollTop() < 120) {
            $('.scroll-top').hide();
            $('.see-more').show();
        }
    });

    $('.scroll-top').click(function() {
        $('.see-more').show();
        $('.scroll-top').hide();
    });

    $('.nav-tabs-head ul li').click(function(){
        $('.nav-tabs-head ul li').addClass('navigation-border');    
        $('.header-top .col-sm-7').css('border-bottom' , "solid 1px #d4d4d4");  
        $('.header-top .col-sm-5').css('border-bottom' , "solid 1px #d4d4d4");  
    });

    $('.nav-tabs .nav-tab').hide();
    $('.nav-tabs .nav-tab:eq(0)').click(function(){
        $(this).show();
    });
    $('.nav-tabs-head ul li').click(function() {
        var idx = $(this).index();
        if(!$(this).hasClass('current')){
            $('.nav-tabs-head ul li').removeClass('current');
            $(this).addClass('current');
            $('.nav-tabs .nav-tab').hide();
            var activeTab = $('.nav-tab').eq(idx).fadeToggle(); 
            $(".header-top").css('height' , '160px');   
        }else{
            $('.ico-closing-tabs').trigger("click");        
        }
        return false;
    });

    $('.ico-closing-tabs').click(function(){
        $(".header-top").css('height' , '50px');    
        $(".nav-tab").hide();  
        $('.header-top .col-sm-7').css('border-bottom' , "solid 0");
        $('.header-top .col-sm-5').css('border-bottom' , "solid 0");
        $('.nav-tabs-head ul li').removeClass('current , navigation-border');
    });

    $('input[type="checkbox"]').on('change', function() {
        var $span = $(this).next('label').find('span');
        if ($span.length && $(this).is(':checked')) {
            $span.addClass('checked');
        } else {
            $span.removeClass('checked');
        }
    }).trigger('change');

    var revapi;
    if($('.tp-banner').length) {
        revapi = jQuery('.tp-banner').revolution(
            {
                delay:100000000,
                startwidth:1170,
                startheight:540,
                hideThumbs:0,
                fullWidth:"off",
                forceFullWidth:"on",
                zindex: '1',
                fontfamily: 'OpenSans-Regular'     
        });
    }

    // if (jQuery('.event-slider li').length == 5) {
    //     $('.event-slider').css("left", "-114px");
    //     $('#carousel').css("padding-bottom", "20px");
    // };

    if (jQuery('.event-slider li').length < 5) {
        $('.event-slider').css("left", "250px");
        $('#carousel').css("padding-bottom", "20px");
        $('.pager , .next , .prev').addClass("display-none");
    };

    // if (jQuery('.offer-slider li').length == 5) {
    //     $('.offer-slider').css("left", "-114px");
    //     $('#offers-carousel').css("padding-bottom", "20px");
    // };

    if (jQuery('.offer-slider li').length < 5) {
        $('.offer-slider').css("left", "250px");
        $('#offers-carousel').css("padding-bottom", "20px");
        $('.offers-pager , .offers-next , .offers-prev').addClass("display-none");
    };
});

$('html').click(function(e) {
  if(!($(e.target).hasClass("profile-ico") || $(e.target).hasClass("image-dropdowns")) ){ 
    hideProfile();
  }
});


function hideProfile(){
    $('.image-dropdowns').fadeOut(200);
    $('.profile-ico').attr("is-open","no");
}

function showProfile(){
    $('.image-dropdowns').fadeIn(200);
    $('.profile-ico').attr("is-open","yes");
}

$('html').click(function(e) {
  if(!($(e.target).hasClass("notification-ico") || $(e.target).hasClass("section-notifications")) ){ 
    hideNotif();
  }
});

function hideNotif(){
    $('.section-notifications').fadeOut(200);
    $('.notification-ico').attr("is-open","no");
}

function showNotif(){
    $('.section-notifications').fadeIn(200);
    $('.notification-ico').attr("is-open","yes");
}

$('html').click(function(e) {
  if(!($(e.target).hasClass("btn-add-dropdown") || $(e.target).hasClass("section-add")) ){ 
    hide();
  }
});

function hide(){
    $('.section-add').fadeOut(200);
    $('.btn-add-dropdown').attr("is-open","no");
}

function show(){
    $('.section-add').fadeIn(200);
    $('.btn-add-dropdown').attr("is-open","yes");
}

$('html').click(function(e) {
  if(!($(e.target).hasClass("ico-messages") || $(e.target).hasClass("section-messages")) ){ 
    hideSection();
  }
});

function hideSection(){
    $('.section-messages').fadeOut(200);
    $('.ico-messages').attr("is-open","no");
}

function showSection(){
    $('.section-messages').fadeIn(200);
    $('.ico-messages').attr("is-open","yes");
}

/*$(function(){
    $('.next').click(function(){
        $(".prev").addClass('block-important');
        $(".caroufredsel_wrapper").addClass('push-left');
    });
});*/

$(".unfollow").tooltip({
    placement: 'top',
    trigger: 'hover',
});