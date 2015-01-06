<?php

/**
 * CategoryArticle filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCategoryArticleFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'status'              => new sfWidgetFormChoice(array('choices' => array('' => '', 'approved' => 'approved', 'pending' => 'pending', 'rejected' => 'rejected'))),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'country_list'        => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Country')),
      'classification_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Classification')),
    ));

    $this->setValidators(array(
      'status'              => new sfValidatorChoice(array('required' => false, 'choices' => array('approved' => 'approved', 'pending' => 'pending', 'rejected' => 'rejected'))),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'country_list'        => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Country', 'required' => false)),
      'classification_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Classification', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('category_article_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addCountryListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('CategoryArticleCountry.country_id', $values)
    ;
  }

  public function addClassificationListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.CategoryArticleClassification CategoryArticleClassification')
      ->andWhereIn('CategoryArticleClassification.classification_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'CategoryArticle';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'status'              => 'Enum',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
      'country_list'        => 'ManyKey',
      'classification_list' => 'ManyKey',
    );
  }
}
