<?php
	foreach ($places as $place):
		$plaseTitle = $place->getCompanyPage()->getCompany()->getCompanyTitle($culture);
		$placeAddress = $place->getCompanyPage()->getCompany()->getDisplayAddress();
		$sPlaceText = $plaseTitle .' - '. $placeAddress;
		?> 
		<div>
		<p> 
			<?php echo $sPlaceText?> 
		</p> 
		<a onclick="$(this).parent().remove()">X</a>
		<input type="hidden" name="<?php echo $form['place_id']->renderName() ?>[]" value="<?php echo $place->getPageId();?>">
		</div>
		<?php 
	endforeach;