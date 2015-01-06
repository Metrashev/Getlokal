<?php

/**
 * CompanyDetailSr form base class.
 *
 * @method CompanyDetailSr getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCompanyDetailSrForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'company_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => false)),
      'internal_id'       => new sfWidgetFormInputText(),
      'full_company_name' => new sfWidgetFormInputText(),
      'sr_url'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'company_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Company'))),
      'internal_id'       => new sfValidatorInteger(),
      'full_company_name' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'sr_url'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('company_detail_sr[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompanyDetailSr';
  }

}
