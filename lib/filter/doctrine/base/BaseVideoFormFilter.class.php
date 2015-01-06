<?php

/**
 * Video filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseVideoFormFilter extends ImageFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('video_filters[%s]');
  }

  public function getModelName()
  {
    return 'Video';
  }
}