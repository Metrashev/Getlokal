<?php

/**
 * Conversation form base class.
 *
 * @method Conversation getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseConversationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'page_from'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FromPage'), 'add_empty' => true)),
      'page_to'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ToPage'), 'add_empty' => true)),
      'opened'          => new sfWidgetFormInputCheckbox(),
      'last_message_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Message'), 'add_empty' => true)),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'page_from'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FromPage'), 'required' => false)),
      'page_to'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ToPage'), 'required' => false)),
      'opened'          => new sfValidatorBoolean(array('required' => false)),
      'last_message_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Message'), 'required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('conversation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Conversation';
  }

}
