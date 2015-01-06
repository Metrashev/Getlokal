<?php //include_javascripts() ?>
<?php //include_stylesheets() ?>
<?php use_stylesheets_for_form($gameForm) ?>
<?php include_partial('company/rating');?>

<?php slot("fb_meta") ?>
<?php if ($facebookGame->getSlug() == 'big-race-ro') : ?>
    <meta property="fb:app_id" content="394728430634966" />
    <meta property="og:url" content="<?php echo url_for('default', array('module' => 'facebook', 'action' => 'game2ro'), true); ?>" />
    <meta property="og:title" content="Unde te distrezi cel mai tare?" />
    <meta property="og:description" content="Spune-ne unde te distrezi cel mai tare - în București sau în provincie. Getlokal.ro te premiază și face harta distracției!" />
<?php elseif ($facebookGame->getSlug() == 'bere-vs-vin') : ?>
    <meta property="fb:app_id" content="525540210839584" />
    <meta property="og:url" content="<?php echo url_for('default', array('module' => 'facebook', 'action' => 'game2ro'), true); ?>" />
    <meta property="og:title" content="Ce bei mai des?" />
    <meta property="og:description" content="Spune-ne ce bei mai des - bere sau vin? getlokal.ro te premiază!" />
<?php endif; ?>
    <meta property="og:type" content="game" />
    <meta property="og:site_name" content="<?php echo $sf_request->getHost() ?>" />
    <meta property="og:image" content="<?php echo public_path('/images/facebook/prizes/ro/game_' . $facebookGame->getId() . '_prize_big.png', true) ?>" />
    <meta property="og:country-name" content="RO" />
<?php end_slot(); ?>

<div class="wrapInner">

<?php if ($facebookGame->getSlug() == 'big-race-ro') : ?>
    <div class="header">
		<img src="/images/facebook/prizes/ro/game_<?php echo $facebookGame->getId() ?>_header.png" />
    </div>
<?php elseif ($facebookGame->getSlug() == 'bere-vs-vin') : ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.wrapInner').css('width', '990px');
            $('.wrapInner > div.content ').css('top', '220px');
            $('.wrapInner > div.content ').css('border-top', '10px solid #6ec0c1');
            $('.footer').css('top', '220px');
          });

    </script>
    <div class="big_bg_image">
        <img src="/images/facebook/prizes/ro/game_<?php echo $facebookGame->getId() ?>_header.png" />
    </div>
	<div class="game_title">
      <h1>Ce bei mai des?</h1>
    </div>
<?php endif; ?>

    <div class="content">
        <!-- step 1 -->
        <div class="step1 slide">
            <img src="/images/facebook/prizes/ro/game_<?php echo $facebookGame->getId() ?>_prize_big.png" />
            <div class="left_wrap">
					<?php if ($facebookGame->getSlug() == 'big-race-ro') : ?>
                        <h2>Răspunde şi câştigă un aparat foto!</h2>
                        <ul class="first_step">
                            <li class="local">
                                    Raspunde la intrebarea:
                                    <p>Unde se distrează românii mai bine?</p>
                                   <!-- <p>Къде се забавляваш?</p>-->
                            </li>
                            <li class="msg">Scrie un review pentru cel mai tare loc de party şi participă.</li>
                            <li class="gift">Ia-ne premiul!</li>
					<?php elseif ($facebookGame->getSlug() == 'bere-vs-vin') : ?>
						<h2>Răspunde şi câştigă un iPad 2!</h2>
                        <ul class="first_step">
                            <li class="local">
                                    Răspunde la întrebarea
                                    <p>Ce bei mai des - bere sau vin?</p>
                                   <!-- <p>Къде се забавляваш?</p>-->
                            </li>
                            <li class="msg">Scrie un review pentru un loc în care ai băut o bere bună sau un vin bun.</li>
                            <li class="gift">Ia-ne premiul!</li>
					<?php endif; ?>
                            <?php if ($isFbGame) : ?>
                                     <li><span>Prin folosirea acestei aplicații îți dai acordul de a deveni utilizator getlokal.ro, acceptând <a href="http://www.getlokal.ro/ro/page/terms-of-use" target="_blank">termenii și condițiile</a> de utilizare ale site-ului.</span></li>
                            <?php endif; ?>
                        </ul>

                   <div class="left interaction">
                            <?php if (!$sf_user->isAuthenticated()) : ?>
                                <a href="<?php echo url_for('@sf_guard_signin', array(), true) ?>" id="login" title="<?php echo __('Login or Register', null, 'facebookgame') ?>" class="button"><span><span><span><?php echo __('Login or Register', null, 'facebookgame') ?></span></span></span></a>
				<a href="<?php echo url_for('user/FBLogin')?>" title="<?php echo __('Facebook Connect', null, 'facebookgame') ?>" class="button_fb_connect"><?php echo __('<span>f</span> Connect', null, 'facebookgame') ?></a>

                            <?php else : ?>
				<a href="#" class="button continue">Start</a>
                            <?php endif; ?>
	                </div>
            </div>
            <div class="clear"></div>
        </div>
        <!-- step 2 -->
        <div class="step2 slide">
            <div class="content_in">
			<?php if ($facebookGame->getSlug() == 'big-race-ro') : ?>
                    <h2>Unde au loc cele mai tari party-uri?</h2>
                    <div class="checkbox_list">
                        <a href="#" class="checkbox_1"></a>
                        <label for="checkbox_1">Bucureşti</label>
                        <a href="#" class="checkbox_2"></a>
                        <label for="checkbox_2">provincie</label>

                        <input id="checkbox_1" name="genre" value="1" type="checkbox" autocomplete="off" />
                        <input id="checkbox_2" name="genre" value="2" type="checkbox" autocomplete="off" />
                        <div class="clear"></div>
                        <p class="error_genre error_msg" style="display: none">Selectati o optiune!</p>
                    </div>
                    <h2 style="margin-bottom: 20px;">Alege locul în care se întâmplă cele mai tari petreceri!
