<?php if ($field->isPartial()): ?>
  <?php include_partial('classification/'.$name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php elseif ($field->isComponent()): ?>
  <?php include_component('classification', $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php else: ?>
  <div class="<?php echo $class ?><?php $form[$name]->hasError() and print ' errors' ?>">
    <?php echo $form[$name]->renderError() ?>
    <div>
      <?php echo $form[$name]->renderLabel($label) ?>
<?php if ($field->getName()=='sectors'):?>
<?php if(!$form->getObject()->isNew()):?>
<?php echo 'Default Sector ' . $form->getObject()->getPrimarySector();?><br>
<?php endif;?> 
<?php echo '<span style="color:red">After classification is saved, Sector 1 will become a primary sector</span>'; ?>


<?php endif;?> 


      <div class="content"><?php echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?></div>
<?php if ($field->getName()=='sectors'):?>
<?php $i = count($form->getObject()->getClassificationSector()); 
if ($i == 0) $i=1;
     $i++;?>
    <div class="classifierButtons" id="classifierButtons<?php echo $i;?>">
				          	 <?php  echo  jq_link_to_remote('<span>Add Sector</span>', array(
                                  'update' => 'classifierButtons'.$i,
                                  'url'    => 'classification/addSector?id='.$form->getObject()->getId().'&num='.$i,
                                        'onclick'=>'return true'
                                        ));?>  
                      
                    </div> 
                    <?php endif;?>
      <?php if ($help): ?>
        <div class="help"><?php echo __($help, array(), 'messages') ?></div>
      <?php elseif ($help = $form[$name]->renderHelp()): ?>
        <div class="help"><?php echo $help ?></div>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>
