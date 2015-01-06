<?php echo $form[$form->getCSRFFieldName()]; ?>

<div class="row">
    <div class="col-sm-12">
        <h2 class="form-title">
        <?php echo __('Report Abuse')?>
        
        <button type="button" class="close close_form_report" onclick="$('.reservation_content').html('')"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </h2>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="default-input-wrapper required <?php echo $form['email']->hasError() ? 'incorrect' : '' ?>">
            <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
            <?php echo $form['email']->renderLabel(null, array('class' => 'default-label')) ?>
            <?php echo $form['email']->render(array('placeholder' => $form['email']->renderPlaceholder(), 'class' => 'default-input')); ?>
            <div class="error-txt"><?php echo $form['email']->renderError() ?></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="default-input-wrapper required <?php echo $form['name']->hasError() ? 'incorrect' : '' ?>">
            <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
            <?php echo $form['name']->renderLabel(null, array('class' => 'default-label')) ?>
            <?php echo $form['name']->render(array('placeholder' => $form['name']->renderPlaceholder(), 'class' => 'default-input')); ?>
            <div class="error-txt"><?php echo $form['name']->renderError() ?></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="default-input-wrapper select-wrapper required <?php echo $form['offence']->hasError() ? 'incorrect' : '' ?>">
            <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
            <?php echo $form['offence']->renderLabel(null, array('class' => 'default-label')) ?>
            <?php echo $form['offence']->render(array('placeholder' => $form['offence']->renderPlaceholder(), 'class' => 'default-input')); ?>
            <div class="error-txt"><?php echo $form['offence']->renderError() ?></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="default-input-wrapper <?php echo $form['body']->hasError() ? 'incorrect' : '' ?>">
            <?php echo $form['body']->renderLabel(null, array('class' => 'default-label')) ?>
            <?php echo $form['body']->render(array('placeholder' => $form['body']->renderPlaceholder(), 'class' => 'default-input')); ?>
            <div class="error-txt"><?php echo $form['body']->renderError() ?></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <input type="submit" value="<?php echo __('Send', null, 'company'); ?>" class="default-btn success pull-right " />
    </div>
</div>