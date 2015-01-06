<?php

/**
 * CompanyOffer filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCompanyOfferFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'company_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => true)),
      'is_active'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_draft'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'active_from'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'active_to'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'valid_from'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'valid_to'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'max_vouchers'          => new sfWidgetFormFilterInput(),
      'max_per_user'          => new sfWidgetFormFilterInput(),
      'show_to_all'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'image_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Image'), 'add_empty' => true)),
      'code'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'count_voucher_codes'   => new sfWidgetFormFilterInput(),
      'country_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => true)),
      'created_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'updated_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UpdatedByUser'), 'add_empty' => true)),
      'ad_service_company_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AdServiceCompany'), 'add_empty' => true)),
      'benefit_choice'        => new sfWidgetFormFilterInput(),
      'new_price'             => new sfWidgetFormFilterInput(),
      'old_price'             => new sfWidgetFormFilterInput(),
      'discount_pct'          => new sfWidgetFormFilterInput(),
      'benefit_text'          => new sfWidgetFormFilterInput(),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'company_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Company'), 'column' => 'id')),
      'is_active'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_draft'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'active_from'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'active_to'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'valid_from'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'valid_to'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'max_vouchers'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'max_per_user'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'show_to_all'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'image_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Image'), 'column' => 'id')),
      'code'                  => new sfValidatorPass(array('required' => false)),
      'count_voucher_codes'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'country_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Country'), 'column' => 'id')),
      'created_by'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserProfile'), 'column' => 'id')),
      'updated_by'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UpdatedByUser'), 'column' => 'id')),
      'ad_service_company_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('AdServiceCompany'), 'column' => 'id')),
      'benefit_choice'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'new_price'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'old_price'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'discount_pct'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'benefit_text'          => new sfValidatorPass(array('required' => false)),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('company_offer_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompanyOffer';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'company_id'            => 'ForeignKey',
      'is_active'             => 'Boolean',
      'is_draft'              => 'Boolean',
      'active_from'           => 'Date',
      'active_to'             => 'Date',
      'valid_from'            => 'Date',
      'valid_to'              => 'Date',
      'max_vouchers'          => 'Number',
      'max_per_user'          => 'Number',
      'show_to_all'           => 'Boolean',
      'image_id'              => 'ForeignKey',
      'code'                  => 'Text',
      'count_voucher_codes'   => 'Number',
      'country_id'            => 'ForeignKey',
      'created_by'            => 'ForeignKey',
      'updated_by'            => 'ForeignKey',
      'ad_service_company_id' => 'ForeignKey',
      'benefit_choice'        => 'Number',
      'new_price'             => 'Number',
      'old_price'             => 'Number',
      'discount_pct'          => 'Number',
      'benefit_text'          => 'Text',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
    );
  }
}
