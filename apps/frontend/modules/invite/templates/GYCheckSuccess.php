<?php use_javascript('scrollbar.js') ?>
<?php slot('no_map', true) ?>

<div class="settings_content">
    <?php if ($sf_user->hasFlash('error')) : ?>
        <p><?php echo link_to(__('Back', null, 'user'), '@invite_gy'); ?></p>
    <?php endif; ?>

    <?php if (!$sf_user->getFlash('notice')) : ?>
    <h3 class="h3-title">
          <?php echo __('Via Gmail or Yahoo', null, 'user')?>
     </h3>

    <h2 class="dotted">
        <?php echo __('Send Your Invite via <img src="/images/logos/gmail.png"> or <img src="/images/logos/yahoo.png">', null, 'user')?>
    </h2>

    <div class="email_fields">
        <form action="<?php echo url_for('@invite_gy_check') ?>" method="POST">
            <div class="email <?php echo ($sendInviteGYForm['email_lists']->hasError()) ? 'error' : '' ?>">
                <?php //echo $sendInviteGYForm['email_lists']->renderLabel()?>
                <div id="scrollbar1">
                    <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                    <div class="viewport">
                        <?php echo $sendInviteGYForm['email_lists'] ?>
                    </div>
                </div>
                <?php echo $sendInviteGYForm['email_lists']->renderError()?>

            </div>
            <div class="mailbody form_box <?php echo ($sendInviteGYForm['body']->hasError()) ? 'error' : '' ?>">
                <?php echo $sendInviteGYForm['body']->renderLabel()?>
                <?php echo $sendInviteGYForm['body'] ?>
                <?php echo $sendInviteGYForm['body']->renderError()?>
            </div>
            <div class="clear"></div>
            <?php if (sfConfig::get('app_recaptcha_active', false)): ?>
	            <div class="form_box<?php if ($sendInviteGYForm['captcha']->hasError()): ?> error<?php endif; ?>">
	                <div class="captcha_out">
	                   <label><?php echo __('Security check. Enter the characters from the picture below', null, 'form') ?><span class="pink">*</span></label>
	                    <?php echo $sendInviteGYForm['captcha']->render(); ?>
	                </div>
	                <?php if ($sendInviteGYForm['captcha']->hasError()): ?>
	                    <p class="error"><?php echo $sendInviteGYForm['captcha']->renderError(); ?></p>
	                <?php endif; ?>
	            </div>
	        <?php endif; ?>
            <?php echo $sendInviteGYForm->renderHiddenFields(); ?>
            <input type="submit" class="button_green" value="<?php echo __('Send', null, 'user') ?>" />
        </form>
        <?php else : ?>
            <p><a href="<?php echo url_for("@invite_gy") ?>" title="<?php echo __('Send another invite?', null, 'user') ?>"><?php echo __('Send another invite?', null, 'user') ?></a></p>
        <?php endif; ?>
        <div class="clear"></div>
    </div>
</div>
<div class="clear"></div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#scrollbar1').tinyscrollbar();

        if ($('#scrollbar1 .viewport ul').outerHeight() < $('#scrollbar1 .viewport').outerHeight()) {
            $('#scrollbar1 .viewport').css({height:'auto'});
            $('#scrollbar1 .overview').css({position:'static'});
            $('#scrollbar1 .overview li').css({paddingRight: 0});
            $('#scrollbar1 .scrollbar').remove();
        }

        $('.path_wrap').remove();
//        $('.search_bar').remove();
        $(".banner").remove();
    });
</script>
