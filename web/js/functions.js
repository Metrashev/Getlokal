$(function() {
	
    if($('#carousel ul').children().length < 4 ) {
        $('#carousel ul').carouFredSel({
            items: 1,
            prev: '#prev_slider',
            next: '#next_slider',
            scroll: {
                pauseOnHover: true,
                duration: 700,
            },
            auto: false,
            circular: true,
            infinite: false
        });
        $('#prev_slider').hide();
        $('#next_slider').hide();
    } else {
        $('#carousel ul').carouFredSel({
            items: 1,
    		prev: '#prev_slider',
    		next: '#next_slider',
    		scroll: {
                pauseOnHover: true,
                duration: 700,
            },
    		auto: {
              play: true,
              timeoutDuration: 5000
            },
            circular: true,
            infinite: false
    	});
    }

    if($('#offers-carousel ul').children().length < 4 ) {
        $('#offers-carousel ul').carouFredSel({
            items: 1,
            prev: '#offers-prev',
            next: '#offers-next',
            scroll: {
                pauseOnHover: true,
                duration: 700,
            },
            auto: false
        });
        $('#offers-prev').hide();
        $('#offers-next').hide();
    } else {
        $('#offers-carousel ul').carouFredSel({
            items: 1,
            prev: '#offers-prev',
            next: '#offers-next',
            scroll: {
                pauseOnHover: true,
                duration: 700,
            },
            auto: {
              play: true,
              timeoutDuration: 5000
            }
        });
    }

    // $(".testimonials").niceScroll({
    //     touchbehavior:false ,
    //     cursorcolor:"#dadada" ,
    //     cursorwidth: '10px' ,
    //     zindex: "50",
    // });

    //     $("html").niceScroll({
    //     touchbehavior:false ,
    //     cursorcolor:"#000" ,
    //     cursorwidth: '10px' ,
    //     zindex: "50"
    // });

    $('.profile-ico').click(function(){
        var isOpen = $(this).attr("is-open")
        if(isOpen == "yes"){
            hideProfile();
        }else{
            showProfile();
        }
    });
    
    $( ".default-input" ).on("focus",function() {
    	//$( ".default-input" ).parent().removeClass('active');
    	$( this ).parent().addClass('active');
    });
    $( ".default-input" ).on('blur',function() {
        if( !$(this).val() || $(this).val() == '' ) {
    	   $( this ).parent().removeClass('active');
        }
    });

    $('.notification-ico').click(function(){
        var isOpen = $(this).attr("is-open")
        if(isOpen == "yes"){
            hideNotif();
        }else{
            showNotif();
        }
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

    $('.nav-tabs-head ul li').click(function() {
        var idx = $(this).index();
        if(!$(this).hasClass('current')){
            $('.nav-tabs-head ul li').removeClass('current');
            $('.nav-tabs-head ul li').children('a').children('.fa').removeClass('fa-angle-up');
            $('.nav-tabs-head ul li').children('a').children('.fa').addClass('fa-angle-down');
            $(this).addClass('current');
            $(this).children('a').children('.fa').removeClass('fa-angle-down');
            $(this).children('a').children('.fa').addClass('fa-angle-up');
            $('.nav-tabs .nav-tab').hide();
            var activeTab = $('.nav-tab').eq(idx).stop(true,true).fadeToggle(); 
            controlHeaderTabsHeight($(this));
        }else{
            closeHeaderTabs();        
        }
        return false;
    });

    $('.ico-closing-tabs').click(function(){
        closeHeaderTabs();
    });

    $('input[type="checkbox"]').on('change', function() {
        var $span = $(this).next('label').find('span');
        if ($span.length && $(this).is(':checked')) {
            $span.addClass('checked');
        } else {
            $span.removeClass('checked');
        }
    }).trigger('change');


    $('.pp-tabs .pp-tab').hide();
    $('.pp-tabs .pp-tab:eq(0)').show();
        $('.pp-tabs .pp-tab:eq(0)').click(function(){
            $(this).show();
        });

    $('.pp-tabs-head ul li').click(function() {
        var idx = $(this).index();
        if(!$(this).hasClass('current')){
            $('.pp-tabs-head ul li').removeClass('current');
            $(this).addClass('current');
            $('.pp-tabs .pp-tab').hide();
            var activeTab = $('.pp-tab').eq(idx).fadeToggle(); 
        }else{

        }
        return false;
    });

    var revapi;
    if($('.tp-banner').length) {
        revapi = jQuery('.tp-banner').revolution(
            {
                delay:9000,
                startwidth:1170,
                startheight:540,
                hideThumbs:0,
                fullWidth:"off",
                forceFullWidth:"on",
                zindex: '1',
                fontfamily: 'OpenSans-Regular',
                shuffle:"on"     
        });
    }

    // if (jQuery('.event-slider li').length == 5) {
    //     $('.event-slider').css("left", "-114px");
    //     $('#carousel').css("padding-bottom", "20px");
    // };

    // if (jQuery('.event-slider li').length < 5) {
    //     $('.event-slider').css("left", "250px");
    //     $('#carousel').css("padding-bottom", "20px");
    //     $('.pager , .next_slider , .prev_slider').addClass("display-none");
    // };

    // if (jQuery('.offer-slider li').length == 5) {
    //     $('.offer-slider').css("left", "-114px");
    //     $('#offers-carousel').css("padding-bottom", "20px");
    // };

    // if (jQuery('.offer-slider li').length < 5) {
    //     $('.offer-slider').css("left", "250px");
    //     $('#offers-carousel').css("padding-bottom", "20px");
    //     $('.offers-pager , .offers-next , .offers-prev').addClass("display-none");
    // };


  $("#toggle-embed-btn").click(function(){
    $("#wrap-popover").toggle();
  });

  $("#toggle-embed-btn").click(function(){
    $("#toggle-caret").toggleClass('fa-angle-down fa-angle-up');;
  });
});



$('html').click(function(e) {
  if(!($(e.target).hasClass("profile-ico")) ){ 
    hideProfile();
  }
});


function controlHeaderTabsHeight(selector) {
    $('.nav-tab').each( function() {
        if(selector.attr('lang') == $(this).attr('lang')) {
            var el = $(this);
            var navTabHeight = parseInt(el.height());
            var regionsHeight = parseInt($('.regions').height());
            var bonusHeight = 10;
            var headerTopHeight = navTabHeight + regionsHeight + bonusHeight;
            $(".header-top").css('height' , headerTopHeight);   
        }
    });
} // Set height to header dependant on heights of tabs' content

function hideProfile(){
    $('.header_wrapper .image-dropdowns').fadeOut(200);
    $('.profile-ico').attr("is-open","no");
    $('.profile-ico').removeClass('fa-angle-up').addClass('fa-angle-down');
}

function showProfile(){
    $('.header_wrapper .image-dropdowns').fadeIn(200);
    $('.profile-ico').attr("is-open","yes");
    $('.profile-ico').removeClass('fa-angle-down').addClass('fa-angle-up');
}

$('html').click(function(e) {
  if(!($(e.target).hasClass("notification-ico")) ){ 
    hideNotif();
  }
});

function hideNotif(){
    $('.header_wrapper .section-notifications').fadeOut(200);
    $('.notification-ico').attr("is-open","no");
}

function showNotif(){
    $('.header_wrapper .section-notifications').fadeIn(200);
    $('.notification-ico').attr("is-open","yes");
}

$('html').click(function(e) {
  if(!($(e.target).hasClass("btn-add-dropdown"))){ 
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
  if(!($(e.target).hasClass("ico-messages")) ){ 
    hideSection();
  }
});

function hideSection(){
    $('.header_wrapper .section-messages').fadeOut(200);
    $('.ico-messages').attr("is-open","no");
}

function showSection(){
    $('.header_wrapper .section-messages').fadeIn(200);
    $('.ico-messages').attr("is-open","yes");
}

function closeHeaderTabs() {
    $(".header-top").css('height' , '50px');    
    $(".nav-tab").hide();

    $('.header-top .col-sm-7').css('border-bottom' , "solid 0");
    $('.header-top .col-sm-5').css('border-bottom' , "solid 0");
    $('.nav-tabs-head ul li').removeClass('current , navigation-border');
    $('.nav-tabs-head ul li').children('a').children('.fa').removeClass('fa-angle-up');
    $('.nav-tabs-head ul li').children('a').children('.fa').addClass('fa-angle-down');
}

function ajaxPaging(page,target,company_id,type){
	url = "/bg/d/company/companyRalatedObjects?type="+type+"&company="+company_id+"&page="+page;

	$(target).html('<div id="loader_container_events">'+LoaderHTML+'</div>');
	$.ajax({
		  type: "POST",
		  url: url,
		  success: function( data ) {
              $(target).html(data);
          }
	});
}

function ajaxPagingUrl(page,target,url){
	$(target).html('<div id="loader_container_events">'+LoaderHTML+'</div>');
	$.ajax({
		  type: "POST",
		  url: url,
		  success: function( data ) {
              $(target).html(data);
              setFileUplRules();
          }
	});
}

function loginFormReviews(){
	$('#login_form_ppp').hide();
	$('.login_form_wrap').toggle();
	$('.reservation_content').html('');
}
function loginForm(){
	$('#login_form_ppp').toggle('fast');
	$('.login_form_wrap').hide();
	$('.reservation_content').html('');
}
function reservationForm(url){
	$('#login_form_ppp').hide();
	$('.login_form_wrap').hide();	
	
	$('.reservation_content').html('');
	$('.add_photo_content').html('');
	$('#add_list_wrap').html('');
	
	$.ajax({
	    type: "GET",
	    url: url,
	    beforeSend: function(data) { 
	    	$('.reservation_content').html(LoaderHTML);
	    }, 
	    success: function(data) {
	        if ($.trim(data)) {
	        	$('.reservation_content').html(data);
	        }
	    }
	  });
	  return false;
}

$(document).on('submit','#search-form',function(event){
	if($('#search_header_where').val() == ''){
        $('#search_header_where').val(searchHeaderWherePlaceholder);
    }
	where = $('#search_header_where').val();
	ac_where = $('#ac_where').val();
	ac_where_ads = $('#ac_where_ids').val();
	where_p = where.trim().toLowerCase();
	if(where != ac_where && where_p != city && where_p != city_en){
		if(where.search(",") < 0){
	    	where += ", "+country;
	    }
	    url = 'http://maps.googleapis.com/maps/api/geocode/json?address='+where+'&sensor=false&language=en';	
	    //console.log(url);
	    $.ajax({
		    type: "GET",
		    async: false,
		    url: url,
		    beforeSend: function(data) { 
		    	//$('#google_location').val('');
		    	$('#ac_where').val('');
		    	$('#ac_where_ids').val('');
		    }, 
		    success: function(data) {		    	
		    	//console.log(data);
		        for (i = 0;i < data.results.length; i++) {
		        	if(data.results[i].types[0] == 'locality' || 1){
		        		var city = '';
		        		var county = '';
		        		var country = '';
		        		var address_components = data.results[i].address_components;
		        		for(j = 0; j < address_components.length; j++){
		        			if((address_components[j].types[0] == 'locality' || address_components[j].types[0] == 'administrative_area_level_2') && city == ''){
		        				var city = address_components[j].long_name;
	    					}
		        			if(address_components[j].types[0] == 'administrative_area_level_1' && county == ''){
		        				var county = address_components[j].long_name;
	    					}
		        			if(address_components[j].types[0] == 'country' && country == ''){
		        				var country = address_components[j].long_name;
	    					}
		        		}
		        		if(country != ''){
		        			// glr - Google Location Result
		        			if(city == ''){
		        				city = county;
		        			}
		        			$('#glr').val(city+"|"+county+"|"+country);
		        			break;
		        		}
		        	}
		        }
		    }
		});		
	}  
	//event.preventDefault();
    //return false;
});


/*$(function(){
    $('.next').click(function(){
        $(".prev").addClass('block-important');
        $(".caroufredsel_wrapper").addClass('push-left');
    });
});*/
$(function() {
	$('.register_btn_mini').click(function() {
	    $('.sign_in_form_mini').hide();
	    $('.register_form_mini').show();	    
	});
	
	$('.login_btn_mini').click(function() {
		$('.register_form_mini').hide();
	    $('.sign_in_form_mini').show();
	});
	
	$('.close_register').click(function() {
		$('.register_form_mini').hide();
	    $('.sign_in_form_mini').show();
	});
	
	$('.close_signin').click(function() {
		$('.register_form_mini').hide();
	    $('.sign_in_form_mini').show();
	    $('.signin_register').parent().toggle('normal');
	});
});