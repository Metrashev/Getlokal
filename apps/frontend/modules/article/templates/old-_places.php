<?php
foreach ($places as $place):
	$plaseTitle = $place->getCompanyPage()->getCompany()->getCompanyTitleByCulture();
	$placeAddress = $place->getCompanyPage()->getCompany()->getDisplayAddress();
	$sPlaceText = $plaseTitle .' - '. $placeAddress;?> 
	<li>
		<a href="#" id="<?php echo $place->getId()?>" class="button_x"><img src="/images/gui/btn_x.png" alt="X" /></a>
		<span class="pink"><?php echo $sPlaceText?></span>
	</li>
<?php endforeach; ?>