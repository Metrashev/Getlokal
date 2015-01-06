<?php

/**
 * Setting form base class.
 *
 * @method Setting getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSettingForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'  => new sfWidgetFormInputHidden(),
      'k'   => new sfWidgetFormInputText(),
      'val' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'k'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'val' => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('setting[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Setting';
  }

}
