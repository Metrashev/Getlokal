<?php

/**
 * CompanyFeatureCompany form base class.
 *
 * @method CompanyFeatureCompany getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCompanyFeatureCompanyForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'feature_id' => new sfWidgetFormInputHidden(),
      'company_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'feature_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('feature_id')), 'empty_value' => $this->getObject()->get('feature_id'), 'required' => false)),
      'company_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('company_id')), 'empty_value' => $this->getObject()->get('company_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('company_feature_company[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompanyFeatureCompany';
  }

}
