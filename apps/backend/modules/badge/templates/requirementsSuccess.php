<form action="<?php echo url_for('badge/requirements').'?id='. $badge->getId() ?>" method="post">
  
  <div class="wrap">
    <h2><?php echo $badge->getName() ?> (<?php echo link_to('edit', 'badge/index?id='.$badge->getId()) ?>)</h2>
    <table class="widefat">
      <thead>
        <tr>
          <th scope="col" width="100">Group#</th>
          <th scope="col">SUM(Fields)</th>
          <th scope="col">>= Value</th>
          <th scope="col">Options</th>
        </tr>
      </thead>

      <?php $i = 0; ?>
      <?php foreach($requirements as $i => $list): ?>
        <tr class="<?php $i%2==0 and print 'alternate' ?>">
          <td><?php echo $form[$i]['group_no'] ?></td>
          <td>
          <?php foreach($form->getEmbeddedForm($i)->getObject()->getBadgeRequirementField() as $field): ?>
            <?php echo $field->getKey() ?>
            <input type="hidden" name="<?php echo $form[$i]['key']->renderName() ?>[]" value="<?php echo $field->getKey() ?>" />
          <?php endforeach ?>
          </td>
          <td><?php echo $form[$i]['value'] ?></td>
          <td><input type="button" class="button" value="delete" onclick="$(this).parent().parent().remove()" /></td>
        </tr>
      <?php endforeach ?>
      
      <tr class="<?php ($i+1)%2==0 and print 'alternate' ?>">
        <td><?php echo $form['new']['group_no'] ?></td>
        <td>
          <select name="type" id="type">
            <option value="null">(Please select)</option>
            <option value="review"><?php echo __('reviews'); ?></option>
            <option value="photos">Photos</option>
            <option value="event_category"><?php echo __('Events', null, 'form'); ?></option>
          </select>
          
          <div class="option review" style="display: none;">
            <input type="radio" value="sector" name="review_type" checked="checked"> Sectors
            <input type="radio" value="classification" name="review_type"> Classifications
            
            <div class="options sector">
              <?php foreach($choices['review_sector'] as $choice): ?>
                <label><input type="checkbox" name="<?php echo $form['new']['key']->renderName() ?>[]" value="<?php echo $choice->getKey() ?>" /> <?php echo $choice->getName() ?></label>
              <?php endforeach ?>
            </div>
            
            <div class="options classification" style="display: none;">
              <?php foreach($choices['review_classification'] as $choice): ?>
                <label><input type="checkbox" name="<?php echo $form['new']['key']->renderName() ?>[]" value="<?php echo $choice->getKey() ?>" /> <?php echo $choice->getName() ?></label>
              <?php endforeach ?>
            </div>
          </div>

          <div class="option photos" style="display: none;">
            <input type="radio" value="sector" name="photo_type" checked="checked"> Sectors
            <input type="radio" value="classification" name="photo_type"> Classifications
            
            <div class="options sector">
              <?php foreach($choices['photo_sector'] as $choice): ?>
                <label><input type="checkbox" name="<?php echo $form['new']['key']->renderName() ?>[]" value="<?php echo $choice->getKey() ?>" /> <?php echo $choice->getName() ?></label>
              <?php endforeach ?>
            </div>
            
            <div class="options classification" style="display: none;">
              <?php foreach($choices['photo_classification'] as $choice): ?>
                <label><input type="checkbox" name="<?php echo $form['new']['key']->renderName() ?>[]" value="<?php echo $choice->getKey() ?>" /> <?php echo $choice->getName() ?></label>
              <?php endforeach ?>
            </div>
          </div>
          
          <div class="option event_category" style="display: none;">            
            <div class="options event">
              <?php foreach($choices['event_category'] as $choice): ?>
                <label><input type="checkbox" name="<?php echo $form['new']['key']->renderName() ?>[]" value="<?php echo $choice->getKey() ?>" /> <?php echo $choice->getName() ?></label>
              <?php endforeach ?>
            </div>
          </div>
        </td>
        <td><?php echo $form['new']['value'] ?></td>
        <td><input type="submit" class="button" value="Save" /></td>
      </tr>
    </table>
    
    <br class="clear" />
  </div>
 
</form>

<script type="text/javascript">
$(document).ready(function() {
  $('#type').change(function() {
    $('.option').hide();
    $('.option.'+ $(this).val()).show();
  })
  
  $('.option input[type=radio]').click(function() {
    $(this).parent().find('.options').hide();
    $(this).parent().find('.options.'+$(this).val()).show();
  })
})
</script>

<style>
label {
  float: left;
  width: 50%;
}
</style>