<?php

/**
 * Lists form base class.
 *
 * @method Lists getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseListsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'user_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'list_type'  => new sfWidgetFormChoice(array('choices' => array('opened' => 'opened', 'closed' => 'closed'))),
      'is_active'  => new sfWidgetFormInputCheckbox(),
      'is_open'    => new sfWidgetFormInputCheckbox(),
      'status'     => new sfWidgetFormChoice(array('choices' => array('approved' => 'approved', 'pending' => 'pending', 'rejected' => 'rejected'))),
      'country_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => true)),
      'image_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Image'), 'add_empty' => true)),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'required' => false)),
      'list_type'  => new sfValidatorChoice(array('choices' => array(0 => 'opened', 1 => 'closed'), 'required' => false)),
      'is_active'  => new sfValidatorBoolean(array('required' => false)),
      'is_open'    => new sfValidatorBoolean(array('required' => false)),
      'status'     => new sfValidatorChoice(array('choices' => array(0 => 'approved', 1 => 'pending', 2 => 'rejected'), 'required' => false)),
      'country_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'required' => false)),
      'image_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Image'), 'required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('lists[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Lists';
  }

}
