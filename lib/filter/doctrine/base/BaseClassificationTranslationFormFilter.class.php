<?php

/**
 * ClassificationTranslation filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseClassificationTranslationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slug'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'short_title'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_active'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'number_of_places' => new sfWidgetFormFilterInput(),
      'keywords'         => new sfWidgetFormFilterInput(),
      'description'      => new sfWidgetFormFilterInput(),
      'old_slug'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'page_title'       => new sfWidgetFormFilterInput(),
      'meta_description' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'title'            => new sfValidatorPass(array('required' => false)),
      'slug'             => new sfValidatorPass(array('required' => false)),
      'short_title'      => new sfValidatorPass(array('required' => false)),
      'is_active'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'number_of_places' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'keywords'         => new sfValidatorPass(array('required' => false)),
      'description'      => new sfValidatorPass(array('required' => false)),
      'old_slug'         => new sfValidatorPass(array('required' => false)),
      'page_title'       => new sfValidatorPass(array('required' => false)),
      'meta_description' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('classification_translation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ClassificationTranslation';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'title'            => 'Text',
      'slug'             => 'Text',
      'short_title'      => 'Text',
      'is_active'        => 'Boolean',
      'number_of_places' => 'Number',
      'keywords'         => 'Text',
      'description'      => 'Text',
      'old_slug'         => 'Text',
      'page_title'       => 'Text',
      'meta_description' => 'Text',
      'lang'             => 'Text',
    );
  }
}
