<?php slot('no_map', true) ?>
<div class="settings_content settings_content_invite">
    <h2 class="dotted"><?php echo __('Send Your Invite via e-mail', null, 'user')?></h2>

    <?php if (!$sf_user->getFlash('notice')) : ?>
        <form action="<?php echo url_for('@invite_pm') ?>" method="POST">
            <div class="email_fields">
                <div class="email">
            <?php for ($i = 1; $i <= 5; $i++) : ?>
                <div class="form_box email_input <?php echo ($sendInvitePMForm['email_' . $i]->hasError()) ? 'error' : '' ?>">
                    <?php echo $sendInvitePMForm['email_' . $i]->renderLabel() ?>
                    <?php echo $sendInvitePMForm['email_' . $i] ?>
                    <?php echo $sendInvitePMForm['email_' . $i]->renderError() ?>
                </div>
            <?php endfor; ?>
                </div>
    
		         <div class="mailbody form_box <?php echo ($sendInvitePMForm['body']->hasError()) ? 'error' : '' ?>">
					<?php echo $sendInvitePMForm['body']->renderLabel() ?>
					<?php echo $sendInvitePMForm['body'] ?>
					<?php echo $sendInvitePMForm['body']->renderError() ?>
		                 
		            <?php echo $sendInvitePMForm->renderHiddenFields(); ?>
		         </div>
		         <div class="clear"></div>
		         <?php if (sfConfig::get('app_recaptcha_active', false)): ?>
		            <div class="form_box<?php if ($sendInvitePMForm['captcha']->hasError()): ?> error<?php endif; ?>">
		                <div class="captcha_out">
		                   <label><?php echo __('Security check. Enter the characters from the picture below', null, 'form') ?><span class="pink">*</span></label>
		                    <?php echo $sendInvitePMForm['captcha']->render(); ?>
		                </div>
		                <?php if ($sendInvitePMForm['captcha']->hasError()): ?>
		                    <p class="error"><?php echo $sendInvitePMForm['captcha']->renderError(); ?></p>
		                <?php endif; ?>
		            </div>
		        <?php endif; ?>
		         <input type="submit" class="button_green" value="<?php echo __('Send', null, 'user') ?>" />
			</div>
		</form>   
    <?php else : ?>
        <p><a href="<?php echo url_for("@invite_pm") ?>" title="<?php echo __('Send another invite?', null, 'user') ?>"><?php echo __('Send another invite?', null, 'user') ?></a></p>
    <?php endif; ?>
</div>       

<script type="text/javascript">
    $(document).ready(function() {
        $('.path_wrap').css('display', 'none');
//        $('.search_bar').css('display', 'none');
        $(".banner").css("display", "none");
    });
</script>