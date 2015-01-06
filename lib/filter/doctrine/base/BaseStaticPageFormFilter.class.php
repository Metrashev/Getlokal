<?php

/**
 * StaticPage filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseStaticPageFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'status'     => new sfWidgetFormChoice(array('choices' => array('' => '', 'approved' => 'approved', 'pending' => 'pending', 'rejected' => 'rejected'))),
      'country_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => true)),
      'root_id'    => new sfWidgetFormFilterInput(),
      'lft'        => new sfWidgetFormFilterInput(),
      'rgt'        => new sfWidgetFormFilterInput(),
      'level'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'status'     => new sfValidatorChoice(array('required' => false, 'choices' => array('approved' => 'approved', 'pending' => 'pending', 'rejected' => 'rejected'))),
      'country_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Country'), 'column' => 'id')),
      'root_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lft'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rgt'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'level'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('static_page_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StaticPage';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'status'     => 'Enum',
      'country_id' => 'ForeignKey',
      'root_id'    => 'Number',
      'lft'        => 'Number',
      'rgt'        => 'Number',
      'level'      => 'Number',
    );
  }
}
