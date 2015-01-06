<?php

/**
 * invitedUser filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseinvitedUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'email'             => new sfWidgetFormFilterInput(),
      'facebook_uid'      => new sfWidgetFormFilterInput(),
      'hash'              => new sfWidgetFormFilterInput(),
      'invited_from'      => new sfWidgetFormChoice(array('choices' => array('' => '', 'email' => 'email', 'gmail_yahoo' => 'gmail_yahoo', 'facebook' => 'facebook'))),
      'points_to_invited' => new sfWidgetFormFilterInput(),
      'points_to_user'    => new sfWidgetFormFilterInput(),
      'user_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'email'             => new sfValidatorPass(array('required' => false)),
      'facebook_uid'      => new sfValidatorPass(array('required' => false)),
      'hash'              => new sfValidatorPass(array('required' => false)),
      'invited_from'      => new sfValidatorChoice(array('required' => false, 'choices' => array('email' => 'email', 'gmail_yahoo' => 'gmail_yahoo', 'facebook' => 'facebook'))),
      'points_to_invited' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'points_to_user'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserProfile'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('invited_user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'invitedUser';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'email'             => 'Text',
      'facebook_uid'      => 'Text',
      'hash'              => 'Text',
      'invited_from'      => 'Enum',
      'points_to_invited' => 'Number',
      'points_to_user'    => 'Number',
      'user_id'           => 'ForeignKey',
    );
  }
}
