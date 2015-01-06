<?php

/**
 * UserProfile filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUserProfileFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'birthdate'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'gender'       => new sfWidgetFormFilterInput(),
      'phone_number' => new sfWidgetFormFilterInput(),
      'karma'        => new sfWidgetFormFilterInput(),
      'hash'         => new sfWidgetFormFilterInput(),
      'facebook_uid' => new sfWidgetFormFilterInput(),
      'access_token' => new sfWidgetFormFilterInput(),
      'summary'      => new sfWidgetFormFilterInput(),
      'city_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'add_empty' => true)),
      'image_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Image'), 'add_empty' => true)),
      'blog_url'     => new sfWidgetFormFilterInput(),
      'facebook_url' => new sfWidgetFormFilterInput(),
      'twitter_url'  => new sfWidgetFormFilterInput(),
      'website'      => new sfWidgetFormFilterInput(),
      'google_url'   => new sfWidgetFormFilterInput(),
      'country_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => true)),
      'partner'      => new sfWidgetFormFilterInput(),
      'referer'      => new sfWidgetFormFilterInput(),
      'points'       => new sfWidgetFormFilterInput(),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'birthdate'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'gender'       => new sfValidatorPass(array('required' => false)),
      'phone_number' => new sfValidatorPass(array('required' => false)),
      'karma'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'hash'         => new sfValidatorPass(array('required' => false)),
      'facebook_uid' => new sfValidatorPass(array('required' => false)),
      'access_token' => new sfValidatorPass(array('required' => false)),
      'summary'      => new sfValidatorPass(array('required' => false)),
      'city_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('City'), 'column' => 'id')),
      'image_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Image'), 'column' => 'id')),
      'blog_url'     => new sfValidatorPass(array('required' => false)),
      'facebook_url' => new sfValidatorPass(array('required' => false)),
      'twitter_url'  => new sfValidatorPass(array('required' => false)),
      'website'      => new sfValidatorPass(array('required' => false)),
      'google_url'   => new sfValidatorPass(array('required' => false)),
      'country_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Country'), 'column' => 'id')),
      'partner'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'referer'      => new sfValidatorPass(array('required' => false)),
      'points'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('user_profile_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserProfile';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'birthdate'    => 'Date',
      'gender'       => 'Text',
      'phone_number' => 'Text',
      'karma'        => 'Number',
      'hash'         => 'Text',
      'facebook_uid' => 'Text',
      'access_token' => 'Text',
      'summary'      => 'Text',
      'city_id'      => 'ForeignKey',
      'image_id'     => 'ForeignKey',
      'blog_url'     => 'Text',
      'facebook_url' => 'Text',
      'twitter_url'  => 'Text',
      'website'      => 'Text',
      'google_url'   => 'Text',
      'country_id'   => 'ForeignKey',
      'partner'      => 'Number',
      'referer'      => 'Text',
      'points'       => 'Number',
      'created_at'   => 'Date',
      'updated_at'   => 'Date',
    );
  }
}
