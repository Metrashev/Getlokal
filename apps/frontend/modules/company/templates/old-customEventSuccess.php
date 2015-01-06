<?php /* See http://www.getlokal.com/bg/sofia/inter-expo-center-1 */ ?>
<?php use_helper('Pagination');?>

<div class="company_events_wrap">
	<h2><?php echo __('Events'); ?></h2>

	<p class="nav_bar">
		<span>
      <?php if (isset($future_events) && $future_events): ?>
          <a id="incoming_events" <?php echo $past ? '' : 'class="current"'; ?> href="#" onclick="getAllEvents(false, true); return false;"><?php echo __('Incoming Events',null,'events')?></a>
      <?php endif; ?>

      <?php if (isset($past_events) && $past_events): ?>
          <a id="past_events" <?php echo $past ? 'class="current"' : ''; ?> href="#" onclick="getAllEvents(true, true); return false;"><?php echo __('Past Events',null,'events')?></a>
      <?php endif; ?>
        </span>
	</p>
	<?php if (!$pager->getNbResults()) : ?>
	    <p style="margin-left: 25px;">
	        <?php echo __('There are no events', null, 'events'); ?>
	    </p>
	<?php else:?>
        <?php foreach ($pager->getResults() as $event) : ?>
            <?php include_partial('event/customEvent', array('event' => $event)) ?>
        <?php endforeach;?>
    	<div class="clear"></div>
	<?php endif;?>


	<?php if (isset($past)) : ?>
	    <?php echo pager_navigation($pager, 'company/events?slug=' . $company->getSlug() . '&city=' . $company->getCity()->getSlug() . '&past=1&ppp=true&template=customEvent') ?>
	<?php else : ?>
	    <?php echo pager_navigation($pager, 'company/events?slug='. $company->getSlug() . '&city=' . $company->getCity()->getSlug() . '&ppp=true&template=customEvent') ?>
	<?php endif;?>

	<div class="clear"></div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
      // See http://www.getlokal.com/bg/sofia/inter-expo-center-1

      $('.pager a').click(function() {
          $.ajax({
              url: this.href,
              beforeSend: function( ) {
                $('.place_content').html('<div class="review_list_wrap">loading...</div>');
              },
              success: function( data ) {
                $('.place_content').html(data);
              }
          });
          return false;
      });

      $('.lightpink a').click(function() {

          if ($(this).hasClass('current')) {
			return false;
      	  }
          else {
    	  	$('.lightpink a').removeClass('current');
    	  	$(this).addClass('current');
          }
      });
  })
</script>

<?php /*
<?php  if (isset($openTab) && $openTab && $all_events>0):?>
<script type="text/javascript">
    $("document").ready(function() {
    	$('.standard_tabs_top a').removeClass('current');
	    $('.standard_tabs_top #<?php echo $openTab;?>').addClass('current');

		var top = $('.standard_tabs_top #<?php echo $openTab;?>').offset().top - 60;
	    $('html,body').scrollTop(top);
    });
</script>
<?php elseif (isset($openTab) && $openTab && $all_events=0):?>
<script type="text/javascript">
setTimeout(function() {
			//console.log('bqbqbq');
        	$('.standard_tabs_top #tab0').trigger('click');
        });
</script>
<?php endif; ?>
*/
?>
