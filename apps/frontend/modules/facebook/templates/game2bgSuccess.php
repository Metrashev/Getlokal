<?php include_javascripts() ?>
<?php include_stylesheets() ?>
<?php use_stylesheets_for_form($gameForm) ?>
<?php include_partial('company/rating');?>

<?php slot("fb_meta") ?>
    <?php if ($facebookGame->getSlug() == 'getlokal-big-race') : ?>
        <meta property="fb:app_id" content="389933171098747"/>
        <meta property="og:url" content="<?php echo url_for('default', array('module' => 'facebook', 'action' => 'game2bg'), true); ?>" />
        <meta property="og:title" content="Спечели двубоя мъже vs. жени!" />
        <meta property="og:description" content="Участвай в надпреварата кои са по-романтични - жените или мъжете и спечели вечеря за двама и бутилка вино!" />
    <?php elseif ($facebookGame->getSlug() == 'sofia-vs-country') : ?>
        <meta property="fb:app_id" content="139337716231028" />
        <meta property="og:url" content="<?php echo url_for('default', array('module' => 'facebook', 'action' => 'game2bg'), true); ?>" />
        <meta property="og:title" content="Спечели двубоя София vs. страната!" />
        <meta property="og:description" content="Участвай в надпреварата за най-известни забележителности и спечели екскурзия!" />
    <?php elseif ($facebookGame->getSlug() == 'pop-folk-vs-other') : ?>
        <meta property="fb:app_id" content="101255206731369" />
        <meta property="og:url" content="<?php echo url_for('default', array('module' => 'facebook', 'action' => 'game2bg'), true); ?>" />
        <meta property="og:title" content="Спечели двубоя поп-фолк vs. всичко друго!" />
        <meta property="og:description" content="Участвай в надпреварата поп-фолк vs. всичко друго!" />
    <?php endif; ?>
    <meta property="og:type" content="game" />
    <meta property="og:site_name" content="<?php echo $sf_request->getHost() ?>" />
    <meta property="og:image" content="<?php echo public_path('/images/facebook/prizes/bg/game_' . $facebookGame->getId() . '_prize_big.png', true) ?>" />
    <meta property="og:country-name" content="BG" />
<?php end_slot(); ?>

