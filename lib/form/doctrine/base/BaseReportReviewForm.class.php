<?php

/**
 * ReportReview form base class.
 *
 * @method ReportReview getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseReportReviewForm extends ReportForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('report_review[%s]');
  }

  public function getModelName()
  {
    return 'ReportReview';
  }

}
