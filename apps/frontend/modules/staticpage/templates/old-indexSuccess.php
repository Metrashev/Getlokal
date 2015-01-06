<div class="static_page_wrapper">
    <div class="sidebar_nav">
        <?php if (isset($root)): ?>
            <ul class="tree">
                <?php include_partial('page', array('page' => $root)); ?>
            </ul>
        <?php endif ?>
    </div>
    <div class="content_in">
        <?php echo htmlspecialchars_decode($static_page['content']); ?>
    </div>

    <?php if (isset($form)) : ?>
        <div class="flash_success" style="display:none"></div>
        <div class="email_form_wrap">
            <a id="email_form_close"><img src="/images/gui/close_small.png" /></a>
            <form action="<?php echo url_for('static_page_send_mail', array(), true) ?>" method="post" style="display: none;">
                <div class="left_wrapper">
                    <div class="form_box<?php if ($form['email']->hasError()) : ?> error<?php endif; ?>">
                        <label><?php echo __('Your e-mail:', null, 'contact') ?><span class="pink">*</span></label>
                        <?php echo $form['email']->render(); ?>
                        <?php if ($form['email']->hasError()) : ?>
                            <p class="error"><?php echo $form['email']->renderError(); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form_box<?php if ($form['name']->hasError()) : ?> error<?php endif; ?>">
                        <label><?php echo __('Your name:', null, 'contact') ?><span class="pink">*</span></label>
                        <?php echo $form['name']->render(); ?>
                        <?php if ($form['name']->hasError()): ?>
                            <p class="error"><?php echo $form['name']->renderError(); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form_box<?php if ($form['phone']->hasError()): ?> error<?php endif; ?>">
                        <label><?php echo __('Your phone:', null, 'contact') ?></label>
                        <?php echo $form['phone']->render(); ?>
                        <?php if ($form['phone']->hasError()): ?>
                            <p class="error"><?php echo $form['phone']->renderError(); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="right_wrapper">
                    <div class="form_box message_field<?php if ($form['message']->hasError()): ?> error <?php endif; ?>">
                        <label><?php echo __('Your message:', null, 'contact') ?><span class="pink">*</span></label>
                        <?php echo $form['message']->render(); ?>
                        <?php if ($form['message']->hasError()): ?>
                            <p class="error"><?php echo $form['message']->renderError(); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="captcha_wrap">
                    <?php if (sfConfig::get('app_recaptcha_active', false)): ?>
                        <div class="form_box form_capture <?php if ($form['captcha']->hasError()): ?> error<?php endif; ?>">
                            <?php echo $form['captcha']->renderLabel(); ?>
                            <?php echo $form['captcha']->render(); ?>

                        </div>
                        <?php if ($form['captcha']->hasError()): ?>
                            <p class="error"><?php echo $form['captcha']->renderError(); ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>    
                <div class="clear"></div>


                <input type="submit" value="<?php echo __('Send'); ?>" class="input_submit" />

            </form>
        </div>
    <?php endif; ?>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        staticPagesLayout();
        accordeonMenu();

<?php if (isset($form)) : ?>
            $('img.link_to_email').click(function() {
                $('img.link_to_email').removeClass('clicked');
                $(this).addClass('clicked');

                $('.flash_success').html('');
            });

            $('img.link_to_email').click(function() {
                var formContainer = $(this).siblings('.emailForm_container');
                $('.static_page_wrapper .email_form_wrap').appendTo(formContainer);
                $('.flash_success').insertAfter(formContainer);
                $(this).siblings('.emailForm_container').slideDown('fast');
                $('.static_page_wrapper .email_form_wrap').css('display', 'inline-block');
                $(this).siblings('.emailForm_container').children().children().slideDown();

            });

            $(document).click(function(event) {
                if ($(event.target).closest('.static_page_wrapper .email_form_wrap').get(0) == null && ($(event.target).closest('img.link_to_email').get(0) == null)) {
                    $('.email_form_wrap').slideUp('fast', function() {
                        $('.static_page_wrapper .email_form_wrap').css('display', 'none');
                        $('.static_page_wrapper .static_page.full_width_item_wrapper .emailForm_container').slideUp('fast');
                        $('flash_success').css('display', 'none');
                    });
                }
                ;
            });
            
            $('.static_page_wrapper .email_form_wrap a#email_form_close').live('click',function() {
                 $('.email_form_wrap').slideUp('fast', function() {
                        $('.static_page_wrapper .email_form_wrap').css('display', 'none');
                        $('.static_page_wrapper .static_page.full_width_item_wrapper .emailForm_container').slideUp('fast');
                        
                    });
            });
         

            $('.input_submit').click(function() {
                var form = $(this).closest('form');
                $.ajax({
                    type: "POST",
                    url: form.attr('action'),
                    cache: false,
                    data: form.serialize() + "&userId=" + $('img.link_to_email.clicked').attr('id'),
                    dataType: "json"
                }).done(function(response) {
                    clearForm(form);

                    if (response != undefined && response.SUCCESS == 'true') {
                        form.hide();
                        form.find(':input[type=text], textarea').val('');
                        $('img.link_to_email').removeClass('clicked');
                        $('.email_form_wrap').css('display', 'none');
                        $('.flash_success').css('display', 'inline-block');
                        $('.flash_success').html("<?php echo __('Your message was sent successfully.', null, 'messages') ?>");
                        setTimeout(function() {
                            $('.flash_success').css('display', 'none');
                        }, 5000);
                        $('.static_page_wrapper .static_page.full_width_item_wrapper .emailForm_container').css('display', 'none');
                    } else {
                        $.each(response.ERRORS, function(field, error) {
                            form.find('input[name^="contact[' + field + ']"], textarea[name^="contact[' + field + ']"]').closest('.form_box').addClass('error');

                            form.find('input[name^="contact[' + field + ']"], textarea[name^="contact[' + field + ']"]').after('<p class="error">' + error + '</p>');
                        });
                        form.find('img.captcha').click();
                    }
                });

                return false;
            });
<?php endif; ?>
    });

<?php if (isset($form)) : ?>
        function clearForm(form) {
            form.find('.form_box').removeClass('error');
            form.find('p.error').remove();
        }
<?php endif; ?>
</script>
