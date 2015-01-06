<?php

/**
 * Company form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class backendListsForm extends BaseListsForm
{
  public function configure()
  {

  	unset(
      $this['image_id'],
      $this['user_id'],
      $this['updated_at'],
      $this['created_at'],
      $this['country_id'],
      $this['is_active']
      );
      
      $culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();
  	  $this->embedI18n(array('en', $culture));
    //$this->embedForm('location', new CompanyLocationForm($this->getObject()->getLocation()));
  }
}
