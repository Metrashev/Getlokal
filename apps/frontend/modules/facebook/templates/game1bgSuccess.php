<div class="wrapInner">
    <form action="<?php echo url_for('facebook/game1bg') ?>" method="post">
            <div class="step1 slide">
                    <a class="rules" href="http://www.getlokal.com/bg/page/promo-rules#party_name" target="_blank">Правила на играта</a>
                    <p>Здравей, <?php echo $sf_user->getProfile()->getFirstName(); ?></p>
                    <div class="user_img_wrap">
                            <img src="<?php echo public_path('uploads/' . $userImageFileName, true) ?>" />
                            <img class="mask" src="/images/facebook/v1/bg/bg_image_welcome.png" />
                    </div>
                    <div class="drinks_wrap">
                            <a class="a0" val="0" href="#"><img src="/images/facebook/v1/bg/a0.png" /></a>
                            <a class="a1" val="1" href="#"><img src="/images/facebook/v1/bg/a1.png" /></a>
                            <a class="a2" val="2" href="#"><img src="/images/facebook/v1/bg/a2.png" /></a>
                            <a class="a3" val="3" href="#"><img src="/images/facebook/v1/bg/a3.png" /></a>
                            <a class="a4" val="4" href="#"><img src="/images/facebook/v1/bg/a4.png" /></a>
                    </div>
                    <input type="hidden" id="q1" name="q1" />
            </div>

            <div class="step2 slide">
                    <div class="user_img_wrap">
                            <img src="<?php echo public_path('uploads/' . $userImageFileName, true) ?>" />
                            <img class="mask" src="/images/facebook/v1/bg/bg_image.png" />
                    </div>
                    <div class="left_wrap">
                            <p><span><?php echo $sf_user->getProfile()->getFirstName(); ?></span>,<br/> ти пиеш:</p>
                            <div class="drink_wrap"><div></div></div>
                            <img class="question_number" src="/images/facebook/v1/bg/question_1.png" />
                            <span>Отговори на въпросите за да разбереш какво е твоето парти име!</span>
                    </div>
                    <div class="right_wrap">
                            <a class="rules" href="http://www.getlokal.com/bg/page/promo-rules#party_name" target="_blank">Правила на играта</a>
                            <div class="right_content">
                                    <p>Кажи сега, коя е любимата ти музика?</p>
                        <div class="radio">
                            <?php foreach (array('Рок', 'Инди', 'Ретро', 'Дъбстеп', 'Пънк', 'Не танцувам') as $i => $name): ?>
                                <label>
                                    <span class="check"><input type="radio" name="q2" value="<?php echo $i ?>" /></span><?php echo $name ?>
                                </label>
                            <?php endforeach ?>
                            <div class="clear"></div>
                        </div>
                            <span class="error"></span>
                            <a href="#" class="button button_big continue">Продължи</a>
                </div>
                    </div>
        </div>

            <div class="step3 slide">
                    <div class="user_img_wrap">
                            <img src="<?php echo public_path('uploads/' . $userImageFileName, true) ?>" />
                            <img class="mask" src="/images/facebook/v1/bg/bg_image.png" />
                    </div>
                    <div class="left_wrap">
                            <p><span><?php echo $sf_user->getProfile()->getFirstName(); ?></span>,<br/> ти пиеш:</p>
                            <div class="drink_wrap"><div></div></div>
                            <img class="question_number" src="/images/facebook/v1/bg/question_2.png" />
                            <span>Отговори на въпросите за да разбереш какво е твоето парти име!</span>
                    </div>
                    <div class="right_wrap">
                            <a class="rules" href="http://www.getlokal.com/bg/page/promo-rules#party_name" target="_blank">Правила на играта</a>
                            <div class="right_content">
                                    <p>Напиши, кое е любимото ти заведение?</p>
                        <div class="input_wrap"><input type="text" name="q3" /></div>
                    <input type="hidden" name="q3_id" id="q3" value="" />
                            <span class="error"></span>
                            <a href="#" class="button button_big continue">Продължи</a>
                </div>
                    </div>
        </div>

        <div class="step4 slide">
                    <div class="user_img_wrap">
                            <img src="<?php echo public_path('uploads/' . $userImageFileName, true) ?>" />
                            <img class="mask" src="/images/facebook/v1/bg/bg_image.png" />
                    </div>
                    <div class="left_wrap">
                            <p><span><?php echo $sf_user->getProfile()->getFirstName(); ?></span>,<br/> ти пиеш:</p>
                            <div class="drink_wrap"><div></div></div>
                    </div>
                    <div class="right_wrap">
                            <div class="right_content">
                                    <p>Докато кажеш "купон" ще сме готови!</p>
                </div>
                    </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var max_steps = 4;
        _step = 1;
        $('.slide').hide();
        $('.step'+ _step).show();

        $('.drinks_wrap a').click(function() {
       	 	_step++;
	         $('.slide').hide();
	         $('.step'+ _step).show();
			$('.step2 .drink_wrap div').addClass($(this).attr('class'));
			$('.step3 .drink_wrap div').addClass($(this).attr('class'));
			$('.step4 .drink_wrap div').addClass($(this).attr('class'));
			$('#q1').val($(this).attr('val'));
			return false;
        })
  
        $('form').submit(function() {
            if(_step != max_steps)
            {
                _step++;
                $('.slide').hide();
                $('.step'+ _step).show();
                return false;
            }
        })
  
        $( ".step3 input" ).autocomplete({
            source: "<?php echo url_for('facebook/autocomplete') ?>",
            minLength: 2,
            select: function( event, ui ) {
                $('#q3').val(ui.item.id);
            }
        });
  
        $('.slide .check').click(function() {
            $(this).parent().parent().find('input').removeAttr('checked');
            $(this).parent().parent().find('.check').removeClass('active');
            $(this).addClass('active');
            $(this).find('input').attr('checked', 'checked');
        });
  
        $('.slide .continue').click(function () {
            if (_step == 2 && !$(".step" + _step + " input[type='radio']:checked").val()) {
                $(this).parent().find('.error').html('Моля изберете едно от предлагани значения!');
                return false;
            }

            if (_step == 3 && !$(".step" + _step + " input[type='text']").val()) {
                $(this).parent().find('.error').html('Моля въведете името на заведение!');
                return false;
            }

            _step++;
            $('.slide').hide();
            $('.step'+ _step).show();
 
            if(_step == max_steps)
            {
                $('form').submit();
            }

            return false;
        });
    });
</script>