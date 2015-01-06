<?php include_partial('global/commonSlider'); ?>
<div class="container set-over-slider">
		<div class="row">	
			<div class="container">
				<div class="row">
					<h1 class="col-xs-12 main-form-title"><?php echo __('Find your company in getlokal',null,'company'); ?></h1>
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
                <form action="<?php echo url_for('userSettings/findMyCompany') ?>" method="post" class="default-form clearfix">
			    	<div class="row">
						<div class="default-container default-form-wrapper col-sm-12">
							<h2 class="form-title"><?php echo __('Find your company in getlokal',null,'company'); ?></h2>
							<!-- Form Start -->
							<div class="row">
								<div class="col-sm-6">
									<div class="default-input-wrapper <?=$form['mycompany']->hasError() && $form['mycompany']->renderError() != '' ? 'incorrect' : '' ?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $form['mycompany']->renderLabel(null, array('for' => 'mycompany', 'class' => 'default-label'))?>
										<?php echo $form['mycompany']->render(array('placeholder' => $form['mycompany']->renderPlaceholder(), 'id' => 'mycompany', 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $form['mycompany']->renderError()?></div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-12">
									<div class="default-input-wrapper">
										<input type="submit" value="<?php echo __('Search')?>" class="default-btn success" />
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