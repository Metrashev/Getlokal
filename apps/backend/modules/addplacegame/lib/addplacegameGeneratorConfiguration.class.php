<?php

/**
 * addplacegame module configuration.
 *
 * @package    getLokal
 * @subpackage addplacegame
 * @author     Get Lokal
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class addplacegameGeneratorConfiguration extends BaseAddplacegameGeneratorConfiguration
{
public function getPagerMaxPerPage() {
	if (sfContext::getInstance()->getRequest()->getParameter('csv')) {

return 10000;
}
else {

return parent::getPagerMaxPerPage();
}
}
}
	
