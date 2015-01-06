<?php slot('no_map', true) ?>
<?php slot('no_ads', true) ?>
<div class="settings_content menu">
  <h2 class="dotted"><?php  echo  __('Menu',null,'company'); ?></h2>
  <?php include_partial('menu', array('company' => $company, 'form' => $form)) ?>

</div>


<div class="clear"></div>
