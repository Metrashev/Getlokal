<?php include_partial('global/commonSlider'); 
$params = array('company' => $company, 'adminuser' => $adminuser, 'companies' => $companies, 'is_getlokal_admin' => $is_getlokal_admin);
?>
<div class="container set-over-slider">
		<div class="row">	
			<div class="container">
				<div class="row">
					<?php include_partial('topMenu', $params); ?>	
				</div>
			</div>	          
			
		<div class="col-sm-3">
           <div class="section-categories">
                 <?php include_partial('rightMenu', $params); ?>	            
	       </div>
		</div>
		 <div class="col-sm-9">
            <div class="content-default">	            
                <form action="<?php echo url_for('companySettings/hours?slug='. $company->getSlug()) ?>" method="post" class="default-form clearfix">
                	<?php echo $form['_csrf_token']->render() ?>
			    	<div class="row">
						<div class="default-container default-form-wrapper col-sm-12 p-15">
							<div class="col-sm-12">
								<?php include_partial('tabsMenu', $params); ?>
							</div>
							<h2 class="form-title"><?php echo __('Working Hours', null,'company')?></h2>
							<!-- Form Start -->
							<?php foreach(array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun') as $day): ?>
							
							<div class="row">
								<div class="col-sm-4">
									<div class="default-input-wrapper <?=$form[$day.'_from']->hasError() && $form[$day.'_from']->renderError() != '' ? 'incorrect' : '' ?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $form[$day.'_from']->renderLabel(null, array('for' => $day.'_from', 'class' => 'default-label'))?>
										<?php echo $form[$day.'_from']->render(array('placeholder' => $form[$day.'_from']->renderPlaceholder(), 'id' => $day.'_from', 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $form[$day.'_from']->renderError()?></div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="default-input-wrapper <?=$form[$day.'_to']->hasError() && $form[$day.'_to']->renderError() != '' ? 'incorrect' : '' ?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $form[$day.'_to']->renderLabel(null, array('for' => $day.'_to', 'class' => 'default-label'))?>
										<?php echo $form[$day.'_to']->render(array('placeholder' => $form[$day.'_to']->renderPlaceholder(), 'id' => $day.'_to', 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $form[$day.'_from']->renderError()?></div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="default-checkbox">
										<input class="input-check" type="checkbox" <?php echo ($form->getObject()->get($day.'_from') == '1' AND $form->getObject()->get($day.'_to') == '1') ? 
										'checked="checked"' :''?> id="company_close_<?php echo $day?>" name="company_detail[close_<?php echo $day?>]">
										<div class="fake-box"></div>
									</div>
									<label for="company_detail[close_<?php echo $day?>]" class="default-checkbox-label">
										<?= __('Closed',null,'company') ?>
									</label>
								</div>
							</div>
						    <?php endforeach ?>
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
</div>	