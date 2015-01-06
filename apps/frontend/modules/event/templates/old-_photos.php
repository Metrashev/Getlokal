<?php use_helper('TimeStamps');?>
<?php  //if ($form['file']->hasError()):?>
<script type="text/javascript">
    $("document").ready(function() {

        setTimeout(function() {
        	$('.standard_tabs_bar #login-top').trigger('click');
        });
        
    });
</script>
<?php //endif; ?>
<?php ($user && $contributors && $user->getId()!=$event->getUserId())? $contributor='&contributors=1':$contributor=''?>
<div class="standard_tabs_bar">
	<a class="<?php echo($contributors)? '':'current'?>" href="<?php echo url_for('event/photos?event_id='. $event->getId());?>" id="by_author"><?php echo __('By Author',null,'events')?></a> |
	<a class="<?php echo($contributors)? '':'current'?>" href="<?php echo url_for('event/photos?event_id='. $event->getId().'&contributors=1');?>" id="by_contributors"><?php echo __('By Attendees',null,'events')?></a> |
	<a href="javascript:void(0)" id="login-top" ><?php echo __('Add Photo',null,'form')?></a>
</div>
  <?php if($sf_user->hasFlash('form_success')): ?>
    <div class="flash_success">
      <?php echo __($sf_user->getFlash('form_success')) ?>
    </div>
  <?php endif; ?>

<div class="event_photos">
<?php if($user): ?>
		<div class="login_form_wrap"  id="form_image_tab_top" style="display:none">
		<form action="<?php echo url_for('event/show?id='. $event->getId().$contributor.'#photos_tab' ) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
		
			<div class="form_box<?php if( $form['file']->hasError()):?> error<?php endif;?>">
				<?php echo $form['file']->renderLabel()?>
				<?php echo $form['file'] ?>
				<?php echo $form['file']->renderError()?>
			</div>
			<div class="form_box <?php echo $form['caption']->hasError()? 'error': '' ?>">
		      <?php echo $form['caption']->renderLabel() ?>
		      <?php echo $form['caption']->render() ?>
		      <?php echo $form['caption']->renderError() ?>
		    </div>
		<input type="submit" value="<?php echo __('Publish',null,'messages')?>" class="button_green" />
		<?php echo  $form->renderHiddenFields();?>
		</form>
		</div>
	<?php else :?>
					<div class="login_form_wrap"  id="form_tab_top" style="display:none">
			        	<?php include_partial('user/signin_form',array('form'=>new sfGuardFormSignin()));?>
			        </div>
	<?php endif;?>
<?php if ( !count($images) ): ?>
	<p><?php echo __('No uploaded photos yet.'); ?></p>
<?php else:?>
<ul class="event_pictures">
	<?php foreach ($images as $image):?>
			<li>
			 <?php 	if ($image->getType()=='poster' ):?><div class="event_image_wrap"><?php endif;?>
			 <a class="grouped_elements" rel="tab_photos"  href='<?php echo image_path($image->getThumb('preview'))?>' id="image-<?php echo $image->getId() ?>" >
			 <?php 
		      	if ($image->getType()=='poster' ):
		      		echo image_tag($image->getThumb('preview'),array('size'=>'101x135', 'title'=>$image->getCaption() ));
		      	else:
                    echo image_tag($image->getThumb(2),array('size'=>'180x135', 'title'=>$image->getCaption() ));
		        endif;
	        ?>
             </a>
			 <?php 	if ($image->getType()=='poster' ):?></div><?php endif;?>
             <p><?php echo $image->getUserProfile()->getLink(ESC_RAW);?>
             <br />
             	<?php echo ezDate(date('d.m.Y H:i', strtotime($image->getCreatedAt())));
				//echo $sf_user->ezDate(date('d.m.Y H:i', strtotime($image->getCreatedAt())));?></p> 
              <div class="clear"></div>
            </li>
	<?php endforeach;?>
</ul>
<div class="clear"></div>
<?php endif;?>
<?php if( ($user && $contributors && $user->getId()!=$event->getUserId()) || ($user && !$contributors && $user->getId()==$event->getUserId()) ): ?>
<div id="form-image">

<form action="<?php echo url_for('event/show?id='. $event->getId().$contributor.'#photos_tab' ) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

	<div class="form_box<?php if( $form['file']->hasError()):?> error<?php endif;?>">
		<?php echo $form['file']->renderLabel()?>
		<?php echo $form['file'] ?>
		<?php echo $form['file']->renderError()?>
	</div>
	<div class="form_box <?php echo $form['caption']->hasError()? 'error': '' ?>">
      <?php echo $form['caption']->renderLabel() ?>
      <?php echo $form['caption']->render() ?>
      <?php echo $form['caption']->renderError() ?>
    </div>
<input type="submit" value="<?php echo __('Add Photo',null,'form')?>" class="button_green" />
<?php echo  $form->renderHiddenFields();?>
</form>
</div>
<?php elseif (!$user) :?>
	<div class="login_event_picture">
		<div class="login_event_picture_button">
			<a href="javascript:void(0)" id="login_event_picture" class="button_green"><?php echo __('Add Photo',null,'form')?></a>
		</div>
		<div class="login_form_wrap" style="display:none">
			<?php include_partial('user/signin_form',array('form'=>new sfGuardFormSignin()));?>
		</div>
	</div>
<?php endif;?>
</div>
<script type="text/javascript">
$(document).ready(function() {
	  $('#login-top').click(function() {
		  $('#form_tab_top').toggle();
		  $('#form_image_tab_top').toggle();
		  $('#form-image').toggle();
	  });
	  $('a#login_event_picture').click(function() {
		  $('.login_event_picture div.login_form_wrap').toggle();
	  });
}) 

$(document).ready(function() {

	$("a.grouped_elements").fancybox({
				'cyclic'			: true,
				'titlePosition'		: 'outside',
				'overlayColor'		: '#000',
				'overlayOpacity'	: 0.6
	});

/*
	 $('#form-image form').submit(function() {
		    var loading = false;
		        
		    if(loading) return false;
		    
		    var element = $(this).parent().parent().parent();
		        
		    loading = true;

		    $.ajax({
		        url: this.action,
		        type: 'POST',
		        data: $(this).serialize(),
		        beforeSend: function() {
		          $(element).html('loading...');
		        },
		        success: function(data, url) {
		          $(element).html(data);
		          loading = false;
		        },
		        error: function(e, xhr)
		        {
		          console.log(e);
		        }
		    });
		    
		    return false;
	});
	
	 $('#form_image_tab_top form').submit(function() {
				    var loading = false;
				        
				    if(loading) return false;
				    
				    var element = $(this).parent().parent().parent();
				        
				    loading = true;

				    $.ajax({
				        url: this.action,
				        type: 'POST',
				        cache: false,
				        data: $(this).serialize(),
				        beforeSend: function() {
				          $(element).html('loading...');
				        },
				        success: function(data, url) {
				          $(element).html(data);
				          loading = false;
				        },
				        error: function(e, xhr)
				        {
				          console.log(e);
				        }
				    });
				    
				    return false;
	 });

*/
     $('#by_author, #by_contributors').click(function() {
          $.ajax({
              url: this.href,
              beforeSend: function( ) {
                $('.standard_tabs_in').html('<div class="review_list_wrap">loading...</div>');
              },
              success: function( data ) {
                $('.standard_tabs_in').html(data);
              }
          });
          return false;
     });
      
      
      var loading = false;
      
  }) 
</script>