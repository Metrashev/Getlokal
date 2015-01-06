<div class="wrap">

<h2>Package <?php echo $company ?> (<?php echo link_to('back', 'company/index') ?>)</h2>


<br class="clear">



</div>

<br class="clear">

<div class="wrap">
  <h2>Create a package for <?php echo $company->getCompanyTitle(); ?></h2>
<?php if($sf_user->hasFlash('notice')): ?>
    <div class="flash_success">
      <?php echo __($sf_user->getFlash('notice')) ?>
    </div>
  <?php endif; ?>
  <form action="<?php echo url_for('company/package') ?>?id=<?php echo $company->getId() ?>" method="post" >
    <?php //echo $form['_csrf_token'] ?>
   
   
    <table class="form-table">
      <tbody>
       <tr class="form-field form-required">
          <th scope="row" valign="top">NOTE</th>
          <td>Package Includes: TOP_IN_SEARCH, 30 DAY OFFER, DETAIL_DESCRIPTION,
          CLASSIFICATIONS, VIDEO, 30 DAY VIP</td>
      </tr>
        <tr class="form-field form-required">
          <th scope="row" valign="top"><?php echo $form['active_from']->renderLabel() ?></th>
          <td><?php echo $form['active_from'] ?> 
          <?php if ($form['active_from']->hasError()) echo $form['active_from']->renderError() ?>
      </td></tr>
      <tr class="form-field form-required">
          <th scope="row" valign="top"><?php echo $form['active_to']->renderLabel() ?></th>
          <td><?php echo $form['active_to'] ?> 
             
              <?php if ($form['active_to']->hasError()) echo $form['active_to']->renderError() ?></td>
      </tr>
       <tr class="form-field form-required">
          <th scope="row" valign="top">NOTE</th>
          <td>If you do not select Valid From/To dates :<br> 
         If Active From/To is earlier than today's date (<?php echo date ('Y-m-d')?>)- Valid From/To dates  will be automatically filled with Active From/To dates selected.<br><br>
         If Active From/To is later than today's date (<?php echo date ('Y-m-d')?>)- Valid From/To dates  will be automatically filled with 
         <?php echo date ('Y-m-d')?> / <?php echo date('Y-m-d',strtotime(date('Y-m-d',strtotime("+1 Year"))));?>. 
         </td>
      </tr>
       <tr class="form-field form-required">      
          <th scope="row" valign="top"><?php echo $form['valid_from']->renderLabel() ?></th>
          <td><?php echo $form['valid_from'] ?> 
             <?php if ($form['valid_from']->hasError()) echo $form['valid_from']->renderError() ?>
      </td></tr>
      <tr class="form-field form-required">
          <th scope="row" valign="top"><?php echo $form['valid_to']->renderLabel() ?></th>
          <td><?php echo $form['valid_to'] ?> 
         <?php if ($form['valid_to']->hasError()) echo $form['valid_to']->renderError() ?></td>
      </tr>
    </tbody></table>
  <p class="submit"><input type="submit" class="button" name="submit" value="Add Package"></p>
  </form>
</div>