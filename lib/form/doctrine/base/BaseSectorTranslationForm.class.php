<?php

/**
 * SectorTranslation form base class.
 *
 * @method SectorTranslation getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSectorTranslationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'rank'             => new sfWidgetFormInputText(),
      'title'            => new sfWidgetFormInputText(),
      'slug'             => new sfWidgetFormInputText(),
      'description'      => new sfWidgetFormTextarea(),
      'page_title'       => new sfWidgetFormInputText(),
      'meta_description' => new sfWidgetFormTextarea(),
      'lang'             => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'rank'             => new sfValidatorInteger(array('required' => false)),
      'title'            => new sfValidatorString(array('max_length' => 255)),
      'slug'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'      => new sfValidatorString(array('required' => false)),
      'page_title'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'meta_description' => new sfValidatorString(array('required' => false)),
      'lang'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('lang')), 'empty_value' => $this->getObject()->get('lang'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sector_translation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SectorTranslation';
  }

}