scrie primele litere din numele locului şi alege din listă/ alege un oraş </h2><!--<small>
*dacă locul pe care îl cauţi nu există în baza noastră de date, completează formularul de <a href="http://www.getlokal.ro/ro/d/company/addCompany">aici</a> şi va fi adăugat în scurt timp!</small>--></h2>
			<?php elseif ($facebookGame->getSlug() == 'bere-vs-vin') : ?>
					<h2>Ce bei mai des?</h2>
                    <div class="checkbox_list">
                        <a href="#" class="checkbox_1"></a>
                        <label for="checkbox_1">bere</label>
                        <a href="#" class="checkbox_2"></a>
                        <label for="checkbox_2">vin</label>

                        <input id="checkbox_1" name="genre" value="1" type="checkbox" autocomplete="off" />
                        <input id="checkbox_2" name="genre" value="2" type="checkbox" autocomplete="off" />
                        <div class="clear"></div>
                        <p class="error_genre error_msg" style="display: none">Selectati o optiune!</p>
                    </div>
                    <h2 style="margin-bottom: 20px;">Alege barul sau pub-ul în care ai băut ultima oară o bere bună sau un vin bun!</h2>
			<?php endif; ?>

                    <div id="dropdown_search">
                    <div class="form_search">
                        <div class="form_box input_box">
                            <label for="search_place">Scrie aici primele litere ale localului pe care îl cauţi...</label>
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

				<p>Exemple: Carul cu Bere, The Vault, Expirat, etc.</p>
                <p class="error_place error_msg" style="display: none">Selectați un loc!</p>

                <p class="search_result"></p>
            </div>
            <!-- Form with background -->
            <div class="form">
                <div>
                        <h2>Scrie un review despre loc - ce ţi-a plăcut cel mai mult (muzica, oamenii, atmosfera)</h2>

                    <input type="text" name="reivew_place" value="" style="display: none; visibility: hidden" />
                    <div class="input_wrap">
                        <label>Evaluare</label>
                        <ul class="radio_list">
                            <li><input autocomplete="off" title="<?php echo __('Poor'); ?>" name="review[rating]" type="radio" value="1" id="review_rating_1" class="star">&nbsp;<label for="review_rating_1"></label></li>
                            <li><input autocomplete="off" title="<?php echo __('Average'); ?>" name="review[rating]" type="radio" value="2" id="review_rating_2" class="star">&nbsp;<label for="review_rating_2"></label></li>
                            <li><input autocomplete="off" title="<?php echo __('Good'); ?>" name="review[rating]" type="radio" value="3" id="review_rating_3" class="star">&nbsp;<label for="review_rating_3"></label></li>
                            <li><input autocomplete="off" title="<?php echo __('Very good'); ?>" name="review[rating]" type="radio" value="4" id="review_rating_4" class="star">&nbsp;<label for="review_rating_4"></label></li>
                            <li><input autocomplete="off" title="<?php echo __('Excellent'); ?>" name="review[rating]" type="radio" value="5" id="review_rating_5" class="star">&nbsp;<label for="review_rating_5"></label></li>
                        </ul>
                        <div class="clear"></div>
                        <p class="error_rating error_msg" style="display: none">Vă rugăm să oferiți o evaluare!</p>
                    </div>
                            <div class="input_wrap">
                                    <label for="review">Recomandare</label>
                                    <textarea id="review" name="review" autocomplete="off">Scrie ca şi cum ai povesti unui prieten! De exemplu: Mi-a plăcut mult muzica - am încercat berea nefiltrată (şi vinul casei) - totul a fost super gustos! Ca să intri în concurs, scrie minim 100 de caractere!</textarea>
                                    <p class="error_review error_msg" style="display: none">Pentru a participa în concurs, recomandarea ta trebuie să aibă minim 100 de caractere.</p>
                    </div>
                    <a href="#" class="button continue">Continuă</a>
                    <p>Suntem mari fani ai bunului simţ, aşa că te rugăm să păstrezi decenţa în exprimare.</p>
                </div>
            </div>

        </div>
        <!-- Step 3 -->
        <div class="step3 slide">
                <input type="hidden" value="" name="share_image" style="display: none !important; visibility: none !important;" />

            <div class="content_in">
                <div class="left_wrap">
				<?php if ($facebookGame->getSlug() == 'big-race-ro') : ?>
                        <h2>Bucureşti vs. provincia – rezultate pană acum</h2>
				<?php elseif ($facebookGame->getSlug() == 'bere-vs-vin') : ?>
						<h2>Bere vs. vin - rezultatele de până acum</h2>
				<?php endif ; ?>

                    <div class="final_results"><img src="/images/gui/loading.gif" /></div>
                </div>
                <div class="right_wrap">
                    <h2>Invită-ţi prietenii să participe prin facebook, e-mail sau postează pe wall</h2>
                            <a href="#" class="invite button_facebook"><span>f</span>Invită</a>
                            <a href="#" class="share button_facebook"><span>f</span>Postează</a>

                            <a href="javascript:;" class="invite_email button button_email">Invită prin mail</a>
                            <?php include_partial('inviteViaEmail', array('sendInvitePMForm' => $sendInvitePMForm, 'url' => $inviteFromMailUrl)); ?>
                            <!-- <div class="play_again"> -->

                        <div class="clear"></div>

                        <div class="play_again">
                            <a href="<?php echo url_for('facebook/game2ro') ?>" class="button play_again_bttn">Joacă din nou</a>
                           <!-- <img src="/images/facebook/prizes/ro/game_<?php echo $facebookGame->getId() ?>_prize_small.png" /> -->
                            <div class="clear"></div>
                        </div>

                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>

    <div class="footer">
        <a href="<?php echo url_for('@homepage', array(), true); ?>" target="_blank">Acasă</a>
        <a href="<?php echo url_for('facebook/game2ro', array(), true) ?>">Start joc</a>
	    <?php if ($facebookGame->getSlug() == 'big-race-ro') : ?>
			<a href="<?php echo url_for('static_page', array('slug' => 'reguli-bucuresti-vs-provincia')) ?>" target="_blank">Reguli de joc</a>
		<?php elseif ($facebookGame->getSlug() == 'bere-vs-vin') : ?>
			<a href="<?php echo url_for('static_page', array('slug' => 'reguli-bere-vs-vin')) ?>" target="_blank">Reguli de joc</a>
		<?php endif; ?>

            <?php if (isset($games) && count($games)) : ?>
                <a href="<?php echo url_for('facebook/game2ro', array(), true) . '?type=winners' ?>">Castigatori</a>
                <a href="<?php echo url_for('facebook/game2ro', array(), true) . '?type=results' ?>">Rezultate</a>
                <?php /*<a href="<?php echo url_for('facebook/game2', array(), true) . '?type=awards' ?>">Награди</a>*/ ?>
            <?php endif; ?>
    </div>
 <div class="clear"></div>
