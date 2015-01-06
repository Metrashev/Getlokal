<?php

/**
 * CompanyLocation form base class.
 *
 * @method CompanyLocation getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCompanyLocationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'company_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => true)),
      'accuracy'        => new sfWidgetFormInputText(),
      'is_active'       => new sfWidgetFormInputCheckbox(),
      'user_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'location_type'   => new sfWidgetFormInputText(),
      'street_type_id'  => new sfWidgetFormInputText(),
      'street_number'   => new sfWidgetFormInputText(),
      'street'          => new sfWidgetFormInputText(),
      'neighbourhood'   => new sfWidgetFormInputText(),
      'building_no'     => new sfWidgetFormInputText(),
      'entrance'        => new sfWidgetFormInputText(),
      'floor'           => new sfWidgetFormInputText(),
      'appartment'      => new sfWidgetFormInputText(),
      'postcode'        => new sfWidgetFormInputText(),
      'full_address'    => new sfWidgetFormInputText(),
      'full_address_en' => new sfWidgetFormInputText(),
      'address_info'    => new sfWidgetFormInputText(),
      'address_info_en' => new sfWidgetFormInputText(),
      'zoom'            => new sfWidgetFormInputText(),
      'sublocation'     => new sfWidgetFormInputText(),
      'geocode'         => new sfWidgetFormInputText(),
      'processed'       => new sfWidgetFormInputText(),
      'latitude'        => new sfWidgetFormInputText(),
      'longitude'       => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'company_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'required' => false)),
      'accuracy'        => new sfValidatorInteger(array('required' => false)),
      'is_active'       => new sfValidatorBoolean(array('required' => false)),
      'user_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'required' => false)),
      'location_type'   => new sfValidatorInteger(array('required' => false)),
      'street_type_id'  => new sfValidatorInteger(array('required' => false)),
      'street_number'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'street'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'neighbourhood'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'building_no'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'entrance'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'floor'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'appartment'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'postcode'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'full_address'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'full_address_en' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'address_info'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'address_info_en' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'zoom'            => new sfValidatorInteger(array('required' => false)),
      'sublocation'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'geocode'         => new sfValidatorInteger(array('required' => false)),
      'processed'       => new sfValidatorInteger(array('required' => false)),
      'latitude'        => new sfValidatorPass(array('required' => false)),
      'longitude'       => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('company_location[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompanyLocation';
  }

}
