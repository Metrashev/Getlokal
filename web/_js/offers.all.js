/*Create/Edit Offer (_form) JS*/
function offerFormJS() {
/*CropTool*/
    var currentImage = $('.current_offer_image');
    var imageCropWrapper = $('.image_crop_wrapper');
    var clearImageBtn = $('#clearImage');
    var currentImgLabel = $('.current_img_label');
    var invalidFileError =  $('ul.error_list.image-invalid');
    var small = $('#smallPreview');
    var fileInput = $('#company_offer_file');
    var noImageSelected = $('.error_list.image_no_selection')
    // prepare instant preview
    fileInput.live('change', function(){
        $('#x1').val('');
        $('#y1').val('');
        $('#x2').val('');
        $('#y2').val('');
        $('#width').val('');
        $('#height').val('');
        $('ul.error_list.no-image').hide();
        invalidFileError.hide();
        fileInput.removeClass('error');
        $(this).parent().removeClass('error');
        $(this).next('ul.error_list').hide();
        //            imageOverlay.show();
        var fileExtension = fileInput.val().split('.').pop();
        if((fileExtension ==='png') || (fileExtension ==='jpg') || (fileExtension ==='gif') || (fileExtension ==='jpeg') || (fileExtension ==='PNG') || (fileExtension ==='JPG') || (fileExtension ==='GIF')|| (fileExtension ==='JPEG')){
            currentImage.hide();
            // currentImgLabel.hide();
            imageCropWrapper.show();
            fileInput.css('float','left');
            clearImageBtn.show();
        //           $('.image_overlay').show();
        }else{
            imageCropWrapper.hide();
            //  currentImgLabel.show();
            currentImage.show();
            clearImageBtn.hide();
            fileInput.css('float','none');
            if(fileInput.val()!=''){
                $(this).addClass('error');
                invalidFileError.show();
              
            }
             
        }

        $('.jcrop-tracker').removeAttr('style');
        $('.jcrop-tracker').remove();
        $('.jcrop-holder').hide();
        $('#bigPreview').removeAttr('src');
        $('#bigPreview').remove();
        small.fadeOut();

        // prepare HTML5 FileReader
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("company_offer_file").files[0]);

        oFReader.onload = function (oFREvent) {

            var img = $('<img />').attr({
                'id': 'bigPreview', 
                'src': oFREvent.target.result
                }).appendTo($('#imgDiv'));
            // big.attr('src', oFREvent.target.result).show();
             
            small.attr('src', oFREvent.target.result).fadeIn();
           
      
            var boundx, boundy,
           
            $preview = $('#preview-pane'),
            $pcnt = $('#preview-pane .preview-container'),
            $pimg = $('#preview-pane .preview-container img'),
           
            xsize = $pcnt.width(),
            ysize = $pcnt.height();
            $('#bigPreview').Jcrop({
                onChange: updatePreview,
                onSelect: updatePreview,
                bgOpacity:   .4,
                keySupport: false,         
                aspectRatio: 291 / 257, 
                boxWidth: 550 
              
            },function(){
                // Use the API to get the real image size
                var bounds = this.getBounds();
                boundx = bounds[0];
                boundy = bounds[1];
              
                // Store the API in the jcrop_api variable
                jcrop_api = this;
                //  jcrop_api.setSelect([ 100,100,200,200 ]);
                //Move the preview into the jcrop container for css positioning
                $preview.appendTo(jcrop_api.ui.holder);
               
                var cropWidth = boundx;
                var cropHeight = boundy;
                var marginLeft = (boundx - cropWidth)/2;
                var marginTop =  (boundy - cropHeight)/2;
                jcrop_api.animateTo([marginLeft, 0, cropWidth,cropHeight]);
            });
 
            function updatePreview(c)
            {  //imageOverlay.hide();
                small.show();
                noImageSelected.hide();
         
                if (parseInt(c.w) > 0)
                {
                    var rx = xsize / c.w;
                    var ry = ysize / c.h;

                    $pimg.css({
                        width: Math.round(rx * boundx) + 'px',
                        height: Math.round(ry * boundy) + 'px',
                        marginLeft: '-' + Math.round(rx * c.x) + 'px',
                        marginTop: '-' + Math.round(ry * c.y) + 'px'
                    });
                    $('#x1').val(c.x);
                    $('#y1').val(c.y);
                    $('#x2').val(c.x2);
                    $('#y2').val(c.y2);
                    $('#width').val(c.w);
                    $('#height').val(c.h);
                    $('.jcrop-holder').removeClass('error');
                    $('.error_list.image').remove();
                // $('#company_offer_file').removeClass('error');
                //$('#coords').html(c.w + ' x ' + c.h);
                };
            };

        };
    });
    $('.input_submit').live('click', function(){
        var fileExtension = fileInput.val().split('.').pop();
        if((fileInput.val() === '') && currentImage.length ===0){
            fileInput.css('float','none');
            $('ul.error_list.no-image').show();
            fileInput.addClass('error');
            $('html, body').animate({
                scrollTop: $("#company_offer_max_vouchers").offset().top
            }, 1000);
            return false; 
        }else if(currentImage.length === 1 && fileInput.val() === ''){
            return true;    
        }else if((fileExtension ==='png') || (fileExtension ==='jpg') || (fileExtension ==='gif')|| (fileExtension ==='jpeg')|| (fileExtension ==='PNG') || (fileExtension ==='JPG') || (fileExtension ==='GIF')|| (fileExtension ==='JPEG')){
            return true;
        }
        else if(invalidFileError.is(":visible") && fileInput.val() !==''){
            $('html, body').animate({
                scrollTop: $("#company_offer_max_vouchers").offset().top
            }, 1000);
            return false;
        }   
        else if((fileExtension !=='png') || (fileExtension !=='jpg') || (fileExtension !=='gif') || (fileExtension !=='jpeg')|| (fileExtension !=='PNG') || (fileExtension !=='JPG') || (fileExtension !=='GIF') || (fileExtension !=='JPEG'))
        {
            invalidFileError.show();
            $('html, body').animate({
                scrollTop: $("#company_offer_max_vouchers").offset().top
            }, 1000);
            return false;
        }
    });
    clearImageBtn.click(function(e){
        $('#x1').val('');
        $('#y1').val('');
        $('#x2').val('');
        $('#y2').val('');
        $('#width').val('');
        $('#height').val('');
        fileInput.val('');
        imageCropWrapper.hide();
        currentImage.show();
        //  currentImgLabel.show();
        /*  imageOverlay.show();
     small.hide();
     noImageSelected.show();*/
        $(this).hide();
        return false;
    });
 /*end CropTool*/   
 /*Benefit selection*/
       if($('#company_offer_benefit_choice_1').is(':checked')){
        $('.option_fields_wrap .option_2').removeClass('selected');   
        $('.option_fields_wrap .option_1').addClass('selected');
        $('.option_fields_wrap .option_1 input').removeAttr("disabled");
        $('.option_fields_wrap .option_2 input').attr('disabled', 'disabled');
        $('.option_fields_wrap .option_3 input').attr('disabled', 'disabled'); 
        $('.option_fields_wrap .option_3').removeClass('selected');
        $('.offer_benefits_wrap .option_fields_wrap .option_2 .form_box span.pink').css({
            "visibility":"hidden"
        });
        $('.offer_benefits_wrap .option_fields_wrap .option_3 .form_box span.pink').css({
            "visibility":"hidden"
        });
        $('.offer_benefits_wrap .option_fields_wrap .option_1 .form_box span.pink').css({
            "visibility":"visible"
        });
    } else if($('#company_offer_benefit_choice_2').is(':checked')) {
        $('.option_fields_wrap .option_1').removeClass('selected');
        $('.option_fields_wrap .option_2').addClass('selected');
        $('.option_fields_wrap .option_2 input').removeAttr("disabled");
        $('.option_fields_wrap .option_3').removeClass('selected');
        $('.option_fields_wrap .option_1 input').attr('disabled', 'disabled');
        $('.option_fields_wrap .option_3 input').attr('disabled', 'disabled');
        $('.offer_benefits_wrap .option_fields_wrap .option_1 .form_box span.pink').css({
            "visibility":"hidden"
        });
        $('.offer_benefits_wrap .option_fields_wrap .option_3 .form_box span.pink').css({
            "visibility":"hidden"
        });
        $('.offer_benefits_wrap .option_fields_wrap .option_2 .form_box span.pink').css({
            "visibility":"visible"
        });
    }
    else{
        $('.option_fields_wrap .option_1').removeClass('selected');
        $('.option_fields_wrap .option_3').addClass('selected');
        $('.option_fields_wrap .option_3 input').removeAttr("disabled");
        $('.option_fields_wrap .option_2').removeClass('selected');
        $('.option_fields_wrap .option_1 input').attr('disabled', 'disabled');
        $('.option_fields_wrap .option_2 input').attr('disabled', 'disabled');
        $('.offer_benefits_wrap .option_fields_wrap .option_1 .form_box span.pink').css({
            "visibility":"hidden"
        });
        $('.offer_benefits_wrap .option_fields_wrap .option_2 .form_box span.pink').css({
            "visibility":"hidden"
        });
        $('.offer_benefits_wrap .option_fields_wrap .option_3 .form_box span.pink').css({
            "visibility":"visible"
        });
    }
    $('.ez-radio input').live('change', function(){
        if($('#company_offer_benefit_choice_1').is(':checked')){
            $('.option_fields_wrap .option_2').removeClass('selected');   
            $('.option_fields_wrap .option_1').addClass('selected');
            $('.option_fields_wrap .option_1 input').removeAttr("disabled");
            $('.option_fields_wrap .option_2 input').attr('disabled', 'disabled');
            $('.option_fields_wrap .option_3 input').attr('disabled', 'disabled'); 
            $('.option_fields_wrap .option_3').removeClass('selected');
            $('.offer_benefits_wrap .option_fields_wrap .option_2 ul.error_list').remove();
            $('.offer_benefits_wrap .option_fields_wrap .option_3 ul.error_list').remove();
            $('.offer_benefits_wrap .option_fields_wrap .option_3 .form_box').removeClass('error');
            $('.offer_benefits_wrap .option_fields_wrap .option_2 .form_box').removeClass('error');
            $('.offer_benefits_wrap .option_fields_wrap .option_2 .form_box span.pink').css({
                "visibility":"hidden"
            });
            $('.offer_benefits_wrap .option_fields_wrap .option_3 .form_box span.pink').css({
                "visibility":"hidden"
            });
            $('.offer_benefits_wrap .option_fields_wrap .option_1 .form_box span.pink').css({
                "visibility":"visible"
            });
        } else if($('#company_offer_benefit_choice_2').is(':checked')) {
            $('.option_fields_wrap .option_1').removeClass('selected');
            $('.option_fields_wrap .option_2').addClass('selected');
            $('.option_fields_wrap .option_2 input').removeAttr("disabled");
            $('.option_fields_wrap .option_3').removeClass('selected');
            $('.option_fields_wrap .option_1 input').attr('disabled', 'disabled');
            $('.option_fields_wrap .option_3 input').attr('disabled', 'disabled');
            $('.offer_benefits_wrap .option_fields_wrap .option_3 ul.error_list').remove();
            $('.offer_benefits_wrap .option_fields_wrap .option_1 ul.error_list').remove();
            $('.offer_benefits_wrap .option_fields_wrap .option_3 .form_box').removeClass('error');
            $('.offer_benefits_wrap .option_fields_wrap .option_1 .form_box').removeClass('error');
            $('.offer_benefits_wrap .option_fields_wrap .option_1 .form_box span.pink').css({
                "visibility":"hidden"
            });
            $('.offer_benefits_wrap .option_fields_wrap .option_3 .form_box span.pink').css({
                "visibility":"hidden"
            });
            $('.offer_benefits_wrap .option_fields_wrap .option_2 .form_box span.pink').css({
                "visibility":"visible"
            });
        }
        else{
            $('.option_fields_wrap .option_1').removeClass('selected');
            $('.option_fields_wrap .option_3').addClass('selected');
            $('.option_fields_wrap .option_3 input').removeAttr("disabled");
            $('.option_fields_wrap .option_2').removeClass('selected');
            $('.option_fields_wrap .option_1 input').attr('disabled', 'disabled');
            $('.option_fields_wrap .option_2 input').attr('disabled', 'disabled');
            $('.offer_benefits_wrap .option_fields_wrap .option_2 ul.error_list').remove();
            $('.offer_benefits_wrap .option_fields_wrap .option_1 ul.error_list').remove();
            $('.offer_benefits_wrap .option_fields_wrap .option_1 .form_box').removeClass('error');
            $('.offer_benefits_wrap .option_fields_wrap .option_2 .form_box').removeClass('error');
            $('.offer_benefits_wrap .option_fields_wrap .option_1 .form_box span.pink').css({
                "visibility":"hidden"
            });
            $('.offer_benefits_wrap .option_fields_wrap .option_2 .form_box span.pink').css({
                "visibility":"hidden"
            });
            $('.offer_benefits_wrap .option_fields_wrap .option_3 .form_box span.pink').css({
                "visibility":"visible"
            });
        }
    });
       
       
    $('.offer_benefits_wrap .option_fields_wrap .option_1 input').keypress(function (e){
        if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)){
            return false;
        }
    });
    function isNumber (o) {
        return ! isNaN (o-0);
    }
    $('.offer_benefits_wrap .option_fields_wrap .option_2 input').keypress(function (e){
        if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)){
            return false;
        }
        txtVal = $(this).val();  
        if(isNumber(txtVal) && txtVal.length>1)
        {
            $(this).val(txtVal.substring(0,1) )
        }
    });
    $('.offer_benefits_wrap .option_fields_wrap .option_1 input').keypress(function (e){
        if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)){
            return false;
        }
        txtVal = $(this).val();  
        if(isNumber(txtVal) && txtVal.length>6)
        {
            $(this).val(txtVal.substring(0,6) )
        }
    });
    $('#company_offer_benefit_text').keydown ( function (e) {
        if (checkMaxLength (this.innerHTML, 33)) {
            e.preventDefault();
            e.stopPropagation();
        }
    });
            
    function checkMaxLength (text, max) {
        return (text.length >= max);
    }
        
    function countChar(val) {
        var len = val.value.length;
        if (len >= 33) {
            val.value = val.value.substring(0, 33);
            $('#stat span').text(0);
        } else {
            $('#stat span').text(33 - len);
        }
    }
    countChar($('#company_offer_benefit_text').get(0));
    $('#company_offer_benefit_text').keyup(function() {
        countChar(this);
    });
