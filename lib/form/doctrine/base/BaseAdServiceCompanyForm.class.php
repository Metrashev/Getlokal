<?php

/**
 * AdServiceCompany form base class.
 *
 * @method AdServiceCompany getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAdServiceCompanyForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'ad_service_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AdService'), 'add_empty' => false)),
      'company_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => false)),
      'status'          => new sfWidgetFormChoice(array('choices' => array('registered' => 'registered', 'paid' => 'paid', 'active' => 'active', 'cancelled' => 'cancelled', 'expired' => 'expired'))),
      'crm_id'          => new sfWidgetFormInputText(),
      'active_from'     => new sfWidgetFormDate(),
      'active_to'       => new sfWidgetFormDate(),
      'deal_start_date' => new sfWidgetFormDate(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'ad_service_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AdService'))),
      'company_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Company'))),
      'status'          => new sfValidatorChoice(array('choices' => array(0 => 'registered', 1 => 'paid', 2 => 'active', 3 => 'cancelled', 4 => 'expired'), 'required' => false)),
      'crm_id'          => new sfValidatorInteger(array('required' => false)),
      'active_from'     => new sfValidatorDate(array('required' => false)),
      'active_to'       => new sfValidatorDate(array('required' => false)),
      'deal_start_date' => new sfValidatorDate(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('ad_service_company[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AdServiceCompany';
  }

}
