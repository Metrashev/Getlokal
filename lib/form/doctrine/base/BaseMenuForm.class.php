<?php

/**
 * Menu form base class.
 *
 * @method Menu getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMenuForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'company_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => true)),
      'filename'   => new sfWidgetFormInputText(),
      'name'       => new sfWidgetFormChoice(array('choices' => array('Menu' => 'Menu', 'Prices' => 'Prices', 'Catalogue' => 'Catalogue', 'Products' => 'Products', 'Services' => 'Services'))),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'company_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'required' => false)),
      'filename'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'name'       => new sfValidatorChoice(array('choices' => array(0 => 'Menu', 1 => 'Prices', 2 => 'Catalogue', 3 => 'Products', 4 => 'Services'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('menu[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Menu';
  }

}
