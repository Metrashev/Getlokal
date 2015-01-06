<?php use_helper('I18N', 'Date') ?>
<?php include_partial('get_weekend/assets') ?>

<div class="wrap">
  <h2><?php echo __('Edit this getWeekend episode', array(), 'messages') ?></h2>

  <?php include_partial('get_weekend/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('get_weekend/form_header', array('get_weekend' => $get_weekend, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('get_weekend/form', array('get_weekend' => $get_weekend, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('get_weekend/form_footer', array('get_weekend' => $get_weekend, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
