<?php use_helper('Pagination'); ?>
<div class="wrapper-tabs-event-details">
	<div class="tab-photo-event-details">
		<ul class="user-profile-images-tab gallery clearfix">
		<?php foreach ($pager->getResults() as $image){ ?>
			<li>
				<a href="<?php echo $image->getThumb('preview') ?>" target="_blank" class="lightbox" rel="prettyPhoto[gallery2]" title="<?php echo $image->getCaption() ?>">
		            <?php echo image_tag($image->getThumb()) ?>
		        </a>
				<div class="wrapper-upload-photo-event-details">
					<?php if ($is_current_user){ 
							if ($image->getStatus() == 'approved'){ 
			            		 if ($image->getId() != $user->getUserProfile()->getImageId()){ ?>
			                    	<a class="default-btn small profile-picture-btn" href="<?php echo url_for('userSettings/setProfile?id=' . $image->getId()) ?>"><?php echo __('set as profile photo', null, 'company') ?></a>
			                <?php } 
							}else{
			                 	echo $image->getStatus();
			            	}
			            	 echo link_to(__('delete', null, 'company'), 'userSettings/deleteImage?id=' . $image->getId(), array('class'=>'default-btn small delete-picture-btn delete'));
			        	  } ?>
				</div>
			</li>
		<?php } ?>
		</ul>	
	</div>
	<?php echo pager_navigation($pager, url_for('profile/photos?username='. $pageuser->getUsername())); ?>
</div>
<script type="text/javascript" charset="utf-8">
		$(document).ready(function(){

			$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',theme:'facebook',slideshow:3000, autoplay_slideshow: false}); //add , info_markup: 	<?php echo json_encode($sf_data->getRaw('images')); ?> for comments and etc. in image preview

		});
</script>