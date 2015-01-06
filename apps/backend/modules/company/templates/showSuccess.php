<?php use_helper('Date');?>
<div id="sf_admin_container">
  <h1><?php echo __('Places Management', array(), 'messages') ?></h1>

  <?php include_partial('company/flashes') ?>

  

  <div id="sf_admin_content">
   <form action="<?php echo url_for('company_collection', array('action' => 'batch')) ?>" method="post">
    
<div class="sf_admin_list">
  <?php if (!$company): ?>
    <p><?php echo __('No result', array(), 'sf_admin') ?></p>
  <?php else: ?>
    <table cellspacing="0">
      
      <tbody>
       
          <tr class="sf_admin_row <?php echo $odd ?>">
            <?php include_partial('company/list_td_batch_actions', array('company' => $company, 'helper' => $helper)) ?>
            <?php include_partial('company/list_td_stacked', array('company' => $company)) ?>
            <?php include_partial('company/list_td_actions', array('company' => $company, 'helper' => $helper)) ?>
          </tr>
       
      </tbody>
    </table>
  <?php endif; ?>
</div>

    </form>
  </div>

  <div id="sf_admin_footer">
  
  </div>
</div>
