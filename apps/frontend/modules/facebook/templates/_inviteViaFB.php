                <div class="clear"></div>                
                <div class="success_msg_fb success_msg"></div>
                <div class="clear"></div>
                <span class="image_loader_fb"><img src="/images/facebook/prizes/bg/loading.gif" /> <?php echo __('Loading your friends list', null, 'facebookgame') ?></span>
                
                <div class="content_invite_fb <?php echo $class; ?>">
                <?php if (!$fromFacebookGame) : ?>
                    <a href="javascript:;" class="pink">x</a> 
                <?php endif ?>
                <h3><?php echo __('Invite your friends from Facebook', null, 'facebookgame') ?></h3>
                    <div class="fbResilts"></div>
                    <div class="clear"></div>
                </div>

                <script type="text/javascript">
                    $(document).ready(function() {
/*
                        var body = $(".gy_invite_form textarea").val();
                        body = body.replace('#HASH#', '?code=' + $("input[name=hash]").val());
                        $(".gy_invite_form textarea").val(body);
*/

                        <?php if (!$fromFacebookGame) : ?>
                            $('.content_invite_fb a.pink').live('click', function() {
                                $('.content_invite_fb').slideToggle(300);
                            });
                        <?php else : ?>
                            $('.content_invite_fb').show();

                            FB.getLoginStatus(function(response) {
                                if (response.status !== 'connected') {
                                    FB.login(function(response) {
                                        if (response && response.status == 'connected') {
                                            getFriendsList("<?php echo url_for('default', array('module' => 'facebook', 'action' => 'game3'), true); ?>", false);
                                        }
                                        else {
                                            $('.content_invite_fb').hide();
                                        }
                                    }, {scope: 'user_location,email,user_birthday,offline_access,user_checkins,publish_actions'});
                                }
                                else {
                                    getFriendsList("<?php echo url_for('default', array('module' => 'facebook', 'action' => 'game3'), true); ?>", false);
                                }
                            });
                        <?php endif; ?>

                        $('.invite_fb').live('click', function() {
                            <?php if (!$fromFacebookGame) : ?>
                                if ($('.content_invite_fb').css('display') == 'block') {
                                    $('.content_invite_fb').slideToggle(300);
                                    return;
                                }
                            <?php endif; ?>
                            $('.invite_form_wrap').slideUp(300);
                            //$('.content_invite_fb').slideToggle(300);
                            $(".success_msg").html('');
                            $(".success_msg_fb").html('');
                            $(".success_msg_gy").html('');
                            $(".success_msg_gy_inv").html('');
                            $('.image_loader_fb').html('<img src="/images/facebook/prizes/bg/loading.gif" />' + "<?php echo __('Loading your friends list', null, 'facebookgame') ?>");
                            $(".success_msg").hide();
                            
                            FB.getLoginStatus(function(response) {
                                if (response.status !== 'connected') {
                                    FB.login(function(response) {
                                        if (response && response.status == 'connected') {
                                            getFriendsList("<?php echo url_for('default', array('module' => 'facebook', 'action' => 'game3'), true); ?>", false);
                                        }
                                        else {
                                            $('.content_invite_fb').hide();
                                        }
                                    }, {scope: 'user_location,email,user_birthday,offline_access,user_checkins,publish_actions'});
                                }
                                else {
                                    getFriendsList("<?php echo url_for('default', array('module' => 'facebook', 'action' => 'game3'), true); ?>", false);
                                }
                            });
                        });
                    });

                    function getFriendsList(url, slideUp) {
                        // Retrieve pages
                        FB.api('/me/friends', function(response) {
                            $.ajax({
                                type: 'POST',
                                url: url,
                                data: {friendsList: response.data},
                                dataType: 'json', //text

                                // callback handler that will be called on success
                                success: function(response, textStatus, jqXHR) {
                                    if (response.error == true) {
                                        <?php if (!$fromFacebookGame) : ?>
                                            $('.content_invite_fb').slideUp();
                                        <?php endif; ?>
                                    }
                                    else if (response.success == true) {
                                        $('.fbResilts').html(response.html);

                                        <?php if (!$fromFacebookGame) : ?>
                                            if (!slideUp) {
                                                $('.content_invite_fb').slideDown(300);
                                            }
                                        <?php endif; ?>
                                        $('.content_invite_fb h3').show();
                                        
                                        if ($('.step2').css('display') == 'none') $('.step2').show();

                                        $('.facebook_scroll').tinyscrollbar();

										if ($('.facebook_scroll .viewport ul').outerHeight() < $('.facebook_scroll .viewport').outerHeight()) {
                                            $('.facebook_scroll .viewport').css({'height': 'auto', 'position': 'static' });
                                            $('.facebook_scroll .overview').css({'height': 'auto', 'position': 'static' });
                                            $('.facebook_scroll .scrollbar').remove();
                                        }
                                        
										if ($('.step1').css('display') == 'block') $('.step2').hide();
                                    }

                                    $('.image_loader_fb').html('');
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
                        });
                    }
                </script>