<?php

/**
 * SerbianCities
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class SerbianCities extends BaseSerbianCities
{
	function __toString() {
		return (string) $this->getCityChange();
	}
}