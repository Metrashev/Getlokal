<?php

/**
 * ReportImage form base class.
 *
 * @method ReportImage getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseReportImageForm extends ReportForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('report_image[%s]');
  }

  public function getModelName()
  {
    return 'ReportImage';
  }

}
