<?php if ((isset($mail) && $mail=true)):?>
<form action="<?php echo url_for('placeadmin/checkUser?token='.$token);?>" method="post">
<?php else:?>
<?php if ( $form->getObject()->isNew()):?>
 <form action="<?php echo url_for('placeadmin/create?token='.$token);?>" method="post">
  <?php else:?>
 <form action="<?php echo url_for('placeadmin/update?id='.$id.'&token='.$token);?>" method="post">
<?php endif;?>
<?php endif;?>
 <?php echo $form?>
 <input type="submit" value="<?php echo __('Send')?>" class="input_submit" />
    </form>
