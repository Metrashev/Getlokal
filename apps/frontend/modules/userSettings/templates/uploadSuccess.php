<?php include_partial('global/commonSlider'); ?>
<?php use_helper('Pagination') ?>

<div class="container set-over-slider">
		<div class="row">	
			<div class="container">
				<div class="row">
					<h1 class="col-xs-12 main-form-title"><?php echo __('Add Photo', null, 'company') ?></h1>
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
                <form action="<?php echo url_for('userSettings/upload') ?>" method="post" enctype="multipart/form-data" class="default-form clearfix">
                <?php echo $form['_csrf_token']->render() ?>
			    	<div class="row">
						<div class="default-container default-form-wrapper col-sm-12 small-padding">
							<h2 class="form-title"><?php echo __('Add Photo', null, 'company') ?></h2>

							<?php if ($sf_user->getFlash('error')): ?> 
	                            <div class="form-message error">
	                                <p><?php echo __($sf_user->getFlash('error'), null, 'form') ?></p>
	                            </div> 
	                        <?php endif; ?>

							<div class="col-sm-12">
								<?php include_partial('template', array('showTabs' => true, 'tab' => 'userSettings/images', 'selected' => 'userSettings/upload')); ?>	   
							</div>
							<!-- Form Start -->
							<div class="row">
								<div class="col-sm-12">
									<div class="file-input-wrapper <?php echo $form['file']->hasError() ? 'incorrect' : '' ?>">
			                            <label for="file" class="file-label">
			                                <?php echo __('No File chosen', null, 'form'); ?>
			                                <?php echo $form['file']->render(array('placeholder' => $form['file']->renderPlaceholder(), 'id' => 'file', 'class' => 'file-input')) ?>
			                            </label>
			                            <div class="error-txt"><?php echo $form['file']->renderError() ?></div>
			                        </div>    
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-12">
									<div class="default-input-wrapper <?=$form['caption']->hasError() && $form['caption']->renderError() != '' ? 'incorrect' : '' ?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $form['caption']->renderLabel(null, array('for' => 'caption', 'class' => 'default-label'))?>
										<?php echo $form['caption']->render(array('placeholder' => $form['caption']->renderPlaceholder(), 'id' => 'caption', 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $form['caption']->renderError()?></div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-12">
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
