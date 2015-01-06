<?php 	
	$lng = mb_convert_case(getlokalPartner::getLanguageClass(getlokalPartner::getInstanceDomain()), MB_CASE_LOWER, 'UTF-8');
	$lng2 = 'en';
	$tab_lng=sfConfig::get('app_cultures_en_'.$lng);
?>
	
<form class="default-form clearfix" id="articleForm" action="<?php echo url_for('article/'.($form->getObject()->isNew() ? 'create' : 'edit').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
		<div class="row">
			<div class="default-container default-form-wrapper col-sm-12">					
					<?php if($sf_user->getFlash('newsuccess')):?>
					    <div class="form-message">
					      <?php echo  __($sf_user->getFlash('newsuccess'),null,'article') ?>
					    </div>
					 <?php endif;?>
					 <?php if($sf_user->getFlash('newerror')):?>
					    <div class="form-message error">
					      <?php echo  __($sf_user->getFlash('newerror'),null,'article') ?>
					    </div>
					 <?php endif;?>
					 <?php if($sf_user->getFlash('slug_culture_error')):?>
					    <div class="form-message error">
					      <?php echo  __($sf_user->getFlash('slug_culture_error'),null,'article') ?>
					    </div>
					 <?php endif;?>
					
					  <?php if($sf_user->getFlash('slug_en_error')):?>
					    <div class="form-message error">
					      <?php echo  __($sf_user->getFlash('slug_en_error'),null,'article') ?>
					    </div>
					 <?php endif;?>
					
					  <?php if($global_errors = $form->getGlobalErrors()):?>
					     <?php foreach($global_errors as $er):?>
					    <div class="form-message error">
					      <?php echo $er->getMessage();?>
					    </div>
					    <?php endforeach;?>
					 <?php endif;?>
					 
					<h2 class="form-title"><?php echo __('Article info', null, 'form'); ?></h2>
					
					<ul class="nav nav-tabs default-form-tabs" role="tablist" id="myTab_Lang">
						<li class="active"><a href="#SectionBG" role="tab" data-toggle="tab"><?php echo __($tab_lng, null, 'company');?></a></li>
						<li><a href="#SectionEN" role="tab" data-toggle="tab"><?php echo __('English', null, 'form');?></a></li>
					</ul>
				
					<div class="tab-content default-form-tabs-content">
						<div class="tab-pane active" id="SectionBG">
							<div id="container_bg">
							
								<div class="row">
									<div class="col-sm-12">
										<div class="default-input-wrapper required <?php echo $form[$lng]['title']->hasError() && $form[$lng]['title']->renderError() != '' ? 'incorrect' : '' ?>">
											<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
											<?php echo $form[$lng]['title']->renderLabel(null, array('for' => 'name', 'class' => 'default-label'))?>
											<?php echo $form[$lng]['title']->render(array('placeholder' => $form[$lng]['title']->renderPlaceholder(), 'id' => 'name', 'class' => 'default-input' ));  ?>							
											<div class="error-txt"><?php echo $form[$lng]['title']->renderError()?></div>
										</div>
									</div>			
								</div>	
													
								<div class="row">
									<div class="col-sm-12">
										<div class="required article-content-tny-mce <?php echo $form[$lng]['content']->hasError() ? 'incorrect' : '' ?>">
											<h2 class="form-title"><?php echo $form[$lng]['content']->renderLabel(null, array('for' => 'content', 'class' => 'default-label'))?></h2>
											<?php echo $form[$lng]['content']->render(array('class' => 'default-input' ));  ?>							
											<div class="error-txt"><?php echo $form[$lng]['content']->renderError()?></div>
										</div>
									</div>			
								</div>
								
								<div class="row">
									<div class="col-sm-12">
										<div class="default-input-wrapper required <?php echo $form[$lng]['quotation']->hasError() ? 'incorrect' : '' ?>">
											<?php echo $form[$lng]['quotation']->renderLabel(null, array('for' => 'quotation', 'class' => 'default-label'))?>
											<?php echo $form[$lng]['quotation']->render(array('placeholder' => $form[$lng]['quotation']->renderPlaceholder(), 'id' => 'quotation', 'class' => 'default-input' ));  ?>							
											<div class="error-txt"><?php echo $form[$lng]['quotation']->renderError()?></div>
										</div>
									</div>			
								</div>
								
								<div class="row">
									<div class="col-sm-12">
										<div class="default-input-wrapper required">
											<label for="quote_code" class="default-label">Quotation code</label>
											<input type="text" value="{/quotation/}" class='default-input' id="quote_code">
											<?php echo __('Copy this code and position it where you want the quotation to appear in the text!',null,'article');?>
										</div>
									</div>			
								</div>
								
								<?php if ($user_profile->hasCredential('article_editor') ) { ?>
								<h2 class="form-title"><?php echo __('SEO',null,'article');?></h2>
					
								<div class="row">
									<div class="col-sm-6">
										<div class="default-input-wrapper required <?php echo $form[$lng]['slug']->hasError() ? 'incorrect' : '' ?>">
											<?php echo $form[$lng]['slug']->renderLabel(null, array('for' => 'slug', 'class' => 'default-label'))?>
											<?php echo $form[$lng]['slug']->render(array('placeholder' => $form[$lng]['slug']->renderPlaceholder(), 'id' => 'slug', 'class' => 'default-input' ));  ?>							
											<div class="error-txt"><?php echo $form[$lng]['slug']->renderError()?></div>
										</div>
									</div>			
								
									<div class="col-sm-6">
										<div class="default-input-wrapper required <?php echo $form[$lng]['keywords']->hasError() ? 'incorrect' : '' ?>">
											<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
											<?php echo $form[$lng]['keywords']->renderLabel(null, array('for' => 'keywords', 'class' => 'default-label'))?>
											<?php echo $form[$lng]['keywords']->render(array('placeholder' => $form[$lng]['keywords']->renderPlaceholder(), 'id' => 'keywords', 'class' => 'default-input' ));  ?>							
											<div class="error-txt"><?php echo $form[$lng]['keywords']->renderError()?></div>
										</div>
									</div>			
								</div>
								
								<div class="row">
									<div class="col-sm-12">
										<div class="default-input-wrapper required <?php echo $form[$lng]['description']->hasError() ? 'incorrect' : '' ?>">
											<?php echo $form[$lng]['description']->renderLabel(null, array('for' => 'description', 'class' => 'default-label'))?>
											<?php echo $form[$lng]['description']->render(array('placeholder' => $form[$lng]['description']->renderPlaceholder(), 'id' => 'description', 'class' => 'default-input' ));  ?>							
											<div class="error-txt"><?php echo $form[$lng]['description']->renderError()?></div>
										</div>
									</div>			
								</div>
								<?php } ?>
				
							</div>
						</div>
						<div class="tab-pane" id="SectionEN">
							<div id="container_en">
								<div class="row">
									<div class="col-sm-12">
										<div class="default-input-wrapper  <?php echo $form['en']['title']->hasError() && $form['en']['title']->renderError() != '' ? 'incorrect' : '' ?>">
											<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
											<?php echo $form['en']['title']->renderLabel(null, array('for' => 'name', 'class' => 'default-label'));?>
											<?php echo $form['en']['title']->render(array('placeholder' => $form['en']['title']->renderPlaceholder().' ('. __('English').')', 'id' => 'name', 'class' => 'default-input' ));  ?>							
											<div class="error-txt"><?php echo $form['en']['title']->renderError()?></div>
										</div>
									</div>			
								</div>	
													
								<div class="row">
									<div class="col-sm-12">
										<div class="required article-content-tny-mce <?php echo $form['en']['content']->hasError() ? 'incorrect' : '' ?>">
											<h2 class="form-title"><?php echo $form['en']['content']->renderLabel(null, array('for' => 'content', 'class' => 'default-label'))?></h2>
											<?php echo $form['en']['content']->render(array('class' => 'default-input' ));  ?>							
											<div class="error-txt"><?php echo $form['en']['content']->renderError()?></div>
										</div>
									</div>			
								</div>
								
								<div class="row">
									<div class="col-sm-12">
										<div class="default-input-wrapper required <?php echo $form['en']['quotation']->hasError() ? 'incorrect' : '' ?>">
											<?php echo $form['en']['quotation']->renderLabel(null, array('for' => 'quotation', 'class' => 'default-label'))?>
											<?php echo $form['en']['quotation']->render(array('placeholder' => $form['en']['quotation']->renderPlaceholder().' ('. __('English').')', 'id' => 'quotation', 'class' => 'default-input' ));  ?>							
											<div class="error-txt"><?php echo $form['en']['quotation']->renderError()?></div>
										</div>
									</div>			
								</div>
								
								<div class="row">
									<div class="col-sm-12">
										<div class="default-input-wrapper required">
											<label for="quote_code" class="default-label">Quotation code<?php echo ' ('. __('English').')';?></label>
											<input type="text" value="{/quotation/}" class='default-input' id="quote_code">
											<?php echo __('Copy this code and position it where you want the quotation to appear in the text!',null,'article');?>
										</div>
									</div>			
								</div>
								
								<?php if ($user_profile->hasCredential('article_editor') ) { ?>
								<h2 class="form-title"><?php echo __('SEO',null,'article');?></h2>
					
								<div class="row">
									<div class="col-sm-6">
										<div class="default-input-wrapper required <?php echo $form['en']['slug']->hasError() ? 'incorrect' : '' ?>">
											<?php echo $form['en']['slug']->renderLabel(null, array('for' => 'slug', 'class' => 'default-label'))?>
											<?php echo $form['en']['slug']->render(array('placeholder' => $form['en']['slug']->renderPlaceholder().' ('. __('English').')', 'id' => 'slug', 'class' => 'default-input' ));  ?>							
											<div class="error-txt"><?php echo $form['en']['slug']->renderError()?></div>
										</div>
									</div>			
								
									<div class="col-sm-6">
										<div class="default-input-wrapper required <?php echo $form['en']['keywords']->hasError() ? 'incorrect' : '' ?>">
											<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
											<?php echo $form['en']['keywords']->renderLabel(null, array('for' => 'keywords', 'class' => 'default-label'))?>
											<?php echo $form['en']['keywords']->render(array('placeholder' => $form['en']['keywords']->renderPlaceholder().' ('. __('English').')', 'id' => 'keywords', 'class' => 'default-input' ));  ?>							
											<div class="error-txt"><?php echo $form['en']['keywords']->renderError()?></div>
										</div>
									</div>			
								</div>
								
								<div class="row">
									<div class="col-sm-12">
										<div class="default-input-wrapper required <?php echo $form['en']['description']->hasError() ? 'incorrect' : '' ?>">
											<?php echo $form['en']['description']->renderLabel(null, array('for' => 'description', 'class' => 'default-label'))?>
											<?php echo $form['en']['description']->render(array('placeholder' => $form['en']['description']->renderPlaceholder().' ('. __('English').')', 'id' => 'description', 'class' => 'default-input' ));  ?>							
											<div class="error-txt"><?php echo $form['en']['description']->renderError()?></div>
										</div>
									</div>			
								</div>
								<?php } ?>
								
							</div>
						</div>
					</div>
		
					
						
					
					<h2 class="form-title"><?php echo __('Uploading images', null, 'form'); ?></h2>
					<?php
						$i = 0; 
						foreach($form['newImages'] as $k=>$img) {
							$i++;
					?>
							<div class="row">
								<div class="col-sm-4">
									<div class="file-input-wrapper <?php echo $img['filename']->hasError() ? 'incorrect' : '' ?>">
			                            <label for="filename_<?=$i?>" class="file-label">
			                                <?php echo __('No File chosen', null, 'form'); ?>
			                                <?php echo $img['filename']->render(array('placeholder' => $img['filename']->renderPlaceholder(), 'id' => 'filename_'.$i, 'class' => 'file-input')) ?>
			                            </label>
			                            <div class="error-txt"><?php echo $img['filename']->renderError() ?></div>
			                        </div>                        
								</div>
								
								<div class="col-sm-4">
									<div class="default-input-wrapper required <?php echo $img['descrption']->hasError() ? 'incorrect' : '' ?>">
										<?php echo $img['descrption']->renderLabel(null, array('for' => 'descrption_'.$i, 'class' => 'default-label'))?>
										<?php echo $img['descrption']->render(array('placeholder' => $img['descrption']->renderPlaceholder(), 'id' => 'descrption_'.$i, 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $img['descrption']->renderError()?></div>
									</div>
								</div>
								
								<div class="col-sm-4">
									<div class="default-input-wrapper required <?php echo $img['source']->hasError() ? 'incorrect' : '' ?>">
										<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
										<?php echo $img['source']->renderLabel(null, array('for' => 'source_'.$i, 'class' => 'default-label'))?>
										<?php echo $img['source']->render(array('placeholder' => $img['source']->renderPlaceholder(), 'id' => 'source_'.$i, 'class' => 'default-input' ));  ?>							
										<div class="error-txt"><?php echo $img['filename']->renderError()?></div>
									</div>
								</div>	
							</div>	
				  <?php } 
				  		  if (! $form->getObject()->isNew()) { ?>
				  						<div class="event_settings_content"></div>
				  						<script type="text/javascript">
				  							$.ajax({
				  									url: '<?php echo url_for('article/images?article='.$form->getObject()->getId());?>',
				  									beforeSend: function( ) {
				  										$('.event_settings_content').html('<div class="review_list_wrap">loading...</div>');
				  									  },
				  									success: function( data ) {
				  										$('.event_settings_content').html(data);
				  									}
				  								});					
				  						</script>
				  	<?php }
				  	if ($user_profile->hasCredential('article_editor') && !$form->getObject()->isNew()){
	                	include_partial('formEdit', array('form' => $form, 'user_profile'=>$user_profile));
	                }?>
	                
	                <div class="row">
	                    <div class="col-sm-12 form-btn-row">
	                        <input type="submit" value="<?php echo $form->getObject()->isNew() ? __( 'Next',null,'list') :__( 'Publish',null,'messages') ?>" class="default-btn success pull-right " />
							<?php if (!$form->getObject()->isNew()): ?>
								<a class="default-btn pull-right" method="delete" href="<?php echo url_for('@article?slug='.$form->getObject()->getSlug() );?>"><?php echo __('Go to Article',null,'article')?></a>
							<?php endif; ?>
	                    </div>
	                </div>				
			</div>
		</div>	
</form>	


<style>
	.event_settings_content{
		font-size: 12px;
	}
	.event_settings_content p{
		font-size: 12px;
		line-height: 14px;
	}
	.event_settings_content a{
		font-size: 12px;
	}
</style>
	