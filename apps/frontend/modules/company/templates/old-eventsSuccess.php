<?php use_helper('Pagination') ?>
<?php use_javascript('review.js') ?>
<?php use_stylesheet('jquery.rating.css') ?>
<?php include_partial('company/rating') ?>

<div class="standard_tabs_bar">
  <a href="<?php echo url_for('company/events?slug='. $company->getSlug());?>" id="incoming_events"
  class="<?php echo $past ? '' : 'current' ?>">
    <?php echo __('Incoming Events', null, 'events') ?>
  </a>
  |
  <a href="<?php echo url_for('company/events?slug='. $company->getSlug().'&past=1');?>" id="past_events"
  class="<?php echo $past ? 'current' : '' ?>">
    <?php echo __('Past Events', null, 'events') ?>
  </a>
</div>

<?php if (!$pager->getNbResults()): ?>
  <p>
    <?php echo __('There are no events', null, 'events'); ?>
  </p>
<?php else:?>
  <div class="standard_tabs_events">
    <?php foreach ($pager->getResults() as $event): ?>
      <?php include_partial('event/event', array('event' => $event)) ?>
    <?php endforeach; ?>
  </div>
  <div class="clear"></div>
<?php endif;?>

<?php echo pager_navigation($pager, 'company/events?slug='. $company->getSlug().'&past=' . $past) ?>
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

      $('#past_events').click(function() {
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

      $('#incoming_events').click(function() {
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
