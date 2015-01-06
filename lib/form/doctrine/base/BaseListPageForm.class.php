<?php

/**
 * ListPage form base class.
 *
 * @method ListPage getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseListPageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'list_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Lists'), 'add_empty' => true)),
      'page_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CompanyPage'), 'add_empty' => true)),
      'user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'status'  => new sfWidgetFormChoice(array('choices' => array('approved' => 'approved', 'pending' => 'pending', 'rejected' => 'rejected'))),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'list_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Lists'), 'required' => false)),
      'page_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CompanyPage'), 'required' => false)),
      'user_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'required' => false)),
      'status'  => new sfValidatorChoice(array('choices' => array(0 => 'approved', 1 => 'pending', 2 => 'rejected'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('list_page[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListPage';
  }

}
