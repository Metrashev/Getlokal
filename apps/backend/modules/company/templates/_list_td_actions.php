<td>
  <ul class="sf_admin_td_actions">
    <li class="sf_admin_action_images">
      <?php echo link_to(__('Images', array(), 'messages'), 'company/images?id='.$company->getId(), array()) ?>
    </li>
    <?php //echo $helper->linkToEdit($company, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
    <?php  echo $helper->linkToDelete($company, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
    <?php if (/*getlokalPartner::getInstanceDomain() == 78 && */$company->getStatus() == CompanyTable::VISIBLE):?>
    <li class="sf_admin_action_ppp">
      <?php echo link_to(__('Create Premiuim Place Page Service', array(), 'messages'), 'company/pPP?id='.$company->getId(), array()) ?>
    </li>
    <li class="sf_admin_action_deal">
      <?php echo link_to(__('Create Deal Service', array(), 'messages'), 'company/deal?id='.$company->getId(), array()) ?>
    </li>   
    <li class="sf_admin_action_addtomailbgcampaign">
      <?php echo link_to(__('Add To Mail Bg Campaign', array(), 'messages'), 'mail_bg/addCompany?id='.$company->getId(), array()) ?>
    </li>
    <?php endif;?>
    <?php if ($company->getCountryId() == 78):?>
    <?php if ($company->getStatus() == CompanyTable::NEW_PENDING):?>
     <?php echo link_to(__('Approve', array(), 'messages'), 'company/setStatus?id='.$company->getId().'&status='.CompanyTable::VISIBLE, array()) ?>
     <?php echo link_to(__('Reject', array(), 'messages'), 'company/setStatus?id='.$company->getId().'&status='.CompanyTable::REJECTED, array()) ?>
    <?php endif;?>
    <?php if ($company->getStatus() == CompanyTable::REJECTED):?>
     <?php echo link_to(__('Approve', array(), 'messages'), 'company/setStatus?id='.$company->getId().'&status='.CompanyTable::VISIBLE, array()) ?>
   <?php endif;?>
    <?php if ($company->getStatus() == CompanyTable::VISIBLE):?>
     <?php echo link_to(__('Reject', array(), 'messages'), 'company/setStatus?id='.$company->getId().'&status='.CompanyTable::REJECTED, array()) ?>
    <?php endif; ?>
    <?php endif; ?>
  </ul>
</td>
