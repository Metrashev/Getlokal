<?php slot('no_ads', true) ?>
<?php slot('no_map', true) ?>
<div class="settings_content">
  <h2><?php echo __('Find your company in getlokal',null,'company'); ?></h2>
 
  <form action="<?php echo url_for('userSettings/findMyCompany')?>" method="post">
    <?php echo $form[$form->getCSRFFieldName()]; ?>
   <div class="form_box <?php echo $form['mycompany']->hasError()? 'error': ''?>">
      <?php echo $form['mycompany']->renderLabel() ?>
        
      <?php echo $form['mycompany']->render( array('value' => $search) ); ?>
      <?php echo $form['mycompany']->renderError() ?>
    </div>
     <div class="form_box">
      <input type="submit" value="<?php echo __('Search')?>" class="input_submit" />
    </div>
  </form>
  <?php if (isset($pager)):?>
  <?php if ($pager->getNbResults() > 0):?>
  <div id="my_companies">
  <?php include_partial('my_companies', array('pager' => $pager, 'user'=>$user, 'search'=>$search));?>
  </div>
  <?php else: ?>
  <?php echo __('No results found.'); ?>
  <?php endif;?>
  
  <p><?php echo sprintf(__('Click %s to add new company.', null, 'company'),link_to(__('here', null, 'user'), 'company/addCompany'));?></p>
  <?php endif;?>
</div>