/*End benefit*/    
    $(".dealForm .dotted h2, .dealForm .dotted .arrow_up_down").click(function(){
        $('.dealForm .additional_info_gray_bg.offer_in_english, .offer_in_english').slideToggle("fast");
        $(".dealForm .dotted .arrow_up_down").toggleClass("up down"); 
           
    });
    $(".dealForm .dotted .arrow_up_down up").click(function(){ 
        $(this).toggleClass("up down"); 
    }); 
    $("form#offerForm").submit(function(){
        $('input.save_offer').attr("disabled", "disabled");   
    });
    if($('#company_offer_active_to').next().is('.error_list')){
        $('.settings_content form.dealForm .form_box.form_label_inlineerror a.tip.endDate').css('top', '-67px');
    }   
} 
  
function offerBenefitChoiseBG(){
    $('.offer_benefits_wrap .option_fields_wrap .option_1 input').css('margin', '0 6px 0 -8px').addClass('bg_labels'); 
    $('.offer_benefits_wrap .option_fields_wrap .option_2 input').css('margin', '0 6px 0 -8px').addClass('bg_labels');
    $('.offer_benefits_wrap .option_fields_wrap .option_3 input').css('margin', '0 0 0 22px').addClass('bg_labels');
    $('.offer_benefits_wrap .option_fields_wrap .option_1 ul.error_list').css('margin', '0 6px 0 0px');
}
function offerBenefitChoiseMK(){
    $('.offer_benefits_wrap .option_fields_wrap .option_2 input').css('margin', '0 6px 0 10px').addClass('mk_labels');
    $('.offer_benefits_wrap .option_fields_wrap .option_3 input').css('margin', '0 0 0 22px').addClass('mk_labels'); 
}
function offerBenefitChoiseSR(){
    $('.offer_benefits_wrap .option_fields_wrap .option_2 input').css('margin', '0 7px 0 13px').addClass('sr_labels');
    ;
    $('.offer_benefits_wrap .option_fields_wrap .option_3 input').css('margin-left', '24px').addClass('sr_labels');
}
function offerBenefitChoiseRO(){
    if($('#company_offer_discount_pct').next().is('.error_list')){
        $('#company_offer_discount_pct').next('.error_list').css('margin', '0 0 0 88px');
    }
    $('.offer_benefits_wrap .option_fields_wrap .option_2 input').addClass('ro_labels');
    ;
    $('.offer_benefits_wrap .option_fields_wrap .option_3 input').addClass('ro_labels');  
}
  
