<?php

/**
 * MobileDevice filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMobileDeviceFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'device_os'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'app_version'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'device_uid'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'device_token' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_active'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'count_failed' => new sfWidgetFormFilterInput(),
      'user_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'country_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => true)),
      'city_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'add_empty' => true)),
      'country_gps'  => new sfWidgetFormFilterInput(),
      'locale'       => new sfWidgetFormFilterInput(),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'device_os'    => new sfValidatorPass(array('required' => false)),
      'app_version'  => new sfValidatorPass(array('required' => false)),
      'device_uid'   => new sfValidatorPass(array('required' => false)),
      'device_token' => new sfValidatorPass(array('required' => false)),
      'is_active'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'count_failed' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserProfile'), 'column' => 'id')),
      'country_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Country'), 'column' => 'id')),
      'city_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('City'), 'column' => 'id')),
      'country_gps'  => new sfValidatorPass(array('required' => false)),
      'locale'       => new sfValidatorPass(array('required' => false)),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('mobile_device_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MobileDevice';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'device_os'    => 'Text',
      'app_version'  => 'Text',
      'device_uid'   => 'Text',
      'device_token' => 'Text',
      'is_active'    => 'Boolean',
      'count_failed' => 'Number',
      'user_id'      => 'ForeignKey',
      'country_id'   => 'ForeignKey',
      'city_id'      => 'ForeignKey',
      'country_gps'  => 'Text',
      'locale'       => 'Text',
      'created_at'   => 'Date',
      'updated_at'   => 'Date',
    );
  }
}
