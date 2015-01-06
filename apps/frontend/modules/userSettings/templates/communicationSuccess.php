<?php include_partial('global/commonSlider'); 

if ($user->getUserProfile()->getCountry()->getSlug() == 'bg') {
	$newsletterUser = 'Развлекателни бюлетини';
	$newsletterBusiness = 'Бизнес бюлетини';
	$newsletterPromo = 'Известия за игри и промоции';

	$newsletterGroups = array($newsletterUser, $newsletterBusiness, $newsletterPromo);
}
elseif ($user->getUserProfile()->getCountry()->getSlug() == 'ro') {
	$newsletterUser = 'Newsletter de comunitate';
	$newsletterBusiness = 'Newsletter business';
	$newsletterPromo = 'Jocuri si promotii';

	$newsletterGroups = array($newsletterUser, $newsletterBusiness, $newsletterPromo);
}
else {
	$newsletterUser = 'Community newsletters';
	$newsletterBusiness = 'Business newsletters';
	$newsletterPromo = 'Games and promotions';

	$newsletterGroups = array($newsletterUser, $newsletterBusiness, $newsletterPromo);
}
$userSettings = $user->getUserProfile()->getUserSetting();
?>
<div class="container set-over-slider">
		<div class="row">	
			<div class="container">
				<div class="row">
					<h1 class="col-xs-12 main-form-title"><?php echo __('Communication', null, 'company') ?></h1>
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
                <form action="<?php echo url_for('userSettings/communication') ?>" method="post" class="default-form clearfix">
			    	<div class="row">
						<div class="default-container default-form-wrapper col-sm-12 p-20">
							<h2 class="form-title"><?php echo __('Communication', null, 'company') ?></h2>
							<!-- Form Start -->
							<div class="col-sm-12">
								<div class="custom-row">
									<div class="default-checkbox">
										<input <?=$userSettings->getAllowContact() ? 'checked="checked"' : ''?> type="checkbox" id="communication_settings_allow_contact" name="communication_settings[allow_contact]" >
										<div class="fake-box"></div>
									</div>
									<label for="Checkbox01" class="default-checkbox-label">Обще комуникация</label>
								</div><!-- Form Checkbox -->
		
								<div class="custom-row">
									<div class="default-checkbox" style="margin-left: 20px;">
										<input <?=$userSettings->getAllowNewsletter() ? 'checked="checked"' : ''?> type="checkbox" id="Checkbox02" name="communication_settings[allow_newsletter]">
										<div class="fake-box"></div>
									</div>
									<label for="Checkbox02" class="default-checkbox-label"><?=$newsletterUser?></label>
								</div><!-- Form Checkbox -->
								<?php if (isset($usernewsletters) && $usernewsletters){
				                        foreach ($usernewsletters as $key => $value){
				                        	$newsletter = Doctrine_Core::getTable('Newsletter')->findOneById($key); 
				                            if ($newsletter && $newsletter->getUserGroup() == $newsletterUser ){ ?>
				                                <?php $newsletterStatus = NewsletterUserTable::getPerUserAndNewsletter($user->getId(), $newsletter->getId()); ?>
												<div class="custom-row">
													<div class="default-checkbox" style="margin-left: 40px;">
					                                    <input type="checkbox" id="Checkbox05" <?php echo ($newsletterStatus && $newsletterStatus->getIsActive()) ? 'checked="checked"' : '' ?>  name="communication_settings[newsletter_<?php echo $key; ?>]">
					                                    <div class="fake-box"></div>
								                    </div>
								                    <label for="Checkbox05" class="default-checkbox-label"><?=$newsletter->getName()?></label>
								                </div>
				                            <?php }
				                            }
				                      } 
				                ?>		
								<div class="custom-row">
									<div class="default-checkbox" style="margin-left: 20px;">
										<input <?=$userSettings->getAllowBCmc() ? 'checked="checked"' : ''?> type="checkbox" id="Checkbox03" name="communication_settings[allow_b_cmc]" >
										<div class="fake-box"></div>
									</div>
									<label for="Checkbox03" class="default-checkbox-label"><?=$newsletterBusiness?></label>
								</div><!-- Form Checkbox -->
		
								<div class="custom-row">
									<div class="default-checkbox" style="margin-left: 20px;">
										<input <?=$userSettings->getAllowPromo() ? 'checked="checked"' : ''?> type="checkbox" id="Checkbox04" name="communication_settings[allow_promo]">
										<div class="fake-box"></div>
									</div>
									<label for="Checkbox04" class="default-checkbox-label"><?=$newsletterPromo?></label>
								</div><!-- Form Checkbox -->
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