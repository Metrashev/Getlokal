<?php
	foreach ($places as $place){
		$plaseTitle = $place->getCompanyPage()->getCompany()->getCompanyTitleByCulture();
		$placeAddress = $place->getCompanyPage()->getCompany()->getDisplayAddress();
		$sPlaceText = $plaseTitle .' - '. $placeAddress;
		include_partial('global/tag', array('id' => $place->getId(), 'text' => $sPlaceText));
	}
?>