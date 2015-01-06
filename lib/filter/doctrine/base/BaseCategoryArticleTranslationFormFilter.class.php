<?php

/**
 * CategoryArticleTranslation filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCategoryArticleTranslationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_active' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'slug'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'title'     => new sfValidatorPass(array('required' => false)),
      'is_active' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'slug'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('category_article_translation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CategoryArticleTranslation';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'title'     => 'Text',
      'is_active' => 'Boolean',
      'slug'      => 'Text',
      'lang'      => 'Text',
    );
  }
}
