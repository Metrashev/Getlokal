<?php

/**
 * invitedUser form base class.
 *
 * @method invitedUser getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseinvitedUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'email'             => new sfWidgetFormInputText(),
      'facebook_uid'      => new sfWidgetFormInputText(),
      'hash'              => new sfWidgetFormInputText(),
      'invited_from'      => new sfWidgetFormChoice(array('choices' => array('email' => 'email', 'gmail_yahoo' => 'gmail_yahoo', 'facebook' => 'facebook'))),
      'points_to_invited' => new sfWidgetFormInputText(),
      'points_to_user'    => new sfWidgetFormInputText(),
      'user_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'email'             => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'facebook_uid'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'hash'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'invited_from'      => new sfValidatorChoice(array('choices' => array(0 => 'email', 1 => 'gmail_yahoo', 2 => 'facebook'), 'required' => false)),
      'points_to_invited' => new sfValidatorInteger(array('required' => false)),
      'points_to_user'    => new sfValidatorInteger(array('required' => false)),
      'user_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('invited_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'invitedUser';
  }

}
