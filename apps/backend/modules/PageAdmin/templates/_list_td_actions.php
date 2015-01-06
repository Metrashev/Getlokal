<td>
  <ul class="sf_admin_td_actions">
    <li class="sf_admin_action_changeadminstatus">
    <?php if ($page_admin->getIsSamePlaceClaimed()):?>
     <?php echo 'Action Required by Company Admin'?>
     <?php endif;?>
    <?php switch ($page_admin->getStatus()):
           case 'approved':
             echo link_to(__('Reject', array(), 'messages'), 'PageAdmin/setAdminStatus?id='.$page_admin->getId(), array( 'confirm' => 'Are you sure?'));
           break;
           case 'rejected':           
             echo link_to(__('Approve', array(), 'messages'), 'PageAdmin/setAdminStatus?id='.$page_admin->getId(), array( 'confirm' => 'Are you sure?'));
           break;
           case 'pending':
           	echo link_to(__('Approve', array(), 'messages'), 'PageAdmin/setAdminStatus?status=approved&id='.$page_admin->getId(), array( 'confirm' => 'Are you sure?'));
           	echo '&nbsp;';
           	echo link_to(__('Reject', array(), 'messages'), 'PageAdmin/setAdminStatus?status=rejected&id='.$page_admin->getId(), array( 'confirm' => 'Are you sure?')) ;
           break;	
         endswitch; ?>
      
    </li>
    <?php echo $helper->linkToEdit($page_admin, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
    <?php echo $helper->linkToDelete($page_admin, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
  </ul>
</td>