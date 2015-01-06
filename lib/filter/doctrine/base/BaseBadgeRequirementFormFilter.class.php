<?php

/**
 * BadgeRequirement filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseBadgeRequirementFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'value'    => new sfWidgetFormFilterInput(),
      'badge_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Badge'), 'add_empty' => true)),
      'group_no' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'value'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'badge_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Badge'), 'column' => 'id')),
      'group_no' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('badge_requirement_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'BadgeRequirement';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'value'    => 'Number',
      'badge_id' => 'ForeignKey',
      'group_no' => 'Number',
    );
  }
}
