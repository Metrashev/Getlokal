<?php
	foreach ($places as $place){
		$plaseTitle = $place->getCompanyPage()->getCompany()->getCompanyTitle($culture);
		$placeAddress = $place->getCompanyPage()->getCompany()->getDisplayAddress();
		$sPlaceText = $plaseTitle .' - '. $placeAddress;
		?> 
		
		<li class="tag"> 
			<?php echo $sPlaceText?> 
			<a onclick="$(this).parent().remove()"><i class="close"></i></a>
			<input type="hidden" name="<?php echo $form['place_id']->renderName() ?>[]" value="<?php echo $place->getPageId();?>">
		</li>
	<?php }	?>