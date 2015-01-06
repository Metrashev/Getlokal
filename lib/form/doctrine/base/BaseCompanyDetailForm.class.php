<?php

/**
 * CompanyDetail form base class.
 *
 * @method CompanyDetail getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCompanyDetailForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'company_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => false)),
      'mon_from'         => new sfWidgetFormInputText(),
      'mon_to'           => new sfWidgetFormInputText(),
      'tue_from'         => new sfWidgetFormInputText(),
      'tue_to'           => new sfWidgetFormInputText(),
      'wed_from'         => new sfWidgetFormInputText(),
      'wed_to'           => new sfWidgetFormInputText(),
      'thu_from'         => new sfWidgetFormInputText(),
      'thu_to'           => new sfWidgetFormInputText(),
      'fri_from'         => new sfWidgetFormInputText(),
      'fri_to'           => new sfWidgetFormInputText(),
      'sat_from'         => new sfWidgetFormInputText(),
      'sat_to'           => new sfWidgetFormInputText(),
      'sun_from'         => new sfWidgetFormInputText(),
      'sun_to'           => new sfWidgetFormInputText(),
      'content'          => new sfWidgetFormTextarea(),
      'content_en'       => new sfWidgetFormTextarea(),
      'confirmed'        => new sfWidgetFormInputCheckbox(),
      'last_modified_by' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'outdoor_seats'    => new sfWidgetFormInputText(),
      'indoor_seats'     => new sfWidgetFormInputText(),
      'wifi_access'      => new sfWidgetFormInputCheckbox(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'company_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Company'))),
      'mon_from'         => new sfValidatorInteger(array('required' => false)),
      'mon_to'           => new sfValidatorInteger(array('required' => false)),
      'tue_from'         => new sfValidatorInteger(array('required' => false)),
      'tue_to'           => new sfValidatorInteger(array('required' => false)),
      'wed_from'         => new sfValidatorInteger(array('required' => false)),
      'wed_to'           => new sfValidatorInteger(array('required' => false)),
      'thu_from'         => new sfValidatorInteger(array('required' => false)),
      'thu_to'           => new sfValidatorInteger(array('required' => false)),
      'fri_from'         => new sfValidatorInteger(array('required' => false)),
      'fri_to'           => new sfValidatorInteger(array('required' => false)),
      'sat_from'         => new sfValidatorInteger(array('required' => false)),
      'sat_to'           => new sfValidatorInteger(array('required' => false)),
      'sun_from'         => new sfValidatorInteger(array('required' => false)),
      'sun_to'           => new sfValidatorInteger(array('required' => false)),
      'content'          => new sfValidatorString(array('required' => false)),
      'content_en'       => new sfValidatorString(array('required' => false)),
      'confirmed'        => new sfValidatorBoolean(array('required' => false)),
      'last_modified_by' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'required' => false)),
      'outdoor_seats'    => new sfValidatorInteger(array('required' => false)),
      'indoor_seats'     => new sfValidatorInteger(array('required' => false)),
      'wifi_access'      => new sfValidatorBoolean(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('company_detail[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompanyDetail';
  }

}
