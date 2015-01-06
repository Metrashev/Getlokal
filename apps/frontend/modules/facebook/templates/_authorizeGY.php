                <div class="div_gy_auth">
                    <div class="clear"></div>                 
                    <div class="success_msg_gy success_msg"></div>
                    <div class="clear"></div>
                    <span class="image_loader_gy"></span>
                    <div class="content_invite_gy_auth invite_form_wrap">
                        <a href="javascript:;" class="pink">x</a>

                        <form class="gy_login_form" action="<?php echo $url /* echo url_for('@invite_gy') */ ?>" method="POST">
                            <?php if ($isShort === false) : ?>
                                <div class="form_box gy_email_address <?php echo ($loginMailForm['email_address']->hasError()) ? 'error' : '' ?>">
                                    <?php echo $loginMailForm['email_address']->renderLabel()?>
                                    <?php echo $loginMailForm['email_address'] ?>
                                    <?php echo $loginMailForm['email_address']->renderError()?>
                                </div>
                            <?php endif; ?>

                            <div class="form_box gy_email_password <?php echo ($loginMailForm['email_password']->hasError()) ? 'error' : '' ?>">
                                <?php echo $loginMailForm['email_password']->renderLabel()?>
                                <?php echo $loginMailForm['email_password'] ?>
                                <?php echo $loginMailForm['email_password']->renderError()?>
                            </div>

                            <?php echo $loginMailForm->renderHiddenFields(); ?>
                            <input type="submit" class="button_pink" value="<?php echo __('Login', null, 'user') ?>" />
                        </form>
                    </div>

                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('.invite_gy_auth, .content_invite_gy_auth a.pink').live('click', function() {
                            	$(".content_invite").slideUp(300);
                                $('.content_invite_gy_auth').slideToggle(300);
                                $(".success_msg").html('');
                                $(".success_msg_fb").html('');
                                $(".success_msg_gy").html('');
                                $(".success_msg_gy_inv").html('');
                                $('.success_msg').hide();
                            });


                            $('.gy_login_form').submit(function(event) {
                                var serializeVars = $(this).serialize();
                                event.preventDefault();

                                $('.image_loader_gy').html('<img src="/images/facebook/prizes/bg/loading.gif" />');

                                var error_lists = $(".gy_login_form .form_box").find('ul.error_list');

                                $.each(error_lists, function(index, list) {
                                    $(list).remove();
                                });


                                $.ajax({
                                    type: 'POST',
                                    url: $(this).attr("action"),
                                    data: {authorizeGY: true, loginGYMailValues : serializeVars},
                                    dataType: 'json', //text

                                    // callback handler that will be called on success
                                    success: function(response, textStatus, jqXHR) {
                                        if (response != null && response.error == true && response.errors) {
                                            // Remove all errors
                                            $(".gy_login_form .form_box").removeClass("error");

                                            var error_lists = $(".gy_login_form .form_box").find('ul.error_list');
                                            $.each(error_lists, function(index, list) {
                                                $(list).remove();
                                            });

                                            // Set errors
                                            $.each(response.errors, function(widget, error) {
                                                $(".gy_login_form .gy_" + widget).addClass('error');
                                                $(".gy_login_form .gy_" + widget).append('<ul class="error_list"><li>' + error + '</li></ul>');
                                            });

                                            $('.image_loader_gy').html('');
    /*
                                            var top = $('.content_invite_gy_auth').offset().top;
                                            $('html,body').scrollTop(top);
    */
                                        }
                                        else if (response && response.success == true) {
                                            if (response.html && response.html != undefined) {
                                                $('.div_gy_auth').html(response.html);
                                            }
                                            else {
                                                //$(".content_invite_gy_auth").html(response.message);
                                                $(".gy_login_form .form_box").removeClass("error");

                                                var error_lists = $(".gy_login_form .form_box").find('ul.error_list');

                                                $.each(error_lists, function(index, list) {
                                                    $(list).remove();
                                                });

                                                $('.content_invite_gy_auth').slideUp(300);

                                                $(".success_msg_gy").html(response.message);
                                                $(".gy_login_form input[type=text], .gy_login_form textarea").val("");
                                                //$(".gy_login_form textarea").val(response.body);

                                                var body = response.body;

                                                body = body.replace('#HASH#', '?code=' + $("input[name=hash]").val());
                                                $(".gy_login_form textarea").val(body);


                                                $('.toStep3').show();
                                            }
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
                </div>