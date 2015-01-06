<?php

/**
 * BadgeRequirementField filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseBadgeRequirementFieldFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'requirement_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('BadgeRequirement'), 'add_empty' => true)),
      'key'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserStat'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'requirement_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('BadgeRequirement'), 'column' => 'id')),
      'key'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserStat'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('badge_requirement_field_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'BadgeRequirementField';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'requirement_id' => 'ForeignKey',
      'key'            => 'ForeignKey',
    );
  }
}
