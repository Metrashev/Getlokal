<?php include_partial('global/commonSlider'); ?>
<div class="container set-over-slider">
		<div class="row">	
			<div class="container">
				<div class="row">
					<h1 class="col-xs-12 main-form-title"><?php echo __('Change Password') ?></h1>
				</div>
			</div>	          
		</div>
		
		<div class="col-sm-4">
           <div class="section-categories">
                <!-- div class="categories-title">
                    
	            </div><!-- categories-title -->
                <?php include_partial('template'); ?>	            
	       </div>
		</div>
		 <div class="col-sm-8">
            <div class="content-default">	            
                <form action="<?php echo url_for('userSettings/security') ?>" method="post" class="default-form clearfix">
                
                <?php if ($sf_user->hasFlash('notice')): ?>
			        <div class="form-message success">
			            <p><?php echo __($sf_user->getFlash('notice')); ?></p>
			        </div>
			    <?php endif; ?>

  				<?php echo $form[$form->getCSRFFieldName()]; ?>
			    	<div class="row">
						<div class="default-container default-form-wrapper col-sm-12 p-lr-20">
							<div class="col-sm-12">
								<?php include_partial('template', array('showTabs' => true, 'tab' => 'userSettings/security', 'selected' => 'userSettings/security')); ?>	   
							</div>
							<h2 class="form-title"><?php echo __('Change Password') ?></h2>
							<!-- Form Start -->
							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<div class="default-input-wrapper <?=$form['old_password']->hasError() && $form['old_password']->renderError() != '' ? 'incorrect' : '' ?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $form['old_password']->renderLabel(null, array('for' => 'old_password', 'class' => 'default-label'))?>
										<?php echo $form['old_password']->render(array('placeholder' => $form['old_password']->renderPlaceholder(), 'id' => 'old_password', 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $form['old_password']->renderError()?></div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<div class="default-input-wrapper <?=$form['new_password']->hasError() && $form['new_password']->renderError() != '' ? 'incorrect' : '' ?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $form['new_password']->renderLabel(null, array('for' => 'new_password', 'class' => 'default-label'))?>
										<?php echo $form['new_password']->render(array('placeholder' => $form['new_password']->renderPlaceholder(), 'id' => 'new_password', 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $form['new_password']->renderError()?></div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<div class="default-input-wrapper <?=$form['bis_password']->hasError() && $form['bis_password']->renderError() != '' ? 'incorrect' : '' ?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $form['bis_password']->renderLabel(null, array('for' => 'bis_password', 'class' => 'default-label'))?>
										<?php echo $form['bis_password']->render(array('placeholder' => $form['bis_password']->renderPlaceholder(), 'id' => 'bis_password', 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $form['bis_password']->renderError()?></div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-12 m-b-15">
									<div class="default-input-wrapper">
										<input type="submit" value="<?php echo __('Save')?>" class="default-btn success" />
									</div>
								</div>
							</div>
							
							<!-- Form End -->
						</div>
					</div>
				</form>
            </div>
        </div>        
        
		
</div>	