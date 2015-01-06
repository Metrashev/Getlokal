/*=-=-=-=-RUPA icons=-=-=-=-*/
function rupaIcons(){  
	var UL = "ul.feature_icons_wrapper";
    $(UL+' li').click(function() {
        $(this).children('.img_feature_company').toggleClass('selected');
        var checkBoxes = $(this).children('input[type=checkbox]');
        checkBoxes.attr("checked", !checkBoxes.attr("checked"));
    });
         
    $(UL+' li.outdoor_seats').click(function() {
        // $(this).children('.img_feature_company').toggleClass('selected');
        $(this).toggleClass('more_padding');
        $('.form_outdoor_seats_mask').slideToggle('fast');
        $('.feature_icons .form_outdoor_seats').slideToggle('fast');            
    });
    $(':not(ul.feature_icons_wrapper li.outdoor_seats)').click(function (event) {
        if (($(event.target).closest('.feature_icons .form_outdoor_seats').get(0) == null) && ($(event.target).closest(UL+' li.outdoor_seats').get(0) == null) ) {
            if($('#descriptions_outdoor_seats').val().length !=0 ){ 
                $(UL+' li.outdoor_seats .img_feature_company').addClass('selected');
                $('#descriptions_feature_company_list_7').attr("checked", true);
                var outdoor_number = $('input#descriptions_outdoor_seats').val();
                $(UL+' li.outdoor_seats .number').text(outdoor_number);
            }
            else{
                $(UL+' li.outdoor_seats .img_feature_company').removeClass('selected');
                $('#descriptions_feature_company_list_7').attr("checked", false);
                var outdoor_number = $('input#descriptions_outdoor_seats').val();
                $(UL+' li.outdoor_seats .number').text(outdoor_number);
            }
            $('.feature_icons .form_outdoor_seats').slideUp('fast');
            $('.form_outdoor_seats_mask').slideUp('fast');
            $(UL+' li.outdoor_seats').removeClass('more_padding');
            $(UL+' li.outdoor_seats').find('input').prop('checked', false); 
        };
    });
    $(UL+' li.indoor_seats').click(function() {
        $(this).toggleClass('selected');
        $(this).toggleClass('more_padding');    
        $('.feature_icons .form_indoor_seats').slideToggle('fast');      
        $('.form_indoor_seats_mask').slideToggle('fast');
    });
        
    $(':not(ul.feature_icons_wrapper li.indoor_seats)').click(function (event) {
        if (($(event.target).closest('.feature_icons .form_indoor_seats').get(0) == null) && ($(event.target).closest(UL+' li.indoor_seats').get(0) == null) ) {
            if($('#descriptions_indoor_seats').val().length !=0 ){ 
                $(UL+' li.indoor_seats .img_feature_company').addClass('selected');
                $('#descriptions_feature_company_list_8').attr("checked", true);
                var outdoor_number = $('input#descriptions_indoor_seats').val();
                $(UL+' li.indoor_seats .number').text(outdoor_number);
            }
            else{
                $(UL+' li.indoor_seats .img_feature_company').removeClass('selected');
                $('#descriptions_feature_company_list_8').attr("checked", false);
                var outdoor_number = $('input#descriptions_indoor_seats').val();
                $(UL+' li.indoor_seats .number').text(outdoor_number);
            }        
            $('.feature_icons .form_indoor_seats').slideUp('fast');
            $('.form_indoor_seats_mask').slideUp('fast');
            $(UL+' li.indoor_seats').removeClass('more_padding');

        };
    }); 
      
    $('.form_indoor_seats a.button_green.clear_btn').on('click',function() {
        $('input.indoor_number').val('');
        $('input#descriptions_indoor_seats').val('');
        $(UL+' li.indoor_seats').removeClass('selected');
        $(UL+' li.indoor_seats .number').text('');
        $(UL+' li.indoor_seats .img_feature_company').removeClass('selected');
        $("#descriptions_feature_company_list_8").attr("checked", false);
    });
      
      
    $(UL+' li.wifi_option').click(function() {
        $(this).toggleClass('selected');
        $(this).toggleClass('more_padding');    
        $('.feature_icons .form_wifi').slideToggle('fast');      
        $('.form_wifi_mask').slideToggle('fast');
    });
          
    $(':not(ul.feature_icons_wrapper li.wifi_option)').click(function (event) {
        if (($(event.target).closest('.feature_icons .form_wifi').get(0) == null) && ($(event.target).closest(UL+' li.wifi_option').get(0) == null) ) {
            if($('#descriptions_wifi_access_0').is(':checked') || $('#descriptions_wifi_access_1').is(':checked')){
                var accessTypeFree = 'Free';
                var accessTypePaid = 'Paid';
                if($("input#descriptions_wifi_access_0:checked" ).val()==0){
                    $(UL+' li.wifi_option .number').text(accessTypeFree);
                    $('#descriptions_feature_company_list_9').attr("checked", true);
                }
                if($( "input#descriptions_wifi_access_1:checked" ).val()==1){
                    $(UL+' li.wifi_option .number').text(accessTypePaid);
                    $('#descriptions_feature_company_list_9').attr("checked", true);
                }
                $(UL+' li.wifi_option .img_feature_company').addClass('selected');
            }
            $('.feature_icons .form_wifi').slideUp('fast');
            $('.form_wifi_mask').slideUp('fast');
            $(UL+' li.wifi_option').removeClass('more_padding');
       
        };
    });

    $('.form_outdoor_seats a.button_green').click(function() {
        var outdoor_number = $('input#descriptions_outdoor_seats').val();
        if(outdoor_number==""){
            $(UL+' li.outdoor_seats .img_feature_company').removeClass('selected');
        }else{
            $(UL+' li.outdoor_seats .img_feature_company').addClass('selected');
        }
        $(UL+' li.outdoor_seats .number').text(outdoor_number);
        $('.feature_icons .form_outdoor_seats').slideUp('fast');
        $('.form_outdoor_seats_mask').slideUp('fast');
        $(UL+' li.outdoor_seats').removeClass('more_padding');
             
    });
        
    $('.form_outdoor_seats a.button_green.clear_btn').click(function() {     
        $('input.outdoor_number').val('');
        $('input#descriptions_outdoor_seats').val('');
        $(UL+' li.outdoor_seats .number').text('');
        $(UL+' li.outdoor_seats .img_feature_company').removeClass('selected');
        $("#descriptions_feature_company_list_7").attr("checked", false);
    });
        
        
    $('.form_indoor_seats a.button_green').click(function() {
        var indoor_number = $('input#descriptions_indoor_seats').val();
        if(indoor_number==""){
            $(UL+' li.indoor_seats .img_feature_company').removeClass('selected');
        }else{
            $(UL+' li.indoor_seats .img_feature_company').addClass('selected');
        }
        $(UL+' li.indoor_seats .number').text(indoor_number);
       
        $('.feature_icons .form_indoor_seats').slideUp('fast');
        $('.form_indoor_seats_mask').slideUp('fast');
        $(UL+' li.indoor_seats').removeClass('more_padding');
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
        var accessTypeFree = 'Free';
        var accessTypePaid = 'Paid';
        if($("input#descriptions_wifi_access_0:checked" ).val()==0){
            $(UL+' li.wifi_option .number').text(accessTypeFree);
        }
        if($( "input#descriptions_wifi_access_1:checked" ).val()==1){
            $(UL+' li.wifi_option .number').text(accessTypePaid);
        }
        $(UL+' li.wifi_option .img_feature_company').addClass('selected');    
        $('.feature_icons .form_wifi').slideUp('fast');
        $('.form_wifi_mask').slideUp('fast');
        $(UL+' li.wifi_option').removeClass('more_padding');
    });
    $('.form_wifi a.button_green.clear_btn').on('click',function() {
        $('#descriptions_feature_company_list_9').attr("checked", false);
        $(UL+' li.wifi_option .number').text('');
        $(UL+' li.wifi_option .img_feature_company').removeClass('selected');
        $('#descriptions_wifi_access_0').attr("checked", false);
        $('#descriptions_wifi_access_1').attr("checked", false);
    });   
    /*Close forms on X */    
   
    $('.form_outdoor_seats a#picture_form_close img').on('click',function(){ 
        if($('#descriptions_outdoor_seats').val().length !=0 ){ 
            $(UL+' li.outdoor_seats .img_feature_company').addClass('selected');
                   
        }
        else if($('#descriptions_outdoor_seats').val().length ==0 ){ 
            $(UL+' li.outdoor_seats .img_feature_company').removeClass('selected');
                 
        }
        $('.feature_icons .form_outdoor_seats').slideUp('fast');
        $('.form_outdoor_seats_mask').slideUp('fast');
        $(UL+' li.outdoor_seats').removeClass('more_padding');
    });
    
    $('.form_indoor_seats a#picture_form_close img').on('click',function(){
        if($('#descriptions_indoor_seats').val().length !=0 ){ 
            $(UL+' li.indoor_seats .img_feature_company').addClass('selected');
                   
        }
        else if($('#descriptions_indoor_seats').val().length ==0 ){ 
            $(UL+' li.indoor_seats .img_feature_company').removeClass('selected');
                 
        }
        $('.feature_icons .form_indoor_seats').slideUp('fast');
        $('.form_indoor_seats_mask').slideUp('fast');
        $(UL+' li.indoor_seats').removeClass('more_padding');
    });
    
    $('.form_wifi a#picture_form_close img').on('click',function(){ 
       
        if($('#descriptions_wifi_access_0').is(':checked') || $('#descriptions_wifi_access_1').is(':checked')){
            var accessTypeFree = 'Free';
            var accessTypePaid = 'Paid';
            if($("input#descriptions_wifi_access_0:checked" ).val()==0){
                $(UL+' li.wifi_option .number').text(accessTypeFree);
                $('#descriptions_feature_company_list_9').attr("checked", true);
            }
            if($( "input#descriptions_wifi_access_1:checked" ).val()==1){
                $(UL+' li.wifi_option .number').text(accessTypePaid);
                $('#descriptions_feature_company_list_9').attr("checked", true);
            }
            $(UL+' li.wifi_option .img_feature_company').addClass('selected');
        }else if(!$('#descriptions_wifi_access_0').is(':checked') || !$('#descriptions_wifi_access_1').is(':checked')) {
            $(UL+' li.wifi_option .img_feature_company').removeClass('selected');
            $('#descriptions_feature_company_list_9').attr("checked", false);
        }
        $('.feature_icons .form_wifi').slideUp('fast');
        $('.form_wifi_mask').slideUp('fast');
        $(UL+' li.wifi_option').removeClass('more_padding');
    });
  
    if($('.feature_icons .form_indoor_seats input[type=text]').val().lenght !==0){
        var indoor_number = $('input#descriptions_indoor_seats').val();
        $(UL+' li.indoor_seats .number').text(indoor_number);
    }
 
    if($('.feature_icons .form_outdoor_seats input[type=text]').val().lenght !==0){
        var outdoor_number = $('input#descriptions_outdoor_seats').val();
        $(UL+' li.outdoor_seats .number').text(outdoor_number);
    }
 
    if($('#descriptions_wifi_access_0').is(':checked') || $('#descriptions_wifi_access_1').is(':checked')){
        var accessTypeFree = 'Free';
        var accessTypePaid = 'Paid';
        if($("input#descriptions_wifi_access_0:checked" ).val()==0){
            $(UL+' li.wifi_option .number').text(accessTypeFree);
            $('#descriptions_feature_company_list_9').attr("checked", true);
        }
        if($( "input#descriptions_wifi_access_1:checked" ).val()==1){
            $(UL+' li.wifi_option .number').text(accessTypePaid);
            $('#descriptions_feature_company_list_9').attr("checked", true);
        }
        $(UL+' li.wifi_option .img_feature_company').addClass('selected');
    }

    if($('#descriptions_outdoor_seats').val().length !=0 ){ 
        $(UL+' li.outdoor_seats .img_feature_company').addClass('selected');
    }
    if($('#descriptions_indoor_seats').val().length !=0 ){ 
        $(UL+' li.indoor_seats .img_feature_company').addClass('selected');
    }

}    
/*=-=-=-=-RUPA icons END=-=-=-=*/