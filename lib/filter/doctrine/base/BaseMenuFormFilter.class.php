<?php

/**
 * Menu filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMenuFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'company_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => true)),
      'filename'   => new sfWidgetFormFilterInput(),
      'name'       => new sfWidgetFormChoice(array('choices' => array('' => '', 'Menu' => 'Menu', 'Prices' => 'Prices', 'Catalogue' => 'Catalogue', 'Products' => 'Products', 'Services' => 'Services'))),
    ));

    $this->setValidators(array(
      'company_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Company'), 'column' => 'id')),
      'filename'   => new sfValidatorPass(array('required' => false)),
      'name'       => new sfValidatorChoice(array('required' => false, 'choices' => array('Menu' => 'Menu', 'Prices' => 'Prices', 'Catalogue' => 'Catalogue', 'Products' => 'Products', 'Services' => 'Services'))),
    ));

    $this->widgetSchema->setNameFormat('menu_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Menu';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'company_id' => 'ForeignKey',
      'filename'   => 'Text',
      'name'       => 'Enum',
    );
  }
}
