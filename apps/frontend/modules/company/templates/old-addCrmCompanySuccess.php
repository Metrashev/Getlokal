 <?php use_helper('jQuery')?>
 <?php use_javascript('/sfFormExtraPlugin/js/jquery.autocompleter.js') ?>
<?php use_stylesheet('/sfFormExtraPlugin/css/jquery.autocompleter.css') ?>
<?php print_r ($form->getAllErrors());?>
 <form action="<?php echo url_for('company/addCrmCompany');?>" method="post">
  
 
 <?php echo $form?>
<input type="submit" value="<?php echo __('Send')?>" class="input_submit" />
    </form>