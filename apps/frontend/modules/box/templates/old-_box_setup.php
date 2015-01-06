<?php if($sf_user->getAttribute('edit_mode')): ?>
  <div class="setup" style="position: absolute; top: 0; right: 0; background: #eee;">
  <a href="<?php echo url_for('box/setup?id='. $box->getBox()->getId()) ?>" class="lightbox_setup">setup</a>
  <a href="#" class="remove" onclick="$(this).parent().parent().remove(); return false">remove</a>
  </div>

  <input type="hidden" class="box_id" value="<?php echo $box->getBox()->getId() ?>" />
  <input type="hidden" class="box_settings" value="<?php echo $box->getStringSettings() ?>" />
<?php endif ?>