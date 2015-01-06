<?php

/**
 * ClassificationSector filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseClassificationSectorFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'classification_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Classification'), 'add_empty' => true)),
      'sector_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sector'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'classification_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Classification'), 'column' => 'id')),
      'sector_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Sector'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('classification_sector_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ClassificationSector';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'classification_id' => 'ForeignKey',
      'sector_id'         => 'ForeignKey',
    );
  }
}
