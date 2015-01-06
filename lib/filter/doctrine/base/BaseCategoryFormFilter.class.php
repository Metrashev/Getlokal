<?php

/**
 * Category filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCategoryFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'status'              => new sfWidgetFormChoice(array('choices' => array('' => '', 'approved' => 'approved', 'pending' => 'pending', 'rejected' => 'rejected'))),
      'model_name'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'root_id'             => new sfWidgetFormFilterInput(),
      'lft'                 => new sfWidgetFormFilterInput(),
      'rgt'                 => new sfWidgetFormFilterInput(),
      'level'               => new sfWidgetFormFilterInput(),
      'classification_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Classification')),
    ));

    $this->setValidators(array(
      'status'              => new sfValidatorChoice(array('required' => false, 'choices' => array('approved' => 'approved', 'pending' => 'pending', 'rejected' => 'rejected'))),
      'model_name'          => new sfValidatorPass(array('required' => false)),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'root_id'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lft'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rgt'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'level'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'classification_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Classification', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('category_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
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
      ->leftJoin($query->getRootAlias().'.CategoryClassification CategoryClassification')
      ->andWhereIn('CategoryClassification.classification_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Category';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'status'              => 'Enum',
      'model_name'          => 'Text',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
      'root_id'             => 'Number',
      'lft'                 => 'Number',
      'rgt'                 => 'Number',
      'level'               => 'Number',
      'classification_list' => 'ManyKey',
    );
  }
}
