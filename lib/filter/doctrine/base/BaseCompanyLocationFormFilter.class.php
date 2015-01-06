<?php

/**
 * CompanyLocation filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCompanyLocationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'company_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => true)),
      'accuracy'        => new sfWidgetFormFilterInput(),
      'is_active'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'user_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'location_type'   => new sfWidgetFormFilterInput(),
      'street_type_id'  => new sfWidgetFormFilterInput(),
      'street_number'   => new sfWidgetFormFilterInput(),
      'street'          => new sfWidgetFormFilterInput(),
      'neighbourhood'   => new sfWidgetFormFilterInput(),
      'building_no'     => new sfWidgetFormFilterInput(),
      'entrance'        => new sfWidgetFormFilterInput(),
      'floor'           => new sfWidgetFormFilterInput(),
      'appartment'      => new sfWidgetFormFilterInput(),
      'postcode'        => new sfWidgetFormFilterInput(),
      'full_address'    => new sfWidgetFormFilterInput(),
      'full_address_en' => new sfWidgetFormFilterInput(),
      'address_info'    => new sfWidgetFormFilterInput(),
      'address_info_en' => new sfWidgetFormFilterInput(),
      'zoom'            => new sfWidgetFormFilterInput(),
      'sublocation'     => new sfWidgetFormFilterInput(),
      'geocode'         => new sfWidgetFormFilterInput(),
      'processed'       => new sfWidgetFormFilterInput(),
      'latitude'        => new sfWidgetFormFilterInput(),
      'longitude'       => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'company_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Company'), 'column' => 'id')),
      'accuracy'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_active'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'user_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserProfile'), 'column' => 'id')),
      'location_type'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'street_type_id'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'street_number'   => new sfValidatorPass(array('required' => false)),
      'street'          => new sfValidatorPass(array('required' => false)),
      'neighbourhood'   => new sfValidatorPass(array('required' => false)),
      'building_no'     => new sfValidatorPass(array('required' => false)),
      'entrance'        => new sfValidatorPass(array('required' => false)),
      'floor'           => new sfValidatorPass(array('required' => false)),
      'appartment'      => new sfValidatorPass(array('required' => false)),
      'postcode'        => new sfValidatorPass(array('required' => false)),
      'full_address'    => new sfValidatorPass(array('required' => false)),
      'full_address_en' => new sfValidatorPass(array('required' => false)),
      'address_info'    => new sfValidatorPass(array('required' => false)),
      'address_info_en' => new sfValidatorPass(array('required' => false)),
      'zoom'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sublocation'     => new sfValidatorPass(array('required' => false)),
      'geocode'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'processed'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'latitude'        => new sfValidatorPass(array('required' => false)),
      'longitude'       => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('company_location_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompanyLocation';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'company_id'      => 'ForeignKey',
      'accuracy'        => 'Number',
      'is_active'       => 'Boolean',
      'user_id'         => 'ForeignKey',
      'location_type'   => 'Number',
      'street_type_id'  => 'Number',
      'street_number'   => 'Text',
      'street'          => 'Text',
      'neighbourhood'   => 'Text',
      'building_no'     => 'Text',
      'entrance'        => 'Text',
      'floor'           => 'Text',
      'appartment'      => 'Text',
      'postcode'        => 'Text',
      'full_address'    => 'Text',
      'full_address_en' => 'Text',
      'address_info'    => 'Text',
      'address_info_en' => 'Text',
      'zoom'            => 'Number',
      'sublocation'     => 'Text',
      'geocode'         => 'Number',
      'processed'       => 'Number',
      'latitude'        => 'Text',
      'longitude'       => 'Text',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
    );
  }
}