function offerDatepickers(offerMaxEndDate, voucherMinDate, dealActiveTo, sCulture, str){
    if('en' == sCulture){
        $.datepicker.setDefaults($.datepicker.regional['']);
    }else
        $.datepicker.setDefaults($.datepicker.regional[sCulture]);
    $("#company_offer_active_from").datepicker("setDate", new Date());
    $(function() {
        $( "#company_offer_active_from" ).datepicker({
            defaultDate: new Date(),
            minDate: 0,
            maxDate: offerMaxEndDate,
            dateFormat: 'dd.mm.yy',
            changeMonth: true,
            numberOfMonths: 1,
            onClose : function(dateEnd) {
                if($("#company_offer_active_from").datepicker("getDate") === null) {
                    var todayDate = new Date();
                    $("#company_offer_active_from").datepicker("setDate", todayDate);
                }
                //  $("a.endDate").show();
                var dateStart = $('#company_offer_active_from').datepicker("getDate");
                var dateEnd = $('#company_offer_active_from').datepicker("getDate");
                var voucherStartDate = $('#company_offer_active_from').datepicker("getDate");
                dateEnd.setDate(dateEnd.getDate() + 29);
                dateStart.setDate(dateStart.getDate() + 1);
                $("#company_offer_active_to").datepicker('option', {
                    minDate: dateStart, 
                    maxDate: dateEnd
                });
                $("#company_offer_valid_from").datepicker('option', {
                    minDate: voucherStartDate
                });
                // $('#company_offer_valid_to').datepicker('option', {minDate: dateStart});
                setTimeout(function(){
                    $("#company_offer_active_to").datepicker("show");
                },100);

            }
        });
        $( "#company_offer_active_to" ).datepicker({
            changeMonth: false,
            minDate:new Date(),
            maxDate: offerMaxEndDate,
            numberOfMonths: 1,
            dateFormat: 'dd.mm.yy 23:59:59',
            onClose :function() {
                if($(this).datepicker("getDate")== null)
                {
                    var dateStart = $('#company_offer_active_from').datepicker("getDate");
                    dateStart.setDate(dateStart.getDate() + 1);
                    $(this).datepicker('setDate', dateStart);
                }
                var voucherMinEndDate = $(this).datepicker("getDate");
                voucherMinEndDate.setDate(voucherMinEndDate.getDate() + 1);
                $('#company_offer_valid_to').datepicker('option', {
                    minDate: voucherMinEndDate
                });
                setTimeout(function(){
                    $("#company_offer_valid_from").datepicker("show");
                },100);
            }
        });
        $('#company_offer_valid_from').datepicker({
            changeMonth: false,
            minDate: voucherMinDate,
            numberOfMonths: 1,
            dateFormat: 'dd.mm.yy',
            onClose :function() {
                setTimeout(function(){
                    $("#company_offer_valid_to").datepicker("show");
                },100);
            }
        });
        var currentDateNextDay = new Date();
        currentDateNextDay.setDate(currentDateNextDay.getDate() + 1);
        $('#company_offer_valid_to').datepicker({
            changeMonth: false,
            minDate: currentDateNextDay,
            numberOfMonths: 1,
            dateFormat: 'dd.mm.yy'
        });
    });
    $( "#company_offer_active_from" ).live("change",  function() {
        //  $("a.endDate").hide();
        var dateTypeVar = $('#company_offer_active_from').datepicker('getDate');
        dateTypeVar.setDate(dateTypeVar.getDate() + 29);
        var dateString = $.datepicker.formatDate("dd.mm.yy", dateTypeVar);
        $('a.endDate').html('<span class="details">'+str+' ' + dateString + '</span>');
        $("a.endDate").show();
        $(this).parent().removeClass('form_label_inlineerror');
        $(this).parent().addClass('form_label_inline');
        $(this).next().remove();
    });
        
    $( "#company_offer_active_to" ).live("change",  function() {
        var voucherMinEndDate = $('#company_offer_active_to').datepicker('getDate');
        $('#company_offer_valid_to').datepicker('option', {
            minDate: voucherMinEndDate
        });
        $(this).parent().removeClass('form_label_inlineerror');
        $(this).parent().addClass('form_label_inline');
        $(this).next().remove();
    });
    $( "#company_offer_valid_from" ).live("change",  function() {
        $(this).parent().removeClass('form_label_inlineerror');
        $(this).parent().addClass('form_label_inline');
        $(this).next().remove();
    });
    $( "#company_offer_valid_to" ).live("change",  function() {
        $(this).parent().removeClass('form_label_inlineerror');
        $(this).parent().addClass('form_label_inline');
        $(this).next().remove();
    });
}
  
