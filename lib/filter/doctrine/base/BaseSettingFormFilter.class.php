<?php

/**
 * Setting filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSettingFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'k'   => new sfWidgetFormFilterInput(),
      'val' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'k'   => new sfValidatorPass(array('required' => false)),
      'val' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('setting_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Setting';
  }

  public function getFields()
  {
    return array(
      'id'  => 'Number',
      'k'   => 'Text',
      'val' => 'Text',
    );
  }
}
