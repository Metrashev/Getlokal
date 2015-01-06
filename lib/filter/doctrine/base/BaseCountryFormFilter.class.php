<?php

/**
 * Country filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCountryFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'name_en'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slug'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'currency'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'category_article_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'CategoryArticle')),
    ));

    $this->setValidators(array(
      'name'                  => new sfValidatorPass(array('required' => false)),
      'name_en'               => new sfValidatorPass(array('required' => false)),
      'slug'                  => new sfValidatorPass(array('required' => false)),
      'currency'              => new sfValidatorPass(array('required' => false)),
      'category_article_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'CategoryArticle', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('country_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addCategoryArticleListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.CategoryArticleCountry CategoryArticleCountry')
      ->andWhereIn('CategoryArticleCountry.category_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Country';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'name'                  => 'Text',
      'name_en'               => 'Text',
      'slug'                  => 'Text',
      'currency'              => 'Text',
      'category_article_list' => 'ManyKey',
    );
  }
}
