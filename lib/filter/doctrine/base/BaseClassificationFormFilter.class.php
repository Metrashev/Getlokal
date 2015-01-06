<?php

/**
 * Classification filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseClassificationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'external_id'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'category_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'add_empty' => true)),
      'sector_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PrimarySector'), 'add_empty' => true)),
      'status'                => new sfWidgetFormChoice(array('choices' => array('' => '', 'pending' => 'pending', 'approved' => 'approved', 'rejected' => 'rejected'))),
      'crm_id'                => new sfWidgetFormFilterInput(),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'category_article_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'CategoryArticle')),
    ));

    $this->setValidators(array(
      'external_id'           => new sfValidatorPass(array('required' => false)),
      'category_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Category'), 'column' => 'id')),
      'sector_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('PrimarySector'), 'column' => 'id')),
      'status'                => new sfValidatorChoice(array('required' => false, 'choices' => array('pending' => 'pending', 'approved' => 'approved', 'rejected' => 'rejected'))),
      'crm_id'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'category_article_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'CategoryArticle', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('classification_filters[%s]');

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
      ->leftJoin($query->getRootAlias().'.CategoryArticleClassification CategoryArticleClassification')
      ->andWhereIn('CategoryArticleClassification.category_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Classification';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'external_id'           => 'Text',
      'category_id'           => 'ForeignKey',
      'sector_id'             => 'ForeignKey',
      'status'                => 'Enum',
      'crm_id'                => 'Number',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
      'category_article_list' => 'ManyKey',
    );
  }
}
