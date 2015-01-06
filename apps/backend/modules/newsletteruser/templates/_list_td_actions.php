<td>
  <ul class="sf_admin_td_actions">
    <?php //echo $helper->linkToEdit($newsletter_user, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
    <?php echo $helper->linkToDelete($newsletter_user, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Unsubscribe/Remove',)) ?>
 
    <?php
        if ($status /*$newsletter_user->getIsActive()*/) {
            echo link_to(__('Unsubscribe from group', array(), 'messages'), 'newsletteruser/setStatus?status=0&id='.$newsletter_user->getId() . '&mcgroup=' . $newsletter_user->getNewsletterId(), array( 'confirm' => 'Are you sure?'));
        }
        else {
            echo link_to(__('Subscribe to group', array(), 'messages'), 'newsletteruser/setStatus?status=1&id='.$newsletter_user->getId() . '&mcgroup=' . $newsletter_user->getNewsletterId(), array( 'confirm' => 'Are you sure?'));
        }
    ?>

   </ul>
</td>
