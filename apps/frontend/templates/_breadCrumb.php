<?php 
	if ($sf_context->getActionName() == 'forgotPassword' || $sf_context->getActionName() == 'claim'
        	|| ($sf_context->getActionName() == 'signin') || ($sf_context->getActionName() == 'register')
        	|| ($sf_params->get('module') == 'contact' && $sf_params->get('action') == 'getlokal')
        	|| ($sf_params->get('module') == 'contact' && $sf_params->get('action') == 'getlokaloffices')
        	|| ($sf_params->get('module') == 'review' && $sf_params->get('action') == 'index')) { 
 		if (count(breadCrumb::getInstance()->getItems())) { ?>
		<div class="path-holder"> 
	      <?php
	      	if (!isset($breadCrumb)) {
				$breadCrumb = breadCrumb::getInstance()->getItems();
			}
	      	foreach($breadCrumb as $i=>$item) { 
	         	if($item->getUri()) {
	           		echo link_to($item->getText(), $item->getUri(), array('class' => 'path-item'));
	            }
	            else { 
	            	echo $item->getText();
	        	}
	
	        	if($i+1 < sizeof(breadCrumb::getInstance()->getItems())) echo '<span>/</span>'; 
	        }
	      ?>
		</div>

   <?php } ?>
<?php } 
	elseif($sf_params->get('module') != 'event') {
 		if (count(breadCrumb::getInstance()->getItems())) { ?>
		<div class="path-holder">   
	      <?php 
	      	foreach(breadCrumb::getInstance()->getItems() as $i=>$item) {
	        	if($item->getUri()) { 
	         		echo link_to($item->getText(), $item->getUri(), array('class' => 'path-item'));
	         	}
	         	else { 
	         		echo $item->getText();
	         	} 
	
	         	if($i+1 < sizeof(breadCrumb::getInstance()->getItems())) echo '<span>/</span>';
	        }
	      ?>
		</div>

   <?php } ?>
<?php } ?>
