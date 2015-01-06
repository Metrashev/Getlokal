<?php

/**
 * mail_bg module configuration.
 *
 * @package    getLokal
 * @subpackage mail_bg
 * @author     Get Lokal
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mail_bgGeneratorConfiguration extends BaseMail_bgGeneratorConfiguration {
	public function getPagerMaxPerPage() {
		if (sfContext::getInstance ()->getRequest ()->getParameter ( 'csv' )) {
			
			return 100000;
		} else {
			
			return parent::getPagerMaxPerPage ();
		}
	}
}
