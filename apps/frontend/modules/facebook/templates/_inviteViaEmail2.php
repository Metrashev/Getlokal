                <div class="clear"></div>                
                <div class="success_msg"></div>
                <div class="clear"></div>
                <div class="content_invite invite_form_wrap">
                    <a href="javascript:;" class="pink">x</a> 
                    <form class="invite_form" action="<?php echo $url ?> <?php /*echo url_for('default', array('module' => 'facebook', 'action' => 'game2bg'))*/ ?>" method="POST">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <div class="email_<?php echo $i ?> form_box <?php echo ($sendInvitePMForm['email_' . $i]->hasError()) ? 'error' : '' ?>">
                                <?php echo $sendInvitePMForm['email_' . $i]->renderLabel() ?>
                                <?php echo $sendInvitePMForm['email_' . $i] ?>
                                <?php echo $sendInvitePMForm['email_' . $i]->renderError() ?>
                            </div>
                        <?php endfor; ?>

                        <div class="body form_box <?php echo ($sendInvitePMForm['body']->hasError()) ? 'error' : '' ?>">
                            <?php echo $sendInvitePMForm['body']->renderLabel() ?>
                            <?php echo $sendInvitePMForm['body'] ?>
                            <?php echo $sendInvitePMForm['body']->renderError() ?>
                        </div>

                        <?php echo $sendInvitePMForm->renderHiddenFields(); ?>

                        <input type="submit" class="button_pink" value="<?php echo __('Send', null, 'user') ?>" />
                    </form>
                </div>
                
                <script type="text/javascript">
                        $(document).ready(function() {
                            // Send invite via email
                            $(".invite_email, .content_invite a.pink").live('click', function () {
                            	$('.content_invite_gy_auth').slideUp(300);
                                $(".content_invite").slideToggle(300);
                                $(".success_msg").html('');
                                $(".success_msg_fb").html('');
                                $(".success_msg_gy").html('');
                                $(".success_msg_gy_inv").html('');
                                $(".success_msg").hide();
                            });

                            $('.invite_form').submit(function(event) {
                                var serializeVars = $(this).serialize();
                                event.preventDefault();

                                $(".invite_form .form_box").removeClass("error");
                                var error_lists = $(".invite_form .form_box").find('ul.error_list');
                                $.each(error_lists, function(index, list) {
                                    $(list).remove();
                                });

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
/*
                                            var top = $('.content_invite').offset().top;
                                            $('html,body').scrollTop(top);
*/
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

                                            var body = response.body;
                                            body = body.replace('#HASH#', '?code=' + $("input[name=hash]").val());
                                            $(".invite_form textarea").val(body);

                                            $('.toStep3').show();
                                            $('.email .success_msg').show();
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