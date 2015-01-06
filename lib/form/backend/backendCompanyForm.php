<?php

/**
 * Company form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class backendCompanyForm extends BaseCompanyForm
{
  public function configure()
  {
    
    unset(
      $this['power_page_admin_id'],
      $this['updated_crm'],
      $this['date_mod_crm'],
      $this['average_rating'],
      $this['number_of_reviews'],
      $this['external_id'],
      $this['parent_external_id'],
      $this['location_id'],
      $this['updated_at'],
      $this['created_at']
    );
    
    $this->embedForm('location', new CompanyLocationForm($this->getObject()->getLocation()));
  }
}
