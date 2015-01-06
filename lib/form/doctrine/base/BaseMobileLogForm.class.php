<?php

/**
 * MobileLog form base class.
 *
 * @method MobileLog getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMobileLogForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'user_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'device'     => new sfWidgetFormChoice(array('choices' => array('ios' => 'ios', 'android' => 'android'))),
      'version'    => new sfWidgetFormInputText(),
      'action'     => new sfWidgetFormChoice(array('choices' => array('login' => 'login', 'register' => 'register', 'company' => 'company', 'review' => 'review', 'upload' => 'upload', 'checkin' => 'checkin', 'follow' => 'follow'))),
      'foreign_id' => new sfWidgetFormInputText(),
      'lat'        => new sfWidgetFormInputText(),
      'lng'        => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'required' => false)),
      'device'     => new sfValidatorChoice(array('choices' => array(0 => 'ios', 1 => 'android'), 'required' => false)),
      'version'    => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'action'     => new sfValidatorChoice(array('choices' => array(0 => 'login', 1 => 'register', 2 => 'company', 3 => 'review', 4 => 'upload', 5 => 'checkin', 6 => 'follow'), 'required' => false)),
      'foreign_id' => new sfValidatorInteger(array('required' => false)),
      'lat'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'lng'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('mobile_log[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MobileLog';
  }

}
