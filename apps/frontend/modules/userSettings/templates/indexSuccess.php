<?php include_partial('global/commonSlider'); ?>
<div class="container set-over-slider">
		<div class="row">	
			<div class="container">
				<div class="row">
					<h1 class="col-xs-12 main-form-title"><?php echo __('Account Settings'); ?></h1>
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
                <form action="<?php echo url_for('userSettings/index') ?>" method="post" class="default-form clearfix">
                <?php echo $form[$form->getCSRFFieldName()]; ?>
                
                <?php if ($sf_user->hasFlash('notice')): ?>
			        <div class="form-message success">
			            <p><?php echo __($sf_user->getFlash('notice')); ?></p>
			        </div>
			    <?php endif; ?>

			    	<div class="row">
						<div class="default-container default-form-wrapper p-lr-20 col-sm-12">
							<h2 class="form-title"><?php echo __('Account Settings')?></h2>
							<!-- Form Start -->
							<div class="row">
								<div class="col-sm-6">
									<div class="default-input-wrapper <?php if( $form['sf_guard_user']['first_name']->hasError()):?> incorrect<?php endif;?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<div class="error-txt">
											<?=($form['sf_guard_user']['first_name']->hasError() ? $form['sf_guard_user']['first_name']->renderError() : '')?>
										</div>
										<label for="<?= $form['sf_guard_user']['first_name']->getName()?>" class="default-label"><?= __('Name', null, 'user')?></label>
										<?php echo $form['sf_guard_user']['first_name']->render(array('class' => 'default-input','placeholder' => __('Name', null, 'user')));?>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="default-input-wrapper <?php if( $form['sf_guard_user']['last_name']->hasError()):?> incorrect<?php endif;?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<div class="error-txt">
											<?=($form['sf_guard_user']['last_name']->hasError() ? $form['sf_guard_user']['first_name']->renderError() : '')?>
										</div>
										<label for="<?= $form['sf_guard_user']['last_name']->getName()?>" class="default-label"><?= __('Surname', null, 'user')?></label>
										<?php echo $form['sf_guard_user']['last_name']->render(array('class' => 'default-input','placeholder' => __('Surname', null, 'user')));?>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-6">
									<div class="default-input-wrapper required <?=$form['country_id']->hasError() && $form['country_id']->renderError() != '' ? 'incorrect' : '' ?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $form['country_id']->renderLabel(null, array('for' => 'country_id', 'class' => 'default-label'))?>
										<?php echo $form['country_id']->render(array('placeholder' => $form['country_id']->renderPlaceholder(), 'id' => 'country_id', 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $form['country_id']->renderError()?></div>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="default-input-wrapper required <?=$form['city_id']->hasError() && $form['city_id']->renderError() != '' ? 'incorrect' : '' ?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $form['city_id']->renderLabel(null, array('for' => 'city_id', 'class' => 'default-label'))?>
										<?php echo $form['city_id']->render(array('placeholder' => $form['city_id']->renderPlaceholder(), 'id' => 'city_id', 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $form['city_id']->renderError()?></div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-6">
									<div class="default-input-wrapper select-wrapper required <?=$form['gender']->hasError() && $form['gender']->renderError() != '' ? 'incorrect' : '' ?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $form['gender']->renderLabel(null, array('for' => 'country_id', 'class' => 'default-label'))?>
										<?php echo $form['gender']->render(array('placeholder' => $form['country_id']->renderPlaceholder(), 'id' => 'gender', 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $form['gender']->renderError()?></div>
									</div>
								</div>
								
								<div class="col-sm-2">
									<!-- div class="default-input-wrapper required <?=$form['birthdate']->hasError() && $form['birthdate']->renderError() != '' ? 'incorrect' : '' ?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $form['birthdate']->renderLabel(null, array('for' => 'birthdate', 'class' => 'default-label'))?>
										<?php echo $form['birthdate']->render(array('placeholder' => $form['birthdate']->renderPlaceholder(), 'id' => 'birthdate', 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $form['city_id']->renderError()?></div>
									</div-->
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-4">
									<div class="default-input-wrapper <?=$form['phone_number']->hasError() && $form['phone_number']->renderError() != '' ? 'incorrect' : '' ?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $form['phone_number']->renderLabel(null, array('for' => 'phone_number', 'class' => 'default-label'))?>
										<?php echo $form['phone_number']->render(array('placeholder' => $form['phone_number']->renderPlaceholder(), 'id' => 'phone_number', 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $form['phone_number']->renderError()?></div>
									</div>
								</div>
								
								<div class="col-sm-4">
									<div class="default-input-wrapper <?=$form['website']->hasError() && $form['website']->renderError() != '' ? 'incorrect' : '' ?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $form['website']->renderLabel(null, array('for' => 'website', 'class' => 'default-label'))?>
										<?php echo $form['website']->render(array('placeholder' => $form['website']->renderPlaceholder(), 'id' => 'website', 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $form['website']->renderError()?></div>
									</div>
								</div>
								
								<div class="col-sm-4">
									<div class="default-input-wrapper <?=$form['blog_url']->hasError() && $form['blog_url']->renderError() != '' ? 'incorrect' : '' ?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $form['blog_url']->renderLabel(null, array('for' => 'blog_url', 'class' => 'default-label'))?>
										<?php echo $form['blog_url']->render(array('placeholder' => $form['blog_url']->renderPlaceholder(), 'id' => 'blog_url', 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $form['blog_url']->renderError()?></div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-12">
									<div class="default-input-wrapper <?=$form['summary']->hasError() && $form['summary']->renderError() != '' ? 'incorrect' : '' ?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $form['summary']->renderLabel(null, array('for' => 'summary', 'class' => 'default-label'))?>
										<?php echo $form['summary']->render(array('placeholder' => $form['summary']->renderPlaceholder(), 'id' => 'summary', 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $form['summary']->renderError()?></div>
									</div>
								</div>
							</div>
				
							<div class="row">
								<div class="col-sm-12">
									<div class="default-input-wrapper <?=$form['facebook_url']->hasError() && $form['facebook_url']->renderError() != '' ? 'incorrect' : '' ?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $form['facebook_url']->renderLabel(null, array('for' => 'facebook_url', 'class' => 'default-label'))?>
										<?php echo $form['facebook_url']->render(array('placeholder' => $form['facebook_url']->renderPlaceholder(), 'id' => 'facebook_url', 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $form['facebook_url']->renderError()?></div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-12">
									<div class="default-input-wrapper <?=$form['twitter_url']->hasError() && $form['twitter_url']->renderError() != '' ? 'incorrect' : '' ?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $form['twitter_url']->renderLabel(null, array('for' => 'twitter_url', 'class' => 'default-label'))?>
										<?php echo $form['twitter_url']->render(array('placeholder' => $form['twitter_url']->renderPlaceholder(), 'id' => 'twitter_url', 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $form['twitter_url']->renderError()?></div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-12">
									<div class="default-input-wrapper <?=$form['google_url']->hasError() && $form['google_url']->renderError() != '' ? 'incorrect' : '' ?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $form['google_url']->renderLabel(null, array('for' => 'google_url', 'class' => 'default-label'))?>
										<?php echo $form['google_url']->render(array('placeholder' => $form['google_url']->renderPlaceholder(), 'id' => 'google_url', 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $form['google_url']->renderError()?></div>
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