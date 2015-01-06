<?php

/**
 * getWeekend filter form.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class getWeekendFormFilter extends BasegetWeekendFormFilter
{
  public function configure()
  {
    unset(
      $this['country_id'],
      $this['created_at'],
      $this['updated_at'],
      $this['companies_list'],
      $this['events_list'],
      $this['filename']
    );
  }
}
