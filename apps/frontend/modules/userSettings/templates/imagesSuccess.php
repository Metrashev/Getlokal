<?php include_partial('global/commonSlider'); ?>
<?php use_helper('Pagination') ?>
<script type="text/javascript" charset="utf-8">
		$(document).ready(function(){

			$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',theme:'facebook',slideshow:3000, autoplay_slideshow: false}); //add , info_markup: 	<?php echo json_encode($sf_data->getRaw('images')); ?> for comments and etc. in image preview

		});
</script>
<div class="container set-over-slider">
		<div class="row">	
			<div class="container">
				<div class="row">
					<h1 class="col-xs-12 main-form-title"><?php echo __('Profile Photo Gallery') ?></h1>
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

	                <?php if ($sf_user->hasFlash('notice')): ?>
				        <div class="form-message success">
				            <p><?php echo __($sf_user->getFlash('notice')); ?></p>
				        </div>
				    <?php endif; ?>
			    
			    	<div class="row">
						<div class="default-container default-form-wrapper col-sm-12 p-lr-6">
							<h2 class="form-title m-t-20"><?php echo __('Profile Photo Gallery') ?></h2>
							<div class="col-sm-12">
								<?php include_partial('template', array('showTabs' => true, 'tab' => 'userSettings/images', 'selected' => 'userSettings/images')); ?>	   
							</div>
							
							<div id="pictures_container">
								<?php $picture_count = $pager->getNbResults();?>
								<p><?php echo format_number_choice('[0]No uploaded photos yet.|[1]1 uploaded photo|(1,+Inf]%count% uploaded photos', array('%count%' => $picture_count), $picture_count,'messages'); ?></p>
								<?php if($pager->getNbResults() > 0 ){ ?>
									<div class="wrapper-tabs-event-details">
										<div class="tab-photo-event-details">
											<ul class="user-profile-images-tab gallery clearfix p-0">
											<?php foreach ($pager->getResults() as $image){ ?>
												<li>
													<a rel="prettyPhoto[gallery2]" href="<?php echo $image->getThumb('preview') ?>" target="_blank"  title="<?php echo $image->getCaption() ?>">
											            <?php echo image_tag($image->getThumb()) ?>
											        </a>
													<div class="wrapper-upload-photo-event-details">
														<?php 
																if ($image->getStatus() == 'approved'){ 
												            		 if ($image->getId() != $user->getUserProfile()->getImageId()){ ?>
												                    	<a class="default-btn small profile-picture-btn" href="<?php echo url_for('userSettings/setProfile?id=' . $image->getId()) ?>"><?php echo __('set as profile photo', null, 'company') ?></a>
												                <?php } else{
												                 	?><a class="default-btn small profile-picture-btn" ><?php echo __('profile photo', null, 'company') ?></a><?php
												                	} 
												            	}
												            	 echo link_to(__('delete', null, 'company'), 'userSettings/deleteImage?id=' . $image->getId(), array('class'=>'default-btn small delete-picture-btn delete'));
												        	   ?>
													</div>
												</li>
											<?php } ?>
											</ul>	
										</div>
									</div>
									<div class="clear"></div>
								<?php echo pager_navigation($pager, 'userSettings/images') ?>
								<?php } ?>
							</div>
						
							<!-- Form End -->
						</div>
					</div>
				</form>
            </div>
        </div>            
		
</div>	
<style>
.default-form-wrapper {
	padding: 30px 35px 50px;
}
</style>
<script type="text/javascript">
	$('.path_wrap').css('display', 'none');
//	$('.search_bar').css('display', 'none');
	$(".banner").css("display", "none");

	
	function showOptions(id){
		id = 'optionMenu_'+id;
		$('#'+id).show();
	}
	
     $('a.link_confirm').click(function() {
            var delelePhotoLink = $(this).attr('href');        
            $("#dialog-confirm").dialog({
                resizable: false,
                height: 250,
                width:340,
                buttons: {
                    "<?php echo __('delete', null) ?>": function() {
                       window.location.href = delelePhotoLink;
                    },
                    <?php echo __('cancel', null, 'company') ?>: function() {
                        $(this).dialog("close");
                    }
                }
            });
            $(".ui-dialog").css("z-index", "2");
            return false;
        });
</script>
<style>
	.settings_gallery, .settings_gallery li {
	    padding: 0px;
	    margin: 0px;
	    list-style-type: none;
	}
	
	.settings_gallery li {
	    position: relative;
	    float: left;
	    padding: 22px 22px 17px;
	    margin: 0px 15px 15px 0px;
	    width: 180px;
	    background: none repeat scroll 0% 0% #FFF;
	    border: 1px solid #DBDBDB;
	}
	
	.settings_gallery li .profile_picture_options {
	    display: none;
	    position: absolute;
	    margin: 10px -23px 0px;
	    padding: 10px 5px 2px;
	    width: 180px;
	    background: none repeat scroll 0% 0% #FFE9F2;
	    border: 1px solid #DBDBDB;
	    border-bottom-right-radius: 3px;
	    border-bottom-left-radius: 3px;
	    z-index: 1;
	}
	.settings_gallery li .profile_picture_options a{
		font-size: 12px;
	}
</style>