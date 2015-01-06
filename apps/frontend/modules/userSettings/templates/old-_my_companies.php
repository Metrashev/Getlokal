<?php use_helper('Pagination');?>
<?php foreach ($pager as $company):?>
<div>
<?php echo link_to_company_with_culture_or_title($company);?>
<?php if (!$user->getAllStatusPageAdmin($company)):?>
<?php echo link_to( __('Is this your business? Claim it!', null, 'company'), 'company/claim?slug='. $company->getSlug(), array('class'=>'button_pink')); ?>
<p><?php echo $company->getDisplayAddress();?></p>
<?php elseif ($user->getUserProfile()->getIsCompanyAdmin($company,'rejected')):?>
<span class="notice_red"><?php echo __("Admin Status 'Rejected'",null,'user')?></span>
<?php elseif ($user->getUserProfile()->getIsCompanyAdmin($company,'pending')):?>
<span class="notice_blue"><?php echo __("Admin Status 'Pending'",null,'user')?><img src="/images/gui/pending_loader.gif"/></span>
<?php elseif ($user->getUserProfile()->getIsCompanyAdmin($company,'approved')):?>
<span class="notice_blue approved"><?php echo __("Admin Status 'Approved'",null,'user')?></span>
<?php endif;?>
</div>
<?php endforeach;?>
<?php if( $pager->haveToPaginate()):?>
<?php  echo pager_navigation($pager, url_for('userSettings/findMyCompany?search='.$search)); ?>
<?php endif;?>


