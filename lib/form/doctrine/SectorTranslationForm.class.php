<?php

/**
 * SectorTranslation form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SectorTranslationForm extends BaseSectorTranslationForm
{
  public function configure()
  {
    $this->setWidget('description', new sfWidgetFormTextareaTinyMCECustom());

    $this->widgetSchema['title']->setOption('label', 'Sector name');
    $this->widgetSchema['page_title']->setOption('label', 'Page & meta title');
  }
}
