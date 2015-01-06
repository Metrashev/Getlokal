<?php

/**
 * MobileLog filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMobileLogFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'device'     => new sfWidgetFormChoice(array('choices' => array('' => '', 'ios' => 'ios', 'android' => 'android'))),
      'version'    => new sfWidgetFormFilterInput(),
      'action'     => new sfWidgetFormChoice(array('choices' => array('' => '', 'login' => 'login', 'register' => 'register', 'company' => 'company', 'review' => 'review', 'upload' => 'upload', 'checkin' => 'checkin', 'follow' => 'follow', 'getvoucher' => 'getvoucher'))),
      'foreign_id' => new sfWidgetFormFilterInput(),
      'lat'        => new sfWidgetFormFilterInput(),
      'lng'        => new sfWidgetFormFilterInput(),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'user_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserProfile'), 'column' => 'id')),
      'device'     => new sfValidatorChoice(array('required' => false, 'choices' => array('ios' => 'ios', 'android' => 'android'))),
      'version'    => new sfValidatorPass(array('required' => false)),
      'action'     => new sfValidatorChoice(array('required' => false, 'choices' => array('login' => 'login', 'register' => 'register', 'company' => 'company', 'review' => 'review', 'upload' => 'upload', 'checkin' => 'checkin', 'follow' => 'follow', 'getvoucher' => 'getvoucher'))),
      'foreign_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lat'        => new sfValidatorPass(array('required' => false)),
      'lng'        => new sfValidatorPass(array('required' => false)),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('mobile_log_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MobileLog';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'user_id'    => 'ForeignKey',
      'device'     => 'Enum',
      'version'    => 'Text',
      'action'     => 'Enum',
      'foreign_id' => 'Number',
      'lat'        => 'Text',
      'lng'        => 'Text',
      'created_at' => 'Date',
      'updated_at' => 'Date',
    );
  }
}
