<?php use_helper('Pagination');?>
<?php //use_javascript('review.js') ?>

<?php if (!$pager->getNbResults()): ?>
	<p class="flash_error"><?php echo __('There are no Lists', null, 'events'); ?></p>
<?php else:?>
<div class="standard_tabs_events">
	<div class="listing_company_wrap">
	<?php foreach ($pager->getResults() as $list): ;?>
		<?php include_partial('list/list', array('list' => $list, 'show_user'=>true)) ?>
	<?php endforeach;?>
	</div>
</div>
<div class="clear"></div>
<?php endif;?>

	<?php echo pager_navigation($pager, 'company/lists?pageId='. $page_id) ?>


<div class="clear"></div>
<script type="text/javascript">
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

      $('#attended_events').click(function() {
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
      
      $('#my_events').click(function() {
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
      
  });
</script>