<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="sf_admin_form">
  <?php echo form_tag_for($form, '@get_weekend') ?>
    <?php echo $form->renderHiddenFields(false) ?>

    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>

  <form action="/backend_dev.php/company/images/action?id=219998" method="post" enctype="multipart/form-data">
  <table class="form-table">
    <tbody>
      <?php foreach(array('title', 'title_en', 'body', 'body_en', 'embed', 'aired_on') as $field): ?>
      <tr class="form-field form-required">
        <th scope="row" valign="top"><?php echo $form[$field]->renderLabel() ?></th>
        <td>
          <?php echo $form[$field] ?><br>
          <?php echo $form[$field]->renderError() ?>
        </td>
        
      </tr>
      <?php endforeach ?>
      
      <tr class="form-field">
        <th scope="row" valign="top"><?php echo $form['file']->renderLabel('Select a photo from your computer. Please upload a JPG, GIF or PNG image file.') ?></th>
        <td>
          <?php echo $form['file'] ?><br>
          <?php echo $form['file']->renderError() ?>
        </td>
      </tr>
      
      <tr class="form-field company">
        <th scope="row" valign="top">Companies</th>
        <td class="companies">
          <?php $values = $form->getTaintedValues(); ?>
          <?php if(($default = @$values['companies_list']) || ($default = $form->getDefault('companies_list'))): ?>
            <?php foreach(Doctrine::getTable('Company')->createQuery('c')->whereIn('c.id', $default)->execute() as $company): ?>
              <?php include_partial('company', array('company' => $company)) ?>
            <?php endforeach ?>
          <?php endif ?>
        </td>
      </tr>
      
      <tr class="form-field company">
        <th scope="row" valign="top"><?php echo __('Events', null, 'form'); ?></th>
        <td class="events">
          <?php $values = $form->getTaintedValues(); ?>
          <?php if(($default = @$values['events_list']) || ($default = $form->getDefault('events_list'))): ?>
            <?php foreach(Doctrine::getTable('Event')->createQuery('c')->whereIn('c.id', $default)->execute() as $company): ?>
              <?php include_partial('event', array('event' => $company)) ?>
            <?php endforeach ?>
          <?php endif ?>
        </td>
      </tr>
    </tbody>
  </table>

  <p class="submit"><?php include_partial('get_weekend/form_actions', array('get_weekend' => $get_weekend, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?></p>
  </form>
  
  <form action="<?php echo url_for('get_weekend/addCompany') ?>" method="post" class="companies_form">
    <h2>Add company</h2>
    
    <table class="form-table">
      <tbody>
        <tr class="form-field form-required">
          <th scope="row" valign="top"><label for="image_caption">Slug</label></th>
          <td>
            <input type="text" name="slug" value="" />
            <br>The name is used to identify the category almost everywhere, for example under the post or in the category widget.
          </td>
        </tr>
        
      </tbody>
    </table>
    <p class="submit"><input type="submit" class="button" name="submit" value="Add"></p>
  </form>
  
  <form action="<?php echo url_for('get_weekend/addEvent') ?>" method="post" class="events_form">
    <h2>Add event</h2>
    
    <table class="form-table">
      <tbody>
        <tr class="form-field form-required">
          <th scope="row" valign="top"><label for="image_caption">Id</label></th>
          <td>
            <input type="text" name="id" value="" />
            <br>The name is used to identify the category almost everywhere, for example under the post or in the category widget.
          </td>
        </tr>
        
      </tbody>
    </table>
    <p class="submit"><input type="submit" class="button" name="submit" value="Add"></p>
  </form>
</div>

<script type="text/javascript">
$(document).ready(function() {
  $('.companies_form').submit(function() {
    $.ajax({
      url: this.action,
      data: $(this).serialize(),
      success: function(data) {
        
        $('.companies').append(data);
      }
    })
    
    this.reset();
    return false;
  });
  
  $('.events_form').submit(function() {
    $.ajax({
      url: this.action,
      data: $(this).serialize(),
      success: function(data) {
        
        $('.events').append(data);
      }
    });
    
    this.reset();
    return false;
  });
})
</script>