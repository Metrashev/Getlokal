<?php //include_javascripts() ?>
<?php //include_stylesheets() ?>
<?php /* use_stylesheets_for_form($gameForm) */ ?>


<?php slot("fb_meta") ?>
    <?php if ($culture == 'bg') : ?>
        <meta property="fb:app_id" content="590322517647631" />
    <?php elseif($culture == 'mk') : ?>
        <meta property="fb:app_id" content="590322517647631" />
    <?php elseif ($culture == 'sr') : ?>
        <meta property="fb:app_id" content="590322517647631" />
    <?php endif; ?>

    <meta property="og:url" content="<?php echo url_for('default', array('module' => 'facebook', 'action' => 'game3'), true); ?>" />

    <meta property="og:title" content="<?php echo __('Win an iPhone5!', null, 'facebookgame')?>" />
    <meta property="og:description" content="Покани трима приятели и спечели iPhone5!" />

    <meta property="og:type" content="game" />
    <meta property="og:site_name" content="<?php echo $sf_request->getHost() ?>" />
    <meta property="og:image" content="<?php echo public_path('/images/facebook/prizes/' . $culture . '/game_' . $facebookGame->getId() . '_prize_big.png', true) ?>" />
    <meta property="og:country-name" content="<?php echo strtoupper($culture) ?>" />
<?php end_slot(); ?>

<?php if ($culture == 'bg') : ?>
    <?php $homepageUrl = 'http://apps.facebook.com/lucky-three-bg'; ?>
<?php elseif($culture == 'mk') : ?>
    <?php $homepageUrl = 'http://apps.facebook.com/lucky-three-mk'; ?>
<?php elseif ($culture == 'sr') : ?>
    <?php $homepageUrl = 'http://apps.facebook.com/lucky-three-sr'; ?>
<?php endif; ?>

<?php if (!$fromFacebookGame) : ?>
    <?php $homepageUrl = url_for('facebook/game3'); ?>
<?php endif; ?>
    
