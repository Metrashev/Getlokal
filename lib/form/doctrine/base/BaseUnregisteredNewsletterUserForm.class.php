<?php

/**
 * UnregisteredNewsletterUser form base class.
 *
 * @method UnregisteredNewsletterUser getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUnregisteredNewsletterUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'firstname'     => new sfWidgetFormInputText(),
      'lastname'      => new sfWidgetFormInputText(),
      'email_address' => new sfWidgetFormInputText(),
      'country_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'firstname'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'lastname'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email_address' => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'country_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('unregistered_newsletter_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UnregisteredNewsletterUser';
  }

}
