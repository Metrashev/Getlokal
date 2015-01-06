<div class="wrap">

<h2>Premiuim Place Page Service <?php echo $company ?> (<?php echo link_to('back', 'company/index') ?>)</h2>


<br class="clear">



</div>

<br class="clear">

<div class="wrap">
  <h2>Create a Premium Place Page Service for <?php echo $company->getCompanyTitle(); ?></h2>
<?php if($sf_user->hasFlash('notice')): ?>
    <div class="flash_success">
      <?php echo __($sf_user->getFlash('notice')) ?>
    </div>
  <?php endif; ?>
  <form action="<?php echo url_for('company/pPP') ?>?id=<?php echo $company->getId() ?>" method="post" >
    <?php //echo $form['_csrf_token'] ?>
   
   
    <table class="form-table">
      <tbody>
      
        <tr class="form-field form-required">
          <th scope="row" valign="top"><?php echo $form['active_from']->renderLabel() ?></th>
          <td><?php echo $form['active_from'] ?> 
          <?php if ($form['active_from']->hasError()) echo $form['active_from']->renderError() ?>
      </td></tr>
      <?php if (isset($form['active_to'])): ?>
      <tr class="form-field form-required">
          <th scope="row" valign="top"><?php echo $form['active_to']->renderLabel() ?></th>
          <td><?php echo $form['active_to'] ?> 
          <?php if ($form['active_to']->hasError()) echo $form['active_to']->renderError() ?>
      </td></tr>
      <?php endif; ?>
      <tr class="form-field form-required">
          <th scope="row" valign="top"><?php echo $form['status']->renderLabel() ?></th>
          <td><?php echo $form['status'] ?> 
          <?php if ($form['status']->hasError()) echo $form['status']->renderError() ?>
      </td></tr>
    
    </tbody></table>
  <p class="submit"><input type="submit" class="button" name="submit" value="Add Package"></p>
  </form>
</div>