<div class="wrapInner">
	<div class="header">
    	<img src="/images/facebook/prizes/bg/game_<?php echo $facebookGame->getId() ?>_header.png" />
	</div>
	<div class="content">
    	<div class="step1 slide">
    		<img src="/images/facebook/prizes/bg/game_<?php echo $facebookGame->getId() ?>_prize_big.png" />
    		<div class="left_wrap">
                        <?php if ($facebookGame->getSlug() == 'getlokal-big-race') : ?>
                            <h2>Спечели вечеря за двама за Св. Валентин и бутилка вино за Трифон Зарезан</h2>
                            <ul>
				    			<li class="local">Избери най-романтичното място</li>
				    			<li class="msg">Кажи ни защо ти е любимо</li>
				    			<li class="gift">Участвай в надпреварата</li>
                            </ul>
                        <?php elseif ($facebookGame->getSlug() == 'sofia-vs-country') : ?>
                            <h2>Спечели екскурзия до Велико Търново по случай Деня на Освобождението на България 3 март</h2>
                            <ul class="first_step">
                                <li class="local">Избери най-важната забележителност</li>
                                <li class="msg">Кажи с какво е известна</li>
                                <li class="gift">Участвай в надпреварата</li>
                                <?php if ($isFbGame) : ?>
                                	<li class="terms"><span>Съгласен съм с <a href="http://www.getlokal.com/bg/page/terms-of-use" target="_blank">Условията за ползване</a>, <a href="http://www.getlokal.com/bg/page/privacy-policy" target="_blank">Правилата за поверителност</a> и <a href="http://www.getlokal.com/bg/page/rules-bigrace-sofiacountry" target="_blank">Официалните правила на промоцията</a> на getlokal</span></li>
                            	<?php endif; ?>
                            </ul>
                        <?php elseif ($facebookGame->getSlug() == 'pop-folk-vs-other') : ?>
                        	<h2>Спечели 2 билета за DEPECHE MODE</h2>
                            <ul class="first_step">
                                <li class="local">
                                	Отговори на въпросите:
                                	<p>Кой е твоят стил?</p>
                                	<p>Къде се забавляваш?</p>
                                </li>
                                <li class="msg">Напиши ревю и дай своята оценка</li>
                                <li class="gift">Участвай за Наградата</li>
                                <?php if ($isFbGame) : ?>
                                	<li class="terms"><span>Съгласен съм с <a href="http://www.getlokal.com/bg/page/terms-of-use" target="_blank">Условията за ползване</a>, <a href="http://www.getlokal.com/bg/page/privacy-policy" target="_blank">Правилата за поверителност</a> и <a href="http://www.getlokal.com/bg/page/rules-bigrace-pop-folk-vs-other" target="_blank">Официалните правила на промоцията</a> на getlokal</span></li>
                            	<?php endif; ?>
                            </ul>
                        <?php endif; ?>
                            
                        <a href="#" class="button continue">Влез в играта</a>
    		</div>
            <div class="clear"></div>
        </div>

        <div class="step2 slide">
        	<div class="content_in">
                <?php if ($facebookGame->getSlug() == 'getlokal-big-race') : ?>
                    <h2>Кое е най-романтичното място за теб?</h2>
                <?php elseif ($facebookGame->getSlug() == 'sofia-vs-country') : ?>
                    <h2>Избери най-важната забележителност:</h2>
                <?php elseif ($facebookGame->getSlug() == 'pop-folk-vs-other') : ?>
                	<h2>Кой е твоят стил?</h2>
                	<div class="checkbox_list">
	                	<a href="#" class="checkbox_1"></a>
	                	<label for="checkbox_1">Поп-фолк</label>
	                	<a href="#" class="checkbox_2"></a>
	                	<label for="checkbox_2">Друго</label>
	                	
	                	<input id="checkbox_1" name="genre" value="1" type="checkbox" autocomplete="off" />
	                	<input id="checkbox_2" name="genre" value="2" type="checkbox" autocomplete="off" />
	                	<div class="clear"></div>
	                	<p class="error_genre error_msg" style="display: none">Избери стил!</p>
                	</div>
                    <h2>Къде се забавляваш?</h2>
                <?php endif; ?>

                    <div id="dropdown_search">
	                <div class="form_search">
	                    <div class="form_box input_box">
	                        <label for="search_place">Кликни, за да избереш място</label>
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
	        </div>

            <div class="form">
            	<div>
	                <?php if ($facebookGame->getSlug() == 'getlokal-big-race') : ?>
	                    <h2>Кажи ни защо ти е любимо?</h2>
	                <?php elseif ($facebookGame->getSlug() == 'sofia-vs-country') : ?>
	                    <h2>Напиши с какво е известна и дай своята оценка?</h2>
	                <?php elseif ($facebookGame->getSlug() == 'pop-folk-vs-other') : ?>
	                    <h2>Напиши ревю и дай своята оценка</h2>
	                <?php endif; ?>
	
	                <input type="text" name="reivew_place" value="" style="display: none; visibility: hidden" />
	               	<div class="input_wrap">
	                	<label>Оценка</label>
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
	                            <?php if ($facebookGame->getSlug() == 'getlokal-big-race') : ?>
	                                <label for="review">Ревю</label>
	                                <textarea id="review" name="review" autocomplete="off"></textarea>
	                                <p class="error_review error_msg" style="display: none">Ревюто трябва да съдържа поне 5 символа!</p>
	                            <?php elseif ($facebookGame->getSlug() == 'sofia-vs-country') : ?>
	                                <label for="review">С какво е известна</label>
	                                <textarea id="review" name="review" autocomplete="off"></textarea>
	                                <p class="error_review error_msg" style="display: none">Полето "С какво е известна" трябва да съдържа поне 5 символа!</p>
	                            <?php elseif ($facebookGame->getSlug() == 'pop-folk-vs-other') : ?>
	                                <label for="review">Ревю</label>
	                                <textarea id="review" name="review" autocomplete="off"></textarea>
	                                <p class="error_review error_msg" style="display: none">Ревюто трябва да съдържа поне 5 символа!</p>
	                            <?php endif; ?>
		           	</div>
		            <a href="#" class="button continue">Продължи</a>
		            <p>Моля пишете на кирилица, без обидни и нецензурни изрази.</p>
	       		</div>
	        </div>

	    </div>

        <div class="step3 slide">
                <input type="hidden" value="" name="share_image" style="display: none !important; visibility: none !important;" />

        	<div class="content_in">
        		<div class="left_wrap">
                        <?php if ($facebookGame->getSlug() == 'getlokal-big-race') : ?>
                            <h2>Кои са по-романтични - мъжете или жените?</h2>
                        <?php elseif ($facebookGame->getSlug() == 'sofia-vs-country') : ?>
                            <h2>Най-важната забележителност – резултати до сега:</h2>
                        <?php elseif ($facebookGame->getSlug() == 'pop-folk-vs-other') : ?>
                            <h2>Поп-фолк vs. всичко друго – резултати до сега:</h2>
                        <?php endif; ?>
		            
	                <div class="final_results"><img src="/images/gui/loading.gif" /></div>
                </div>
                <div class="right_wrap">
                	<?php if ($isFbGame): ?>
                            <a href="#" class="invite button">Покани приятел</a>
                            <a href="#" class="share button">Сподели на стената</a>
                            <!-- <div class="play_again" style="margin-top:50px;"> -->
                        <?php else: ?>
                            <a href="#" class="invite button_facebook"><span>f</span>Покани</a>
                            <a href="#" class="share button_facebook"><span>f</span>Сподели</a>

                            <a href="javascript:;" class="invite_email button button_email">Покани с email</a>
                            <?php include_partial('inviteViaEmail', array('sendInvitePMForm' => $sendInvitePMForm, 'url' => $inviteFromMailUrl)); ?>
                            <!-- <div class="play_again"> -->
                        <?php endif; ?>
                            
                        <div class="clear"></div>

                        <div class="play_again">
                            <a href="<?php echo url_for('facebook/game2bg') ?>" class="button">Играй отново и спечели</a>
                            <img src="/images/facebook/prizes/bg/game_<?php echo $facebookGame->getId() ?>_prize_small.png" />
                            <div class="clear"></div>
                        </div>

	        	</div>
		        <div class="clear"></div>
	        </div>
        </div>
	</div>

	<div class="footer">
        <a href="<?php echo url_for('@homepage', array(), true); ?>" target="_blank"><img src="<?php echo public_path('/images/facebook/v3/bg/icon_e.png', true) ?>" /></a>
        <a href="<?php echo url_for('facebook/game2bg', array(), true) ?>">Начало</a>
         <?php if ($facebookGame->getSlug() == 'sofia-vs-country') : ?>
         	<a href="<?php echo url_for('static_page', array('slug' => 'rules-bigrace-sofiacountry')) ?>" target="_blank">Правила на играта</a>
         <?php elseif ($facebookGame->getSlug() == 'pop-folk-vs-other') : ?>
           	<a href="<?php echo url_for('static_page', array('slug' => 'rules-bigrace-pop-folk-vs-other')) ?>" target="_blank">Правила на играта</a>
         <?php endif;?>
         
            <?php if (isset($games) && count($games)) : ?>
                <a href="<?php echo url_for('facebook/game2bg', array(), true) . '?type=winners' ?>">Победители</a>
                <a href="<?php echo url_for('facebook/game2bg', array(), true) . '?type=results' ?>">Резултати</a>
                <?php /*<a href="<?php echo url_for('facebook/game2bg', array(), true) . '?type=awards' ?>">Награди</a>*/ ?>
            <?php endif; ?>
	</div>
