<?php use_helper('Date', 'Pagination');?>

<?php $culture = $sf_user->getCulture();?>
<?php  foreach ($pager->getResults() as $voucher): ?>
			<div class="voucher_item">
				<?php $company_offer = $voucher->getCompanyOffer(); ?>
				<?php $company = $company_offer->getCompany(); ?>
				
				<h3><?php echo link_to($company_offer->getDisplayTitle(),'offer/show?id='.$company_offer->getId());?></h3>		
				
				<?php if ($company_offer->getImageId()):?>
      				<?php if ($image = Doctrine_Core::getTable ( 'Image' )->findOneById($company_offer->getImageId())):?>
           					<?php echo image_tag($image->getThumb(2)) ?>
      				<?php endif;?>
    			<?php endif;?>
    			<div class="voucher_info">
	    		
	    				<li class="voucher_li">
							<?php echo __('Voucher Code', null, 'offer')?>: <b><?php echo $voucher->getCode();?></b> -  
							<?php echo __('Name', null, 'form')?>: <b><?php echo $user->getUserProfile();?>
							<?php echo $user->getLastName();?></b>
							<?php echo __('issued on', null, 'offer')?>: <?php echo format_date($company_offer->getActiveTo(), 'dd MMM yyyy',$culture);?>
						</li>
						<li class="voucher_li">
							<?php echo __('Voucher Valid From', null, 'form')?> <b><?php echo format_date($company_offer->getValidFrom(), 'dd MMM yyyy',$culture);?></b> <?php echo __("to",null,"events") ?> <b><?php echo format_date($company_offer->getValidTo(), 'dd MMM yyyy',$culture);?></b>
			    			<?php $url = url_for('offer/voucher?id='.$voucher->getId());?>
			 				<?php $options = 'left=100,top=10,width=720,height=600,location=no,scrollbars =yes,resizable=yes,directories=no,status=no,toolbar=no,menub ar=no' ?>
			 			</li>
		 			</br>
	 				<?php echo link_to( __('Print', null, 'offer'), 'offer/voucher?id='.$voucher->getId(),'class=button_print', array('popup' => array('theWindow', $options)));?>
	  			</div>
  				<div class="clear"></div>
  			</div>
<?php endforeach;?>