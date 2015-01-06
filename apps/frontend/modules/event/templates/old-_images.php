<?php //use_helper('Pagination') ?>
<div class="event_settings_content">
  <h2><?php echo __('Event Photo Gallery');?></h2>
  
 <?php $picture_count = $pager->getNbResults();?>
 <?php //$picture_count = count($images);?>  
    <p><?php echo format_number_choice('[0]No uploaded photos yet.|[1]1 uploaded photo|(1,+Inf]%count% uploaded photos', array('%count%' => $picture_count), $picture_count,'messages'); ?>
    </p>
    <?php if($pager->getNbResults() > 0 ): ?>
  <?php foreach($pager->getResults() as $image): ?>
    <div class="event_settings_gallery current_picture">
      <a href="<?php echo $image->getThumb('preview') ?>" target="_blank" class="lightbox" rel="group" title="<?php echo $image->getCaption() ?>">
        <?php echo image_tag($image->getThumb()) ?>
      </a>
      
      <?php if($image->getId() != $event->getImageId()): ?>
        <a href="<?php echo url_for('event/setEvent?id='. $image->getId().'&event_id='.$event->getId()) ?>" class="button_green"><?php echo __('set as event photo')?></a>
      <?php endif ?>
      <?php /* <a href="#" class="button_green">Make new thumbnail</a> <!--phase 2  */ ?>
      <?php echo link_to(__('delete', null, 'company'), 'event/deleteImage?id='. $image->getId(), 'class=button_pink confirm='.__('Are you sure ?')) ?>
    </div>
  <?php endforeach ?>
  <?php  //echo pager_navigation($pager, url_for( $company->getUri(ESC_RAW))); ?>
  <?php //print_r(sfContext::getInstance()->getRouting());?>
  <?php endif ?>
  <div class="clear"></div>
</div>
<script type="text/javascript">
$(document).ready(function() {
  $('a.lightbox').fancybox({
    titlePosition: 'over',
    cyclic:        true
  });
})

$(document).ready(function() {
      $('.pager a').click(function() {
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
      review.init();
  })

</script>
