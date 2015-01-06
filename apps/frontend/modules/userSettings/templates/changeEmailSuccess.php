<?php include_partial('global/commonSlider'); ?>
<div class="container set-over-slider">
		<div class="row">	
			<div class="container">
				<div class="row">
					<h1 class="col-xs-12 main-form-title"><?php echo __('Change Email') ?></h1>
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
                <form action="<?php echo url_for('userSettings/changeEmail') ?>" method="post" class="default-form clearfix">

                <?php if ($sf_user->hasFlash('notice')): ?>
			        <div class="form-message success">
			            <p><?php echo __($sf_user->getFlash('notice')); ?></p>
			        </div>
			    <?php endif; ?>
			    <?php if ($sf_user->hasFlash('error')): ?>
			        <div class="form-message error">
			            <p><?php echo __($sf_user->getFlash('error')); ?></p>
			        </div>
			    <?php endif; ?>

  				<?php echo $form[$form->getCSRFFieldName()]; ?>
			    	<div class="row">
						<div class="default-container default-form-wrapper p-lr-20 col-sm-12">
							<div class="col-sm-12">
								<?php include_partial('template', array('showTabs' => true, 'tab' => 'userSettings/security', 'selected' => 'userSettings/changeEmail')); ?>	   
							</div>
							<h2 class="form-title"><?php echo __('Change Email') ?></h2>
							<!-- Form Start -->
							<div class="row">
								<div class="col-sm-12 col-md-6 col-lg-6">
									<div class="default-input-wrapper <?=$form['email_address']->hasError() && $form['email_address']->renderError() != '' ? 'incorrect' : '' ?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $form['email_address']->renderLabel(null, array('for' => 'email_address', 'class' => 'default-label'))?>
										<?php echo $form['email_address']->render(array('placeholder' => $form['email_address']->renderPlaceholder(), 'id' => 'email_address', 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $form['email_address']->renderError()?></div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-12 m-b-15">
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