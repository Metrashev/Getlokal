<?php

/**
 * City form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CityForm extends BaseCityForm
{
  public function configure()
  {
      
      unset($this['id'],$this ['referer']);
      $culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();
      $cultures = sfConfig::get('app_languages_'.$culture);

      $this->embedI18n($cultures);
  }
}
