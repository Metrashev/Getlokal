<?php
 
function ezDate($d) { 
        $i18n = sfContext::getInstance()->getI18N();

        $ts = time() - strtotime(str_replace("-","/",$d)); 
        //$culture = sfContext::getInstance()->getUser()->getCulture ();
        if($ts>31536000){
        	$val = floor($ts/31536000);
        	if($val==1) $val = sprintf($i18n->__('over %s year ago' , null,'timeStamps'),$val);
        	else if($val>1) $val = sprintf($i18n->__('over %s years ago' , null,'timeStamps'),$val);
        }
        
        else if($ts>2419200){ 
        	$val = floor($ts/2419200);
        	if($val==1) $val = sprintf($i18n->__('over %s month ago' , null,'timeStamps'),$val);
        	else if($val>1) $val = sprintf($i18n->__('over %s months ago' , null,'timeStamps'),$val);
        }
        
        else if($ts>604800){
	        $val = floor($ts/604800);
	        if($val==1) $val = sprintf($i18n->__('over %s week ago' , null,'timeStamps'),$val);
	        else if($val>1) $val = sprintf($i18n->__('over %s weeks ago' , null,'timeStamps'),$val);
        }
        
        else if($ts>86400){
	        $val = floor($ts/86400);
	        if($val==1) $val = sprintf($i18n->__('over %s day ago' , null,'timeStamps'),$val);
	        else if($val>1) $val = sprintf($i18n->__('%s days ago' , null,'timeStamps'),$val); 
        } 
        
        else if($ts>3600){
        	$val = sprintf($i18n->__('%sh ago' , null,'timeStamps'),floor($ts/3600));
        } 
        
        else if($ts>60){
        	$val = sprintf($i18n->__('%s min ago' , null,'timeStamps'),floor($ts/60));
        } 
        
        else $val = $i18n->__('a few seconds ago' , null,'timeStamps'); 
        
        return $val; 
    }