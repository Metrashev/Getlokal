<?php use_helper('TimeStamps');?>

<script type="text/javascript">
    $("document").ready(function() {

        setTimeout(function() {
        	$('.standard_tabs_bar #login-top').trigger('click');
        });
        
    });
</script>

<?php ($user && $contributors && $user->getId()!=$event->getUserId())? $contributor='&contributors=1':$contributor=''?>

  <?php if($sf_user->hasFlash('form_success')): ?>
    <div class="flash_success">
      <?php echo __($sf_user->getFlash('form_success')) ?>
    </div>
  <?php endif; ?>

<div class="event_photos">

<?php if ( !count($images) ): ?>
	<p><?php echo __('No uploaded photos yet.'); ?></p>
<?php else:?>
<ul class="event_pictures">
	<?php 
		foreach ($images as $image) {
	?>
		<li>
			<a href='<?= image_path($image->getThumb('preview'))?>' id="image-<?= $image->getId() ?>">
			<?php
		      	if ($image->getType()=='poster' ) {
		      		echo image_tag($image->getThumb('preview'),array('size'=>'101x135', 'title'=>$image->getCaption() ));
		      	}
		      	else {
                    echo image_tag($image->getThumb(2),array('size'=>'220x170', 'title'=>$image->getCaption() ));
		        }
	        ?>
            </a>
             <?php 
             	$username = $image->getUserProfile()->getSfGuardUser()->getUsername();
             	$user_url= url_for('@user_page?username='.$username);
             ?>
			 <div class="wrapper-upload-photo-event-details"><?php echo __('uploaded by: ', null, 'events'); ?><a class="photo-uploader-event-details" href="<?= $user_url;?>"><?= $image->getUserProfile(); ?></a></div>
             
             <div class="clear"></div>
        </li>
	<?php } ?>
</ul>
<div class="clear"></div>
<?php endif;?>
<?php if($user): ?>
<div id="form-image">

<div class="row"><!-- Form File -->
	<div class="default-container default-form-wrapper col-sm-12">
		<form id="imgCompanyForm" class="default-form clearfix" action="<?php echo url_for('event/show?id='. $event->getId().$contributor.'#photos_tab' ) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
			<div class="row">
                <div class="col-sm-12">
                    <h2 class="form-title">
                    <?php echo __('Add Photo', null, 'company')?>
                    <button type="button" class="close" onclick="$('.add_photo_content').html('')"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </h2>
                    
                    <?php echo $form['_csrf_token']->render() ?>
                </div>
            </div>
            
			<?php
				if( $form['file']->hasError() || $form['caption']->hasError() ) { ?>
					<div class="form-message error">
						<?php				
							echo $form['file']->renderError();
						?>					
					</div>
			<?php } ?>
			
			<div class="row">
				<div class="col-sm-12">
					<div class="file-input-wrapper">
						<?php echo $form['file']->renderLabel(__('No File chosen', null, 'form').$form['file']->render(array('class'=>"file-input")),array('class' => "file-label"))?>
						<?php //echo $form['file']->render(array('class'=>"file-input")); ?>
					</div>
				</div>
			</div>
			
			<div class="row">
                <div class="col-sm-12">
                    <div class="default-input-wrapper<?php echo $form['caption']->hasError() ? 'incorrect' : '' ?>">
                        <?php echo $form['caption']->renderLabel(null, array('class' => 'default-label')) ?>
                        <?php echo $form['caption']->render(array('class' => 'default-input')); ?>
                        <div class="error-txt"><?php echo $form['caption']->renderError() ?></div>
                    </div>
                </div>
            </div>
            
		    <div class="default-input-wrapper">
				<input type="submit" value="<?php echo __('Add Photo',null,'form')?>" class="default-btn success"/>
			</div>
		<?php echo  $form->renderHiddenFields();?>
		</form>
	</div>
</div><!-- End Form File -->

</div>
<?php elseif (!$user) :?>
	<div class="login_event_picture">		
		<div class="login_form_wrap">
			<?php include_component('user', 'signinRegister'/*,array('trigger_id' => 'login_content_events', 'goto_id' => 'login_content_events')*/);?>
		</div>
	</div>
<?php endif;?>
</div>
