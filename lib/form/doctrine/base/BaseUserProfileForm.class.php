<?php

/**
 * UserProfile form base class.
 *
 * @method UserProfile getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserProfileForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'birthdate'    => new sfWidgetFormDate(),
      'gender'       => new sfWidgetFormInputText(),
      'phone_number' => new sfWidgetFormInputText(),
      'karma'        => new sfWidgetFormInputText(),
      'hash'         => new sfWidgetFormInputText(),
      'facebook_uid' => new sfWidgetFormInputText(),
      'access_token' => new sfWidgetFormInputText(),
      'summary'      => new sfWidgetFormTextarea(),
      'city_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'add_empty' => true)),
      'image_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Image'), 'add_empty' => true)),
      'blog_url'     => new sfWidgetFormInputText(),
      'facebook_url' => new sfWidgetFormInputText(),
      'twitter_url'  => new sfWidgetFormInputText(),
      'website'      => new sfWidgetFormInputText(),
      'google_url'   => new sfWidgetFormInputText(),
      'country_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => true)),
      'partner'      => new sfWidgetFormInputText(),
      'referer'      => new sfWidgetFormInputText(),
      'points'       => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'birthdate'    => new sfValidatorDate(array('required' => false)),
      'gender'       => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'phone_number' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'karma'        => new sfValidatorInteger(array('required' => false)),
      'hash'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'facebook_uid' => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'access_token' => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'summary'      => new sfValidatorString(array('required' => false)),
      'city_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'required' => false)),
      'image_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Image'), 'required' => false)),
      'blog_url'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'facebook_url' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'twitter_url'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'website'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'google_url'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'country_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'required' => false)),
      'partner'      => new sfValidatorInteger(array('required' => false)),
      'referer'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'points'       => new sfValidatorInteger(array('required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('user_profile[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserProfile';
  }

}
