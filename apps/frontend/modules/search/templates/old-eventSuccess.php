<?php use_helper('Pagination') ?>

<?php
    $searchWhere = $sf_request->getParameter('w');
    $searchString = $sf_request->getParameter('s');
    $getNbResults = $pagerEvent->getNbResults();
?>

<a name="map"></a>
<div class="content_in">
  <h2><?php echo sprintf(__('%s in %s'), $sf_request->getParameter('s'), $sf_request->getParameter('w')? $sf_request->getParameter('w'): $sf_user->getCity()->getLocation()); ?></h2>
  <div class="listing_tabs_wrap" id="content_anchor">
  <?php if(!$pagerevent->getNbResults()): ?>
    <div id="no_results" style="display: <?php echo $number_of_results? 'none': 'block' ?>;">
      <h3><?php echo __('No Results found for %keyword% in %place%', array('%keyword%' => $sf_request->getParameter('s'), '%place%' => $sf_request->getParameter('w'))) ?></h3>

      <p><?php echo __('If you want to search again for another location, please use the \'Where\' field to enter the right location. It is also possible to expand your search to cover the whole of %s', array('%s' => $sf_user->getCountry()->getName())) ?></p>
      
      <p><?php echo __('Couldn\'t find the place you were looking for? Send it to us and we\'ll add it.') ?></p>
    </div>
  <?php else: ?>
    <div id="results">
      <div class="listing_tabs_top">
        <a href="<?php echo url_for('search/index?s='. $sf_request->getParameter('s'). '&w='. $sf_request->getParameter('w')) ?>"><?php echo __('Places') ?></a>
        <a href="<?php echo url_for('search/event?s='. $sf_request->getParameter('s'). '&w='. $sf_request->getParameter('w')) ?>" class="current"><?php echo __('Events') ?> (<span id="events_count"><?php echo $pagerevent->getNbResults() ?></span>)</a>
      </div>

      <div class="listing_tabs_content">
        <div class="listing_tabs_bar">
          <!--Optional bar-->
          <span><a href="#map" class="show_results"><?php echo __('Show results on map') ?></a></span>
        </div>
        
        <div class="listing_place_wrap">
          <ul class="event_pictures">
            <?php foreach($pagerevent->getResults() as $event): ?>
              <li><?php include_partial('event/event', array('event' => $event)) ?></li>
            <?php endforeach ?>
          </ul>            
          <div class="clear"></div>
        </div>
        
        <?php echo pager_navigation($pagerevent, 'search/index?s='. $sf_request->getParameter('s'). '&w='. $sf_request->getParameter('w')) ?>
        <div class="clear"></div>
      </div>
    </div>
  <?php endif ?>
  </div>
</div>
<div class="sidebar">
  <?php include_partial('home/sideBar') ?>
</div>
<div class="clear"></div>
<?php if($number_of_results): ?>
<script type="text/javascript">
$(document).ready(function() {
  $("#google_map").css('height', '100px');
})
</script>
<?php endif ?>