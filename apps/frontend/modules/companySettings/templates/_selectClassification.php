<div  id="classification_id<?php echo $index; ?>" > 	
    <?php
    echo $form['classifications[orderclass][' . $index . '][classification_id]']->renderLabel(null, array('class' => 'default-label'));
    echo $form['classifications[orderclass][' . $index . '][classification_id]']->render(array('class' => 'default-input'));
    ?>
</div>