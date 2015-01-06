<?php

/**
 * Voucher form base class.
 *
 * @method Voucher getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseVoucherForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'user_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'company_offer_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CompanyOffer'), 'add_empty' => true)),
      'code'             => new sfWidgetFormInputText(),
      'status'           => new sfWidgetFormChoice(array('choices' => array('pending' => 'pending', 'used' => 'used', 'invalid' => 'invalid', 'expired' => 'expired'))),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'required' => false)),
      'company_offer_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CompanyOffer'), 'required' => false)),
      'code'             => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'status'           => new sfValidatorChoice(array('choices' => array(0 => 'pending', 1 => 'used', 2 => 'invalid', 3 => 'expired'), 'required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('voucher[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Voucher';
  }

}
