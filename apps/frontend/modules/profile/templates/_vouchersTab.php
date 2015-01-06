<?php 
	use_helper('Date', 'Pagination');
	$culture = $sf_user->getCulture();
?>

<ul class="list-box-wrapper">
<?php  foreach ($pager->getResults() as $voucher){
	$company_offer = $voucher->getCompanyOffer();
	$company = $company_offer->getCompany(); 
?>
	<li class="list-box vouchers">
		<div class="custom-row">
			<div class="img-container">
				<?php
					if ($company_offer->getImageId()){ 
      					if ($image = Doctrine_Core::getTable ( 'Image' )->findOneById($company_offer->getImageId())){
           					echo image_tag($image->getThumb(2), array('size' => '110x73', 'class' => 'profile-img'));
      					}
      				}

      				$options = 'left=100,top=10,width=720,height=600,location=no,scrollbars =yes,resizable=yes,directories=no,status=no,toolbar=no,menub ar=no';
      				echo link_to( __('Print', null, 'offer'), 'offer/voucher?id='.$voucher->getId(),'class=default-btn small pull-left', array('popup' => array('theWindow', $options)));
    			?>
			</div>
			<div class="info">
				<?php echo link_to($company_offer->getDisplayTitle(),'offer/show?id='.$company_offer->getId(), array('class' => 'name'));?>
				<div class="location"><?php echo __('Voucher Code', null, 'offer')?>: <strong><?php echo $voucher->getCode();?></strong></div>
				<div class="location"><?php echo __('Name', null, 'form')?>: <strong><?php echo $user->getUserProfile();?></strong></div>
				<div class="location"><?php echo __('issued on', null, 'offer')?>: <strong><?php echo format_date($company_offer->getActiveTo(), 'dd MMM yyyy',$culture);?></strong></div>
				<div class="location"><?php echo __('Voucher Valid From', null, 'form')?>: <strong><?php echo format_date($company_offer->getValidFrom(), 'dd MMM yyyy',$culture);?></strong> 
				<?php echo __("to",null,"events") ?> <strong><?php echo format_date($company_offer->getValidTo(), 'dd MMM yyyy',$culture);?></strong> </div>
			</div>
		</div>
	</li><!-- END Voucher -->
<?php } ?>
</ul>

<?php echo pager_navigation($pager, url_for('profile/vouchers?username='. $pageuser->getUsername())); ?>