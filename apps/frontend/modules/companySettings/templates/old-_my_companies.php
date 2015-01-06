<?php use_helper('Pagination');?>
<?php foreach ($pager as $company):?>
<div>
<?php echo link_to_company($company);?>
<?php echo $company->getDisplayAddress();?>
<?php if (!$user->getAllStatusPageAdmin($company)):?>
 - <?php echo link_to( __('Is this your business? Claim it!', null, 'company'), 'company/claim?slug='. $company->getSlug(), array('class'=>'button_pink')); ?>
<br><br>
<?php endif;?>
</div>
<?php endforeach;?>
<?php if( $pager->haveToPaginate()):?>
<?php  echo pager_navigation($pager, url_for('userSettings/findMyCompany?search='.$search)); ?>
<?php endif;?>
