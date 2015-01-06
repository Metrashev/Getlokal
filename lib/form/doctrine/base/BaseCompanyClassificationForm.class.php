<?php

/**
 * CompanyClassification form base class.
 *
 * @method CompanyClassification getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCompanyClassificationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'classification_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Classification'), 'add_empty' => true)),
      'company_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'classification_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Classification'), 'required' => false)),
      'company_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('company_classification[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompanyClassification';
  }

}
