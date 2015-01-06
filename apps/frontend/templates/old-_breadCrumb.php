<?php if($sf_context->getActionName() == 'forgotPassword' || $sf_context->getActionName() == 'claim'
        || ($sf_context->getActionName() == 'signin') || ($sf_context->getActionName() == 'register')
        || ($sf_params->get('module') == 'contact' && $sf_params->get('action') == 'getlokal')
        || ($sf_params->get('module') == 'contact' && $sf_params->get('action') == 'getlokaloffices')
        || ($sf_params->get('module') == 'review' && $sf_params->get('action') == 'index')): ?>
<?php if (count(breadCrumb::getInstance()->getItems())) : ?>
<div id="content"></div>
<div class="path_wrap path_wrap_big">
  <div class="path">
    <h1>
      <?php foreach(breadCrumb::getInstance()->getItems() as $i=>$item): ?>
        <?php if($item->getUri()): ?>
          <?php echo link_to($item->getText(), $item->getUri()) ?>
        <?php else: ?>
          <?php echo $item->getText() ?>
        <?php endif ?>

        <?php if($i+1 < sizeof(breadCrumb::getInstance()->getItems())) echo '<span>/</span>'; ?>
      <?php endforeach ?>
    </h1>
  </div>
</div>
<?php endif; ?>

<?php elseif($sf_params->get('module') != 'event' && ($sf_params->get('module') != 'home' && $sf_params->get('action') != 'classification')): ?>
<?php if (count(breadCrumb::getInstance()->getItems())) : ?>
<div id="content"></div>
<div class="path_wrap">
  <div class="path">
    <h1>
      <?php foreach(breadCrumb::getInstance()->getItems() as $i=>$item): ?>
        <?php if($item->getUri()): ?>
          <?php echo link_to($item->getText(), $item->getUri()) ?>
        <?php else: ?>
          <?php echo $item->getText() ?>
        <?php endif ?>

        <?php if($i+1 < sizeof(breadCrumb::getInstance()->getItems())) echo '<span>/</span>'; ?>
      <?php endforeach ?>
    </h1>
  </div>
</div>
<?php endif; ?>

<?php endif; ?>
