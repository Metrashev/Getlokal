<?php

/**
 * company_offer module configuration.
 *
 * @package    getLokal
 * @subpackage company_offer
 * @author     Get Lokal
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class company_offerGeneratorConfiguration extends BaseCompany_offerGeneratorConfiguration
{

	public function getPagerMaxPerPage() {
		if (sfContext::getInstance ()->getRequest ()->getParameter ( 'csv' )) {
			return 100000;
		} 
		else {
			return parent::getPagerMaxPerPage ();
		}
	}
}