/*Offer Index page*/
function offerSelectMenus(){
      
   $.q('#city_id').first().select2();
   $.q('#sector_id').first().select2();
}

function offersLayoutBG(){
    $.q('.count_down_timer').addClass('counter_bg');
    $('.getVoucherBtn').addClass('smaller');
    $('.expiration_strip.expired').css('padding','3px 67px 6px 50px');

}
function offersLayoutMK(){
    $.q('.count_down_timer').addClass('counter_mk');
    $.q('.bottom_wrap').css('padding', '6px 0');
    $.q('.count_down_timer p').css("margin-right", "0px"); 
    $.q('.getVoucherBtn').css('margin-top', '14px');
    $.q('.expiration_strip.expired').css('padding','3px 67px 6px 60px');
    $.q('.expiration_strip').css('padding','3px 67px 6px 50px');
    $.q('.getVoucherBtn').addClass('mk_btn');
}

function offerLayoutRO(){
    $.q('.bottom_wrap').css('padding', '6px 0');
    $.q('.getVoucherBtn').css('margin-top', '14px');
    $.q('.expiration_strip.expired').css('padding','3px 67px 6px 90px');
    $.q('.count_down_timer').addClass('counter_ro');
}


/*End offer index page*/
/*Single offer page*/
function singleOfferLayout(){
   $.q(".ui-dialog").css("z-index", "2000");
   $.q('#login').click(function() {
        $('.login_form_wrap').slideToggle("fast");
    });
    $.q(".login_form_wrap a#header_close").click(function() {
        $.q('#login').removeClass('button_clicked');
    });
}
function singleOfferLayoutNotLogged_EN(){
    $.q('#getVoucher').addClass('bigger_button');
    $.q('#remainingVouchers').addClass('for_bigger_button');
    $.q('#bottomWrap').addClass('not_logged_in_en');
}
function singleOfferLayoutLogged_EN(){
    $.q('#bottomWrap').addClass('logged_in_bg_en');
    $.q('#voucherCount').addClass('moz');
}
function maxVoucher1(){
    $.q('#getVoucher').addClass('bigger_button');
    $.q('#remainingVouchers').addClass('for_bigger_button');
}
function singleOfferLayoutLoggedForm_BG(){
    $.q('#countDownLabel').addClass('smaller');
    $.q('#voucherValidLabels').addClass('smaller');
    $.q('#bottomWrap').addClass('logged_in_bg');
    $.q('#voucherCount').addClass('bg_voucher_form');
}
function singleOfferLayoutNotLogged_BG(){
    $.q('#getVoucher').addClass('bigger_button');
    $.q('#remainingVouchers').addClass('for_bigger_button');
    $.q('#bottomWrap').addClass('not_logged_in_bg');
    $.q('#expirationStrip').css('padding', '3px 67px 6px 60px');
    $.q('#expiredStrip').css('padding', '3px 67px 6px 43px');
}
function singleOfferLayoutLoggedForm_MK(){
    $.q('#getVoucherBtnForm').addClass('voucher_form_layout');
    $.q('#voucherCount').css({
        'width':'127px',
        'margin-right': '10px',
        'max-width': '130px'
    });
    $.q('#countDownLabel').addClass('smaller');
    $.q('#countDownTimer').css({
        'max-width':'125px', 
        'text-align':'center'
    });
    $.q('#bottomWrap').addClass('voucher_form_layout');
    $.q('#voucherCount').addClass('voucher_form_layout_mk moz');
}

