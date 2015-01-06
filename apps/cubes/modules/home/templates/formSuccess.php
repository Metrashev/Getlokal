<form action="<?php echo url_for('home/index');?>" method="post">
  <?php echo $form?>
  <input type="submit" value="<?php echo __('Send')?>" class="input_submit" />
</form>