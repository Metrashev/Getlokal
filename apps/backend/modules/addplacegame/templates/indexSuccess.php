<?php use_helper('I18N', 'Date') ?>
<?php include_partial('addplacegame/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Addplacegame List', array(), 'messages') ?></h1>

  <?php include_partial('addplacegame/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('addplacegame/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('addplacegame/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
  <?php $from = null; $to =null;?>
  <?php $date_val= $filters['company_created_at']->getValue();?>
  <?php if (!empty($date_val)):
   $date_val = $filters['company_created_at']->getValue();
   if ($date_val['from']):
     $from =$date_val['from'];
   endif;
   if ($date_val['to']):
     $to =$date_val['to'];
   endif;
  endif;
  ?>
    <?php include_partial('addplacegame/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper, 'from' => $from,  'to' => $to)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('addplacegame/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('addplacegame/list_actions', array('helper' => $helper)) ?>
    </ul>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('addplacegame/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
