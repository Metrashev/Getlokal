<?php

/**
 * review module configuration.
 *
 * @package    getLokal
 * @subpackage review
 * @author     Get Lokal
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reviewGeneratorConfiguration extends BaseReviewGeneratorConfiguration
{
public function getPagerMaxPerPage() {
if (sfContext::getInstance()->getRequest()->getParameter('csv')) {

return 150000;
}
else {

return parent::getPagerMaxPerPage();
}
}
}
