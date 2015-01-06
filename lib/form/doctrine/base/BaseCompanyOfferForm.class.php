<?php

/**
 * CompanyOffer form base class.
 *
 * @method CompanyOffer getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCompanyOfferForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'company_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => true)),
      'is_active'             => new sfWidgetFormInputCheckbox(),
      'is_draft'              => new sfWidgetFormInputCheckbox(),
      'active_from'           => new sfWidgetFormDateTime(),
      'active_to'             => new sfWidgetFormDateTime(),
      'valid_from'            => new sfWidgetFormDateTime(),
      'valid_to'              => new sfWidgetFormDateTime(),
      'max_vouchers'          => new sfWidgetFormInputText(),
      'max_per_user'          => new sfWidgetFormInputText(),
      'show_to_all'           => new sfWidgetFormInputCheckbox(),
      'image_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Image'), 'add_empty' => true)),
      'code'                  => new sfWidgetFormInputText(),
      'count_voucher_codes'   => new sfWidgetFormInputText(),
      'country_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => true)),
      'created_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'updated_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UpdatedByUser'), 'add_empty' => true)),
      'ad_service_company_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AdServiceCompany'), 'add_empty' => true)),
      'benefit_choice'        => new sfWidgetFormInputText(),
      'new_price'             => new sfWidgetFormInputText(),
      'old_price'             => new sfWidgetFormInputText(),
      'discount_pct'          => new sfWidgetFormInputText(),
      'benefit_text'          => new sfWidgetFormInputText(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'company_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'required' => false)),
      'is_active'             => new sfValidatorBoolean(array('required' => false)),
      'is_draft'              => new sfValidatorBoolean(array('required' => false)),
      'active_from'           => new sfValidatorDateTime(array('required' => false)),
      'active_to'             => new sfValidatorDateTime(array('required' => false)),
      'valid_from'            => new sfValidatorDateTime(array('required' => false)),
      'valid_to'              => new sfValidatorDateTime(array('required' => false)),
      'max_vouchers'          => new sfValidatorInteger(array('required' => false)),
      'max_per_user'          => new sfValidatorInteger(array('required' => false)),
      'show_to_all'           => new sfValidatorBoolean(array('required' => false)),
      'image_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Image'), 'required' => false)),
      'code'                  => new sfValidatorString(array('max_length' => 36)),
      'count_voucher_codes'   => new sfValidatorInteger(array('required' => false)),
      'country_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'required' => false)),
      'created_by'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'required' => false)),
      'updated_by'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UpdatedByUser'), 'required' => false)),
      'ad_service_company_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AdServiceCompany'), 'required' => false)),
      'benefit_choice'        => new sfValidatorInteger(array('required' => false)),
      'new_price'             => new sfValidatorNumber(array('required' => false)),
      'old_price'             => new sfValidatorNumber(array('required' => false)),
      'discount_pct'          => new sfValidatorInteger(array('required' => false)),
      'benefit_text'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('company_offer[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompanyOffer';
  }

}
