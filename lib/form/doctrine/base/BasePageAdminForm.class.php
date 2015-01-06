<?php

/**
 * PageAdmin form base class.
 *
 * @method PageAdmin getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePageAdminForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'user_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'page_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CompanyPage'), 'add_empty' => true)),
      'status'     => new sfWidgetFormChoice(array('choices' => array('approved' => 'approved', 'pending' => 'pending', 'rejected' => 'rejected'))),
      'position'   => new sfWidgetFormInputText(),
      'is_primary' => new sfWidgetFormInputCheckbox(),
      'username'   => new sfWidgetFormInputText(),
      'algorithm'  => new sfWidgetFormInputText(),
      'salt'       => new sfWidgetFormInputText(),
      'password'   => new sfWidgetFormInputText(),
      'last_login' => new sfWidgetFormDateTime(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'required' => false)),
      'page_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CompanyPage'), 'required' => false)),
      'status'     => new sfValidatorChoice(array('choices' => array(0 => 'approved', 1 => 'pending', 2 => 'rejected'), 'required' => false)),
      'position'   => new sfValidatorInteger(array('required' => false)),
      'is_primary' => new sfValidatorBoolean(array('required' => false)),
      'username'   => new sfValidatorString(array('max_length' => 128)),
      'algorithm'  => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'salt'       => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'password'   => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'last_login' => new sfValidatorDateTime(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'PageAdmin', 'column' => array('username')))
    );

    $this->widgetSchema->setNameFormat('page_admin[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PageAdmin';
  }

}
