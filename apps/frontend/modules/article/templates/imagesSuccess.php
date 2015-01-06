<?php use_helper('Pagination') ?>
  <h2 class="form-title"><?php echo __('Article Photo Gallery',null,'article');?></h2>
  
 <?php $picture_count = count($pager);?>
    <p><?php echo format_number_choice('[0]No uploaded photos yet.|[1]1 uploaded photo|(1,+Inf]%count% uploaded photos', array('%count%' => $picture_count), $picture_count,'messages'); ?>
    </p>
    <p><?php echo __("If you want to show an image in the article text, copy the code to the right of this image and paste it where you want it to appear in the 'Article Content' field.",null,'article')?></p>
    <?php if(count($pager) > 0 ): ?>
   <div id="list_of_images"> 
  <?php foreach($pager as $image): ?>
    <div class="event_settings_gallery current_picture" style="width: 600px" id="item_<?php echo $image->getId(); ?>">
      <input type="text" value="<?php echo $image->getCode();?>">
      <div class="left_wrap">
	      <a href="<?php echo ZestCMSImages::getImageURL('article', 'big').$image->getFilename();?>" target="_blank" class="grouped_elements" rel="group" title="">
	        <img src="<?php echo ZestCMSImages::getImageURL('article', 'size-ss').$image->getFilename();?>" alt="" />
	      </a>
      	<?php echo $image->getUserProfile()->getLink(ESC_RAW); ?>
      </div>
       
      <?php /* <a href="#" class="button_green">Make new thumbnail</a> <!--phase 2  */ ?>
      <div style="margin-bottom: 10px">
      	<p><span id="span_img_source_<?php echo $image->getId()?>"><?php echo $image->getSource() ;?></span> <a class="img_source" id="<?php echo $image->getId()?>" ><?php echo __('Edit Source',null,'article');?></a></p>
      	<p><span id="span_img_descrption_<?php echo $image->getId()?>"><?php echo $image->getDescrption() ;?></span> <a class="img_descrption" id="<?php echo $image->getId()?>" ><?php echo __('Edit Description',null,'article');?></a></p>
        <?php echo link_to(__('delete', null, 'company'), 'article/deleteImage?id='. $image->getId(), 'class=link_confirm onclick=javascript:void(0)') ?>
      </div>      
    </div>
  <?php endforeach ?>
  </div>
  <div class="clear"></div>
  <?php endif; ?>
  <div class="clear"></div>
   <div id="dialog-confirm" title="<?php echo __('Delete this image?', null, 'company') ?>" style="display:none;">
        <p><?php echo __('Are you sure you want to delete this image?', null, 'company') ?></p>
   </div>
<script type="text/javascript">	
    $('#by_author, #by_contributors').click(function() {
        $.ajax({
            url: this.href,
            beforeSend: function( ) {
              $('.event_settings_content').html('<div class="review_list_wrap">loading...</div>');
            },
            success: function( data ) {
              $('.event_settings_content').html(data);
            }
        });
        return false;
   });


      $('.img_source, .img_descrption').click(function() {
          var save= '<?php echo __("Save")?>';
          var str = $('#span_'+$(this).attr("class")+'_'+$(this).attr("id")).html();
          $(this).parent().html('<input type="text" name="'+$(this).attr("class")+'" value="'+str+'"> <a class="save_'+$(this).attr("class")+'" id="'+$(this).attr("id")+'" >'+save+'</a>');
          return false;
      });
      
      $('.save_img_source, .save_img_descrption').click(function() {
    	  alert(111);
    	  var elem = $(this).parent();
		  var name = elem.children('input').attr('name');
		  var value = elem.children('input').attr('value');
		  var image_id = $(this).attr('id');
		  console.log(name);
    	  $.ajax({
              url: '<?php echo url_for("article/editImgSoure")?>',
              data: { 'name' : name, 'value' : value, 'image_id' : image_id },
              success: function( data ) {
                  elem.html(data);
              }
          });
          return false;
   		});
  /*Delete photo from article*/
     $('a.link_confirm').click(function() {
            var delelePhotoLink = $(this).attr('href');      
            if(confirm('<?= __('Are you sure you want to delete this image?', null, 'company'); ?>')){
            	window.location.href = delelePhotoLink;
            }  
            /*$("#dialog-confirm").show();
            $("#dialog-confirm").dialog({
                resizable: false,
                height: 250,
                width:340,
                buttons: {
                    "<?php echo __('delete', null) ?>": function() {
                       window.location.href = delelePhotoLink;
                    },
                    <?php echo __('cancel', null) ?>: function() {
                        $(this).dialog("close");
                    }
                }
            });
            $(".ui-dialog").css("z-index", "2000000000000000000000000");*/
            return false;
        });
     /*END Delete photo from article*/
  
</script>
