<?php 
foreach($boxes as $box) {
	if($box->getBox()->getComponent() == 'recommendations'){
		include_component($box->getBox()->getModule(), 'box'.ucfirst($box->getBox()->getComponent()), array('box' => $box));
	}
}
?>