<?php

/**
 * County filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCountyFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'municipality' => new sfWidgetFormFilterInput(),
      'region'       => new sfWidgetFormFilterInput(),
      'country_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => true)),
      'slug'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'municipality' => new sfValidatorPass(array('required' => false)),
      'region'       => new sfValidatorPass(array('required' => false)),
      'country_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Country'), 'column' => 'id')),
      'slug'         => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('county_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'County';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'municipality' => 'Text',
      'region'       => 'Text',
      'country_id'   => 'ForeignKey',
      'slug'         => 'Text',
    );
  }
}
