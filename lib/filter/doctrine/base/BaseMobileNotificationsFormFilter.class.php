<?php

/**
 * MobileNotifications filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMobileNotificationsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'message_text'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'device_os'        => new sfWidgetFormFilterInput(),
      'app_version'      => new sfWidgetFormFilterInput(),
      'country_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => true)),
      'city_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'add_empty' => true)),
      'country_gps'      => new sfWidgetFormFilterInput(),
      'locale'           => new sfWidgetFormFilterInput(),
      'count_ios'        => new sfWidgetFormFilterInput(),
      'succeded_ios'     => new sfWidgetFormFilterInput(),
      'failed_ios'       => new sfWidgetFormFilterInput(),
      'deleted_ios'      => new sfWidgetFormFilterInput(),
      'count_android'    => new sfWidgetFormFilterInput(),
      'succeded_android' => new sfWidgetFormFilterInput(),
      'failed_android'   => new sfWidgetFormFilterInput(),
      'deleted_android'  => new sfWidgetFormFilterInput(),
      'send_from'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'message_text'     => new sfValidatorPass(array('required' => false)),
      'device_os'        => new sfValidatorPass(array('required' => false)),
      'app_version'      => new sfValidatorPass(array('required' => false)),
      'country_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Country'), 'column' => 'id')),
      'city_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('City'), 'column' => 'id')),
      'country_gps'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'locale'           => new sfValidatorPass(array('required' => false)),
      'count_ios'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'succeded_ios'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'failed_ios'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'deleted_ios'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'count_android'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'succeded_android' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'failed_android'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'deleted_android'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'send_from'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserProfile'), 'column' => 'id')),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('mobile_notifications_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MobileNotifications';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'message_text'     => 'Text',
      'device_os'        => 'Text',
      'app_version'      => 'Text',
      'country_id'       => 'ForeignKey',
      'city_id'          => 'ForeignKey',
      'country_gps'      => 'Number',
      'locale'           => 'Text',
      'count_ios'        => 'Number',
      'succeded_ios'     => 'Number',
      'failed_ios'       => 'Number',
      'deleted_ios'      => 'Number',
      'count_android'    => 'Number',
      'succeded_android' => 'Number',
      'failed_android'   => 'Number',
      'deleted_android'  => 'Number',
      'send_from'        => 'ForeignKey',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
    );
  }
}
