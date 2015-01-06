<form action="<?php echo url_for('@ws_create?model=UserProfile&sf_format=json');?>" method="post">
 <?php echo $form?>
<input type="submit" value="<?php echo __('Send')?>" class="input_submit" />
    </form>