<?php

/**
 * StaticPageTranslation form base class.
 *
 * @method StaticPageTranslation getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseStaticPageTranslationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'title'     => new sfWidgetFormInputText(),
      'content'   => new sfWidgetFormTextarea(),
      'slug'      => new sfWidgetFormInputText(),
      'is_active' => new sfWidgetFormInputCheckbox(),
      'lang'      => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'title'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'content'   => new sfValidatorString(array('required' => false)),
      'slug'      => new sfValidatorString(array('max_length' => 255)),
      'is_active' => new sfValidatorBoolean(),
      'lang'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('lang')), 'empty_value' => $this->getObject()->get('lang'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('static_page_translation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StaticPageTranslation';
  }

}