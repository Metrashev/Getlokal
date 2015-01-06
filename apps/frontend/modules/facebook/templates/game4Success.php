<?php include_javascripts() ?>
<?php include_stylesheets() ?>
<?php use_stylesheets_for_form($gameForm) ?>
<?php include_partial('company/rating');?>

<?php slot("fb_meta") ?>
    
    <meta property="fb:app_id" content="191865117646261"/>
    <meta property="og:url" content="<?php echo url_for('default', array('module' => 'facebook', 'action' => 'game4'), true); ?>" />
    <meta property="og:title" content="Гореща лятна надпревара" />
    <meta property="og:description" content="Спечели два билета за The Wall всяка седмица!" />
    <meta property="og:type" content="game" />
    <meta property="og:site_name" content="<?php echo $sf_request->getHost() ?>" />
    <meta property="og:image" content="<?php echo public_path('/images/facebook/prizes/bg/game_' . $facebookGame->getId() . '_award_big', true) ?>" />
    <meta property="og:country-name" content="BG" />
<?php end_slot(); ?>

<div class="wrapInner">
	<div class="header">
<?php /*    	<img src="/images/facebook/prizes/bg/game_<?php  echo $facebookGame->getId() ?>_header.png" />  */ ?>  
	</div>
	
	<div class="content">
	
	<div class="step1 slide">
	<div class="left_wrap step-1">
            <img class="hangouts" src="/images/facebook/v3/bg/step_1_images.png"/>
	    <h2>Спечели два билета за The Wall всяка седмица!</h2>
	    <ul class="first_step">
	        <li class="local">Избери любимо място</li>
	        <li class="msg">Напиши ревю</li>
	        <li class="gift">Участвай в надпреварата</li>  	
	    </ul>
            <div class="clear"></div>
            <div class="pre_footer">
                 <ul class="first_step terms">
                     <li class="checkbox">
                        <input type="checkbox" style="display: none" checked>
                     </li>
                     <li class="terms">Съгласен съм с <a href="http://www.getlokal.com/bg/page/terms-of-use" target="_blank">Условията за ползване</a>, <a href="http://www.getlokal.com/bg/page/privacy-policy" target="_blank">Правилата за поверителност</a> и <a href="http://www.getlokal.com/bg/page/rules-the-wall" target="_blank">Официалните правила на промоцията</a> на getlokal</li>
                </ul>
                 <div class="clear"></div>
                  <p class="error_terms error_msg" style="display: none">Моля, съгласете се с условията.</p>
                 <a href="#" class="button continue">Влез в играта</a>
            </div>
	</div>
          
    <div class="clear"></div>
    
    </div>
    <div class="pre_footer_bg"></div>
    <div class="step2 slide">
        <div class="left_wrap step-2">    
                <h2>Избери любимо място</h2>
                    <div id="dropdown_search">
	                <div class="form_search">
	                    <div class="form_box input_box">
	                        <label for="search_place">Име</label>
	                        <input id="search_place" type="text" autocomplete="off" />
	                    </div>
	
	                    <div class="form_city">
	                        <?php echo $gameForm['location_id']->renderLabel()?>
	                        <?php echo $gameForm['location_id'] ?>
	                        <?php echo $gameForm['location_id']->renderError()?>
		                    <a href="javascript:void(0);" id="search_city_name"></a>
		                </div>
		            </div>
	
                    <div id="PlacesList" class="places_dropdown">
                        <a href="javascript:void(0)" id="form_close">x</a>
                        <div class="scroll">
                            <div class="scrollbar">
                                <div class="track"><div class="thumb"><div class="end"></div></div></div>
                            </div>
                            <div class="viewport"><div class="overview"></div></div>
                        </div>
                   </div>
		        </div>
	
		        <p class="error_place error_msg" style="display: none">Избери място!</p>

	            <p class="search_result"></p>
	      
            
                    <div class="separator"></div>
            <div class="form">
            	<div>
	                <h2>Напиши ревю и дай оценка</h2>

	                <input type="text" name="reivew_place" value="" style="display: none; visibility: hidden" />
	               	<div class="input_wrap">
	                	<label>Оценка * </label>
		                <ul class="radio_list">
		                    <li><input autocomplete="off" title="<?php echo __('Poor'); ?>" name="review[rating]" type="radio" value="1" id="review_rating_1" class="star">&nbsp;<label for="review_rating_1"></label></li>
		                    <li><input autocomplete="off" title="<?php echo __('Average'); ?>" name="review[rating]" type="radio" value="2" id="review_rating_2" class="star">&nbsp;<label for="review_rating_2"></label></li>
		                    <li><input autocomplete="off" title="<?php echo __('Good'); ?>" name="review[rating]" type="radio" value="3" id="review_rating_3" class="star">&nbsp;<label for="review_rating_3"></label></li>
		                    <li><input autocomplete="off" title="<?php echo __('Very good'); ?>" name="review[rating]" type="radio" value="4" id="review_rating_4" class="star">&nbsp;<label for="review_rating_4"></label></li>
		                    <li><input autocomplete="off" title="<?php echo __('Excellent'); ?>" name="review[rating]" type="radio" value="5" id="review_rating_5" class="star">&nbsp;<label for="review_rating_5"></label></li>
		                </ul>
						<div class="clear"></div>
		                <p class="error_rating error_msg" style="display: none">Моля, дай оценка!</p>
					</div>
	                        <div class="input_wrap">
                                <textarea id="review" name="review" autocomplete="off">Вашият коментар*</textarea>
                                <p class="error_review error_msg" style="display: none">Ревюто трябва да съдържа поне 5 символа!</p>

		           	</div>
		            <a href="#" class="button continue to_slide_3">Продължи</a>
		            <p>Моля пишете на кирилица, без обидни и нецензурни изрази.</p>
	       		</div>
	        </div>
        </div>
        
	    </div>
	    
	<div class="step3 slide">
     <div class="left_wrap step-3">
        
            <input type="hidden" value="" name="share_image" style="display: none !important; visibility: none !important;" />
             <h2 id="final_step">Честито! Участваш в томболата за два билета за The Wall, която ще се тегли на 12 август 2013</h2>  
                    <a href="#" class="invite button">Покани приятел</a>
                    <a href="#" class="share button">Сподели на стената</a>    
                <div class="clear"></div>

                <div class="play_again">
                    <a href="<?php echo url_for('facebook/game4') ?>" class="button">Играй отново и спечели</a>
 <?php /*                           <img src="/images/facebook/prizes/bg/game_<?php echo $facebookGame->getId() ?>_prize_small.png" />    */ ?>
                    <div class="clear"></div>
                </div>
        </div>
     </div>
