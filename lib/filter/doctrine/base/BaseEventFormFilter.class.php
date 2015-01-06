<?php

/**
 * Event filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseEventFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'start_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'end_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'start_h'          => new sfWidgetFormFilterInput(),
      'end_h'            => new sfWidgetFormFilterInput(),
      'category_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'add_empty' => true)),
      'image_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Image'), 'add_empty' => true)),
      'facebook_id'      => new sfWidgetFormFilterInput(),
      'info_url'         => new sfWidgetFormFilterInput(),
      'buy_url'          => new sfWidgetFormFilterInput(),
      'price'            => new sfWidgetFormFilterInput(),
      'location_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'add_empty' => true)),
      'country_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => true)),
      'user_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'is_active'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'recommend'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'recommended_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'get_weekend_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'getWeekend')),
    ));

    $this->setValidators(array(
      'start_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'end_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'start_h'          => new sfValidatorPass(array('required' => false)),
      'end_h'            => new sfValidatorPass(array('required' => false)),
      'category_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Category'), 'column' => 'id')),
      'image_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Image'), 'column' => 'id')),
      'facebook_id'      => new sfValidatorPass(array('required' => false)),
      'info_url'         => new sfValidatorPass(array('required' => false)),
      'buy_url'          => new sfValidatorPass(array('required' => false)),
      'price'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'location_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('City'), 'column' => 'id')),
      'country_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Country'), 'column' => 'id')),
      'user_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserProfile'), 'column' => 'id')),
      'is_active'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'recommend'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'recommended_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'get_weekend_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'getWeekend', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('event_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addGetWeekendListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('getWeekendEvent.parent_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Event';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'start_at'         => 'Date',
      'end_at'           => 'Date',
      'start_h'          => 'Text',
      'end_h'            => 'Text',
      'category_id'      => 'ForeignKey',
      'image_id'         => 'ForeignKey',
      'facebook_id'      => 'Text',
      'info_url'         => 'Text',
      'buy_url'          => 'Text',
      'price'            => 'Number',
      'location_id'      => 'ForeignKey',
      'country_id'       => 'ForeignKey',
      'user_id'          => 'ForeignKey',
      'is_active'        => 'Boolean',
      'recommend'        => 'Number',
      'recommended_at'   => 'Date',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
      'get_weekend_list' => 'ManyKey',
    );
  }
}
