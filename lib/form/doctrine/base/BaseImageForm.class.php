<?php

/**
 * Image form base class.
 *
 * @method Image getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseImageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'user_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'caption'     => new sfWidgetFormInputText(),
      'status'      => new sfWidgetFormChoice(array('choices' => array('approved' => 'approved', 'rejected' => 'rejected', 'pending' => 'pending', 'mobile_upload' => 'mobile_upload'))),
      'priority'    => new sfWidgetFormInputText(),
      'country_id'  => new sfWidgetFormInputText(),
      'type'        => new sfWidgetFormInputText(),
      'link'        => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormInputText(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
      'filename'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'required' => false)),
      'caption'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'status'      => new sfValidatorChoice(array('choices' => array(0 => 'approved', 1 => 'rejected', 2 => 'pending', 3 => 'mobile_upload'), 'required' => false)),
      'priority'    => new sfValidatorInteger(array('required' => false)),
      'country_id'  => new sfValidatorInteger(array('required' => false)),
      'type'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'link'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
      'filename'    => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('image[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Image';
  }

}
