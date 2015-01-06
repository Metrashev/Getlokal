<?php

/**
 * Sector form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SectorForm extends BaseSectorForm
{
  public function configure()
  {
    $this->embedI18n(array('en', 'ro', 'bg', 'mk', 'sr', 'fi', 'ru', 'hu', 'pt', 'fr', 'de', 'es'));
    
    $this->widgetSchema->moveField('sr', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('mk', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('ro', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('bg', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('en', sfWidgetFormSchema::FIRST);
    
    unset(
      $this['slider_list'],
      $this['updated_at'],
      $this['created_at']
    );
  }
}
