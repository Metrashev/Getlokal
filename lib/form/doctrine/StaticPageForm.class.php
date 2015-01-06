<?php

/**
 * StaticPage form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class StaticPageForm extends BaseStaticPageForm
{
  public function configure()
  {
  	$this->embedI18n( array(sfContext::getInstance()->getUser()->getCountry()->getSlug(), 'en')); 
  }

}
