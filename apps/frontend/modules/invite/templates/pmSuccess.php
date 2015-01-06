<?php include_partial('global/commonSlider'); ?>
<div class="container set-over-slider">
		<div class="row">	
			<div class="container">
				<div class="row">
					<h1 class="col-xs-12 main-form-title"><?php echo __('Send Your Invite via e-mail', null, 'user')?></h1>
				</div>
			</div>	          
		</div>
		<form class="default-form clearfix" id="articleForm" action="<?php echo url_for('@invite_pm') ?>" method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="default-container default-form-wrapper col-sm-12">
					<?php for ($i = 1; $i <= 5; $i++){ ?>
						<div class="row">
			                <div class="col-sm-12">
								<div class="default-input-wrapper required <?php echo $sendInvitePMForm['email_' . $i]->hasError() ? 'incorrect' : '' ?>">
				                    <?php echo $sendInvitePMForm['email_' . $i]->renderLabel(null, array('for' => 'email_'.$i, 'class' => 'default-label'))?>
									<?php echo $sendInvitePMForm['email_' . $i]->render(array('placeholder' => $sendInvitePMForm['email_' . $i]->renderPlaceholder(), 'id' => 'email_' . $i, 'class' => 'default-input' ));  ?>							
									<div class="error-txt"><?php echo $sendInvitePMForm['email_' . $i]->renderError()?></div>
			                    </div>
			                </div>
			            </div>	
			        <?php } ?>
		        	<div class="row">
		                <div class="col-sm-12">
							<div class="default-input-wrapper required <?php echo $sendInvitePMForm['body']->hasError() ? 'incorrect' : '' ?>">
			                    <?php echo $sendInvitePMForm['body']->renderLabel(null, array('for' => 'body', 'class' => 'default-label'))?>
								<?php echo $sendInvitePMForm['body']->render(array('placeholder' => $sendInvitePMForm['body']->renderPlaceholder(), 'id' => 'body', 'class' => 'default-input' ));  ?>							
								<div class="error-txt"><?php echo $sendInvitePMForm['body']->renderError()?></div>
		                    </div>
		                </div>
		            </div>
		            <?php if (sfConfig::get('app_recaptcha_active', false)){ ?>
						<div class="row margin-bottom-small">
							<div class="col-sm-12">
								<div class="default-input-wrapper required <?=$sendInvitePMForm['captcha']->hasError() ? 'incorrect' : ''?>">
									<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
									<div class="error-txt"><?=($sendInvitePMForm['captcha']->hasError() ? $sendInvitePMForm['captcha']->renderError() : '')?></div>
									<?php echo $sendInvitePMForm['captcha']->renderLabel(null, array('for' => 'captcha', 'class' => 'default-label'))?>
									<?php echo $sendInvitePMForm['captcha']->render(array('placeholder' => $sendInvitePMForm['captcha']->renderPlaceholder(), 'id' => 'captcha'));  ?>
								</div>
							</div>
						</div>
					<?php }?>
			        <div class="row">
	                    <div class="col-sm-12 form-btn-row">
	                        <input type="submit" value="<?=__('Send')?>" class="default-btn success pull-left" />							
	                    </div>
					</div>
				</div>
			</div>
		</form>
</div>