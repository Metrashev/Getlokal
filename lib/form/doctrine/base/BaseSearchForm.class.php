<?php

/**
 * Search form base class.
 *
 * @method Search getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSearchForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'title'      => new sfWidgetFormTextarea(),
      'body'       => new sfWidgetFormTextarea(),
      'keywords'   => new sfWidgetFormTextarea(),
      'object_id'  => new sfWidgetFormInputText(),
      'culture'    => new sfWidgetFormInputText(),
      'model_name' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'title'      => new sfValidatorString(array('required' => false)),
      'body'       => new sfValidatorString(array('required' => false)),
      'keywords'   => new sfValidatorString(array('required' => false)),
      'object_id'  => new sfValidatorInteger(array('required' => false)),
      'culture'    => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'model_name' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('search[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Search';
  }

}
