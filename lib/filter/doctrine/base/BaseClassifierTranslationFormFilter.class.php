<?php

/**
 * ClassifierTranslation filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseClassifierTranslationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slug'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'short_title'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_visible'       => new sfWidgetFormFilterInput(),
      'number_of_places' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'title'            => new sfValidatorPass(array('required' => false)),
      'slug'             => new sfValidatorPass(array('required' => false)),
      'short_title'      => new sfValidatorPass(array('required' => false)),
      'is_visible'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'number_of_places' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('classifier_translation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ClassifierTranslation';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'title'            => 'Text',
      'slug'             => 'Text',
      'short_title'      => 'Text',
      'is_visible'       => 'Number',
      'number_of_places' => 'Number',
      'lang'             => 'Text',
    );
  }
}
