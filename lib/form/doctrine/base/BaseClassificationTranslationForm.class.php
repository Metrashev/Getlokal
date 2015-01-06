<?php

/**
 * ClassificationTranslation form base class.
 *
 * @method ClassificationTranslation getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseClassificationTranslationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'title'            => new sfWidgetFormInputText(),
      'slug'             => new sfWidgetFormInputText(),
      'short_title'      => new sfWidgetFormInputText(),
      'is_active'        => new sfWidgetFormInputCheckbox(),
      'number_of_places' => new sfWidgetFormInputText(),
      'keywords'         => new sfWidgetFormTextarea(),
      'description'      => new sfWidgetFormTextarea(),
      'old_slug'         => new sfWidgetFormInputText(),
      'page_title'       => new sfWidgetFormInputText(),
      'meta_description' => new sfWidgetFormTextarea(),
      'lang'             => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'title'            => new sfValidatorString(array('max_length' => 255)),
      'slug'             => new sfValidatorString(array('max_length' => 255)),
      'short_title'      => new sfValidatorString(array('max_length' => 255)),
      'is_active'        => new sfValidatorBoolean(array('required' => false)),
      'number_of_places' => new sfValidatorInteger(array('required' => false)),
      'keywords'         => new sfValidatorString(array('required' => false)),
      'description'      => new sfValidatorString(array('required' => false)),
      'old_slug'         => new sfValidatorString(array('max_length' => 255)),
      'page_title'       => new sfValidatorPass(array('required' => false)),
      'meta_description' => new sfValidatorString(array('required' => false)),
      'lang'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('lang')), 'empty_value' => $this->getObject()->get('lang'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('classification_translation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ClassificationTranslation';
  }

}
