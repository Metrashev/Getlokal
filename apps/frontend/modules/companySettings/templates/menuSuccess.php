<?php 
include_partial('global/commonSlider'); 
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
		        
		        <?php if ($sf_user->getFlash('notice')): ?> 
		            <div class="form-message success">
		                <p><?php echo __($sf_user->getFlash('notice')) ?></p>
		            </div> 
		        <?php endif; ?>

               <form id="cs-form" action="<?php echo url_for('companySettings/menu?slug='.$company->getSlug()) ?>" enctype="multipart/form-data" method="post">
                	<?php echo $form['_csrf_token']->render() ?>
			    	<div class="row">
						<div class="default-container default-form-wrapper col-sm-12 p-15">
							<div class="col-sm-12">
								<?php include_partial('tabsMenu', $params); ?>	   
							</div>
							<h2 class="form-title"><?php  echo  __('Menu',null,'company'); ?></h2>

							<?php 
					        $menu = $company->getFirstMenu();
					        if ($menu) { 
					        	echo __("Current file", null, 'form') . ': '
					        ;?>
					        	<a href="#"><?php echo sfOutputEscaperGetterDecorator::unescape($menu->getDownloadLink($menu->getFilename(), 'target = "_blank" class="default-link"')); ?></a>
					        	<a class="list_delete default-btn" href="<?php echo url_for('companySettings/deleteMenu?id=' . $menu->getId()) ?>"><?php echo __('delete') ?></a>
					        <?php } ?>

		       				</br></br>

							<div class="row">
                                <div class="col-sm-12">
                                    <div class="default-input-wrapper required select-wrapper <?php echo $form['name']->hasError() ? 'incorrect' : '' ?>">
                                    	<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                                        <?php 
                                        	echo $form['name']->renderLabel(null, array('class' => 'default-label'));
                                        	echo $form['name']->render(array('class' => 'default-input' ));
										?>
                                        <div class="error-txt"><?php echo $form['name']->renderError(); ?></div>
                                    </div>
                                </div>
                            </div>

				            <div class="row">
				                <div class="col-sm-12">
				                    <div class="file-input-wrapper upload <?php echo $form['file']->hasError() ? 'incorrect' : '' ?>">
				                    	<label for="fileUpload" class="file-label">
		                                	<?php echo __('No File chosen', null, 'form'); ?>
		                                	<?php echo $form['file']->render(array('id' => 'fileUpload', 'class' => 'file-input')) ?>
		   		                        </label>
				                        <div class="error-txt"><?php echo $form['file']->renderError(); ?></div>

				                        <ul class="error_listMenu " style="display:none;"></ul>
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
							
						</div>
					</div>
					
					<?php echo $form->renderHiddenFields();?>
				</form>
            </div>
        </div>
	</div>	
</div>

<div id="dialog-confirm-delete" title="<?php echo __('Delete file', null, 'messages') ?>" style="display:none;">
    <p><?php echo __('Are you sure you want to delete the current file?', null, 'messages') ?></p>
</div>

<script type="text/javascript">
    $('a.list_delete').click(function(event) {
        var deleleReviewLink = $(this).attr('href');
        $("#dialog-confirm-delete").data('id', deleleReviewLink).dialog('open');       
        return false;
	});

	$("#dialog-confirm-delete").dialog({
	    resizable: false,
	    autoOpen: false,
	    height: 250,
	    width:340,
	    buttons: {
	        "<?php echo __('delete', null) ?>": function() {
	             window.location.href =  $("#dialog-confirm-delete").data('id');
	        },
		    <?php echo __('cancel', null) ?>: function() {
			    $(this).dialog("close");
			}
		}
	});
</script>