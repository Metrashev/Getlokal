<?php use_helper('XssSafe') ?>
<div class="list_offer">
	<?php if ($offer->getImageId() && $offer->getImage()->getFileName()) :?>
	    <?php echo link_to(image_tag($offer->getImage()->getThumb()),'offer/show?id='.$offer->getId(), array('class'=>'img_wrap', 'title' => $offer->getDisplayTitle())); ?>
        <?php else : ?>
            <?php echo link_to(image_tag('gui/default_offer_100x100.jpg'),'offer/show?id='.$offer->getId(), array('class'=>'img_wrap', 'title' => $offer->getDisplayTitle())); ?>
	<?php endif;?>
	
	<h3><?php echo link_to($offer->getDisplayTitle(),'offer/show?id='.$offer->getId());?></h3>
	
	<p><?php echo (mb_strlen($offer->getContent(ESC_XSSSAFE), 'UTF8') <= 120 )? $offer->getContent(ESC_XSSSAFE) : mb_substr($offer->getContent(ESC_XSSSAFE), 0, 120, 'UTF8').'...';?></p>

	<?php echo link_to(__('Order Voucher', null, 'offer'),'offer/show?id='.$offer->getId(), 'class=button_pink'); ?>
</div>
