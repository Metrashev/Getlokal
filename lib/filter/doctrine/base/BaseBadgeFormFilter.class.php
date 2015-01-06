<?php

/**
 * Badge filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseBadgeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'start_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'end_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'requirements'       => new sfWidgetFormFilterInput(),
      'points'             => new sfWidgetFormFilterInput(),
      'percent'            => new sfWidgetFormFilterInput(),
      'is_active'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_seasonal'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_visible'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'notify_by_email'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'display_message'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'small_active_image' => new sfWidgetFormFilterInput(),
      'active_image'       => new sfWidgetFormFilterInput(),
      'inactive_image'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'start_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'end_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'requirements'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'points'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'percent'            => new sfValidatorPass(array('required' => false)),
      'is_active'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_seasonal'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_visible'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'notify_by_email'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'display_message'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'small_active_image' => new sfValidatorPass(array('required' => false)),
      'active_image'       => new sfValidatorPass(array('required' => false)),
      'inactive_image'     => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('badge_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Badge';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'start_at'           => 'Date',
      'end_at'             => 'Date',
      'requirements'       => 'Number',
      'points'             => 'Number',
      'percent'            => 'Text',
      'is_active'          => 'Boolean',
      'is_seasonal'        => 'Boolean',
      'is_visible'         => 'Boolean',
      'notify_by_email'    => 'Boolean',
      'display_message'    => 'Boolean',
      'small_active_image' => 'Text',
      'active_image'       => 'Text',
      'inactive_image'     => 'Text',
    );
  }
}
