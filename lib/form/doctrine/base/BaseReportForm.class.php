<?php

/**
 * Report form base class.
 *
 * @method Report getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseReportForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'user_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'email'      => new sfWidgetFormInputText(),
      'name'       => new sfWidgetFormInputText(),
      'body'       => new sfWidgetFormTextarea(),
      'offence'    => new sfWidgetFormInputText(),
      'status'     => new sfWidgetFormChoice(array('choices' => array('approved' => 'approved', 'pending' => 'pending', 'rejected' => 'rejected'))),
      'object_id'  => new sfWidgetFormInputText(),
      'type'       => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'required' => false)),
      'email'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'name'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'body'       => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'offence'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'status'     => new sfValidatorChoice(array('choices' => array(0 => 'approved', 1 => 'pending', 2 => 'rejected'), 'required' => false)),
      'object_id'  => new sfValidatorInteger(array('required' => false)),
      'type'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('report[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Report';
  }

}
