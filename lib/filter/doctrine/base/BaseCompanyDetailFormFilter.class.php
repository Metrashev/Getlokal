<?php

/**
 * CompanyDetail filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCompanyDetailFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'company_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => true)),
      'mon_from'         => new sfWidgetFormFilterInput(),
      'mon_to'           => new sfWidgetFormFilterInput(),
      'tue_from'         => new sfWidgetFormFilterInput(),
      'tue_to'           => new sfWidgetFormFilterInput(),
      'wed_from'         => new sfWidgetFormFilterInput(),
      'wed_to'           => new sfWidgetFormFilterInput(),
      'thu_from'         => new sfWidgetFormFilterInput(),
      'thu_to'           => new sfWidgetFormFilterInput(),
      'fri_from'         => new sfWidgetFormFilterInput(),
      'fri_to'           => new sfWidgetFormFilterInput(),
      'sat_from'         => new sfWidgetFormFilterInput(),
      'sat_to'           => new sfWidgetFormFilterInput(),
      'sun_from'         => new sfWidgetFormFilterInput(),
      'sun_to'           => new sfWidgetFormFilterInput(),
      'content'          => new sfWidgetFormFilterInput(),
      'content_en'       => new sfWidgetFormFilterInput(),
      'confirmed'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'last_modified_by' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'outdoor_seats'    => new sfWidgetFormFilterInput(),
      'indoor_seats'     => new sfWidgetFormFilterInput(),
      'wifi_access'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'company_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Company'), 'column' => 'id')),
      'mon_from'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mon_to'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tue_from'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tue_to'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'wed_from'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'wed_to'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'thu_from'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'thu_to'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fri_from'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fri_to'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sat_from'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sat_to'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sun_from'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sun_to'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'content'          => new sfValidatorPass(array('required' => false)),
      'content_en'       => new sfValidatorPass(array('required' => false)),
      'confirmed'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'last_modified_by' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserProfile'), 'column' => 'id')),
      'outdoor_seats'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'indoor_seats'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'wifi_access'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('company_detail_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompanyDetail';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'company_id'       => 'ForeignKey',
      'mon_from'         => 'Number',
      'mon_to'           => 'Number',
      'tue_from'         => 'Number',
      'tue_to'           => 'Number',
      'wed_from'         => 'Number',
      'wed_to'           => 'Number',
      'thu_from'         => 'Number',
      'thu_to'           => 'Number',
      'fri_from'         => 'Number',
      'fri_to'           => 'Number',
      'sat_from'         => 'Number',
      'sat_to'           => 'Number',
      'sun_from'         => 'Number',
      'sun_to'           => 'Number',
      'content'          => 'Text',
      'content_en'       => 'Text',
      'confirmed'        => 'Boolean',
      'last_modified_by' => 'ForeignKey',
      'outdoor_seats'    => 'Number',
      'indoor_seats'     => 'Number',
      'wifi_access'      => 'Boolean',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
    );
  }
}
