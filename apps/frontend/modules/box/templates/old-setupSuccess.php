<?php use_stylesheet(sfWpAdmin::getProperty('web_dir').'/css/admin_global.css') ?>
<?php use_stylesheet(sfWpAdmin::getProperty('web_dir').'/css/admin.css') ?>
<?php use_stylesheet(sfWpAdmin::getProperty('web_dir').'/css/admin_colors.css') ?>
<?php use_stylesheet(sfWpAdmin::getProperty('web_dir').'/css/admin_sf.css') ?>

<?php if($done): ?>
  <script language="javascript" type="text/javascript">
    window.parent.updateBox('<?php echo $sf_request->getParameter('xpath', ESC_RAW) ?>', '<?php echo $settings ?>');
  </script>
<?php else: ?>
  <?php include_partial('box/setup'. ucfirst($box->getComponent()), array('form' => $form, 'box' => $box)) ?>
<?php endif ?>