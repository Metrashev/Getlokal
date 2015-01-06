<?php use_helper('Pagination') ?>
	<a href="<?php echo url_for('event/images?event='. $event->getId());?>" id="by_author"><?php echo __('By Author',null,'events')?></a> |
	<a href="<?php echo url_for('event/images?event='. $event->getId().'&contributors=1');?>" id="by_contributors"><?php echo __('By Attendees',null,'events')?></a>
  <h2><?php echo __('Event Photo Gallery');?></h2>
  
 <?php $picture_count = $pager->getNbResults();?>
 <?php //$picture_count = count($images);?>  
    <p><?php echo format_number_choice('[0]No uploaded photos yet.|[1]1 uploaded photo|(1,+Inf]%count% uploaded photos', array('%count%' => $picture_count), $picture_count,'messages'); ?>
    </p>
    <?php if($pager->getNbResults() > 0 ): ?>
  <?php foreach($pager->getResults() as $image): ?>
    <div class="event_settings_gallery current_picture">
      <a href="<?php echo $image->getThumb('preview') ?>" target="_blank" class="grouped_elements" rel="group" title="<?php echo $image->getCaption() ?>">
        <?php echo image_tag($image->getThumb()) ?>
      </a>
      
      <?php if($image->getId() != $event->getImageId()): ?>
        <a href="<?php echo url_for('event/setEvent?id='. $image->getId().'&event_id='.$event->getId()) ?>" class="button_green"><?php echo __('set as event photo')?></a>
      <?php endif ?>
      <?php /* <a href="#" class="button_green">Make new thumbnail</a> <!--phase 2  */ ?>
      <?php echo link_to(__('delete', null, 'company'), 'event/deleteImage?id='. $image->getId(), 'class=button_confirm') ?>
    </div>
  <?php endforeach ?>
  <?php  echo pager_navigation($pager, url_for( 'event/images?event='.$event->getId() )); ?>
  <?php //print_r(sfContext::getInstance()->getRouting());?>
  <?php endif ?>
  <div class="clear"></div>
   <div id="dialog-confirm" title="<?php echo __('Delete this image?', null, 'company') ?>" style="display:none;">
        <p><?php echo __('Are you sure you want to delete this image?', null, 'company') ?></p>
   </div>
<script type="text/javascript">
$(document).ready(function() {
	$("a.grouped_elements").fancybox({
		'cyclic'			: true,
		'titlePosition'		: 'outside',
		'overlayColor'		: '#000',
		'overlayOpacity'	: 0.6
});
$('a.button_confirm').click(function() {
            var delelePhotoLink = $(this).attr('href');        
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
            $(".ui-dialog").css("z-index", "2");
            return false;
        });
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

      $('.pager a').click(function() {
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
      //review.init();
  })

</script>
