<?php

/**
 * PageAdmin filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePageAdminFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'page_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CompanyPage'), 'add_empty' => true)),
      'status'     => new sfWidgetFormChoice(array('choices' => array('' => '', 'approved' => 'approved', 'pending' => 'pending', 'rejected' => 'rejected'))),
      'position'   => new sfWidgetFormFilterInput(),
      'is_primary' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'username'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'algorithm'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'salt'       => new sfWidgetFormFilterInput(),
      'password'   => new sfWidgetFormFilterInput(),
      'last_login' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'user_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserProfile'), 'column' => 'id')),
      'page_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CompanyPage'), 'column' => 'id')),
      'status'     => new sfValidatorChoice(array('required' => false, 'choices' => array('approved' => 'approved', 'pending' => 'pending', 'rejected' => 'rejected'))),
      'position'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_primary' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'username'   => new sfValidatorPass(array('required' => false)),
      'algorithm'  => new sfValidatorPass(array('required' => false)),
      'salt'       => new sfValidatorPass(array('required' => false)),
      'password'   => new sfValidatorPass(array('required' => false)),
      'last_login' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('page_admin_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PageAdmin';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'user_id'    => 'ForeignKey',
      'page_id'    => 'ForeignKey',
      'status'     => 'Enum',
      'position'   => 'Number',
      'is_primary' => 'Boolean',
      'username'   => 'Text',
      'algorithm'  => 'Text',
      'salt'       => 'Text',
      'password'   => 'Text',
      'last_login' => 'Date',
      'created_at' => 'Date',
      'updated_at' => 'Date',
    );
  }
}