function singleOfferLayoutNotLogged_MK(){
    $.q('#voucherValidLabels').addClass('smaller');
    $.q('#countDownLabel').addClass('smaller');
    $.q('#countDownTimer').css({
        'text-align':'center'
    });
    $.q('#expirationStrip').css('padding', '3px 67px 6px 42px');
    $.q('#expiredStrip').css('padding', '3px 67px 6px 50px');
} 
function singleOfferLayoutLoggedForm_SR(){
    $.q('#countDownLabel').addClass('smaller');
    $.q('#voucherValidLabels').addClass('smaller');
    $.q('#getVoucherBtnForm').css('margin-top:', '0px !important');
    $.q('#voucherCount').addClass('voucher_form_layout');
    $.q('#countDownLabel').addClass('smaller');
    $.q('#countDownTimer').css('max-width','125px');
    $.q('#bottomWrap').addClass('voucher_form_layout_sr');
}
function singleOfferLayoutNotLogged_SR(){
    $.q('#voucherValidLabels').addClass('smaller');
    $.q('#countDownLabel').addClass('smaller');
    $.q('#bottomWrap').addClass('not_logged_sr');
    $.q('#getVoucher').addClass('bigger_button');
    $.q('#remainingVouchers').addClass('for_bigger_button');
}
function singleOfferLayoutLoggedForm_RO(){
    $.q('#getVoucherBtnForm').addClass('voucher_form_layout');
    $.q('#voucherCount').css({
        'width':'130px',
        'margin-right': '10px',
        'max-width': '130px'
    });
    $.q('#countDownLabel').addClass('smaller');
    $.q('#countDownTimer').css('max-width','125px');
    $.q('#bottomWrap').addClass('logged_ro');
    $.q('#voucherCount').addClass('voucher_form_layout_ro');
}
function singleOfferLayoutNotLogged_RO(){
   $.q('#countDownTimer').css('text-align', 'center');
   $.q('#expiredStrip').css('padding','3px 67px 6px 80px');
   $.q('#voucherValidLabels').addClass('smaller');
   $.q('#countDownLabel').addClass('smaller');
   $.q('#getVoucher').addClass('bigger_button');
   $.q('#remainingVouchers').addClass('for_bigger_button');
}
  /*End Single offer page */
   function test(){
    var shownOffer = $('.filtered');
    var bounds = new google.maps.LatLngBounds( );
    $(shownOffer).each(function(index, value) { 
        var dealEndDate = new Date(parseInt($(this).attr('time-left'), 10));
        if($(this).attr('c-l')=='bg')   {
            $('#offerCountdown' + $(this).attr('o-id')).countdown({
                until: dealEndDate, 
                compact: true,
                compactLabels: ['', '', '', ' Дни', '', '', ''], 
                compactLabels1: ['', '', '', ' Ден', '', '', ''],            
            
                whichLabels: function(amount) { 
                    var units = amount % 10; 
                    var tens = Math.floor(amount % 100 / 10); 
                    return (amount == 1 ? 1 : 
                        (units >=2 && units <= 4 && tens != 1 ? 2 : 0)); 
                }
            }); 
        }else if($(this).attr('c-l')=='mk')   {
            $('#offerCountdown' + $(this).attr('o-id')).countdown({
                until: dealEndDate, 
                compact: true,
                compactLabels: ['', '', '', ' Денови', '', '', ''], 
                compactLabels1: ['', '', '', ' Ден', '', '', ''],
            
                whichLabels: function(amount) { 
                    var units = amount % 10; 
                    var tens = Math.floor(amount % 100 / 10); 
                    return (amount == 1 ? 1 : 
                        (units >=2 && units <= 4 && tens != 1 ? 2 : 0)); 
                }
            }); 
        }
        else if($(this).attr('c-l')=='sr')   {
            $('#offerCountdown' + $(this).attr('o-id')).countdown({
                until: dealEndDate, 
                compact: true,
                compactLabels: ['', '', '', ' Dana', '', '', ''], 
                compactLabels1: ['', '', '', ' Dan ', '', '', ''],
            
                whichLabels: function(amount) { 
                    var units = amount % 10; 
                    var tens = Math.floor(amount % 100 / 10); 
                    return (amount == 1 ? 1 : 
                        (units >=2 && units <= 4 && tens != 1 ? 2 : 0)); 
                }
            }); 
        }
        else if($(this).attr('c-l')=='ro')   {
            $('#offerCountdown' + $(this).attr('o-id')).countdown({
                until: dealEndDate, 
                compact: true,
                compactLabels: ['', '', '', ' Zile', '', '', ''], 
                compactLabels1: ['', '', '', ' Zi', '', '', ''],
            
                whichLabels: function(amount) { 
                    var units = amount % 10; 
                    var tens = Math.floor(amount % 100 / 10); 
                    return (amount == 1 ? 1 : 
                        (units >=2 && units <= 4 && tens != 1 ? 2 : 0)); 
                }
            }); 
        }
        else if($(this).attr('c-l')=='en')   {
            $('#offerCountdown' + $(this).attr('o-id')).countdown({
                until: dealEndDate, 
                compact: true,
                whichLabels: function(amount) { 
                    var units = amount % 10; 
                    var tens = Math.floor(amount % 100 / 10); 
                    return (amount == 1 ? 1 : 
                        (units >=2 && units <= 4 && tens != 1 ? 2 : 0)); 
                }
            }); 
        }
        map.map.fitBounds(bounds);
        google.maps.event.trigger(map.map, 'resize');
          
    });         
}