</div>
<div id="fb-root"></div>
<script src="//connect.facebook.net/en_US/all.js"></script>


<script type="text/javascript">
<?php if ($facebookGame->getSlug() == 'big-race-ro') : ?>
FB.init({
    appId : '394728430634966',
    frictionlessRequests: true,

    status: true,
    cookie: true,
    oauth: true,
    xfbml: true
});

FB.Canvas.setAutoGrow(200);
FB.Canvas.scrollTo(0,0);
<?php elseif ($facebookGame->getSlug() == 'bere-vs-vin') : ?>
FB.init({
    appId : '525540210839584',
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
    if($('textarea[name="review"]').val() === 'Scrie ca şi cum ai povesti unui prieten! De exemplu: Mi-a plăcut mult muzica - am încercat berea nefiltrată (şi vinul casei) - totul a fost super gustos! Ca să intri în concurs, scrie minim 100 de caractere!')
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

                if ($('textarea[name="review"]').val() == undefined || $('textarea[name="review"]').val().length < 100 || $('textarea[name="review"]').val() ==='Scrie ca şi cum ai povesti unui prieten! De exemplu: Mi-a plăcut mult muzica - am încercat berea nefiltrată (şi vinul casei) - totul a fost super gustos! Ca să intri în concurs, scrie minim 100 de caractere!' ){
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

            $.post('<?php echo url_for('default', array('module' => 'facebook',
                                                        'action' => 'game2ro'), true) ?>',
            {
              save: true,
              review_place: $('input[name="reivew_place"]').val(),
              review_stars: $("input.star:checked").val(),
              review_text: $('textarea[name="review"]').val(),
              genre: $('input[name="genre"]:checked').val()
            },

            function(data) {
                if (data) {
                    if (data.error != undefined && data.error == true) {
                        location.href = '<?php echo url_for('facebook/game2ro'); ?>';
                    }
                     else if (data.error == false) {
                        var iterations = 0;
                        var results = '';

                        $("input[name=share_image]").val(data.image);

                        $.each(data.result, function(param1, param2) {
                            iterations++;
                            var scnd="";
                            if (iterations < 3) {
                            if ((iterations % 2) == 0)
                                scnd='second';
                                results = results + '<div class="result_wrap"><span>' + param1 + '</span><div class="result_bar"><div class="' + scnd + '" style="width:' + param2 + '%"></div></div><span class="blue"><img src="/images/gui/bg_vote.gif" />' + param2 + '%</span><div class="clear"></div></div>';
                            }
                        });

                        results = results + '<div class="total_votes"><p>Total: <span class="blue">' + data.total + ' voturi</span></p></div>';
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


<?php if ($facebookGame->getSlug() == 'big-race-ro') : ?>
    $('a.share').live('click', function() {
        var obj = {
            method: 'feed',
            link: 'http://apps.facebook.com/big-race-ro',
            picture: $("input[name=share_image]").val(),
            name: 'Participă și tu la dezbaterea București vs Provincie și câștigă un aparat foto Nikon Coolpix L310',
            caption: 'Tu vrei să știi unde se distrează cel mai bine românii?',
            description: 'Eu am spus unde îmi place să ma distrez în aplicația getlokal.ro București vs Provincie - participă și tu!'
        };

        FB.ui(obj);
    });


    $('a.invite').click(function() {
        FB.ui({method: 'apprequests',
            message: 'Castiga un aparat foto!'
        }, requestCallback);
    });
    /* END FACEBOOK */
<?php elseif ($facebookGame->getSlug() == 'bere-vs-vin') : ?>
    $('a.share').live('click', function() {
        var obj = {
            method: 'feed',
            link: 'http://apps.facebook.com/bere-vs-vin',
            picture: $("input[name=share_image]").val(),
            name: 'Participă și tu la dezbaterea Bere vs. vin și câștigă un iPad2!',
            caption: 'Vrei să ştii ce beau românii mai des - bere sau vin?',
            description: 'Bere sau vin? Eu am votat şi-am scris şi unde ies cel mai des :) Încearcă şi tu aplicaţia getlokal.ro Bere vs. vin!'
        };

        FB.ui(obj);
    });


    $('a.invite').click(function() {
        FB.ui({method: 'apprequests',
            message: 'Câştigă un iPad 2!'
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
                url: '<?php echo url_for("facebook/searchro") ?>',
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
<?php if (isset($do_fb_connect) && $do_fb_connect): ?>
<script type="text/javascript">
    $(document).ready(function () {
        // alert(<?php echo json_encode(url_for('user/FBLogin')) ?>);
        window.top.location.href = <?php echo json_encode(url_for('user/FBLogin')) ?>;
        // .click();
    });
</script>
<?php endif ?>
