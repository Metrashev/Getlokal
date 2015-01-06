<?php slot('no_map', true) ?>
<?php slot('no_ads', true) ?>
<?php use_helper('Pagination') ?>
<?php include_partial('review/reviewJs');?>
<?php //use_stylesheet('jquery.rating.css');?>
<?php //use_javascript('jquery.rating.js');?>

<div class="settings_content">
	<?php if (!$pager->getNbResults()): ?>
		<p><?php echo __('There are no reviews', null, 'user'); ?></p>
	<?php else: ?>
		<div class="review_list_wrap">
			<p><?php echo format_number_choice('[0]No reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $pager->getNbResults()), $pager->getNbResults(),'user'); ?></p>
			<div class="review_edit_success"></div>
			<?php foreach ($pager->getResults() as $review): ?>
				<?php include_partial('review/review', array('review' => $review, 'review_user' => true, 'user'=>$user, 'user_is_admin'=>$user_is_admin)) ?>
			<?php endforeach;?>
	 
			<?php  echo pager_navigation($pager, 'companySettings/reviews'); ?>
		</div>
	<?php endif;?>
</div>

<script type="text/javascript">
$(document).ready(function() {
$('.path_wrap').remove();
		
$('.pager a').click(function() {
    $.ajax({
        url: this.href,
        beforeSend: function( ) {
          $('.settings_content').html('<div class="review_list_wrap"><?php echo sprintf(__('loading...') ) ?></div>');
        },
        success: function( data ) {
          $('.settings_content').replaceWith(data);
          $('.settings_tabs_in div.settings_sidebar').width($('.settings_tabs_top > div').first().width() - 7);
          if ($('.settings_tabs_in div.settings_sidebar').width() < 150)
          {
        	  $('.settings_tabs_in div.settings_sidebar').width(150);
          }
          $('.settings_content').width(832 - $('.settings_tabs_in div.settings_sidebar').width());
          $('.settings_content div.pager_center').width($('.settings_content').width() - 52 - $('.settings_content div.pager_left').width() - $('.settings_content div.pager_right').width());
        }
    });
    return false;
  });
});
</script>
