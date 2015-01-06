<?php slot('no_map', true) ?>
<?php slot('no_ads', true) ?>
<?php use_helper('jQuery')?>
<div class="settings_content">
	<div id="loading-image" style="display:none">
		<img src="/images/gui/loading.gif" alt="Loading..." />
		<?php echo __("Your video is being uploaded. Please do not close this page and wait until the process of uploading has completed and you have seen a confirmation message. If you close the page the process will be interrupted and your video will not be successfully uploaded!",null, 'company');?>
	</div>	
	<h2><?php echo __('Video',null,'company');?></h2>
	<?php if($company->getActivePPPService()):?>
		<div id="success_message_holder" class="reg_msg_success" style="display: none;"></div>
		 	<?php foreach ($form->getErrorSchema() as $field => $error)
			{
		  		printf("%s: %s\n", $field, $error->getMessage());
			}
		 	?> 
		 	<?php if ($form->getObject()->isNew()):?>
				<form action="<?php echo url_for('companySettings/videos?slug='. $company->getSlug());?>" method="POST" enctype="multipart/form-data">
			<?php else:?>
				<form action="<?php echo url_for('companySettings/editVideo?slug='. $company->getSlug().'&videoid='.$form->getObject()->getId());?>" method="POST" >
			<?php endif;?>
			<div class="form_box <?php echo $form['caption']->hasError()? 'error': ''?>">
		      	<?php echo $form['caption']->renderLabel() ?><span class="pink">*</span>        
		      	<?php echo $form['caption']->render(array('name' => 'video_caption')); ?>
		      	<p id="video_caption_error" class="error"></p>
		    </div>
			<div class="form_box <?php echo $form['description']->hasError()? 'error': ''?>">
		      	<?php echo $form['description']->renderLabel() ?><span class="pink">*</span>        
		      	<?php echo $form['description']->render(array('name' => 'video_description')); ?>
		      	<p id="video_description_error" class="error"></p>
		    </div>
		    <?php if ($form->getObject()->isNew()):?>
		    	<div class="form_box <?php echo $form['filename']->hasError()? 'error': ''?>">
		      		<?php echo $form['filename']->renderLabel() ?><span class="pink">*</span>        
		      		<?php echo $form['filename']->render(array('name' => 'video_filename' , 'id'=>'video_filename')); ?>
		      		<p id="file_error_message" class="error"></p>
		    	</div>
			<?php else:?>
		    	<input type="hidden" name="videoid" value="<?php echo  $form->getObject()->getId();?>" /> 
		    <?php endif;?>
		   	<input name="token" id="videouploader_toked_id" type="hidden" value=""/>
			<?php  echo $form->renderHiddenFields();?> 	 
			<div class="form_box">
		      	<input type="submit" name="formsubmit" id="formsubmit" value="<?php echo __('Send')?>" class="input_submit" />
		    </div>
		    <?php //echo $form->renderHiddenFields();?>
		  	</form>
    <?php endif;?>
  	<div id="youtobe_player_video_holder"></div>
    <div class="clear"></div><br />
    <div class="video_images_title_and_description_holder">
	    <?php if($videos): ?>
		    <script type="text/javascript">
		    	$(document).ready(function(){
					var params = { allowScriptAccess: "always"};
			        var atts = { id: "youtobe_player_video_holder" };
			        swfobject.embedSWF("http://www.youtube.com/e/<?php print $videos[0]->getLink();?>?enablejsapi=1&playerapiid=youtobe_player_video_holder",
			        "youtobe_player_video_holder", "624", "356", "8", null, null, params, atts);     
		        });
		    </script>
		    <ul class="user_settings_gallery_list">
		    	<?php foreach ($videos as $video): $videoHolderId = "video_holder_".$video->getId(); ?>
			    	<li id="<?php echo $videoHolderId; ?>" class="current_picture current_picture_full">
			    		<a class="lightbox" title="<?php echo  $video->getDescription();?>" href="javascript:__changeYoutobeVideo('<?php echo $video->getLink();?>');">
			    			<img src="http://img.youtube.com/vi/<?php print $video->getLink();?>/1.jpg" alt="<?php echo $video->getDescription();?>" />
			    		</a>
			    		<a class="button_green" href="<?php echo url_for('companySettings/videos?slug='.$company->getSlug().'&videoid='.$video->getId());?>"><?php echo  __('Edit',null,'company');?></a>
			    		<?php echo  link_to(__('delete',null,'company'),  'companySettings/DeleteVideo?slug='.$company->getSlug().'&videoid='.$video->getId(), array('class'=>'button_pink')); ?>
			    		<div class="clear"></div>
			    		<p><?php echo  $video->getCaption();?></p>
			    	</li>
		    	<?php endforeach; ?>
		    </ul>
	    <?php endif;?>
    </div>
    
    
    
    
    
    
    <?php /*?>
    <table align="left" class="video_images_title_and_description_holder">
    	<tr>
    	<?php
            if($videos):
        ?>
       <script type="text/javascript">
            $(document).ready(function(){
                var params = { allowScriptAccess: "always"};
                var atts = { id: "youtobe_player_video_holder" };
                swfobject.embedSWF("http://www.youtube.com/e/<?php print $videos[0]->getLink();?>?enablejsapi=1&playerapiid=youtobe_player_video_holder",
                                   "youtobe_player_video_holder", "425", "356", "8", null, null, params, atts);     
            });
        </script>
        <?php
             foreach ($videos as $video):
                    $videoHolderId = "video_holder_".$video->getId();
        ?>
                <td id="<?php print  $videoHolderId;?>">
                    <table>
                        <tr>
                            <td colspan="2">
                                    <img width="100px" style="cursor: pointer;" onclick="__changeYoutobeVideo('<?php echo $video->getLink();?>');" title="<?php echo  $video->getDescription();?>" src="http://img.youtube.com/vi/<?php print $video->getLink();?>/1.jpg" border="0"/>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 0px; vertical-align: top;width: 100px;line-height:100%;">
                                <div>
                                <?php echo  $video->getCaption();?>
                                </div>
                            <br style="clear: both;"/>
                            <span class="clear"></span>
                               
                           
                                <a href="<?php echo  url_for('companySettings/videos?slug='.$company->getSlug().'&videoid='.$video->getId());?>">
                                   <span> <?php echo  __('Edit',null,'company');?></span>
                                </a>
                              
                               <br/>
                                <?php echo  link_to( '<strong>x</strong> <span>'. __('delete',null,'company') .'</span>',  'companySettings/DeleteVideo?slug='.$company->getSlug().'&videoid='.$video->getId()); ?>
                            </td>
                        </tr>
                    </table>
                </td>    
        <?php
            endforeach;
        ?>
        <?php
            endif;
        ?>
              </tr>
        </table>
        */ ?>
	<?php if ($form->getObject()->isNew()):?>
		<?php  include_partial('companySettings/advideosjs', array('company'=>$company));?>
    <?php  endif;?>
</div>

<script type="text/javascript">
$(document).ready(function () { 
	$('.path_wrap').remove();
})
</script> 