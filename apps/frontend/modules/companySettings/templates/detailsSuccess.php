<?php include_partial('global/commonSlider'); 
$params = array('company' => $company, 'adminuser' => $adminuser, 'companies' => $companies, 'is_getlokal_admin' => $is_getlokal_admin);
?>
<?php slot('no_map', true) ?>
<?php slot('no_ads', true) ?>

<?php $lng = mb_convert_case(getlokalPartner::getLanguageClass(), MB_CASE_LOWER,'UTF-8');   ?>
<?php $current_culture = sfContext::getInstance()->getUser()->getCulture();   ?>
<?php $languages = sfConfig::get('app_languages_'.$lng)?>

<?php //include_stylesheets_for_form($form) ?>
<?php //include_javascripts_for_form($form) ?>
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
		    	<div class="row">
					<div class="default-container default-form-wrapper col-sm-12 p-15">
						<div class="col-sm-12">
							<?php include_partial('tabsMenu', $params); ?>	   
						</div>
						<h2 class="form-title"><?= __('Description', null, 'company') ?></h2>
						<!-- Form Start -->
						<form id="cs-form" class="default-form" action="<?= url_for('companySettings/details?slug=' . $company->getSlug()) ?>" method="post"<?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
							
							<?= $form['_csrf_token']->render() ?>
					        <?php if ($company->getActivePPPService(true) || $company->getRegisteredPPPService(true)): ?>
					        <div class="feature_icons">
					            <p><?= __('Choose features', null, 'company') ?></p>
					            <?php  //if ($form->getObject()->getActivePPPService(true)):?>
					            <div class="row">
					            	<div class="col-sm-12">
							            <div class="form_box <?= $form[$lng]['description']->hasError() ? 'error' : '' ?>">
							                <?php //echo $form['feature_company_list']->renderLabel() ?>
							                <?= $form['feature_company_list']->render() ?>
							                <?php //echo $form['feature_company_list']->renderError() ?>
							            </div>
						            </div>
					            </div>
					            <div class="row">
						            <div class="col-sm-12">
							            <div class="form_outdoor_seats default-input-wrapper active<?php if($form['outdoor_seats']->hasError()):?> incorrect<?php endif;?>" style="display:none;">
							            	<div class="form_outdoor_seats_mask" style="display:none;"></div>
											<div class="error-txt"><?= $form['outdoor_seats']->renderError() ?></div>
											
											<?= $form['outdoor_seats']->renderLabel(__('Number of outdoor seats:', null, 'company'),array('class'=>"default-label")) ?>
											<?= $form['outdoor_seats']->render(array('class'=>'default-input')) ?>
											<a  title="" class="button_green default-btn success"><?= __('Add', null, 'company') ?></a>
							                <a title="" alt ="" class="default-btn button_green clear_btn"><?= __('Clear', null, 'company') ?></a>
							                <a title="" id="picture_form_close" href="#">
							                    <img alt ="" src="/images/gui/close_small.png">
							                </a>
										</div>
						            </div>
					            </div>
					            <div class="row">
					            	<div class="col-sm-12">
					            		<div class="form_indoor_seats default-input-wrapper active<?php if($form['indoor_seats']->hasError()):?> incorrect<?php endif;?>" style="display:none;">
							            	<div class="form_indoor_seats_mask" style="display:none;"></div>
											<div class="error-txt"><?= $form['indoor_seats']->renderError() ?></div>
											
											<?= $form['indoor_seats']->renderLabel(__('Number of indoor seats:', null, 'company'),array('class'=>"default-label")) ?>
											<?= $form['indoor_seats']->render(array('class'=>'default-input')) ?>
											<a  title="" class="button_green default-btn success"><?= __('Add', null, 'company') ?></a>
							                <a title="" alt ="" class="default-btn button_green clear_btn"><?= __('Clear', null, 'company') ?></a>
							                <a title="" id="picture_form_close" href="#">
							                    <img alt ="" src="/images/gui/close_small.png">
							                </a>
										</div>
						            </div>
					            </div>
					            <div class="row">
					            	<div class="col-sm-12">
							            <div class="form_wifi default-input-wrapper" style="display:none;">
							                <div class="form_wifi_mask" style="display:none;"></div>
							                <h3>Wi-Fi</h3>
							                <?php //echo $form['wifi_access']->render() ?>
							                <div class="custom-row">
												<div class="default-radio">
													<input type="radio" value="0" id="descriptions_wifi_access_0" name="<?= $form['wifi_access']->getName()?>" <?php echo $form['wifi_access']->getValue() === 0 ? "checked='checked'" : ""?>>
													<div class="fake-box"></div>
												</div>
												<label for="radio1" class="default-radio-label"><?= __('Free')?></label>
											</div>
											
											<div class="custom-row">
												<div class="default-radio">
													<input type="radio" value="1" id="descriptions_wifi_access_1" name="<?= $form['wifi_access']->getName()?>"<?php echo $form['wifi_access']->getValue() === 1 ? "checked='checked'" : ""?>>
													<div class="fake-box"></div>
												</div>
												<label for="radio2" class="default-radio-label"><?= __('Paid')?></label>
											</div>

							
							                <div class="clear"></div>
							                <a class="button_green default-btn success"><?= __('Add', null, 'company') ?></a>
							                <a class="button_green default-btn clear_btn"><?= __('Clear', null, 'company') ?></a>
							                <a  id="picture_form_close">
							                    <img src="/images/gui/close_small.png">
							                </a>
							            </div>
						            </div>
					            </div>
					        </div>
					        <?php endif; ?>
					        <div class="row">
								<div class="col-sm-12">
									<div class="default-input-wrapper active<?php if($form[$lng]['description']->hasError()):?> incorrect<?php endif;?>">
										<div class="required-txt">Required</div>
										<div class="error-txt"><?= $form[$lng]['description']->renderError() ?></div>
										
										<?= $form[$lng]['description']->renderLabel($form[$lng]['description']->renderLabelName(),array('class'=>"default-label")) ?>
										<?= $form[$lng]['description']->render(array('class'=>'default-input','placeholder'=>$form[$lng]['description']->renderLabelName())) ?>
									</div><!-- Form TextArea -->
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-12">
									<div class="default-input-wrapper active<?php if($form['en']['description']->hasError()):?> incorrect<?php endif;?>">
										<div class="required-txt">Required</div>
										<div class="error-txt"><?= $form['en']['description']->renderError() ?></div>
										<?= $form['en']['description']->renderLabel(__('Description (English)', null, 'form'),array('class'=>"default-label")) ?>
										<?= $form['en']['description']->render(array('class'=>'default-input','placeholder'=>__('Description (English)', null, 'form'))) ?>
									</div><!-- Form TextArea -->
								</div>
							</div>
					            
					        <?php if(count($languages)>2):?>
					            <?php foreach ($languages as $language):?>
					                <?php if($language != 'en' && $language != $lng):?>
						                <div class="row">
											<div class="col-sm-12">
												<div class="default-input-wrapper active<?php if($form[$language]['description']->hasError()):?> incorrect<?php endif;?>">
													<div class="required-txt">Required</div>
													<div class="error-txt"><?= $form[$language]['description']->renderError() ?></div>
													<?= $form[$language]['description']->renderLabel(__('Description ('.sfConfig::get('app_cultures_en_'.$language).')', null, 'form'),array('class'=>"default-label")) ?>
													<?= $form[$language]['description']->render(array('class'=>'default-input','placeholder'=>__('Description ('.sfConfig::get('app_cultures_en_'.$language).')', null, 'form'))) ?>
												</div><!-- Form TextArea -->
											</div>
										</div>			              
					                <?php endif;?>
					            <?php endforeach;?>
					        <?php endif;?>
					        <?php if ($company->getActivePPPService(true) or $company->getRegisteredPPPService(true)): ?>    
								<div class="row">
									<div class="col-sm-12">
							            <div class="form_box">
							                <?= $form[$lng]['content']->renderLabel() ?>
							                <?= $form[$lng]['content']->render(array('class' => 'tinyMCE')) ?>
							                <?php if($form[$lng]['content']->hasError()):?>
							                <div class="form-message error">
							                	<?= $form[$lng]['content']->renderError() ?>
							                </div>
							                <?php endif;?>
							            </div>
						            </div>
					            </div>
					            
					            <div class="row">
						            <div class="col-sm-12">
							            <div class="form_box <?= $form['en']['content']->hasError() ? 'error' : '' ?>">
							                <?= __('Detailed Description (English)', null, 'form')?>
							                <?= $form['en']['content']->render(array('class' => 'tinyMCE')) ?>
							                <?php if($form['en']['content']->hasError()):?>
							                <div class="form-message error">
							                	<?= $form['en']['content']->renderError() ?>
							                </div>
							                <?php endif;?>
							            </div>
						            </div>
					            </div>
					        
					            <?php if(count($languages)>2):?>
					                <?php foreach ($languages as $language):?>
					                    <?php if($language != 'en' && $language != $lng):?>
					                    	<div class="row">
					                    		<div class="col-sm-12">
							                        <div class="form_box <?= $form[$language]['content']->hasError() ? 'error' : '' ?>">
							                            <?= __('Detailed Description ('.sfConfig::get('app_cultures_en_'.$language).')', null, 'form')?>
							                            <?= $form[$language]['content']->render(array('class' => 'tinyMCE')) ?>
							
							                            <?= $form[$language]['content']->renderError() ?>
							                        </div>
						                        </div>
					                        </div>
					                    <?php endif;?>
					                <?php endforeach;?>
					            <?php endif; ?>
					        <?php endif; ?>
							
							<div class="row">
								<div class="col-sm-12">
									<div class="default-input-wrapper">
										<input type="submit" value="<?= __('Save')?>" class="default-btn success m-10 pull-right" />
									</div>
								</div>
							</div>
						</form>
						<!-- Form End -->
					</div>
				</div>
            </div>
        </div>
    </div>	        
</div>	
<script type="text/javascript" src="/js/company_settings_description.js"></script>
<script type="text/javascript">
    $(document).ready(function () { 
        <?php if($company->getActivePPPService(true)): ?>
            rupaIcons();
        <?php endif; ?>
    });
    $(window).bind("load", function() {
        $("#descriptions_bg_content_ifr").contents().keydown(function(){ formChanged = true;});
        $("#descriptions_en_content_ifr").contents().keydown(function(){ formChanged = true;});
    });
</script>