<?php $siteUrl = url_for('homepage', array(), true); ?>
<div class="wrap">
	<div class="wrapInner">
	    <div class="header">
	        <img src="/images/facebook/prizes/<?php echo $culture ?>/game_<?php echo $facebookGame->getId() ?>_header.png" />
	    </div>

	    <div class="content">
	        <?php /* Facebook game steps */ ?>
	        <?php if ($fromFacebookGame) : ?>
                    <?php if (!$sf_user || !$sf_user->hasAttribute('goToStep') || !$sf_user->getAttribute('goToStep', false) == NULL) : ?>
                        <div class="step1 slide">
                            <div class="left">
                                <?php if ($culture == 'bg') : ?>
                                    <h1><?php echo __('How to play.', null, 'facebookgame') ?></h1>
                                    <ul>
                                        <li><?php echo __('Invite three friends to register in getlokal.', null, 'facebookgame') ?></li>
                                        <a target="_blank" title="We Will Rock You" href="http://www.getlokal.com/bg/d/event/show/id/2030"><img src="/images/facebook/prizes/bg/prize1.png" style="margin: -22px 0 0 80px" /></a>
                                        <li><?php echo __('Participate in the draw for the big prize – iPhone5.', null, 'facebookgame') ?></li>
                                    </ul>
                                <?php else : ?>
                                    <h1><?php echo __('How to play', null, 'facebookgame') ?></h1>
                                    <ul>
                                        <li><?php echo __('Invite three friends to register in getlokal', null, 'facebookgame') ?></li>
                                        <li><?php echo __('Participate in the draw for the big prize – iPhone5', null, 'facebookgame') ?></li>
                                    </ul>
                                <?php endif; ?>
                            </div>

                            <div class="left interaction">
                                <?php if ($sf_user->isAuthenticated()) : ?>
                                    <a href="javascript:;" class="button continue"><span><span><span><?php echo __('Play the game', null, 'facebookgame') ?></span></span></span></a>
                                <?php else : ?>
                                    <a href="javascript:;" id="go" class="button"><span><span><span><?php echo __('Play the game', null, 'facebookgame') ?></span></span></span></a>
                                <?php endif; ?>
                                <p><?php echo __('There is no limit to how many times a person can participated. Each time three of your friends register, you get another entry into the prize draw.', null, 'facebookgame') ?></p>
                            </div>
                            <div class="clear"></div>
                            <div class="additional_text_yellow_bg">
                                <p><?php echo __('Ако стигнавте до тука преку барањето кое ви пристигна од вашиот пријател, притиснете го копчето “УЧЕСТВУВАЈ ВО НАТПРЕВАРОТ” и со тоа ќе му помогнете да освои шанса за главната награда.  Секако, и вие можете да учествувавте во натпреварот, тоа го правите со покана на вашите пријатели.', null, 'facebookgame') ?></p>
	                    </div>
                        </div>
                    <?php endif; ?>

	            <div class="step2 slide">
	                <!-- <h1>STEP 2</h1> -->

	                <!-- CODE GOES HERE... -->
                        <a href="javascript:;" class="invite_fb button button_email"><span><span><span><?php echo __('Facebook Invite', null, 'facebookgame') ?></span></span></span></a>
                        
	                	<?php include_partial('inviteViaFB', array('fromFacebookGame' => $fromFacebookGame, 'class' => 'content_invite_fb_full')); ?>

                        <div class="clear"></div>
                        
                        <p class="note_step2"><?php echo __('There is no limit to how many times a person can participated. Each time three of your friends register, you get another entry into the prize draw.', null, 'facebookgame') ?></p>
                        
                        <a href="javascript:;" class="toStep3 button continue"><span><span><span><?php echo __('Continue', null, 'facebookgame') ?></span></span></span></a>
	            </div>

	            <div class="step3 slide">
	                <input type="hidden" value="" name="share_image" style="display: none !important; visibility: none !important;" />
                        <input type="hidden" value="" name="share_image_small" style="display: none !important; visibility: none !important;" />

	                <!-- <h1>STEP 3</h1> -->

                        <div class="final_results"><img src="/images/facebook/prizes/bg/loading.gif" /></div>

                        <div class="clear"></div>

	                <!-- CODE GOES HERE... -->
	                	<div class="btn_top">
                        <a id="playAgain" href="<?php echo $homepageUrl ?>" class="button" title="<?php echo __('Play again', null, 'facebookgame') ?>"><span><span><span><?php echo __('Play again', null, 'facebookgame') ?></span></span></span></a>
	                	</div>
	                <a href="javascript:;" class="share button"><span><span><span><?php echo __('Share on your wall', null, 'facebookgame') ?></span></span></span></a>
	            	<div class="clear"></div>
	            </div>
	        <?php /* Site game steps */ ?>
	        <?php else : ?>
	            <div class="step1 slide">
                        <div class="left">
                            <?php if ($culture == 'bg') : ?>
                                <h1><?php echo __('How to play.', null, 'facebookgame') ?></h1>
                                <ul>
                                    <li><?php echo __('Invite three friends to register in getlokal.', null, 'facebookgame') ?></li>
                                    <a target="_blank" title="We Will Rock You" href="http://www.getlokal.com/bg/d/event/show/id/2030"><img src="/images/facebook/prizes/bg/prize1.png" style="margin: -22px 0 0 80px" /></a>
                                    <li><?php echo __('Participate in the draw for the big prize – iPhone5.', null, 'facebookgame') ?></li>
                                </ul>
                            <?php else : ?>
                                <h1><?php echo __('How to play', null, 'facebookgame') ?></h1>
                                <ul>
                                    <li><?php echo __('Invite three friends to register in getlokal', null, 'facebookgame') ?></li>
                                    <li><?php echo __('Participate in the draw for the big prize – iPhone5', null, 'facebookgame') ?></li>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <div class="left interaction">
                            <?php if (!$userIsAuthenticated) : ?>
                                <a href="<?php echo url_for('@sf_guard_signin', array(), true) ?>" id="login" title="<?php echo __('Login or Register', null, 'facebookgame') ?>" class="button"><span><span><span><?php echo __('Login or Register', null, 'facebookgame') ?></span></span></span></a>
                                <p><?php echo __('There is no limit to how many times a person can participated. Each time three of your friends register, you get another entry into the prize draw.', null, 'facebookgame') ?></p>
                            <?php else : ?>
                                <a href="javascript:;" class="button continue"><span><span><span><?php echo __('Play the game', null, 'facebookgame') ?></span></span></span></a>
                                <p><?php echo __('There is no limit to how many times a person can participated. Each time three of your friends register, you get another entry into the prize draw.', null, 'facebookgame') ?></p>
                            <?php endif; ?>
	                </div>
	                <div class="clear"></div>
                        <?php if ($culture == 'mk') : ?>
                        <div class="additional_text_yellow_bg">
                            <p><?php echo __('Ако стигнавте до тука преку барањето кое ви пристигна од вашиот пријател, притиснете го копчето “УЧЕСТВУВАЈ ВО НАТПРЕВАРОТ” и со тоа ќе му помогнете да освои шанса за главната награда.  Секако, и вие можете да учествувавте во натпреварот, тоа го правите со покана на вашите пријатели.', null, 'facebookgame') ?></p>
	                </div>
                         <?php endif; ?>
                    </div>
                        
	            <?php /* All another game steps */ ?>
	            <?php if ($userIsAuthenticated) : ?>
	                <div class="step2 slide">
	                    <!--<h1>STEP 2</h1> -->

	                    <!-- CODE GOES HERE... -->
	                    <ul>
		                    <li class="fb">
	                            <h2><img src="/images/facebook/prizes/bg/game_5_pin.png" /><?php echo __('Invite your friends from Facebook', null, 'facebookgame') ?></h2>
	                            <a href="javascript:;" class="invite_fb button button_email"><span><span><span><?php echo __('Facebook Invite', null, 'facebookgame') ?></span></span></span></a>
	            				<?php include_partial('inviteViaFB', array('fromFacebookGame' => true, 'class' => '' /* $fromFacebookGame */)); ?>	
	                        </li>
							<li class="email">
                                <h2 class="note_3"><?php echo __('You can also invite your friends via:', null, 'facebookgame') ?></h2>
	                            <h2><img src="/images/facebook/prizes/bg/game_5_pin.png" /><?php echo __('e-mail', null, 'facebookgame') ?></h2>
		                    	<a href="javascript:;" class="invite_email button button_email"><span><span><span><?php echo __('Email invite', null, 'facebookgame') ?></span></span></span></a>
	                            <?php include_partial('inviteViaEmail2', array('sendInvitePMForm' => $sendInvitePMForm, 'url' => $inviteFromMailUrl)); ?>
							</li>
							<li class="gy">
	                            <div class="gy_form">
	                                <h2><img src="/images/facebook/prizes/bg/game_5_pin.png" /><?php echo __('Gmail/Yahoo!', null, 'facebookgame') ?></h2>
	                                <?php if (strpos($sf_user->getGuardUser()->getEmailAddress(), 'gmail') !== false || strpos($sf_user->getGuardUser()->getEmailAddress(), 'yahoo') !== false) : ?>
	                                    <a href="javascript:;" class="invite_gy_auth button button_email"><span><span><span><?php echo __('Gmail/Yahoo! Invite', null, 'facebookgame') ?></span></span></span></a>
	                                    <?php include_partial('authorizeGY', array('loginMailForm' => $loginMailForm, 'url' => $authorizeGYUrl, 'isShort' => true)); ?>
	                                <?php else : ?>
	                                    <a href="javascript:;" class="invite_gy_auth button button_email"><span><span><span><?php echo __('Gmail/Yahoo! Invite', null, 'facebookgame') ?></span></span></span></a>
	                                    <?php include_partial('authorizeGY', array('loginMailForm' => $loginMailForm, 'url' => $authorizeGYUrl, 'isShort' => false)); ?>
	                                <?php endif; ?>
	                            </div>
	                        </li>
						</ul>
						<div class="clear"></div>
						<p class="note_step2"><?php echo __('There is no limit to how many times a person can participated. Each time three of your friends register, you get another entry into the prize draw.', null, 'facebookgame') ?></p>
                        <a href="javascript:;" class="toStep3 button continue"><span><span><span><?php echo __('Continue', null, 'facebookgame') ?></span></span></span></a>
	                </div>

	                <div class="step3 slide">
	                    <input type="hidden" value="" name="share_image" style="display: none !important; visibility: none !important;" />
                            <input type="hidden" value="" name="share_image_small" style="display: none !important; visibility: none !important;" />

	                    <!-- <h1>STEP 3</h1> -->

	                    <!-- CODE GOES HERE... -->	
	                    <div class="final_results"><img src="/images/facebook/prizes/bg/loading.gif" /></div>

	                    <div class="clear"></div>
						<div class="btn_top">
                            <a id="playAgain" href="<?php echo $homepageUrl ?>" class="button" title="<?php echo __('Play again', null, 'facebookgame') ?>"><span><span><span><?php echo __('Play again', null, 'facebookgame') ?></span></span></span></a>
                        </div>
                            <a href="javascript:;" class="share button"><span><span><span><?php echo __('Share on your wall', null, 'facebookgame') ?></span></span></span></a>
	                	<div class="clear"></div>
	                </div>
	            <?php endif; ?>
	        <?php endif; ?>
	    </div>

            <input name="hash" type="hidden" style="display: none; visibility: none;" />

	    <div class="footer">
	        <a href="<?php echo $siteUrl ?>"><?php echo __('Home', null, 'facebookgame') ?></a>
	        <a id="playAgain" href="<?php echo $homepageUrl ?>"><?php echo __('Play again', null, 'facebookgame') ?></a>
	        <a href="<?php echo url_for('static_page', array('slug' => 'rules-lucky3')) ?>" target="_blank"><?php echo __('Rules', null, 'facebookgame') ?></a>

	        <?php if (isset($games) && count($games)) : ?>
                    <?php /*
	            <a href="<?php echo url_for('facebook/game3', array(), true) . '?type=winners' ?>"><?php echo __('Winners', null, 'facebookgame') ?></a>
	            <a href="<?php echo url_for('facebook/game3', array(), true) . '?type=results' ?>"><?php echo __('Results', null, 'facebookgame') ?></a>
                     * 
                     */ ?>
	            <?php /*<a href="<?php echo url_for('facebook/game2cbg', array(), true) . '?type=awards' ?>">Награди</a>*/ ?>
	        <?php endif; ?>
	        <img src="/images/facebook/prizes/<?php echo $culture ?>/game_<?php echo $facebookGame->getId() ?>_footer_logo.png" alt="Lucky Three" />
	    </div>
	</div>
