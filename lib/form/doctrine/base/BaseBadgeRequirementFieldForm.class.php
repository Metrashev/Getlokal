<?php

/**
 * BadgeRequirementField form base class.
 *
 * @method BadgeRequirementField getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseBadgeRequirementFieldForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'requirement_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('BadgeRequirement'), 'add_empty' => true)),
      'key'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserStat'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'requirement_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('BadgeRequirement'), 'required' => false)),
      'key'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserStat'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('badge_requirement_field[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'BadgeRequirementField';
  }

}
