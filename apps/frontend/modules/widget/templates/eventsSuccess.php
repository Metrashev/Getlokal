<?php
  use_helper('Text');
  $uri = sprintf('@widget?action=events',
    $sf_request->getParameter('width'),
    $sf_request->getParameter('height'),
    $sf_request->getParameter('color', 'white'));
?>
<ul id="tabs">
  <li class="a"><a href="#all">ALL</a></li>
  <?php if (count($weekend) > 0): ?>
    <li><a href="#weekend">THIS WEEKEND</a></li>
  <?php endif ?>
</ul>
<div class="clear"></div>
<ul class="tabs">
  <li id="all">
    <?php include_partial('list_events', array('events' => $events)); ?>
  </li>

  <?php if (count($weekend)): ?>
    <li id="weekend">
      <?php include_partial('list_events', array('events' => $weekend)); ?>
    </li>
  <?php endif ?>
</ul>
<div id="change-city">
  <form action="<?php echo url_for($uri) ?>" method="get">
    <a href="#"><?php echo __('Change city',null,'contact') ?></a>
    <?php echo $city_form->renderHiddenFields(); ?>
    <?php echo $city_form['city']; ?>
  </form>
</div>
