<?php if ($form->getObject()->isNew()):?>
 <form action="<?php echo url_for('order/create?company_id='.$company->getId().'&token='.$token);?>" method="post">
  <?php else:?>
 <form action="<?php echo url_for('order/update?id='.$id.'&token='.$token);?>" method="post">
<?php endif;?>
 <?php echo $form?>
 <input type="submit" value="<?php echo __('Send')?>" class="input_submit" />
    </form>
