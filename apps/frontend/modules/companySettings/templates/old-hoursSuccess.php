<?php slot('no_map', true) ?>
<?php slot('no_ads', true) ?>
<div class="settings_content working_hours">
  <h2 class="dotted"><?php echo __('Working Hours', null,'company')?></h2>
  
  <form id="cs-form" action="<?php echo url_for('companySettings/hours?slug='. $company->getSlug()) ?>" method="post">
    <?php echo $form['_csrf_token']->render() ?>    
    <?php foreach(array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun') as $day): ?><div class="clear"></div>
      <div class="form_box <?php echo $form[$day.'_from']->hasError()? 'error': '' ?>">
        <?php echo $form[$day.'_from']->renderLabel() ?>
          
          <div class="from_to" id="timetable">  
            <?php echo __('From',null,'company')?> 
            <?php echo $form[$day.'_from']->render() ?>        
               <?php echo __('To',null,'company')?> 
            <?php echo $form[$day.'_to']->render() ?>        
            <?php echo $form[$day.'_from']->renderError() ?>
            <input type="checkbox" <?php echo ($form->getObject()->get($day.'_from') == '1' AND $form->getObject()->get($day.'_to') == '1') ? 
            'checked="checked"' :''?> id="company_close_<?php echo $day?>"  
            name="company_detail[close_<?php echo $day?>]"><?php echo __('Closed',null,'company')?>
          </div>
          <div class="clear"></div>
      </div>
      <div class="clear"></div>
    <?php endforeach ?>
       <div class="clear"></div>
    <div class="form_box">
      <input type="submit" value="<?php echo __('Save')?>" class="button_green" />
    </div>

  </form>

</div>
<div class="clear"></div>
