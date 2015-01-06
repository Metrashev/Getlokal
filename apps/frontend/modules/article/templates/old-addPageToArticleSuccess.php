<?php 
	$placeTitle = $place->getCompanyPage()->getCompany()->getCompanyTitleByCulture();
	$placeAddress = $place->getCompanyPage()->getCompany()->getDisplayAddress();
	$sPlaceText = $placeTitle .' - '. $placeAddress;
?> 
<li>
	<a href="#" id="<?php echo $place->getId()?>" class="button_x"><img src="/images/gui/btn_x.png" alt="X" /></a>
	<span class="pink"><?php echo $sPlaceText?></span>
</li>