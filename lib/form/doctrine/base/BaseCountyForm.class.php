<?php

/**
 * County form base class.
 *
 * @method County getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCountyForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'municipality' => new sfWidgetFormInputText(),
      'region'       => new sfWidgetFormInputText(),
      'country_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => false)),
      'slug'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'municipality' => new sfValidatorString(array('max_length' => 60, 'required' => false)),
      'region'       => new sfValidatorString(array('max_length' => 60, 'required' => false)),
      'country_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'))),
      'slug'         => new sfValidatorString(array('max_length' => 255)),
    ));

    $this->widgetSchema->setNameFormat('county[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'County';
  }

}