</div>

    <div class="footer">
        <a href="<?php echo url_for('@homepage', array(), true); ?>" target="_blank"><img src="<?php echo public_path('/images/facebook/v3/bg/icon_e.png', true) ?>" /></a>
        <a href="<?php echo url_for('facebook/game4', array(), true) ?>">Начало</a>
        <a href="<?php echo url_for('static_page', array('slug' => 'rules-the-wall')) ?>" target="_blank">Правила на играта</a>
    </div>

</div>

<div id="fb-root"></div>
<script src="//connect.facebook.net/en_US/all.js"></script>

<script type="text/javascript">

FB.init({
        appId : '191865117646261',
        frictionlessRequests: true,

        status: true,
        cookie: true,
        oauth: true,
        xfbml: true
    });

    FB.Canvas.setAutoGrow(200);
    FB.Canvas.scrollTo(0,0);

function requestCallback(response) {
  // Handle callback here
}

$(document).ready(function() {  
    
    
      if($('textarea[name="review"]').val() === 'Вашият коментар*')
        {
            $("textarea#review").css({"color": "#999","font-style":"italic"});
        }
      $("textarea#review").click(function() {
            $(this).css({"color": "#494949","font-style":"normal"});
    });

    $("textarea#review")
        .focus(function() {
        if (this.value === this.defaultValue) {
            this.value = '';
        }
  })
  .blur(function() {
        if (this.value === '') {
            this.value = this.defaultValue;
             $("textarea#review").css({"color": "#999","font-style":"italic"});
        }
});
	
        
        
        
	function myLoop () {
		setTimeout(function () {
			$('.step1').css('height', $('.step1 > img').outerHeight());
			if ($('.step1 > img').outerHeight() < 1)
				myLoop();
		}, 300);
	}
	myLoop();
	
	<?php if (!$isFbGame) : ?>
		$('html').css('background', 'url("../images/gui/bg.gif") repeat scroll 0 0 #ffffff')
	<?php endif;?>
	
    var max_steps = 3;
    var _step = 1;
    
    $('.slide .continue').click(function () {
        var hasError = false;
       if(_step==1){
           var checked = $("input[type=checkbox]:checked").length;
            if(checked == 0) {
            $('.error_terms').css("display","block");
            $('.wrapInner div.content .pre_footer_bg').css('padding-bottom', "40px");
            return false;
            
        }}; 
     
        if (_step == 2) {
          	
            if ($('input[name="reivew_place"]').val() == 'undefiled' || $('input[name="reivew_place"]').val() == '') {
                $(".error_place").show();
                $(".footer").css("margin-top","40px")
                hasError = true;
            }
            else {
                $(".error_place").hide();

                if ($("input.star:checked").val() == undefined || $("input.star:checked").val() < 1 || $("input.star:checked").val() > 5) {
                    $(".error_rating").show();
                     $(".footer").css("margin-top","40px")
                    hasError = true;
                   
                }
                else {
                    $("span.error_rating").hide();
                }

                if ($('textarea[name="review"]').val() == undefined || $('textarea[name="review"]').val().length < 5 || $('textarea[name="review"]').val() ==='Вашият коментар*') {
                    $(".error_review").show();
                    $(".footer").css("margin-top","40px")
                    hasError = true;
                }
                else {
                    $(".error_review").hide();
                }
            }

            if (hasError) {
                return false;
            }

            $.post('<?php echo url_for('default', array('module' => 'facebook', 'action' => 'game4'), true) ?>', { save: true, review_place: $('input[name="reivew_place"]').val(), review_stars: $("input.star:checked").val(), review_text: $('textarea[name="review"]').val(), genre: $('input[name="genre"]:checked').val() }, function(data) {
                if (data) {
                    if (data.error != undefined && data.error == true) {
                        location.href = '<?php echo url_for('facebook/game4'); ?>';
                    }
                    else if (data.error == false) {
                        var iterations = 0;
                        var results = '';

                        $("input[name=share_image]").val(data.image);

                        $.each(data.result, function(param1, param2) {
                            iterations++;
                            var scnd="";
                            if ((iterations % 2) == 0)
                                scnd='second';
//                            results = results + '<div class="result_wrap"><span>' + param1 + '</span><div class="result_bar"><div class="' + scnd + '" style="width:' + param2 + '%"></div></div><span class="blue"><img src="/images/gui/bg_vote.gif" />' + param2 + '%</span><div class="clear"></div></div>';
                        });

//                        results = results + '<div class="total_votes"><p>Общо до момента: <span class="blue">' + data.total + ' гласа</span></p></div>';
//                        $(".final_results").html(results);
                    }
                }
            }, 'json');
        }
     
        _step++;
         console.log(_step);
         if(_step==3){
         $('.step2.slide').hide();
            $('.left_wrap.step-2').hide();
            $('.step3.slide').show();
         }
         
         //   $('.slide').hide();
        $('.left_wrap.step-1').hide();
        $('.pre_footer_bg').hide();
        $('.step'+ _step).show();

        return false;
    });

    
    $('.radio_list a').click(function() {
            $('.error_rating').hide();
    });

    $('#review').keyup(function() {
            if ($(this).val().length > 4)
                    $('.error_review').hide();
    });


    $(".invite_email").click(function () {
    	$(".content_invite").slideToggle(300);
    	$(".success_msg").html('');
    });

    $('.invite_form').submit(function(event) {
        var serializeVars = $(this).serialize();
        event.preventDefault();

        $.ajax({
            type: 'POST',
            url: $(this).attr("action"),
            data: {sendInvite: true, formValues : serializeVars},
            dataType: 'json', //text

            // callback handler that will be called on success
            success: function(response, textStatus, jqXHR) {
                if (response.error == true && response.errors) {
                    // Remove all errors
                    $(".invite_form .form_box").removeClass("error");
                    var error_lists = $(".invite_form .form_box").find('ul.error_list');
                    $.each(error_lists, function(index, list) {
                        $(list).remove();
                    });

                    // Set errors
                    $.each(response.errors, function(widget, error) {
                        $(".invite_form ." + widget).addClass('error');
                        $(".invite_form ." + widget).append('<ul class="error_list"><li>' + error + '</li></ul>');
                    });
                    var top = $('.content_invite').offset().top;
    		        $('html,body').scrollTop(top);
                }
                else if (response.success == true) {
                    //$(".content_invite").html(response.message);
                    $(".invite_form .form_box").removeClass("error");
                    var error_lists = $(".invite_form .form_box").find('ul.error_list');
                    $.each(error_lists, function(index, list) {
                        $(list).remove();
                    });
                    $('.content_invite').slideUp(300);

                    $(".success_msg").html(response.message);
                    $(".invite_form input[type=text], .invite_form textarea").val("");
                    $(".invite_form textarea").val(response.body);
                }
            },
            // callback handler that will be called on error
            error: function(jqXHR, textStatus, errorThrown) {
                // log the error to the console
                //console.log("The following error occured: " + textStatus, errorThrown);
            },
            // callback handler that will be called on completion
            // which means, either on success or error
            complete: function(){
            }
        });

        return false;
    });


    $('a.share').live('click', function() {
        var obj = {
            method: 'feed',
            link: 'http://apps.facebook.com/hot-summer-race',
            picture: $("input[name=share_image]").val(),
            name: 'Гореща лятна надпревара',
            caption: 'Спечели два билета за The Wall всяка седмица!',
            description: 'Участвай в надпреварата и спечели два билета за The Wall всяка седмица!'
        };

        FB.ui(obj);
    });


    $('a.invite').click(function() {
        FB.ui({method: 'apprequests',
            message: 'Спечели два билета за The Wall всяка седмица!'
        }, requestCallback);
    });
    /* END FACEBOOK */



    $(".place_items div a").live('click', function(){
        $("input[name=reivew_place]").val($(this).attr('id'));
    });

    $('#search_place').keyup(function(){
        var values = $(this).val();
        var cityId = $('#facebookGame2_location_id').val();

        if(values.length > 2) {
            $('.error_msg').hide();
            $("#PlacesList").css('display', 'block');
            $('.scroll .viewport').css('height', '180px');
            $.ajax({
                url: '<?php echo url_for("facebook/search") ?>',
                data: {'place': values, 'cityId': cityId},
                success: function(data, url) {
                    $("#PlacesList .overview").html(data);
                    $("#PlacesList .overview div div a").each(function() {
                        $(this).html($(this).html().replace(values, '<span>' + values + "</span>"));
                    });
                    $(".scroll").tinyscrollbar_update();
                    if ($('.scroll .overview').outerHeight() < $('.scroll .viewport').outerHeight()) {
                		$('.scroll .viewport').css('height', $('.scroll .overview').outerHeight());
                		$('.place_items').css('width', '680px');
                	}
                }
            });
        }
        else {
        	if ($('.form > div').css('display') == 'none')
        		$('.form').removeClass('form_wrapper');
        	$("#PlacesList").css("display", "none");
        }
    });

    $('#form_close, .place_items a').live('click', function() {
        $("#PlacesList").css('display', 'none');
    });

    $('.input_box input, .input_box textarea').each(function() {
		if($(this).val()) {
			$(this).parent().find('label').hide();
		}
		$(this).focus(function() {
			$(this).parent().find('label').hide();
		}).blur(function() {
			if(!$(this).val())
				$(this).parent().find('label').show();
		});
	});

    $('a#search_city_name').text($('#autocomplete_facebookGame2_location_id').val());
    $('a#search_city_name').click(function() {
            $(this).hide(100);
            $(this).parent().css({top: 0, right: '-10px'});
            $(this).parent().children('input').show(100)
            $(this).parent().children('input').focus();
    });

    $('#autocomplete_facebookGame2_location_id').blur(function() {
        val = $(this).val();

        if ($.trim(val) != '') {
            $(this).parent().children('a').text(val.split(',')[0]);
        }
        else {
            $(this).val($(this).parent().children('a').text());
        }
        $(this).parent().css({top: '9px', right: 0});
        $(this).hide(100);
        $(this).parent().children('a').show(100);
    });

    $('.ac_results').live('mouseup', function(e) {
        $('#search_city_name').text($('.ac_over').text().split(',')[0]);
    });

    $('.scroll').tinyscrollbar();

    $('body').bind('click', function(e) {
        if($(e.target).closest('#dropdown_search').length == 0) {
            $("#PlacesList").css('display', 'none');
        }
    });

    $('.checkbox_list a').click(function() {
        if (!$(this).hasClass('current')) {
	    	$('.checkbox_list input').removeAttr('checked');
			$('#' + $(this).attr('class')).attr('checked', 'checked');
	    	$('.checkbox_list a').removeClass('current');
	    	$(this).addClass('current');
        }
        $('.error_genre').hide();
		return false;
    });
    
  $('ul.first_step.terms li.checkbox').live('click', function() { 
   $(this).toggleClass('unchecked');
   $('input[type=checkbox]').attr("checked", !$('[type=checkbox]').attr("checked"));
});  

    
});
</script>
<?php /*if (isset($do_fb_connect) && $do_fb_connect): ?>
<script type="text/javascript">
    $(document).ready(function () {
        // alert(<?php echo json_encode(url_for('user/FBLogin')) ?>);
        window.top.location.href = <?php echo json_encode(url_for('user/FBLogin')) ?>;
        // .click();
    });
</script>
<?php endif */?>