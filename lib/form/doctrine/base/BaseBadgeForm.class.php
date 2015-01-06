<?php

/**
 * Badge form base class.
 *
 * @method Badge getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseBadgeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'start_at'           => new sfWidgetFormDateTime(),
      'end_at'             => new sfWidgetFormDateTime(),
      'requirements'       => new sfWidgetFormInputText(),
      'points'             => new sfWidgetFormInputText(),
      'percent'            => new sfWidgetFormInputText(),
      'is_active'          => new sfWidgetFormInputCheckbox(),
      'is_seasonal'        => new sfWidgetFormInputCheckbox(),
      'is_visible'         => new sfWidgetFormInputCheckbox(),
      'notify_by_email'    => new sfWidgetFormInputCheckbox(),
      'display_message'    => new sfWidgetFormInputCheckbox(),
      'small_active_image' => new sfWidgetFormInputText(),
      'active_image'       => new sfWidgetFormInputText(),
      'inactive_image'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'start_at'           => new sfValidatorDateTime(array('required' => false)),
      'end_at'             => new sfValidatorDateTime(array('required' => false)),
      'requirements'       => new sfValidatorInteger(array('required' => false)),
      'points'             => new sfValidatorInteger(array('required' => false)),
      'percent'            => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'is_active'          => new sfValidatorBoolean(array('required' => false)),
      'is_seasonal'        => new sfValidatorBoolean(array('required' => false)),
      'is_visible'         => new sfValidatorBoolean(array('required' => false)),
      'notify_by_email'    => new sfValidatorBoolean(array('required' => false)),
      'display_message'    => new sfValidatorBoolean(array('required' => false)),
      'small_active_image' => new sfValidatorPass(array('required' => false)),
      'active_image'       => new sfValidatorPass(array('required' => false)),
      'inactive_image'     => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('badge[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Badge';
  }

}
