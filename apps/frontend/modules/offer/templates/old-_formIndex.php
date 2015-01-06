<?php
$sCulture = $sf_user->getCulture();

// company offer
//$formObject = $form->getObject();
?>
<div id="filters" class="selection_filter_wrap">
    
     <div class="city_selection ui-group <?php echo $form['city_id']->hasError() ? 'error' : '' ?>">
        <?php // echo $form['city_id']->renderLabel() ?>    
        <?php echo $form['city_id']->render() ?>
        <?php echo $form['city_id']->renderError() ?>
     </div> 
    <div class="sector_selection ui-group <?php echo $form['sector_id']->hasError() ? 'error' : '' ?>">
        <?php // echo $form['sector_id']->renderLabel() ?>
        <?php echo $form['sector_id']->render() ?>
        <?php echo $form['sector_id']->renderError() ?>
    </div>
    
    <div class="sorting_wrap <?php echo 'lg_'.$sf_user->getCulture() ?> <?php echo $form['order']->hasError() ? 'error' : '' ?>">
        <?php echo $form['order']->renderLabel() ?>
        <?php echo $form['order']->render() ?>
        <?php echo $form['order']->renderError() ?>
    </div>
    <div class="separator_dotted"></div>
</div>        

  