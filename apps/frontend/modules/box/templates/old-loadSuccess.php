<div class="box">
  <?php include_component($box->getModule(), 'box'.ucfirst($box->getComponent()), array('box' => $box)) ?>
  
  <?php include_partial('box/box_setup', array('box' => $box)) ?>
</div>