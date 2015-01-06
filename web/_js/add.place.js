$(document).ready(function() {
    if($(".addCompany .error_list").length>0){
        $('#addCompanyForm section').eq(0).css("padding-top","25px");
        $(".addCompany .error_message").css("display","block");
        setTimeout(function(){
            $(".addCompany .error_message").fadeOut();
            $('#addCompanyForm section').eq(0).css("padding-top","0px");
        }, 12000);

    }
    $("#show_address").click(function(){
        $('#expandable').slideToggle("fast");
        $(this).toggleClass("up");
    });


    $("#owners-details").click(function(){
        $('.owners_company_info').slideToggle("fast");
        $(this).toggleClass("up");
    });

    $("#btn-no-scroll").click(function() {
        if($(".error_label").length > 0){
            $('html, body').animate({
                scrollTop: $(".error_label").offset().top
            }, 200);
        }
        
        if($(".page_wrap").length > 0){
            $('html, body').animate({
               scrollTop: $(".page_wrap").offset().top
            }, 200);    
        }
    });
    
    function resetForm($form) {
        $form.find('#company_bg_title, #company_ro_title, #company_mk_title, #company_sr_title, #company_fi_title, #company_hu_title, #company_classification, #company_company_location_street, #company_company_location_street_number').val('');
        $form.find('#company_company_location_neighbourhood, #company_company_location_building_no, #company_company_location_address_info').val('');
        $form.find('#company_phone, #company_website_url, #company_email, #company_sector_id, #company_classification_id').val('');
        $form.find('#company_page_admin_username, #company_page_admin_password, #company_page_admin_user_profile_phone_number, #company_registration_no').val('');
        $form.find('#company_facebook_url, #company_googleplus_url, #company_twitter_url, #company_foursquare_url').val('');
        
        $form.find('#company_company_location_street_type_id').val('6');
        $form.find('#company_company_location_location_type').val('2');
        
        $form.find('#company_page_admin_user_profile_gender').val('selected');
        $form.find('#company_page_admin_position').val('selected');

        $form.find('.ez-checkbox').removeClass('ez-checked');
    }

    $("#add-more").click(function(){
        $('#success-msg').removeClass('opened');
        $('#success-msg2').removeClass('opened');
        $('#success-msg').css('top', '-450px');
        $('#success-msg2').css('top', '-500px');
        resetForm($('#addCompanyForm'));
//        document.getElementById("addCompanyForm").reset();
        $('.added_items').html('');
        $('.error_list, .error_label').remove();
        $('.form_box, .add_field').removeClass('error');
        $('.page_wrap').removeClass('offset');
//        $('.captcha_out a img').trigger('click');
        $('.form-wrap').slideDown();
    });

    $(".contact-form a.send-mail").click(function(){
        
        var element = $(this).parent().parent().find('.ajax');

        $.ajax({
            type: 'GET',
            url: 'addCompanySendMail',
            // data: $(this).serialize(),
            beforeSend: function(data){
                document.getElementById("loading-overlay").style.display="block";
            },
            success: function(data){
                document.getElementById("loading-overlay").style.display="none";
                $(element).html(data);
            }
        });

        return false;
    });

    /*=-=-Phones add and validation-=-=*/
    /*
     $("a#add_phone").click(function(){
            var phoneLimit = ($("#list_of_phones").children().length);

            var z = $("#phone_number").val();

            if($("#list_of_phones").children().length<3  && z.match(/^(\d+)$/) &&  z.length>2 &&  z.length<16 ){
                $("#list_of_phones.added_items").css("display","inline-block");
                $("#list_of_phones").append(
                '<div class="added_item">'+
                    '<p>'+$("#phone_number").val()+'</p>'+
                    '<a>×</a>'+
                    '<input type="hidden" name="company[ph][]" value="'+$("#phone_number").val()+'" >   </div>'
            );
                $("#phone_number").val('');
            }
            if(!z.match(/^(\d+)$/) || z.length<3 || z.length>15 )
            {
                $(".invalid_error.phone").css("display","block");
                 $('form.right div.part.one div.two_inputs div.form_box.add_field a.tip.phone_tip').css('top' ,'56px;')

                // $("input[type=text]#phone_number").css("border","1px solid #ff0000;");
                $("input[type=text]#phone_number").animate({
                    borderLeftColor: "#ff0000",
                    borderTopColor: "#ff0000",
                    borderRightColor: "#ff0000",
                    borderBottomColor: "#ff0000"
                }, 2000);
                $("input[type=text]#phone_number").animate({
                    borderLeftColor: "#ccc",
                    borderTopColor: "#ccc",
                    borderRightColor: "#ccc",
                    borderBottomColor: "#ccc"
                }, 2000);
                setTimeout(function(){
                    $(".invalid_error.phone").fadeOut();
            }, 2000);

            }

            if(phoneLimit==3){
                $(".phone_limit").css("display","block");
                setTimeout(function(){
                    $(".phone_limit").fadeOut();}, 2000);
            }

            $(".added_items .added_item a").live("click", function(){
            $(this).parents(".added_item").remove();
            if($("#list_of_phones").children().length==0){
                setTimeout(function(){
                    $("#list_of_phones").fadeOut();}, 1200);
            }
        });     
        });*/
    
    /*Removal of added classification*/
    $(".added_item a").live("click", function(){
        $(this).parents(".added_item").remove();  
        if($("#list_of_classifications").children().length==0){
            setTimeout(function(){
                $("#list_of_classifications").fadeOut();
            }, 1200);
        }
    });
    
    /*=-=-Owner's form validation=-=-*/
  /*    $('.owners_company_info input').blur(function(){
         if($(this).val()===''){
             $(this).addClass('ignore');
             return false;
         }else{
             $(this).removeClass('ignore'); 
         }
     });*/

    $.validator.addMethod(
          "regex",
          function(value, element, regexp) {
              var check = false;
              var re = new RegExp(regexp);
              return this.optional(element) || re.test(value);
          },""
    );

    $("#addCompanyForm").validate({
        invalidHandler: function(form, validator) {
            var errors = validator.numberOfInvalids();

            if (errors) {
                $(".addCompany .error_message").css("display","block");
                setTimeout(function(){
                    $(".addCompany .error_message").fadeOut();
                    $('#addCompanyForm section').eq(0).css("padding-top","0px");
                }, 12000);
            } else {
                $(".error_message").hide();
            }
        },
        errorClass: "error_label",
        focusCleanup: false,
        rules: {
            //=-=-First name=-=-//
            'company[page_admin][user_profile][sf_guard_user][first_name]': {
                required: {
                    depends: function(element) {
                        return (
                            ($('#company_page_admin_user_profile_sf_guard_user_last_name').length > 0 && $('#company_page_admin_user_profile_sf_guard_user_last_name').val() !== '') ||   
                            ($('#company_page_admin_username').length > 0 && $('#company_page_admin_username').val() !== '') || 
                            ($('#company_page_admin_password').length > 0 && $('#company_page_admin_password').val() !== '') ||
                            ($('#company_page_admin_user_profile_phone_number').length > 0 &&  $('#company_page_admin_user_profile_phone_number').val() !== '') ||
                            ($('#company_registration_no').length > 0 && $('#company_registration_no').val() !== '') ||
                            ($('#company_page_admin_user_profile_gender').length > 0 && $('#company_page_admin_user_profile_gender').val() !== '') ||
                            ($('#company_page_admin_position').length > 0  && $('#company_page_admin_position').val() !== '') 
                            );
                    }
                }
            },
            //=-=-Last name=-=-//
            'company[page_admin][user_profile][sf_guard_user][last_name]': {
                required: {
                    depends: function(element) {
                        return (
                            ($('#company_page_admin_user_profile_sf_guard_user_first_name').length > 0 && $('#company_page_admin_user_profile_sf_guard_user_first_name').val() !== '') ||
                            ($('#company_page_admin_username').length > 0 && $('#company_page_admin_username').val() !== '') || 
                            ($('#company_page_admin_password').length > 0 && $('#company_page_admin_password').val() !== '') ||
                            ($('#company_page_admin_user_profile_phone_number').length > 0 &&  $('#company_page_admin_user_profile_phone_number').val() !== '') ||
                            ($('#company_registration_no').length > 0 && $('#company_registration_no').val() !== '') ||
                            ($('#company_page_admin_user_profile_gender').length > 0 && $('#company_page_admin_user_profile_gender').val() !== '') ||
                            ($('#company_page_admin_position').length > 0  && $('#company_page_admin_position').val() !== '') 
                            );
                    }
                }
            },
             //=-=-Street location=-=-//
            'company[company_location][street]': {
                required: true
            },
             //=-=-Company title=-=-//
            'company[bg][title]': {
                required: true
            },
            'company[ro][title]': "required",
            'company[mk][title]': "required",
            'company[sr][title]': "required",
            'company[fi][title]': "required",
            'company[hu][title]': "required",
            'company[en][title]': {
                regex: /^[a-zA-Z0-9?><;,{}[\]\-_+=!@#$%\^&*|'\(\)\.\\\/:\"\s]*$/,
                titleEnCheck: true
            },
             //=-=-Classification=-=-//
             'company[classification]': {
                required: {
                    depends: function(element) {
                        return (
                            $('.added_item input[type=hidden]').val() === '' ||   
                            $('.added_item input[type=hidden]').length ===0 );
                    }
                }
            },
              //=-=-Captcha=-=-//
            //  'company[captcha]': {
            //     required: true
            // },
            //=-=-Username name=-=-//
            // 'company[page_admin][username]': {
            //     required: {
            //         depends: function(element) {
            //             return (
            //                 ($('#company_page_admin_user_profile_sf_guard_user_first_name').length > 0 && $('#company_page_admin_user_profile_sf_guard_user_first_name').val() !== '') ||
            //                 ($('#company_page_admin_user_profile_sf_guard_user_last_name').length > 0 && $('#company_page_admin_user_profile_sf_guard_user_last_name').val() !== '') ||   
            //                 ($('#company_page_admin_password').length > 0 && $('#company_page_admin_password').val() !== '') ||
            //                 ($('#company_page_admin_user_profile_phone_number').length > 0 &&  $('#company_page_admin_user_profile_phone_number').val() !== '') ||
            //                 ($('#company_registration_no').length > 0 && $('#company_registration_no').val() !== '') ||
            //                 ($('#company_page_admin_user_profile_gender').length > 0 && $('#company_page_admin_user_profile_gender').val() !== '') ||
            //                 ($('#company_page_admin_position').length > 0  && $('#company_page_admin_position').val() !== '') 
            //                 );
            //         }
            //     },
            //     minlength: 3
                
            // },
            //=-=-Password=-=-//
            'company[page_admin][password]': {
                required: {
                    depends: function(element) {
                        return (
                            ($('#company_page_admin_user_profile_sf_guard_user_first_name').length > 0 && $('#company_page_admin_user_profile_sf_guard_user_first_name').val() !== '') ||
                            ($('#company_page_admin_user_profile_sf_guard_user_last_name').length > 0 && $('#company_page_admin_user_profile_sf_guard_user_last_name').val() !== '') ||   
                            ($('#company_page_admin_username').length > 0 && $('#company_page_admin_username').val() !== '') ||    
                            ($('#company_page_admin_user_profile_phone_number').length > 0 &&  $('#company_page_admin_user_profile_phone_number').val() !== '') ||
                            ($('#company_registration_no').length > 0 && $('#company_registration_no').val() !== '') ||
                            ($('#company_page_admin_user_profile_gender').length > 0 && $('#company_page_admin_user_profile_gender').val() !== '') ||
                            ($('#company_page_admin_position').length > 0  && $('#company_page_admin_position').val() !== '') 
                            );
                    }
                },
                minlength: 6
            }, 
            //=-=-Phone=-=-//
            'company[page_admin][user_profile][phone_number]': {
                required: {
                    depends: function(element) {
                        return (
                            ($('#company_page_admin_user_profile_sf_guard_user_first_name').length > 0 && $('#company_page_admin_user_profile_sf_guard_user_first_name').val() !== '') ||
                            ($('#company_page_admin_user_profile_sf_guard_user_last_name').length > 0 && $('#company_page_admin_user_profile_sf_guard_user_last_name').val() !== '') ||   
                            ($('#company_page_admin_username').length > 0 && $('#company_page_admin_username').val() !== '') ||    
                            ($('#company_page_admin_password').length > 0 && $('#company_page_admin_password').val() !== '') ||
                            ($('#company_registration_no').length > 0 && $('#company_registration_no').val() !== '') ||
                            ($('#company_page_admin_user_profile_gender').length > 0 && $('#company_page_admin_user_profile_gender').val() !== '') ||
                            ($('#company_page_admin_position').length > 0  && $('#company_page_admin_position').val() !== '') 
                            );
                    }
                },
            },
            //=-=-Bulstat=-=-//
            'company[registration_no]': {
                required: {
                    depends: function(element) {
                        return (
                            ($('#company_page_admin_user_profile_sf_guard_user_first_name').length > 0 && $('#company_page_admin_user_profile_sf_guard_user_first_name').val() !== '') ||
                            ($('#company_page_admin_user_profile_sf_guard_user_last_name').length > 0 && $('#company_page_admin_user_profile_sf_guard_user_last_name').val() !== '') ||   
                            ($('#company_page_admin_username').length > 0 && $('#company_page_admin_username').val() !== '') ||    
                            ($('#company_page_admin_password').length > 0 && $('#company_page_admin_password').val() !== '') ||
                            ($('#company_page_admin_user_profile_phone_number').length > 0 &&  $('#company_page_admin_user_profile_phone_number').val() !== '') ||
                            ($('#company_page_admin_user_profile_gender').length > 0 && $('#company_page_admin_user_profile_gender').val() !== '') ||
                            ($('#company_page_admin_position').length > 0  && $('#company_page_admin_position').val() !== '') 
                            );
                    }
                }
            },
            //=-=-Gender=-=-//
            'company[page_admin][user_profile][gender]': {
                required: {
                    depends: function(element) {
                        return (
                            ($('#company_page_admin_user_profile_sf_guard_user_first_name').length > 0 && $('#company_page_admin_user_profile_sf_guard_user_first_name').val() !== '') ||
                            ($('#company_page_admin_user_profile_sf_guard_user_last_name').length > 0 && $('#company_page_admin_user_profile_sf_guard_user_last_name').val() !== '') ||   
                            ($('#company_page_admin_username').length > 0 && $('#company_page_admin_username').val() !== '') ||    
                            ($('#company_page_admin_password').length > 0 && $('#company_page_admin_password').val() !== '') ||
                            ($('#company_page_admin_user_profile_phone_number').length > 0 &&  $('#company_page_admin_user_profile_phone_number').val() !== '') ||
                            ($('#company_registration_no').length > 0 && $('#company_registration_no').val() !== '') ||
                            ($('#company_page_admin_position').length > 0  && $('#company_page_admin_position').val() !== '') 
                            );
                    }
                }
            },
            //=-=-Position=-=-//
            'company[page_admin][position]': {
                required: {
                    depends: function(element) {
                        return (
                            ($('#company_page_admin_user_profile_sf_guard_user_first_name').length > 0 && $('#company_page_admin_user_profile_sf_guard_user_first_name').val() !== '') ||
                            ($('#company_page_admin_user_profile_sf_guard_user_last_name').length > 0 && $('#company_page_admin_user_profile_sf_guard_user_last_name').val() !== '') ||   
                            ($('#company_page_admin_username').length > 0 && $('#company_page_admin_username').val() !== '') ||    
                            ($('#company_page_admin_password').length > 0 && $('#company_page_admin_password').val() !== '') ||
                            ($('#company_page_admin_user_profile_phone_number').length > 0 &&  $('#company_page_admin_user_profile_phone_number').val() !== '') ||
                            ($('#company_registration_no').length > 0 && $('#company_registration_no').val() !== '') ||
                            ($('#company_page_admin_user_profile_gender').length > 0 && $('#company_page_admin_user_profile_gender').val() !== '')
                            );
                    }
                }
            },
            //=-=-Accept=-=-//
            'company[page_admin][accept]': {
                required: {
                    depends: function(element) {
                        return (
                            ($('#company_page_admin_user_profile_sf_guard_user_first_name').length > 0 && $('#company_page_admin_user_profile_sf_guard_user_first_name').val() !== '') ||
                            ($('#company_page_admin_user_profile_sf_guard_user_last_name').length > 0 && $('#company_page_admin_user_profile_sf_guard_user_last_name').val() !== '') ||   
                            ($('#company_page_admin_username').length > 0 && $('#company_page_admin_username').val() !== '') ||    
                            ($('#company_page_admin_password').length > 0 && $('#company_page_admin_password').val() !== '') ||
                            ($('#company_page_admin_user_profile_phone_number').length > 0 &&  $('#company_page_admin_user_profile_phone_number').val() !== '') ||
                            ($('#company_registration_no').length > 0 && $('#company_registration_no').val() !== '') ||
                            ($('#company_page_admin_user_profile_gender').length > 0 && $('#company_page_admin_user_profile_gender').val() !== '')
                            );
                    }
                }
            },
            //=-=-Facebook url=-=-//
            'company[facebook_url]': {
                regex: /^(http\:\/\/|https\:\/\/)?(?:www\.)?facebook\.com\/(?:(?:\w\.)*#!\/)?(?:pages\/)?(?:[\w\-\.]*\/)*([\w\-\.]*)/
            },
            //=-=-Google+ url=-=-//
            'company[googleplus_url]': {
                regex: /^((http:\/\/(plus\.google\.com\/.*|www\.google\.com\/profiles\/.*|google\.com\/profiles\/.*))|(https:\/\/(plus\.google\.com\/.*)))/i
                // /plus\.google\.com\/.?\/?.?\/?([0-9]*)/i
            },
            //=-=-Twitter url=-=-//
            'company[twitter_url]': {
                regex: /^(http\:\/\/|https\:\/\/)?(?:www\.)?(twitter.com\/)?(\@[a-zA-Z0-9_]{1,15}$)/
            },
            //=-=-Foursquare url=-=-//
            'company[foursquare_url]': {
                regex: /^((http:\/\/(foursquare\.com\/.*|www\.foursquare\.com\/.*|4sq\.com\/.*))|(https:\/\/(foursquare\.com\/.*|www\.foursquare\.com\/.*)))/i
            },
        },
        messages: {
            'company[page_admin][user_profile][sf_guard_user][first_name]' : $('#mandatory').text(),
            'company[page_admin][user_profile][sf_guard_user][last_name]': $('#mandatory').text(),
            'company[page_admin][username]':{
                required:$('#mandatory').text(),                                   
                minlength: $('#min-3').text()
            },
            'company[page_admin][password]':{
                required:$('#mandatory').text(),                                   
                minlength: $('#min-6').text() 
            },
            'company[page_admin][user_profile][phone_number]':{
                required:$('#mandatory').text()
            },
                'company[registration_no]':$('#mandatory').text(),
                'company[page_admin][position]':$('#mandatory').text(),
                'company[page_admin][accept]':$('#mandatory').text(),
                'company[page_admin][user_profile][gender]' : $('#mandatory').text(),
                'company[page_admin][position]' : $('#mandatory').text(),
                'company[bg][title]':$('#mandatory').text(),
                'company[ro][title]':$('#mandatory').text(),
                'company[mk][title]':$('#mandatory').text(),
                'company[sr][title]':$('#mandatory').text(),
                'company[fi][title]':$('#mandatory').text(),
                'company[hu][title]':$('#mandatory').text(),
                'company[en][title]': {
                    regex: $('#title-en-error').text(),
                    titleEnCheck: $('#mandatory').text()
                },
                'company[classification]':$('#mandatory').text(),
                'company[company_location][street]':$('#mandatory').text(),
                'company[facebook_url]': {
                    regex: $('#facebook-error').text(),
                },
                'company[googleplus_url]': {
                    regex: $('#googleplus-error').text(),
                },
                'company[twitter_url]': {
                    regex: $('#twitter-error').text(),
                },
                'company[foursquare_url]': {
                    regex: $('#foursquare-error').text(),
                }
//                'company[captcha]':$('#mandatory').text()
            
        },
        submitHandler: function() {
            
            $.ajax({
                url: $("#addCompanyForm").attr('action'),
                data: $("#addCompanyForm").serialize(),
                type:'POST',
                beforeSend: function(data) {
                    document.getElementById("loading-overlay").style.display="block";
                },
                success: function( data ) {
                    document.getElementById("loading-overlay").style.display="none";
                    try {
                        var json = jQuery.parseJSON(data);
                        $('.form-wrap').hide();
                        window.scrollTo(0,0);
                        $('#added_company, #to-profile').attr("href", json.url);
                        $('#added_company').text(json.title);
                        $('#company_title').text(json.title);
                        $('#success-msg').addClass('opened');
                        $('#success-msg2').addClass('opened');
                        $('.page_wrap').addClass('offset');
                        $('#success-msg').css('top', 0);
                        $('#success-msg2').css('top', 0);
                       
                    } catch(error) {
                        $('.page_wrap').addClass('centered');
                        $('.content_wrap').addClass('appended')
                                          .html(data);
                         $('input').each(function(index) {
                            if (!($(this).hasClass('star')))
                            {
                                $(this).ezMark();
                            }
                        });                  
                      //  if(!window.scriptHasRun) { 
                            window.scriptHasRun = true; 
                            jQuery.getScript("/js/add.place.js")
                            .done(function() {
                            })
                            .fail(function() {
                            });
                       // }
                    } 
                    if($(".owners_company_info .error_list").length > 0){
                        $(".owners_company_info").slideDown();
                    }
                },
                error: function( data ) {
                    alert('error');
                }  
            });
            return false;
        }
    });

    /*Classification autocomplete*/
    $('#company_classification').autocomplete({
        source: $('#class-url').text(),
        minLength: 2,
        position: {
            of: $('#company_classification').parent()
        },
        select: function( event, ui ) {
            $('#company_classification_id').val(''+ui.item.id);
            $('#company_sector_id').val(''+ui.item.sector_id);
        },
        open: function (event, ui) {
            var menu = $(this).data("uiAutocomplete").menu
            , i = 0
            , $items = $('li', menu.element)
            , item
            , text
            , startsWith = new RegExp("^" + this.value, "i");
            for (; i < $items.length && !item; i++) {
                text = $items.eq(i).text();
                if (startsWith.test(text)) {
                    item = $items.eq(i);
                }
            }
            
            if (item) {
                menu.focus(null, item);
            }
        }
    }).autocomplete( "widget" ).addClass( "classification-autocomplete" );
    var geocoder = new google.maps.Geocoder();     
       
    /*=-=-Add classifications=-=-*/        
    $("a#add_classification").click(function(){
        var classificationLimit=($("#list_of_classifications").children().length);
        if($("#list_of_classifications").children().length< 5 && $("#company_classification_id").val()){
            $("#list_of_classifications.added_items").css("display","inline-block");
            $("#list_of_classifications").append(
                '<div class="added_item"> '+
                '<p>'+$("#company_classification").val()+'</p>'+
                '<a>×</a>'+
                '<input type="hidden" name="company[classification_list_id][]" id="classification_list_id_'+$("#company_classification_id").val()+'" value="'+$("#company_classification_id").val()+'">'+
                '<input type="hidden" name="company[classification_list_title][]" id="classification_list_title_'+$("#company_classification_id").val()+'" value="'+$("#company_classification").val()+'">'+
                '<input type="hidden" name="company[sector_list_id][]" id="sector_list_id_'+$("#company_sector_id").val()+'" value="'+$("#company_sector_id").val()+'">'+
                '</div>'
                );

            $("#company_classification").val('');
            $("#company_classification_id").val('');
            $("#company_sector_id").val('');
        }
        if(classificationLimit== 5){
            $(".limit_error.classification_limit").css("display","block");
            $(".form.right div.part.one div.two_inputs div.form_box.add_field a.tip.classification_tip").css("top", "54px");
            setTimeout(function(){
                $(".limit_error.classification_limit").fadeOut();
            }, 2000);
        }

    });
    /*Map navigation*/
    $(".nav_arrow").click(function() {
        var height = $("#map_canvas").height();
      //  var getCen = map.getCenter();
        if(height<350)
        {
            $("#map_canvas").animate({
                height:"450px"
            });
            $(".nav_arrow").toggle();
        }
        else{
            $("#map_canvas").animate({
                height:"250px"
            });
            $(".nav_arrow").toggle();

        }
        return false;
    });
});