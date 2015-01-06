<?php

/**
 * writereviewgame module configuration.
 *
 * @package    getLokal
 * @subpackage writereviewgame
 * @author     Get Lokal
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class writereviewgameGeneratorConfiguration extends BaseWritereviewgameGeneratorConfiguration
{
  public function getPagerMaxPerPage() {
		if (sfContext::getInstance ()->getRequest ()->getParameter ( 'csv' )) {
			
			return 10000;
		} else {
			
			return parent::getPagerMaxPerPage ();
		}
	}
}
