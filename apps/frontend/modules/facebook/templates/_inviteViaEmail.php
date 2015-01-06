                <div class="clear"></div>                
                <div class="success_msg"></div>
                <div class="clear"></div>
                <div class="content_invite">
                	<a href="#" class="pink">X</a>
                    <h2><?php echo __('Send Your Invite via e-mail', null, 'user')?></h2>

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
					$('.content_invite a.pink').click(function() {
						$('.content_invite').slideUp(300);
					});
				});
                </script>