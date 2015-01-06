<?php use_helper('jQuery');?>

<?php if ($form->getObject()->isNew()):?>
 <form action="<?php echo url_for('company/create?token='.$token);?>" method="post">
<?php elseif (isset($action) && $action == 'merge'):?>
 <form action="<?php echo url_for('company/merge?company1_id='.$form->getObject()->getId().'&company2_id='.$object_to_hide->getId().'&token='.$token);?>" method="post">
<?php else:?>
 <form action="<?php echo url_for('company/update?id='.$form->getObject()->getId().'&token='.$token);?>" method="post">
<?php endif;?>
 <?php echo $form?>
 <input type="submit" value="<?php echo __('Send')?>" class="input_submit" />
    </form>
