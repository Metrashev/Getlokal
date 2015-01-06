<?php

/**
 * user_profile module configuration.
 *
 * @package    getLokal
 * @subpackage user_profile
 * @author     Get Lokal
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class user_profileGeneratorConfiguration extends BaseUser_profileGeneratorConfiguration {
	public function getPagerMaxPerPage() {
		if (sfContext::getInstance ()->getRequest ()->getParameter ( 'csv' )) {
			
			return 100000;
		} else {
			
			return parent::getPagerMaxPerPage ();
		}
	}
}