</div>

<div id="fb-root"></div>
<script src="//connect.facebook.net/en_US/all.js"></script>


<script type="text/javascript">
	<?php if (!$fromFacebookGame) : ?>
		$('html').css('background', 'url("<?php echo public_path("/images/gui/bg.gif", true); ?>") repeat scroll 0 0 #E9E1D4');
	<?php /* else: ?>
		$('.invite_fb').trigger('click');
		$('.invite_fb').hide();
		$('.image_loader_fb').html('<img src="/images/facebook/prizes/bg/loading.gif" />');
         */ ?>
	<?php endif; ?>
	
    <?php if ($culture == 'bg') : ?>
        FB.init({
            appId : '430198693740282',
            frictionlessRequests: true,

            status: true,
            cookie: true,
            oauth: true,
            xfbml: true
        });
    <?php elseif ($culture == 'mk') : ?>
        FB.init({
            appId : '579081232109732',
            frictionlessRequests: true,

            status: true,
            cookie: true,
            oauth: true,
            xfbml: true
        });
    <?php elseif ($culture == 'sr') : ?>
        FB.init({
            appId : '111070179087144',
            frictionlessRequests: true,

            status: true,
            cookie: true,
            oauth: true,
            xfbml: true
        });
    <?php endif; ?>

    FB.Canvas.setAutoGrow(200);
    FB.Canvas.scrollTo(0,0);

    function requestCallback(response) {
        // Handle callback here
        if (response != null && response != undefined) {
            $('.toStep3').show();
        }
    }

    $(document).ready(function() {
        var step_count = 3;
        var step = 1;

        <?php if ($fromFacebookGame) : ?>
            $('#playAgain').live('click', function() {
                //$(".final_results").html("<img src=\"/images/facebook/prizes/bg/loading.gif\" />");
                //$(".step3").hide();
                //$(".step1").show();
                location.reload();

                return false;
            });
        <?php endif; ?>

        <?php if ($fromFacebookGame && $sf_user->getAttribute('goToStep', false) == 2) : ?>
            $("input[name=hash]").val('<?php echo $hash ?>');

            $(".step1").hide();
            $(".step2").show();

            <?php $sf_user->setAttribute('goToStep', NULL) ?>
        <?php endif; ?>

        $('.toStep3').hide();

        $('.continue').click(function() {
            step += 1;
            $('.slide').hide();
            $('.step' + step).show();

            // Step 2
            if ($('.step2').css('display') == 'block') {
                $.post('<?php echo url_for('default', array('module' => 'facebook', 'action' => 'game3'), true) ?>', { step: 'step2' }, function(data) {
                    if (data) {
                        if (data.hash) {
                            $("input[name=hash]").val(data.hash);

                            <?php if (!$fromFacebookGame) : ?>
                                var body = $("textarea[name='sendInvitePM[body]']").val();
                                body = body.replace('#HASH#', '?code=' + $("input[name=hash]").val());

                                $("textarea[name='sendInvitePM[body]']").val(body);
                            <?php endif; ?>
                        }

                        $("input[name=share_image]").val(data.image);
                        $("input[name=share_image_small]").val(data.image_sm);
                    }
                }, 'json');
            }


            // Get the final results
            if ($('.step3').css('display') == 'block') {
                $.post('<?php echo url_for('default', array('module' => 'facebook', 'action' => 'game3'), true) ?>', { step: 'step3' }, function(data) {
                    if (data) {
                        if (data.success == true) {
                            var r1 = '';
                            var r2 = '';
                            var r3 = '';

                            if (data.count > 1) {
                                r1 = "<p><span class='pink'>" + data.count + "</span> <?php echo __('entries in the prize draw', null, 'facebookgame') ?> </p>";
                            }
                            else if (data.count == 1) {
                                r1 = "<p><span class='pink'>" + data.count + "</span> <?php echo __('entry in the prize draw', null, 'facebookgame') ?> </p>";
                            }
                            else if (data.count < 1) {
                                r1 = "<p><span class='pink'>" + data.count + "</span> <?php echo __('entries in the prize draw', null, 'facebookgame') ?> </p>";
                            }

                            if (data.cntInv > 1) {
                                r2 = "<p><?php echo __('You have', null, 'facebookgame') ?> <span class='pink'>" + data.cntInv + "</span> <?php echo __('invited friends', null, 'facebookgame') ?> </p>";
                            }
                            else if (data.cntInv == 1) {
                                r2 = "<p><?php echo __('You have', null, 'facebookgame') ?> <span class='pink'>" + data.cntInv + "</span> <?php echo __('invited friend', null, 'facebookgame') ?> </p>";
                            }
                            else if (data.cntInv < 1) {
                                r2 = "<p><?php echo __('You haven’t invited any friends', null, 'facebookgame') ?></p>";
                            }

                            r3 = "<p><?php echo __('and', null, 'facebookgame') ?></p>";

                            $(".final_results").html(r2 + r3 + r1);
                        }
                    }
                }, 'json');
            }
        });

        // Share bnt
        $('a.share').live('click', function() {
            var link = picture = name = caption = descripton = '';

            link = '<?php echo url_for('default', array('module' => 'facebook', 'action' => 'game3'), true) . '?code=' /*. $hash*/; ?>' + $("input[name=hash]").val();
            picture = $("input[name=share_image]").val() + '?' + "<?php echo time() ?>";
            name = '<?php echo __('Win an iPhone5!', null, 'facebookgame') ?>';
            caption = '<?php echo __('I participated in Lucky three!', null, 'facebookgame') ?>';
            description = '<?php echo __('Invite three friends and enter the prize draw!', null, 'facebookgame') ?>';

            var obj = {
                method: 'feed',
                link: link,
                picture: picture,
                name: name,
                caption: caption,
                description: description
            };

            FB.ui(obj);
        });

        // Play btn (from facebook)
        $('a#go').click(function(){
            <?php if (!$sf_user || !$sf_user->isAuthenticated()) : ?>
                top.location.href='<?php echo url_for('default', array('module' => 'facebook', 'action' => 'login', 'app' => $facebookGame->getSlug()), true) ?>';
            <?php endif; ?>
        });
    });
</script>