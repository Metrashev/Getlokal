<?php

/**
 * company module configuration.
 *
 * @package    getLokal
 * @subpackage company
 * @author     Get Lokal
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class companyGeneratorConfiguration extends BaseCompanyGeneratorConfiguration
{

	public function getFilterDefaults()
	{    
    	return array('country' => 'default');
	}
	
	public function getPagerMaxPerPage() {
		if (sfContext::getInstance ()->getRequest ()->getParameter ( 'csv' )) {
			return 100000;
		} 
		else {
			return parent::getPagerMaxPerPage ();
		}
	}

}