</div>

<div id="fb-root"></div>
<script src="//connect.facebook.net/en_US/all.js"></script>


<script type="text/javascript">
<?php if ($facebookGame->getSlug() == 'getlokal-big-race') : ?>
    FB.init({
        appId : '389933171098747',
        frictionlessRequests: true,

        status: true,
        cookie: true,
        oauth: true,
        xfbml: true
    });

    FB.Canvas.setAutoGrow(200);
    FB.Canvas.scrollTo(0,0);
<?php elseif ($facebookGame->getSlug() == 'sofia-vs-country') : ?>
    FB.init({
        appId : '139337716231028',
        frictionlessRequests: true,

        status: true,
        cookie: true,
        oauth: true,
        xfbml: true
    });

    FB.Canvas.setAutoGrow(200);
    FB.Canvas.scrollTo(0,0);
<?php elseif ($facebookGame->getSlug() == 'pop-folk-vs-other') : ?>
    FB.init({
        appId : '101255206731369',
        frictionlessRequests: true,

        status: true,
        cookie: true,
        oauth: true,
        xfbml: true
    });

    FB.Canvas.setAutoGrow(200);
    FB.Canvas.scrollTo(0,0);
<?php endif; ?>

function requestCallback(response) {
  // Handle callback here
}

$(document).ready(function() {
	
	function myLoop () {
		setTimeout(function () {
			$('.step1').css('height', $('.step1 > img').outerHeight());
			if ($('.step1 > img').outerHeight() < 1)
				myLoop();
		}, 300);
	}
	myLoop();
	
	<?php if (!$isFbGame) : ?>
		$('html').css('background', 'url("../images/gui/bg.gif") repeat scroll 0 0 #E9E1D4')
	<?php endif;?>
	
    var max_steps = 3;
    var _step = 1;

    $('.slide .continue').click(function () {
        if (_step == 2) {
            var hasError = false;
				
            if ($('input[name="reivew_place"]').val() == 'undefiled' || $('input[name="reivew_place"]').val() == '') {
                $(".error_place").show();
                hasError = true;
            }
            else {
                $(".error_place").hide();

                if ($("input.star:checked").val() == undefined || $("input.star:checked").val() < 1 || $("input.star:checked").val() > 5) {
                    $(".error_rating").show();
                    hasError = true;
                }
                else {
                    $("span.error_rating").hide();
                }

                if ($('textarea[name="review"]').val() == undefined || $('textarea[name="review"]').val().length < 5) {
                    $(".error_review").show();
                    hasError = true;
                }
                else {
                    $(".error_review").hide();
                }
            }

			if ($('input[name="genre"]:checked').val() == undefined) {
				 $(".error_genre").show();
                 hasError = true;
			}

            if (hasError) {
                return false;
            }

            $.post('<?php echo url_for('default', array('module' => 'facebook', 'action' => 'game2bg'), true) ?>', { save: true, review_place: $('input[name="reivew_place"]').val(), review_stars: $("input.star:checked").val(), review_text: $('textarea[name="review"]').val(), genre: $('input[name="genre"]:checked').val() }, function(data) {
                if (data) {
                    if (data.error != undefined && data.error == true) {
                        location.href = '<?php echo url_for('facebook/game2bg'); ?>';
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
                            results = results + '<div class="result_wrap"><span>' + param1 + '</span><div class="result_bar"><div class="' + scnd + '" style="width:' + param2 + '%"></div></div><span class="blue"><img src="/images/gui/bg_vote.gif" />' + param2 + '%</span><div class="clear"></div></div>';
                        });

                        results = results + '<div class="total_votes"><p>Общо до момента: <span class="blue">' + data.total + ' гласа</span></p></div>';
                        $(".final_results").html(results);
                    }
                }
            }, 'json');
        }

        _step++;
        $('.slide').hide();
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

    /* FACEBOOK */
    <?php /*
    $('a.share').live('click', function() {
      FB.ui({
        method: 'stream.publish',
        message: 'Сподели с приятели парти името си!',
        attachment: {
          name: 'getlokal те предизвиква!',
          description: (
            'Участвай в надпреварата кои са по-романтични - жените или мъжете и спечели вечеря за двама и бутилка вино!'
          ),
          href: 'http://apps.facebook.com/getlokal-big-race',
          media: [
            {
              type: 'image',
              href: '<?php echo $shareImg ?>',
              src: '<?php echo $shareImg ?>'

              <?php 
              //href: $("input[name=share_image]").val(),
              //src: $("input[name=share_image]").val() 
              ?>
            }
          ]
        },
        action_links: [
          { text: 'fbrell', href: 'http://apps.facebook.com/getlokal-big-race' }
        ],
        user_prompt_message: 'Сподели с приятели'
      });
    });
*/ ?>


<?php if ($facebookGame->getSlug() == 'getlokal-big-race') : ?>
    $('a.share').live('click', function() {
        var obj = {
            method: 'feed',
            link: 'http://apps.facebook.com/getlokal-big-race',
            picture: $("input[name=share_image]").val(),
            name: 'getlokal те предизвиква!',
            caption: 'Спечели двубоя мъже vs. жени!',
            description: 'Участвай в надпреварата кои са по-романтични - жените или мъжете и спечели вечеря за двама и бутилка вино!'
        };

        FB.ui(obj);
    });


    $('a.invite').click(function() {
        FB.ui({method: 'apprequests',
            message: 'Спечели в двубоя мъже vs. жени!'
        }, requestCallback);
    });
    /* END FACEBOOK */
<?php elseif ($facebookGame->getSlug() == 'sofia-vs-country') : ?>
    $('a.share').live('click', function() {
        var obj = {
            method: 'feed',
            link: 'http://apps.facebook.com/sofia-vs-country',
            picture: $("input[name=share_image]").val(),
            name: 'getlokal те предизвиква!',
            caption: 'Спечели двубоя София vs. страната!',
            description: 'Участвай в надпреварата за най-известни забележителности и спечели екскурзия!'
        };

        FB.ui(obj);
    });


    $('a.invite').click(function() {
        FB.ui({method: 'apprequests',
            message: 'Играй за София или страната!'
        }, requestCallback);
    });
    /* END FACEBOOK */
<?php elseif ($facebookGame->getSlug() == 'pop-folk-vs-other') : ?>
    $('a.share').live('click', function() {
        var obj = {
            method: 'feed',
            link: 'http://apps.facebook.com/pop-folk-vs-other',
            picture: $("input[name=share_image]").val(),
            name: 'getlokal те предизвиква!',
            caption: 'Спечели 2 билета за Depeche Mode!',
            description: 'Участвай в надпреварата поп-фолк vs. всичко друго!'
        };

        FB.ui(obj);
    });


    $('a.invite').click(function() {
        FB.ui({method: 'apprequests',
            message: 'Спечели 2 билета за Depeche Mode!'
        }, requestCallback);
    });
    /* END FACEBOOK */
<?php endif; ?>



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
});
</script>