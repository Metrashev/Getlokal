<?php slot('no_map', true) ?>
<?php slot('no_ads', true) ?>
<?php use_helper('jQuery')?>
<div class="content_in">
			
		
				<h2><?php echo __('Edit Video',null,'company');?></h2>

<div id="success_message_holder" class="reg_msg_success" style="display: none;">
        </div>
 <?php 
 foreach ($form->getErrorSchema() as $field => $error)
{
  printf("%s: %s\n", $field, $error->getMessage());

}
 
 ?> 

	 <form action="<?php echo url_for('companySettings/editVideo?slug='. $company->getSlug().'&videoid='.$form->getObject()->getId());?>" method="POST" >

		<div class="form_box <?php echo $form['caption']->hasError()? 'error': ''?>">
      <?php echo $form['caption']->renderLabel() ?><span>*</span>        
      <?php echo $form['caption']->render(array('name' => 'video_caption')); ?>
      <span id="video_caption_error" class="error"></span>
    </div>
		<div class="form_box <?php echo $form['description']->hasError()? 'error': ''?>">
      <?php echo $form['description']->renderLabel() ?><span>*</span>        
      <?php echo $form['description']->render(array('name' => 'video_description')); ?>
      <span id="video_description_error" class="error"></span>
    </div>
   
      
       <input type="hidden" name="videoid" value="<?php echo  $form->getObject()->getId();?>"/>
           

   <input name="token" id="videouploader_toked_id" type="hidden"/>
	
				
	<?php  echo $form->renderHiddenFields();?> 	 
		 	 <div class="form_box">
      <input type="submit" name="formsubmit" id="formsubmit" value="<?php echo __('Send')?>" class="input_submit" />
    </div>
   
  </form>
    <?php echo link_to('Back to "My videos"', 'companySettings/videos?slug='. $company->getSlug());?>
</div>

