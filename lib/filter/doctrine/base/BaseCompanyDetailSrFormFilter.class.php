<?php

/**
 * CompanyDetailSr filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCompanyDetailSrFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'company_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => true)),
      'internal_id'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'full_company_name' => new sfWidgetFormFilterInput(),
      'sr_url'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'company_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Company'), 'column' => 'id')),
      'internal_id'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'full_company_name' => new sfValidatorPass(array('required' => false)),
      'sr_url'            => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('company_detail_sr_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompanyDetailSr';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'company_id'        => 'ForeignKey',
      'internal_id'       => 'Number',
      'full_company_name' => 'Text',
      'sr_url'            => 'Text',
    );
  }
}
