<?php

/**
 * MobileNotifications form base class.
 *
 * @method MobileNotifications getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMobileNotificationsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'message_text'     => new sfWidgetFormInputText(),
      'device_os'        => new sfWidgetFormInputText(),
      'app_version'      => new sfWidgetFormInputText(),
      'country_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => true)),
      'city_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'add_empty' => true)),
      'country_gps'      => new sfWidgetFormInputText(),
      'locale'           => new sfWidgetFormInputText(),
      'count_ios'        => new sfWidgetFormInputText(),
      'succeded_ios'     => new sfWidgetFormInputText(),
      'failed_ios'       => new sfWidgetFormInputText(),
      'deleted_ios'      => new sfWidgetFormInputText(),
      'count_android'    => new sfWidgetFormInputText(),
      'succeded_android' => new sfWidgetFormInputText(),
      'failed_android'   => new sfWidgetFormInputText(),
      'deleted_android'  => new sfWidgetFormInputText(),
      'send_from'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'message_text'     => new sfValidatorString(array('max_length' => 255)),
      'device_os'        => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'app_version'      => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'country_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'required' => false)),
      'city_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'required' => false)),
      'country_gps'      => new sfValidatorInteger(array('required' => false)),
      'locale'           => new sfValidatorPass(array('required' => false)),
      'count_ios'        => new sfValidatorInteger(array('required' => false)),
      'succeded_ios'     => new sfValidatorInteger(array('required' => false)),
      'failed_ios'       => new sfValidatorInteger(array('required' => false)),
      'deleted_ios'      => new sfValidatorInteger(array('required' => false)),
      'count_android'    => new sfValidatorInteger(array('required' => false)),
      'succeded_android' => new sfValidatorInteger(array('required' => false)),
      'failed_android'   => new sfValidatorInteger(array('required' => false)),
      'deleted_android'  => new sfValidatorInteger(array('required' => false)),
      'send_from'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('mobile_notifications[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MobileNotifications';
  }

}