<?php slot('no_map', true) ?>
<?php slot('no_asd', true) ?>
<form action="<?php echo url_for('crop/placePhoto?slug='.$company->getSlug().'&image_id='.$image->getId())?>" method="POST">
	<input type="hidden" id="x1" name="x1" />
	<input type="hidden" id="y1" name="y1" />
	<input type="hidden" id="x2" name="x2" />
	<input type="hidden" id="y2" name="y2" />
	<input type="hidden" id="width" name="width" />
	<input type="hidden" id="height" name="height" />     
	<?php //echo __('The cover image is 975x300 pixels so if your photo is big enough our advise is to crop a part of it that’s exactly the same size. Just click on the image, stretch the crop area until it reaches the maximum size (975x300) and if necessary drag on the part of the image you wish to crop. Then click on the ‘Crop’ button. Your cover image will change immediately. <p>If your image is smaller than 975x300 pixels you can crop part of it which will be displayed on the page surrounded by black background. Again the maximum width of the crop area cannot be bigger than 975 and the maximum height more than 300 pixels. The crop area cannot be dragged outside the boundaries of your image.', null,'company')?>
    <p><?php echo __('Before saving this image as a cover photo, we recommend that you crop it to the size of the cover photo template (975x300 px) in order to obtain best results.', null, 'company')?></p><br/>
    <p><?php echo __('How to do that:', null, 'company')?></p>
    <ol>
		<li><?php echo __('Click on the image', null, 'company')?></li>
		<li><?php echo __('Stretch the crop area to your preference. Note that the selection won\'t stretch over the limit of 975x300 px.', null, 'company')?></li>
		<li><?php echo __('You can drag the selection to a different part of the photo.', null, 'company')?></li>
		<li><?php echo __('Once you\'re ready, click on the CROP button. The cropped image will be saved as a new copy in Cover Photos Tab and set as a cover photo.', null, 'company')?></li>
    </ol>
    <p><?php echo __('If the selected area is smaller than 975x300 px, your image will be centered on the cover photo template surrounded by a black background.', null, 'company')?></p>
	<input class="button_green" type="submit" name="submit" id="ava_submit" value="<?php echo __('Crop', null, 'company'); ?>">
</form>
<div id="preview_wrap" style="display:none;">
<h3><?php echo __('Preview');?></h3>
	<div style="margin-bottom:10px;width:975px;height:300px;background:#000;overflow:hidden;">
		<div style="overflow:hidden;">
			<img src="<?php echo $image->getFile()?>" id="preview" alt="Preview" class="jcrop-preview" />
		</div>
	</div>
</div>
<h3><?php echo __('Your Photo');?></h3>
<img src="<?php echo $image->getFile()?>" alt="<?php echo $image->getCaption()?>" id="cropbox"/>

<script type="text/javascript">
jQuery(function($){
    var boundx, boundy;
    
    $('#cropbox').Jcrop({
		onChange: updatePreview,
		onSelect: updatePreview,
		maxSize: [975, 300]
      
    },function(){
		var bounds = this.getBounds();
		boundx = bounds[0];
		boundy = bounds[1];
    });

    $('.jcrop-tracker').append($('#coords'));

    function updatePreview(c)
    {
        $('#preview_wrap').show();
		if (c.w > 0 && c.h > 0)
      	{
			$('#x1').val(c.x);
	    	$('#y1').val(c.y);
	    	$('#x2').val(c.x2);
	    	$('#y2').val(c.y2);
	    	$('#width').val(c.w);
	    	$('#height').val(c.h);
	    	$('#coords').html(c.w + ' x ' + c.h);
			console.log($('#x1'));
	        $('#preview').css({
	            marginLeft: '-' + c.x + 'px',
	            marginTop: '-' + c.y + 'px'
	        });
	        $('#preview').parent().css({
				width: c.w + 'px',
				height: c.h + 'px',
				marginLeft: ((975 - c.w) / 2) + 'px',
				marginTop: ((300 - c.h) / 2) + 'px'
		    });
      	}
		else
		{
			$('#preview_wrap').hide();
		}
    };

	$('.ava_submit').click(function() {
		$('#ava_submit').trigger('click');
	});

  });
</script>
<p style="color:#FFF;padding:0px 10px;text-shadow:-1px -1px 0 #000,1px -1px 0 #000,-1px 1px 0 #000,1px 1px 0 #000;"id="coords"></p>

<div style="padding:15px 0px;"><a href="#" class="ava_submit button_green"><?php echo __('Crop', null, 'company'); ?></a></div>
<?php echo  link_to(__('Back to \'Photos\'', null, 'company'), 'companySettings/images?slug='.$company->getSlug())?>