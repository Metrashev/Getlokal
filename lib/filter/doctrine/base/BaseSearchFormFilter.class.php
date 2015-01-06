<?php

/**
 * Search filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSearchFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'      => new sfWidgetFormFilterInput(),
      'body'       => new sfWidgetFormFilterInput(),
      'keywords'   => new sfWidgetFormFilterInput(),
      'object_id'  => new sfWidgetFormFilterInput(),
      'culture'    => new sfWidgetFormFilterInput(),
      'model_name' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'title'      => new sfValidatorPass(array('required' => false)),
      'body'       => new sfValidatorPass(array('required' => false)),
      'keywords'   => new sfValidatorPass(array('required' => false)),
      'object_id'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'culture'    => new sfValidatorPass(array('required' => false)),
      'model_name' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('search_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Search';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'title'      => 'Text',
      'body'       => 'Text',
      'keywords'   => 'Text',
      'object_id'  => 'Number',
      'culture'    => 'Text',
      'model_name' => 'Text',
    );
  }
}
