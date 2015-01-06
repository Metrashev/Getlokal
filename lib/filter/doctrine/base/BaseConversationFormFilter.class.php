<?php

/**
 * Conversation filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseConversationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'page_from'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FromPage'), 'add_empty' => true)),
      'page_to'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ToPage'), 'add_empty' => true)),
      'opened'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'last_message_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Message'), 'add_empty' => true)),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'page_from'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('FromPage'), 'column' => 'id')),
      'page_to'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ToPage'), 'column' => 'id')),
      'opened'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'last_message_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Message'), 'column' => 'id')),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('conversation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Conversation';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'page_from'       => 'ForeignKey',
      'page_to'         => 'ForeignKey',
      'opened'          => 'Boolean',
      'last_message_id' => 'ForeignKey',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
    );
  }
}
