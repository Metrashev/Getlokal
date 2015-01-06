<?php

/**
 * UnregisteredNewsletterUser filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUnregisteredNewsletterUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'firstname'     => new sfWidgetFormFilterInput(),
      'lastname'      => new sfWidgetFormFilterInput(),
      'email_address' => new sfWidgetFormFilterInput(),
      'country_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'firstname'     => new sfValidatorPass(array('required' => false)),
      'lastname'      => new sfValidatorPass(array('required' => false)),
      'email_address' => new sfValidatorPass(array('required' => false)),
      'country_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Country'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('unregistered_newsletter_user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UnregisteredNewsletterUser';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'firstname'     => 'Text',
      'lastname'      => 'Text',
      'email_address' => 'Text',
      'country_id'    => 'ForeignKey',
    );
  }
}
