<?php

/**
 * BadgeRequirement form base class.
 *
 * @method BadgeRequirement getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseBadgeRequirementForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'value'    => new sfWidgetFormInputText(),
      'badge_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Badge'), 'add_empty' => true)),
      'group_no' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'value'    => new sfValidatorInteger(array('required' => false)),
      'badge_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Badge'), 'required' => false)),
      'group_no' => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('badge_requirement[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'BadgeRequirement';
  }

}
