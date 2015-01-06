<?php

/**
 * getWeekend filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasegetWeekendFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'          => new sfWidgetFormFilterInput(),
      'title_en'       => new sfWidgetFormFilterInput(),
      'body'           => new sfWidgetFormFilterInput(),
      'body_en'        => new sfWidgetFormFilterInput(),
      'embed'          => new sfWidgetFormFilterInput(),
      'aired_on'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'country_id'     => new sfWidgetFormFilterInput(),
      'is_active'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'filename'       => new sfWidgetFormFilterInput(),
      'companies_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Company')),
      'events_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Event')),
    ));

    $this->setValidators(array(
      'title'          => new sfValidatorPass(array('required' => false)),
      'title_en'       => new sfValidatorPass(array('required' => false)),
      'body'           => new sfValidatorPass(array('required' => false)),
      'body_en'        => new sfValidatorPass(array('required' => false)),
      'embed'          => new sfValidatorPass(array('required' => false)),
      'aired_on'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'country_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_active'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'filename'       => new sfValidatorPass(array('required' => false)),
      'companies_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Company', 'required' => false)),
      'events_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Event', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('get_weekend_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addCompaniesListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.getWeekendCompany getWeekendCompany')
      ->andWhereIn('getWeekendCompany.company_id', $values)
    ;
  }

  public function addEventsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.getWeekendEvent getWeekendEvent')
      ->andWhereIn('getWeekendEvent.event_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'getWeekend';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'title'          => 'Text',
      'title_en'       => 'Text',
      'body'           => 'Text',
      'body_en'        => 'Text',
      'embed'          => 'Text',
      'aired_on'       => 'Date',
      'country_id'     => 'Number',
      'is_active'      => 'Boolean',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
      'filename'       => 'Text',
      'companies_list' => 'ManyKey',
      'events_list'    => 'ManyKey',
    );
  }
}
