                <div class="clear"></div>                
                <div class="success_msg_gy_inv success_msg"></div>
                <div class="clear"></div>
                <div class="content_invite_gy invite_form_wrap">
                    <a href="javascript:;" class="pink">x</a> 

                    <form class="gy_invite_form" action="<?php echo $url /*url_for('@invite_gy_check')*/ ?>" method="POST">
                        <div class="form_box gy_email_lists <?php echo ($sendInviteGYForm['email_lists']->hasError()) ? 'error' : '' ?>">
                            <?php echo $sendInviteGYForm['email_lists']->renderLabel()?>
                            <div class="scrl_box">
                            <div class="email_scroll">
                                <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                                <div class="viewport">
                                    <?php echo $sendInviteGYForm['email_lists'] ?>
                                </div>
                            </div>
                            <?php echo $sendInviteGYForm['email_lists']->renderError()?>
                            </div>
                        </div>

                        <div class="mailbody form_box gy_body <?php echo ($sendInviteGYForm['body']->hasError()) ? 'error' : '' ?>">
                            <?php echo $sendInviteGYForm['body']->renderLabel()?>
                            <?php echo $sendInviteGYForm['body'] ?>
                            <?php echo $sendInviteGYForm['body']->renderError()?>
                        </div>

                        <?php echo $sendInviteGYForm->renderHiddenFields(); ?>
                        <input type="submit" class="button_pink" value="<?php echo __('Send', null, 'user') ?>" />
                    </form>
                </div>

                <script type="text/javascript">
                    $(document).ready(function() {
                        var body = $(".gy_invite_form textarea").val();
                        body = body.replace('#HASH#', '?code=' + $("input[name=hash]").val());
                        $(".gy_invite_form textarea").val(body);

                        $('.invite_gy_auth, .content_invite_gy a.pink').live('click', function() {
                        	$(".content_invite").slideUp(300);
                            $('.content_invite_gy').slideToggle(300);
                            $(".success_msg").html('');
                            $(".success_msg_fb").html('');
                            $(".success_msg_gy").html('');
                            $(".success_msg_gy_inv").html('');
                            $('.success_msg').hide();
                        });
                        
                        $('.email_scroll').tinyscrollbar();

                        if ($('.email_scroll .viewport ul').outerHeight() < $('.email_scroll .viewport').outerHeight()) {
                            $('.email_scroll .viewport').css({'height': 'auto', 'position': 'static' });
                            $('.email_scroll .overview').css({'height': 'auto', 'position': 'static' });
                            $('.email_scroll .scrollbar').remove();
                        }

                        $('.gy_invite_form').submit(function(event) {
                            var serializeVars = $(this).serialize();
                            event.preventDefault();

                            $(".gy_invite_form .form_box").removeClass("error");
                            var error_lists = $(".gy_invite_form .form_box").find('ul.error_list');
                            $.each(error_lists, function(index, list) {
                                $(list).remove();
                            });


                            $.ajax({
                                type: 'POST',
                                url: $(this).attr("action"),
                                data: {sendInviteGY: true, GYMailValues : serializeVars},
                                dataType: 'json', //text

                                // callback handler that will be called on success
                                success: function(response, textStatus, jqXHR) {
                                    if (response.error == true && response.errors) {
                                        // Remove all errors
                                        $(".gy_invite_form .form_box").removeClass("error");
                                        var error_lists = $(".gy_invite_form .form_box").find('ul.error_list');
                                        $.each(error_lists, function(index, list) {
                                            $(list).remove();
                                        });

                                        // Set errors
                                        $.each(response.errors, function(widget, error) {
                                            $(".gy_invite_form .gy_" + widget).addClass('error');
                                            $(".gy_invite_form .gy_" + widget).append('<ul class="error_list"><li>' + error + '</li></ul>');
                                        });
										$('.success_msg').hide();
/*							
                                        var top = $('.content_invite_gy').offset().top;
                                        $('html,body').scrollTop(top);
*/
                                    }
                                    else if (response.success == true) {
                                        //$(".content_invite_gy").html(response.message);
                                        $(".gy_invite_form .form_box").removeClass("error");

                                        var error_lists = $(".gy_invite_form .form_box").find('ul.error_list');

                                        $.each(error_lists, function(index, list) {
                                            $(list).remove();
                                        });

                                        $('.content_invite_gy').slideUp(300);

                                        $('input[name="sendInviteGY[email_lists][]"]').attr('checked', false);

                                        $(".success_msg_gy_inv").html(response.message);
                                        $(".gy_invite_form input[type=text], .gy_invite_form textarea").val("");
                                        //$(".gy_invite_form textarea").val(response.body);

                                        var body = response.body;
                                        body = body.replace('#HASH#', '?code=' + $("input[name=hash]").val());
                                        $(".gy_invite_form textarea").val(body);


                                        $('.toStep3').show();

                                        $('.gy .success_msg').show();
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
                    });
                </script>