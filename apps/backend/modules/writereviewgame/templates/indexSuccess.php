<?php use_helper('I18N', 'Date') ?>
<?php include_partial('writereviewgame/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Writereviewgame List', array(), 'messages') ?></h1>

  <?php include_partial('writereviewgame/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('writereviewgame/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('writereviewgame/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
  <?php $from = null; $to =null;?>
  <?php $date_val= $filters['review_created_at']->getValue();?> 
  <?php if (empty($date_val['from'])):  
  $week = $filters['week_id']->getValue();   
  if ($week['text']):  
  $year = date('Y');
  $next_week = $week['text']+1;
  $from = date('Y-m-d', strtotime($year."W".$week['text'].'1'));
  $to = date('Y-m-d', strtotime($year."W".$next_week.'1'));
  $from = $from .' 00:00:00';
  $to = $to.' 00:00:00';
  endif;
  else: 
   $date_val = $filters['review_created_at']->getValue();
   if ($date_val['from']):
     $from =$date_val['from'];
   endif;
   if ($date_val['to']):
     $to =$date_val['to'];
   endif;
  endif;
  ?>
    <?php include_partial('writereviewgame/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper, 'from' => $from,  'to' => $to)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('writereviewgame/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('writereviewgame/list_actions', array('helper' => $helper)) ?>
    </ul>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('writereviewgame/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
